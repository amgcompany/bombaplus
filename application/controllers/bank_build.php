<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Bank_build extends CI_Controller {
		private $user_id;
		public function __construct() {
			parent::__construct();
			/* If the user is not logged in to be redirected */
			if($this->session->userdata('logged_in') != 1 && $this->session->userdata('rank') != 1) {
				redirect(base_url().'home');
			}
			$this->user_id = $this->session->userdata('user_id');
			$this->load->model('build_bank_model');
		}
		/*--- LOADS BULDING BANK ---*/
		public function load_build() {
			$area_id 	= $this->input->post('area_id');
			$val		= $this->input->post('val');
			$zone 		= $this->input->post('zone_id');
			$page 		= $this->input->post('page');
			
			if($val == 1) {
				$arr = array(
					'area_id' 	=> $area_id,
					'zone_id' 	=> $zone,
					'page' 		=> $page,
					'row'		=> $this->build_bank_model->bank_administration($area_id),
					'credits'	=> $this->build_bank_model->bank_credits($area_id)
				);
				$this->load->view('ajax_included/build_bank_view', $arr);
			} else {
				redirect(base_url());
			}
		}
		/**** END OF load_build() ****/
		/*--- BUILDS/CREATES BANK ---*/
		public function build_bank() {
			$res = $this->build_bank_model->create_bank();
		}
		/**** END OF BUILD BANK ****/
		/*--- ENTERS INTO THE BANK ---*/
		public function enter_bank() {
			$area_id = $this->input->post('area_id');
			$val	 = $this->input->post('val');
			$sum	 = $this->input->post('sum');
			$bank_id = $this->input->post('bank_id');
			$zone 		= $this->input->post('zone_id');
			$page 		= $this->input->post('page');
			
			if($val == 1) {
				$arr = array(
				'area_id'	=> $area_id,
				'bank_id'	=> $bank_id,
				'zone_id' 	=> $zone,
				'page' 		=> $page,
				'credit'	=> $this->build_bank_model->is_credit_downlaoded($area_id, $bank_id), // area_id, bank_id
				'payments'	=> $this->build_bank_model->credit_payments($area_id, $bank_id)
			);
				$this->load->view('ajax_included/enter_bank_view', $arr);
			} else {
				redirect(base_url());
			}
		}
		/**** END OF eneter_bank ****/
		/*--- GETS FAST CREDIT UP TO 5000 ---*/
		public function get_fast_credit() {
			$res = $this->build_bank_model->get_credit_fast();
			echo $res; /* USING ECHO HERE BECAUSE OF AJAX, IN JS CHECKS WITH hr.responseText */
		}
		/*** END OF get_fast_Credit ***/
		/*--- PAYS CREDIT ---*/
		public function credit_payment() {
			$res = $this->build_bank_model->pay_credit();
			echo $res; /* USING ECHO HERE BECAUSE OF AJAX, IN JS CHECKS WITH hr.responseText */
		}
		/*** END OF credit_payment ***/
	}