<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Living_area_model extends CI_Model {
		private $user_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			$this->user_id = $this->session->userdata('user_id');
		}
		/*--- GETS LIVING AREAS ---*/
		public function get_it($id) {
			$this->load->library('pagination');
			$paging['base_url'] = base_url().'living_area/index';
			
			$paging['total_rows'] = $this->db->get_where('areas', array('area_zone_id' => $id))->num_rows();
			$paging['per_page'] = 12; //12
			$paging['num_links'] = 10; //10
			
			$this->pagination->initialize($paging);
			$data = array();
			$q = $this->db->get_where('areas', array('area_zone_id' => $id), $paging['per_page'], $this->uri->segment(3));
			foreach($q->result_array() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		/*** end of get_areas ****/	
		/*--- GETS CITY CENTERS AREAS ---*/
		public function get_living_areas_view() {
			$data = array();
			$res = $this->get_it(2);
			foreach($res as $key=>$row) {
				$data[] = $row;
				if($row['area_cat_building'] == '0') { // AREA FOR SALE
					$data[$key]['view'] = 'area_zero_view';
				}
				if($row['area_sold'] == '1') { // IF THE AREA IS SOLD TO LOAD area_sold_view
					$data[$key]['view'] = 'area_sold_view';
				}
				if($row['area_cat_building'] == '1') { // MANSIONS VIEW
					$q_mansions = $this->db->get_where('building_apartments', array('ba_area_id' => $row['area_id']))->row_array();
					$data[$key]['apartment_level'] = $q_mansions['b_apartment_level'];
					$data[$key]['view'] = 'area_mansions_view';
				}
				if($row['area_cat_building'] == '2') { // BANK VIEW
					$q_bank = $this->db->get_where('building_bank', array('b_bank_area_id' => $row['area_id']))->row_array();
					$data[$key]['bank_id']	= $q_bank['b_bank_id'];
					$data[$key]['view'] = 'area_bank_view';
				}
				if($row['area_cat_building'] == '3') { // CASINO VIEW
					$q_casino = $this->db->get_where('building_casino', array('bc_area_id' => $row['area_id']))->row_array();
					$data[$key]['casino_id'] = $q_casino['b_casino_id'];
					$data[$key]['view'] = 'area_casino_view';
				}
				if($row['area_cat_building'] == '5') { // UNIVERSITY VIEW
					$q_uni = $this->db->get_where('universities', array('uni_area_id' => $row['area_id']))->row_array();
					$data[$key]['uni_id'] = $q_uni['university_id'];
					$data[$key]['view'] = 'area_university_view';
				}
				if($row['area_cat_building'] == '7') { // RESTAURANT VIEW
					$q_restaurant = $this->db->get_where('building_restaurants', array('br_area_id' => $row['area_id']))->row_array();					
					$data[$key]['restaurant_id']		= $q_restaurant['restaurant_id'];
					$data[$key]['b_restaurant_level']	= $q_restaurant['b_restaurant_level'];
					$data[$key]['view'] 	= 'area_restaurant_view';
				}
				if($row['area_cat_building'] == '8') { // SHOP VIEW
					//$q_restaurant = $this->db->get_where('building_restaurants', array('br_area_id' => $row['area_id']))->row_array();					
					//$data[$key]['restaurant_id']		= $q_restaurant['restaurant_id'];
					//$data[$key]['b_restaurant_level']	= $q_restaurant['b_restaurant_level'];
					$data[$key]['view'] 	= 'area_shop_view';
				}
			}
			return $data;
		}
		/*** end of get_areas ****/
	}