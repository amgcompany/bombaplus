<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Main extends CI_Controller {
		private $user_id,
				$main;
		public function __construct() {
			parent::__construct();
			/* If the user is not logged in to be redirected */
			if($this->session->userdata('logged_in') != 1) {
				redirect(base_url().'home');
			}
			$this->user_id = $this->session->userdata('user_id');
			$this->count_visitors();
			$this->load->model('create_buildings_model');
			$this->load->model('main_model');
			$this->load->model('left_menu_model');
			$this->load->model('messages_model');
			// gets views for areas and zones
			$this->main = array(
				'zone' 		=> $this->main_model->get_zones(),
				'areas' 	=> $this->main_model->get_it($this->input->post('zone_id')) /* GETS THE AREAS */
			); 
		}
		public function index() {
			$left['row'] = $this->left_menu_model->get_user_condtions(); 
			$mess['count'] = $this->messages_model->unread_mess(); 
			$array['title'] = "Bomba+ Начало"; // Title of the page

			$this->load->vars($array);
			$this->load->vars($mess);
			$this->load->vars($left);
			$this->load->vars($this->main);
			
			$this->load->template('main_view'); 
		}
		/*--- LOADS CENTER AREAS VIEWS ---*/
		public function load_areas_view() {
			$val = $this->input->post('val');
			$res = $this->main_model->get_center_areas_view();
			foreach($res as $row) {
				$row['zone_id'] = $this->input->post('zone_id');
				$this->load->view('areas_views/'.$row['view'], $row);
			}
		}
		/**** END of showing center area's views ****/
		/*--- LOADS LEFT MENU's VIEW ---*/
		public function load_left_menu() {
			$left['row'] = $this->left_menu_model->get_user_condtions();
			$this->load->view('ajax_included/ajax_left_menu', $left);
		}	
		/*--- LOADS MESSAGE CONVERSATIONS ---*/
		public function load_conversations() {
			$messages['row_mess'] = $this->messages_model->get_conversations(); 
			$this->load->view('ajax_included/chat_conversations', $messages);
		}
		/*** END OF load_conversations ***/
		/*--- LOADS ONE MESSAGE CONVERSATIONS WITH HASH ---*/
		public function load_conversation($hash) {
			$conv = array(
				'conv' => $this->messages_model->conversation($hash),
				'select_id'	=> $this->messages_model->get_selected_id()
			);
			$this->load->view('ajax_included/chat_conversation', $conv);
		}
		/*** END OF load_conversations ***/
		/*--- LOADS the DIV #chat_container WITH THE CONTENT OF THE CONVERSATION ---*/
		public function load_chat_container($hash) {
			$conv = array(
				'conv' => $this->messages_model->conversation($hash),
				'select_id'	=> $this->messages_model->get_selected_id()
			);
			$this->load->view('ajax_included/chat_conversation_div', $conv);
		}
		/**** END OF load_chat_container *****/
		/*--- BUYS AMOUNT OF SPACE AREA FOR USER WITH ID session_id ---*/
		public function buy_area() {
			$space = $this->input->post('space');
			$res = $this->main_model->buy_area_model();
			echo $res;
			//$this->load->view('ajax_included/notifications/main/buy_area', array('res' => $res, 'space' => $space));
		}
		/**** END OF buy_areaa *****/
		/*--- 
		|Function loads views for the user to choose what kind of building to build 
		---*/
		public function choose_what_to_build() {
			$zone	 = $this->input->post('zone_id');
			$page	 = $this->input->post('page');
			$res['cats'] = $this->main_model->center_buldings_categories();
			$res = array(
				'zone_id'	=> $zone,
				'page'		=> $page,
				'cats' 		=> $this->main_model->center_buldings_categories()
			);
			$this->load->view('ajax_included/choose_what_to_build_view', $res);
		}
		/**** END of choose_what_to_build() ****/
		
		/*
		###########################################
		#	LOADING VIEWS FOR CREATING BUILDINGS
		###########################################
		*/
		
		/*--- |LOADS VIEW LOAD BUILD APARTMENTS| ---*/
		public function load_view_build_apartments() {	
			$area_id = $this->input->post('area_id');
			$zone_id	 = $this->input->post('zone_id');
			$page	 = $this->input->post('page');
			$arr = array(
				'area_id' 	=> $area_id,
				'zone_id' 	=> $zone_id,
				'page' 		=> $page,
				'row' 		=> $this->create_buildings_model->load_build_mansions()
			);
			$this->load->view('ajax_included/build_apartments', $arr);
		}
		/**** END of load_build_apartments() ****/
		/*--- |LOADS VIEW LOAD ENTERED MANSIONS| ---*/
		public function enter_mansions() {	
			$area_id 	= $this->input->post('area_id');
			$zone_id	 = $this->input->post('zone_id');
			$page		 = $this->input->post('page');
			$arr = array(
				'area_id' => $area_id,
				'zone_id' => $zone_id,
				'page' => $page,
				'row' => $this->create_buildings_model->enter_mansions_model()
			);
			$this->load->view('ajax_included/build_enter_mansions', $arr);
		}
		/**** END of enter_mansions() ****/
		/*--- BUYS MORE AREA ---*/
		public function buy_more_area() {
			$space = $this->input->post('space');
			$res = $this->create_buildings_model->buy_more_area();
			if($res == 'area_bought') {
				$this->load->view('ajax_included/notifications/main/buy_more_area', array('res' => $res, 'space' => $space));
			} else {
				echo $res; /* USING ECHO HERE BECAUSE OF AJAX, IN JS CHECKS WITH hr.responseText */
			}
		}
		/****** END OF buy_more_area *****/
		/*--- BUYS ALLOW TO BUILD ---*/
		public function buy_allow_build() {
			$res = $this->create_buildings_model->buy_allowance();
			echo $res; /* USING ECHO HERE BECAUSE OF AJAX, IN JS CHECKS WITH hr.responseText */
			/*$this->load->view('ajax_included/notifications/main/buy_building_permission', array('res' => $res));*/
		}
		/****** END OF buy_allow_build *****/
		/*--- BUILDS APARTMENTS ---*/
		public function build_apartments() {
			$level = $this->input->post('level');
			$res = $this->create_buildings_model->build_apartments();
			echo $res; /* USING ECHO HERE BECAUSE OF AJAX, IN JS CHECKS WITH hr.responseText */	
		}
		/****** END OF buy_allow_build *****/
		/*----------------------------------------
				UNIQUE COUNTER VISITORS
		------------------------------------------*/
		public function count_visitors() {
			$this->load->model('Visitors_counter_model');
			$page = 'main';
			$this->Visitors_counter_model->count_unique_visitors($page);
		}
		/*** END of count_visitors ***/
		/*--- Logout function ---*/
		public function logout() {
			$this->session->sess_destroy();
			redirect(base_url());
		}
	}