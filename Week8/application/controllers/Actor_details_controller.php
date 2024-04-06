<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Actor_details_controller extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('actor_details_model');
	}

	public function viewWord(){
		$this->load->view('actor_details');
	}

	public function getActor(){
		$word = $this->input->post('inputTxt');
		$definition = $this->actor_details_model->actorDetails($word);

		echo json_encode($definition);
	}
}