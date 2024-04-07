<?php
	class ModuleStudent extends CI_Controller{

		public function __construct(){
			parent::__construct();
			$this->load->model("Module");
		}

		public function moduleDetailPage(){
			$this->load->view("modulepage");
		}

		public function getModuleDetails(){
			$modules = $this->Module->getModules();
			echo json_encode($modules);
		}

		public function getStudentDetails(){
			$student = $this->Module->getStudents();
			echo json_encode($student);

//			echo json_encode($student);
		}
	}
