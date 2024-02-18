<?php
	class Films_Model extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		public function get_film_all_data(){
			$query = $this->db->get('films');
			return $query->result_array();
		}

		public function get_comedy_films(){
			$query = $this->db->get_where('films', array('genre' => 'Comedy', 'IMDB_rating >' => '5.0'));
			return $query->result_array();
		}

	}
