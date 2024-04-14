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

	public function addquestion_post(){
		$_POST = json_decode(file_get_contents("php://input"), true);
		$this->form_validation->set_rules('title', 'checkTitle', 'required');
		$this->form_validation->set_rules('question', 'checkQuestion', 'required');
		$this->form_validation->set_rules('expectationQ', 'checkExpectationQ', 'required');
		$this->form_validation->set_rules('tags', 'checkTags', 'required');
		$this->form_validation->set_rules('category', 'checkCategory', 'required');
		$this->form_validation->set_rules('difficulty', 'checkDifficulty', 'required');

		$userid = strip_tags($this->post('user_id'));
		$title = strip_tags($this->post('title'));
		$question = strip_tags($this->post('question'));
		$expectationQ = strip_tags($this->post('expectationQ'));
		$tags = strip_tags($this->post('tags'));
		$category = strip_tags($this->post('category'));
		$qaddeddate = strip_tags($this->post('qaddeddate'));

		if(!empty($userid) && !empty($title) && !empty($question) && !empty($expectationQ) && !empty($tags) && !empty($category) && !empty($qaddeddate)) {
			$tagArray = explode(',', $tags);

			$result = $this->QuestionModel->addQuestion($userid, $title, $question, $expectationQ, $category, $qaddeddate, $tagArray);
			if ($result) {
				$this->response(array(
					'status' => TRUE,
					'message' => 'Question added successfully.'
				), REST_Controller::HTTP_OK);
			} else {
				$this->response("Failed to add question.", REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}
}
