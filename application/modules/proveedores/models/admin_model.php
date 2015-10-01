<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Admin_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();	
	}
	
	function buscaPerfilID($id){
		$data = array(); 
		$q = $this->db->query("SELECT p.*,u.fancyUrl as fancyUrl FROM proveedores p LEFT JOIN usuarios u ON u.usuarioID=p.usuarioID WHERE p.usuarioID='$id'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function buscaSegmento($idProy){
		$data = array(); 
		$q = $this->db->query("SELECT
								s.seccionDesc as 'descripcion',
								s.idProyecto as 'idProyecto',
								u.nombre as 'nombreUnidad',
								u.simbolo as 'simboloUnidad',
								s.cantidad as 'cantidad',
								s.idSegmento as 'idSegmento'
								FROM 
								segmentoProyectos s
								LEFT JOIN unidades u ON s.unidadID=u.idUnidad
								WHERE s.idProyecto='$idProy'
								AND s.status='activo'
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function traecotizaciones(){
		$data = array(); 
		$q = $this->db->query("SELECT *,sum(precio_unitario) as total FROM cotizaciones GROUP BY idproveedor,idproyecto");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
}