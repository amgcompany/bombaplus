<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Bugs_model extends CI_Model {
		public function __construct() {
			parent::__construct();
		}
		/* GETS ALL BUGS FROM DB  */
		public function get_bugs() {
			$data = array();
			$q = $this->db->query("SELECT * FROM bugs ORDER BY bug_id DESC");
			foreach($q->result_array() as $row) {
				$data[] =  $row;
			}
			return $data;
		}
		/* ADDS BUGS */
		public function add_bug() {
			$type 	= $this->input->post('type');
			$bug 	= $this->input->post('bug');
			$where 	= $this->input->post('where');
			$ip		= $_SERVER['REMOTE_ADDR'];
			$user_id = $this->session->userdata('user_id');
			
			$add = array(
				'bug_type'			=> $type,
				'bug_description'	=> $bug,
				'bug_page'			=> $where,
				'bug_ip'			=> $ip,
				'bug_user_id_added'	=> $user_id
			);
			$this->db->insert('bugs', $add);
		}
		/* MAKES THE BUG REPAIRED */
		public function repair_bug($id) {
			$this->db->where('bug_id', $id);
			$this->db->update('bugs', array('bug_repaired'=>'1'));
		}
		/* DELETES BUG */
		public function delete_bug($id) {
			$this->db->delete('bugs', array('bug_id'=>$id));
		}
	}