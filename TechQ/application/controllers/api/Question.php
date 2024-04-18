<?php

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';

class Question extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('QuestionModel');
	}

	public function displayAllQuestions_get($question_id = FALSE){
		log_message('debug', 'Question::displayAllQuestions_get() - $question_id: ' . $question_id);

		if ($question_id === FALSE) {
			$questions = $this->QuestionModel->getAllQuestions();
		} else {
			$questions = $this->QuestionModel->getQuestion($question_id);
		}

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

	public function addquestion_post() {
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
		$imageurl = strip_tags($this->post('questionimage'));

		// Initialize questionimage variable
		$questionimage = '';

		// Check if an image file is uploaded
		if (!empty($_FILES['image']['name'])) {
			// Define upload directory and file name
//			$uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/TechQ/assets/images/';
			$uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/TechQ/assets/images/question/';
			$uploadFile = $uploadDir . basename($_FILES['image']['name']);

			// Attempt to move uploaded file to specified directory
			if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
				// File uploaded successfully, update image path
				$questionimage = $uploadFile;
			}
		}

		if (!empty($userid) && !empty($title) && !empty($question) && !empty($expectationQ) && !empty($tags) && !empty($category) && !empty($qaddeddate)) {
			$tagArray = explode(',', $tags);

			// Pass the updated $questionimage variable to the addQuestion function
			$result = $this->QuestionModel->addQuestion($userid, $title, $question, $expectationQ, $category, $qaddeddate, $tagArray, $imageurl);
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


//	public function addquestion_post(){
//		$_POST = json_decode(file_get_contents("php://input"), true);
//
//		$config['upload_path'] = '/Applications/XAMPP/xamppfiles/htdocs/TechQ/assets/images/'; // Specify the upload directory
//		$config['allowed_types'] = 'gif|jpg|jpeg|png'; // Specify allowed file types
//		$config['max_size'] = 10000; // Specify max file size in KBs
//
//		$this->load->library('upload', $config);
//
//		$this->form_validation->set_rules('title', 'checkTitle', 'required');
//		$this->form_validation->set_rules('question', 'checkQuestion', 'required');
//		$this->form_validation->set_rules('expectationQ', 'checkExpectationQ', 'required');
//		$this->form_validation->set_rules('tags', 'checkTags', 'required');
//		$this->form_validation->set_rules('category', 'checkCategory', 'required');
//		$this->form_validation->set_rules('difficulty', 'checkDifficulty', 'required');
//
//
//		if (!$this->upload->do_upload('image')) {
//			$error = array('error' => $this->upload->display_errors());
//			$this->response($error, REST_Controller::HTTP_BAD_REQUEST);
//			return;
//		}
//
//		$data = array('upload_data' => $this->upload->data());
//		$questionimage = '/Applications/XAMPP/xamppfiles/htdocs/TechQ/assets/images/' . $data['upload_data']['file_name']; // Path to be saved in the database
//
//		$userid = strip_tags($this->post('user_id'));
//		$title = strip_tags($this->post('title'));
//		$question = strip_tags($this->post('question'));
//		$expectationQ = strip_tags($this->post('expectationQ'));
//		$tags = strip_tags($this->post('tags'));
//		$category = strip_tags($this->post('category'));
//		$qaddeddate = strip_tags($this->post('qaddeddate'));
//
//		if(!empty($userid) && !empty($title) && !empty($question) && !empty($expectationQ) && !empty($tags) && !empty($category) && !empty($qaddeddate)) {
//			$tagArray = explode(',', $tags);
//
//			$result = $this->QuestionModel->addQuestion($userid, $title, $question, $expectationQ, $questionimage, $category, $qaddeddate, $tagArray);
//			if ($result) {
//				$this->response(array(
//					'status' => TRUE,
//					'message' => 'Question added successfully.'
//				), REST_Controller::HTTP_OK);
//			} else {
//				$this->response("Failed to add question.", REST_Controller::HTTP_BAD_REQUEST);
//			}
//		}
//	}
}
