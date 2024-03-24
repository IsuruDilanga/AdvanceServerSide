<?php
	class SearchByWord_model extends CI_Model{

		public function __construct(){
			parent::__construct();
		}

		public function get_movie_by_name($name = FALSE){
			if($name === FALSE){
				$query = $this->db->get('films');
				return $query->result_array();
			}

			$this->db->select('*');
			$this->db->like('title', $name);
			$query = $this->db->get('films');
			if ($query->num_rows() > 0) {
				return $query->result_array();
			}else{
				return false;
			}
		}
	}
