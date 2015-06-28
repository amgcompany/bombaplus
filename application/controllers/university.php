<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class University extends CI_Controller {
		private $user_id;
		public function __construct() {
			parent::__construct();
			/* If the user is not logged in to be redirected */
			if($this->session->userdata('logged_in') != 1) {
				redirect(base_url().'home');
			}
			$this->user_id = $this->session->userdata('user_id');
			$this->load->model('University_model');
			$this->load->model('left_menu_model');		
		}
		public function index() {
			$left['row'] = $this->left_menu_model->get_user_condtions(); 
			$this->load->model('messages_model');
			$mess['count'] = $this->messages_model->unread_mess(); 
			$array['title'] = "Университет - Bomba+"; // Title of the page
			
			$this->load->view('includes/header', $array);
			$this->load->view('includes/log_header', $mess);
			$this->load->view('includes/leftmenu', $left);
			$arr = array(
				'uni_id'	=> 1,
				'row'		=> $this->University_model->load_university(1)
			);
			$this->load->view('university_view', $arr);
			$this->load->view('includes/footer');
		}
		/*--- LOADS BUILDING THE University ONLY FOR THE ADMINS ---*/
		public function load_build_university() {
			$area_id = $this->input->post('area_id');
			$val	 = $this->input->post('val');
			if($val == 1 && $this->session->userdata('rank') == 1) {
				$arr = array(
					'area_id'	=> $area_id
				);
				$this->load->view('ajax_included/building_load_university', $arr);
			} else {
				redirect(base_url());
			}
		}
		/**** END OF LOAD_BUILD_UNIVERSITY ****/
		/*---- MAKES CONNECTON WITH THE MODEL TO BUILD THE University ----*/
		public function building_university() {
			$res = $this->University_model->build_university();
		}
		/**** END OF building_university ****/
		/*--- LOADS UNIVERSITY'S ADMINISTRATIONS ---*/
		public function load_university_administration() {
			$area_id = $this->input->post('area_id');
			$uni_id  = $this->input->post('uni_id');
			
			$arr = array(
				'area_id'	=> $area_id,
				'uni_id'	=> $uni_id,
				'row'		=> $this->University_model->university_administration($area_id, $uni_id)
			);
			$this->load->view('ajax_included/build_uni_administration', $arr);
		}
		/*** END OF load_university_administration ***/
		/*--- ADDING UNI SPECIALTY ---*/
		public function add_uni_specialty() {
			$this->University_model->add_university_specialty($uni_id, $spec, $prize);
		}
		/*** END of add_uni_specialty ***/
		/*--- ADDING QUESTION ---*/
		public function add_university_question() {
			$res = $this->University_model->add_question_validation();
			echo $res;
		}
		/*** END of adding_quesiton ***/
		/*---- STARTING EDUCATION SPECIALTY ----*/
		public function start_education() {
			$val	 = $this->input->post('val');
			if($val == 1) {
				$res = $this->University_model->start_study_specialty();
				echo $res;
			} else {
				exit();
			}
		}
		/**** END OF start_education ****/
		/*--- THE TEST ---*/
		public function test($spec_id) {
			$this->University_model->check_permission_for_test($spec_id);
			$left['row'] = $this->left_menu_model->get_user_condtions(); 
			$this->load->model('messages_model');
			$mess['count'] = $this->messages_model->unread_mess(); 
			$array['title'] = "Тест - Университет - Bomba+"; // Title of the page
			
			$this->load->view('includes/header', $array);
			$this->load->view('includes/log_header', $mess);
			$this->load->view('includes/leftmenu', $left);
			$this->load->view('university_test_view', array('spec_id'=>$spec_id));
			$this->load->view('includes/footer');
		}
		/*** END OF THE TEST ***/
		/*-- FIRST LEVEL QUESTION --*/
		public function get_question_first_level() {
			$res['row'] = $this->University_model->uni_level_question();
			$this->load->view('ajax_included/question_first_level', $res);
		}
		/*** END OF FIRST LEVEL QUESTION ***/
		/*---- GETTING TESTS RESULT ----*/
		public function test_results() {
			$res = $this->University_model->check_test_results();
			$arr = array(
				'is_passed' => $res,
				'result'	=> $this->input->post('result')
			);
			$this->load->view('ajax_included/is_test_passed', $arr);
			
		}
	}