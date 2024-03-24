<?php
	class Films extends CI_Controller{

		public function getAllFilmDetails(){

			$data['films_details'] = $this->films_model->get_film_all_data();
			$data['comedy_films'] = $this->films_model->get_comedy_films();
			$this->load->view('pages/view', $data);
		}

	}