<?php

class QuestionModel extends CI_Model{

	public function getAllQuestions(){

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

//		$this->db->select('*');
//		$this->db->from('Questions');
//		$query = $this->db->get();
//
//		return $query->result();


//		$students = $this->db->get("student");
//		if($students->num_rows() > 0){ // Check if there are rows returned
//			$students_array = $students->result(); // Fetch results as object
//			foreach ($students_array as &$student) {
//				$module_id = $student->module_id;
//				$module_query = $this->db->select('name')
//					->from('module')
//					->where('id', $module_id)
//					->get();
//				$modules = $module_query->result();
//				$student->modules = array_column($modules, 'name');
//			}
//			return $students_array; // Return array of student data
//		} else {
//			return new stdClass(); // Return empty object if no students found
//		}

	}

	public function addQuestion($userid, $title, $question, $expectationQ, $category, $qaddeddate, $tagArray){
		$this->db->trans_start(); // Start transaction

		$questionData = array(
			'userid' => $userid,
			'title' => $title,
			'question' => $question,
			'expectationQ' => $expectationQ,
			'category' => $category,
			'qaddeddate' => $qaddeddate
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
