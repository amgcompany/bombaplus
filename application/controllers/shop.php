<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Shop extends CI_Controller {
		private $user_id;
		public function __construct() {
			parent::__construct();
			/* If the user is not logged in to be redirected */
			if($this->session->userdata('logged_in') != 1) {
				redirect(base_url().'home');
			}
			$this->user_id = $this->session->userdata('user_id');
			
			$this->load->model('left_menu_model');	
			$this->load->model('Shop_model');		
		}
		public function index() {
			$left['row'] = $this->left_menu_model->get_user_condtions(); 
			$this->load->model('messages_model');
			$mess['count'] = $this->messages_model->unread_mess(); 
			$array['title'] = "Пазар - Bomba+"; // Title of the page
			$arr = array(
				'articles'	=> $this->Shop_model->get_shop_article()
			);
			$this->load->vars($array);
			$this->load->vars($mess);
			$this->load->vars($left);
			$this->load->vars($arr);
			
			$this->load->template('shop_view'); 
		}
		/*---- BUYS PRODUCT ----*/
		public function buy_product() {
			$res = $this->Shop_model->buy_shop_product();
			$this->load->view('ajax_included/notifications/shop/buy_product', array('res' => $res));
		}
		/**** END OF buy_product() ****/
		/*--- DELETES ARTICLES ---*/
		public function delete_article() {
			$this->Shop_model->delete_shop_article();
		}
		/**** END OF DELETING PRODUCT'S ARTICLES ****/
	}