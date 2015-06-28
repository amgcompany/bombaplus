<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Industrial extends CI_Controller {
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
			$this->load->model('Industrial_model');		
			$this->load->model('Dairy_farm_model');		
		}
		public function index() {
			$left['row'] = $this->left_menu_model->get_user_condtions(); 
			$this->load->model('messages_model');
			$mess['count'] = $this->messages_model->unread_mess(); 
			$array['title'] = "Индустриална зона - Bomba+"; // Title of the page
			$arr = array(
				'zone' => $this->main_model->get_zones(),
				'areas' => $this->Industrial_model->get_industrial_areas_view()
			);
			
			$this->load->vars($array);
			$this->load->vars($mess);
			$this->load->vars($left);
			$this->load->vars($arr);
			
			$this->load->template('industrial_area_view'); 
		}
		/*------------------------------------------------------------ 
			# BUYS AMOUNT OF SPACE AREA FOR USER WITH ID session_id #
		-------------------------------------------------------------*/
		public function buy_area() {
			$space = $this->input->post('space');
			$res = $this->Industrial_model->buy_area_model();
			echo $res;
			//$this->load->view('ajax_included/notifications/main/buy_area', array('res' => $res, 'space' => $space));
		}
		/***** END OF BUY AREA ****/
		/*------------------------------------------------------------ 
				# LOADS VIEW OF BUILDING DAIRY FARM (COWS) #
		-------------------------------------------------------------*/
		public function load_build_cow() {
			$area_id 		= $this->input->post('area_id');
			$zone_id	 	= $this->input->post('zone_id');
			$page	 		= $this->input->post('page');
			$arr = array(
				'area_id' => $area_id,
				'zone_id' => $zone_id,
				'page' 	  => $page,
				'row' => $this->Dairy_farm_model->load_build_dairy_farm()
			);
			$this->load->view('ajax_included/dairy_farm/build_dairy_farm', $arr);
		}
		/***** END OF dairy farm BUILDIGN VIEW ****/
		/*------------------------------------------------------------ 
						# BUILDS DAIRY FARM #
		-------------------------------------------------------------*/
		public function build_dairy_farm() {
			$res = $this->Dairy_farm_model->build_the_dairy_farm();
			echo $res; /* USING ECHO BECAUSE OF AJAX */
		}
		/***** END OF build_dairy_farm() ****/
	}