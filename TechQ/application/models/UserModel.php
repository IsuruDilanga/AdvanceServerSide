<?php

class UserModel extends CI_Model{


	/**
	 * This function logs in a user by checking the provided username/email and password against the database.
	 *
	 * @param string $username The username or email of the user to be logged in.
	 * @param string $password The password of the user to be logged in.
	 * @return object|bool The user data if the login is successful, FALSE otherwise.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function loginUser($username, $password){
		// Log the start of the loginUser function
		log_message('debug', 'UserModel::loginUser()');

		// Select all fields from the users table
		$this->db->select('*');
		$this->db->where("(username = '$username' OR email = '$username')");
		$this->db->where('password', $password);
		$this->db->from('users');

		// Retrieve the user data from the database
		$respond = $this->db->get();

		// If the user data is retrieved successfully
		if($respond->num_rows() == 1){
			log_message('info', 'UserModel::loginUser() - User logged in successfully.');

			// Return the user data
			return ($respond->row(0));
		}else{
			// Log the failed login
			log_message('error', 'UserModel::loginUser() - Failed to log in user.');

			// If the login is not successful, return FALSE
			return false;
		}
	}

	/**
	 * This function registers a new user by inserting the provided user data into the database.
	 *
	 * @param array $userData The data of the user to be registered.
	 * @return bool TRUE if the user was successfully registered, FALSE otherwise.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function registerUser($userData){
		// Log the start of the registerUser function
		log_message('debug', 'UserModel::registerUser()');

		// Insert the provided user data into the users table
		$insertDetails = $this->db->insert('users', $userData);

		// Log the result of the insertion operation
		if($insertDetails){
			log_message('info', 'UserModel::registerUser() - User registered successfully.');
		} else {
			log_message('error', 'UserModel::registerUser() - Failed to register user.');
		}

		// Return the result of the insertion operation
		return $insertDetails;
	}


	/**
	 * This function updates a user's data in the database if the provided data is different from the existing data.
	 *
	 * @param int $user_id The ID of the user to be updated.
	 * @param array $userData The new data of the user.
	 * @return bool TRUE if the user data was successfully updated, FALSE otherwise.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function updateUser($user_id, $userData){
		log_message('debug', 'UserModel::updateUser()');

		// Select specific columns from the users table
		$this->db->select('user_id, username, occupation, name, email');
		$this->db->where('user_id', $user_id);
		$existingData = $this->db->get('users')->row_array();

		// Check if the existing data is different from $userData
		$isDifferent = false;
		foreach ($existingData as $key => $value) {
			if (isset($userData[$key]) && $existingData[$key] !== $userData[$key]) {

				log_message('info', 'UserModel::updateUser() - User data is different.');

				// Set the flag to indicate that the data is different
				$isDifferent = true;
				break;
			}
		}

		// If the data is different
		if ($isDifferent) {
			log_message('debug', 'UserModel::updateUser() - Updating user data.');

			// Update the user data in the database
			$this->db->where('user_id', $user_id);
			$updateDetails = $this->db->update('users', $userData);

			// Log the result of the update operation
			if($updateDetails){
				log_message('info', 'UserModel::updateUser() - User data updated successfully.');
			} else {
				log_message('error', 'UserModel::updateUser() - Failed to update user data.');
			}

			// Return the result of the update operation
			return $updateDetails;
		} else {
			log_message('info', 'UserModel::updateUser() - User data is already up to date.');

			// If the data is already up to date, return FALSE
			return false;
		}
	}


	/**
	 * This function updates a user's password in the database if the provided old password matches the existing password.
	 *
	 * @param int $user_id The ID of the user whose password is to be updated.
	 * @param string $oldpassword The old password of the user.
	 * @param string $newpassword The new password of the user.
	 * @return string|bool The new password if the password was successfully updated, FALSE otherwise.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function updatePassword($user_id,  $oldpassword, $newpassword) {

		log_message('debug', 'UserModel::updatePassword()');

		// Retrieve existing password from the database
		$this->db->select('password');
		$this->db->where('user_id', $user_id);
		$existingPasswordQuery = $this->db->get('users');

		// Check if user exists and retrieve the existing password
		if ($existingPasswordQuery->num_rows() > 0) {
			$existingPasswordRow = $existingPasswordQuery->row();
			$existingPassword = $existingPasswordRow->password;

			// Compare old password with the existing password
			if ($oldpassword == $existingPassword) {

				log_message('info', 'UserModel::updatePassword() - Old password matches existing password.');

				// Update password
				$this->db->where('user_id', $user_id);
				$this->db->update('users', array('password' => $newpassword));

				// Check if the password was successfully updated
				if ($this->db->affected_rows() > 0) {
					log_message('info', 'UserModel::updatePassword() - Password updated successfully.');

					// Return the new password
					return $newpassword;
				} else {
					log_message('error', 'UserModel::updatePassword() - Failed to update password.');

					// Return FALSE if the password update failed
					return false;
				}
			} else {
				log_message('info', 'UserModel::updatePassword() - Old password does not match existing password.');

				// Return FALSE if the old password does not match the existing password
				return false;
			}
		} else {
			log_message('info', 'UserModel::updatePassword() - User not found.');

			// Return FALSE if the user is not found
			return false;
		}
	}


	/**
	 * This function updates a user's password in the database if the user exists.
	 *
	 * @param string $username The username or email of the user whose password is to be updated.
	 * @param string $newpassword The new password of the user.
	 * @return bool TRUE if the password was successfully updated, FALSE otherwise.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function forgetPassword($username, $newpassword){
		log_message('debug', 'UserModel::forgetPassword()');

		// Select the password field from the users table
		$this->db->select('password');
		$this->db->where("(username = '$username' OR email = '$username')");
		$existingPasswordQuery = $this->db->get('users');

		// If the user exists
		if($existingPasswordQuery->num_rows() > 0) {
			log_message('info', 'UserModel::forgetPassword() - User found.');

			// Update the password in the database
			$this->db->where("(username = '$username' OR email = '$username')");
			$updatepassword = $this->db->update('users', array('password' => $newpassword));

			// Log the result of the update operation
			if($updatepassword){
				log_message('info', 'UserModel::forgetPassword() - Password updated successfully.');
			} else {
				log_message('error', 'UserModel::forgetPassword() - Failed to update password.');
			}

			// Return the result of the update operation
			return $updatepassword;
		} else {
			log_message('info', 'UserModel::forgetPassword() - User not found.');

			// If the user does not exist, return FALSE
			return false;
		}
	}


	/**
	 * This function updates a user's image in the database if the provided image data is different from the existing image data.
	 *
	 * @param int $user_id The ID of the user whose image is to be updated.
	 * @param array $userData The new image data of the user.
	 * @return bool TRUE if the image data was successfully updated, FALSE otherwise.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function updateUserImage($user_id, $userData){

		log_message('debug', 'UserModel::updateUserImage()');

		// Select the userimage field from the users table
		$this->db->select('userimage');

		// Where the user_id field matches the provided user_id
		$this->db->where('user_id', $user_id);

		// Retrieve the existing image data from the database
		$existingData = $this->db->get('users')->row_array();

		// Check if the existing data is different from $userData
		$isDifferent = false;
		foreach ($existingData as $key => $value) {
			if (isset($userData[$key]) && $existingData[$key] !== $userData[$key]) {

				log_message('info', 'UserModel::updateUserImage() - User image data is different.');

				// Set the flag to indicate that the data is different
				$isDifferent = true;
				break;
			}
		}

		// If the data is different
		if ($isDifferent) {

			log_message('debug', 'UserModel::updateUserImage() - Updating user image data.');

			// Update the image data in the database
			$this->db->where('user_id', $user_id);
			$updateDetails = $this->db->update('users', $userData);

			// Log the result of the update operation
			if($updateDetails){
				log_message('info', 'UserModel::updateUserImage() - User image data updated successfully.');
			} else {
				log_message('error', 'UserModel::updateUserImage() - Failed to update user image data.');
			}

			// Return the result of the update operation
			return $updateDetails;
		} else {

			log_message('info', 'UserModel::updateUserImage() - User image data is already up to date.');

			// If the data is already up to date, return FALSE
			return false;
		}
	}


	/**
	 * This function retrieves a user's data from the database based on the provided user ID.
	 *
	 * @param int $id The ID of the user to be retrieved.
	 * @return object The user data if the user exists, NULL otherwise.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function getUser($id){
		log_message('debug', 'UserModel::getUser()');

		// Select all fields from the users table
		$this->db->select('*');
		$this->db->where('userID', $id);
		$this->db->from('users');

		// Retrieve the user data from the database
		$respond = $this->db->get();

		// Log the result of the retrieval operation
		if($respond->row()){
			log_message('info', 'UserModel::getUser() - User data retrieved successfully.');
		} else {
			log_message('info', 'UserModel::getUser() - User not found.');
		}

		// Return the user data
		return $respond->row();
	}


	/**
	 * This function checks if a user exists in the database based on the provided username or email.
	 *
	 * @param string $username The username or email of the user to be checked.
	 * @return bool TRUE if the user exists, FALSE otherwise.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function checkUser($username){
		log_message('debug', 'UserModel::checkUser()');

		// Select the username and email fields from the users table
		$this->db->select('username, email');
		$this->db->where("(username = '$username' OR email = '$username')");
		$respond = $this->db->get('users');

		// If the user data is retrieved successfully
		if($respond->num_rows() == 1){
			log_message('info', 'UserModel::checkUser() - User found.');

			// Return TRUE to indicate that the user exists
			return true;
		}else{
			log_message('info', 'UserModel::checkUser() - User not found.');

			// If the user does not exist, return FALSE
			return false;
		}
	}

}
