<?php

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';

class Answer extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('AnswerModel');
		$this->load->library('Logger');
	}

	/**
	 * This function retrieves all answers for a specific question.
	 *
	 * @author Isuru Dissanayake
	 *
	 * @param int $questionid The ID of the question for which to retrieve answers.
	 *
	 */
	public function getAnswers_get($questionid){

		// Log the start of getAnswers process
		log_message('debug', 'getAnswers() called');

		// Retrieve answers from the AnswerModel
		$answers = $this->AnswerModel->getAnswers($questionid);

		// Check if any answers were found
		if (!empty($answers)) {
			// Log the found answers
			log_message('info', 'Answers found: ' . json_encode($answers));

			// Send a response with the found answers
			$this->response($answers, REST_Controller::HTTP_OK);
		} else {
			// Log that no answers were found
			log_message('error', 'No answers found.');

			// Send a response indicating that no answers were found
			$this->response(array(), REST_Controller::HTTP_OK);
		}
	}


	/**
	 * This function handles the image upload process for an answer.
	 *
	 * @author Isuru Dissanayake
	 *
	 * @param none
	 *
	 */
	public function ans_image_post() {
		// Log the start of image upload process
		log_message('debug', 'ans_image_post() called');

		// Check if file is uploaded and it's not empty
		if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
			// Define upload directory
			$uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/TechQ/assets/images/answer/';

			// Log the upload directory
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
				$imagePath = '../../assets/images/answer/' . $uploadData['file_name'];

				// Log the image path
				log_message('debug', 'answer imagePath: ' . $imagePath);

				// Send a response with the image path
				$this->response(array('imagePath' => $imagePath), REST_Controller::HTTP_OK);
			} else {
				// Log the error message
				log_message('error', 'Error uploading file: ' . $this->upload->display_errors());
				// Error uploading file, send a response with the error message
				$this->response(array('error' => $this->upload->display_errors()), REST_Controller::HTTP_BAD_REQUEST);
			}
		} else {
			// Log that no file was uploaded
			log_message('debug', 'No file uploaded.');
			// No file uploaded, return a default image path or an empty response
			$this->response(array('imagePath' => ''), REST_Controller::HTTP_OK);
		}
	}


	/**
	 * This function handles the add answers for question.
	 *
	 * @author Isuru Dissanayake
	 *
	 * @param none
	 *
	 */
	public function add_answer_post(){
		// Log the start of the add_answer_post function
		log_message('debug', 'add_answer_post() called');

		// Retrieve and sanitize input data from the POST request
		$questionid = strip_tags($this->post('questionid'));
		$userid = strip_tags($this->post('answeraddeduserid'));
		$answer = $this->post('answer');
		$imageurl = strip_tags($this->post('answerimage'));
		$answeraddreddate = strip_tags($this->post('answeraddeddate'));
		$rate = strip_tags($this->post('rate'));

		// Initialize answerimage variable
		$answerimage = '';

		// Log the input data for debugging purposes
		log_message('info', 'questionid: ' . $questionid . ', userid: ' . $userid . ', answer: ' . $answer . ', imageurl: ' . $imageurl . ', answeraddreddate: ' . $answeraddreddate . ', rate: ' . $rate);

		// Check if an image file is uploaded
		if (!empty($_FILES['image']['name'])) {
			// Define upload directory and file name
			$uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/TechQ/assets/images/answer/';
			$uploadFile = $uploadDir . basename($_FILES['image']['name']);

			// Attempt to move uploaded file to specified directory
			if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
				// File uploaded successfully, update image path
				$answerimage = $uploadFile;

				// Log the image path for debugging purposes
				log_message('info', 'answerimage: ' . $answerimage);
			}
		}

		// Check if all necessary data is provided
		if (!empty($questionid) && !empty($userid) && !empty($answer) && !empty($answeraddreddate)) {
			// Call the addAnswer method of the AnswerModel to add the answer to the database
			$result = $this->AnswerModel->addAnswer($questionid, $userid, $answer, $answeraddreddate, $imageurl, $rate);
			if ($result) {
				// Log the successful addition of the answer
				log_message('info', 'Answer added successfully.');
				// Send a response with the status, message and the ID of the added answer
				$this->response(array(
					'status' => TRUE,
					'message' => 'Answer added successfully.',
					'answerid' => $result
				), REST_Controller::HTTP_OK);
			} else {
				// Log the failure of adding the answer
				log_message('error', 'Failed to add answer.');
				// Send a response with an error message
				$this->response("Failed to add answer.", REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}


	/**
	 * This function handles the deletion of an answer.
	 *
	 * @author Isuru Dissanayake
	 *
	 * @param none
	 *
	 */
	public function delete_answer_post(){

		// Log the start of the delete_answer_post function
		log_message('debug', 'delete_answer_post() called');

		// Retrieve the answer ID and image from the POST request
		$answerid = $this->post('answerid');
		$userid = $this->post('userid');
		$answerimage = $this->post('answerimage');

		// Call the deleteAnswer method of the AnswerModel to delete the answer from the database
		$delete = $this->AnswerModel->deleteAnswer($answerid, $userid, $answerimage);
		if($delete) {
			// Log the successful deletion of the answer
			log_message('info', 'Answer deleted successfully.');
			// Send a response with the status and success message
			$this->response(array(
				'status' => TRUE,
				'message' => 'Answer deleted successfully.'
			), REST_Controller::HTTP_OK);
		} else {
			// Log the failure of deleting the answer
			log_message('error', 'Failed to delete answer.');
			// Send a response with an error message
			$this->response("Failed to delete answer.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}


}
