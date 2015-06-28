<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Home extends CI_Controller {
		public function __construct() {
			parent::__construct();
			if($this->session->userdata('logged_in') != 1 || $this->session->userdata('rank') != 1) {
				redirect(base_url().'home');
			}
			if($this->session->userdata('admin_logged_in') != 1 &&  $this->session->userdata('rank') == 1) {
				redirect(base_url().'admin/login');
			}
			$this->load->library('form_validation');
			$this->load->model('admin/home_model');
			$this->load->model('messages_model');
		}
		public function index() {
			/*all db tables*/
			$res['res'] = $this->home_model->get_tables();
			$mess['count'] = $this->messages_model->unread_mess();
			
			$array['title'] = "АДМИН Начало"; // Title of the page
			$this->load->view('includes/header', $array);
			$this->load->view('includes/log_header', $mess);
			$this->load->view('admin/leftlinks', $res);
			$this->load->view('admin/home');
			$this->load->view('includes/footer');
		}
		/* GETS USERS FOR ADMIN PANEL */
		public function users() {
			$res 			= $this->home_model->get_users_number();
			$today_sign 	= $this->home_model->today_signed_up();
			$last_twenty	= $this->home_model->last_twenty();
			$data_to_pass = array(
				'all_users'		=> $res, 
				'today_sign'	=> $today_sign,
				'last_tw'		=> $last_twenty
			);
			$this->load->view('admin/users_view', $data_to_pass);
		}
		/*--- SEARCH FOR USER ---*/
		public function search_user() {
			$res['result'] = $this->home_model->get_found_user();
			$this->load->view('admin/found_user_view', $res);
		}
		/*--- END OF SEARCH FOR USER ---*/
	}