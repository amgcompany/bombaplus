<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Sign_up_model extends CI_Model {
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
		}
		/* INSERT USERS MAIN INFORMATION INTO DB */
		public function insert_into_db() {
			$data = array(
				'username'		=> $this->input->post('reg_username'),
				'password'		=> md5($this->input->post('reg_password')),
				'email'			=> $this->input->post('email'),
				'ip_of_reg'		=> $_SERVER['REMOTE_ADDR'],
				'date_of_reg'	=> date("Y-m-d")
			);
			$this->db->insert('accounts', $data);
			/* INSERTS USER's ID INTO USERS CONDIONS  */
			$this->db->insert('user_conditions', array('uc_user_id' => $this->db->insert_id()));
		}
		/*** END OF insert_into_db() ***/
		
	}