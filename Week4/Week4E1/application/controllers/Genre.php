<?php
	class Genre extends CI_Controller{

		public function __construct(){
			parent::__construct();
			$this->load->model('genre_model');
		}
		public function viewGenre(){
			$data['genre_details'] = $this->genre_model->get_genre();
			$this->load->view('pages/genremovieslist', $data);
		}

		public function viewGenreDetails($genre = NULL){
			$data['genre_view'] = $this->genre_model->get_title_by_genre($genre);
			$data['title'] = $genre;
//			$data['title'] = $data['post']['title'];

			$this->load->view('pages/genreview', $data);

		}
	}
