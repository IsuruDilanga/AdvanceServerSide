<?php

class QuestionModel extends CI_Model{

	public function getAllQuestions(){
		log_message('debug', 'getAllQuestions() called');
//		$this->logger->debug('getAllQuestions() called');

		$question = $this->db->get("Questions");
		if($question->num_rows() > 0){
			$question_array = $question->result();
			foreach ($question_array as $question) {
				$question_id = $question->questionid;
				$tag_query = $this->db->select('tags')
					->from('Tags')
					->where('questionid', $question_id)
					->get();
				$tags = $tag_query->result();
				$question->tags = array_column($tags, 'tags');
			}
			return $question_array;
		}else{
			return new stdClass();
		}

	}

	public function getQuestion($question_id)
	{
		{
			$question = $this->db->get_where("Questions", array('questionid' => $question_id))->row();

			if ($question) {
				$tag_query = $this->db->select('tags')
					->from('Tags')
					->where('questionid', $question->questionid)
					->get();
				$tags = $tag_query->result();
				$question->tags = array_column($tags, 'tags');

				return $question;
			} else {
				return null; // Return null if no question found
			}
		}
//		$question = $this->db->get_where("Questions", array('questionid' => $question_id));
//		if ($question->num_rows() > 0) {
//			$question_array = $question->result();
//			foreach ($question_array as $question) {
//				$question_id = $question->questionid;
//				$tag_query = $this->db->select('tags')
//					->from('Tags')
//					->where('questionid', $question_id)
//					->get();
//				$tags = $tag_query->result();
//				$question->tags = array_column($tags, 'tags');
//			}
//			return $question_array;
//		} else {
//			return new stdClass();
//		}
	}

	public function addQuestion($userid, $title, $question, $expectationQ, $category, $qaddeddate, $tagArray, $imageurl) {
		$this->db->trans_start(); // Start transaction

		$questionData = array(
			'userid' => $userid,
			'title' => $title,
			'question' => $question,
			'expectationQ' => $expectationQ,
			'questionimage' => $imageurl, // Ensure that the questionimage field is correctly set here
			'category' => $category,
			'qaddeddate' => $qaddeddate,
		);

		// Insert into 'Questions' table
		$insertDetails = $this->db->insert('Questions', $questionData);

		// Check if the insertion was successful
		if ($insertDetails) {
			// Get the last inserted question ID
			$questionId = $this->db->insert_id();

			// Insert into 'Tags' table
			foreach ($tagArray as $tag) {
				$tagData = array(
					'questionid' => $questionId, // Use the retrieved question ID
					'tags' => trim($tag)
				);
				$this->db->insert('Tags', $tagData);
			}
		}

		$this->db->trans_complete(); // Complete transaction

		return $insertDetails && $this->db->trans_status(); // Return transaction status
	}



}
