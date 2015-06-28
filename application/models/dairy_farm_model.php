<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Dairy_farm_model extends CI_Model {
		private $user_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			$this->user_id = $this->session->userdata('user_id');
			$this->load->model('create_buildings_model');
			$this->load->model('Restaurant_model');
		}
		/*--------------------------------------------------------------------------- 
								# LOADS DAIRY FARM BUILDING VIEW #
		---------------------------------------------------------------------------*/
		public function load_build_dairy_farm() {
			$area_id 		= $this->input->post('area_id');
			$zone_id	 	= $this->input->post('zone_id');
			/* 
			- CHECK IF THE USER user_id IS OWNER OF THE AREA WITH ID area_id  
			- CHECK IF IS BUILD ON THIS AREA
			*/
			if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
				/* GETS expenses and profits on the area */
				$sum_expenses = $this->Restaurant_model->money_spent_on_area($area_id);
				$sum_profits = $this->Restaurant_model->profits_on_area($area_id);		
				/* NUMBER FROMATING */
				$expenses = number_format($sum_expenses, 0, '.', ' ');
				$profits = number_format($sum_profits, 0, '.', ' ');
				$pechalba = number_format($sum_profits-$sum_expenses, 0, '.', ' ');
				/*
				| CHECKS IF THERE IS BUILDED RESTAURANT ON THIS AREA 
				*/
				$this->db->select('*');
				$this->db->from('farming_dairy_farm');
				$this->db->join('area_owners', 'area_owners.ao_area_id=farming_dairy_farm.df_area_id');
				$this->db->join('accounts', 'accounts.user_id=area_owners.ao_owner_id');
				$this->db->where('farming_dairy_farm.df_area_id', $area_id);
				$q_ba = $this->db->get();
				
				if($q_ba->num_rows() > 0) { // If there is, do smth
					$row_ao = $q_ba->row_array();
					$row_ao['money_spent'] = $expenses;
					$row_ao['money_earned'] = $profits;
					$row_ao['pechalba'] = $pechalba;
					$row_ao['is_build'] = 1;
					$row_ao['animal_education'] = 1;
					
					return $row_ao;
				} else {
					$this->db->select('*');
					$this->db->from('area_owners');
					$this->db->where('ao_area_id', $area_id);
					$q_ao = $this->db->get();
					$row_ao = $q_ao->row_array();	
					/*------------------------------------- 
					CHECKS IF THE AREA HAS A LICENSE TO BUILD 
					-----------------------------------------*/
					$this->db->select('*');
					$this->db->from('building_allow_build');
					$this->db->where('ballow_area_id', $area_id);
					$q_bab = $this->db->get();
					if($q_bab->num_rows() >= 1) {
						$row_ao['license_to_build'] = 1;
					} else {
						$row_ao['license_to_build'] = 0;
					}
					/*--------------------------------------------------
					CHECKS IF THE USER HAS EDUCATION TO BUILD DAIRY FARM
					---------------------------------------------------*/
					$this->db->select("*");
					$this->db->from("education");
					$this->db->where("edu_user_id = $this->user_id AND edu_spec_id = 2");
					$q_get_education = $this->db->get();
					if($q_get_education->num_rows() > 0) {
						$row_ao['animal_education'] = 1;
					} else {
						$row_ao['animal_education'] = 0;
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
		/**** END OF LOAD BUILDING DAIRY FARM ****/
		/*--------------------------------------------------------------------------- 
							# BUILDING DAIRY FARM #
		---------------------------------------------------------------------------*/
		public function build_the_dairy_farm() {
			$area_id = $this->input->post('area_id');
			$space = $this->input->post('space');
			$val	 = $this->input->post('val');
			
			if($val == 1) {
				/*--------------------------------------------------
						@-- CALCULATIONS FOR SPACE TO BUILD --@
				---------------------------------------------------*/
				$money = $space*100;
				
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
					if($this->create_buildings_model->us_con('uc_energy')<15) {
						return 'no_enough_energy';
					} else if($this->create_buildings_model->us_con('uc_money')<$money) {
						return 'no_enough_money';
					} else {
						$data = array(
							'df_user_id'		=> $this->user_id,
							'df_area_id'		=> $area_id,
							'df_space_builded'	=> $space,
							'df_cows'			=> 0,
							'df_ip_builded'		=> $_SERVER['REMOTE_ADDR']
						);
						$this->db->insert('farming_dairy_farm', $data);
						/*--- UPDATES AREA category building to be equal to 9 ---*/
						$this->db->where('area_id', $area_id);
						$this->db->update('areas', array('area_cat_building' => 9));
						/*--- UPDATES USER'S CONDTIONS ---*/
						$new_power = $this->create_buildings_model->us_con('uc_power') + 30;
						$this->create_buildings_model->user_conditions_money_rest($new_power, $money, 15, 15, 0, 5.5);
						$this->create_buildings_model->insert_users_action('dairy_farm_builded', "Построени $space кв.м. сграда за крави", $money, 5);
						$this->create_buildings_model->spent_money($area_id, $money, 'dairy_farm_builded', "Построени $space кв.м. сграда за крави");
						return 'dairy_farm_builded';
					}
				}
			} else {
				exit();
			}
		}
		/**** END OF build_the_dairy_farm() ****/
		/*--------------------------------------------------------------------------- 
						# GETS MAIN INFO FOR DAIRY FARM #
		---------------------------------------------------------------------------*/
		public function get_dairy_farm_info() {
			$area_id = $this->input->post('area_id');
			$zone_id = $this->input->post('zone_id');
			
			if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
				/*-------------------------- 
					EXPENSES AND PROFITS 
				----------------------------*/
				
				/* GETS expenses and profits on the area */
				$sum_expenses = $this->Restaurant_model->money_spent_on_area($area_id);
				$sum_profits = $this->Restaurant_model->profits_on_area($area_id);		
				/* NUMBER FROMATING */
				$expenses = number_format($sum_expenses, 0, '.', ' ');
				$profits = number_format($sum_profits, 0, '.', ' ');
				$pechalba = number_format($sum_profits-$sum_expenses, 0, '.', ' ');
				
				/*************************** 
				END OF  profits and expenses
				***************************/
				
				/*-- SQLq --*/
				$this->db->select("*");
				$this->db->from('farming_dairy_farm');
				$this->db->join('area_owners', 'area_owners.ao_area_id=farming_dairy_farm.df_area_id');
				$this->db->where("df_user_id = $this->user_id AND df_area_id = $area_id");
				
				$q_get_df = $this->db->get();
				$row_df = $q_get_df->row_array();
				/** END OF SQLq **/
				
				/*--- MILK PRODUCTION ---*/
				$row_df['is_finished'] = 0;
				$row_df['dfd_milk_producing'] = 0;
				$q_milk_production = $this->db->get_where('farming_df_milk', array('dfd_milk_user_id' => $this->user_id, 'dfd_milk_area_id' => $area_id));
				if($q_milk_production->num_rows() >= 1) {
					$now 			= date(time()); 
					$row_milk = $q_milk_production->row_array();
					if($now > $row_milk['dfd_milk_date_end']) { // has finished
						$row_df['milk_production'] = 0;
						if($row_milk['dfd_milk_producing'] == 1) {
							$row_df['is_finished'] = 1;
							$row_df['dfd_milk_producing'] = 1;
						}
					} else {
						$row_df['milk_production'] 	= 1;
						$row_df['milk_prod_finish'] = date( "H:i:s", $row_milk['dfd_milk_date_end']);
					}
				} else {
					$row_df['milk_production'] = 0;
				}
				/*--- END OF MILK PRODUCTON ---*/
			
				/*---------------------------------------------------------------------- 
					CALCULATING THE CAPACITY OF HOW MANY COWS CAN LIVE IN THE DAIRY FARM 
				----------------------------------------------------------------------*/
				$row_df['cow_capacity'] = round($row_df['df_space_builded']/15);
				
				$row_df['money_spent'] = $expenses;
				$row_df['money_earned'] = $profits;
				$row_df['pechalba'] = $pechalba;
				
				return $row_df;
			} else {
				exit();
			}
		}
		/**** END OF get_dairy_farm_info() ****/
		/*--------------------------------------------------------------------------- 
						# BUILDING MORE SPACE BIGGER BUIDLING #
		---------------------------------------------------------------------------*/
		public function build_more_df() {
			$area_id = $this->input->post('area_id');
			$space = $this->input->post('space');
			$val	 = $this->input->post('val');
			
			if($val == 1) {
				/*--------------------------------------------------
						@-- CALCULATIONS FOR SPACE TO BUILD --@
				---------------------------------------------------*/
				$money = $space*100;
				
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
					if($this->create_buildings_model->us_con('uc_energy')<15) {
						return 'no_enough_energy';
					} else if($this->create_buildings_model->us_con('uc_money')<$money) {
						return 'no_enough_money';
					} else {
						/*--- UPDATES farming_dairy_farm, df_space_builded to be equal + space ---*/
						$this->db->where("df_user_id = $this->user_id AND df_area_id = $area_id");
						$this->db->set('df_space_builded', "df_space_builded+$space", FALSE);
						$this->db->update('farming_dairy_farm');
						/*--- UPDATES USER'S CONDTIONS ---*/
						$new_power = $this->create_buildings_model->us_con('uc_power') + 15;
						$this->create_buildings_model->user_conditions_money_rest($new_power, $money, 15, 15, 0, 2.5);
						$this->create_buildings_model->insert_users_action('dairy_farm_builded', "Построени още $space кв.м. сграда за крави", $money, 5);
						$this->create_buildings_model->spent_money($area_id, $money, 'dairy_farm_builded', "Построени още $space кв.м. сграда за крави");
						return 'dairy_farm_updated';
					}
				}
			} else {
				exit();
			}
		}
		/**** ****/
		/*--------------------------------------------------------------------------- 
										# BUYING COWS#
		---------------------------------------------------------------------------*/
		public function buying_cows() {
			$area_id = $this->input->post('area_id');
			$cows	 = $this->input->post('cows');
			$val	 = $this->input->post('val');
			
			if($val == 1) {
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
					/*------------------------ 
						CHECKS THE CAPACITY 
					--------------------------*/
					$q_cap = $this->db->get_where('farming_dairy_farm', array('df_user_id' => $this->user_id, 'df_area_id' => $area_id))->row_array();
					$capacity = round($q_cap['df_space_builded']/15);
					$new_capcity = $q_cap['df_cows']+$cows;
					//echo "$new_capcity and $capacity";
					/*-------------------------------
					CALCULATES THE MONEY NEEDED FOR THE COWS
					---------------------------------*/
					$need_money = $cows*1200; // one cow costs 1200
					
					if($new_capcity > $capacity) {
						return 'no_enough_capacity';
					} else if($this->create_buildings_model->us_con('uc_money')<$need_money) {
						return 'no_enough_money';
					} else if($this->create_buildings_model->us_con('uc_energy')<15) {
						return 'no_enough_energy';
					} else {
						/*-- UPDATES df_cows + COWS --*/
						$this->db->where("df_user_id = $this->user_id AND df_area_id = $area_id");
						$this->db->set('df_cows', "df_cows+$cows", FALSE);
						$this->db->update('farming_dairy_farm');
						/*--- UPDATES USER'S CONDTIONS ---*/
						$new_power = $this->create_buildings_model->us_con('uc_power') + 15;
						$this->create_buildings_model->user_conditions_money_rest($new_power, $need_money, 15, 15, 0, 2.5);
						$this->create_buildings_model->insert_users_action('cows_bought', "Купени $cows крави", $need_money, 5);
						$this->create_buildings_model->spent_money($area_id, $need_money, 'cows_bought', "Купени $cows крави");
						return 'cow_bought';
					}
				} else {
					exit();
				}
			} else {
				redirect(base_url());
			}
		}
		/*** END OF buying cows ***/
		/*--------------------------------------------------------------------------- 
								# MILK PRODUCTION #
		---------------------------------------------------------------------------*/
		public function milk_production() {
			$area_id = $this->input->post('area_id');
			$val = $this->input->post('val');
			
			if($val == 1) {
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
					/* TIME VARS AND CALCULATIONS */
					$now 			= date(time()); // TIMESTAMP NOW TIME
					$finish_time 	= strtotime('+6 hours', $now); // TIME AFTER 6 HOURS
					/*--------------------------------------------------------------------------
						CHEKS IF THERE IS ALREADY ROW WITH THIS AREA ID TO PRODUCE MILK
					---------------------------------------------------------------------------*/
					$q_milk_production = $this->db->get_where('farming_df_milk', array('dfd_milk_user_id' => $this->user_id, 'dfd_milk_area_id' => $area_id));
					
					if($q_milk_production->num_rows() >= 1) {
						/* UPDATE */
						$upd_arr = array(
							'dfd_milk_date_started' => $now,
							'dfd_milk_date_end' 	=> $finish_time,
							'dfd_milk_producing'	=> 1,
							'dfd_ip' 				=> $_SERVER['REMOTE_ADDR']
						);
						$this->db->where("dfd_milk_user_id = $this->user_id AND dfd_milk_area_id = $area_id");
						$this->db->update('farming_df_milk', $upd_arr);
					} else {
						/* INSERT */
						$insert_array = array(
							'dfd_milk_user_id' 		=> $this->user_id,
							'dfd_milk_area_id' 		=> $area_id,
							'dfd_milk_date_started' => $now,
							'dfd_milk_date_end' 	=> $finish_time,
							'dfd_milk_producing' 	=> 1,
							'dfd_ip' 				=> $_SERVER['REMOTE_ADDR']
						);
						$this->db->insert('farming_df_milk', $insert_array);
					}
				} else {
					exit();
				}
			} else {
				redirect(base_url());
			}
		}
		/*** END OF MILK PRODUCTION ***/
		/*--------------------------------------------------------------------------- 
								# COLLECTS MILK PRODUCTION #
		---------------------------------------------------------------------------*/
		public function collect_milk_production() {
			$area_id = $this->input->post('area_id');
			$val = $this->input->post('val');
			
			if($val == 1) {
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
					$this->db->select("*");
					$this->db->from('farming_dairy_farm');
					$this->db->where("df_user_id = $this->user_id AND df_area_id = $area_id");
					$q = $this->db->get();
					$q_row = $q->row_array();
					
					$litres = $q_row['df_cows']*240;
					/*--- UPDATES FARMING LITRES ---*/
					$this->db->where("df_user_id = $this->user_id AND df_area_id = $area_id");
					$this->db->set('df_litres_milk', "df_litres_milk+$litres", FALSE);
					$this->db->update('farming_dairy_farm');
					/*--- UPDATES DAIRY FARM MILK PRODUCTION TO 0 --- */
					$this->db->where("dfd_milk_user_id = $this->user_id AND dfd_milk_area_id = $area_id");
					$this->db->update('farming_df_milk', array('dfd_milk_producing' => 0));
				} else {
					exit();
				}
			} else {
				exit();
			}
		}
		/*** END OF collecting_milk ***/
		/*--------------------------------------------------------------------------- 
								# SELL MILK PRODUCTION #
		---------------------------------------------------------------------------*/
		public function sell_milk_production() {
			$area_id = $this->input->post('area_id');
			$val = $this->input->post('val');
			
			if($val == 1) {
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
					$this->db->select("*");
					$this->db->from('farming_dairy_farm');
					$this->db->where("df_user_id = $this->user_id AND df_area_id = $area_id");
					$q = $this->db->get();
					$q_row = $q->row_array();
					
					if($q_row['df_litres_milk']==0) {
						return 'zero_milk';
					} else {
						$money = $q_row['df_litres_milk']*0.5;
						/*--- UPDATE STORAGE TO 0 ---*/
						$this->db->where("df_user_id = $this->user_id AND df_area_id = $area_id");
						$this->db->update('farming_dairy_farm', array('df_litres_milk' => 0));
						/*--- UPDATES USER'S CONDTIONS ---*/
						$new_power = $this->create_buildings_model->us_con('uc_power') + 10;
						$this->create_buildings_model->user_conditions_money_rest($new_power, -$money, 0, 0, 0, 5.5);
						$this->create_buildings_model->insert_users_action('milk_sold', "Продадени $q_row[df_litres_milk] литра мляко", $money, 5);
						$this->create_buildings_model->money_earned_on_area($area_id, $this->user_id, $money, 'milk_sold',"Продадени $q_row[df_litres_milk] литра мляко");
						return 'milk_sold';
					}
				} else {
					exit();
				}
			} else {
				exit();
			}
		}
	}