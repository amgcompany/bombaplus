<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Administrators extends CI_Controller {
		public function __construct() {
			parent::__construct();
			if($this->session->userdata('logged_in') != 1 || $this->session->userdata('admin_logged_in') !=1 || $this->session->userdata('rank') != 1) {
				redirect(base_url().'home');
			}
			$this->load->library('form_validation');
			$this->load->model('admin/administrators_model');
		}
		/*-- GETS ALL ADMINISTRATORS --*/
		public function index() {
			$admin['admins'] = $this->administrators_model->get_administrators();
			$this->load->view('admin/administrators_view', $admin);
		}
		/*** end of index() ***/
		/*--- GET LAST 20 LOGIN ATTEMPTS ---*/
		public function login_attempts() {
			$attempts['attempts'] = $this->administrators_model->get_login_attempts();
			$this->load->view('admin/attempts_view', $attempts);
		}
		/*** end of login_attempts ***/
		/*--- LOADS CREATE_ADMIN ---*/
		public function create_admin() {
			$this->load->view('admin/create_admin_view');
		}
		/*** end of create_admin ***/
		/*--- SEARCH FOR USER ---*/
		public function create_admin_search_user() {
			$this->load->model('admin/home_model');
			$res['result'] = $this->home_model->get_found_user();
			$this->load->view('admin/found_user_create_admin', $res);
		}
		/**** END OF SEARCH FOR USER ****/
		/*--- CREATING NEW ADMIN ---*/
		public function create_new_admin() {
			$this->administrators_model->creating_admin();
		}
		/*** END of create_new_admin ***/
		/*--- SEARCH FOR USER ---*/
		public function generate_areas() {
			//$this->load->model('admin/home_model');
			//$res['result'] = $this->home_model->get_found_user();
			$this->load->view('admin/generate_areas_view');
		}
		/*** END OF generate_areas ***/
	}