<?php


class AnswerModel extends CI_Model{

	public function getAnswers($questionid){

		$answer = $this->db->get_where("Answers", array('questionid' => $questionid));

		if($answer->num_rows() > 0) {
			return $answer->result();
		}else{
			return null;
		}
	}

	public function addAnswer($questionid, $userid, $answer, $answeraddreddate, $imageurl){

		$answerData = array(
			'questionid' => $questionid,
			'userid' => $userid,
			'answer' => $answer,
			'answerimage' => $imageurl,
			'answeraddeddate' => $answeraddreddate
		);

		$insertAns = $this->db->insert('Answers', $answerData);
		return $insertAns;
	}


}
