<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Living_area extends CI_Controller {
		private $user_id, $main;
		public function __construct() {
			parent::__construct();
			/* If the user is not logged in to be redirected */
			if($this->session->userdata('logged_in') != 1) {
				redirect(base_url().'home');
			}
			$this->user_id = $this->session->userdata('user_id');
			
			$this->load->model('left_menu_model');	
			$this->load->model('main_model');		
			$this->load->model('Living_area_model');		
		}
		public function index() {
			$left['row'] = $this->left_menu_model->get_user_condtions(); 
			$this->load->model('messages_model');
			$mess['count'] = $this->messages_model->unread_mess(); 
			$array['title'] = "Жилищен квартал - Bomba+"; // Title of the page
			
			$arr = array(
				'zone' => $this->main_model->get_zones(),
				'areas' => $this->Living_area_model->get_living_areas_view()
			);
			
			$this->load->vars($array);
			$this->load->vars($mess);
			$this->load->vars($left);
			$this->load->vars($arr);
			
			$this->load->template('living_area_view'); 
		}
	}