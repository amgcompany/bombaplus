<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Casino extends CI_Controller {
		private $user_id;
		public function __construct() {
			parent::__construct();
			/* If the user is not logged in to be redirected */
			if($this->session->userdata('logged_in') != 1) {
				redirect(base_url().'home');
			}
			$this->user_id = $this->session->userdata('user_id');
			$this->load->model('Casino_model');
		}
		/*--- LOADS BUILD CASINO ---*/
		public function build_casino() {
			$area_id = $this->input->post('area_id');
			$zone	 = $this->input->post('zone_id');
			$page	 = $this->input->post('page');

			$arr = array(
				'area_id'	=> $area_id,
				'zone_id'	=> $zone,
				'page'		=> $page,
				'row' 		=> $this->Casino_model->load_build_casino($area_id)
			);
			$this->load->view('ajax_included/building_load_casino', $arr);
		}
		/*** END OF LOAD BUILD CASINo ***/
		/*--- INSERT MONEY ---*/
		public function insert_money() {
			$res = $this->Casino_model->money_insert($area_id, $money);
			echo $res; /* USING ECHO HERE BECAUSE OF AJAX, IN JS CHECKS WITH hr.responseText */
		}
		/*** END OF LOAD insert_money ***/
		/*--- INSERT MONEY ---*/
		public function get_casino_money() {
			$res = $this->Casino_model->getting_casino_money();
			echo $res; /* USING ECHO HERE BECAUSE OF AJAX, IN JS CHECKS WITH hr.responseText */
		} 
		/*** END OF LOAD insert_money ***/
		/*--- INSERT MONEY ---*/
		public function insert_more_casino_money() {
			$res = $this->Casino_model->insert_more_money($area_id, $money);
			echo $res; /* USING ECHO HERE BECAUSE OF AJAX, IN JS CHECKS WITH hr.responseText */
		}
		/*** END OF LOAD insert_money ***/
		/*--- BUIDLING CASINO ---*/
		public function create_casino() {
			$res = $this->Casino_model->build_create_casino();
			echo $res; /* USING ECHO HERE BECAUSE OF AJAX, IN JS CHECKS WITH hr.responseText */
		}
		/*** END OF create_casino ***/
		/*--- ENTERS CASINO ---*/
		public function enter_casino() {
			$area_id = $this->input->post('area_id');
			$casino_id = $this->input->post('casino_id');
			$val	 = $this->input->post('val');
			$zone	 = $this->input->post('zone_id');
			$page	 = $this->input->post('page');
			
			if($val == 1) {
				$arr = array(
					'area_id'	=> $area_id,
					'zone_id'	=> $zone,
					'casino_id'	=> $casino_id,
					'page'		=> $page,
					'row' 		=> $this->Casino_model->load_enter_casino($area_id, $casino_id)
				);
				$this->load->view('ajax_included/building_enter_casino', $arr);
			} else {
				redirect(base_url());
			}
		}
		/**** END OF ENTER CASINO ****/
		/*---MAKES THE BET ---*/
		public function make_bet() {
			$res = $this->Casino_model->casino_bet();
			echo $res; /* USING ECHO HERE BECAUSE OF AJAX, IN JS CHECKS WITH hr.responseText */
		}
		/**** END OF make_bet ****/
		/*--- CHECKS WHAT IS THE PRIZE ---*/
		public function check_prize() {
			$res = $this->Casino_model->check_for_prize();
			echo $res; /* USING ECHO HERE BECAUSE OF AJAX, IN JS CHECKS WITH hr.responseText */
		}
		/**** END OF make_bet ****/
		/*--- CHANGES CASINO's PRIZE ---*/
		public function change_casino_prize() {
			$res = $this->Casino_model->change_prize();
			echo $res; /* USING ECHO HERE BECAUSE OF AJAX, IN JS CHECKS WITH hr.responseText */
		}
		/**** END OF change_casino_prize ****/
	}