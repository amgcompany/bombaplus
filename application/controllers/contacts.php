<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Contacts extends CI_Controller {
		public function __construct() 
		{
			parent::__construct();

		}
		public function index() 
		{
			$this->load->model('messages_model');
			$mess['count'] = $this->messages_model->unread_mess(); 
			$array['title'] = "Контакти - Bomba+"; // Title of the page
			
			$this->load->view('includes/header', $array);
			if($this->session->userdata('logged_in') == 1) {
				$this->load->view('includes/log_header', $mess);
			} else {
				$this->load->view('includes/header', $mess);
				$this->load->view('includes/contacts_header', $mess);
			}
			$this->load->view('contacts_view');
			$this->load->view('includes/home_footer');
		}
		public function sendemail() 
		{
			$this->load->model('contacts_model');
			$res = $this->contacts_model->send_email();
			
			if($res == 'doesnt_run') 
			{
				$this->index();
			} else {
				echo "Sent successfully";
			}
		}
	}