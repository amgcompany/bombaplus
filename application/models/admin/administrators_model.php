<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Administrators_model extends CI_Model {
		public function __construct() {
			parent::__construct();
		}
		/*---- GETS ALL ADMINISTRATORS FROM THE DB TABLE administrator ----*/
		public function get_administrators() {
			$data = array();
			$this->db->select('*');
			$this->db->order_by('admin_id', 'DESC');
			$q = $this->db->get('administrator');
			foreach($q->result_array() AS $row) {
				$data[] = $row;
			}
			return $data;
		}
		/**** end of get_administrators ****/
		/*---- GETS LAST 20 LOGIN ATTEMPTS ----*/
		public function get_login_attempts() {
			$data = array();
			$this->db->select('*');
			$this->db->order_by('atlog_id', 'DESC');
			$q = $this->db->get('admin_loginattemps');
			foreach($q->result_array() AS $row) {
				$data[] = $row;
			}
			return $data;
		}
		/**** end of get_administrators ****/
		/*---- CREATING NEW ADMIN ----*/
		public function creating_admin() {
			$pass = $this->input->post('password_admin');
			$pass2 = $this->input->post('cpassword_admin');
			$email = $this->input->post('email');
			$user = $this->input->post('username');
			$user_id = $this->input->post('userid');
			if($pass == $pass2) {
				$arr = array(
					'admin_email'		=> $email,
					'admin_username'	=> $user,
					'admin_password'	=> md5($pass),
					'admin_added_ip'	=> $_SERVER['REMOTE_ADDR'],
				);
				$this->db->insert('administrator', $arr);
				
				/*--- UPDATES rank in accounts ---*/
				$this->db->where('user_id', $user_id);
				$this->db->update('accounts', array('rank' => 1));
				redirect(base_url().'admin');
			} else {
				return 'Passwords dont match';
			}
		}
		/**** end of creating_admin() ****/
	}