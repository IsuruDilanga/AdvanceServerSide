<?php

class Student extends CI_Controller
{

	public function index(){
		$this->load->view('student_details', array('name' => 'Isuru Dissanayake',
			                                             'course' => 'Software Engineering',
			                                             'picture' => 'https://static.vecteezy.com/system/resources/thumbnails/005/427/608/small/young-indian-student-holding-diary-file-in-hand-free-photo.JPG'));
	}

}
