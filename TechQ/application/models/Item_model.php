<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_model extends CI_Model {

	public function get_items() {
		log_message('debug', 'this is debug log');

		// Fetch items from the database or any other data source
		$users = array(
			array('id' => 1, 'name' => 'John'),
			array('id' => 2, 'name' => 'Jane'),
			array('id' => 3, 'name' => 'Doe')
		);

		return $users;
	}

}
