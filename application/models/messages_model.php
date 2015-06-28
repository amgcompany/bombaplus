<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Messages_model extends CI_Controller {
		private $user_id,
				$select_id,
				$selected_id;
		public function __construct() {
			parent::__construct();
			date_default_timezone_set("Europe/Sofia");
			$this->user_id = $this->session->userdata('user_id');
		}
		/*--- GETS CONVERSATIONS ---*/
		public function get_conversations() {	
			$data = array();
			/* QUERY GETS LAST 10 CONVERSATIONS AND ORDERS THEM BY mess_group_date DESC */
			$this->db->select('user_one, user_two, mess_hash, mess_group_date');
			$this->db->where("user_one = '$this->user_id' OR user_two='$this->user_id'");
			$this->db->order_by('mess_group_date', 'DESC');
			$q = $this->db->get('message_group');

			foreach($q->result_array() AS $key => $row) {
				$hash = $row['mess_hash'];
				/* GETS FROM WHO IS THE MESS user_one OR user_two FROM DB */
				$user_one = $row['user_one'];
				$user_two = $row['user_two'];
	
				if($user_one == $this->user_id) {
					$this->select_id = $user_two;
				} else {
					$this->select_id = $user_one;
				}
				/*--- end of getting selected user ---*/
				
				/* GETS USERNAME OF THE SELECTED USER */
				$q_user_info = $this->db->get_where('accounts', array('user_id' => $this->select_id));
				$row_qui = $q_user_info->row_array();
				/**** END OF GETS USERNAME OF THE SELECTED USER ****/
				
				/*--- GETS PROFILE PICTURE ---*/
				$q_pic = $this->db->get_where('user_avatar_picture', array('uap_user_id' => $this->select_id));
				if($q_pic->num_rows() > 0) {
					$row_pic = $q_pic->row_array();
					$row['picture'] = $row_pic['u_avatar_picture'];
				} else {
					$row['picture'] = 'none';
				}
				/*** END OF GETS PROFILE PICTURE ***/
				
				/*--- GETS THE LAST MESSAGE TO SHOW ---*/
				$this->db->select('*');
				$this->db->where("mess_group_hash = $hash");
				$this->db->order_by('mess_id', 'DESC');
				$q_mess = $this->db->get('messages');
				//$q_mess = $this->db->get_where('messages', array('mess_group_hash' => $hash));
				$row_qm = $q_mess->row_array();
				/**** END OF LAST MESSAGE ****/
				
				$row['last_mess'] = $this->substr_unicode($row_qm['message'],0,150);
				$row['username'] = $row_qui['username'];
				$row['mess_date'] = $row_qm['mess_date'];
				$row['mess_clock'] = $row_qm['mess_clock'];
				$row['mess_viewed'] = $row_qm['mess_viewed'];
				$row['mess_from_id'] = $row_qm['mess_from_id'];
				$data[] = $row;
			}		
			return $data;
		}
		/*** END OF get_conversations ***/
		/*--- DECREASES THE NUMBER OF SYMBOLS ---*/
		private function substr_unicode($str, $s, $l = null) {
			return join("", array_slice(
				preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
		}
		/*** END of substr_unicode ***/
		
		/*-----------------------------------------------------*/
		
		/*--- GETS ONE CONVERSATION ---*/
		public function conversation($conv) {
			$data = array();
			/*$this->db->select('mess_id, message, mess_group_hash, mess_from_id');
			$this->db->where("mess_group_hash='$conv'");
			$this->db->order_by('mess_id','DESC');
			$q_view_con = $this->db->get('messages', 1, 0);*/
			$q_view_con = $this->db->query("SELECT mess_id, message, mess_group_hash, mess_from_id
								FROM messages WHERE mess_group_hash='$conv' ORDER BY mess_id DESC LIMIT 1");
			$row_view_con = $q_view_con->row_array();
			
			/* If the message is not from user with ID session->user_id then make the message as viewed */
			if($row_view_con['mess_from_id'] != $this->user_id) {
				$this->db->where('mess_group_hash', $conv);
				$this->db->update('messages', array('mess_viewed'=>'1'));
			}
			/* CHECKS if the hash in the URL is valid, if is not the user will be redirected */
			$this->db->select('user_one, user_two, mess_hash');
			$this->db->where("(user_one = '$this->user_id' OR user_two = '$this->user_id') AND mess_hash='$conv'");
			$q_is_conv = $query = $this->db->get('message_group');
			
			$row_qiscon = $q_is_conv->row_array();
			if($row_qiscon['mess_hash'] != $conv) {
				redirect(base_url().'messages');
			}
				/* GETS FROM WHO IS THE MESS user_one OR user_two FROM DB */
				$user_one = $row_qiscon['user_one'];
				$user_two = $row_qiscon['user_two'];
	
				if($user_one == $this->user_id) {
					$this->selected_id = $user_two;
				} else {
					$this->selected_id = $user_one;
				}
				/*--- end of getting selected user ---*/
				
			/* GETS LAST 50 MESSAGES FROM THE CONVERSATION */
			$q_conv = $this->db->query("SELECT mess_id, message, mess_group_hash, mess_from_id, mess_date, mess_clock 
										FROM messages 
										WHERE mess_group_hash='$conv' 
										ORDER BY mess_date DESC 
										LIMIT 50
									");
			foreach($q_conv->result_array() AS $row) {
				/* GETS usernames */
				$this->db->select('username');
				$this->db->where("user_id = '$row[mess_from_id]'");
				$q_ui = $this->db->get('accounts');
				$row_qui = $q_ui->row_array(); 
				
				$row['username'] = $row_qui['username'];
				
				/*--- GETS PROFILE PICTURE ---*/
				$q_pic = $this->db->get_where('user_avatar_picture', array('uap_user_id' => $row['mess_from_id']));
				if($q_pic->num_rows() > 0) {
					$row_pic = $q_pic->row_array();
					$row['picture'] = $row_pic['u_avatar_picture'];
				} else {
					$row['picture'] = 'none';
				}
				/*** END OF GETS PROFILE PICTURE ***/
				
				$data[] = $row;
			}
			return $data;
		}
		/*** END of conversation ***/
		public function get_selected_id() {
			return $this->selected_id;
		}
		/*-----------------------------------------------------*/
		
		/*--- CHEKS IF THE CONVERSATION EXISTS AND MORE THINGS ---*/
		private function check_conversation($firstUser, $secondUser, $mess, $d, $c, $i) {
			$rand = rand();
			
			$sqlCheckConv="SELECT mess_hash FROM message_group
							WHERE (user_one='$firstUser' AND user_two='$secondUser') 
							OR (user_one='$secondUser' AND user_two='$firstUser') ";
							
			$qCheckConv = mysql_query($sqlCheckConv)or die(mysql_error());	
			
			$brConv = mysql_num_rows($qCheckConv);
			$row_ids = mysql_fetch_assoc($qCheckConv);
			$message = array(
				'mess_group_hash'	=> $row_ids['mess_hash'],
				'mess_from_id'		=> $firstUser,
				'message'			=> $mess,
				'mess_date'			=> $d,
				'mess_clock'		=> $c,
				'mess_ip'		=> $i,
			);	

			$sqlUpdateTime = "UPDATE message_group SET 
				mess_group_date='$d' 
				WHERE mess_hash='$row_ids[mess_hash]'";
			
			if($brConv == 1) {	
				$this->db->insert('messages', $message);
				$this->db->query($sqlUpdateTime);
			} else {
				// CREATES NEW CONVERSATION
				if($firstUser == $this->user_id && $secondUser != $this->user_id) {
					$mg_data = array(
						'user_one' 		=> $firstUser,
						'user_two' 	=> $secondUser,
						'mess_hash' 	=> $rand,
						'mess_group_date' => date(time())
					);
					$this->db->insert('message_group', $mg_data);

					$m_data = array(
						'mess_group_hash' 		=> $rand,
						'mess_from_id' 	=> $firstUser,
						'message' 	=> $mess,
						'mess_date' => $d,
						'mess_clock' => $c,
						'mess_ip' => $i
					);
					$this->db->insert('messages', $m_data);
				} else {
					exit();
				}
			}
		}
		/*--- WRITES AND SENDS NEW MESSAGE ---*/
		public function write_message() {
			(int) $from = $this->input->post('from');
			(int) $toid = $this->input->post('to');
			
			$date = time();
			$clock = date('H:i',time());
			$ip = $_SERVER['REMOTE_ADDR'];
			
			$message = $this->input->post('message');
			if(mb_strlen($message, "UTF-8")>=1) {
				$this->check_conversation($from, $toid, $message, $date, $clock, $ip);
			}
		}
		/*** END of write_message() ***/
		/*--- COUNTS UNREAD MESSAGES ---*/
		public function unread_mess() {
			$q = $this->db->query("SELECT user_one, user_two, mess_hash, mess_group_hash, mess_viewed, mess_from_id, mess_id 
				FROM message_group JOIN messages ON (mess_hash=mess_group_hash)
				WHERE (user_one = '$this->user_id' OR user_two='$this->user_id') 
				AND mess_viewed='0'
				AND mess_from_id != '$this->user_id'
				");
			return $q->num_rows();
		}
		/*** END OF  UNREAD MESSAGES ***/
		
	}