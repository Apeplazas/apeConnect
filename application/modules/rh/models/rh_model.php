<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class rh_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	function traerEmpleados(){
		$data = array(); 
		$q = $this->db->query("SELECT u.*,r.nombre FROM usuarios u
			LEFT JOIN roles r ON r.id = u.idrole
			WHERE u.idrole = 4 OR u.idrole = 5");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
		
}