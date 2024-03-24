<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class Word_Definition extends CI_Controller{

		public function __construct(){
			parent::__construct();
			$this->load->model('word_definition_model');
		}

		public function viewWord(){
			$this->load->view('word_definition');
		}

		public function get_definition(){
			$word = $this->input->post('inputTxt');
			$definition = $this->word_definition_model->wordDefinition($word);
//			print_r($definition);
			echo json_encode($definition);
		}
	}
