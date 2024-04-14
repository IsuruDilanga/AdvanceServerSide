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
