<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Home extends CI_Controller {
		private $er;
		public function __construct() {
			parent::__construct();
			if($this->session->userdata('logged_in') == 1) {
				redirect(base_url().'main');
			}
			$this->load->library('form_validation');
			$this->er = 0;
		}
		public function index() {
			$array['title'] = "Bomba+"; // Title of the page
			$er['er'] = $this->er;
			$this->load->view('includes/header', $array);
			$this->load->view('home_view', $er);
			$this->load->view('includes/home_footer');
			$this->count_visitors();
		}
		/* LOGIN Controller */
		public function login() {
			$this->form_validation->set_rules('username', 'Потребителско име', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Парола', 'trim|required|xss_clean');
			
			$this->form_validation->set_message('required','Полето <b>%s</b> е задължително');

			if($this->form_validation->run() == FALSE) {
				$this->index();
			} else {
				$this->load->model('login_model');
				$res = $this->login_model->check_inputs();
				
				switch($res) {
					case 'wrong_pass_or_email':
						$this->er = 4;
						$this->index();
					break;
					case 'logged_in':
						redirect(base_url().'main');
					break;
				}
			}
		}
		/*** END OF LOGIN Controller ***/
		/* SIGN UP Controller */
		public function register() {	
			$this->form_validation->set_rules('reg_username', 'потребителско име', 'trim|required|xss_clean|callback_check_type|is_unique[accounts.username]|callback_validate_member|callback_username_str');	
			$this->form_validation->set_rules("email", "електронна поща", "trim|required|valid_email|xss_clean");
			$this->form_validation->set_rules('reg_password', 'парола', 'trim|required|min_length[4]|max_length[32]|xss_clean|callback_validate_password');
			$this->form_validation->set_rules('creg_password', 'потвърдждаване на парола', 'trim|required|min_length[4]|max_length[32]|matches[reg_password]|xss_clean');					
			
			$this->form_validation->set_message('is_unique', 'Вече има регистрация с това потребителско име');
			$this->form_validation->set_message('valid_email', 'Невалидна електронна поща');
			$this->form_validation->set_message('required', 'Полето <b>%s</b> е задължително');
			$this->form_validation->set_message('matches', 'Паролите не съвпадат');
			$this->form_validation->set_message('min_length', 'Минимум 4 символа за парола');
			$this->form_validation->set_message('max_length', 'Максимум 32 символа за парола');
			
			if($this->form_validation->run() == FALSE) {
				$this->er = 1;
				$this->index();
			} else {
				$this->load->model('sign_up_model');
				$this->sign_up_model->insert_into_db();
				$this->er = 2;
				$this->index();
			}
		}
		/* END OF SIGN UP */
		/* LENGTH OF username */
		public function username_str() {
			if(mb_strlen($this->input->post('reg_username'), "UTF-8")<4) {
				$this->form_validation->set_message('username_str', 'Минимум 4 символа за потребителско име');
				return FALSE;
			} else if (mb_strlen($this->input->post('reg_username'), "UTF-8")>20)  {
				$this->form_validation->set_message('username_str', 'Максимум 20 символа за потребителско име');
				return FALSE;
			}
			else {
				return TRUE;
			}
		}
		/* VALIDATION OF username */
		function validate_member() {
			if($this->input->post('reg_username') == 'Потребителско име') {
				$this->form_validation->set_message('validate_member', 'Невалидно потребителско име');
				return FALSE;
			}
			else {
				return TRUE;
			}
		}
		/* VALIDATION OF password */
		function validate_password() {
			if($this->input->post('reg_password') == 'Парола' || $this->input->post('reg_password') == 'Потвърди парола') {
				$this->form_validation->set_message('validate_password', 'Невалидна парола');
				return FALSE;
			}
			else {
				return TRUE;
			}
		}
		/*----------------------------------------
				UNIQUE COUNTER VISITORS
		------------------------------------------*/
		public function count_visitors() {
			$this->load->model('Visitors_counter_model');
			$page = 'home';
			$this->Visitors_counter_model->count_unique_visitors($page);
		}

	}