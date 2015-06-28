<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Build_bank_model extends CI_Model {
		private $user_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			$this->load->model('create_buildings_model');
			
			$this->user_id = $this->session->userdata('user_id');
		}
		/*---------------------------------------------------
		#			| BANK'S ADMINISTRATIONS |				#
		-----------------------------------------------------*/
		public function bank_administration($area_id) {
			if($this->create_buildings_model->is_owner_of_area($area_id) == 1 && $this->session->userdata('rank') == 1) {
				$q_bank = $this->db->get_where('building_bank', array('b_bank_area_id'=>$area_id, 'bb_user_id'=>$this->user_id));
				$row_bank = $q_bank->row_array();
				
				/* CHECKS IF THERE IS BUILDED BANK ON THIS AREA */
				if($q_bank->num_rows() == 0) {	/* IF THERE IS  */
					$row_bank['is_build'] = 0;
				} else {						/* IF THERE IS NOT */
					$row_bank['is_build'] = 1;
					$row_bank['money_in_the_bank'] = number_format($row_bank['b_bank_money'], 0, '.', ' ');
				}
				return $row_bank;
			} else {
				exit();
			}
		}
		/*--- GETS ALL CREDITS ---*/
		public function bank_credits($area_id) {
			$bank_id = $this->get_bank_id($area_id);
			$data = array();
			$this->db->select("*");
			$this->db->order_by('bb_credit_id','DESC');
			$q = $this->db->get_where('building_bank_credits', array('bbc_bank_id'=>$bank_id));
			foreach($q->result_array() AS $row) {
				$data[] = $row;
			}
			return $data;
		}
		/**** END of get credit ****/
		/**** END OF bank_administration ****/
		
		/*---------------------------------------------------
		#			| LOADS BANKS MAIN VIEWS |				#
		-----------------------------------------------------*/
		
		/*--- GETS BANK'S ID ---*/
		public function get_bank_id($area_id) {
			$q = $this->db->get_where('building_bank', array('b_bank_area_id'=>$area_id));
			$row_id = $q->row_array();
			return @$row_id['b_bank_id'];
		}
		/**** END OF get_bank_id() ****/
		
		/*--- GET FAST CREDIT ---*/
		public function get_credit_fast() {
			$area_id = $this->input->post('area_id');
			$bank_id = $this->input->post('bank_id');
			$sum	 = $this->input->post('sum');
			$val	 = $this->input->post('val');
			if($val == 1) {
				/* CHECKS IF THERE IS EXISTING BANK */
				$q_check_bank = $this->db->get_where('building_bank', array('b_bank_id'=>$bank_id, 'b_bank_area_id'=>$area_id));
				if($q_check_bank->num_rows()<1 || $q_check_bank->num_rows()>1)	{
					return 'no_such_bank';
				} else if($this->create_buildings_model->us_con('uc_energy')<15) {
					return 'no_enough_energy';
				} else {
					/* CALCULATIONS ABOUT THE MONEY AND CREDIT */
					$sum_to_return	= round($sum+($sum/2)); 				/* The increased sum with 50% to return  */
					$return_per_day = round($sum_to_return/6); 				/* DAILY PAYMENT FOR 6 DAYS */
					$limit_date 	= strtotime('+7 days', date(time()));	/* DATE LIMIT UNTIL WHEN THE USER NEED TO EXTINCT HIS CREDIT */
					/* UPDATES BANK'S MONEY subtraction money */
					$this->db->where('b_bank_id', $bank_id);
					$this->db->set('b_bank_money', "b_bank_money-$sum", FALSE);
					$this->db->update('building_bank');
					/* INSERTS DATA INTO building_bank_credits */
					$data = array(
						'bbc_bank_id' 			=>  $bank_id,
						'bbc_user_id' 			=>  $this->user_id,
						'bbc_wanted_money' 		=>  $sum,
						'bbc_total_money' 		=>  $sum_to_return,
						'bbc_type_credit' 		=>  1,
						'bbc_approved' 			=>  1,
						'bbc_per_days' 			=>  1,
						'bbc_payment_per_days' 	=>  $return_per_day,
						'bb_credit_date' 		=>  date(time()),
						'bbc_date_limit' 		=>  $limit_date,
						'bb_credit_ip' 			=>  $_SERVER['REMOTE_ADDR']
					);
					$this->db->insert('building_bank_credits', $data);
					/* UPDATES USER'S CONDITIONS */
					$new_power = $this->create_buildings_model->us_con('uc_power')+0.15;
					$this->create_buildings_model->user_conditions_money_rest($new_power, -$sum, 15, 5, 0, 0.01);
					$this->create_buildings_model->insert_users_action('got_fast_credit', "Изтеглихте бърз кредит на стойност $sum", 0, 0.02);
					return 'fast_credit_ready';
				}
			}
		}
		/*** END OF get_fast_credit() ***/
		/*--- CHECKS IF THE USER HAS DOWNLOADED CREDITS ---*/
		public function is_credit_downlaoded($area_id ,$bank_id) {
			$data = array();
			$q_check_bank = $this->db->get_where('building_bank', array('b_bank_id'=>$bank_id, 'b_bank_area_id'=>$area_id));
			/* CHECKS IF THERE IS EXISTING BANK */
			if($q_check_bank->num_rows()<1 || $q_check_bank->num_rows()>1)	{
				$data['does_exists'] = 0;
				return $data;
			} else {
				$q_credit = $this->db->get_where('building_bank_credits', array('bbc_bank_id'=>$bank_id, 'bbc_user_id'=>$this->user_id));
				if($q_credit->num_rows() >= 1) {		/* IF THE USER HAS CREDITS */
					$row_credit = $q_credit->row_array();
					$data[] = $row_credit;
					$data['is_credit_downlaoded'] = 1;
					/* CHEKS IF THE CREDIT IS PAID */
					if($row_credit['bbc_total_money']<=$row_credit['bbc_howmuch_paid']) {
						$data['is_credit_paid'] = 1;
						$this->db->delete('building_bank_credits', array('bbc_bank_id'=>$bank_id, 'bbc_user_id'=>$this->user_id));
						$this->db->delete('bank_credit_payemets', array('bcp_user_id'=>$this->user_id));
						$row_credit['bbc_is_paid'] == 1;
						$data['is_credit_downlaoded'] = 0;
					} else {
						$data['is_credit_paid'] = 0;
					}
				} else {
					$data[0]['bb_credit_id'] = 0;
					$data['is_credit_downlaoded'] = 0;
				}
				$data['does_exists'] = 1;
				return $data;
			}
		}
		/*** END OF is_credit_downlaoded ***/
		/*--- CREDIT PAYMENT ---*/
		public function pay_credit() {
			$credit_id 	= $this->input->post('credit_id');
			$val		= $this->input->post('val');
			$payment	= $this->input->post('payment');
			$how		= $this->input->post('how');
			
			if($val == 1) {
				/* CHEKCS IF THERE IS SUCH CREDIT FOR THE USER */
				$q_is_credit = $this->db->get_where('building_bank_credits', array('bb_credit_id'=>$credit_id, 'bbc_user_id'=>$this->user_id));
				if($q_is_credit->num_rows() < 1) {
					return 'no_such_credit';
				} else {
					if($this->create_buildings_model->us_con('uc_money')<($payment*$how)) {
						return 'no_enough_money';
					} else if($this->create_buildings_model->us_con('uc_energy')<15) {
						return 'no_enough_energy';
					} else {
						/* INSERT THE PAYMENTS INTO bank_credit_payemets */
						$data = array(
							'bcp_credit_id'	=> $credit_id,
							'bcp_user_id'	=> $this->user_id,
							'bcp_payment'	=> $payment,
							'bcp_date'		=> date(time()),
							'bcp_ip'		=> $_SERVER['REMOTE_ADDR']
						);
						$i = 0;
						for($i=1; $i<=$how; $i++) {
							$this->db->insert('bank_credit_payemets', $data);
						}
						/* UPDATES row to how much money has been paid until now */
						$how_much = $how*$payment;
						$this->db->where('bb_credit_id', $credit_id);
						$this->db->set('bbc_howmuch_paid', "bbc_howmuch_paid+$how_much", FALSE);
						$this->db->update('building_bank_credits');
						/* UPDATES USER'S CONDITIONS */
						$new_power = $this->create_buildings_model->us_con('uc_power')+0.05;
						$this->create_buildings_model->user_conditions_money_rest($new_power, $how_much, 15, 15, 0, 0.01);
						$this->create_buildings_model->insert_users_action('credit_payment', "$how_much вноска кредит", 0, 0.02);
						return 'payment_in';
					}
				}
			} else {
				redirect(base_url());
			} 
		}
		/*** END OF pay_credit ***/
		/*--- CREDIT PAYMENTS ---*/
		public function credit_payments($area_id, $bank_id) {
			$data = array();
			$res = $this->is_credit_downlaoded($area_id, $bank_id);
			if($res['does_exists'] == 1) {
				$tak = $res[0]['bb_credit_id'];
			}
			$this->db->select("*");
			$this->db->order_by('bc_payment_id', 'DESC');
			$q = $this->db->get_where('bank_credit_payemets', array('bcp_credit_id' => $tak));
			foreach($q->result_array() AS $row) {
				$data[] = $row;
			}
			return $data;
		}
		/**** END OF credit payments ****/
		/****# END OF bank load main views #****/
		/*---------------------------------------------------
		#				| BUILDS A BANK |					#
		-----------------------------------------------------*/
		public function create_bank($area_id, $sum) {
			$area_id = $this->input->post('area_id');
			$val	 = $this->input->post('val');
			$sum	 = $this->input->post('sum');
			if($val == 1) {
				$data = array(
					'b_bank_area_id'	=> $area_id,
					'bb_user_id'		=> $this->user_id,
					'b_bank_money'		=> $sum,
					'bb_ip'				=> $_SERVER['REMOTE_ADDR']
				);
				$this->db->insert('building_bank', $data);
				$this->db->where('area_id', $area_id);
				$this->db->update('areas', array('area_cat_building'=>2));
				return 'bank_builded';
			} else {
				redirect(base_url());
			}
		} 
		/**** END of create_bank() ****/
	}