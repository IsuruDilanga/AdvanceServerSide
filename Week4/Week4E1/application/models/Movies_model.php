<?php
	class Movies_model extends CI_Model{

		public function __construct(){
			parent::__construct();
		}

		public function get_search_results($genre = FALSE, $IMDB_rating = FALSE){
			if($genre === FALSE && $IMDB_rating === FALSE){
				$query = $this->db->get('films');
				if($query->num_rows() > 0){
					return $query->result_array();
				}else{
					return false;
				}
			}

			$this->db->select('*');
			$this->db->where('genre', $genre);
			$this->db->where('IMDB_rating', $IMDB_rating);
			$query = $this->db->get('films');
			if ($query->num_rows() > 0) {
				return $query->result_array();
			}else{
				return false;
			}
		}

		public function get_all_movies(){
			$query = $this->db->get('films');
			return $query->result_array();
		}
	}
