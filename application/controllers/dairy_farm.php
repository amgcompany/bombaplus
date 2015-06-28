<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Dairy_farm extends CI_Controller {
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
			$this->load->model('Industrial_model');		
			$this->load->model('Dairy_farm_model');		
		}
		/*-----------------------------------------------------
					# LOADS ADMIN DAIRY FARM #
		-------------------------------------------------------*/
		public function admin_dairy_farm() {
			$arr = array(
				'area_id'	=> $this->input->post('area_id'),
				'zone_id' 	=> $this->input->post('zone_id'),
				'page' 		=> $this->input->post('page'),
				'row' 		=> $this->Dairy_farm_model->get_dairy_farm_info()
			);
			$this->load->view('ajax_included/dairy_farm/admin_dairy_farm', $arr);
		}
		/*** END of admin_dairy_farm ***/
		/*-----------------------------------------------------
				# BUIDLING BIGGER BUIDLING IN DAIRY FARM #
		-------------------------------------------------------*/
		public function build_more_df_space() {
			$res = $this->Dairy_farm_model->build_more_df();
			echo $res;
		}
		/*** END of build_more_df_space() ***/
		/*-----------------------------------------------------
						# BUYS COWS #
		-------------------------------------------------------*/
		public function buy_cows() {
			$res = $this->Dairy_farm_model->buying_cows();
			echo $res;
		}
		/*** END of buy_cows() ***/
		/*-----------------------------------------------------
					# MILK PRODUCTION #
		-------------------------------------------------------*/
		public function start_milk_production() {
			$res = $this->Dairy_farm_model->milk_production();
		}
		/*** END of milk_production ***/
		/*-----------------------------------------------------
				# COLLECTING MILK PRODUCTION #
		-------------------------------------------------------*/
		public function get_milk_production() {
			$this->Dairy_farm_model->collect_milk_production();
		}
		/*** END of get_milk_production ***/
		/*-----------------------------------------------------
				# SELLING MILK PRODUCTION #
		-------------------------------------------------------*/
		public function sell_milk() {
			$res = $this->Dairy_farm_model->sell_milk_production();
			echo $res;
		}
		/*** END of sell_milk ***/
	}