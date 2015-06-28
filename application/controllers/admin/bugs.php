<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Bugs extends CI_Controller {
		public function __construct() {
			parent::__construct();
			if($this->session->userdata('logged_in') != 1 || $this->session->userdata('admin_logged_in') !=1 || $this->session->userdata('rank') != 1) {
				redirect(base_url().'home');
			}
			$this->load->library('form_validation');
			$this->load->model('admin/bugs_model');
		}
		/*--- SHOWS ALL BUGS ---*/
		public function index() {
			$res['res'] = $this->bugs_model->get_bugs();
			$this->load->view('admin/bugs_view', $res);
		}
		/*** END OF index()***/
		/*--- ADD NEW BUGS ---*/
		public function add_bugs() {
			$this->bugs_model->add_bug();
		}
		/*** END OF add_bugs() ***/
		/*--- Make it repaired ---*/
		public function repair_bug($id) {
			$this->bugs_model->repair_bug($id);
		}
		/**** END OF Make it repaired ***/
		/*--- DELETES Bug ---*/
		public function delete_bug($id) {
			$this->bugs_model->delete_bug($id);
		}
		/*--- END OF DELETE_BUG ---*/
	}