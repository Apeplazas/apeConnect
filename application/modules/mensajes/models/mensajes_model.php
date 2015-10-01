<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Mensajes_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	function traeconversaciones($usuarioID){
		$data = array(); 
		$q = $this->db->query("SELECT 
			c.*
			FROM conversaciones c
			WHERE (c.idUsuarioUno = '$usuarioID' or c.idUsuarioDos = '$usuarioID')");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function cargaNotificaciones_por_usuario($usuarioID){
		$data = array(); 
		$q = $this->db->query("SELECT 
			mu.id,mu.mensaje,mu.date,mu.url,mu.leido
			FROM mensajes_usuarios mu
			WHERE mu.usuarioid=$usuarioID
			ORDER BY mu.date DESC");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
}