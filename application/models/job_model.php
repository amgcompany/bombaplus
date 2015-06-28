<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Job_model extends CI_Model {
		private $user_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			$this->user_id = $this->session->userdata('user_id');
			$this->load->model('create_buildings_model');
			
			$this->checks();
		}
		public function checks() {
			if($this->create_buildings_model->us_con('uc_job') != 1) {
				redirect(base_url().'findjob');
			}
		}
		/*-----------------------------------------------------------
							GETS USER'S JOB
		-----------------------------------------------------------*/
		public function get_the_job() {
			$data = array();
			
			$this->db->select('*');
			$this->db->from('job_started');
			$this->db->join('job_offers', 'job_offers.job_offer_id = job_started.js_job_offer_id');
			$this->db->where("job_started.js_user_id = $this->user_id");
			$q_get_job = $this->db->get();
			
			if($q_get_job->num_rows() == 1) {
				$row_job = $q_get_job->row_array();
				/*-- DEFINES SALARIES --*/
				$row_job['salary'] 	= $this->define_salaries($row_job['js_level'], $row_job['job_max_salary']);
				/*-- LEVEL TIME LIMTS --*/
				$row_job['limit'] 	= $this->level_time_limits($row_job['js_level'], $row_job['js_last_click']);
				
				/*-- CHECKS IF THE TIME LIMIT HAS PASSED --*/
				if($row_job['js_level'] <= 2) {
					$row_job['limit_passed'] = 1;
				} else {
					if(date(time())>$row_job['limit']) {
						$row_job['limit_passed'] = 1;
					} else {
						$row_job['limit_passed'] = 0;
					}
				}
				$data[] = $row_job;
				return $data;
			}
		}
		/*** END of get_the_job() ***/
		
		/*-----------------------------------------------------------
								# WORKING #
		-----------------------------------------------------------*/
		public function working() {
			$val = $this->input->post('val');
			if($val == 1) {
				$row_job = $this->get_the_job();
				$money = $row_job[0]['salary'];
				if($this->create_buildings_model->us_con('uc_energy')<15) {
					return 'no_energy';
				} else {
					/*-- UPDATES job_started --*/
					$this->db->where('js_user_id', $this->user_id);
					$this->db->set('js_level', "js_level+1", FALSE);
					$this->db->update('job_started', array('js_last_click' => date(time())));
					
					/*-- ADDS MONEY TO users_conditions --*/
					$new_power = $this->create_buildings_model->us_con('uc_power') + 0.3;
					$this->create_buildings_model->user_conditions_money_rest($new_power, -$money, 15, 15, 0, 0.3);
					$this->create_buildings_model->insert_users_action('got_salary', "Взехте заплата", $money, 0.3);
				}
			} else {
				redirect(base_url());
			}
			
		}
		/*** END OF working ***/
		/*-----------------------------------------------------------
							# QUIT/RESIGN JOB #
		-----------------------------------------------------------*/
		public function quiting_job() {
			$val = $this->input->post('val');
			
			if($val == 1) {
				$now = date(time());
				$row_job = $this->get_the_job();
				/*--- THE USER CAN QUIT THE JOB AT LEAST 6 HOURS AFTER HAVING STARTED ---*/
				$time_to_quit = strtotime('+6 hours', $row_job[0]['js_date_started']);
				if($now<$time_to_quit) {
					return 'six_hours_later';
				} else {
					/*-- DELETES THE ROW FROM job_started --*/
					$this->db->where('js_user_id', $this->user_id);
					$this->db->delete('job_started');
					/*-- UPDATES users_conditions to uc_job 0 --*/
					$this->db->where('uc_user_id', $this->user_id);
					$this->db->update('user_conditions', array('uc_job' => 0));
				}
			} else {
				redirect(base_url());
			}
		}
		/*** END of quting_job ***/
		
		/*--- DEFINES JOB LEVEL TIME LIMTS ---*/
		public function level_time_limits($level, $last_click) {
			if($level >= 3) {
				$limit = strtotime('+15 minutes', $last_click);
			} else {
				$limit = 0;
			}
			return $limit;
		}
		/*** END of level_time_limits() ***/
		/*--- DEFINES SALARIES ---*/
		public function define_salaries($level, $max_salary) {
			if($level == 0) {
				$salary = round($max_salary/2);
			} else if($level == 1) { // 70% of the max salary
				$sal = round(($max_salary*70)/100);
				$salary = $sal; 
			} else if($level >= 2) {
				$salary = $max_salary; 
			}
			return $salary;
		}
		/*** END of define_salaries() ***/
	}