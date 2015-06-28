<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Add_category_buildng extends CI_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			/* If the user is not logged in to be redirected */
			/* CHECKS IF THE USER IS ADMIN and logged in */
			if($this->session->userdata('logged_in') != 1 || $this->session->userdata('admin_logged_in') !=1 || $this->session->userdata('rank') != 1) {
				redirect(base_url().'home');
			}
			
		}
		public function index() {
			/*all db tables*/
			$this->load->model('admin/home_model');
			$res['res'] = $this->home_model->get_tables();
			$this->load->model('messages_model');
			$mess['count'] = $this->messages_model->unread_mess();
			
			$array['title'] = "АДМИН - Добавяне на категория"; // Title of the page
			$this->load->view('includes/header', $array);
			$this->load->view('includes/log_header', $mess);
			$this->load->view('admin/add_cat_building');
			$this->load->view('admin/leftlinks', $res);
			$this->load->view('includes/footer');
		}
		/* MAKES CONNECTION WITH MODEL TO INSERT THE CATEGORIES INTO DB */
		public function add() {
			$this->form_validation->set_rules('cat_type', 'Тип категория', 'required|xss_clean|trim|callback_cat_validation');
			$this->form_validation->set_rules('cat_build', 'Категория', 'required|xss_clean|trim|min_length[3]');
			if($this->form_validation->run() == FALSE) {
				$this->index();
			} else {
				$this->load->model('admin/category_insert_model');
				$this->category_insert_model->insert();
				redirect(base_url().'admin/add_category_buildng');
			}
		}
		function cat_validation() {
			if($this->input->post('cat_type')>0 && $this->input->post('cat_type')<=3) {
				return TRUE;
			} else {
				$this->form_validation->set_message('cat_validation', 'Невалидна категория');
				return FALSE;
			}
		}
	}