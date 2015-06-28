<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Home_model extends CI_Model {
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
		}
		/* GETS ALL TABLES FROM THE DB */
		public function get_tables() {
			$data = array();
			$tables = $this->db->list_tables();
			foreach ($tables as $table) {
			   $data[] = $table;
			}
			return $data;
		}
		/*--- COUNTS ALL USERS FROM THE DB ---*/
		public function get_users_number() {
			$q = $this->db->get('accounts');
			$num =  $q->num_rows();
			return $num;
		}
		/*** END OF COUNTING ALL USERD ***/
		/*--- USERS WHO HAVE SIGNED UP TODAY ---*/
		public function today_signed_up() {
			$br = 0;
			$q = $this->db->get('accounts');
			foreach($q->result_array() as $row) {
				if (date('Y-m-d') == date('Y-m-d', strtotime($row['date_of_reg']))) {
					$br++;
				}
			}
			return $br;
		}
		/*** END OF USERS WHO HAVE SIGNED UP TODAY ***/
		/*--- LAST 20 USERS ---*/
		public function last_twenty() {
			$data = array();
			$this->db->order_by("user_id", "desc"); 
			$q = $this->db->get('accounts', 20, 0);
			foreach($q->result_array() as $user) {
				$data[] = $user;
			}
			return $data;
		}
		/*** END OF LAST 20 USERS ***/
		/*--- LOOKING FOR USER ---*/
		public function get_found_user() {
			$dataReturn = array();
			$user 	= $this->input->post('username');
			echo "Търсите за ".$user;
			$query 	= $this->db->query("SELECT user_id, username, email, ip_of_reg, date_of_reg, rank 
										FROM accounts 
										WHERE MATCH(username) 
										AGAINST('$user' IN BOOLEAN MODE)");
			if($query->num_rows()>=1) {
				foreach($query->result_array() AS $row) {
					/*--- GETS ACCOUNT LOGS ---*/
					$this->db->order_by('acc_log_id', 'DESC');
					$q_account_logs = $this->db->get_where('account_logs', array('acc_log_user_id' => $row['user_id']), 5, 0);
					if($q_account_logs->num_rows() >= 1) {
						$row['is_logs'] = 1;
						$row['logs'] = $q_account_logs->result_array();
					} else {
						$row['is_logs'] = 0;
					}
					/**** END of account logs ****/
					
					/*--- GETS USER ACTIONS ---*/
					$this->db->order_by('ua_id', 'DESC');
					$q_activity = $this->db->get_where('users_activity', array('ua_user_id' => $row['user_id']), 20, 0);
					if($q_activity->num_rows() >= 1) {
						$row['is_activity'] = 1;
						$row['activity'] = $q_activity->result_array();
					} else {
						$row['is_activity'] = 0;
					}
					/**** END of user's actions ****/
					$dataReturn[] = $row;
				}
				return $dataReturn;
			} else {
				return FALSE;
			}
		}
		/*** END OF LOOKING FOR USER ***/
	}