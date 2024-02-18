<?php

	class Details_model extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		public function get_details($name  = FALSE){
			if($name === FALSE){
				$query = $this->db->get('dinosaursDetails');
				return $query->result_array();
			}

			$query = $this->db->get_where('dinosaursDetails', array('name' => $name));
			return $query->row_array();
		}

	}
