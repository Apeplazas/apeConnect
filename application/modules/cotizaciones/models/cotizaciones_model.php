<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Cotizaciones_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();	
	}
	
	function traecotizaciones(){
		$data = array(); 
		$q = $this->db->query("SELECT 
			c.id, sum(c.precio_unitario*s.cantidad) as total, c.fechaCotizacion,
			p.tituloProyecto,
			pv.razonSocial
			FROM cotizaciones c 
			LEFT JOIN segmentoProyectos s ON s.idSegmento=c.idsegmento
			LEFT JOIN proyectos p ON p.idProyecto=c.idproyecto
			LEFT JOIN proveedores pv ON pv.idProveedor=c.idproveedor
			WHERE p.statusProyecto = 'Contratando'
			GROUP BY c.idproveedor,c.idproyecto
			ORDER BY c.fechaCotizacion DESC");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function traeobservaciones($idSegmento,$usuarioId){
		$data = array(); 
		$q = $this->db->query("SELECT observacion as 'observacion'  FROM observaciones WHERE idSegmento='$idSegmento' AND idusuario='$usuarioId'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function traecotizaciones_porproyecto(){
		$data = array(); 
		$q = $this->db->query("SELECT r.idProyecto as id,min(r.total) as cmin,max(r.total) as cmax,r.tituloProyecto,sum(r.ncot) as ncot
			FROM
				(SELECT 
					p.idProyecto, sum(c.precio_unitario*s.cantidad) as total,
					count(distinct(c.idproveedor)) as ncot,
					p.tituloProyecto,
					pv.razonSocial
					FROM cotizaciones c 
					LEFT JOIN segmentoProyectos s ON s.idSegmento=c.idsegmento
					LEFT JOIN proyectos p ON p.idProyecto=c.idproyecto
					LEFT JOIN proveedores pv ON pv.idProveedor=c.idproveedor
					WHERE p.statusProyecto = 'Contratando'
					GROUP BY c.idproveedor,c.idproyecto
				) r
			GROUP BY r.tituloProyecto");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function traecotizacion($idcot){
		$data = array(); 
		$q = $this->db->query("SELECT 
			c.id,c.idproyecto,c.idproveedor,c.precio_unitario,c.matrizDesglose,
			s.idSegmento, s.seccionDesc,s.cantidad,s.idPartida,
			(s.cantidad*c.precio_unitario) as segtotal,
			p.tituloProyecto,
			pv.razonSocial,
			u.usuarioID,
			pa.nombre,
			un.simbolo 
			FROM cotizaciones c 
			LEFT JOIN segmentoProyectos s ON s.idSegmento=c.idsegmento
			LEFT JOIN partidas pa ON pa.id=s.idPartida
			LEFT JOIN unidades un ON un.idUnidad=s.unidadID
			LEFT JOIN proyectos p ON p.idProyecto=c.idproyecto
			LEFT JOIN proveedores pv ON pv.idProveedor=c.idproveedor
			LEFT JOIN usuarios u ON u.usuarioID=pv.usuarioID
			WHERE c.idproyecto=(SELECT idproyecto FROM cotizaciones WHERE id=$idcot) AND c.idproveedor=(SELECT idproveedor FROM cotizaciones WHERE id=$idcot)");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function traecotizacion_deproyecto($idproyecto){
		$data = array(); 
		$q = $this->db->query("SELECT 
					c.id,c.idproveedor,(c.precio_unitario*s.cantidad) totalseg,
					s.idSegmento,s.seccionDesc,
					p.tituloProyecto,
					pv.razonSocial
					FROM cotizaciones c 
					LEFT JOIN segmentoProyectos s ON s.idSegmento=c.idsegmento
					LEFT JOIN proyectos p ON p.idProyecto=c.idproyecto
					LEFT JOIN proveedores pv ON pv.idProveedor=c.idproveedor
					WHERE c.idproyecto=$idproyecto
					ORDER BY c.idproveedor,s.idSegmento");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function traeDetalleCot($proyId,$proveedorId){
		$data = array(); 
		$q = $this->db->query("SELECT 
			c.id, sum(c.precio_unitario*s.cantidad) as total,
			p.tituloProyecto,
			pv.razonSocial 
			FROM cotizaciones c 
			LEFT JOIN segmentoProyectos s ON s.idSegmento=c.idsegmento
			LEFT JOIN proyectos p ON p.idProyecto=c.idproyecto
			LEFT JOIN proveedores pv ON pv.idProveedor=c.idproveedor
			WHERE p.statusProyecto = 'Contratando' AND c.idproyecto = '$proyId' AND c.idproveedor = '$proveedorId'
			GROUP BY c.idproveedor,c.idproyecto");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	
	function traeParticipantesProyecto($proyId,$provElegidoId){
		$data = array(); 
		$q = $this->db->query("SELECT u.email
			FROM usuarios u
			LEFT JOIN proveedores p ON p.usuarioID=u.usuarioID
			LEFT JOIN cotizaciones c ON c.idproveedor=p.idProveedor
			WHERE c.idproyecto = '$proyId' AND c.idproveedor not in ('$provElegidoId')
			GROUP BY c.idproveedor");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
}