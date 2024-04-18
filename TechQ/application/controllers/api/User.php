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
						'user_id' => $result->user_id,
						'premium' => $result->premium,
						'occupation' => $result->occupation,
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
			$this->response(array('error' => 'No image file provided'), REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function register_post(){
		$_POST = json_decode(file_get_contents("php://input"), true);
		$this->form_validation->set_rules('username', 'checkUsername', 'required');
		$this->form_validation->set_rules('password', 'checkPassword', 'required');
		$this->form_validation->set_rules('occupation', 'checkOccupation', 'required');
		$this->form_validation->set_rules('premium', 'checkPremium', 'required');

		$username = strip_tags($this->post('username'));
		$password = strip_tags($this->post('password'));
		$occupation = strip_tags($this->post('occupation'));
		$premium = strip_tags($this->post('premium'));

		if(!empty($username) && !empty($password) &&!empty($occupation)){

			$userData = array(
				'username' => $username,
				'password' => sha1($password),
				'occupation' => $occupation,
				'premium' => $premium
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

		}

	}
}
