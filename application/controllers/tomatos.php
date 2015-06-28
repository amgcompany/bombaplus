<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Tomatos extends CI_Controller {
		private $user_id, $main;
		public function __construct() {
			parent::__construct();
			/* If the user is not logged in to be redirected */
			if($this->session->userdata('logged_in') != 1) {
				redirect(base_url().'home');
			}
			$this->user_id = $this->session->userdata('user_id');
			
			$this->load->model('left_menu_model');	
			$this->load->model('main_model');		
			$this->load->model('Tomatos_model');		
		}
		/*-----------------------------------------------------
					# LOADS BUILDING TOMATOS #
		-------------------------------------------------------*/
		public function load_build_tomatos() {
			$area_id 		= $this->input->post('area_id');
			$zone_id	 	= $this->input->post('zone_id');
			$page	 		= $this->input->post('page');
			$arr = array(
				'area_id' 	=> $area_id,
				'zone_id' 	=> $zone_id,
				'page' 		=> $page,
				'row' 		=> $this->Tomatos_model->load_build_tomatos()
			);
			$this->load->view('ajax_included/tomatos/load_build_tomatos', $arr);
		}
		/*** END of load_build_tomatos ***/
		/*-----------------------------------------------------
						# SEED TOMATOS #
		-------------------------------------------------------*/
		public function seed_tomatos() {
			$res = $this->Tomatos_model->seeding_tomatos();
			echo $res;
		}
		/*** END of seed_tomatos ***/
		/*-----------------------------------------------------
					# TOMATO PRODUCTION #
		-------------------------------------------------------*/
		public function start_tomato_production() {
			$res = $this->Tomatos_model->tomato_production();
		}
		/*** END of tomato_production ***/
		/*-----------------------------------------------------
				# COLLECTING TOMATO PRODUCTION #
		-------------------------------------------------------*/
		public function get_tomato_production() {
			$this->Tomatos_model->collect_tomato_production();
		}
		/*** END of get_tomato_production ***/
		/*-----------------------------------------------------
				# SELLING TOMATOS #
		-------------------------------------------------------*/
		public function sell_tomatos() {
			$res = $this->Tomatos_model->sell_tomatos_production();
			echo $res;
		}
		/*** END of sell_tomatos ***/
	}