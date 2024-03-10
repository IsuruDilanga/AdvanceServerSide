<?php

	class Auth_model extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		public function authenticate($userid, $password){
			$this->db->where("(userid = '$userid' OR email = '$userid')");
			$this->db->where('password', $password);

			// Get the user data based on the provided criteria
			$query = $this->db->get('userTable');

			// Check if there is a matching row
			if ($query->num_rows() == 1) {
				return 'true'; // Return true if a matching row is found
			} else {
				return 'false'; // Return false if no matching row is found
			}

		}

	}
