<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Login_model extends CI_Model {
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
		}
		public function check_inputs() {
			$username 	= $this->input->post('username');
			$password 	= md5($this->input->post('password'));
			
			$array = array(
				'username' 	=> $username,
				'password'	=> $password
			);
			$this->db->where($array);
			$query = $this->db->get('accounts');
			$row = $query->row();

			if($query->num_rows() == 1) {
				$session_array = array(
					'user_id'	=> $row->user_id,
					'email'		=> $row->email,
					'rank'		=> $row->rank,
					'username'	=> $username
				);
				$this->set_session($session_array);
				$this->logged_in($row->user_id, $username);
				return 'logged_in';
			} else {
				return 'wrong_pass_or_email';
			}
		}
		private function set_session($session_array) {
			$sess = array(
				'user_id' 	=> $session_array['user_id'],
				'email' 	=> $session_array['email'],
				'username' 	=> $session_array['username'],
				'rank' 		=> $session_array['rank'],
				'logged_in' => 1
			);
			$this->session->set_userdata($sess);
		}
		/*--- INSERTS INFO INTO DB THAT THE USERS HAS LOGGED IN ---*/
		private function logged_in($us_id, $usname) {
			$data = array(
				'acc_log_user_id'	=> $us_id,
				'acc_log_username'	=> $usname,
				'acc_log_ip'		=> $_SERVER['REMOTE_ADDR']
			);
			$this->db->insert('account_logs', $data);
		}
		/*--- END OF logged_in ---*/
	}