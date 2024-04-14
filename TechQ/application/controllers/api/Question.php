<?php

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';

class Question extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('QuestionModel');
	}

	public function displayAllQuestions_get(){
		$questions = $this->QuestionModel->getAllQuestions();

		// Check if the user data exists
		if (!empty($questions)) {
			$this->response($questions, REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => FALSE,
				'message' => 'No questions found.'
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}
}
