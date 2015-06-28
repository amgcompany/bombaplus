<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Casino_model extends CI_Model {
		private $user_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			$this->load->model('create_buildings_model');
			$this->load->model('Restaurant_model');
			
			$this->user_id = $this->session->userdata('user_id');
		}
		/*
		----------------------------------------------------------------------
							# BUILDING CASINO #
		----------------------------------------------------------------------
		*/
		/*--- LOAD BUILD CASINO ---*/
		public function load_build_casino($area_id) {
			/* 
			- CHECK IF THE USER user_id IS OWNER OF THE AREA WITH ID area_id  
			*/
			$val = $this->input->post('val');
			if($val != 1) {
				redirect(base_url());
			} else {
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
					/* GETS expenses and profits on the area */
					$sum_expenses = $this->Restaurant_model->money_spent_on_area($area_id);
					$sum_profits = $this->Restaurant_model->profits_on_area($area_id);		
					/* NUMBER FROMATING */
					$expenses = number_format($sum_expenses, 0, '.', ' ');
					$profits = number_format($sum_profits, 0, '.', ' ');
					$pechalba = number_format($sum_profits-$sum_expenses, 0, '.', ' ');
					/*
					| CHECKS IF THERE IS BUILDED CASINO ON THIS AREA 
					*/
					$this->db->select('*');
					$this->db->from('building_casino');
					$this->db->join('area_owners', 'area_owners.ao_area_id=building_casino.bc_area_id');
					$this->db->join('accounts', 'accounts.user_id=area_owners.ao_owner_id');
					$this->db->where('building_casino.bc_area_id', $area_id);
					$q_ba = $this->db->get();
					
					if($q_ba->num_rows() > 0) { // If there is, do smth
						$row_ao = $q_ba->row_array();
						$row_ao['money_spent'] = $expenses;
						$row_ao['money_earned'] = $profits;
						$row_ao['pechalba'] = $pechalba;
						$row_ao['is_build'] = 1;
						$row_ao['license_to_build'] = 1;
						
						/* CHEKS WHAT TYPE IS THE BUILDING IN areas (area_cat_building) AND IF IT IS 7 IT MEANS THIS IS FINISHED CASINO */
						$q_area_type =	$this->db->get_where('areas', array('area_id'=>$area_id, 'area_cat_building'=>3));
						if($q_area_type->num_rows() == 0) {
							$row_ao['builded_at_all'] = 0;
						} else {
							/* GETS CASINO PRIZES */
							$prize_data = array();
							$q_prizes = $this->db->get_where('building_casino_prizes', array('bcp_area_id'=>$area_id, 'bcp_user_id'=>$this->user_id));
							foreach($q_prizes->result_array() AS $row_prize) {
								$prize_data[] = $row_prize;
							}
							$row_ao['prizes'] = $prize_data;
							$row_ao['builded_at_all'] = 1;
						}
						return $row_ao;
					} else {
						$this->db->select('*');
						$this->db->from('area_owners');
						$this->db->where('ao_area_id', $area_id);
						$q_ao = $this->db->get();
						$row_ao = $q_ao->row_array();
						/* CHECKS IF THE USER HAS LICENSE TYPE 1 TO BUILD A CASINO */
						$q_lice = $this->db->get_where('licenses', array('license_type'=>1, 'license_user_id'=>$this->user_id));
						$row_ao['has_license']	= $q_lice->num_rows();
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
		}
		/* END OF LAOD CASINO */
		/*--- INSERTS MONEY ---*/
		public function money_insert() {
			$area_id = $this->input->post('area_id');
			$money	 = $this->input->post('money');
			$val	 = $this->input->post('val');
			
			if($val == 1) {
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
					if($this->create_buildings_model->us_con('uc_energy')<25) {
						return 'no_enough_energy';
					} else if($this->create_buildings_model->us_con('uc_money')<$money) {
						return 'no_enough_money';
					} else {
						$data = array(
							'bc_area_id'		=> $area_id,
							'bc_user_id'		=> $this->user_id,
							'b_casino_money'	=> $money,
							'b_casino_max_bet'	=> 100000,
							'bc_ip'				=> $_SERVER['REMOTE_ADDR']
						);
						$this->db->insert('building_casino', $data);
						
						$new_power = $this->create_buildings_model->us_con('uc_power') + 30;
						$this->create_buildings_model->user_conditions_money_rest($new_power, $money, 25, 15, 0, 15.5);
						$this->create_buildings_model->spent_money($area_id, $money, 'inserted_casino_money', "Вкарахте в казиното пари -  $money");
						$this->create_buildings_model->insert_users_action('inserted_casino_money', "Вкарахте в казиното $money", $money, 10);
					}
				} else {
					exit();
				}
			} else {
				redirect(base_url());
			}
		}
		/**** END Of insert_money ****/
		/*--- GETTING CASINO MONEY ---*/
		public function getting_casino_money() {
			$area_id = $this->input->post('area_id');
			$money	 = $this->input->post('money');
			$atleast = $this->input->post('atleast');
			$val	 = $this->input->post('val');
			
			if($val == 1) {
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
					/* 
					- CHEKS HOW MUCH WILL BE THE MONEY AFTER THE DONWLOAD
					- CHEKS IF AFTER THE DOWNLOAD, THE MONEY IN THE CASINO WILL BE MORE THAN 5M
					*/
					$res = $this->load_build_casino($area_id);
					$tostay = $res['b_casino_money']-$money;
					
					if($this->create_buildings_model->us_con('uc_energy')<15) {
						return 'no_enough_energy';
					} else if($tostay<$atleast) {
						return 'at_least_five';
					} else if($money>$res['b_casino_money']) {
						return 'no_enough_casino_money';
					} else {
						/* UPDATEST  building_casino AND TAKES MONEY FROM THE CASINO */
						$this->db->select("*");
						$this->db->where("bc_area_id = '$area_id' AND bc_user_id= '$this->user_id'");
						$this->db->set('b_casino_money',"b_casino_money-$money",FALSE);
						$this->db->update('building_casino');
						
						$new_power = $this->create_buildings_model->us_con('uc_power') + 5;
						$this->create_buildings_model->user_conditions_money_rest($new_power, -$money, 15, 5, 0, 5.2);
						$this->create_buildings_model->money_earned_on_area($area_id, $this->user_id, $money, 'taken_casino_money', "Изтеглихте от казиното $money");
						$this->create_buildings_model->insert_users_action('taken_casino_money', "Изтеглихте от казиното $money", $money, 10);
					
					}
				} else {
					exit();
				}
			} else {
				redirect(base_url());
			}
		}
		/**** END Of getting_casino_money ****/
		/*--- INSERTS MORE MONEY IN THE CASINO ---*/
		public function insert_more_money() {
			$area_id = $this->input->post('area_id');
			$money	 = $this->input->post('money');
			$val	 = $this->input->post('val');
			
			if($val == 1) {
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
					if($this->create_buildings_model->us_con('uc_energy')<15) {
						return 'no_enough_energy';
					} else if($this->create_buildings_model->us_con('uc_money')<$money) {
						return 'no_enough_money';
					} else {
						/* UPDATEST  building_casino AND INSERTS MONEY IN THE CASINO */
						$this->db->select("*");
						$this->db->where("bc_area_id = '$area_id' AND bc_user_id= '$this->user_id'");
						$this->db->set('b_casino_money',"b_casino_money+$money",FALSE);
						$this->db->update('building_casino');
						
						$new_power = $this->create_buildings_model->us_con('uc_power') + 2.5;
						$this->create_buildings_model->user_conditions_money_rest($new_power, $money, 15, 5, 0, 5.2);
						$this->create_buildings_model->spent_money($area_id, $money, 'inserted_casino_money', "Вкарахте в казиното пари -  $money");
						$this->create_buildings_model->insert_users_action('taken_casino_money', "Вкарахте в казиното $money", $money, 10);
					
					}
				} else {
					exit();
				}
			} else {
				redirect(base_url());
			}
		}
		/**** END Of insert_more_money ****/
		/*---- CREATES BUILD CASINO, SETS the area_cat_building row to be equal to 3 ----*/
		public function build_create_casino() {
			$area_id = $this->input->post('area_id');
			$money	 = $this->input->post('money');
			$val	 = $this->input->post('val');
			
			if($val == 1) {	
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
					if($this->create_buildings_model->us_con('uc_energy')<25) {
						return 'no_enough_energy';
					} else if($this->create_buildings_model->us_con('uc_money')<$money) {
						return 'no_enough_money';
					} else {
						/* UPDATEST areas area_cat_building to be = 3 */
						$this->db->where("area_id = '$area_id' AND area_sold_to_id = '$this->user_id'");
						$this->db->update('areas', array('area_cat_building'=>3));
						/* INSERTS WINNING PRIZES */
						$this->insert_casino_prizes($area_id);
						/* USERS CONDTIONS */
						$new_power = $this->create_buildings_model->us_con('uc_power') + 15.5;
						$this->create_buildings_model->user_conditions_money_rest($new_power, $money, 15, 5, 0, 45);
						$this->create_buildings_model->spent_money($area_id, $money, 'casino_builded', "Строеж на казино");
						$this->create_buildings_model->insert_users_action('casino_builded', "Строеж на казино", $money, 40);
					
					}
				} else {
					exit();
				}
			} else {
				redirect(base_url());
			}
		}
		/**** END of create_build_casino ****/
			/*--- GETS CASINO's ID ---*/
		public function get_casino_id($area_id) {
			$q_cas = $this->db->get_where('building_casino', array('bc_area_id'=>$area_id));
			if($q_cas>0) {
				$row = $q_cas->row_array();
				$casino_id = (int) $row['b_casino_id'];
				return $casino_id;
			}
		}
		/*** END of get_casino_id ***/
		/*--- CHANGES CASINO PRIZES ---*/
		public function change_prize() {
			$area_id 	= $this->input->post('area_id');
			$prize_id 	= $this->input->post('prize_id');
			$tobe		= $this->input->post('tobe');
			$val	 	= $this->input->post('val');
			
			if($val == 1) {	
				if($this->create_buildings_model->is_owner_of_area($area_id) == 1) {
					$res = $this->load_build_casino($area_id);
					/* CALCULATIONS
					- THE updated prize must be five times less
					*/
					$casino_money = $res['b_casino_money'];
					$min = $casino_money/5;
					if($tobe>$min) {
						return 'five_time_less';
					} else {
						$this->db->where('bc_prize_id', $prize_id);
						$this->db->update('building_casino_prizes', array('bcp_prize'=>$tobe));
						return 'prize_updated';
					}
				}
			} else {
				redirect(base_url());
			}
		}
		/***** END of  *****/
		/*--- INSERT PRIZES ---*/
		public function insert_casino_prizes($area_id) {
			/*--- CHECKING CASES ---*/
			$i = 0;
			for($i=5;$i<=10;$i++) {
				// $i $i X, ($i*10)% of the bet + bet
				if($i<=8) {
					$this->db->insert('building_casino_prizes', array(
						'bcp_area_id' 		=> $area_id,
						'bcp_casino_id' 	=> $this->get_casino_id($area_id),
						'bcp_user_id' 		=> $this->user_id,
						'bcp_how_numbers' 	=> 2,
						'bcp_type' 			=> $i-4,
						'bcp_prize' 		=> $i*10,
						'bcp_ip' 			=> $_SERVER['REMOTE_ADDR'],
					));
				}
				if($i == 9) {
					$this->db->insert('building_casino_prizes', array(
						'bcp_area_id' 		=> $area_id,
						'bcp_casino_id' 	=> $this->get_casino_id($area_id),
						'bcp_user_id' 		=> $this->user_id,
						'bcp_how_numbers' 	=> 2,
						'bcp_type' 			=> $i-4,
						'bcp_prize' 		=> 200,
						'bcp_ip' 			=> $_SERVER['REMOTE_ADDR'],
					));
				}
				if($i == 10) {
					$this->db->insert('building_casino_prizes', array(
						'bcp_area_id' 		=> $area_id,
						'bcp_casino_id' 	=> $this->get_casino_id($area_id),
						'bcp_user_id' 		=> $this->user_id,
						'bcp_how_numbers' 	=> 2,
						'bcp_type' 			=> $i-4,
						'bcp_prize' 		=> 300,
						'bcp_ip' 			=> $_SERVER['REMOTE_ADDR'],
					));
				}
			}
			/* THREE SAME NUMBERS CASES */
			$this->db->insert('building_casino_prizes', array(
				'bcp_area_id' 		=> $area_id,
				'bcp_casino_id' 	=> $this->get_casino_id($area_id),
				'bcp_user_id' 		=> $this->user_id,
				'bcp_how_numbers' 	=> 3,
				'bcp_type' 			=> 7,
				'bcp_prize' 		=> 1000,
				'bcp_ip' 			=> $_SERVER['REMOTE_ADDR'],
			));
			$this->db->insert('building_casino_prizes', array(
				'bcp_area_id' 		=> $area_id,
				'bcp_casino_id' 	=> $this->get_casino_id($area_id),
				'bcp_user_id' 		=> $this->user_id,
				'bcp_how_numbers' 	=> 3,
				'bcp_type' 			=> 8,
				'bcp_prize' 		=> 10000,
				'bcp_ip' 			=> $_SERVER['REMOTE_ADDR'],
			));
			$this->db->insert('building_casino_prizes', array(
				'bcp_area_id' 		=> $area_id,
				'bcp_casino_id' 	=> $this->get_casino_id($area_id),
				'bcp_user_id' 		=> $this->user_id,
				'bcp_how_numbers' 	=> 3,
				'bcp_type' 			=> 9,
				'bcp_prize' 		=> 50000,
				'bcp_ip' 			=> $_SERVER['REMOTE_ADDR'],
			));
			$this->db->insert('building_casino_prizes', array(
				'bcp_area_id' 		=> $area_id,
				'bcp_casino_id' 	=> $this->get_casino_id($area_id),
				'bcp_user_id' 		=> $this->user_id,
				'bcp_how_numbers' 	=> 3,
				'bcp_type' 			=> 10,
				'bcp_prize' 		=> 100000,
				'bcp_ip' 			=> $_SERVER['REMOTE_ADDR'],
			));
			$this->db->insert('building_casino_prizes', array(
				'bcp_area_id' 		=> $area_id,
				'bcp_casino_id' 	=> $this->get_casino_id($area_id),
				'bcp_user_id' 		=> $this->user_id,
				'bcp_how_numbers' 	=> 3,
				'bcp_type' 			=> 11,
				'bcp_prize' 		=> 500000,
				'bcp_ip' 			=> $_SERVER['REMOTE_ADDR'],
			));
			$this->db->insert('building_casino_prizes', array(
				'bcp_area_id' 		=> $area_id,
				'bcp_casino_id' 	=> $this->get_casino_id($area_id),
				'bcp_user_id' 		=> $this->user_id,
				'bcp_how_numbers' 	=> 3,
				'bcp_type' 			=> 12,
				'bcp_prize' 		=> 1000000,
				'bcp_ip' 			=> $_SERVER['REMOTE_ADDR'],
			));
		}
		/**** END OF INSERTING PRIZES ****/
		/*
		************************************************************************
							# END OF BUILDING CASINO #
		************************************************************************
		*/
		/*
		----------------------------------------------------------------------
							# INSIDE CASINO FOR THE USERS #
		----------------------------------------------------------------------
		*/
		public function load_enter_casino($area_id, $casino_id) {
			/* GETS THE OWNER'S NAME */
			$this->db->select('*');
			$this->db->from('building_casino');
			$this->db->join('accounts', 'accounts.user_id=building_casino.bc_user_id');
			$this->db->where('building_casino.bc_area_id', $area_id);
			$q_get = $this->db->get();
			$q_owner_name = $q_get->row_array();
			if($q_get->num_rows() > 0) {
				$row_all['owner'] 		= $q_owner_name['username'];
				$row_all['owner_id'] 	= $q_owner_name['user_id'];
				/* END OF GETTING OWNERS NAME AND ID */
				$row_all['casino_id'] = $casino_id;
				/* GETS CASINO PRIZES */
				$prizes = array();
				$q_get_prizes = $this->db->get_where('building_casino_prizes', array('bcp_casino_id'=>$casino_id));
				foreach($q_get_prizes->result_array() AS $prize) {
					$prizes[] = $prize;
				}
				$row_all['prizes'] = $prizes;
				$row_all['b_casino_max_bet'] = $q_owner_name['b_casino_max_bet'];
				return $row_all;
			} else {
				exit();
			}
		}
		/*--- MAKES CASINO BET ---*/
		public function casino_bet() {
			$casino_id 	= $this->input->post('casino_id');
			$area_id 	= $this->input->post('area_id');
			$bet 		= $this->input->post('zalog');
			$val	 	= $this->input->post('val');
			
			if($val == 1) {
				if($this->create_buildings_model->us_con('uc_energy')<5) {
					return 'no_enough_energy';
				} else if($this->create_buildings_model->us_con('uc_money')<$bet) {
					return 'no_enough_money';
				} else {
					$res = $this->load_enter_casino($area_id, $casino_id);
					if($bet>$res['b_casino_max_bet']) {
						return 'max_bet';
					} else {
						/* UPDATES USER'S CONDTIONS AND TAKES MONEY (bet) FROM THE USER */
						$new_power = $this->create_buildings_model->us_con('uc_power');
						$this->create_buildings_model->user_conditions_money_rest($new_power, $bet, 5, -3, 0, 0);
						$this->create_buildings_model->insert_users_action('casino_gaame', "Направихте залог в казиното", $bet, 1);
						/* INSERTS MONEY IN THE CASINO */
						$this->db->where('b_casino_id', $casino_id);
						$this->db->set('b_casino_money', "b_casino_money+$bet", FALSE);
						$this->db->update('building_casino');
						/* GETS ID OF THE OWNER */
						$owner_id = $res['owner_id'];
						/* UPDATES PROFITS ON AREA */
						$this->create_buildings_model->money_earned_on_area($area_id, $owner_id, $bet, 'casino_bet', "Направен залог $bet");
					}
				}
			} else {
				redirect(base_url());
			}
		}
		/**** END of casino_bet ****/
		public function check_for_prize() {
			$casino_id 	= $this->input->post('casino_id');
			$area_id 	= $this->input->post('area_id');
			$bet 		= $this->input->post('zalog');
			$one 		= $this->input->post('one');
			$two 		= $this->input->post('two');
			$three 		= $this->input->post('three');
			$val	 	= $this->input->post('val');
			if($val == 1) {
				/* GETS CASINO PRIZES */
				$type = $this->get_type_prize($one, $two, $three);
				if($type == 0) {
					return '0';
				} else {
					$q_get_prizes = $this->db->get_where('building_casino_prizes', array('bcp_casino_id'=>$casino_id));
					foreach($q_get_prizes->result_array() AS $prize) {
						if($prize['bcp_type']<=6) {
							if($prize['bcp_type'] == $type) {
								$bash_prize = round($bet+(($bet*$prize['bcp_prize'])/100));
								$new_power = $this->create_buildings_model->us_con('uc_power')+0.2;
								$this->create_buildings_model->user_conditions_money_rest($new_power, -$bash_prize, 0, -5, 0, 0);
								/* GETS MONEY FROM THE CASINO */
								$this->db->where('b_casino_id', $casino_id);
								$this->db->set('b_casino_money', "b_casino_money-$bash_prize", FALSE);
								$this->db->update('building_casino');
								/* SET THE MONEY AS AN EXPENSE FOR THE CASINO */
								$this->create_buildings_model->spent_money($area_id, $bash_prize, 'won_casino_money', "Спечелени пари в казиното -  $bash_prize");
								$return_prize = number_format($bash_prize, 0, '.', ' ');
								return $return_prize;
							}
						} else if($prize['bcp_type']>=7 && $prize['bcp_type']<=12) {
							if($prize['bcp_type'] == $type) {
								$bash_prize = $prize['bcp_prize'];
								$new_power = $this->create_buildings_model->us_con('uc_power')+0.4;
								$this->create_buildings_model->user_conditions_money_rest($new_power, -$bash_prize, 0, -5, 0, 0);
								/* GETS MONEY FROM THE CASINO */
								$this->db->where('b_casino_id', $casino_id);
								$this->db->set('b_casino_money', "b_casino_money-$bash_prize", FALSE);
								$this->db->update('building_casino');
								/* SET THE MONEY AS AN EXPENSE FOR THE CASINO */
								$this->create_buildings_model->spent_money($area_id, $bash_prize, 'won_casino_money', "Спечелени пари в казиното -  $bash_prize");		
								$return_prize = number_format($bash_prize, 0, '.', ' ');
								return $return_prize;
							}
						} 
					}	
				}
			} else {
				redirect(base_url());
			}
		}
		public function get_type_prize($one, $two, $tri) {
			if($one == 6 && $one == $two && $two == $tri) {
				return '12';
			}
			if($one == 5 && $one == $two && $two == $tri) {
				return '11';
			}
			if($one == 4 && $one == $two && $two == $tri) {
				return '10';
			}
			if($one == 3 && $one == $two && $two == $tri) {
				return '9';
			}
			if($one == 2 && $one == $two && $two == $tri) {
				return '8';
			}
			if($one == 1 && $one == $two && $two == $tri) {
				return '7';
			}
			
			if(($one == 6 && $two == 6) || ($one == 6 && $tri == 6) ||($two == 6 && $tri == 6)) {
				return '6';
			}
			if(($one == 5 && $two == 5) || ($one == 5 && $tri == 5) ||($two == 5 && $tri == 5)) {
				return '5';
			}
			if(($one == 4 && $two == 4) || ($one == 4 && $tri == 4) ||($two == 4 && $tri == 4)) {
				return '4';
			}
			if(($one == 3 && $two == 3) || ($one == 3 && $tri == 3) ||($two == 3 && $tri == 3)) {
				return '3';
			}
			if(($one == 2 && $two == 2) || ($one == 2 && $tri == 2) ||($two == 2 && $tri == 2)) {
				return '2';
			}
			if(($one == 1 && $two == 1) || ($one == 1 && $tri == 1) ||($two == 1 && $tri == 1)) {
				return '1';
			}
			return '0';
		}
		/*
		************************************************************************
							# END OF INSIDE CASINO #
		************************************************************************
		*/
	}