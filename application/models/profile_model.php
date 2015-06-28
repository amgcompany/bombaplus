<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Profile_model extends CI_Model {
		private $user_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			$this->user_id = $this->session->userdata('user_id');
		}
		/*----------------------------------------------------------------
						# GETTING USER'S PROFILE WITH ID #
		------------------------------------------------------------------*/
		public function get_profile($id) {
			$data = array();
			
			if($id != 0 && $id != '') {
				
				$this->db->select("*");
				$this->db->from('accounts');
				$this->db->join('user_conditions', 'user_conditions.uc_user_id = accounts.user_id');
				$this->db->where("accounts.user_id = $id");
				$does_exist = $this->db->get();
				/*--- CHECKS IF THERE IS SUCH USER WITH $id IN THE DB ---*/
				if($does_exist->num_rows() == 1) {
					$row_user = $does_exist->row_array(); // IN THIS VARIABLE WILL BE THE MAIN USER'S INFORMATION
					
					/*--- CHECKS IF THE USER HAS PROFILE PICTURE ---*/
					$q_pic = $this->db->get_where('user_avatar_picture', array('uap_user_id' => $id));
					if($q_pic->num_rows() >= 1) { // HE HAS PICTURE
						$row_qpic = $q_pic->row_array();
						$row_user['avatar_picture'] = $row_qpic['u_avatar_picture'];
					} else {// HE HASN'T pic
						$row_user['avatar_picture'] = 'none';
					}
					/** END Of checking user's profile picture **/
					
					$data[] = $row_user;

					return $data;
				} else {
					redirect(base_url());
				}
			} else {
				redirect(base_url());
			}
		}
		/**** END of get_profile ****/
		/*---------------------------------------------------------------
					# UPLOADING USER AVATAR PICTURE #
		------------------------------------------------------------------*/
		public function do_upload() {
			if(isset($_FILES['userfile']['name'])) {
				$config['upload_path'] = './uploaded_pictures/avatars';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '6144';
				$config['max_width'] = "2048"; 
				$config['max_height'] = "2048";
				
				$newFileName = strtolower($this->new_name($_FILES['userfile']['name']));
				$config['file_name'] = $newFileName;
				
				$this->load->library('upload',$config);
				if(!$this->upload->do_upload()) {
					echo $this->upload->display_errors();
					//$error = array('error'=>$this->upload->display_errors());
				} else {
					$upload_data = $this->upload->data();
					$q_check = $this->db->get_where('user_avatar_picture', array('uap_user_id' => $this->user_id));
					if($q_check->num_rows() == 0) {
						$upd_arr = array(
							'uap_user_id'		=> $this->user_id,
							'u_avatar_picture'	=> $upload_data['file_name'],
							'uap_ip'			=> $_SERVER['REMOTE_ADDR']
						);
						$this->db->insert('user_avatar_picture', $upd_arr);
					} else {
						$this->db->where('uap_user_id', $this->user_id);
						$this->db->update('user_avatar_picture', array('u_avatar_picture' => $upload_data['file_name']));
					}
					return $upload_data['file_name'];
				}
			}
		}
		/*** END of avatar_upload ***/
		/*--------------------------------------------------------------------------
					CHECKS IF HAS A CONVERSATION WITH THIS USER
		--------------------------------------------------------------------------*/
		public function get_profile_conv($id) {
			$firstUser = $id;
			$secondUser = $this->user_id;
			$sqlCheckConv	=	"SELECT mess_hash FROM message_group
							WHERE (user_one='$firstUser' AND user_two='$secondUser') 
							OR (user_one='$secondUser' AND user_two='$firstUser')";
			$q = $this->db->query($sqlCheckConv);
			if($q->num_rows() >= 1) {
				$row_conv = $q->row_array();
				return $row_conv['mess_hash'];
			} else {
				return '0';
			}
		}
		/*** ***/
		/*--- GIVING NEW NAME TO THE UPLOADED PIC ---*/
		public function new_name($exp)	{
			$symbols = "123456789qwertyuiopasdfgjklzxcvbnm";
			return substr(str_shuffle($symbols),0,25).".".$exp;
		}
	}