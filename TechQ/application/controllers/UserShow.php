<?php

class UserShow extends CI_Controller {


	public function index()
	{
		log_message('debug', 'index() called');
		$this->load->view('index');
	}
}
