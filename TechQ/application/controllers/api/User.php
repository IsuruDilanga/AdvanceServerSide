<?php

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';

class User extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('UserModel');
	}

	public function login_post(){
		$_POST = json_decode(file_get_contents("php://input"), true);
		$this->form_validation->set_rules('username', 'checkUsername', 'required');
		$this->form_validation->set_rules('password', 'checkPassword', 'required');

		if($this->form_validation->run() == FALSE){
			$this->response("Something went wrong!.", REST_Controller::HTTP_BAD_REQUEST);
		}else{
			$username = strip_tags($this->post('username'));
			$password = strip_tags($this->post('password'));

			$result = $this->UserModel->loginUser($username, sha1($password));
//			$result = $this->UserModel->loginUser($username, $password);
//			print_r($result);
			if($result != false){
				$this->response(array(
						'status' => TRUE,
						'message' => 'User has logged in successfully.',
						'data' => true,
						'username' => $result->username,
						'user_id' => $result->user_id,
						'premium' => $result->premium,
						'occupation' => $result->occupation,
						'userimage'=> $result->userimage,
						'name' => $result->name,
						'email' => $result->email,
						'answerquestioncnt' => $result->answerquestioncnt,
						'askquestioncnt' => $result->askquestioncnt,
					), REST_Controller::HTTP_OK);
			}else{
				$this->response("Enter valid username and password", REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}

	public function ask_question_image_post() {
		// Check if file is uploaded
		if (!empty($_FILES['image']['name'])) {
			// Define upload directory
			$uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/TechQ/assets/images/question/';

			log_message('debug', 'uploadDir: ' . $uploadDir);


			// Set upload configuration
			$config['upload_path'] = $uploadDir;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = 1024 * 10; // 2 MB

			// Load upload library
			$this->load->library('upload', $config);

			// Perform upload
			if ($this->upload->do_upload('image')) {
				// File uploaded successfully
				$uploadData = $this->upload->data();
//				$imagePath = '/Applications/XAMPP/xamppfiles/htdocs/TechQ/assets/images/' . $uploadData['file_name'];
				$imagePath = '../../assets/images/question/' . $uploadData['file_name'];
				$this->response(array('imagePath' => $imagePath), REST_Controller::HTTP_OK);
			} else {
				// Error uploading file
				$this->response(array('error' => $this->upload->display_errors()), REST_Controller::HTTP_BAD_REQUEST);
			}
		} else {
			// No file uploaded
			$this->response(array('imagePath' => ''), REST_Controller::HTTP_OK);		}
	}

	public function register_post(){
		$_POST = json_decode(file_get_contents("php://input"), true);
//		$this->form_validation->set_rules('username', 'checkUsername', 'required');
//		$this->form_validation->set_rules('password', 'checkPassword', 'required');
//		$this->form_validation->set_rules('occupation', 'checkOccupation', 'required');
//		$this->form_validation->set_rules('premium', 'checkPremium', 'required');
//		$this->form_validation->set_rules('name', 'checkName', 'required');
//		$this->form_validation->set_rules('email', 'checkEmail', 'required');

		$username = strip_tags($this->post('username'));
		$password = strip_tags($this->post('password'));
		$occupation = strip_tags($this->post('occupation'));
		$premium = strip_tags($this->post('premium'));
		$name = strip_tags($this->post('name'));
		$email = strip_tags($this->post('email'));

		if(!empty($username) && !empty($password) &&!empty($occupation) && !empty($name) && !empty($email)){

			$userData = array(
				'username' => $username,
				'password' => sha1($password),
				'occupation' => $occupation,
				'premium' => $premium,
				'name' => $name,
				'email' => $email
			);

			if($this->UserModel->checkUser($username)) {
				$this->response("Username already exists", 409);
			}else{
				$userInformation = $this->UserModel->registerUser($userData);
				if($userInformation){
					$this->response(array(
						'status' => TRUE,
						'message' => 'User has been registered successfully.',
						'data' => $userInformation)
						, REST_Controller::HTTP_OK);
				}else{
					$this->response("Failed to register user", REST_Controller::HTTP_BAD_REQUEST);
				}
			}

		}else{
			$this->response("Enter valid information", REST_Controller::HTTP_BAD_REQUEST);
		}

	}

	public function edit_user_post(){
		$user_id = strip_tags($this->post('user_id'));
		$username = strip_tags($this->post('username'));
		$occupation = strip_tags($this->post('occupation'));
		$premium = strip_tags($this->post('premium'));
		$name = strip_tags($this->post('name'));
		$email = strip_tags($this->post('email'));

		if(!empty($user_id) && !empty($username) && !empty($occupation) && !empty($name) && !empty($email)){

			$userData = array(
				'user_id' => $user_id,
				'username' => $username,
				'occupation' => $occupation,
				'premium' => $premium,
				'name' => $name,
				'email' => $email
			);

			$updateUser = $this->UserModel->updateUser($user_id, $userData);
			if($updateUser !== false) {
				// User was updated successfully
				$this->response(array(
					'status' => TRUE,
					'message' => 'User has been updated successfully.',
					'data' => $userData) // Return updated user data
					, REST_Controller::HTTP_OK);
			} else {
				// Update was not performed, possibly due to data being already up to date
				$this->response(array(
					'status' => FALSE,
					'message' => 'User data is already up to date.',
					'data' => null) // Return null data or an appropriate message
					, REST_Controller::HTTP_OK);
			}

		}else{
			$this->response("Enter valid information", REST_Controller::HTTP_BAD_REQUEST);
		}

	}

	public function edit_user_image_post(){
		if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
			// Define upload directory
			$uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/TechQ/assets/images/userimage/';

			log_message('debug', 'uploadDir: ' . $uploadDir);

			// Set upload configuration
			$config['upload_path'] = $uploadDir;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = 1024 * 10; // 10 MB

			// Load upload library
			$this->load->library('upload', $config);

			// Perform upload
			if ($this->upload->do_upload('image')) {
				// File uploaded successfully
				$uploadData = $this->upload->data();
				// Adjust imagePath relative to the URL structure
				$imagePath = '../../assets/images/userimage/' . $uploadData['file_name'];
				$this->response(array('imagePath' => $imagePath), REST_Controller::HTTP_OK);
			} else {
				// Error uploading file
				$this->response(array('error' => $this->upload->display_errors()), REST_Controller::HTTP_BAD_REQUEST);
			}
		} else {
			// No file uploaded, return a default image path or an empty response
			$this->response(array('imagePath' => ''), REST_Controller::HTTP_OK);
		}

//		$_POST = json_decode(file_get_contents("php://input"), true);
//
//		$user_id = strip_tags($this->post('user_id'));
//		$userpic = strip_tags($this->post('userimage'));
//
//
//		// Initialize userimage variable
//		$userimage = '';
//
//		if(!empty($_FILES['image']['name'])){
//
//			$uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/TechQ/assets/images/userimage/';
//			$uploadFile = $uploadDir . basename($_FILES['image']['name']);
//
//			if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)){
//				$userimage = $uploadFile;
//			}
//		}
//
//		if(!empty($user_id) && !empty($userimage)){
//			$userData = array(
//				'user_id' => $user_id,
//				'userimage' => $userimage
//			);
//
//			$updateUser = $this->UserModel->updateUserImage($user_id, $userpic);
//			if($updateUser !== false) {
//				// User was updated successfully
//				$this->response(array(
//					'status' => TRUE,
//					'message' => 'User image has been updated successfully.',
//					'data' => $userData) // Return updated user data
//					, REST_Controller::HTTP_OK);
//			} else {
//				// Update was not performed, possibly due to data being already up to date
//				$this->response(array(
//					'status' => FALSE,
//					'message' => 'User image is already up to date.',
//					'data' => null) // Return null data or an appropriate message
//					, REST_Controller::HTTP_OK);
//			}
//		}

	}

	public function upload_image_post()
	{
		$_POST = json_decode(file_get_contents("php://input"), true);

		$user_id = strip_tags($this->post('user_id'));
		$userpic = strip_tags($this->post('userimage'));


		// Initialize userimage variable
		$userimage = '';

		if(!empty($_FILES['image']['name'])){

			$uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/TechQ/assets/images/userimage/';
			$uploadFile = $uploadDir . basename($_FILES['image']['name']);

			if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)){
				$userimage = $uploadFile;
			}
		}

		if(!empty($user_id) && !empty($userpic)){
			$userData = array(
				'user_id' => $user_id,
				'userimage' => $userpic
			);

			$updateUser = $this->UserModel->updateUserImage($user_id, $userData);
			if($updateUser !== false) {
				// User was updated successfully
				$this->response(array(
					'status' => TRUE,
					'message' => 'User image has been updated successfully.',
					'data' => $userData) // Return updated user data
					, REST_Controller::HTTP_OK);
			} else {
				// Update was not performed, possibly due to data being already up to date
				$this->response(array(
					'status' => FALSE,
					'message' => 'User image is already up to date.',
					'data' => null) // Return null data or an appropriate message
					, REST_Controller::HTTP_OK);
			}
		}
	}

	public function change_password_post(){
		$_POST = json_decode(file_get_contents("php://input"), true);

		$user_id = strip_tags($this->post('user_id'));
		$oldpassword = strip_tags($this->post('oldpassword'));
		$newpassword = strip_tags($this->post('newpassword'));

		if(!empty($user_id) && !empty($oldpassword) && !empty($newpassword)){

			$oldpassword = sha1($oldpassword);
			$newpassword = sha1($newpassword);

			$updateUser = $this->UserModel->updatePassword($user_id, $oldpassword, $newpassword);
			if($updateUser !== false) {
				// User was updated successfully
				$this->response(array(
					'status' => TRUE,
					'message' => 'User password has been updated successfully.') // Return updated user data
					, REST_Controller::HTTP_OK);
			} else {
				// Update was not performed, possibly due to data being already up to date
				$this->response(array(
					'status' => FALSE,
					'message' => 'Please check the credentials.',
					'data' => null) // Return null data or an appropriate message
					, REST_Controller::HTTP_OK);
			}
		}
	}

	public function forget_password_post(){
		$_POST = json_decode(file_get_contents("php://input"), true);

		$username = strip_tags($this->post('username'));
		$newpassword = strip_tags($this->post('newpassword'));

		if(!empty($username) && !empty($newpassword)){

			$newpassword = sha1($newpassword);

			$updateUser = $this->UserModel->forgetPassword($username, $newpassword);
			if($updateUser !== false) {
				// User was updated successfully
				$this->response(array(
					'status' => TRUE,
					'message' => 'User password has been updated successfully.') // Return updated user data
					, REST_Controller::HTTP_OK);
			} else {
				// Update was not performed, possibly due to data being already up to date
				$this->response(array(
					'status' => FALSE,
					'message' => 'Please check the credentials.',
					'data' => null) // Return null data or an appropriate message
					, REST_Controller::HTTP_OK);
			}
		}
	}
}
