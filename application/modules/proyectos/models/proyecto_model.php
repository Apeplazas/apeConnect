<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Proyecto_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	function traeproyecto($idproyecto){
		$data = array(); 
		$q = $this->db->query("SELECT 
			p.idProyecto,p.tituloProyecto, p.fechaCierreProyecto, p.descripcionProyecto,
			c.rangoMinimo, c.rangoMaximo,
			z.zona,
			count(pa.proveedorId) as 'postulantes'
			FROM proyectos p 
			LEFT JOIN costoRango c ON c.idRango=p.costoRangoid
			LEFT JOIN proyectosAsignados pa ON pa.proyectoId=p.idProyecto
			LEFT JOIN zonas z ON z.idZona=p.zonasid
			WHERE p.idProyecto='$idproyecto'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function traeproyecto_secciones($idproyecto,$idSecc){
		$data = array(); 
		$q = $this->db->query("SELECT 
			s.*,
			u.nombre as 'unidad',
			u.simbolo as 'simbolo' 
			FROM segmentoProyectos s 
			LEFT JOIN unidades u ON u.idUnidad=s.unidadID
			WHERE idProyecto='$idproyecto' AND s.idPartida='$idSecc' AND s.status='activo'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function cargeObrasProveedor($idproveedor){
				
		$data = array(); 
		$q = $this->db->query("SELECT count(id) as numeroObras 
								FROM proyectosAsignados
								WHERE proveedorId='$idproveedor'
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data = $row->numeroObras;
			}
			$q->free_result();  	
		}
		return $data;	
		
	}
	
	function cargaProyectoID($proyecto){
		
		$data = array(); 
		$q = $this->db->query("SELECT p.*,
								o.tipo,
								e.nombreEstado,
								z.zona,
								u.nombreCompleto
								FROM proyectos p
								LEFT JOIN obrasTipo o ON o.idTipo=p.obrasTipoid
								LEFT JOIN zonas z ON z.idZona=p.zonasid
								LEFT JOIN zonas_estadosMexico ze ON ze.zonasid=z.idZona
								LEFt JOIN estadosMexico e ON e.claveEstado=ze.claveEstado
								LEFT JOIN usuarios u ON u.usuarioID = p.usuarioID
								WHERE idProyecto='$proyecto'
								GROUP BY e.claveEstado
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
		
	}
	
	function cargaPartida($partidaId){
		
		$data = array(); 
		$q = $this->db->query("SELECT * FROM partidas WHERE id = '$partidaId'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
		
	}
	
	function cargaZonaPorProyecto($proyectoId){
		
		$data = array(); 
		$q = $this->db->query("SELECT z.* FROM zonas z
			LEFT JOIN proyectos p ON p.zonasid=z.idZona
			WHERE p.idProyecto = '$proyectoId'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
		
	}
	
	function cargaNumeroPartida($proyectoId,$paridaId){
				
		$data = array(); 
		$q = $this->db->query("SELECT count(idPartida) as totalPartidas FROM segmentoProyectos
			WHERE idProyecto = '$proyectoId' AND idPartida = '$paridaId'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data = $row->totalPartidas;
			}
			$q->free_result();  	
		}
		return $data;
		
	}
	
	function cargaArchivosProyecto($idproyecto){
		
		$data = array(); 
		$q = $this->db->query("SELECT *
			FROM archivosProyectos
			WHERE idProyecto='$idproyecto'
		");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
		
	}
	
	function cuentaCotizacionesProyectos($idproyecto)
	{
		$data = array(); 
		$q = $this->db->query("SELECT COUNT(distinct (idproveedor)) AS cuenta FROM cotizaciones WHERE idproyecto='$idproyecto'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function buscaProyectos(){
		$data = array(); 
		$q = $this->db->query("SELECT 
								p.tituloProyecto as 'tituloProyecto',p.descripcionProyecto as 'descripcionProyecto',p.idProyecto as 'idProyecto',p.statusProyecto as 'status',p.fechaUltimaRevision,p.fechaAutorizacion,p.fechaAsignacion,
								o.tipo as 'obraTipo',
								u.nombreCompleto
								FROM proyectos p
								LEFT JOIN obrasTipo o ON o.idTipo=p.obrasTipoid
								LEFT JOIN usuarios u ON u.usuarioID = p.usuarioID
								WHERE statusProyecto!='Borrado'
								ORDER BY p.fechaAltaProyecto DESC
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function buscaProyectosSupervisor($usuarioID){
		$data = array(); 
		$q = $this->db->query("SELECT 
								p.tituloProyecto as 'tituloProyecto',
								p.descripcionProyecto as 'descripcionProyecto',
								p.idProyecto as 'idProyecto',
								o.tipo as 'obraTipo',
								p.statusProyecto as 'status'
								FROM proyectos p
								LEFT JOIN obrasTipo o ON o.idTipo=p.obrasTipoid
								WHERE statusProyecto!='Borrado'
								AND p.usuarioID='$usuarioID'
								ORDER BY p.fechaAltaProyecto DESC
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function buscaSegmento($idProy,$idPartida){
		$data = array(); 
		$q = $this->db->query("SELECT
								s.seccionDesc as 'descripcion',s.idProyecto as 'idProyecto',s.cantidad as 'cantidad',s.idSegmento as 'idSegmento',s.claveSegmento,
								u.nombre as 'nombreUnidad',u.simbolo as 'simboloUnidad'
								FROM 
								segmentoProyectos s
								LEFT JOIN unidades u ON s.unidadID=u.idUnidad
								WHERE s.idProyecto='$idProy'
								AND s.idPartida='$idPartida'
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
	
	function tresegentocant($idsegmento){
		$data = array(); 
		$q = $this->db->query("SELECT 
								cantidad
								FROM segmentoProyectos
								WHERE idSegmento=$idsegmento
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function traecomentarios($idProy){
		$data = array(); 
		$q = $this->db->query("Select 
			o.id,o.observacion,o.comment_date,o.respuesta,
			u.nombreCompleto,
			r.nombre,
			sp.seccionDesc,sp.idSegmento
			From observaciones o 
			LEFT JOIN segmentoProyectos sp ON sp.idSegmento=o.idsegmento
			LEFT JOIN proyectos p ON p.idProyecto=sp.idProyecto
			LEFT JOIN usuarios u ON u.usuarioID=o.idusuario
			LEFT JOIN roles r ON r.id=u.idrole
			WHERE p.idProyecto='$idProy'
			ORDER BY o.comment_date ASC");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function traerespuesta($respid){
		$data = array(); 
		$q = $this->db->query("SELECT respuesta FROM respuestas WHERE id = $respid");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row->respuesta;
			}
			$q->free_result();  	
		}
		return $data;
	}	
	
	function tiene_cotizacion($idProy){
		$data = array(); 
		$q = $this->db->query("SELECT
			if(count(c.id)>0,true,false) as hasct
			FROM proyectos p
			LEFT JOIN cotizaciones c ON c.idproyecto=p.idProyecto
			WHERE p.idProyecto='$idProy'
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row->hasct;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function traecreador($idProy){
		$data = array(); 
		$q = $this->db->query("SELECT usuarioID FROM proyectos WHERE idProyecto='$idProy'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data = $row->usuarioID;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function cargaProyectosPorEstatusSupervisor($idSupervisor,$estatus){
		
		$data = array(); 
		$q = $this->db->query("SELECT count(idProyecto) as totalProyectos 
			FROM proyectos 
			WHERE usuarioID='$idSupervisor'
			AND statusProyecto='$estatus'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data = $row->totalProyectos;
			}
			$q->free_result();  	
		}
		return $data;
		
	}
	
	function cargaComentarios($idProy){
		$data = array(); 
		$q = $this->db->query("SELECT
			u.usuarioID, u.nombreCompleto as 'usuarioCompleto',
			r.nombre as 'tipo',
			p.tituloProyecto as 'proyecto',
			t.conversacionTipo as 'mensajeTipo',
			c.idConversacionTipo as 'tipoID', c.cID as 'comentarioID', c.fechaConversacion as 'fecha'
			FROM conversaciones c
			LEFT JOIN usuarios u ON u.usuarioID=c.idUsuarioUno
			LEFT JOIN roles r ON r.id=u.idrole
			LEFT JOIN proyectos p ON p.idProyecto=c.idProyecto
			LEFT JOIN conversacionesTipo t ON t.id=c.idConversacionTipo
			WHERE c.idProyecto='$idProy'
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function cargaComentariosID($idProy, $comentarioID){
		$data = array(); 
		$q = $this->db->query("SELECT
			c.cID as 'comentarioID', c.idProyecto, c.idConversacionTipo
			FROM conversaciones c
			WHERE c.idProyecto='$idProy'
			AND c.cID='$comentarioID'
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function cargaRespuestas($comentarioID){
		$data = array(); 
		$q = $this->db->query("SELECT 
			cr.respuesta as 'respuesta',
			cr.fechaRespuesta as 'fechaRespuesta',
			u.usuarioID, u.nombreCompleto as 'nombreCompleto'
			FROM 
			conversacionesRespuestas cr
			LEFT JOIN usuarios u ON u.usuarioID=cr.usuarioId
			WHERE cr.idConversacion='$comentarioID'
			ORDER BY cr.fechaRespuesta ASC
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function seHaCancelado($idProy){
		$data = array(); 
		$q = $this->db->query("SELECT 
			c.cID
			FROM conversaciones c
			WHERE c.idProyecto='$idProy'
			AND c.idConversacionTipo=3
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	//esta funcion se debe de incluir en el modilo de "mesajes" cuando se desarrolle
	function traeConverssacion($idConver){
		$data = array(); 
		$q = $this->db->query("SELECT * FROM conversaciones c WHERE c.cID='$idConver'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function traePartidas($proyectoId){
		$data = array(); 
		$q = $this->db->query("SELECT 
			p.id,p.nombre 
			FROM partidas p
			LEFt JOIN ProyectosPartidas pp ON pp.partidaId=p.id
			WHERE pp.proyectoId='$proyectoId' AND pp.status='activo'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function traeNombrePartidas($idProyecto){
		$data = array(); 
		$q = $this->db->query("SELECT 
			* 
			FROM partidas p
			WHERE p.id NOT IN (SELECT pp.partidaId FROM ProyectosPartidas pp WHERE pp.proyectoId='$idProyecto' AND pp.status='activo')");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function traeProyectoCreador($proyectoId){
		
		$data = array(); 
		$q = $this->db->query("SELECT p.usuarioID
			FROM proyectos p
			WHERE p.idProyecto='$proyectoId'
		");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
		
	}
	
	function comentariosProy($idProyecto){
			
		$data = array(); 
		$q = $this->db->query("SELECT 
			cr.*,c.cID,
			u.*
			FROM conversaciones c
			LEFT JOIN conversacionesRespuestas cr ON cr.idConversacion=c.cID
			LEFT JOIN usuarios u ON u.usuarioID=cr.usuarioId
			WHERE idProyecto='$idProyecto' AND idConversacionTipo=4
			ORDER BY  cr.fechaRespuesta ASC
		");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
		
	}
	
	function converIniciada($idProyecto,$idUsuario){
			
		$data = array(); 
		$q = $this->db->query("SELECT * FROM conversaciones c 
			WHERE c.idProyecto = '$idProyecto' 
			AND c.idUsuarioUno = '$idUsuario'
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