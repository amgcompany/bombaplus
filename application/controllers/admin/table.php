<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Table extends CI_Controller {
		public function __construct() {
			parent::__construct();
			if($this->session->userdata('logged_in') != 1 || $this->session->userdata('admin_logged_in') !=1 || $this->session->userdata('rank') != 1) {
				redirect(base_url().'home');
			}
		}
		public function index($table) {
			$this->load->model('admin/admin_table_model');
			$res 			= $this->admin_table_model->show_table_columns($table);
			$pass_data = array(
				'table'	  => $table,
				'columns' => $res
			);
			$this->load->view('admin/table_view', $pass_data);
		}
	}