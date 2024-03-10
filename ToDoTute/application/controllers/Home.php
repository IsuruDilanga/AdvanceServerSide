<?php
	class Home extends CI_Controller{


		public function getlistitem($userid){

			$this->session->set_userdata('priorityOrder', 'ASC');

			$this->retrieveDetails(($this->session->userdata('user')), ($this->session->userdata('priorityOrder')));

//			$data['existing_action'] = $this->todolist_model->getlistitem($this->session->userdata('user'), $this->session->userdata('priorityOrder'));
//
//			$this->load->view('templates/header.php');
//			$this->load->view('pages/home_page', $data);
//			$this->load->view('templates/footer.php');
		}

		public function changePriority(){

			if(($this->session->userdata('priorityOrder')) == 'ASC'){
				$this->session->set_userdata('priorityOrder', 'DESC');

				$this->retrieveDetails(($this->session->userdata('user')), ($this->session->userdata('priorityOrder')));

//				redirect("home/getlistitem/" . $this->session->userdata('user'));

			}elseif ($this->session->userdata('priorityOrder') == 'DESC'){
				$this->session->set_userdata('priorityOrder', 'ASC');

				$this->retrieveDetails(($this->session->userdata('user')), ($this->session->userdata('priorityOrder')));

//				$data['existing_action'] = $this->todolist_model->getlistitem($this->session->userdata('user'), $this->session->userdata('priorityOrder'));
//
//				$this->load->view('templates/header.php');
//				$this->load->view('pages/home_page', $data);
//				$this->load->view('templates/footer.php');
			}
		}

		public function retrieveDetails($user, $priority){
			$data['existing_action'] = $this->todolist_model->getlistitem($user, $priority);

			$this->load->view('templates/header.php');
			$this->load->view('pages/home_page', $data);
			$this->load->view('templates/footer.php');
		}
	}
