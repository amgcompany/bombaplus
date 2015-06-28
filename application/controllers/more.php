<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class More extends CI_Controller {
		private $user_id,
				$main;
		public function __construct() {
			parent::__construct();
			/* If the user is not logged in to be redirected */
			if($this->session->userdata('logged_in') != 1) {
				redirect(base_url().'home');
			}
			$this->user_id = $this->session->userdata('user_id');
			$this->load->model('create_buildings_model');
			$this->load->model('main_model');
			$this->load->model('left_menu_model');
			$this->load->model('messages_model');
		}
		public function index() {
			redirect(base_url().'home');
		}
		public function area($area) {
			$left['row'] = $this->left_menu_model->get_user_condtions(); 
			$mess['count'] = $this->messages_model->unread_mess(); 
			$array['title'] = "Информация за имот - Bomba+"; // Title of the page
			$this->main = array(
				'exps' => $this->create_buildings_model->get_expenses($area),
				'profs' => $this->create_buildings_model->get_profits($area)
			); 
			$this->load->vars($array);
			$this->load->vars($mess);
			$this->load->vars($left);
			$this->load->vars($this->main);
			
			$this->load->template('profits_expenses_area_view'); 
		}
		
	}