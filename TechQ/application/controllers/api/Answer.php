<?php

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';

class Answer extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('AnswerModel');
	}

	public function getAnswers_get($questionid){
		$answers = $this->AnswerModel->getAnswers($questionid);

		if (!empty($answers)) {
			$this->response($answers, REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => FALSE,
				'message' => 'No questions found.'
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function ans_image_post() {
		// Check if file is uploaded
		if (!empty($_FILES['image']['name'])) {
			// Define upload directory
			$uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/TechQ/assets/images/answer/';

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
				$imagePath = '../../assets/images/answer/' . $uploadData['file_name'];
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

	public function add_answer_post(){
		$_POST = json_decode(file_get_contents("php://input"), true);

		$questionid = strip_tags($this->post('questionid'));
		$userid = strip_tags($this->post('userid'));
		$answer = strip_tags($this->post('answer'));
		$imageurl = strip_tags($this->post('answerimage'));
		$answeraddreddate = strip_tags($this->post('aaddeddate'));

		// Initialize answerimage variable
		$answerimage = '';

		// Check if an image file is uploaded
		if (!empty($_FILES['image']['name'])) {
			// Define upload directory and file name
			$uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/TechQ/assets/images/answer/';
			$uploadFile = $uploadDir . basename($_FILES['image']['name']);

			// Attempt to move uploaded file to specified directory
			if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
				// File uploaded successfully, update image path
				$answerimage = $uploadFile;
			}
		}

		if (!empty($questionid) && !empty($userid) && !empty($answer) && !empty($answeraddreddate)) {
			$result = $this->AnswerModel->addAnswer($questionid, $userid, $answer, $answeraddreddate, $imageurl);
			if ($result) {
				$this->response(array(
					'status' => TRUE,
					'message' => 'Answer added successfully.'
				), REST_Controller::HTTP_OK);
			} else {
				$this->response("Failed to add answer.", REST_Controller::HTTP_BAD_REQUEST);
			}
		}



	}


}
