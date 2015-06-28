<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Login extends CI_Controller {
		private $er;
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			/* If the user is not logged in to be redirected */
			if($this->session->userdata('logged_in') != 1) {
				redirect(base_url().'home');
			}
			/* CHECKS IF THE USER IS ADMIN */
			if($this->session->userdata('rank') != 1) {
				redirect(base_url().'home');
			}
			/* CHEKS IF THE USER ADMIN IS LOGGED IN */
			if($this->session->userdata('admin_logged_in') == 1) {
				redirect(base_url().'admin/home');
			}
			/* var for errors in the view */
			$this->er = 0;
			$this->load->model('admin/login_model');
			$this->load->model('messages_model');
		}
		public function index() {
			$mess['count'] = $this->messages_model->unread_mess(); 
			$array['title'] = "АДМИН Вход"; // Title of the page
			$this->load->view('includes/header', $array);
			$this->load->view('includes/log_header', $mess);
			$this->load->view('admin/login', array('error' => $this->er));
			$this->load->view('includes/footer');
		}
		/* LOGIN Controller */
		public function sigin() {
			$this->form_validation->set_rules('username', 'Потребителско име', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Парола', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Електронна поща', 'trim|required|xss_clean|valid_email');
			
			$this->form_validation->set_message('required','Полето <b>%s</b> е задължително');

			if($this->form_validation->run() == FALSE) {
				$this->index();
			} else {	
				$res = $this->login_model->check_inputs();
				
				switch($res) {
					case 'wrong_pass_or_email':
						$this->er = 1;
						$this->index();
					break;
					case 'logged_in':
						redirect(base_url().'admin/home');
					break;
				}
			}
		}
		/*** END OF LOGIN Controller ***/
	}