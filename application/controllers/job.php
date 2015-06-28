<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Job extends CI_Controller {
		private $user_id, $main;
		public function __construct() {
			parent::__construct();
			/* If the user is not logged in to be redirected */
			if($this->session->userdata('logged_in') != 1) {
				redirect(base_url().'home');
			}
			$this->user_id = $this->session->userdata('user_id');
			
			$this->load->model('left_menu_model');		
			$this->load->model('Job_model');		
		}
		public function index() {
			$left['row'] = $this->left_menu_model->get_user_condtions(); 
			$this->load->model('messages_model');
			$mess['count'] = $this->messages_model->unread_mess(); 
			$array['title'] = "Работа - Bomba+"; // Title of the page
			
			$arr = array(
				'job' => $this->Job_model->get_the_job()
			);
			
			$this->load->vars($array);
			$this->load->vars($mess);
			$this->load->vars($left);
			$this->load->vars($arr);
			
			$this->load->template('job_view'); 
		}
		/*------------------------------------------------------------
							# LAODS AJAX VIEW #
		--------------------------------------------------------------*/
		public function load_view() {
			$arr = array(
				'job' => $this->Job_model->get_the_job()
			);
			$this->load->view('ajax_included/job/job_ajax_view', $arr);
		}
		/*** END OF load_view() ***/
		/*------------------------------------------------------------
							# WORK, getting salary #
		--------------------------------------------------------------*/
		public function work() {
			$res = $this->Job_model->working();
			echo $res;
		}
		/*** END of work ***/
		/*------------------------------------------------------------
							# QUIT JOB #
		--------------------------------------------------------------*/
		public function quit_job() {
			$res = $this->Job_model->quiting_job();
			echo $res;
		}
	}