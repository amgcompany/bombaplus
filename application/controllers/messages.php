<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Messages extends CI_Controller {
		public function __construct() {
			parent::__construct();
			/* If the user is not logged in to be redirected */
			if($this->session->userdata('logged_in') != 1) {
				redirect(base_url().'home');
			}
			$this->load->model('left_menu_model');
			$this->load->model('messages_model');
		}
		public function index() {
			$left['row'] = $this->left_menu_model->get_user_condtions(); 
			$messages['row_mess'] = $this->messages_model->get_conversations(); 
			$mess['count'] = $this->messages_model->unread_mess(); 
			$array['title'] = "Bomba+ Съобщения"; // Title of the page
			
			$this->load->vars($array);
			$this->load->vars($mess);
			$this->load->vars($left);
			$this->load->vars($messages);
			
			$this->load->template('messages_view'); 
		}
		public function conversation($hash) {
			$left['row'] = $this->left_menu_model->get_user_condtions(); 
			$mess['count'] = $this->messages_model->unread_mess(); 
			$conv = array(
				'conv' => $this->messages_model->conversation($hash),
				'select_id'	=> $this->messages_model->get_selected_id()
			);
			$array['title'] = "Bomba+ Съобщения"; // Title of the page
			
			$this->load->vars($array);
			$this->load->vars($mess);
			$this->load->vars($left);
			$this->load->vars($conv);
			
			$this->load->template('conversation_view'); 
		}
		public function send_message() {
			$this->messages_model->write_message();
			echo "Вашето съобщение беше изпратено успешно";
		}
		public function send_mess() {
			$this->load->view('send_mess');
		}
	}