<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Apartments extends CI_Controller {
		private $user_id,
				$main;
		public function __construct() {
			parent::__construct();
			/* If the user is not logged in to be redirected */
			if($this->session->userdata('logged_in') != 1) {
				redirect(base_url().'home');
			}
			$this->user_id = $this->session->userdata('user_id');
			$this->load->model('create_buildings_model');
		}
		/*--- DEFINES THE PRIZE OF THE APARTMENT ----*/
		public function define_prize() {
			$res = $this->create_buildings_model->update_price();
			$this->load->view('ajax_included/notifications/apartments/define_prize', array('res' => $res));
		}
		/**** END of define_prize() ****/
		/*--- DEFINES THE PRIZE OF THE APARTMENT ----*/
		public function buy_apartment() {
			$res = $this->create_buildings_model->buy_apartment_model();
			echo $res; /* USING ECHO HERE BECAUSE OF AJAX, IN JS CHECKS WITH hr.responseText */
		}
		/**** END of define_prize() ****/
		/*--- GIVES THE OPPORTUNITY OF THE MANSIONS OWNER TO LIVE IN HIS OWN BUIDLING ----*/
		public function live_here() {
			$this->create_buildings_model->live_here_model();
		}
		/**** END of live_here() ****/
		/*---SETS APARTMENT TO FREE ----*/
		public function set_free_apartment() {
			$this->create_buildings_model->set_free_apartment_model();
		}
		/**** END of live_here() ****/
	}