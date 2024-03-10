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

		public function addToDoList($user_id, $actionTitle, $date, $priority){
			$this->db->insert('actions', array('userid' => $user_id,
				'action_titles' => $actionTitle,
				'added_date' => $date,
				'priority_level' => $priority));

		}

	}
