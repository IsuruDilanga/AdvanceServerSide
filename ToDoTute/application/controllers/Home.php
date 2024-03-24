<?php
	class Home extends CI_Controller{


		public function getlistitem($userid){

			$this->session->set_userdata('priorityOrder', 'ASC');

			$this->retrieveDetails(($this->session->userdata('user')), ($this->session->userdata('priorityOrder')));

		}

		public function changePriority(){

			if(($this->session->userdata('priorityOrder')) == 'ASC'){
				$this->session->set_userdata('priorityOrder', 'DESC');

				$this->retrieveDetails(($this->session->userdata('user')), ($this->session->userdata('priorityOrder')));

			}elseif ($this->session->userdata('priorityOrder') == 'DESC'){
				$this->session->set_userdata('priorityOrder', 'ASC');

				$this->retrieveDetails(($this->session->userdata('user')), ($this->session->userdata('priorityOrder')));

			}
		}

		public function retrieveDetails($user, $priority){
			$data['existing_action'] = $this->todolist_model->getlistitem($user, $priority);

			$this->load->view('templates/header.php');
			$this->load->view('pages/home_page', $data);
			$this->load->view('templates/footer.php');
		}

		public function addToDoItem(){

			// Retrieve action title and date from POST data
			$actionTitle = $this->input->post('action_title', true);
			$date = $this->input->post('date', true);
			$priority = $this->input->post('priority', true);

			// Pass data to the model to add the to-do item
			$this->todolist_model->addToDoList($this->session->userdata('user'), $actionTitle, $date, $priority);

			redirect("home/getlistitem/" . $this->session->userdata('user'));
		}
	}
