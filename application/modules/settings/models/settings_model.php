<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Settings_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	function traeplazas(){
		$data = array(); 
		$q = $this->db->query("SELECT z.*,
			e.nombreEstado
			FROM zonas z
			LEFT JOIN zonas_estadosMexico ze ON ze.zonasid=z.idZona
			LEFT JOIN estadosMexico e ON e.claveEstado=ze.claveEstado
			Group by z.idZona");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function traeunidades(){
		$data = array(); 
		$q = $this->db->query("SELECT * FROM unidades");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function traepartidas(){
		
		$data = array(); 
		$q = $this->db->query("SELECT * FROM partidas");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
		
	}
	
}