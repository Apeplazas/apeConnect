<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Renovaciones_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();	
	}
	
	public function obtener_grupo($grupoId){
		
		$data = array(); 
		$q = $this->db->query("SELECT * FROM grupos_locales g 
			WHERE g.Id = '$grupoId'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data = $row;
			}
			$q->free_result();  	
		}
		return $data;
		
	}
		
}