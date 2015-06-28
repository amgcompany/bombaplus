<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Visitors_counter_model extends CI_Model {
		private $user_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			$this->user_id = $this->session->userdata('user_id');
		}
		/*--------------------------------------------------
						UNIQUE VISITOR COUNTER
		----------------------------------------------------*/
		public function count_unique_visitors($page) {
			$ip = $_SERVER['REMOTE_ADDR'];
			
			$this->db->order_by('uv_id', 'DESC');
			$q = $this->db->get_where('unique_visits', array('u_visit_ip' => $ip, 'u_visit_page' => $page));
			if($q->num_rows() == 0) {
				$arr = array(
					'u_visit_ip' 	=> $ip,
					'u_visit_date' 	=> date(time()),
					'u_visit_page' 	=> $page
				);
				$this->db->insert('unique_visits', $arr);
			} else {
				$row = $q->row_array();

				if(date('Ymd') == date('Ymd', $row['u_visit_date'])) {
					return 'do_noting';
				} else {
					$arr = array(
						'u_visit_ip' 	=> $ip,
						'u_visit_date' 	=> date(time()),
						'u_visit_page' 	=> $page
						);
					$this->db->insert('unique_visits', $arr);
				}
			}
		}
		/*** END of count_unique_visitors ***/
		/*--------------------------------------------------
			GETS UNIQUE VISITS TO BE SHOWN IN ADMIN PANEL
		----------------------------------------------------*/
		public function get_unique_visits() {
			$data = array();
			$q_get = $this->db->get('unique_visits');
			$br_home = 0; $br_main = 0;
			foreach($q_get->result_array() AS $row) {
				if(date('Ymd') == date('Ymd', $row['u_visit_date'])) {
					if($row['u_visit_page'] == 'home') {
						$br_home++;
					}
					if($row['u_visit_page'] == 'main') {
						$br_main++;
					}
				}
			}
			$data['home_visits'] = $br_home;
			$data['main_visits'] = $br_main;
			return $data;
		}
		/*** END of get_unique_visits() ***/
	}