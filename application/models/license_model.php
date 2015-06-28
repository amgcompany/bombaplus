<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class License_model extends CI_Model {
		private $user_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			
			
			$this->user_id = $this->session->userdata('user_id');
		}
		/*--- CHEKS IF THE USER HAS A CASINO LICENSE ---*/
		public function check_type_license($type) {
			$q = $this->db->get_where('licenses', array('license_user_id'=>$this->user_id, 'license_type'=>$type));
			$row = $q->row_array();
			$row['num_rows'] = $q->num_rows();
			return $row;
		}
		/*** END of check_casino_license() ***/
		/*--- BUYS LICENSE ---*/
		public function buy_license_type() {
			$type	 = $this->input->post('type');
			$val	 = $this->input->post('val');
			
			if($val == 1) {
				$this->load->model('create_buildings_model');

				if($type == 1) {
					$decr = 'Лиценз за казино';
					$money = 250000;
					$new_power = $this->create_buildings_model->us_con('uc_power') + 75;
					$tuz = 250;
				} else if($type == 2) {
					$decr = 'Лиценз за добив на злато';
					$money = 5500000;
					$new_power = $this->create_buildings_model->us_con('uc_power') + 250;
					$tuz = 150;
				} else if($type == 3) {
					$decr = 'Лиценз за добив на нефт';
					$money = 30000000;
					$new_power = $this->create_buildings_model->us_con('uc_power') + 1000;
					$tuz = 500;
				}
				$q = $this->db->get_where('licenses', array('license_user_id'=>$this->user_id, 'license_type'=>$type));
				if($q->num_rows() > 0) {
					return 'already_has';
				} else if($q->num_rows() == 0) {
					if($this->create_buildings_model->us_con('uc_energy')<55) {
						return 'no_enough_energy';
					} else if($this->create_buildings_model->us_con('uc_money')<$money){
						return 'no_enough_money';
					}	else {
						/* INSERTS THE INFTO INTO licenses table */
						$data = array(
							'license_user_id'		=> $this->user_id,
							'license_type'			=> $type,
							'license_description'	=> $decr,
							'license_ip'			=> $_SERVER['REMOTE_ADDR']
						);
						$this->db->insert('licenses', $data);
						
						/* UPDATES USER'S CONDITIONS */
						
						$this->create_buildings_model->user_conditions_money_rest($new_power, $money, 55, 35, 0, $tuz);
						$this->create_buildings_model->insert_users_action('bought_license', "Купен ".$decr, $money, 30);
						return 'license_bought';
						}
				}
			} else {
				exit();
			}
		}
		/**** END OF buy license_type ****/
	}