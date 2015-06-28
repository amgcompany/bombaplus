<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Findjob extends CI_Controller {
		private $user_id, $main;
		public function __construct() {
			parent::__construct();
			/* If the user is not logged in to be redirected */
			if($this->session->userdata('logged_in') != 1) {
				redirect(base_url().'home');
			}
			$this->user_id = $this->session->userdata('user_id');
			
			$this->load->model('left_menu_model');		
			$this->load->model('Findjob_model');		
		}
		public function index() {
			$left['row'] = $this->left_menu_model->get_user_condtions(); 
			$this->load->model('messages_model');
			$mess['count'] = $this->messages_model->unread_mess(); 
			$array['title'] = "Намери работа - Bomba+"; // Title of the page
			
			$arr = array(
				'jobs' => $this->Findjob_model->get_jobs()
			);
			
			$this->load->vars($array);
			$this->load->vars($mess);
			$this->load->vars($left);
			$this->load->vars($arr);
			
			$this->load->template('findjob_view'); 
		}
		/*-------------------------------------------------------
							# STARTING JOB #
		--------------------------------------------------------*/
		public function start_job() {
			$this->Findjob_model->job_start();
		}
	}