<?php

	class SearchByWord extends CI_Controller{

		public function __construct(){
			parent::__construct();
			$this->load->model('searchbyword_model');
		}
		public function movieSearchWord(){
			$title = $this->input->get('title', true);
			$data['search_results'] = $this->searchbyword_model->get_movie_by_name($title);
			$this->load->view('pages/searchWord.php', $data);
		}
	}
