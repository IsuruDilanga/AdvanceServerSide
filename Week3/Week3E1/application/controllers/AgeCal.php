<?php

	class AgeCal extends CI_Controller {

		public function view(){
			$this->load->view('pages/ageInput.php');
		}

		public function cal(){
			$birthday = $this->input->get('datepicker');
			$age = $this->agediff->get_diff($birthday);
			$this->load->view('pages/currentage',array('age'=>$age));
		}
	}
