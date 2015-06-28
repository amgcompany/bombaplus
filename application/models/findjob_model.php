<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Findjob_model extends CI_Model {
		private $user_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			$this->user_id = $this->session->userdata('user_id');
			$this->load->model('create_buildings_model');
			
			$this->checks();
		}
		public function checks() {
			if($this->create_buildings_model->us_con('uc_job') == 1) {
				redirect(base_url().'job');
			}
		}
		/*---------------------------------------------------------
						# GETS ALL JOBS #
		-----------------------------------------------------------*/
		public function get_jobs() {
			$data = array();
			/*------------------------------
			CHECKS IF THE USER HAS EDUCATION 3
			--------------------------------*/
			$q_edu = $this->db->get_where('education', array('edu_user_id' => $this->user_id, 'edu_spec_id' => 3));
			$row['education'] = $q_edu->num_rows();
			if($row['education'] >= 1) {
				/*--- GETS JOBS ---*/
				$q_get_jobs = $this->db->get('job_offers');
				$data['jobs'] = $q_get_jobs->result_array();
			}
			$data[] = $row;
			return $data;
		}
		/*** END OF GETTING ALL JOBS ***/
		
		/*---------------------------------------------------------
						# STARTING JOBS #
		-----------------------------------------------------------*/
		public function job_start() {
			/*-- INSERTS THE JOB INTO job_started --*/
			$job_id = $this->input->post('job_offer_id');
			$arr_data = array(
				'js_job_offer_id'	=> $job_id,
				'js_user_id'		=> $this->user_id,
				'js_date_started'	=> date(time())
			);
			$this->db->insert('job_started', $arr_data);
			
			/*-- UPDATES users_condtions, user already has a job --*/
			$this->db->where('uc_user_id', $this->user_id);
			$this->db->update('user_conditions', array('uc_job' => 1));
			redirect(base_url().'job');
		}
		/*** END of job_start ***/
		
	}