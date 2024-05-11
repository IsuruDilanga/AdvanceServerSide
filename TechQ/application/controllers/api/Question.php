<?php

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';

class Question extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('QuestionModel');
	}

	/**
	 * This function handles the retrieval of all questions or a specific question.
	 *
	 * @author Isuru Dissanayake
	 *
	 * @param mixed $question_id The ID of the question to retrieve. If FALSE, all questions are retrieved.
	 *
	 */
	public function displayAllQuestions_get($question_id = FALSE){

		log_message('debug', 'Question::displayAllQuestions_get() - $question_id: ' . $question_id);

		// Check if a specific question ID is provided
		if ($question_id === FALSE) {

			log_message('debug', 'Question::displayAllQuestions_get() - Getting all questions.');
			// Retrieve all questions from the QuestionModel
			$questions = $this->QuestionModel->getAllQuestions();
		} else {

			log_message('debug', 'Question::displayAllQuestions_get() - Getting question with ID: ' . $question_id);
			// Retrieve the specific question from the QuestionModel
			$questions = $this->QuestionModel->getQuestion($question_id);
		}

		// Check if any questions were found
		if (!empty($questions)) {

			log_message('info', 'Question::displayAllQuestions_get() - Questions found. question_id: ' . $question_id . ' questions: ' . json_encode($questions));
			// Send a response with the question data
			$this->response($questions, REST_Controller::HTTP_OK);
		} else {

			log_message('error', 'Question::displayAllQuestions_get() - No questions found.');
			// Send a response with an error message
			$this->response(array(
				'status' => FALSE,
				'message' => 'No questions found.'
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}


	/**
	 * This function handles the retrieval of bookmarked questions for a specific user.
	 *
	 * @author Isuru Dissanayake
	 *
	 * @param int $userid The ID of the user whose bookmarked questions are to be retrieved.
	 *
	 */
	public function bookmarkQuestions_get($userid){
		log_message('debug', 'Question::bookmarkQuestions_get() - $userid: ' . $userid);

		// Retrieve the bookmarked questions for the user from the QuestionModel
		$questions = $this->QuestionModel->getBookmarkQuestions($userid);

		// Check if any bookmarked questions were found
		if($questions) {
			log_message('info', 'Question::bookmarkQuestions_get() - Bookmark questions found. userid: ' . $userid);

			// Send a response with the bookmarked questions
			$this->response($questions, REST_Controller::HTTP_OK);
		} else {
			log_message('error', 'Question::bookmarkQuestions_get() - No bookmarked questions found.');
			// Send a response with an error message
			$this->response(array(
				'status' => FALSE,
				'message' => 'No bookmarked questions found.'
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}


	/**
	 * This function handles the retrieval of questions based on a search word.
	 *
	 * @author Isuru Dissanayake
	 *
	 * @param mixed $searchWord The word to search for in the questions. If FALSE, all questions are retrieved.
	 *
	 */
	public function displaySearchQuestions_get($searchWord = FALSE){

		log_message('debug', 'Question::displaySearchQuestions_get() - $searchWord: ' . $searchWord);

		// Check if a specific search word is provided
		if ($searchWord === FALSE) {
			log_message('debug', 'Question::displaySearchQuestions_get() - Getting all questions.');

			// Retrieve all questions from the QuestionModel
			$questions = $this->QuestionModel->getAllQuestions();
		} else {
			log_message('debug', 'Question::displaySearchQuestions_get() - Getting questions with search word: ' . $searchWord);

			// Retrieve the questions that match the search word from the QuestionModel
			$questions = $this->QuestionModel->getSearchQuestions($searchWord);
		}

		// Check if any questions were found
		if (!empty($questions)) {
			log_message('info', 'Question::displaySearchQuestions_get() - Questions found. searchWord: ' . $searchWord . ' questions: ' . json_encode($questions));
			// Send a response with the question data
			$this->response($questions, REST_Controller::HTTP_OK);
		} else {
			log_message('error', 'Question::displaySearchQuestions_get() - No questions found.');

			// Send a response with an error message
			$this->response(array(
				'status' => FALSE,
				'message' => 'No questions found.'
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}


	/**
	 * This function handles the upvoting of a question.
	 *
	 * @author Isuru Dissanayake
	 *
	 * @param int $questionid The ID of the question to upvote.
	 *
	 */
	public function upvote_get($questionid){

		log_message('debug', 'Question::upvote_get() - $questionid: ' . $questionid);

		// Call the upvote method of the QuestionModel to upvote the question
		$upvote = $this->QuestionModel->upvote($questionid);

		// Check if the upvote was successful
		if($upvote) {

			log_message('info', 'Question::upvote_get() - Question upvoted successfully.');
			// Send a response with the status and success message
			$this->response(array(
				'status' => TRUE,
				'message' => 'Question upvoted successfully.'
			), REST_Controller::HTTP_OK);
		} else {

			log_message('error', 'Question::upvote_get() - Failed to upvote question.');
			// Send a response with an error message
			$this->response("Failed to upvote question.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}


	/**
	 * This function handles the downvoting of a question.
	 *
	 * @author Isuru Dissanayake
	 *
	 * @param int $questionid The ID of the question to downvote.
	 *
	 */
	public function downvote_get($questionid){

		log_message('debug', 'Question::downvote_get() - $questionid: ' . $questionid);

		// Call the downvote method of the QuestionModel to downvote the question
		$downvote = $this->QuestionModel->downvote($questionid);

		// Check if the downvote was successful
		if($downvote) {

			log_message('info', 'Question::downvote_get() - Question downvoted successfully.');
			// Send a response with the status and success message
			$this->response(array(
				'status' => TRUE,
				'message' => 'Question downvoted successfully.'
			), REST_Controller::HTTP_OK);
		} else {

			log_message('error', 'Question::downvote_get() - Failed to downvote question.');
			// Send a response with an error message
			$this->response("Failed to downvote question.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	/**
	 * This function handles the addition of a new question.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function addquestion_post() {

		log_message('debug', 'Question::addquestion_post()');

		// Decode the JSON input from the POST request
		$_POST = json_decode(file_get_contents("php://input"), true);

		// Set validation rules for the input data
		$this->form_validation->set_rules('title', 'checkTitle', 'required');
		$this->form_validation->set_rules('question', 'checkQuestion', 'required');
		$this->form_validation->set_rules('expectationQ', 'checkExpectationQ', 'required');
		$this->form_validation->set_rules('tags', 'checkTags', 'required');
		$this->form_validation->set_rules('category', 'checkCategory', 'required');
		$this->form_validation->set_rules('difficulty', 'checkDifficulty', 'required');

		// Retrieve and sanitize input data from the POST request
		$userid = strip_tags($this->post('user_id'));
		$title = strip_tags($this->post('title'));
		$question = $this->post('question');
		$expectationQ = $this->post('expectationQ');
		$tags = strip_tags($this->post('tags'));
		$category = strip_tags($this->post('category'));
		$qaddeddate = strip_tags($this->post('qaddeddate'));
		$imageurl = strip_tags($this->post('questionimage'));

		// Initialize questionimage variable
		$questionimage = '';

		// Check if an image file is uploaded
		if (!empty($_FILES['image']['name'])) {

			log_message('debug', 'Question::addquestion_post() - Image file uploaded.');
			// Define upload directory and file name
			$uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/TechQ/assets/images/question/';
			$uploadFile = $uploadDir . basename($_FILES['image']['name']);

			// Attempt to move uploaded file to specified directory
			if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
				// File uploaded successfully, update image path
				$questionimage = $uploadFile;
			}
		}

		// Check if all necessary data is provided
		if (!empty($userid) && !empty($title) && !empty($question) && !empty($expectationQ) && !empty($tags) && !empty($category) && !empty($qaddeddate)) {
			// Convert tags from string to array
			$tagArray = explode(',', $tags);


			log_message('debug', 'Question::addquestion_post() - $userid: ' . $userid);

			// Call the addQuestion method of the QuestionModel to add the question to the database
			$result = $this->QuestionModel->addQuestion($userid, $title, $question, $expectationQ, $category, $qaddeddate, $tagArray, $imageurl);
			if ($result) {
				// Log the successful addition of the question
				log_message('info', 'Question::addquestion_post() - Question added successfully.');
				// Send a response with the status and success message
				$this->response(array(
					'status' => TRUE,
					'message' => 'Question added successfully.'
				), REST_Controller::HTTP_OK);
			} else {

				log_message('error', 'Question::addquestion_post() - Failed to add question.');
				// Send a response with an error message
				$this->response("Failed to add question.", REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}


	/**
	 * This function handles the retrieval of bookmark status for a specific question by a user.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function getBookmark_post(){

		log_message('debug', 'Question::getBookmark_post()');

		// Retrieve the question ID and user ID from the POST request
		$questionid = $this->post('questionid');
		$userid = $this->post('userid');

		// Call the getBookmark method of the QuestionModel to check if the question is bookmarked by the user
		$bookmark = $this->QuestionModel->getBookmark($questionid, $userid);

		// Check if the question is bookmarked by the user
		if($bookmark) {

			log_message('info', 'Question::getBookmark_post() - Question bookmarked successfully.');
			// Send a response with the bookmark status and success message
			$this->response(array(
				'is_bookmark' => TRUE,
				'status' => TRUE,
				'message' => 'Question bookmarked successfully.'
			), REST_Controller::HTTP_OK);
		} else {

			log_message('info', 'Question::getBookmark_post() - Question not bookmarked.');
			// Send a response with the bookmark status and success message
			$this->response(array(
				'is_bookmark' => FALSE,
				'status' => TRUE,
				'message' => 'Question not bookmarked.'
			), REST_Controller::HTTP_OK);
		}
	}
//	public function getBookmark_post(){
//
//		log_message('debug', 'Question::getBookmark_post()');
//
//		$questionid = $this->post('questionid');
//		$userid = $this->post('userid');
//
//		$bookmark = $this->QuestionModel->getBookmark($questionid, $userid);
//		if($bookmark) {
//			$this->response(array(
//				'is_bookmark' => TRUE,
//				'status' => TRUE,
//				'message' => 'Question bookmarked successfully.'
//			), REST_Controller::HTTP_OK);
//		} else {
//			$this->response(array(
//				'is_bookmark' => FALSE,
//				'status' => TRUE,
//				'message' => 'Question bookmarked successfully.'
//			), REST_Controller::HTTP_OK);
//		}
//	}

	/**
	 * This function handles the removal of a bookmark from a specific question by a user.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function remove_bookmark_post(){

		log_message('debug', 'Question::remove_bookmark_post()');

		// Retrieve the question ID and user ID from the POST request
		$questionid = $this->post('questionid');
		$userid = $this->post('userid');

		// Call the removeBookmark method of the QuestionModel to remove the bookmark from the question by the user
		$bookmark = $this->QuestionModel->removeBookmark($questionid, $userid);

		// Check if the bookmark was removed successfully
		if($bookmark) {

			log_message('info', 'Question::remove_bookmark_post() - Question removed from bookmark successfully.');
			// Send a response with the status and success message
			$this->response(array(
				'status' => TRUE,
				'message' => 'Question removed from bookmark successfully.'
			), REST_Controller::HTTP_OK);
		} else {

			log_message('error', 'Question::remove_bookmark_post() - Failed to remove question from bookmark.');
			// Send a response with an error message
			$this->response("Failed to remove question from bookmark.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}


	/**
	 * This function handles the addition of a bookmark to a specific question by a user.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function add_bookmark_post(){
		log_message('debug', 'Question::add_bookmark_post()');

		// Retrieve the question ID and user ID from the POST request
		$questionid = $this->post('questionid');
		$userid = $this->post('userid');

		// Call the addBookmark method of the QuestionModel to add the bookmark to the question by the user
		$bookmark = $this->QuestionModel->addBookmark($questionid, $userid);

		// Check if the bookmark was added successfully
		if($bookmark) {
			log_message('info', 'Question::add_bookmark_post() - Question added to the bookmark successfully.');
			// Send a response with the status and success message
			$this->response(array(
				'status' => TRUE,
				'message' => 'Question added to the bookmark successfully.'
			), REST_Controller::HTTP_OK);
		} else {
			log_message('error', 'Question::add_bookmark_post() - Failed to add question to the bookmark.');
			// Send a response with an error message
			$this->response("Failed to add question to the bookmark.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}


	/**
	 * This function handles the deletion of a specific question by a user.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function delete_question_post(){
		log_message('debug', 'Question::delete_question_post()');

		// Retrieve the question ID and user ID from the POST request
		$questionid = $this->post('questionid');
		$userid = $this->post('userid');

		// Call the deleteQuestion method of the QuestionModel to delete the question
		$delete = $this->QuestionModel->deleteQuestion($userid, $questionid);

		// Check if the question was deleted successfully
		if($delete) {
			log_message('info', 'Question::delete_question_post() - Question deleted successfully.');
			// Send a response with the status and success message
			$this->response(array(
				'status' => TRUE,
				'message' => 'Question deleted successfully.'
			), REST_Controller::HTTP_OK);
		} else {
			log_message('error', 'Question::delete_question_post() - Failed to delete question.');
			// Send a response with an error message
			$this->response("Failed to delete question.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}

}
