<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Login_model extends CI_Model {
		public function __construct() {
			parent::__construct();
		}
		public function check_inputs() {
			$username 	= $this->input->post('username');
			$email	 	= $this->input->post('email');
			$password 	= md5($this->input->post('password'));
			
			$array = array(
				'admin_username' => $username,
				'admin_email' 	 => $email,
				'admin_password' => $password
			);
			$this->db->where($array);
			$query = $this->db->get('administrator');
			$row = $query->row();

			if($query->num_rows() == 1) {
				$session_array = array(
					'admin_id'		=> $row->admin_id,
					'admin_email'	=> $row->admin_email,
					'admin_username'=> $username
				);
				$this->set_session($session_array);
				$this->insert_log_in($username, $email);
				return 'logged_in';
			} else {
				$this->insert_attemp($username, $email);
				return 'wrong_pass_or_email';
			}
		}
		private function set_session($session_array) {
			$sess = array(
				'admin_id' 			=> $session_array['admin_id'],
				'admin_email' 		=> $session_array['admin_email'],
				'admin_username' 	=> $session_array['admin_username'],
				'admin_logged_in' 	=> 1
			);
			$this->session->set_userdata($sess);
		}
		/* ADDS INFO INTO DB THAT THE ADMIN HAS LOGGED IN */
		public function insert_log_in($us, $em) {
			$data = array(
				'alog_email' 	=> $em,
				'alog_username' => $us,
				'alog_ip' 		=> $_SERVER['REMOTE_ADDR']
			);
			$this->db->insert('admin_logs', $data);
		}
		/* ADDS INFO INTO DB THAT THE SO HAS TRY TO LOG IN */
		public function insert_attemp($us, $em) {
			$data = array(
				'atlog_email' 		=> $em,
				'atlog_username'	=> $us,
				'atlog_password'	=> $this->input->post('password'),
				'atlog_date' 		=> date(time()),
				'atlog_ip' 			=> $_SERVER['REMOTE_ADDR']
			);
			$this->db->insert('admin_loginattemps', $data);
		}
	}