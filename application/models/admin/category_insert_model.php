<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Category_insert_model extends CI_Model {
		public function __construct() {
			parent::__construct();
		}
		/*--- INSERTS CATEGOTIES INTO DB ---*/
		public function insert() {
			$category = $this->input->post('cat_build');
			$cat_type = $this->input->post('cat_type');
			$ip 	= $_SERVER['REMOTE_ADDR'];
			/* BUILDINGS  */
			if($cat_type == '1') {
				$data = array(
					'category_building' => $category,
					'cat_ip_added'		=> $ip
				);
				$this->db->insert('category_buildings' ,$data);
			}
			/* FARMING */
			if($cat_type == '2') {
				$data = array(
					'cat_farm' 		=> $category,
					'cat_ip_added'	=> $ip
				);
				$this->db->insert('category_farming' ,$data);
			}
			/* LIVESTOCK BREEDING */
			if($cat_type == '3') {
				$data = array(
					'cat_animal' 	=> $category,
					'cat_ip_added'	=> $ip
				);
				$this->db->insert('category_animal' ,$data);
			}
		}
	}