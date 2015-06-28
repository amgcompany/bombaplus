<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Profile extends CI_Controller {
		private $user_id, $main;
		public function __construct() {
			parent::__construct();
			/* If the user is not logged in to be redirected */
			if($this->session->userdata('logged_in') != 1) {
				redirect(base_url().'home');
			}
			$this->user_id = $this->session->userdata('user_id');
			
			$this->load->model('left_menu_model');		
			$this->load->model('Profile_model');		
		}
		public function index() {
			redirect(base_url().'profile/'.$this->user_id);
		}
		/*------------------------------------------------
				GETS USER'S ID AND PROFILE
		------------------------------------------------*/
		public function id($id) {
			$left['row'] = $this->left_menu_model->get_user_condtions(); 
			$this->load->model('messages_model');
			$mess['count'] = $this->messages_model->unread_mess(); 
			$prof = $this->Profile_model->get_profile($id);
			$username = $prof[0]['username'];
			$array['title'] = "Профил на $username - Bomba+ "; // Title of the page
			
			$arr = array(
				'user' => $prof,
				'conv' => $this->Profile_model->get_profile_conv($id)
			);
			
			$this->load->vars($array);
			$this->load->vars($mess);
			$this->load->vars($left);
			$this->load->vars($arr);
			
			$this->load->template('profile_view'); 
		}
		/*** END of id ***/
		/*--- UPLOADS PROFILE PICTURE ---*/
		public function upload_avatar($usid) {
			$this->Profile_model->do_upload();
			redirect(base_url().'profile/'.$usid);
		}
		/*** END of UAP ***/
	}