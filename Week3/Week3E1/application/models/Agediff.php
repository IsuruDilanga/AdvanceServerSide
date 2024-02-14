<?php
	class Agediff extends CI_Model{

		public function get_diff($dob){
			$today = date("y-m-d");
			$diff = date_diff(date_create($dob), date_create($today));
			return 'Age is '.$diff->format('%y');
		}
	}
