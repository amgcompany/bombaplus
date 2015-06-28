<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Areas_model extends CI_Model {
		public function __construct() {
			parent::__construct();
		}
		/*---- INSERTS AREAS INTO THE DB ----*/
		public function create_areas() {
			$zone = $this->input->post('zone');
			$city = $this->input->post('city');
			$numb = $this->input->post('numb');
			$space = $this->input->post('space');
			
			$data = array(
				'area_city_id'	=> $city,
				'area_zone_id'	=> $zone,
				'area_space'	=> $space,
				'area_added_ip'	=> $_SERVER['REMOTE_ADDR']
			);
			$i = 0;
			for($i = 1; $i<=$numb; $i++) {
				$this->db->insert('areas', $data);
			}
		}
		/**** end of create_areas ****/
	}