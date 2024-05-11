<?php

class QuestionModel extends CI_Model{

	/**
	 * This function retrieves all questions from the database along with their associated tags.
	 *
	 * @return array|stdClass An array of questions if they exist, an empty stdClass otherwise.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function getAllQuestions(){
		log_message('debug', 'getAllQuestions() called');

		// Retrieve all questions from the database
		$question = $this->db->get("Questions");

		// Check if there are any questions
		if($question->num_rows() > 0){
			log_message('debug', 'Questions found');

			// If there are questions, retrieve them as an array
			$question_array = $question->result();

			// For each question, retrieve its associated tags
			foreach ($question_array as $question) {
				// Retrieve the ID of the question
				$question_id = $question->questionid;

				// Retrieve the tags associated with the question from the database
				$tag_query = $this->db->select('tags')
					->from('Tags')
					->where('questionid', $question_id)
					->get();

				// Retrieve the tags as an array
				$tags = $tag_query->result();

				// Add the tags to the question
				$question->tags = array_column($tags, 'tags');
				log_message('debug', 'Tags retrieved for question ' . $question_id);
			}

			log_message('debug', 'Questions retrieved');

			// Return the array of questions
			return $question_array;
		} else {
			log_message('debug', 'No questions found');
			// If there are no questions, return an empty stdClass
			return new stdClass();
		}
	}


	/**
	 * This function retrieves a specific question from the database along with its associated tags.
	 *
	 * @param int $question_id The ID of the question to be retrieved.
	 * @return object|null The question if it exists, null otherwise.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function getQuestion($question_id)
	{

		log_message('debug', 'QuestionModel::getQuestion()');

		// Retrieve the question from the database
		$question = $this->db->get_where("Questions", array('questionid' => $question_id))->row();

		// Check if the question exists
		if ($question) {

			log_message('info', 'QuestionModel::getQuestion() - Question retrieved successfully.');

			// Retrieve the tags associated with the question from the database
			$tag_query = $this->db->select('tags')
				->from('Tags')
				->where('questionid', $question->questionid)
				->get();

			// Retrieve the tags as an array
			$tags = $tag_query->result();

			// Add the tags to the question
			$question->tags = array_column($tags, 'tags');

			log_message('debug', 'Tags retrieved for question ' . $question_id);

			// Return the question
			return $question;
		} else {

			log_message('error', 'QuestionModel::getQuestion() - Failed to retrieve question.');

			// Return null if no question found
			return null;
		}
	}

	/**
	 * This function retrieves questions from the database that match a search word in their title, content, or associated tags.
	 *
	 * @param string $searchWord The word to search for in the questions' title, content, and associated tags.
	 * @return array|stdClass An array of matching questions if they exist, an empty stdClass otherwise.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function getSearchQuestions($searchWord){
		log_message('debug', 'QuestionModel::getSearchQuestions()');

		// Search for the word in the questions' title and content
		$this->db->like('title', $searchWord);
		$this->db->or_like('question', $searchWord);

		// Join the Questions and Tags tables on the questionid field
		$this->db->join('Tags', 'Questions.questionid = Tags.questionid', 'left');

		// Search for the word in the questions' associated tags
		$this->db->or_like('tags', $searchWord);

		// Retrieve the matching questions from the database
		$question = $this->db->get("Questions");

		log_message('debug', 'Questions retrieved for search word: ' . $searchWord);

		// Check if there are any matching questions
		if ($question->num_rows() > 0) {
			log_message('debug', 'Matching questions found');
			// If there are matching questions, retrieve them as an array
			$question_array = $question->result();

			// For each question, retrieve its associated tags
			foreach ($question_array as $question) {
				// Retrieve the ID of the question
				$question_id = $question->questionid;

				// Retrieve the tags associated with the question from the database
				$tag_query = $this->db->select('tags')
					->from('Tags')
					->where('questionid', $question_id)
					->get();

				// Retrieve the tags as an array
				$tags = $tag_query->result();

				// Add the tags to the question
				$question->tags = array_column($tags, 'tags');
			}

			log_message('debug', 'Tags retrieved for matching questions');
			// Return the array of matching questions
			return $question_array;
		} else {
			log_message('debug', 'No matching questions found');
			// If there are no matching questions, return an empty stdClass
			return new stdClass();
		}
	}


	/**
	 * This function adds a question to the database, updates the count of asked questions by the user, and adds associated tags.
	 *
	 * @param int $userid The ID of the user who asks the question.
	 * @param string $title The title of the question.
	 * @param string $question The content of the question.
	 * @param string $expectationQ The expectation of the question.
	 * @param string $category The category of the question.
	 * @param string $qaddeddate The date when the question is added.
	 * @param array $tagArray An array of tags associated with the question.
	 * @param string $imageurl The URL of the image associated with the question.
	 * @return bool The result of the transaction.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function addQuestion($userid, $title, $question, $expectationQ, $category, $qaddeddate, $tagArray, $imageurl) {
		log_message('debug', 'QuestionModel::addQuestion()');

		// Start transaction
		$this->db->trans_start();
		log_message('debug', 'Transaction started');

		// Prepare the data of the question
		$questionData = array(
			'userid' => $userid,
			'title' => $title,
			'question' => $question,
			'expectationQ' => $expectationQ,
			'questionimage' => $imageurl,
			'category' => $category,
			'qaddeddate' => $qaddeddate,
		);

		log_message('debug', 'Question data prepared');
		// Insert the question into the 'Questions' table
		$insertDetails = $this->db->insert('Questions', $questionData);

		// If the insertion was successful
		if ($insertDetails) {
			log_message('debug', 'Question inserted successfully');

			// Retrieve the ID of the inserted question
			$questionId = $this->db->insert_id();

			// For each tag in the tag array
			foreach ($tagArray as $tag) {
				// Prepare the data of the tag
				$tagData = array(
					'questionid' => $questionId,
					'tags' => trim($tag)
				);

				// Insert the tag into the 'Tags' table
				$this->db->insert('Tags', $tagData);
			}
		}

		// If the insertion was successful
		if ($insertDetails){
			log_message('debug', 'Tags inserted successfully');
			// Retrieve the past count of asked questions by the user from the database
			$pastaskquestioncnt = $this->db->select('askquestioncnt')
				->from('Users')
				->where('user_id', $userid)
				->get()
				->row();

			// Increment the count of asked questions by the user
			$askquestioncnt = $pastaskquestioncnt->askquestioncnt + 1;

			// Update the count of asked questions by the user in the database
			$this->db->where('user_id', $userid)
				->update('Users', array('askquestioncnt' => $askquestioncnt));
		}

		// Complete transaction
		$this->db->trans_complete();
		log_message('debug', 'Transaction completed');
		// Return the result of the transaction
		return $insertDetails && $this->db->trans_status();
	}


	/**
	 * This function increments the view status of a specific question in the database.
	 *
	 * @param int $questionid The ID of the question to be upvoted.
	 * @return bool The result of the update operation.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function upvote($questionid){

		log_message('debug', 'QuestionModel::upvote()');

		// Retrieve the current view status of the question from the database
		$currentViewStatus = $this->db->select('viewstatus')
			->from('Questions')
			->where('questionid', $questionid)
			->get()
			->row()
			->viewstatus;

		// Increment the view status
		$newViewStatus = $currentViewStatus + 1;

		// Update the view status of the question in the database
		$updateViewStatus = $this->db->where('questionid', $questionid)
			->update('Questions', array('viewstatus' => $newViewStatus));

		// Log the result of the update operation
		if($updateViewStatus){
			log_message('info', 'QuestionModel::upvote() - View status updated successfully.');
		} else {
			log_message('error', 'QuestionModel::upvote() - Failed to update view status.');
		}

		// Return the result of the update operation
		return $updateViewStatus;
	}


	/**
	 * This function decrements the view status of a specific question in the database.
	 *
	 * @param int $questionid The ID of the question to be downvoted.
	 * @return bool The result of the update operation.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function downvote($questionid){

		log_message('debug', 'QuestionModel::downvote()');

		// Retrieve the current view status of the question from the database
		$currentViewStatus = $this->db->select('viewstatus')
			->from('Questions')
			->where('questionid', $questionid)
			->get()
			->row()
			->viewstatus;

		// Decrement the view status
		$newViewStatus = $currentViewStatus - 1;

		// Update the view status of the question in the database
		$updateViewStatus = $this->db->where('questionid', $questionid)
			->update('Questions', array('viewstatus' => $newViewStatus));

		// Log the result of the update operation
		if($updateViewStatus){
			log_message('info', 'QuestionModel::downvote() - View status updated successfully.');
		} else {
			log_message('error', 'QuestionModel::downvote() - Failed to update view status.');
		}

		// Return the result of the update operation
		return $updateViewStatus;
	}


	/**
	 * This function checks if a specific question is bookmarked by a specific user in the database.
	 *
	 * @param int $questionid The ID of the question to be checked.
	 * @param int $userid The ID of the user to be checked.
	 * @return bool TRUE if the question is bookmarked by the user, FALSE otherwise.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function getBookmark($questionid, $userid){

		log_message('debug', 'QuestionModel::getBookmark()');

		// Check if the question is bookmarked by the user in the database
		$bookmark = $this->db->get_where("BookmarkQue", array('questionid' => $questionid, 'userid' => $userid));

		// If the question is bookmarked by the user
		if($bookmark->num_rows() > 0){

			log_message('info', 'QuestionModel::getBookmark() - Bookmark retrieved successfully.');

			// Return TRUE
			return TRUE;
		}else{

			log_message('error', 'QuestionModel::getBookmark() - Failed to retrieve bookmark.');

			// Return FALSE
			return FALSE;
		}
	}


	/**
	 * This function deletes a specific question from the database, removes its associated answers, bookmarks, and tags, and updates the count of asked questions by the user.
	 *
	 * @param int $userid The ID of the user who asked the question.
	 * @param int $questionid The ID of the question to be deleted.
	 * @return bool The result of the deletion operation.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function deleteQuestion($userid, $questionid){
		log_message('debug', 'QuestionModel::deleteQuestion()');

		// Delete related rows from the Answers table
		$this->db->where('questionid', $questionid);
		$this->db->delete('Answers');
		log_message('debug', 'Related answers deleted');

		// Delete related rows from the bookmarkque table
		$this->db->where('questionid', $questionid);
		$this->db->delete('bookmarkque');
		log_message('debug', 'Related bookmarks deleted');

		// Delete related rows from the tags table
		$this->db->where('questionid', $questionid);
		$this->db->delete('tags');
		log_message('debug', 'Related tags deleted');

		// Delete the question from the Questions table
		$this->db->where(array('questionid' => $questionid));
		$questiondlt = $this->db->delete('Questions');

		// If the deletion was successful
		if($questiondlt){
			log_message('info', 'QuestionModel::deleteQuestion() - Question deleted successfully.');

			// Retrieve the past count of asked questions by the user from the database
			$pastaskquestioncnt = $this->db->select('askquestioncnt')
				->from('Users')
				->where('user_id', $userid)
				->get()
				->row();

			// Decrement the count of asked questions by the user
			$askquestioncnt = $pastaskquestioncnt->askquestioncnt - 1;

			// Update the count of asked questions by the user in the database
			$this->db->where('user_id', $userid)
				->update('Users', array('askquestioncnt' => $askquestioncnt));
		} else {
			log_message('error', 'QuestionModel::deleteQuestion() - Failed to delete question.');
		}

		// Return the result of the deletion operation
		return $questiondlt;
	}


	/**
	 * This function removes a bookmark from a specific question for a specific user in the database.
	 *
	 * @param int $questionid The ID of the question from which the bookmark is to be removed.
	 * @param int $userid The ID of the user for whom the bookmark is to be removed.
	 * @return bool The result of the deletion operation.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function removeBookmark($questionid, $userid){

		log_message('debug', 'QuestionModel::removeBookmark()');

		// Remove the bookmark from the database
		$bookmark = $this->db->delete("BookmarkQue", array('questionid' => $questionid, 'userid' => $userid));

		// Log the result of the deletion operation
		if($bookmark){
			log_message('info', 'QuestionModel::removeBookmark() - Bookmark removed successfully.');
		} else {
			log_message('error', 'QuestionModel::removeBookmark() - Failed to remove bookmark.');
		}

		// Return the result of the deletion operation
		return $bookmark;
	}


	/**
	 * This function adds a bookmark for a specific question for a specific user in the database.
	 *
	 * @param int $questionid The ID of the question to be bookmarked.
	 * @param int $userid The ID of the user who bookmarks the question.
	 * @return bool FALSE if the bookmark already exists, TRUE if the bookmark was successfully added.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function addBookmark($questionid, $userid){
		log_message('debug', 'QuestionModel::addBookmark()');

		// Check if the combination of questionid and userid already exists in the database
		$this->db->where('questionid', $questionid);
		$this->db->where('userid', $userid);
		$existingBookmark = $this->db->get('BookmarkQue')->row();

		// If the combination already exists
		if($existingBookmark) {
			log_message('info', 'QuestionModel::addBookmark() - Bookmark already exists.');

			// Return false to indicate that the bookmark was not added
			return false;
		}

		// If the combination does not exist, prepare the data of the new bookmark
		$bookmarkData = array(
			'questionid' => $questionid,
			'userid' => $userid
		);

		// Add the new bookmark to the database
		$bookmark = $this->db->insert('BookmarkQue', $bookmarkData);

		// Log the result of the insertion operation
		if($bookmark){
			log_message('info', 'QuestionModel::addBookmark() - Bookmark added successfully.');
		} else {
			log_message('error', 'QuestionModel::addBookmark() - Failed to add bookmark.');
		}

		// Return true to indicate that the bookmark was successfully added
		return $bookmark;
	}


	/**
	 * This function retrieves all questions bookmarked by a specific user from the database along with their associated tags.
	 *
	 * @param int $userid The ID of the user whose bookmarked questions are to be retrieved.
	 * @return array|stdClass An array of bookmarked questions if they exist, an empty stdClass otherwise.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function getBookmarkQuestions($userid){
		log_message('debug', 'QuestionModel::getBookmarkQuestions()');

		// Select all fields from the Questions table
		$this->db->select('Questions.*');

		// From the Questions table
		$this->db->from('Questions');

		// Join the BookmarkQue table on the questionid field
		$this->db->join('BookmarkQue', 'Questions.questionid = BookmarkQue.questionid');

		// Where the userid field in the BookmarkQue table matches the provided userid
		$this->db->where('BookmarkQue.userid', $userid);

		// Retrieve the bookmarked questions from the database
		$question = $this->db->get();

		// If there are any bookmarked questions
		if($question->num_rows() > 0){
			log_message('info', 'QuestionModel::getBookmarkQuestions() - Bookmarked questions retrieved successfully.');

			// Convert the result to an array
			$question_array = $question->result();

			// For each bookmarked question
			foreach ($question_array as $question) {
				// Retrieve the questionid
				$question_id = $question->questionid;

				// Select the tags field from the Tags table where the questionid field matches the retrieved questionid
				$tag_query = $this->db->select('tags')
					->from('Tags')
					->where('questionid', $question_id)
					->get();

				// Convert the result to an array
				$tags = $tag_query->result();

				log_message('debug', 'Tags retrieved for question ' . $question_id);

				// Add the tags to the question
				$question->tags = array_column($tags, 'tags');
			}

			// Return the array of bookmarked questions
			return $question_array;
		}else{
			log_message('info', 'QuestionModel::getBookmarkQuestions() - No bookmarked questions found.');

			// If there are no bookmarked questions, return an empty stdClass
			return new stdClass();
		}
	}

}
