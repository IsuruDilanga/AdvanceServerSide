<?php
	class Todolist_model extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		public function getlistitem($userid, $priorityOrder){
			$this->db->where("userid = '$userid'");
			$this->db->order_by('priority_level', $priorityOrder);
			$query = $this->db->get('actions');
			return $query->result_array();
		}


	}
