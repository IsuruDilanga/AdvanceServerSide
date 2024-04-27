<?php

class UserModel extends CI_Model{

	public function loginUser($username, $password){

		$this->db->select('*');
		$this->db->where("(username = '$username' OR email = '$username')");
		$this->db->where('password', $password);
		$this->db->from('users');

		$respond = $this->db->get();
		if($respond->num_rows() == 1){
			return ($respond->row(0));
		}else{
			return false;
		}
	}

	public function registerUser($userData){
		$insertDetails = $this->db->insert('users', $userData);
		return $insertDetails;
	}

	public function updateUser($user_id, $userData){
		// Select specific columns from the database table
		$this->db->select('user_id, username, occupation, name, email');
		$this->db->where('user_id', $user_id);
		$existingData = $this->db->get('users')->row_array();

		// Check if the existing data is different from $userData
		$isDifferent = false;
		foreach ($existingData as $key => $value) {
			if (isset($userData[$key]) && $existingData[$key] !== $userData[$key]) {
				$isDifferent = true;
				break;
			}
		}

		if ($isDifferent) {
			// Perform the update
			$this->db->where('user_id', $user_id);
			$updateDetails = $this->db->update('users', $userData);
			return $updateDetails;
		} else {
			// Data is already up to date, no need to update
			return false;
		}
	}

	public function updateUserImage($user_id, $userData){

		$this->db->select('userimage');
		$this->db->where('user_id', $user_id);
		$existingData = $this->db->get('users')->row_array();

		// Check if the existing data is different from $userData
		$isDifferent = false;
		foreach ($existingData as $key => $value) {
			if (isset($userData[$key]) && $existingData[$key] !== $userData[$key]) {
				$isDifferent = true;
				break;
			}
		}

		if ($isDifferent) {
			// Perform the update
			$this->db->where('user_id', $user_id);
			$updateDetails = $this->db->update('users', $userData);
			return $updateDetails;
		} else {
			// Data is already up to date, no need to update
			return false;
		}
	}

	public function getUser($id){
		$this->db->select('*');
		$this->db->where('userID', $id);
		$this->db->from('users');

		$respond = $this->db->get();
		return $respond->row();
	}


	public function checkUser($username){
		$this->db->select('username');
		$this->db->where('username', $username);
		$respond = $this->db->get('users');
		if($respond->num_rows() == 1){
			return true;
		}else{
			return false;
		}
	}

}
