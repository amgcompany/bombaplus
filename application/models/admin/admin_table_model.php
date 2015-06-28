<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Admin_table_model extends CI_Model {
		public function __construct() {
			parent::__construct();
		}
		/* SHOWS TABLE's COLUMNS  */
		public function show_table_columns($table) {
			$data = array();
			$q = $this->db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'bombaplu_bombaplus' AND TABLE_NAME = '$table';");
			foreach($q->result_array() as $row) {
				$data[] =  $row['COLUMN_NAME'];
			}
			return $data;
		}
	}