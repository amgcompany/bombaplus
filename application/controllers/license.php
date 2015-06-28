<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class License extends CI_Controller {
		private $user_id;
		public function __construct() {
			parent::__construct();
			/* If the user is not logged in to be redirected */
			if($this->session->userdata('logged_in') != 1) {
				redirect(base_url().'home');
			}
			$this->user_id = $this->session->userdata('user_id');
			$this->load->model('License_model');
			$this->load->model('left_menu_model');
			$this->load->model('messages_model');
		}
		public function index() {
			$left['row'] = $this->left_menu_model->get_user_condtions(); 
			$mess['count'] = $this->messages_model->unread_mess(); 
			$array['title'] = "Комисии за лиценз Bomba+"; // Title of the page
			$lic = array(
				'casino' 	=> $this->License_model->check_type_license(1), 
				'gold' 		=> $this->License_model->check_type_license(2), 
				'oil' 		=> $this->License_model->check_type_license(3) 
			);
			
			$this->load->vars($array);
			$this->load->vars($mess);
			$this->load->vars($left);
			$this->load->vars($lic);
			
			$this->load->template('license_view'); 
		}
		/* BUYS License */
		public function buy_license() {
			$res = $this->License_model->buy_license_type();
			echo $res;
		}
	}