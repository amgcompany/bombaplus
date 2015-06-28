<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Industrial_model extends CI_Model {
		private $user_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			$this->user_id = $this->session->userdata('user_id');
			$this->load->model('create_buildings_model');
		}
		/*--- GETS LIVING AREAS ---*/
		public function get_it($id) {
			$this->load->library('pagination');
			$paging['base_url'] = base_url().'industrial/index';
			
			$paging['total_rows'] = $this->db->get_where('areas', array('area_zone_id' => $id))->num_rows();
			$paging['per_page'] = 12; //12
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
		/*--------------------------------------------------------------------------- 
								# GETS CITY CENTERS AREAS #
		---------------------------------------------------------------------------*/
		public function get_industrial_areas_view() {
			$data = array();
			$res = $this->get_it(3);
			foreach($res as $key=>$row) {
				$data[] = $row;
				if($row['area_cat_building'] == '0') { // AREA FOR SALE
					$data[$key]['view'] = 'area_zero_view';
				}
				if($row['area_sold'] == '1') { // IF THE AREA IS SOLD TO LOAD area_sold_view
					$data[$key]['view'] = 'area_sold_view';
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
		/*--------------------------------------------------------------------------- 
								# BUYS AREA FOR A USER #
		---------------------------------------------------------------------------*/
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
					$area_space = $space*100; // x(*) 100
					$power_to_add = $area_space*2; // 0.20 because it gives 0.20 power for 100 kv.m ($area_space*2;)/100
					$new_power = $row['uc_power']+$power_to_add;
					
					$this->create_buildings_model->user_conditions_money_rest($new_power, $sum, 3, 1, 1, 0);
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
					$this->create_buildings_model->insert_users_action('bought_area', "Купени $space декара", $sum, 0.2);
					
					/* 
					| INSERTS DATA INTO areas_spent_money WHERE WILL BE ALL SPENT MONEY ON THIS AREAS
					*/
					
					$this->create_buildings_model->spent_money($area_id, $sum, 'bought_area', "Купени $space декара");
					return 'area_bought';
				}
			}
		}
		/**** END of buy_area ****/
	}
	