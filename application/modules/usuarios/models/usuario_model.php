<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Usuario_model extends CI_Model
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
	
	function cargarProyectosRecomendacion($usuarioID,$obraTipo){
		$data = array(); 
		$q = $this->db->query("SELECT 
								p.zonasid as 'zonaID',
								e.claveEstado as 'estadosID',
								p.descripcionProyecto as 'descripcion',
								c.rangoMaximo as 'rangoMaximo',
								p.fechaCierreProyecto as 'cierreProyecto',
								p.tituloProyecto as 'tituloProyecto',
								z.zona as 'zona'
								FROM proyectos p
								LEFT JOIN costoRango c ON c.idRango=p.costoRangoid
								LEFT JOIN zonas_estadosMexico e ON e.zonasid=p.zonasid
								LEFT JOIN zonas z ON z.idZona=e.zonasid
								LEFT JOIN proveedores_estadosMexico pe ON pe.claveEstado=e.claveEstado
								LEFT JOIN proveedores pr ON pr.idProveedor=pe.proveedoresid
								WHERE pr.usuarioID='$usuarioID' AND p.costoRangoid=pr.idRango
								GROUP BY p.idProyecto
							");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function verificaDocumentacion($idProveedor){
		$data = array(); 
		$q = $this->db->query("SELECT certificado as certificado,
								actasConstitutivas as actasConstitutivas,
								cedulas as cedulas,
								shcp as shcp,
								edoCuenta as edoCuenta,
								comprobanteDomicilio as comprobanteDomicilio,
								credencialElector as credencialElector,
								IMSS as IMSS
								FROM proveedores
								WHERE idProveedor='$idProveedor'
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
}