<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo extends CI_Controller {

	private $actionTitle;
	private $date;
	private $user_id;

	public function index()
	{
		$data['todo_list'] = $this->todo_model->getToDoList();
		$this->load->view('templates/header');
		$this->load->view('pages/todo_page',$data);
		$this->load->view('templates/footer');
	}

	public function addToDoItem(){

		$this->user_id = $this->session->userdata('user_id');
		if(!$this->user_id){
			$this->user_id = uniqid();
			$this->session->set_userdata('user_id', $this->user_id);
			log_message('info', 'New user ID generated and stored in session ' . print_r($this->user_id, True));
		}else{
			log_message('debug', 'Existing user ID found in session: ' . print_r($this->user_id, True));
//			$this->logger->debug("Existing user ID found in session: $this->user_id");
		}

		// Generate a new unique user ID and set it in the session
//		$this->user_id = uniqid();
//		$this->session->set_userdata('user_id', $this->user_id);

		// Retrieve action title and date from POST data
		$actionTitle = $this->input->post('action_title', true);
		$date = $this->input->post('date', true);

		// Pass data to the model to add the to-do item
		$this->todo_model->addToDoList($actionTitle, $date, $this->user_id);

		$existing_action = $this->todo_model->getToDoList($this->user_id);
		$data['existing_action'] = $existing_action;
		$this->load->view('pages/todo_view.php', $data);

		// Redirect to the index function to refresh the page
		redirect('todo/index');

	}
}
