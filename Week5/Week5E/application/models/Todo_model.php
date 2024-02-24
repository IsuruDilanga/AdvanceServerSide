<?php
	class Todo_model extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		public function getToDoList($user_id = FALSE){

			if($user_id === FALSE){
				$query = $this->db->get('todo');
				return $query->result_array();
			}
			$query = $this->db->get_where('todo', array('user_id' => $user_id));
			return $query->row_array();

		}
		public function addToDoList($actionTitle, $date, $user_id){
			$this->db->insert('todo', array('action_title' => $actionTitle,
											'date' => $date,
											'user_id' => $user_id));

		}
	}
