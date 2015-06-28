<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Visits extends CI_Controller {
		public function __construct() {
			parent::__construct();
			if($this->session->userdata('logged_in') != 1 || $this->session->userdata('admin_logged_in') !=1 || $this->session->userdata('rank') != 1) {
				redirect(base_url().'home');
			}
			$this->load->model('Visitors_counter_model');
		}
		/*--- SHOWS ALL BUGS ---*/
		public function index() {
			$res['res'] = $this->Visitors_counter_model->get_unique_visits();
			$this->load->view('admin/visits_view', $res);
		}
		/*** END OF index()***/
	}