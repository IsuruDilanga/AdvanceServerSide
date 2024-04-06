<?php
class actor_details_model extends CI_Model{

	public function __construct(){
		$this->load->database();
	}

	public function actorDetails($word){

		$actor_details = $this->db->get_where('actor_details', array('name' => $word))->row_array();
		if($actor_details){
			$actor_id = $actor_details['id'];
			$films_query = $this->db->select('film_name')
				->from('actor_film')
				->where('actorId', $actor_id);
			$films = $films_query->get()->result_array();
			$actor_details['films'] = array_column($films, 'film_name');

			return $actor_details;
		}
		return null;

	}

}
