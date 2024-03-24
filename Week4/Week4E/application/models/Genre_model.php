<?php

	class Genre_model extends CI_Model{

		public function __construct(){
//			$this->load->database();
			parent::__construct();
		}

		public function get_genre(){
			$this->db->distinct();
			$this->db->select('genre');
			$query = $this->db->get('films');
			return $query->result_array();
		}

		public function get_title_by_genre($genre){
			$this->db->select('title');
			$this->db->where('genre', $genre);
			$query = $this->db->get('films');
			return $query->result_array();
		}
	}
