<?php


class AnswerModel extends CI_Model{

	/**
	 * This function retrieves the answers for a specific question.
	 *
	 * @param int $questionid The ID of the question for which to retrieve the answers.
	 * @return array|null The answers for the question if they exist, null otherwise.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function getAnswers($questionid){

		log_message('debug', 'AnswerModel::getAnswers()');

		// Retrieve the answers for the question from the database
		$answer = $this->db->get_where("Answers", array('questionid' => $questionid));

		// Check if there are any answers for the question
		if($answer->num_rows() > 0) {
			log_message('debug', 'AnswerModel::getAnswers() - Answers found');
			// If there are answers, return them
			return $answer->result();
		} else {
			log_message('debug', 'AnswerModel::getAnswers() - No answers found');
			// If there are no answers, return null
			return null;
		}
	}

	/**
	 * This function adds an answer to a specific question by a user and updates the rate of the question.
	 *
	 * @param int $questionid The ID of the question to which the answer is added.
	 * @param int $userid The ID of the user who adds the answer.
	 * @param string $answer The content of the answer.
	 * @param string $answeraddreddate The date when the answer is added.
	 * @param string $imageurl The URL of the image associated with the answer.
	 * @param float $rate The rate of the answer.
	 * @return int The ID of the added answer.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function addAnswer($questionid, $userid, $answer, $answeraddreddate, $imageurl, $rate){

		log_message('debug', 'AnswerModel::addAnswer()');

		// Convert the rate to a float
		$rate = floatval($rate);

		// Retrieve the past rate of the question from the database
		$pastRateResult = $this->db->select('rate')
			->from('Questions')
			->where('questionid', $questionid)
			->get();

		// Check if the past rate exists and the new rate is greater than 0
		if ($pastRateResult->num_rows() > 0 && $rate > 0) {
			log_message('debug', 'AnswerModel::addAnswer() - Past rate found');

			// Extract the past rate from the result and convert it to a float
			$pastRate = floatval($pastRateResult->row()->rate);

			// If the past rate is 0, set it to the new rate
			if ($pastRate == 0) {
				$pastRate = $rate;
			}

			// Calculate the new rate as the average of the past rate and the new rate
			$rate = ($rate + $pastRate) / 2;
			log_message('debug', 'AnswerModel::addAnswer() - New rate calculated');
		}

		// Update the rate of the question in the database
		$this->db->where('questionid', $questionid)
			->update('Questions', array('rate' => $rate));

		// Prepare the data of the answer
		$answerData = array(
			'questionid' => $questionid,
			'userid' => $userid,
			'answer' => $answer,
			'answerimage' => $imageurl,
			'answeraddeddate' => $answeraddreddate
		);

		// Insert the answer into the database
		$insertAns = $this->db->insert('Answers', $answerData);

		// Retrieve the ID of the inserted answer
		$answerid = $this->db->insert_id();

		// If the answer is inserted successfully
		if($insertAns){
			log_message('debug', 'AnswerModel::addAnswer() - Answer inserted');
			// Retrieve the past count of answered questions by the user from the database
			$pastanswerquestioncnt = $this->db->select('answerquestioncnt')
				->from('Users')
				->where('user_id', $userid)
				->get()
				->row();

			// Increment the count of answered questions by the user
			$answerquestioncnt = $pastanswerquestioncnt->answerquestioncnt + 1;

			// Update the count of answered questions by the user in the database
			$this->db->where('user_id', $userid)
				->update('Users', array('answerquestioncnt' => $answerquestioncnt));
		}

		log_message('debug', 'AnswerModel::addAnswer() - Answer ID: ' . $answerid);
		// Return the ID of the inserted answer
		return $answerid;
	}

	/**
	 * This function deletes an answer from the database, updates the count of answered questions by the user, and removes the associated image file.
	 *
	 * @param int $answerid The ID of the answer to be deleted.
	 * @param int $userid The ID of the user who posted the answer.
	 * @param string $answerimage The relative path of the image associated with the answer.
	 * @return bool The result of the deletion operation.
	 *
	 * @author Isuru Dissanayake
	 *
	 */
	public function deleteAnswer($answerid, $userid, $answerimage){
		log_message('debug', 'AnswerModel::deleteAnswer()');

		// Define the default path where the images are stored
		$default_path = '/Applications/XAMPP/xamppfiles/htdocs/TechQ/assets/';

		// Remove '../../assets/' from the image path to get the relative path
		$cleanedImagePath = str_replace('../../assets/', '', $answerimage);

		// Concatenate the cleaned image path with the default path to get the absolute path of the image
		$finalImagePath = $default_path . $cleanedImagePath;

		// Delete the answer from the database
		$answer = $this->db->delete("Answers", array('answerid' => $answerid));
		log_message('debug', 'AnswerModel::deleteAnswer() - Answer deleted');
		// If the answer is deleted successfully
		if($answer){
			// Retrieve the past count of answered questions by the user from the database
			$pastanswerquestioncnt = $this->db->select('answerquestioncnt')
				->from('Users')
				->where('user_id', $userid)
				->get()
				->row();

			// Decrement the count of answered questions by the user
			$answerquestioncnt = $pastanswerquestioncnt->answerquestioncnt - 1;

			// Update the count of answered questions by the user in the database
			$this->db->where('user_id', $userid)
				->update('Users', array('answerquestioncnt' => $answerquestioncnt));
			log_message('debug', 'AnswerModel::deleteAnswer() - Answer count updated');
		}

		// Delete the image file associated with the answer
		unlink($finalImagePath);
		log_message('debug', 'AnswerModel::deleteAnswer() - Image deleted');

		// Return the result of the deletion operation
		return $answer;
	}


}
