<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Sell extends CI_Controller {
		private $user_id;
		public function __construct() {
			parent::__construct();
			/* If the user is not logged in to be redirected */
			if($this->session->userdata('logged_in') != 1) {
				redirect(base_url().'home');
			}
			$this->user_id = $this->session->userdata('user_id');
			$this->load->model('Sell_model');
			$this->load->model('left_menu_model');		
		}
		public function index() {
			$left['row'] 			= $this->left_menu_model->get_user_condtions(); 
			$this->load->model('messages_model');
			$mess['count'] 			= $this->messages_model->unread_mess(); 
			$array['title'] 		= "Пусни за продан - Bomba+"; // Title of the page
			
			$arr = array(
				'categories'		=> $this->Sell_model->get_sell_categories()
			);
			
			$this->load->vars($array);
			$this->load->vars($mess);
			$this->load->vars($left);
			$this->load->vars($arr);
			
			$this->load->template('sell_view'); 
		}
		public function get_sell_category() {
			if($this->input->post('val') == 1) {
				$arr = array(
					'products' => $this->Sell_model->get_product_from_category()
				);
				$this->load->view('ajax_included/sell_main_category', $arr);
			} else {
				//redirect(base_url());
			}
		}
		/*--- SELLS THE PRODUCT IN THE SHOp ---*/
		public function sell_it() {
			$res = $this->Sell_model->insert_sell_shop_article();
			$this->load->view('ajax_included/notifications/selling_not', array('notification'=>$res));
		}
		
	}