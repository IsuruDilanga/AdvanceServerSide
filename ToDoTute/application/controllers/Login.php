<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	private $userId;
	private $password;
	private $userLogged;

	public function index()
	{

		$this->load->view('login_page');

	}

	public function login_function(){
//		$this->session->userdata('userId');
		log_message('info', "user create the CI_session ");

		$this->userId = $this->input->post('userId', true);
		$this->password = $this->input->post('password', true);

		$this->userLogged = $this->auth_model->authenticate($this->userId, $this->password);

		if($this->userLogged === 'true'){
			$this->session->set_flashdata('success', 'Login successful!');

			$this->session->set_userdata('user', $this->userId);

			redirect("home/getlistitem/" . $this->session->userdata('user'));
//			$this->load->view('templates/header.php');
//			$this->load->view('pages/home_page', $data);
//			$this->load->view('templates/footer.php');
		}else{
			$this->session->set_flashdata('error', 'Invalid username or password.');
			redirect('login/index');
		}

	}

	public function logout(){
		$this->session->unset_userdata('user');
		redirect('login/index');
	}

}
