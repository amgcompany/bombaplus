<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Shop_model extends CI_Model {
		private $user_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			$this->load->model('create_buildings_model');
			
			
			$this->user_id = $this->session->userdata('user_id');
		}
		/* GETS SHOP ARTICLES */
		public function get_shop_article() {
			$this->load->model('Sell_model');
			/* PAGINATION */
			$this->load->library('pagination');
			$paging['base_url'] = base_url().'shop/index';
			
			$paging['total_rows'] = $this->db->get('shop_articles')->num_rows();
			$paging['per_page'] = 10; //10
			$paging['num_links'] = 10; //10
			
			$this->pagination->initialize($paging);
			
			$data = array();
			$this->db->select('*');
			$this->db->from('shop_articles');
			$this->db->join('shop_categories', 'shop_categories.shop_cat_id = shop_articles.shop_art_cat_id');
			$this->db->join('accounts', 'accounts.user_id = shop_articles.shop_art_user_id');
			$this->db->order_by('shop_article_id','DESC');
			$q_get_products = $this->db->get('', $paging['per_page'], $this->uri->segment(3));
			
			if($q_get_products->num_rows() >= 1) {
				foreach($q_get_products->result_array() AS $row) {
					$q_sub_cat = $this->db->get_where('shop_subcategories', array('shop_bash_cat_id'=>$row['shop_cat_id'], 'shop_subcat_id'=>$row['shop_art_subcat_id']))->row_array();
					$row['shop_subcategory'] = $q_sub_cat['shop_subcategory'];
					$row['shop_subcat_id'] = $q_sub_cat['shop_subcat_id'];
					$row['prize'] = $this->format_big_numbers($row['shop_art_prize']);
					$row['div_icon'] = $this->Sell_model->div_icon($q_sub_cat['shop_subcat_id'], $row['shop_cat_id']);
					$data[] = $row;
				}
			} else {
				$data['product_num_rows'] = 0;
			}
			return $data;
		}
		/*---- BUYS QUANTITY OF SHOP PRODUCT ----*/
		public function buy_shop_product() {
			$val = $this->input->post('val');
			if($val == 1) {
				$article_id = $this->input->post('article_id');
				$quantity = $this->input->post('quantity');
				/* Query CHECKS IF THERE IS STILL THIS ARTICLE article_id  */
				$q_is_there = $this->db->get_where('shop_articles', array('shop_article_id' => $article_id));
				$row_article = $q_is_there->row_array();
				
				if($quantity == 0 || $quantity == '') { // QUANTITY WASN'T CHOOSED
					return 'choose_quantity';
				} else if($q_is_there->num_rows()==0) { /* THERE IS NO SUCH ARTICLE ANYMORE */
					return 'no_such_article';
				} else if($row_article['shop_art_quantity']<$quantity) { /* CHEKCS IF THERE ISN'T THIS AMOUNT OF QUANTITY */ 
					return 'no_quantity';
				} else if($this->create_buildings_model->us_con('uc_money')<($row_article['shop_art_prize']*$quantity)) { /* CHECKS IF THE USER HASN'T GOT ENOUGH MONEY TO BUY THE PRODUCT */
					return 'no_enough_money';
				} else {
					/* GETS HOW MANY TUZAR TO GIVE TO THE USER */
					$tuzar_to_give_func = $this->get_product_tuzar($row_article['shop_art_subcat_id'], $row_article['shop_art_prize']);
					$tuzar_to_give = $tuzar_to_give_func*$quantity;
					/* 
						--- GETS THE QUANTITY FROM THE USER WHO HAS DECLARED THE ARTICLE ---
						# - CHECKS IF THE AMOUNT OF QUANTITY IS 0, IF IT IS THEN DELETE
					*/
					$q_user_product_quantity = $this->db->get_where('users_properties', array('up_subcat_id' => $row_article['shop_art_subcat_id'], 
																							   'up_user_id'=> $row_article['shop_art_user_id']));
					$row_uq = $q_user_product_quantity->row_array();
					$final_q = $row_uq['q_property_quantity'] - $quantity;
					if($final_q == 0) {
						$this->db->where('up_subcat_id', $row_article['shop_art_subcat_id']);
						$this->db->delete('users_properties');
					} else {
						$this->db->where("up_subcat_id = $row_article[shop_art_subcat_id] AND up_user_id=$row_article[shop_art_user_id]");
						$this->db->set('q_property_quantity',"q_property_quantity-$quantity",FALSE);
						$this->db->update('users_properties');
					}
					/*------------------------------------------------------------------
						--- CHECKS HOW MUCH QUANTITY HAS REST IN THE SHOP ARTICLE ---
							1) - IF IT IS 0 THEN DELETE THE ARTICLE -
							2) - IF IS MORE THAN 0, THEN UPDATE - $quantity
					--------------------------------------------------------------------*/
					$rest_quantity = $row_article['shop_art_quantity']-$quantity;

					if($rest_quantity == 0) {
						/* DELETES THE ARTICLE */
						$this->db->where('shop_article_id', $row_article['shop_article_id']);
						$this->db->delete('shop_articles');
					} else {
						/* UPDATE, TAKES $quantity */
						$this->db->where('shop_article_id', $row_article['shop_article_id']);
						$this->db->set('shop_art_quantity', "shop_art_quantity-$quantity", FALSE);
						$this->db->update('shop_articles');
					}
					/*------------------------------------------------------------------
						### INSERTS THE AMOUNT OF QUANTITY FOR THE BUYER AS PROPERTY ###
						1) CHECKS THE USER HAS PRODUCTS FROM THIS SUBCATEGORY
							1.1) IF HE HASN'T, THEN INSERT
							1.2) IF HE HAS, THEN UPDATE, add quantity
					--------------------------------------------------------------------*/
					/*-- @ 1.0 @ --*/
					$q_has_product = $this->db->get_where('users_properties', array('up_subcat_id' => $row_article['shop_art_subcat_id'], 
																					'up_user_id' => $this->user_id));
					$row_hp = $q_has_product->row_array();
					
					/*-- @ 1.1 @ --*/
					if($q_has_product->num_rows() == 0) {
						$data = array(
							'up_user_id' 		=> $this->user_id,
							'up_category_id'	=> $row_article['shop_art_cat_id'],
							'up_subcat_id'		=> $row_article['shop_art_subcat_id'],
							'q_property_quantity'	=> $quantity
						);
						$this->db->insert('users_properties', $data);
					} else {
					/*-- @ 1.2 @ --*/
						$this->db->where("up_subcat_id = $row_article[shop_art_subcat_id] AND up_user_id=$this->user_id");
						$this->db->set('q_property_quantity', "q_property_quantity+$quantity", FALSE);
						$this->db->update('users_properties');
					}
					/*--- GIVES THE MONEY TO THE OWNER OF THE SHOP ARTICLE ---*/
					$total_prize = $row_article['shop_art_prize']*$quantity;
					$this->db->where('uc_user_id', $row_article['shop_art_user_id']);
					$this->db->set('uc_money', "uc_money+$total_prize", FALSE);
					$this->db->update('user_conditions');
					
					/*--- UPDATES USER'S CONDITIONS ---*/
					$new_power = $this->create_buildings_model->us_con('uc_power')+0.5;
					$this->create_buildings_model->user_conditions_money_rest($new_power, $total_prize, 0, 0, 0, $tuzar_to_give);
					/*--- UPDATES USER'S CONDITIONS PLUS QUANTITY OF VEHICLES ---*/
					if($row_article['shop_art_cat_id'] == 2) {
						$this->db->where('uc_user_id', $this->user_id);
						$this->db->set('uc_vehicles', "uc_vehicles+$quantity", FALSE);
						$this->db->update('user_conditions');
						
						/*--- GETS $quantity VEHICLES FROM THE CREATER OF THE ARTICLE ---*/
						$this->db->where('uc_user_id', $row_article['shop_art_user_id']);
						$this->db->set('uc_vehicles', "uc_vehicles-$quantity", FALSE);
						$this->db->update('user_conditions');
					}
					/*--- UPDATES USER'S CONDITIONS PLUS QUANTITY OF JEWERIES ---*/
					if($row_article['shop_art_cat_id'] == 3) {
						$this->db->where('uc_user_id', $this->user_id);
						$this->db->set('uc_jewelries', "uc_jewelries+$quantity", FALSE);
						$this->db->update('user_conditions');
						/*--- GETS $quantity JEWERIES FROM THE CREATER OF THE ARTICLE ---*/
						$this->db->where('uc_user_id', $row_article['shop_art_user_id']);
						$this->db->set('uc_jewelries', "uc_jewelries-$quantity", FALSE);
						$this->db->update('user_conditions');
					}
					return "bought";
				}
			} else {
				redirect(base_url());
			}
		}
		/***** END OF buy_shop_product *****/
		/*---- DELETES ARTICLES ----*/
		public function delete_shop_article() {
			$val = $this->input->post('val');
			$article = $this->input->post('article');
			if($val == 1) {
				/*--- CHECKS IF THE USER IS THE OWNER OF THE AREA ---*/
				$q_is_owner = $this->db->get_where('shop_articles', array('shop_article_id'=>$article,'shop_art_user_id'=>$this->user_id));
				if($q_is_owner->num_rows() < 1) {
					exit();
				} else {
					$this->db->delete('shop_articles', array('shop_article_id' => $article));
				}
			} else {
				redirect(base_url());
			}
		}
		/***** END OF DELETING ARTICLES ****/
		/*----------------------------------------------------------------------------------------------------
													# SOME FUNCTIONS #
		------------------------------------------------------------------------------------------------------*/
		/*---- FORMATING THOUSANDD, MILLIONS AND BILLIONS  ----*/
		public function format_big_numbers($n) {
			if($n>1000000000) return round(($n/1000000000),2).' B';
			else if($n>1000000) return round(($n/1000000),2).' M';
			return number_format($n);
		}
		/**** END of format_big_numbers() ****/
		/*---- CALCULATES HOW MANY 'tuzar' TO GIVE TO THE USER  ----*/
		public function get_product_tuzar($subcat, $prize) {
			if($subcat == 8) { // CAR
				$tuzar = 35;
			}
			if($subcat == 9) { // GULFSTREAM JET 
				$tuzar = 7000;
			} 
			if($subcat == 10) { // CESSENA
				$tuzar = 350;
			}
			if($subcat == 11) { // EMBRAER LEGACY 600 (2005.)
				$tuzar = 950;
			}
			if($subcat == 12) { // BOMBARDIER (2006)
				$tuzar = 650;
			}
			if($subcat == 13) { //BENETEAU 323 
				$tuzar = 100;
			}
			if($subcat == 14) { //112' DOMINO (2006.)
				$tuzar = 700;
			}
			if($subcat == 15) { //PALMER JOHNSON DB9 52 M (2010.)
				$tuzar = 15000;
			}
			if($subcat == 16) { //DIAMOND 10
				$tuzar = 150;
			}
			if($subcat == 17) { //NECHLACE
				$tuzar = 135;
			}
			if($subcat == 18) { // DIAMOND BRACELETS
				$tuzar = 100;
			}
			if($subcat == 19) { //NECHLACE
				$tuzar = 75;
			}
			if($subcat == 20) { //NECKLACE
				$tuzar = 40;
			}
			return $tuzar;
		}
		/**** END of get_product_tuzar() ****/
	}