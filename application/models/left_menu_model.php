<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Left_menu_model extends CI_Model {
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
		}
		/*--- GETS USER'S CONDITIONS INOFRMATION ---*/
		public function get_user_condtions() {
			$q = $this->db->get_where('user_conditions', array('uc_user_id' => $this->session->userdata('user_id')));
			$row = $q->row_array();
			return $row;
		}
		/*** END OF get_user_conditions ***/
	}