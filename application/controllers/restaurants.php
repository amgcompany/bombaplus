<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Restaurants extends CI_Controller {
		private $user_id;
		public function __construct() {
			parent::__construct();
			/* If the user is not logged in to be redirected */
			if($this->session->userdata('logged_in') != 1) {
				redirect(base_url().'home');
			}
			$this->user_id = $this->session->userdata('user_id');
			$this->load->model('Restaurant_model');
		}
		/*--- LOAD BUILD RESTAUrANT ---*/
		public function load_view_build_restaurant() {
			$area_id = $this->input->post('area_id');
			$val	 = $this->input->post('val');
			$zone	 = $this->input->post('zone_id');
			$page	 = $this->input->post('page');
			
			if($val == 1) {
				$arr = array(
					'area_id'	=> $area_id,
					'zone_id'	=> $zone,
					'page'		=> $page,
					'row' 		=> $this->Restaurant_model->load_build_restaurant($area_id)
				);
				$this->load->view('ajax_included/build_restaurant_view', $arr);
			} else {
				redirect(base_url());
			}
		}
		/**** END OF  load_view_build_restaurant() ****/
		/*--- BUILDS RESTAURANT ---*/
		public function build_restaurant() {
			$area_id	 	= $this->input->post('area_id');
			$level 			= $this->input->post('level');
			$howmuch		= $this->input->post('howmuch');
			$validator 		= $this->input->post('val');

			if($validator != 1) {
				redirect(base_url());
			} else {
				$res = $this->Restaurant_model->build_restaurant($area_id, $level, $howmuch);
				if($res == 'no_enough_money') {
					echo "Нямате достатъчно пари, за да започенете строеж";
				} else if($res == 'no_enough_energy') {
					echo "Нямате достатъчно енергия";
				} else {
					echo "Вие построихте ресторант ниво $level";
				}
			}
		}
		/****** END OF build_restaurant() *****/
		/*--- DEFINES DISH PRICE ---*/
		public function define_dish_price() {
			$res = $this->Restaurant_model->define_price();
			if($res == 'suc_def') {
				echo 'suc_def';
			}
		}
		/**** END of dish price ****/
		/*--- ENTERS RESTAURANT ---*/
		public function enter_restaurant() {
			$area_id = $this->input->post('area_id');
			$restaurant_id = $this->input->post('res_id');
			$val	 = $this->input->post('val');
			$zone	 = $this->input->post('zone_id');
			$page	 = $this->input->post('page');
			
			if($val == 1) {
				$arr = array(
					'area_id'	=> $area_id,
					'zone_id'	=> $zone,
					'page'		=> $page,
					'row' 		=> $this->Restaurant_model->enter_restaurant($area_id, $restaurant_id)
				);
				$this->load->view('ajax_included/build_enter_restaurant', $arr);
			} else {
				redirect(base_url());
			}
		}
		/**** END of enter_restaurant ****/
		/*--- BUYS DISHES ---*/
		public function buy_dish() {
			$res = $this->Restaurant_model->dish_buy();
			echo $res;
		}
		/**** END of buy_dish ****/
		/*--- LAODS STOCKS ---*/
		public function load_stocks() {
			$res = $this->Restaurant_model->loading_stocks();
			echo $res;
		}
		/*--- END OF LAODS STOCKS ---*/
	}