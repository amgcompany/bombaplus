<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Areas extends CI_Controller {
		public function __construct() {
			parent::__construct();
			if($this->session->userdata('logged_in') != 1 || $this->session->userdata('admin_logged_in') !=1 || $this->session->userdata('rank') != 1) {
				redirect(base_url().'home');
			}
			$this->load->library('form_validation');
			$this->load->model('admin/administrators_model');
		}
		/*-- LOADS generate_areas_view --*/
		public function index() {
			$this->load->view('admin/generate_areas_view');
		}
		/*** end of index() ***/
		/*--- Generates AREAS ---*/
		public function generate_areas() {
			$this->load->model('admin/areas_model');
			$this->areas_model->create_areas();
		}
		/*** end of index() ***/

	}