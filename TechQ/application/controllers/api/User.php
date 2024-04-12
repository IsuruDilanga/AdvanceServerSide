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

//			$result = $this->UserModel->loginUser($username, sha1($password));
			$result = $this->UserModel->loginUser($username, $password);
//			print_r($result);
			if($result != false){
				$this->response(array(
						'status' => TRUE,
						'message' => 'User has logged in successfully.',
						'data' => true,
						'user_id' => $result['user_id'],
					), REST_Controller::HTTP_OK);
			}else{
				$this->response("Enter valid username and password", REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}
}
