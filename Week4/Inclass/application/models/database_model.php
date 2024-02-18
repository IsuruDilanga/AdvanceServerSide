<?php
	class database_model EXTENDS CI_Model{
		public function __construct(){
			$this->load->database();
		}

		public function getName(){
			$names = array();
			$result = $this->db->get('people');
			foreach ($result -> result() as $row) {
				$names[] = $row->name;
			}

			return $names;
		}

		// Example Select
		// SELECT * FROM people WHERE gender = ‘male’
		public function useGender(){
			$this -> db->where('gender', 'male');
			$result = $this->db->get('people');

			if($result -> num_rows() == 0){
				return false;
			}

			$names = array();
			foreach ($result -> result() as $row) {
				$names[] = $row->name;
			}

			return $names;
		}

		public function insertData(){
			$data = array('name' => 'Taylor Swift',
			              'imageurl' => 'http://www.pics.com/swift1.jpg',
				          'dateofbirth' => '13-12-1989',
						  'gender' => 'female'
		              );
			$res = $this->db->insert('people', $data);
		}

	}
