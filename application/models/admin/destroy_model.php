<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Destroy_model extends CI_Model {
		public function __construct() {
			parent::__construct();
		}
		/*-------------------------------------------- 
					DESTROYS BUILDING
		--------------------------------------------*/
		public function destroy_building() {
			$area_id = $this->input->post('destroy_property_id');
			$type = $this->input->post('destroy_type');
			
			$this->del_spent_money($area_id);
			$this->del_earned_money($area_id);
			$this->update_for_sale($area_id);
			$this->delete_area_owner($area_id);
			$this->delete_allow_build($area_id);
			
			/*--- DESTROYING MANSIONS ---*/
			if($type == 1) {
				$this->delete_mansions($area_id);
			}
			/* end of mansions */
			/*--- DESTROYING RESTAURANTS ---*/
			if($type == 2) {
				$this->delete_restaurant($area_id);
			}
			/* end of restaurants */
			/*--- DESTROYING CASINOS ---*/
			if($type == 3) {
				$this->delete_casino($area_id);
			}
			/* end of casino */
			/*--- DESTROYING DAIRY FARM ---*/
			if($type == 4) {
				$this->delete_dairy_farm($area_id);
			}
			/* end of df */
			/*--- DESTROYING TOMATOS ---*/
			if($type == 5) {
				$this->delete_tomatos($area_id);
			}
			/* end of tomatos */
			echo "Успешно изтрито";
		}
		/**** end of destroy ****/
		/*-------------------------------------------- 
				DELETES SPENT MONEY
		--------------------------------------------*/
		public function del_spent_money($area_id) {
			$this->db->where('asm_area_id', $area_id);
			$this->db->delete('area_spent_money');
		}
		/*-- end of del_spent_money() --*/
		/*-------------------------------------------- 
				DELETES EARNED MONEY
		--------------------------------------------*/
		public function del_earned_money($area_id) {
			$this->db->where('aem_area_id', $area_id);
			$this->db->delete('area_earn_money');
		}
		/*-- end of del_spent_money() --*/
		/*-------------------------------------------- 
				UPDATES AREAS 'FOR SALE'
		--------------------------------------------*/
		public function update_for_sale($area_id) {
			$this->db->where('area_id', $area_id);
			$this->db->update('areas', array(
				'area_sold'			=> 0,
				'area_sold_to_id'	=> 0,
				'area_cat_building'	=> 0
			));
		}
		/*-- end of del_spent_money() --*/
		/*-------------------------------------------- 
				DELETES AREA OWNER 
		--------------------------------------------*/
		public function delete_area_owner($area_id) {
			$this->db->where('ao_area_id', $area_id);
			$this->db->delete('area_owners');
		}
		/*-- end of delete_area_owner() --*/
		/*-------------------------------------------- 
				DELETES ALLOW TO BUILD 
		--------------------------------------------*/
		public function delete_allow_build($area_id) {
			$this->db->where('ballow_area_id', $area_id);
			$this->db->delete('building_allow_build');
		}
		/*-- end of delete_allow_build() --*/
		/*-------------------------------------------- 
				DELETES MANSIONS
		--------------------------------------------*/
		public function delete_mansions($area_id) {	
			$this->db->where('ba_area_id', $area_id);
			$this->db->delete('building_apartments');
			
			/* DELETES APARTMENTS OWNERS */
			$this->db->where('bao_area_id', $area_id);
			$this->db->delete('building_apartment_owners');
		}
		/*-- end of delete_mansions() --*/
		/*-------------------------------------------- 
				DELETES RESTAURANTS
		--------------------------------------------*/
		public function delete_restaurant($area_id) {	
			$this->db->where('br_area_id', $area_id);
			$this->db->delete('building_restaurants');
			
			/* DELETES DISHES */
			$this->db->where('brd_area_id', $area_id);
			$this->db->delete('build_restaurant_dishes');
		}
		/*-- end of delete_restaurant() --*/
		/*-------------------------------------------- 
				DELETES CASINO
		--------------------------------------------*/
		public function delete_casino($area_id) {	
			$this->db->where('bc_area_id', $area_id);
			$this->db->delete('building_casino');
			
			/* DELETES PRIZES */
			$this->db->where('bcp_area_id', $area_id);
			$this->db->delete('building_casino_prizes');
		}
		/*-- end of delete_casino() --*/
		/*-------------------------------------------- 
				DELETES DAIRY FARM
		--------------------------------------------*/
		public function delete_dairy_farm($area_id) {	
			$this->db->where('df_area_id', $area_id);
			$this->db->delete('farming_dairy_farm');
			
			/* DELETES PRIZES */
			$this->db->where('dfd_milk_area_id', $area_id);
			$this->db->delete('farming_df_milk');
		}
		/*-- end of delete_dairy_farm() --*/
		/*-------------------------------------------- 
				DELETES TOMATOES
		--------------------------------------------*/
		public function delete_tomatos($area_id) {	
			$this->db->where('tft_tomato_area_id', $area_id);
			$this->db->delete('farming_ft_tomatos');
			
			/* DELETES PRIZES */
			$this->db->where('tomato_farm_area_id', $area_id);
			$this->db->delete('farming_tomato');
		}
		/*-- end of delete_tomatos() --*/
	}