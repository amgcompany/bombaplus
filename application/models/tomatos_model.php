<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Tomatos_model extends CI_Model {
		private $user_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			$this->user_id = $this->session->userdata('user_id');
			$this->load->model('create_buildings_model');
			$this->load->model('Restaurant_model');
		}
		/*--------------------------------------------------------------------------- 
								# LOADS BUILDING TOMATOS VIEW #
		---------------------------------------------------------------------------*/
		public function load_build_tomatos() {
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
				$this->db->from('farming_tomato');
				$this->db->join('area_owners', 'area_owners.ao_area_id=farming_tomato.tomato_farm_area_id');
				$this->db->join('accounts', 'accounts.user_id=area_owners.ao_owner_id');
				$this->db->where('farming_tomato.tomato_farm_area_id', $area_id);
				$q_ba = $this->db->get();
				
				if($q_ba->num_rows() > 0) { // If there is, do smth
					$row_ao = $q_ba->row_array();
					$row_ao['money_spent'] = $expenses;
					$row_ao['money_earned'] = $profits;
					$row_ao['pechalba'] = $pechalba;
					$row_ao['is_build'] = 1;
					$row_ao['tomato_education'] = 1;
					/*--------------------------------------------- 
							GETS INFO FOR TOMATO PRODUCING
					-----------------------------------------------*/
					$row_ao['is_finished'] = 0;
					$row_ao['ftf_tomato_producing'] = 0;
					
					$q_get = $this->db->get_where('farming_ft_tomatos', array('ftf_tomato_user_id' => $this->user_id, 'tft_tomato_area_id' => $area_id));
					if($q_get->num_rows() >= 1) {
						$now 			= date(time()); 
						$row_milk = $q_get->row_array();
						if($now > $row_milk['ftf_tomato_date_end']) { // has finished
							$row_ao['tomato_production'] = 0;
							if($row_milk['ftf_tomato_producing'] == 1) {
								$row_ao['is_finished'] = 1;
								$row_ao['ftf_tomato_producing'] = 1;
							}
						} else {
							$row_ao['tomato_production'] 	= 1;
							$row_ao['tomato_prod_finish'] = date( "d.m.Y H:i:s", $row_milk['ftf_tomato_date_end']);
						}
					} else {
						$row_ao['tomato_production'] = 0;
					}
					/*** END OF PRODUCING ***/
					
					return $row_ao;
				} else {
					$this->db->select('*');
					$this->db->from('area_owners');
					$this->db->where('ao_area_id', $area_id);
					$q_ao = $this->db->get();
					$row_ao = $q_ao->row_array();	
					/*--------------------------------------------------
					CHECKS IF THE USER HAS EDUCATION TO BUILD TOMATO FARM
					---------------------------------------------------*/
					$this->db->select("*");
					$this->db->from("education");
					$this->db->where("edu_user_id = $this->user_id AND edu_spec_id = 1");
					$q_get_education = $this->db->get();
					if($q_get_education->num_rows() > 0) {
						$row_ao['tomato_education'] = 1;
					} else {
						$row_ao['tomato_education'] = 0;
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
								# SEEDING TOMATOS #
		---------------------------------------------------------------------------*/
		public function seeding_tomatos() {
			$area_id 		= $this->input->post('area_id');
			$space 			= $this->input->post('space');
			$val 			= $this->input->post('val');
			
			if($val == 1) {
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
					/*-----------------------------------------------------------
									CALCULATES TOTAL COSTS
					------------------------------------------------------------*/
					$seeds = $space*120;
					$water = ($space*60)*3;
					$work = $space*2000;
					$money = $seeds + $water + $work;
					/*** END OF calculations ***/
					
					/*--- MAIN CHECKS FOR ENERGY AND MONEY ---*/
					if($this->create_buildings_model->us_con('uc_money')<$money) {
						return 'no_enough_money';
					} else if($this->create_buildings_model->us_con('uc_energy')<15) {
						return 'no_enough_energy';
					} else {
						/*-----------------------------------------------------------
							CHECKS IF THE AREA HAS ALREADY BEEN SEEDED
						------------------------------------------------------------*/
						$q_get = $this->db->get_where('farming_tomato', array('tomato_farm_user_id' => $this->user_id, 'tomato_farm_area_id' => $area_id));
						if($q_get->num_rows() == 0) {
							/*-- INSERTS/CREATE THE TOMATO FARM INTO farming_tomato --*/
							$db_tom_arr = array(
								'tomato_farm_user_id'		=> $this->user_id, 
								'tomato_farm_area_id'		=> $area_id, 
								'tf_space_seed'				=> $space, 
								'tf_tomato_tons'			=> 0, 
								'tf_ip'						=> $_SERVER['REMOTE_ADDR']
							);
							$this->db->insert('farming_tomato', $db_tom_arr);
							
							/*-- UPDATES AREA'S cat_building to 10 --*/
							$this->db->where('area_id', $area_id);
							$this->db->update('areas', array('area_cat_building' => 10));
							
							/*--- UPDATES USER'S CONDTIONS ---*/
							$new_power = $this->create_buildings_model->us_con('uc_power') + 15;
							$this->create_buildings_model->user_conditions_money_rest($new_power, $money, 15, 15, 0, 2.5);
							$this->create_buildings_model->insert_users_action('tomato_farm', "Засадени $space декара домати", $money, 5);
							$this->create_buildings_model->spent_money($area_id, $money, 'tomato_farm', "Засадени $space декара домати");
							return 'seeded';
						} else {
							$upd_tom_arr = array(
								'tf_space_seed'				=> $space, 
								'tf_ip'						=> $_SERVER['REMOTE_ADDR']
							);
							$this->db->where("tomato_farm_user_id = $this->user_id AND tomato_farm_area_id = $area_id");
							$this->db->update('farming_tomato', $upd_tom_arr);
							
							/*--- UPDATES USER'S CONDTIONS ---*/
							$new_power = $this->create_buildings_model->us_con('uc_power') + 15;
							$this->create_buildings_model->user_conditions_money_rest($new_power, $money, 15, 15, 0, 2.5);
							$this->create_buildings_model->insert_users_action('tomato_farm', "Засадени $space декара домати", $money, 5);
							$this->create_buildings_model->spent_money($area_id, $money, 'tomato_farm', "Засaдени $space декара домати");
							return 'seeded';
						}
					}
				} else {
					exit();
				}
			} else {
				redirect(base_url());
			}
		}
		/**** END OF seeding_tomatos ****/
		/*--------------------------------------------------------------------------- 
								# TOMATO PRODUCTION #
		---------------------------------------------------------------------------*/
		public function tomato_production() {
			$area_id = $this->input->post('area_id');
			$val = $this->input->post('val');
			
			if($val == 1) {
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
					/* TIME VARS AND CALCULATIONS */
					$now 			= date(time()); // TIMESTAMP NOW TIME
					$finish_time 	= strtotime('+3 days', $now); // TIME AFTER 3 DAYS
					/*--------------------------------------------------------------------------
						CHEKS IF THERE IS ALREADY ROW WITH THIS AREA ID TO PRODUCE TOMATOS
					---------------------------------------------------------------------------*/
					$q_milk_production = $this->db->get_where('farming_ft_tomatos', array('ftf_tomato_user_id' => $this->user_id, 'tft_tomato_area_id' => $area_id));
					
					if($q_milk_production->num_rows() >= 1) {
						/* UPDATE */
						$upd_arr = array(
							'ftf_tomato_date_started' => $now,
							'ftf_tomato_date_end' 	=> $finish_time,
							'ftf_tomato_producing'	=> 1,
							'ftf_ip' 				=> $_SERVER['REMOTE_ADDR']
						);
						$this->db->where("ftf_tomato_user_id = $this->user_id AND tft_tomato_area_id = $area_id");
						$this->db->update('farming_ft_tomatos', $upd_arr);
					} else {
						/* INSERT */
						$insert_array = array(
							'ftf_tomato_user_id' 		=> $this->user_id,
							'tft_tomato_area_id' 		=> $area_id,
							'ftf_tomato_date_started' 	=> $now,
							'ftf_tomato_date_end' 		=> $finish_time,
							'ftf_tomato_producing' 		=> 1,
							'ftf_ip' 					=> $_SERVER['REMOTE_ADDR']
						);
						$this->db->insert('farming_ft_tomatos', $insert_array);
					}
				} else {
					exit();
				}
			} else {
				redirect(base_url());
			}
		}
		/*** END OF TOMATO PRODUCTION ***/
		/*--------------------------------------------------------------------------- 
							# COLLECTS TOMATO PRODUCTION #
		---------------------------------------------------------------------------*/
		public function collect_tomato_production() {
			$area_id = $this->input->post('area_id');
			$val = $this->input->post('val');
			
			if($val == 1) {
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
					$this->db->select("*");
					$this->db->from('farming_tomato');
					$this->db->where("tomato_farm_user_id = $this->user_id AND tomato_farm_area_id = $area_id");
					$q = $this->db->get();
					$q_row = $q->row_array();
					
					$tons = $q_row['tf_space_seed']*5; // 5 tona na dekar
					
					/*--- UPDATES FARMING LITRES ---*/
					$this->db->where("tomato_farm_user_id = $this->user_id AND tomato_farm_area_id = $area_id");
					$this->db->set('tf_tomato_tons', "tf_tomato_tons+$tons", FALSE);
					$this->db->update('farming_tomato', array('tf_space_seed' => 0));
					
					/*--- UPDATES DAIRY FARM MILK PRODUCTION TO 0 --- */
					$this->db->where("ftf_tomato_user_id = $this->user_id AND tft_tomato_area_id = $area_id");
					$this->db->update('farming_ft_tomatos', array('ftf_tomato_producing' => 0));
				} else {
					exit();
				}
			} else {
				exit();
			}
		}
		/*** END OF collecting_tomato ***/
		/*--------------------------------------------------------------------------- 
								# SELL MILK PRODUCTION #
		---------------------------------------------------------------------------*/
		public function sell_tomatos_production() {
			$area_id = $this->input->post('area_id');
			$val = $this->input->post('val');
			
			if($val == 1) {
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
					$this->db->select("*");
					$this->db->from('farming_tomato');
					$this->db->where("tomato_farm_user_id = $this->user_id AND tomato_farm_area_id = $area_id");
					$q = $this->db->get();
					$q_row = $q->row_array();
					
					if($q_row['tf_tomato_tons']==0) {
						return 'zero_tomatos';
					} else {
						$money = $q_row['tf_tomato_tons']*500;
						/*--- UPDATE STORAGE TO 0 ---*/
						$this->db->where("tomato_farm_user_id = $this->user_id AND tomato_farm_area_id = $area_id");
						$this->db->update('farming_tomato', array('tf_tomato_tons' => 0));
						/*--- UPDATES USER'S CONDTIONS ---*/
						$new_power = $this->create_buildings_model->us_con('uc_power') + 10;
						$this->create_buildings_model->user_conditions_money_rest($new_power, -$money, 0, 0, 0, 5.5);
						$this->create_buildings_model->insert_users_action('milk_sold', "Продадени $q_row[tf_tomato_tons] тона домати", $money, 5);
						$this->create_buildings_model->money_earned_on_area($area_id, $this->user_id, $money, 'milk_sold',"Продадени $q_row[tf_tomato_tons] тона домати");
						return 'milk_sold';
					}
				} else {
					exit();
				}
			} else {
				exit();
			}
		}
		/*** END OF Selling tomatos ***/
	}