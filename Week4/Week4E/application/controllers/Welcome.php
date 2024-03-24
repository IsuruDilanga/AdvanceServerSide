<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
	public function index()
	{
		$data['films_details'] = $this->films_model->get_film_all_data();
		$data['comedy_films'] = $this->films_model->get_comedy_films();
		$this->load->view('pages/view', $data);
	}
}
