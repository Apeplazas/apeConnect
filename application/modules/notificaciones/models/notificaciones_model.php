<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Notificaciones_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	function cargarNotificacionesTodas($usuId){
		$data = array(); 
		$q = $this->db->query("(SELECT 
				mr.mensaje,mr.date,mr.url,
				mur.id,mur.leido,
				('role') as tipo 
				FROM mensajes_roles mr
				LEFT JOIN mensajes_usuarios_roles mur ON mur.mensajerole_id=mr.id
				WHERE mur.usuarioid='$usuId')
			union
				(SELECT 
						mu.mensaje,mu.date,mu.url,mu.id,mu.leido,
						('usuario') as tipo
						FROM mensajes_usuarios mu
						WHERE mu.usuarioid='$usuId')
			ORDER BY date DESC");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function cargaNotificaciones_por_role($usuarioID){
		$data = array(); 
		$q = $this->db->query("SELECT 
			mr.mensaje,mr.date,mr.url,
			mur.id,mur.leido 
			FROM mensajes_roles mr
			LEFT JOIN mensajes_usuarios_roles mur ON mur.mensajerole_id=mr.id
			WHERE mur.usuarioid=$usuarioID
			ORDER BY mr.date DESC");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function cargaNotificacionesBarra($usuarioID){
		$data = array(); 
		$q = $this->db->query("SELECT 
			mr.mensaje,mr.date,mr.url,
			mur.id,mur.leido 
			FROM mensajes_roles mr
			LEFT JOIN mensajes_usuarios_roles mur ON mur.mensajerole_id=mr.id
			WHERE mur.usuarioid=$usuarioID
			AND mur.leido !='1'
			ORDER BY mr.date DESC
			limit 5
			");
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