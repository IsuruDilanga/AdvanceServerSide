<?php

class UserModel extends CI_Model{

	public function loginUser($username, $password){

		if($username == "admin" && $password == "admin"){

			$user = array(
				"user_id" => 1,
				"username" => "admin",
				"password" => "admin"
			);
			return $user;
		}
	}

}
