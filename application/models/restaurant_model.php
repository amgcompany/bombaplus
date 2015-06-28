<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Restaurant_model extends CI_Model {
		private $user_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			$this->load->model('create_buildings_model');
			
			$this->user_id = $this->session->userdata('user_id');
		}
		/*
		----------------------------------------------------------------------
							# BUILDING RESTAURANT #
		----------------------------------------------------------------------
		*/
		
		/*--- LOAD BUILD RESTAURANT ---*/
		public function load_build_restaurant($area_id) {
			/* 
			- CHECK IF THE USER user_id IS OWNER OF THE AREA WITH ID area_id  
			- CHECK IF IS BUILD ON THIS AREA
			*/
			if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
				/* GETS expenses and profits on the area */
				$sum_expenses = $this->money_spent_on_area($area_id);
				$sum_profits = $this->profits_on_area($area_id);		
				/* NUMBER FROMATING */
				$expenses = number_format($sum_expenses, 0, '.', ' ');
				$profits = number_format($sum_profits, 0, '.', ' ');
				$pechalba = number_format($sum_profits-$sum_expenses, 0, '.', ' ');
				/*
				| CHECKS IF THERE IS BUILDED RESTAURANT ON THIS AREA 
				*/
				$this->db->select('*');
				$this->db->from('building_restaurants');
				$this->db->join('area_owners', 'area_owners.ao_area_id=building_restaurants.br_area_id');
				$this->db->join('accounts', 'accounts.user_id=area_owners.ao_owner_id');
				$this->db->where('building_restaurants.br_area_id', $area_id);
				$q_ba = $this->db->get();
				
				if($q_ba->num_rows() > 0) { // If there is, do smth
					$row_ao = $q_ba->row_array();
					$row_ao['money_spent'] = $expenses;
					$row_ao['money_earned'] = $profits;
					$row_ao['pechalba'] = $pechalba;
					$row_ao['is_build'] = 1;
					
					/* GETS THE DISHES */
					$q_dishes = $this->db->get_where('build_restaurant_dishes', array('brd_area_id'=>$area_id));
					$dishes = array();
					foreach($q_dishes->result_array() AS $row) {
						$dishes[] = $row;
					}
					$row_ao['dishes'] = $dishes;
					/* END OF GETTING DISHES */
					
					return $row_ao;
				} else {
					$this->db->select('*');
					$this->db->from('area_owners');
					$this->db->where('ao_area_id', $area_id);
					$q_ao = $this->db->get();
					$row_ao = $q_ao->row_array();	
					/* CHECKS IF THE AREA HAS A LICENSE TO BUILD */
					$this->db->select('*');
					$this->db->from('building_allow_build');
					$this->db->where('ballow_area_id', $area_id);
					$q_bab = $this->db->get();
					if($q_bab->num_rows() >= 1) {
						$row_ao['license_to_build'] = 1;
					} else {
						$row_ao['license_to_build'] = 0;
					}
					/* PASSING DATA FOR THE VIEW */
					$row_ao['is_build'] = 0;
					$row_ao['money_spent'] = $expenses;
					$row_ao['money_earned'] = $profits;
					$row_ao['pechalba'] = $pechalba;
					//print_r($row_ao);
					return $row_ao;
				}
			} else {
				exit();
			}
		}
		/**** END of load_build() ****/
		
		/*------------------------------------------------------------------ 
			|BUILDS RESTAURANT
		------------------------------------------------------------------ */
		public function build_restaurant($area_id, $level, $howmuch) {
			if($howmuch>$this->create_buildings_model->us_con('uc_money')) { // CHEKS IF THE USER HAS ENOUGH MONEY TO BUY THE AREA
				return 'no_enough_money';
			} else if($this->create_buildings_model->us_con('uc_energy')<15) { 
				return 'no_enough_energy';
			} else {
				$q_apart = $this->db->get_where('building_restaurants', array('br_area_id' => $area_id));
				$row_apart = $q_apart->row_array();
				// if da proverqva na koi level e i ako veche e postroeno da updatva
				if($q_apart->num_rows() == 0) {  // CHECKS IF THERE IS BUILD RESTAURANT, IF THERE IS NO, THEN INSERTS
					$data = array(
						'br_area_id'	=> $area_id,
						'br_user_id'	=> $this->user_id,
						'b_restaurant_level'	=> 1,
						'br_ip'			=> $_SERVER['REMOTE_ADDR']
					);
					$this->db->insert('building_restaurants',$data);
					
					/* INSERTS DISHES */
					$this->add_dishes($area_id);
					/* UPDATES CATEGORY OF BUIDLING TO 1 SO IT IS A MANSIONS */
					$this->db->where('area_id', $area_id);
					$this->db->update('areas', array('area_cat_building' => 7)); 
					
					/* UPDATES DATA ABOUT USERS'S CONDTIONS AND MONEY SPENT ON AREA */
					$new_power = $this->create_buildings_model->us_con('uc_power')+10;
					$this->create_buildings_model->user_conditions_money_rest($new_power, $howmuch, 15, 10, 0, 20);
					$this->create_buildings_model->insert_users_action('restaurant_build', "Строеж на ресторарант ниво $level", $howmuch, 2);
					$this->create_buildings_model->spent_money($area_id, $howmuch, 'restaurant_build', "Строеж на ресторант ниво $level");
					
					return 'restaurant_build';
				} else if($row_apart['b_restaurant_level'] == 1) { // BUILDING LEVEL TWO
					$data = array(
						'b_restaurant_level'	=> 2,
						'br_ip'	=> $_SERVER['REMOTE_ADDR']
					);
					$this->db->where('br_area_id', $area_id);
					$this->db->update('building_restaurants',$data);

					$new_power = $this->create_buildings_model->us_con('uc_power')+20;
					
					$this->create_buildings_model->user_conditions_money_rest($new_power, $howmuch, 15, 10, 0, 0);
					$this->create_buildings_model->insert_users_action('restaurant_updated', "Построено ниво $level на ресторант", $howmuch, 6);
					$this->create_buildings_model->spent_money($area_id, $howmuch, 'restaurant_updated', "Построено ниво $level на ресторант");
					return 'restaurant_updated';
				}
			}
		}
		/************************************************************************ 
			|END OF build_restaurant() 
		*************************************************************************/
		/*--- DEFINES/UPDATES DISH PRICE ---*/
		public function define_price() {
			$area_id = $this->input->post('area_id');
			$price 	= $this->input->post('price');
			$dish_id = $this->input->post('dish_id');
			$val	 = $this->input->post('val');
			
			if($val == 1) {
				$this->db->select('*');
				$this->db->where("dish_id = '$dish_id' AND brd_area_id='$area_id'");
				$this->db->update('build_restaurant_dishes', array('br_dish_price'=>$price));
				return 'suc_def';
			} else {
				redirect(base_url());
			}
		}
		/**** END OF define_price ****/
		/*********************************************************************
							# END OF BUILDING RESTAURANT #
		**********************************************************************/
		
		/*-------------------------------------------------------------------
							| RESTAURANT VIEW FOR THE USERS |
		--------------------------------------------------------------------*/
		public function enter_restaurant($area_id, $restaurant_id) {
			$this->db->select('*');
			$this->db->from('building_restaurants');
			$this->db->join('area_owners', 'area_owners.ao_area_id=building_restaurants.br_area_id');
			$this->db->join('accounts', 'accounts.user_id=area_owners.ao_owner_id');
			$this->db->where('building_restaurants.br_area_id', $area_id);
			$q_ba = $this->db->get();
				
			if($q_ba->num_rows() > 0) { // If there is, do smth
				$row_ao = $q_ba->row_array();
					
				/* GETS THE DISHES */
				$q_dishes = $this->db->get_where('build_restaurant_dishes', array('brd_area_id'=>$area_id));
				$dishes = array();
				foreach($q_dishes->result_array() AS $row) {
					$dishes[] = $row;
				}
				$row_ao['dishes'] = $dishes;
				/* END OF GETTING DISHES */
				return $row_ao;
			} else {
				exit();
			}
		}
		/*** END of enter_restaurant ***/
		/*--- BUYS DISH ---*/
		public function dish_buy() {
			$area_id = $this->input->post('area_id');
			$dish_id = $this->input->post('dish_id');
			$how	 = $this->input->post('how');
			$val	 = $this->input->post('val');
			if($val == 1) {
				
				/* GETS THE ID OF THE RESTAURANT'S OWNER */
				$row_owner = $this->db->get_where('building_restaurants', array('br_area_id'=>$area_id))->row_array();
				$owner = $row_owner['br_user_id'];
				
				/* GETS THE EATEN DISH */
				$q_get_res = $this->db->get_where('build_restaurant_dishes', array('brd_area_id'=>$area_id, 'dish_id'=>$dish_id));
				$row_dish = $q_get_res->row_array();
				$total_price = $how*$row_dish['br_dish_price'];
				if($this->create_buildings_model->us_con('uc_money')<$total_price) {
					echo 'no_enough_money';
				} else if($row_dish['br_dish_quantity']<$how) {
					echo 'no_enough_quantity';
				} else {
					$total_energy = $how*$row_dish['br_dish_energy'];
					
					$now_energy = $this->create_buildings_model->us_con('uc_energy');
					$new_power = $this->create_buildings_model->us_con('uc_power');
					$this->create_buildings_model->user_conditions_money_rest($new_power, $total_price, -$total_energy, 3, 0, 0.001);
					if($owner != $this->user_id) {
						$this->create_buildings_model->money_earned_on_area($area_id, $owner,	$total_price, 'eaten_dish', "Потребител изяде $how $row_dish[br_dish]");
					}
					/* TAKES $how quantity from the restaurant */
					$this->db->where('dish_id', $dish_id);
					$this->db->set('br_dish_quantity', "br_dish_quantity-$how", FALSE);
					$this->db->update('build_restaurant_dishes');	
					
					/* GIVES THE OWNER THE EARNED MONEY */
						$this->create_buildings_model->give_money($owner, $total_price);
					return 'bought_energy';
				}
			} else {
				exit();
			}
		}
		/*** END of dish_buy ***/
		/*####################################################################
							| SOME FUNCTIONS |
		#####################################################################*/
		/*--- CALCULATES AND GETS THE MONEY SPENT OT AREA ---*/
		public function money_spent_on_area($area_id) {
			$sum_expenses = 0;
			$q_expenses = $this->db->get_where('area_spent_money', array('asm_area_id'=>$area_id));
			foreach($q_expenses->result_array() AS $row_expenses) {
				$sum_expenses += $row_expenses['asm_money_invest'];
			}
			$expenses = number_format($sum_expenses, 0, '.', ' ');
			return $sum_expenses;
		}
		/*** END OF money_spent_on_area ***/
		/*--- CALCULATES THE PFORFITS FROM AREA ---*/
		public function profits_on_area($area_id) {
			$sum_profits = 0;
			$q_profits = $this->db->get_where('area_earn_money', array('aem_area_id'=>$area_id));
			if($q_profits->num_rows() >= 1) {
				foreach($q_profits->result_array() AS $row_profits) {
					$sum_profits += $row_profits['aem_money_earn'];
				}
				$profits = number_format($sum_profits, 0, '.', ' ');
			} else {
				$profits = 0;
				$sum_profits = 0;
			}
			return $sum_profits;
		}
		/*** END of profits_on_area ***/
		/*--- LOADING STOCKS ---*/
		public function loading_stocks() {
			$area_id = $this->input->post('area_id');
			$dish_id = $this->input->post('dish_id');
			$val 	= $this->input->post('val');

			if($val == 1) {
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
					/*-- CHECKS IF THE DISH IS THERE IN THE RESTAURANT --*/
					$q_dish = $this->db->get_where('build_restaurant_dishes', array('brd_area_id' => $area_id, 'dish_id' => $dish_id));
					if($q_dish->num_rows() >= 1) {
						if($this->create_buildings_model->us_con('uc_money')<500) {
							return 'no_enough_money';
						} else {
							//updates dish quantity
							$this->db->where("dish_id = $dish_id AND brd_area_id = $area_id");
							$this->db->set('br_dish_quantity', "br_dish_quantity+100", FALSE);
							$this->db->update('build_restaurant_dishes');
							
							/*-- USERS CONDITIONS --*/
							$new_power = $this->create_buildings_model->us_con('uc_power')+0;
					
							$this->create_buildings_model->user_conditions_money_rest($new_power, 500, 0, 0, 0, 0);
							$this->create_buildings_model->insert_users_action('restaurant_stocks_loaded', "Заредихте стока в ресторанта", 500, 0);
							$this->create_buildings_model->spent_money($area_id, 500, 'restaurant_stocks_loaded', "Заредихте стока в ресторанта");
							
							return "dish_quantity_updated";
						}
					} else {
						exit();
					}
				} else {
					exit();
				}
			} else {
				redirect(base_url());
			}
		}
		/**** END OF LOADING STOCKS ****/
		/*--- ADDING DISHES TO THE RESTAURANT ---*/
		public function add_dishes($area_id) {
			$this->db->insert('build_restaurant_dishes', array(
				'brd_area_id' 		=> $area_id,
				'br_dish'	  		=> 'Салата краставици и домати',
				'br_dish_price'	 	=> 5,
				'br_dish_energy'	=> 10
			));
			$this->db->insert('build_restaurant_dishes', array(
				'brd_area_id' 		=> $area_id,
				'br_dish'	  		=> 'Пилешка супа',
				'br_dish_price'	 	=> 10,
				'br_dish_energy'	=> 15
			));
			$this->db->insert('build_restaurant_dishes', array(
				'brd_area_id' 		=> $area_id,
				'br_dish'	  		=> 'Буца сирене',
				'br_dish_price'	 	=> 25,
				'br_dish_energy'	=> 20
			));
			$this->db->insert('build_restaurant_dishes', array(
				'brd_area_id' 		=> $area_id,
				'br_dish'	  		=> 'Пилешка пържола',
				'br_dish_price'	 	=> 20,
				'br_dish_energy'	=> 30
			));
			$this->db->insert('build_restaurant_dishes', array(
				'brd_area_id' 		=> $area_id,
				'br_dish'	  		=> 'Свинска пържола',
				'br_dish_price'	 	=> 40,
				'br_dish_energy'	=> 55
			));
			$this->db->insert('build_restaurant_dishes', array(
				'brd_area_id' 		=> $area_id,
				'br_dish'	  		=> 'Говежда пържола',
				'br_dish_price'	 	=> 55,
				'br_dish_energy'	=> 75
			));
		}
		/**** END of add dish ****/
	}