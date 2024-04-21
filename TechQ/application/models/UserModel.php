<?php

class UserModel extends CI_Model{

	public function loginUser($username, $password){

		$this->db->select('*');
		$this->db->where('username', $username);
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
