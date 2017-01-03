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
			WHERE u.idrole = 9 OR u.idrole = 5 OR u.idrole = 8 ORDER BY u.idrole");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function encargadoPlaza($var){
		$data = array(); 
		$q = $this->db->query("SELECT Nombre FROM borrar_vic_inmueble
			WHERE usuario_id = $var");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function supervisores($var){
		$data = array(); 
		$q = $this->db->query("SELECT nombreCompleto FROM usuarios
			WHERE numeroEmpleado = $var");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function encargado($var){
		$data = array(); 
		$q = $this->db->query("SELECT nombreCompleto, jefeDirectoID FROM usuarios
			WHERE idrole = 8 OR usuarioID=$var");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
		
}