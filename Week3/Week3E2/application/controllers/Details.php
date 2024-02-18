<?php
	class Details extends CI_Controller{

		public function view(){

			$data['dinosaurs_details'] = $this->details_model->get_details();
//			print_r($data);

			$this->load->view('pages/dinosaursDetails.php', $data);
		}

		public function viewDinosaurs($name = NULL){
			$data['dinosaurs_details'] = $this->details_model->get_details($name);

//			$data['title'] = $data['post']['title'];

			$this->load->view('pages/view', $data);

		}

	}
