<?php
	class word_definition_model extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		public function wordDefinition($word){

			$query = $this->db->get_where('word_definition', array('word' => $word));
			return $query->row_array();

		}

	}
