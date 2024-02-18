<?php
	class Movies extends CI_Controller{

		public function __construct(){
			parent::__construct();
			$this->load->model('movies_model');
		}

		public function index(){
			$this->load->view('pages/search');
		}

		public function search(){
			$genre = $this->input->get('genre', true);
			$IMDB_rating = $this->input->get('imdb_rating', true);
			$data['search_results'] = $this->movies_model->get_search_results($genre, $IMDB_rating);
			$this->load->view('pages/search', $data);
		}

		public function allmovies(){
			$data['all_movies'] = $this->movies_model->get_all_movies();
			$this->load->view('pages/allmovies', $data);
		}

	}
