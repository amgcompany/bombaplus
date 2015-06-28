<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Main_model extends CI_Model {
		private $user_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			$this->user_id = $this->session->userdata('user_id');
		}
		/*--- GETS CITY ZONES ---*/
		public function get_zones() {
			$data = array();	
			$q = $this->db->get('city_zones');
			foreach($q->result_array() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		/*** end of get_zones ****/
		/*--- GETS CITY CENTERS AREAS ---*/
		public function get_center_areas_view() {
			$this->load->library('pagination');
			$zone_id = $this->input->post('zone_id');
			$data = array();
			$res = $this->get_it($zone_id);
			foreach($res as $key=>$row) {
				$data[] = $row;
				if($row['area_cat_building'] == '0') { // AREA FOR SALE
					$data[$key]['view'] = 'area_zero_view';
				}
				if($row['area_sold'] == '1') { // IF THE AREA IS SOLD TO LOAD area_sold_view
					$data[$key]['view'] = 'area_sold_view';
				}
				if($row['area_cat_building'] == '1') { // MANSIONS VIEW
					$q_mansions = $this->db->get_where('building_apartments', array('ba_area_id' => $row['area_id']))->row_array();
					$data[$key]['apartment_level'] = $q_mansions['b_apartment_level'];
					$data[$key]['view'] = 'area_mansions_view';
				}
				if($row['area_cat_building'] == '2') { // BANK VIEW
					$q_bank = $this->db->get_where('building_bank', array('b_bank_area_id' => $row['area_id']))->row_array();
					$data[$key]['bank_id']	= $q_bank['b_bank_id'];
					$data[$key]['view'] = 'area_bank_view';
				}
				if($row['area_cat_building'] == '3') { // CASINO VIEW
					$q_casino = $this->db->get_where('building_casino', array('bc_area_id' => $row['area_id']))->row_array();
					$data[$key]['casino_id'] = $q_casino['b_casino_id'];
					$data[$key]['view'] = 'area_casino_view';
				}
				if($row['area_cat_building'] == '5') { // UNIVERSITY VIEW
					$q_uni = $this->db->get_where('universities', array('uni_area_id' => $row['area_id']))->row_array();
					$data[$key]['uni_id'] = $q_uni['university_id'];
					$data[$key]['view'] = 'area_university_view';
				}
				if($row['area_cat_building'] == '7') { // RESTAURANT VIEW
					$q_restaurant = $this->db->get_where('building_restaurants', array('br_area_id' => $row['area_id']))->row_array();					
					$data[$key]['restaurant_id']		= $q_restaurant['restaurant_id'];
					$data[$key]['b_restaurant_level']	= $q_restaurant['b_restaurant_level'];
					$data[$key]['view'] 	= 'area_restaurant_view';
				}
				if($row['area_cat_building'] == '8') { // SHOP VIEW
					$data[$key]['view'] 	= 'area_shop_view';
				}
				if($row['area_cat_building'] == '9') { // COW FARM
					$this->db->select("*");
					$this->db->from("farming_dairy_farm");
					$this->db->join('accounts', 'accounts.user_id = farming_dairy_farm.df_user_id');
					$this->db->where("farming_dairy_farm.df_area_id = $row[area_id]");
					$q_df = $this->db->get()->row_array();
					$data[$key]['cows'] = $q_df['df_cows'];
					$data[$key]['owner'] = $q_df['username'];
					$data[$key]['owner_id'] = $q_df['user_id'];
					$data[$key]['view'] = 'area_cow_view';
				}
				if($row['area_cat_building'] == '10') { // TOMATO FARM
					$this->db->select("*");
					$this->db->from("farming_tomato");
					$this->db->join('accounts', 'accounts.user_id = farming_tomato.tomato_farm_user_id');
					$this->db->where("farming_tomato.tomato_farm_area_id = $row[area_id]");
					$q_df = $this->db->get()->row_array();
					$data[$key]['seeds'] = $q_df['tf_space_seed'];
					$data[$key]['owner'] = $q_df['username'];
					$data[$key]['owner_id'] = $q_df['user_id'];
					$data[$key]['view'] = 'area_tomato_view';
				}
			}
			return $data;
		}
		/*** end of get_areas ****/
		
		/*--- GETS CITY AREAS ---*/
		public function get_it($id) {
			$this->load->library('pagination');
			$paging['base_url'] = base_url().'living_area/index';
			
			$paging['total_rows'] = $this->db->get_where('areas', array('area_zone_id' => $id))->num_rows();
			$paging['per_page'] = 12; //10
			$paging['num_links'] = 10; //10
			
			$this->pagination->initialize($paging);
		
			$data = array();
			$q = $this->db->get_where('areas', array('area_zone_id' => $id), $paging['per_page'], $this->uri->segment(3));
			foreach($q->result_array() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		/*** end of get_areas ****/	
		/*--- BUYS AREA FOR A USER ---*/
		public function buy_area_model() {
			$area_id = $this->input->post('area_id');
			$space = $this->input->post('space');
			$sum = $this->input->post('sum');
			$validator = $this->input->post('validator');
			if($validator != 1) {
				redirect(base_url());
			} else {
				$q_area = $this->db->get_where('areas', array('area_id'=>$area_id, 'area_sold'=>1));
				$q = $this->db->get_where('user_conditions', array('uc_user_id' => $this->session->userdata('user_id')));
				$row = $q->row_array();

				if($q_area->num_rows() >= 1) {
					return 'already_bought_area';
				} else if($sum>$row['uc_money']) { // CHEKS IF THE USER HAS ENOUGH MONEY TO BUY THE AREA
					return 'no_enough_money';
				} else if($row['uc_energy']<3) { 
					return 'no_enough_energy';
				} else { 
					/*
					----------------------------------------------------------------------------
					| gets the money from the user and calculates the power
					----------------------------------------------------------------------------
					*/
					$area_space = $space/100;
					$power_to_add = $area_space*2; // 0.20 because it gives 0.20 power for 100 kv.m
					$new_power = $row['uc_power']+$power_to_add;
					
					$this->user_conditions_money_rest($new_power, $sum, 3, 1, 1, 0);
					/*
					----------------------------------------------------------------------------
					| updates the area_sold row in the DB to 1, so no other user can buy this area
					----------------------------------------------------------------------------
					*/
					$this->db->where('area_id', $area_id);
					$this->db->update('areas', array('area_sold' => '1', 'area_sold_to_id' => $this->user_id)); 
					/* 
					| INSERTS THE area INTO area_owners TABLE FOR USER ID session->user_id
					*/
					$data = array(
						'ao_area_id' => $area_id,
						'ao_owner_id' => $this->user_id,
						'ao_space'	=> $space
					);
					$this->db->insert('area_owners', $data);
					/* 
					| INSERTS DATA ABOUT THE USER's ACTION INTO THE DB
					*/
					$this->insert_users_action('bought_area', "Купени $space кв.м", $sum, 0.2);
					
					/* 
					| INSERTS DATA INTO areas_spent_money WHERE WILL BE ALL SPENT MONEY ON THIS AREAS
					*/
					
					$this->spent_money($area_id, $sum, 'bought_area', "Купени $space кв.м");
					return 'area_bought';
				}
			}
		}
		/**** END of buy_area ****/
		/*--- GETS CENTERS CATEGORIES ---*/
		public function center_buldings_categories() {
			$area_id = $this->input->post('area_id');
			$val	 = $this->input->post('val');
			$zone	 = $this->input->post('zone_id');
			if($val == 1) {
				$this->load->model('create_buildings_model');
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1 && $this->create_buildings_model->is_build_on_area($area_id) == 0) {
					$data = array();
					$q = $this->db->get('category_buildings');
					foreach($q->result_array() as $row) {
						$data[] = $row;
					}
					return $data;
				} else {
					exit();
				}
			} else {
				redirect(base_url());
			}
		}
		/*--- END of center_bulding_categories ---*/
		
		
		
		/*
		------------------------------------------------------------------ 
		# FUNCTION WICH UPDATES USER'S CONDTIONS power, energy, fun and money,
		# Parameter $how_much is about calculating how much money to take from the user
		------------------------------------------------------------------
		*/
		public function user_conditions_money_rest($new_power, $how_much, $energy, $fun, $areas, $tuz) {
			$q = $this->db->get_where('user_conditions', array('uc_user_id' => $this->session->userdata('user_id')));
			$row = $q->row_array();
				
			$rest_money = $row['uc_money']-$how_much;
			$this->db->where('uc_user_id', $this->user_id);
			if($row['uc_energy']>=0){
				$this->db->set('uc_energy', "uc_energy-$energy", FALSE);
			}
			if($row['uc_fun']>=0){
				$fun_to_take = $row['uc_fun'] - $fun;
				if($fun_to_take > 0) {
					$this->db->set('uc_fun', "uc_fun-$fun", FALSE);
				} else {
					$this->db->set('uc_fun', "uc_fun-uc_fun", FALSE);
				}
			}
			$this->db->set('uc_areas', "uc_areas+$areas", FALSE);
			$this->db->set('uc_tuz', "uc_tuz+$tuz", FALSE);
			$this->db->update('user_conditions', array('uc_money' => $rest_money, 'uc_power'=>$new_power)); 
		}
		/************************************************************************ 
			#END OF user_conditions_money_rest() 
		*************************************************************************/
		/*
		------------------------------------------------------------------ 
		# INSERTS INFORMATION ABOUT USER'S ACTIONS
		------------------------------------------------------------------
		*/
		public function insert_users_action($action, $description, $spent_money, $ratio) {
			$data_action = array(
				'ua_user_id' 		=> $this->user_id,
				'ua_action'			=> $action,
				'ua_description'	=> $description,
				'ua_money_spent'	=> $spent_money,
				'ua_ratio_action'	=> $ratio,
				'ua_ip_activity'	=> $_SERVER['REMOTE_ADDR']
			);
			$this->db->insert('users_activity', $data_action);
		}
		/************************************************************************ 
			#END OF insert_users_action() 
		*************************************************************************/
		/*
		------------------------------------------------------------------ 
		# INSERTS INFORMATION SPENT MONEY ON AREA
		------------------------------------------------------------------
		*/
		public function spent_money($area, $spent_money, $action, $description) {
			$data_smoney = array(
				'asm_area_id' 				=> $area,
				'asm_user_id'				=> $this->user_id,
				'asm_money_invest'			=> $spent_money,
				'aspent_money_action'		=> $action,
				'aspent_money_description'	=> $description,
				'asm_ip'					=> $_SERVER['REMOTE_ADDR']
			);
			$this->db->insert('area_spent_money', $data_smoney);
		}
		/************************************************************************ 
			#END OF spent_money() 
		*************************************************************************/

	}