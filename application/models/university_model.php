<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class University_model extends CI_Model {
		private $user_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			$this->load->model('create_buildings_model');
			
			$this->user_id = $this->session->userdata('user_id');
		}
		/*
		----------------------------------------------------------------------
					# BUILDING UNIVERSITY AND ADMINISTRATIONS #
		----------------------------------------------------------------------
		*/
		/*--- INSERTS THE UNI IN THE DB ---*/
		public function build_university() {
			$area_id = $this->input->post('area_id');
			$val	 = $this->input->post('val');
			if($val == 1 && $this->session->userdata('rank') == 1) {	
				/* 
				- CHECK IF THE USER user_id IS OWNER OF THE AREA WITH ID area_id  
				- CHEKS IF THE USER IS ADMIN
				*/
				if($this->create_buildings_model->is_build_on_area($area_id) == 0) {
					if($this->create_buildings_model->is_owner_of_area($area_id) == 1 && $this->session->userdata('rank') == 1) {
						$data = array(
							'uni_area_id' 	=> $area_id,
							'uni_user_id' 	=> $this->user_id,
							'uni_builded_ip' => $_SERVER['REMOTE_ADDR'],
						);
						$this->db->insert('universities', $data);
						/* UPDATES ARES TO BULDING_CAT TO BE EQUAL TO university's category */
						$this->db->where("area_id = '$area_id' AND area_sold_to_id= '$this->user_id'");
						$this->db->update('areas', array('area_cat_building'=>5));
						return 'uni_build';
					} else {
						exit();
					}
				} else {
					exit();
				}
			} else {
				exit();
			}
		}
		/*** END OF build_university ***/
		/*--- LOAD THE ADMINISTRATIONS ---*/
		public function university_administration($area_id, $uni_id) {
			$val	 = $this->input->post('val');
			if($val == 1 && $this->session->userdata('rank') == 1) {

				if($this->create_buildings_model->is_owner_of_area($area_id) == 1 && $this->session->userdata('rank') == 1) {
				/* GETS ALL TO SHOW IN THE VIEW */
					$data = array();
					/* # GETTING THE SPECIALTIES/CATEGORIES FROM THE UNI # */
					$q_get_cats = $this->db->get_where('university_specialties', array('us_uni_id'=>$uni_id));
					if($q_get_cats->num_rows() > 0) {
						$categories = array();
						foreach($q_get_cats->result_array() AS $row) {
							$categories[] = $row;
						}
						$data['categories'] = $categories;
					} else {
						$data['categories'] = '0';
					}
				/* END OF GETTING WHAT TO SHOW IN THE VIEW */
				return $data;
				} else {
					exit();
				}
				
			} else {
				exit();
			}
		}
		/**** END OF LOADING ADMINISTRATIONS ****/
		/*--- ADDING UNI SPECIALTY ---*/
		public function add_university_specialty() {
			$area_id = $this->input->post('area_id');
			$uni_id  = $this->input->post('uni_id');
			$spec    = $this->input->post('spec');
			$prize	 = $this->input->post('prize');
			$val	 = $this->input->post('val');
			
			if($val == 1 && $this->session->userdata('rank') == 1) {
				$data = array(
					'us_uni_id'				=> $uni_id,
					'u_specialty_title'		=> $spec,
					'u_specialty_enter_prize'=> $prize,
					'up_ip_added'			=> $_SERVER['REMOTE_ADDR']
				);
				$this->db->insert('university_specialties', $data);
			} else {
				redirect(base_url());
			}
		}
		/*** END OF add_university_specialty() ***/
		/*--- ADDING QUESTION ---*/
		public function add_question_validation() {
			$cat_id 	= $this->input->post('cat_id');
			$question	= $this->input->post('question');
			$level		= $this->input->post('level');
			$ans1		= $this->input->post('ans1');
			$ans2		= $this->input->post('ans2');
			$ans3		= $this->input->post('ans3');
			$ans4		= $this->input->post('ans4');
			$correct	= $this->input->post('iscorrect');
			/* INSERTS THE QUESTION INTO DB table 'questions' */
			$question_data = array(
				'question'			=> $question,
				'question_level'	=> $level,
				'question_specialty_id'	=> $cat_id,
				'question_ip_added'	=> $_SERVER['REMOTE_ADDR']
			);
			$this->db->insert('questions', $question_data);
			$insert_id = $this->db->insert_id(); // GETS THE LAST ID3
			/* UPDATES THE question_id row TO THE LAST INSERTED QUESTION'S ID $insert_id */
			$this->db->where('id', $insert_id);
			$this->db->update('questions', array('question_id' => $insert_id));
			/* INSERTS THE ANSWERS */
			if($correct == 'answer1'){
				$this->db->insert('answers', array(
					'ans_question_id'	=> $insert_id,
					'answer'			=> $ans1,
					'correct'			=> '1'
				));
				$this->db->insert('answers', array(
					'ans_question_id'	=> $insert_id,
					'answer'			=> $ans2,
					'correct'			=> '0'
				));
				$this->db->insert('answers', array(
					'ans_question_id'	=> $insert_id,
					'answer'			=> $ans3,
					'correct'			=> '0'
				));
				$this->db->insert('answers', array(
					'ans_question_id'	=> $insert_id,
					'answer'			=> $ans4,
					'correct'			=> '0'
				));
			}
			if($correct == 'answer2'){
				$this->db->insert('answers', array(
					'ans_question_id'	=> $insert_id,
					'answer'			=> $ans1,
					'correct'			=> '0'
				));
				$this->db->insert('answers', array(
					'ans_question_id'	=> $insert_id,
					'answer'			=> $ans2,
					'correct'			=> '1'
				));
				$this->db->insert('answers', array(
					'ans_question_id'	=> $insert_id,
					'answer'			=> $ans3,
					'correct'			=> '0'
				));
				$this->db->insert('answers', array(
					'ans_question_id'	=> $insert_id,
					'answer'			=> $ans4,
					'correct'			=> '0'
				));
			}
			if($correct == 'answer3'){
				$this->db->insert('answers', array(
					'ans_question_id'	=> $insert_id,
					'answer'			=> $ans1,
					'correct'			=> '0'
				));
				$this->db->insert('answers', array(
					'ans_question_id'	=> $insert_id,
					'answer'			=> $ans2,
					'correct'			=> '0'
				));
				$this->db->insert('answers', array(
					'ans_question_id'	=> $insert_id,
					'answer'			=> $ans3,
					'correct'			=> '1'
				));
				$this->db->insert('answers', array(
					'ans_question_id'	=> $insert_id,
					'answer'			=> $ans4,
					'correct'			=> '0'
				));
			}
			if($correct == 'answer4'){
				$this->db->insert('answers', array(
					'ans_question_id'	=> $insert_id,
					'answer'			=> $ans1,
					'correct'			=> '0'
				));
				$this->db->insert('answers', array(
					'ans_question_id'	=> $insert_id,
					'answer'			=> $ans2,
					'correct'			=> '0'
				));
				$this->db->insert('answers', array(
					'ans_question_id'	=> $insert_id,
					'answer'			=> $ans3,
					'correct'			=> '0'
				));
				$this->db->insert('answers', array(
					'ans_question_id'	=> $insert_id,
					'answer'			=> $ans4,
					'correct'			=> '1'
				));
			}
			
		}
		/*** END of adding_quesiton ***/
		/***************************************************************************
							# END OF UNIVERSITY'S ADMINISTRATIONS #
		****************************************************************************/
		/*--------------------------------------------------------------------------
								# INSIDE UNIVERSITY #
		---------------------------------------------------------------------------*/
		public function load_university($uni_id) {
			$data = array();
			$q_get_cats = $this->db->get_where('university_specialties', array('us_uni_id'=>$uni_id));
			if($q_get_cats->num_rows() > 0) {
				$categories = array();
				foreach($q_get_cats->result_array() AS $row) {
					$q_is_started = $this->db->get_where('university_is_specialty_started', array('uiss_spec_id'=>$row['uni_spec_id'], 'uiss_user_id'=>$this->user_id));
					$row['spec_num_rows'] = $q_is_started->num_rows();
					$categories[] = $row;
				}
				$data['categories'] = $categories;
			} else {
				$data['categories'] = '0';
			}
			return $data;	
		}
		/*--- STARTING LEARNING SPECIALTY ---*/
		public function start_study_specialty() {
			$spec_id = $this->input->post('spec_id');
			$q_has_already_started = $this->db->get_where('university_is_specialty_started', array('uiss_spec_id' => $spec_id, 'uiss_user_id' => $this->user_id));
			if($q_has_already_started->num_rows()<1) {
				$row_prize = $this->db->get_where('university_specialties', array('uni_spec_id'=>$spec_id))->row_array();
				$money = $row_prize['u_specialty_enter_prize'];
				if($this->create_buildings_model->us_con('uc_energy')<15) {
					return 'no_enough_energy';
				} else if($this->create_buildings_model->us_con('uc_money')<$money) {
					return 'no_enough_money';
				} else {
					$data = array(
						'uiss_spec_id'		=> $spec_id,
						'uiss_user_id'		=> $this->user_id,
						'uiss_ip'			=> $_SERVER['REMOTE_ADDR']
					);
					$this->db->insert('university_is_specialty_started', $data);
					
					$new_power = $this->create_buildings_model->us_con('uc_power')+5;
					if($this->create_buildings_model->us_con('uc_money')>=0) {
						$this->create_buildings_model->user_conditions_money_rest($new_power, $money, 15, 25, 0, 0);
					}
					$this->create_buildings_model->insert_users_action('started_study', "Започнахте да учите $row_prize[u_specialty_title]", $money, 3);
					return 'cool';
				}
			} else {
				exit();
			}
		}
		/*** end of start_study_specialty ***/
		/*--- CHECKS IF THE USER HAS PERMISSION TO TAKE THE TEST ---*/
		public function check_permission_for_test($spec_id) {
			$q_has_already_started = $this->db->get_where('university_is_specialty_started', array('uiss_spec_id' => $spec_id, 'uiss_user_id' => $this->user_id));
			if($q_has_already_started->num_rows()<1) {
				redirect(base_url());
			} else {
				$test_prize_row = $this->db->get_where('university_specialties', array('uni_spec_id'=>$spec_id))->row_array();
				$test_prize = $test_prize_row['us_test_prize'];
				if($this->create_buildings_model->us_con('uc_money')>$test_prize) {
					$new_power = $this->create_buildings_model->us_con('uc_power')+0.5;
					$this->create_buildings_model->user_conditions_money_rest($new_power, $test_prize, 0, 0, 0, 0);
					$this->create_buildings_model->insert_users_action('started_test', "Започнахте тест от университета", $test_prize, 2.5);
				} else {
					redirect(base_url().'university');
				}
			}
		}
		/**** END OF check permissions ****/
		/*--- GETTING THE QUESTIONS ---*/
		public function uni_level_question() {
			$check = $this->input->post("check");
			$spec_id = $this->input->post("spec_id");
			$level = $this->input->post("level");
			
			if($check==1) {
					
				$data = array();
				$q 	= $this->db->query("SELECT question_id, question, question_level
											FROM questions 
											WHERE question_level='$level' AND question_specialty_id='$spec_id'
											ORDER BY MD5(CONCAT(question_id, CURRENT_TIMESTAMP))");
				$row 	= $q->row_array();
				$q_id 	= $row['question_id'];
				
				$answers = $this->db->query("SELECT ans_id, ans_question_id,answer, correct 
												FROM answers 
												WHERE ans_question_id='$q_id'
												ORDER BY MD5(CONCAT(ans_id, CURRENT_TIMESTAMP))");			
				$data[] 	= $row;
				foreach($answers->result_array() AS $ans) {
					$data[] = $ans;
				}
				return $data;
				
			} else {
				exit();
			}
		}
		/*** END OF uni_level_question ***/
		/*--- CHEKING RESULTS ---*/
		public function check_test_results() {
			$check = $this->input->post("check");
			
			if($check==1) {
				$spec_id = $this->input->post('spec_id');
				$res = $this->input->post('result');
				if($res>=2) { /* IF THE USER HAS ANSWERED CORRECTLY 2 OR 3 QUESTIONS HE HAS PASSED THE TEST */
					/* ADDS THE spec_id TO THE educations */
					$data = array(
						'edu_user_id'	=> $this->user_id,
						'edu_spec_id'	=> $spec_id,
						'edu_ip'		=> $_SERVER['REMOTE_ADDR']
					);
					$this->db->insert('education', $data);
					return 'test_passed';
				} else {
					return 'test_failed';
				}
			}
		}
		/**** END of checking the results ****/
	}