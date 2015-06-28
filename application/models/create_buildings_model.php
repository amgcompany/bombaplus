<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Create_buildings_model extends CI_Model {
		private $user_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			$this->user_id = $this->session->userdata('user_id');
		}
		/* BUILDS MANSIONS */
		public function load_build_mansions() {
			$area_id = $this->input->post('area_id');
			$zone_id	 = $this->input->post('zone_id');
			$val	 = $this->input->post('val');
			if($val == 1) {
				
				if($this->is_owner_of_area($area_id) == 1) {
					/* CALCULATES SPENT MONEY ON THE AREA */
					$sum_expenses = 0;
					$q_expenses = $this->db->get_where('area_spent_money', array('asm_area_id'=>$area_id));
					foreach($q_expenses->result_array() AS $row_expenses) {
						$sum_expenses += $row_expenses['asm_money_invest'];
					}
					$expenses = number_format($sum_expenses, 0, '.', ' ');
					/* CALCULATES EARNED MONEY ON THE AREA */
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
					$pechalba = number_format($sum_profits-$sum_expenses, 0, '.', ' ');
					/*
					| CHECKS IF THERE IS BUILDED MANSIONS ON THIS AREA 
					*/
					$this->db->select('*');
					$this->db->from('building_apartments');
					$this->db->join('area_owners', 'area_owners.ao_area_id=building_apartments.ba_area_id');
					$this->db->join('accounts', 'accounts.user_id=area_owners.ao_owner_id');
					$this->db->where('building_apartments.ba_area_id', $area_id);
					$q_ba = $this->db->get();
					
					if($q_ba->num_rows() > 0) { // If there is, do smth
						$row_ao = $q_ba->row_array();
						$row_ao['money_spent'] = $expenses;
						$row_ao['money_earned'] = $profits;
						$row_ao['pechalba'] = $pechalba;
						$row_ao['is_build'] = 1;
						
						/* GETS ALL INFORMATION ABOUT OWNERS OF APARTMENTS */
						$q_ba_owners = $this->db->get_where('building_apartment_owners', array('bao_area_id'=>$area_id));
						$apartment_owners = array(); // in this array will be all owners of apartment from mansion with area_id
						foreach($q_ba_owners->result_array() as $key=>$bao_row) {
							$apartment_owners[] = $bao_row;
							/* CHECKS IF THE APARTMENT IS SOLD, AND IF IT IS, GETS INFOR ABOUT THE OWNER (WHO IS HE) */
							if($bao_row['ba_owner_sold'] == 1) {
								$q_ap_owner = $this->db->get_where('accounts', array('user_id'=>$bao_row['ba_owner_user_id']));
								$row_ap_owner = $q_ap_owner->row_array();
								
								$apartment_owners[$key] = array_slice($apartment_owners[$key], 0, 3, true) +
								array("owner_user" => $row_ap_owner['username']) + array("owner_user_id" => $row_ap_owner['user_id']) +
								array_slice($apartment_owners[$key], 3, count($apartment_owners[$key]) - 1, true);
							}
							
						}
						$row_ao['ba_owners'] = $apartment_owners;
						/* END OF GETTING INFO ABOUT OWNERS OF APARTMENTS */
						
						//print_r($row_ao);
						return $row_ao;
					} else { // if there's no
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
					/* 
					| GETS INFORMATION HOW MANY IS THE SPACE OF THE AREA FROM area_owner
					*/

					/*$this->db->select('*');
					$this->db->from('building_apartments');
					$this->db->join('area_owners', 'area_owners.ao_area_id=building_apartments.ba_area_id');
					$q = $this->db->get();*/
				} else {
					exit();
				}
			} else {
				redirect(base_url());
			}
		}
		/**** END of buidl_mansions() ****/
		
		/*------------------------------------------------------------------------ 
		ENETERS MANSIONS 
		-------------------------------------------------------------------------*/
		public function enter_mansions_model() {
			$area_id = $this->input->post('area_id');
			$zone_id	 = $this->input->post('zone_id');
			$val	 = $this->input->post('val');
			if($val == 1) {
				$q_ex = $this->db->get_where('building_apartments', array('ba_area_id'=>$area_id)); 
				if($q_ex->num_rows()>0) { 					/* CHECKS IF THE MANSIONS EXISTS */ 
					$this->db->select('*');
					$this->db->from('building_apartments');
					$this->db->join('area_owners', 'area_owners.ao_area_id=building_apartments.ba_area_id');
					$this->db->join('accounts', 'accounts.user_id=area_owners.ao_owner_id');
					$this->db->where('building_apartments.ba_area_id', $area_id);
					$q_ba = $this->db->get();
					
					$row_ao = $q_ba->row_array();
					$row_ao['is_build'] = 1;
						
					/* GETS ALL INFORMATION ABOUT OWNERS OF APARTMENTS */
					$q_ba_owners = $this->db->get_where('building_apartment_owners', array('bao_area_id'=>$area_id));
					$apartment_owners = array(); // in this array will be all owners of apartment from mansion with area_id
					foreach($q_ba_owners->result_array() as $key=>$bao_row) {
						$apartment_owners[] = $bao_row;
						/* CHECKS IF THE APARTMENT IS SOLD, AND IF IT IS, GETS INFOR ABOUT THE OWNER (WHO IS HE) */
						if($bao_row['ba_owner_sold'] == 1) {
							$q_ap_owner = $this->db->get_where('accounts', array('user_id'=>$bao_row['ba_owner_user_id']));
							$row_ap_owner = $q_ap_owner->row_array();
							
							$apartment_owners[$key] = array_slice($apartment_owners[$key], 0, 3, true) +
							array("owner_user" => $row_ap_owner['username']) + array("owner_user_id" => $row_ap_owner['user_id']) +
							array_slice($apartment_owners[$key], 3, count($apartment_owners[$key]) - 1, true);
						}
							
					}
					$row_ao['ba_owners'] = $apartment_owners;
					/* END OF GETTING INFO ABOUT OWNERS OF APARTMENTS */
					return $row_ao;
				} else {
					exit();
				}
			} else {
				redirect(base_url());
			}
		}
		/**** END OF ENETERS MANSIONS ****/
		
		/*--- BUYS MORE AREA FOR A USER ---*/
		public function buy_more_area() {
			$area_id = $this->input->post('area_id');
			$space = $this->input->post('space');
			$sum = $this->input->post('sum');
			$validator = $this->input->post('validator');
			
			if($validator != 1) {
				redirect(base_url());
			} else {
				
				$q_area = $this->db->get_where('area_owners', array('ao_area_id'=>$area_id));
				$q = $this->db->get_where('user_conditions', array('uc_user_id' => $this->session->userdata('user_id')));
				$row = $q->row_array();
			
				if($sum>$row['uc_money']) { // CHEKS IF THE USER HAS ENOUGH MONEY TO BUY THE AREA
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
					
					// UPDATES INFO ABOUT USER'S CONDTIONS
					$this->user_conditions_money_rest($new_power, $sum, 3, 1, 0, 0); // 3 is energy to take, 1 is fun to take

					/* 
					| UPDATES THE area INTO area_owners TABLE FOR USER ID session->user_id
					*/
					$data = array(
						'ao_area_id' => $area_id,
						'ao_owner_id' => $this->user_id,
						'ao_space'	=> $space
					);
					$this->db->where('ao_area_id', $area_id);
					$this->db->set('ao_space', "ao_space+$space", FALSE);
					$this->db->update('area_owners');
					
					// INSERTS INFORMATION ABOUT USER'S ACTIONS
					$this->insert_users_action('bought_area', "Купени още $space кв.м", $sum, 0.2);
					/* 
					| INSERTS DATA INTO areas_spent_money WHERE WILL BE ALL SPENT MONEY ON THIS AREAS
					*/
					$this->spent_money($area_id, $sum, 'bought_area', "Купени още $space кв.м");
					return 'area_bought';
				}
			}
		}
		/**** END of buy_area ****/
		
		/*------------------------------------------------------------------ 
			|BUY ALLOW TO BUILD 
		------------------------------------------------------------------ */
		public function buy_allowance() {
			$area_id = $this->input->post('area_id');
			$validator = $this->input->post('validator');

			if($validator != 1) {
				redirect(base_url());
			} else {
				$q = $this->db->get_where('user_conditions', array('uc_user_id' => $this->session->userdata('user_id')));
				$row = $q->row_array();
				if(10000>$row['uc_money']) { // CHEKS IF THE USER HAS ENOUGH MONEY TO BUY THE AREA
					return 'no_enough_money';
				} else if($row['uc_energy']<3) { 
					return 'no_enough_energy';
				} else { 
					$data = array(
						'ballow_area_id'	=> $area_id,
						'ballow_user_id'	=> $this->user_id,
						'ballow_is_allowed'	=> 1,
						'ballow_ip'	=> $_SERVER['REMOTE_ADDR']
					);
					$this->db->insert('building_allow_build',$data);
					$new_power = $row['uc_power']+0.15;
					$this->user_conditions_money_rest($new_power, 10000, 5, 5, 0, 0);
					$this->insert_users_action('license_to_build', 'Купено разрешително за строеж', 10000, 0.4);
					$this->spent_money($area_id, 10000, 'license_to_build', 'Купено разрешително за строеж');
					return 'bought_build';
				}
			}
		}
		/************************************************************************ 
			|END OF buy_allowance() 
		*************************************************************************/
		/*------------------------------------------------------------------ 
			|BUILD MANSIONS
		------------------------------------------------------------------ */
		public function build_apartments() {
			$area_id = $this->input->post('area_id');
			$level = $this->input->post('level');
			$howmuch = $this->input->post('howmuch');
			$validator = $this->input->post('val');

			if($validator != 1) {
				redirect(base_url());
			} else {
				$q = $this->db->get_where('user_conditions', array('uc_user_id' => $this->session->userdata('user_id')));
				$row = $q->row_array();
				if($howmuch>$row['uc_money']) { // CHEKS IF THE USER HAS ENOUGH MONEY TO BUY THE AREA
					return 'no_enough_money';
				} else if($row['uc_energy']<15) { 
					return 'no_enough_energy';
				} else {
					$q_apart = $this->db->get_where('building_apartments', array('ba_area_id' => $area_id));
					$row_apart = $q_apart->row_array();
					// if da proverqva na koi level e i ako veche e postroeno da updatva are fuck off
					if($q_apart->num_rows() == 0) {  // CHECKS IF THERE IS BUILD MANSIONS, IF THERE IS NO, THEN INSERTS
						$data = array(
							'ba_area_id'	=> $area_id,
							'ba_user_id'	=> $this->user_id,
							'b_apartment_level'	=> 1,
							'ba_apartments'	=> 5,
							'ba_ip_builded'	=> $_SERVER['REMOTE_ADDR']
						);
						$this->db->insert('building_apartments',$data);
						for($i=1;$i<=5;$i++) {
							$bao_data = array(
								'bao_area_id'		=> $area_id,
								'ba_owner_user_id'	=> $this->user_id,
								'bao_price'			=> 350000,
								'ba_owner_ip'		=> $_SERVER['REMOTE_ADDR']
							);
							$this->db->insert('building_apartment_owners',$bao_data);
						}
						
						/* UPDATES CATEGORY OF BUIDLING TO 1 SO IT IS A MANSIONS */
						$this->db->where('area_id', $area_id);
						$this->db->update('areas', array('area_cat_building' => 1)); 
						
						/* UPDATES DATA ABOUT USERS'S CONDTIONS AND MONEY SPENT ON AREA */
						$new_power = $row['uc_power']+2;
						$this->user_conditions_money_rest($new_power, $howmuch, 15, 10, 0, 0);
						$this->insert_users_action('mansions_build', "Строеж на блок ниво $level", $howmuch, 2);
						$this->spent_money($area_id, $howmuch, 'mansions_build', "Строеж на блок ниво $level");
						
						return 'mansions_build';
					} else if($row_apart['b_apartment_level'] == 1) { // BUILDING LEVEL TWO
						$data = array(
							'b_apartment_level'	=> 2,
							'ba_apartments'	=> 10,
							'ba_ip_builded'	=> $_SERVER['REMOTE_ADDR']
						);
						$this->db->where('ba_area_id', $area_id);
						$this->db->update('building_apartments',$data);
						for($i=1;$i<=5;$i++) {
							$bao_data = array(
								'bao_area_id'		=> $area_id,
								'ba_owner_user_id'	=> $this->user_id,
								'bao_price'			=> 350000,
								'ba_owner_ip'		=> $_SERVER['REMOTE_ADDR']
							);
							$this->db->insert('building_apartment_owners',$bao_data);
						}
						$new_power = $row['uc_power']+5;
						$this->user_conditions_money_rest($new_power, $howmuch, 15, 10, 0, 0);
						$this->insert_users_action('mansions_updated', "Построено ниво $level на блок", $howmuch, 4);
						$this->spent_money($area_id, $howmuch, 'mansions_updated', "Построено ниво $level на блок");
						return 'mansions_updated';
					}
				}
			}
		}
		/************************************************************************ 
			|END OF build_apartments() 
		*************************************************************************/
		
		/* --- DEFINES THE PRICE OF AN APARTMENT --- */
		public function update_price() {
			$area_id = $this->input->post('area_id');
			$price = $this->input->post('price');
			$validator = $this->input->post('val');

			if($validator != 1) {
				redirect(base_url());
			} else {
				$this->db->where("bao_area_id = '$area_id' AND ba_owner_user_id = '$this->user_id'");
				$this->db->update('building_apartment_owners', array('bao_price' => $price)); 
				return 'price_updated';
			}
		}
		/* *** END of update_price() *** */
		/* --- BUYS AN APARTMENT --- */
		public function buy_apartment_model() {
			$apart_id = $this->input->post('apart_id');
			$area_id = $this->input->post('area_id');
			$mansions_owner = $this->input->post('mansions_owner');
			$price = $this->input->post('price');
			$validator = $this->input->post('val');

			if($validator != 1) {
				redirect(base_url());
			} else {
				$q = $this->db->get_where('user_conditions', array('uc_user_id' => $this->session->userdata('user_id')));
				$row = $q->row_array();
				if($price>$row['uc_money']) { // CHEKS IF THE USER HAS ENOUGH MONEY TO BUY THE AREA
					return 'no_enough_money';
				} else if($row['uc_energy']<10) { 
					return 'no_enough_energy';
				} else {
					/* UPDATES INFO ABOUT THE BOUGHT APARTMENT FROM USER $this->user_id (buys an apartment) */
					$data = array(
						'ba_owner_user_id'	=> $this->user_id,
						'ba_owner_sold'		=> 1,
						'ba_owner_ip'		=> $_SERVER['REMOTE_ADDR']
					);
					$this->db->where("ba_owners_id", $apart_id);
					$this->db->update('building_apartment_owners', $data);
					
					/* UPDATES INFO ABOUT PROFITS ON AREA */
					$area_profits = array(
						'aem_area_id'				=> $area_id, 
						'aem_user_id'				=> $mansions_owner,
						'aem_money_earn' 			=> $price,
						'aearn_money_action' 		=> 'sold_apartment',
						'aerna_money_description'	=> "Продаден апартамент № $apart_id",
						'aem_ip'					=> $_SERVER['REMOTE_ADDR']
					);
					$this->db->insert('area_earn_money', $area_profits);
					
					/* UPDATES MONEY OF THE MANSION'S OWNER */
					$this->db->where('uc_user_id', $mansions_owner);
					$this->db->set('uc_money', "uc_money+$price", FALSE);
					$this->db->update('user_conditions');
					/* UPDATES THAT THE USER HAS ALREADY HAS A HOME */
					$this->db->where('uc_user_id', $this->user_id);
					$this->db->update('user_conditions', array('uc_home' => '1'));
					/* UPDATES ABOUT USERS CONDTIONS */
					$new_power = $row['uc_power']+0.5;
					$this->user_conditions_money_rest($new_power, $price, 10, 15, 1, 2.1);
					$this->insert_users_action('apartment_bought', "Купен апартамент за $price", $price, 0.5);
					
					return 'apartment_bought';
				}
			}
		}
		/* *** END of buy_apartment_model() *** */
		/*----------------------------------------------------------------
			| OPPORTUNITY FOR MANSIONS OWNER TO LIVE IN HIS OWN BUIDLING |
		----------------------------------------------------------------*/
		function live_here_model() {
			$apart_id = $this->input->post('apart_id');
			$area_id = $this->input->post('area_id');
			$validator = $this->input->post('val');
			if($validator != 1) {
				redirect(base_url());
			} else {
				$data = array(
						'ba_owner_user_id'	=> $this->user_id,
						'ba_owner_sold'		=> 1,
						'ba_owner_ip'		=> $_SERVER['REMOTE_ADDR']
					);
				$this->db->where("ba_owners_id", $apart_id);
				$this->db->update('building_apartment_owners', $data);
				/* UPDATES THAT THE USER HAS ALREADY HAS A HOME */
				$this->db->where('uc_user_id', $this->user_id);
				$this->db->set('uc_areas', "uc_areas+1", FALSE);
				$this->db->update('user_conditions', array('uc_home' => '1'));
				/* INSERTS INFO ABOUT USER'S ACTIONS */
				$this->insert_users_action('started_living', "Започнахте да живеете в собствена сграда", "0", "0.4");
			}
		}
		/**************************************************************
			| END OF live_here function() |
		***************************************************************/
		/*----------------------------------------------------------------
			| SETS APARTMENT TO FREE |
		----------------------------------------------------------------*/
		function set_free_apartment_model($apart_id, $area_id) {
			$apart_id = $this->input->post('apart_id');
			$area_id = $this->input->post('area_id');
			$validator = $this->input->post('val');
			if($validator != 1) {
				redirect(base_url());
			} else {
				$data = array(
						'ba_owner_user_id'	=> $this->user_id,
						'ba_owner_sold'		=> 0,
						'ba_owner_ip'		=> $_SERVER['REMOTE_ADDR']
					);
				$this->db->where("ba_owners_id", $apart_id);
				$this->db->update('building_apartment_owners', $data);
				/* UPDATES THAT THE USER HAS ALREADY HAS A HOME */
				$this->db->where('uc_user_id', $this->user_id);
				$this->db->set('uc_areas', "uc_areas-1", FALSE);
				$this->db->update('user_conditions', array('uc_home' => '0'));
				/* INSERTS INFO ABOUT USER'S ACTIONS */
				$this->insert_users_action('set_free_apartment', "Освободен апартамент от собствена сграда", "0", "1");
			}
		}
		/**************************************************************
			| END OF set_free_apartment() |
		***************************************************************/
		
		/*--- GETS EXPENSES ABOUT AN AREA (it has been used in More CONTROLLER) ---*/
		public function get_expenses($area_id) {
			/* CHECKS IF THE AREA OWNS TO THE USER WITH ID $this->user_id */
			$q_area_owner = $this->db->get_where('areas', array('area_id' => $area_id ,'area_sold_to_id' => $this->user_id));
			if($q_area_owner->num_rows() == 1) {
				/* QUERY GETS ALL THE INFO ABOUT EXPENSES FROM area_spent_money TABLE IN THE DB */
				$return_data = array();
				$this->db->select('*');
				$this->db->order_by('asm_id', 'DESC');
				$q = $this->db->get_where('area_spent_money', array('asm_area_id'=>$area_id), 50, 0);
				foreach($q->result_array() AS $row) {
					$return_data[] = $row;
				}
				return $return_data;
			} else {
				redirect(base_url().'home');
			}
		} 
		/*** END of get_expenses ***/
		/*--- GETS PROFITS ABOUT AN AREA (it has been used in More CONTROLLER) ---*/
		public function get_profits($area_id) {
			/* CHECKS IF THE AREA OWNS TO THE USER WITH ID $this->user_id */
			$q_area_owner = $this->db->get_where('areas', array('area_id' => $area_id ,'area_sold_to_id' => $this->user_id));
			if($q_area_owner->num_rows() == 1) {
				/* QUERY GETS ALL THE INFO ABOUT EXPENSES FROM area_spent_money TABLE IN THE DB */
				$return_data = array();
				$this->db->select('*');
				$this->db->order_by('aem_id', 'DESC');
				$q = $this->db->get_where('area_earn_money', array('aem_area_id'=>$area_id), 50, 0);
				foreach($q->result_array() AS $row) {
					$return_data[] = $row;
				}
				return $return_data;
			} else {
				redirect(base_url().'home');
			}
		} 
		/*** END of get_profits ***/
		
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
			if($energy>=0) {
				if($row['uc_energy']>=0) {							
					$this->db->set('uc_energy', "uc_energy-$energy", FALSE);
				}
			} else if($energy<0) {
				$new_energy	= abs($energy);
				if($new_energy>=100) {
					$this->db->set('uc_energy', "100", FALSE);
				} else if($new_energy<=100 && $new_energy>=0) {
					$to_give = $row['uc_energy']+$new_energy;
					if($to_give>=100) {
						$this->db->set('uc_energy', "100", FALSE);
					} else {
						$this->db->set('uc_energy', "$to_give", FALSE);
					}
				}
			}
			if($fun>=0) {
				if($row['uc_fun']>=0){
					$fun_to_take = $row['uc_fun'] - $fun;
					if($fun_to_take > 0) {
						$this->db->set('uc_fun', "uc_fun-$fun", FALSE);
					} else {
						$this->db->set('uc_fun', "uc_fun-uc_fun", FALSE);
					}
				} 
			} else if($fun<0) {
				$new_fun = abs($fun);
				if($new_fun>=100) {
					$this->db->set('uc_fun', "100", FALSE);
				} else if($new_fun<=100 && $new_fun>=0) {
					$to_give_fun = $row['uc_fun']+$new_fun;
					if($to_give_fun>=100) {
						$this->db->set('uc_fun', "100", FALSE);
					} else {
						$this->db->set('uc_fun', "$to_give_fun", FALSE);
					}
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
		/*-----------------------------------------------------------------------
						| EARNED MONEY ON AREA |
		------------------------------------------------------------------------*/
		public function money_earned_on_area($area_id, $owner, $earned_money, $action, $description) {
			$area_profits = array(
				'aem_area_id'				=> $area_id, 
				'aem_user_id'				=> $owner,
				'aem_money_earn' 			=> $earned_money,
				'aearn_money_action' 		=> $action,
				'aerna_money_description'	=> $description,
				'aem_ip'					=> $_SERVER['REMOTE_ADDR']
			);
			$this->db->insert('area_earn_money', $area_profits);
		}
		/**** end of earned money ****/
		/*--- GIVES USER MONEY ---*/
		public function give_money($user_id, $money) {
			$this->db->where('uc_user_id', $user_id);
			$this->db->set('uc_money', "uc_money+$money", FALSE);
			$this->db->update('user_conditions');
		}
		/**** END of give_money ****/
		/*--- GETS USER'S CONDTIONS ---*/
		public function us_con($parm) {
			/* GETS USER's conditions*/
			$q = $this->db->get_where('user_conditions', array('uc_user_id' => $this->session->userdata('user_id')));
			$row = $q->row_array();
			return $row[$parm];
		}
		/*** END OF get_users cond ***/
		/*--- FUNCTON CHECKS IF USER IS OWNER OF AREA ---*/
		public function is_owner_of_area($area_id) {
			$q_get = $this->db->get_where('area_owners', array('ao_area_id'=>$area_id, 'ao_owner_id'=>$this->user_id));
			if($q_get->num_rows() == 1) {
				return 1;
			} else {
				return 0;
			}
		}
		/*** END OF is_owner_of_area ***/
		/*--- FUNCTON CHECKS IF IS BUILD ON AREA ---*/
		public function is_build_on_area($area_id) {
			$q_get = $this->db->get_where('areas', array('area_id'=>$area_id, 'area_sold_to_id'=>$this->user_id));
			$row = $q_get->row_array();
			if($row['area_cat_building'] != 0) {
				return 1;
			} else {
				return 0;
			}
		}
		/*** END OF is_owner_of_area ***/
	}