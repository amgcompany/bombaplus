<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Sell_model extends CI_Model {
		private $user_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			$this->load->model('create_buildings_model');
			
			$this->user_id = $this->session->userdata('user_id');
		}
		/*--- GTES MAIN CATEGORIES ---*/
		public function get_sell_categories() {
			$data = array();
			$q_cats = $this->db->get_where('shop_categories');
			foreach($q_cats->result_array() AS $row) {
				$data[] = $row;
			}
			return $data;
		}
		/**** END OF GTES MAIN CATEGORIES ****/
		/*--- GETTING OWNING PRODUCTS FROM CATEGORY shop_cat_id ---*/
		public function get_product_from_category() {
			$data = array();
			$category = $this->input->post('category');
			$this->db->select('*');
			$this->db->from('users_properties');
			$this->db->join('shop_categories', 'shop_categories.shop_cat_id = users_properties.up_category_id');
			$this->db->where("users_properties.up_user_id = $this->user_id AND  shop_categories.shop_cat_id=$category");
			$this->db->order_by('up_id', 'DESC');
			$q_get_products = $this->db->get();
			if($q_get_products->num_rows() >= 1) {
				foreach($q_get_products->result_array() AS $row) {
					$q_sub_cat = $this->db->get_where('shop_subcategories', array('shop_bash_cat_id'=>$row['shop_cat_id'], 'shop_subcat_id'=>$row['up_subcat_id']))->row_array();
					$row['shop_subcategory'] = $q_sub_cat['shop_subcategory'];
					$row['shop_subcat_id'] = $q_sub_cat['shop_subcat_id'];
					$row['div_icon'] = $this->div_icon($q_sub_cat['shop_subcat_id'], $category);
					$data[] = $row;
				}
			} else {
				$data['product_num_rows'] = 0;
			}
			return $data;
		}
		/**** END of get_product_from_category() ****/
		/*--- INSERTS SHOP SELL ARTICLE TO THE SHO ---*/
		public function insert_sell_shop_article() {
			$sub_category 	= $this->input->post('subcategory');
			$category 		= $this->input->post('category');
			$prize 			= $this->input->post('prize');
			$quantity 		= $this->input->post('quantity');
			/* CHECKS IF THERE IS ALREADY ARTICLE FROM THIS USER WITH THIS PRODUCT */
			$where_array = array(
				'shop_art_cat_id' 		=> $category,
				'shop_art_subcat_id' 	=> $sub_category,
				'shop_art_user_id' 		=> $this->user_id
			);
			
			/* CHECKS IF THE QUANTITY IS LESS */
			$q_quanty = $this->db->get_where('users_properties', array('up_subcat_id'=>$sub_category, 'up_user_id'=>$this->user_id));
			$row_quantity = $q_quanty->row_array();
			$q_article_product = $this->db->get_where('shop_articles', $where_array);
			
			if($q_article_product->num_rows() > 0) { /* CHECKS IF THERE IS ALREADY ARTICLE FROM THIS USER WITH THIS PRODUCT */
				return 'exist_such_article';
			} else if($row_quantity['q_property_quantity']<$quantity) {
				return 'no_enough_quantity';
			} else if($quantity <1) {
				return 'doesnt_select_quantity';
			} else if($prize < 1) {
				return 'doesnt_select_prize';
			} else {
				$data = array(
					'shop_art_user_id'		=> $this->user_id,
					'shop_art_cat_id'		=> $category,
					'shop_art_subcat_id'	=> $sub_category,
					'shop_art_quantity'		=> $quantity,
					'shop_art_prize'		=> $prize,
					'shop_art_ip'			=> $_SERVER['REMOTE_ADDR'],
				);
				$this->db->insert('shop_articles', $data);
				return 'inserted';
			}
		}
		/*--- GIVES THE ICON TO THE DIV ---*/
		public function div_icon($sub_category, $category) {
			if($sub_category == 1) {
				$div = 'cow_meat';
			}
			if($sub_category == 2) {
				$div = 'cow_milk';
			}
			if($sub_category == 3) {
				$div = 'pig_meat';
			}
			if($sub_category == 4) {
				$div = 'chicken';
			}
			if($sub_category == 5) {
				$div = 'tomato';
			}
			if($sub_category == 6) {
				$div = 'cucumber';
			}
			if($sub_category == 7) {
				$div = 'bean';
			}
			if($sub_category == 8) {
				$div = 'car';
			}
			if($sub_category != 8 && $sub_category>=9 && $sub_category<=12) {
				$div = 'jet';
			}
			if($sub_category>=13 && $sub_category<=15) {
				$div = 'yacht';
			}
			if($sub_category>=16 && $sub_category<=18) {
				$div = 'diamond';
			}
			if($sub_category == 19 || $sub_category == 20) {
				$div = 'golden_rings';
			}
			return $div;
		}
	}