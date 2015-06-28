<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Destroy extends CI_Controller {
		public function __construct() {
			parent::__construct();
			if($this->session->userdata('logged_in') != 1 || $this->session->userdata('admin_logged_in') !=1 || $this->session->userdata('rank') != 1) {
				redirect(base_url().'home');
			}
			$this->load->model('admin/Destroy_model');
		}
		/*--- SHOWS ALL BUGS ---*/
		public function index() {
			//$res['res'] = $this->Destroy->get_unique_visits();
			$this->load->view('admin/destroy_building_view');
		}
		/*** END OF index()***/
		/*------------------------------------------------ 
							DESTROYS 
		------------------------------------------------*/
		public function destroy_it() {
			$this->Destroy_model->destroy_building();
		}
		/*** END OF destroy_it()***/
	}