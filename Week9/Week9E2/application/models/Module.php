<?php
	class Module extends CI_Model{

		public function __construct(){
			parent::__construct();
			$this->load->database();
		}

		function getModules(){
			$query = $this->db->get("module");
			return $query->result_array();
		}

		public function getStudents(){
			$students = $this->db->get("student");
			if($students->num_rows() > 0){ // Check if there are rows returned
				$students = $students->result_array(); // Fetch results as array
				foreach ($students as &$student) {
					$module_id = $student['module_id'];
					$module_query = $this->db->select('name')
						->from('module')
						->where('id', $module_id)
						->get();
					$modules = $module_query->result_array();
					$student['modules'] = array_column($modules, 'name');
				}
				return $students; // Return array of student data
			} else {
				return array(); // Return empty array if no students found
			}
		}

	}
