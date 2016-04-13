<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class service_model extends CI_Model {
	
	function traeSuc($query){
		$data = array(); 
		$q = $this->db->query($query);/*es el query que traigo desde la peticion WS*/
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return array('mensaje' => $data);
		//return $data;
	}
}