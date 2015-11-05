<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Planogramas_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	function traerPlano($planoId){
		$data = array();
		$q = $this->db->query("SELECT v.* FROM planogramas p
			LEFT JOIN vector v ON v.plazaId=p.id
			WHERE p.id = '$planoId'
			AND v.status !='borrado'
			AND v.status !='areaPublica'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function traerInfoPlano($planoId){
		$data = array();
		$q = $this->db->query("SELECT
									v.id as 'id',
									v.grupoId as 'grupoId',
									v.tipo as 'tipo',
									v.x as 'x',
									v.y as 'y',
									v.x1 as 'x1',
									v.y1 as 'y1',
									v.x2 as 'x2',
									v.y2 as 'y2',
									v.cx as 'cx',
									v.cy as 'cy',
									v.d as 'd',
									v.r as 'r',
									v.rx as 'rx',
									v.ry as 'ry',
									v.width as 'width',
									v.height as 'height',
									v.points as 'points',
									v.transform as 'transform',
									v.localID as 'localID',
									l.Uso_1 as 'status',
									c.fechaEmision as 'fechaEmision',
									l.precioLocal as 'precioLocal'
								FROM planogramas p
								LEFT JOIN vector v ON v.plazaId=p.id
								LEFT JOIN contratos c ON c.Clavedelocal=v.localID
								LEFT JOIN vic_local l ON l.local=v.localID
								WHERE p.id = '$planoId'
								AND v.status !='borrado'
								AND v.status !='areaPublica'
								AND v.tipo !='text'
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function traerRenovacionesPlano($planoId){
		$data = array();
		$q = $this->db->query("SELECT
									v.id as 'id',
									v.tipo as 'tipo',
									v.x as 'x',
									v.y as 'y',
									v.x1 as 'x1',
									v.y1 as 'y1',
									v.x2 as 'x2',
									v.y2 as 'y2',
									v.cx as 'cx',
									v.cy as 'cy',
									v.d as 'd',
									v.r as 'r',
									v.rx as 'rx',
									v.ry as 'ry',
									v.width as 'width',
									v.height as 'height',
									v.points as 'points',
									v.transform as 'transform',
									v.localID as 'localID',
									l.Uso_1 as 'status',
									c.fechaEmision as 'fechaEmision',
									l.precioLocal as 'precioLocal',
									c.Clavedelocal as 'Clavedelocal',
									l.nombre as 'nombreLocal',
									v.contenido as 'contenido'
								FROM planogramas p
								LEFT JOIN vector v ON v.plazaId=p.id
								LEFT JOIN contratos c ON c.Clavedelocal=v.localID
								LEFT JOIN vic_local l ON l.local=v.localID
								WHERE p.id = '$planoId'
								AND v.status !='borrado'
								AND v.status !='areaPublica'
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function traerAreaPublica($planoId){
		$data = array();
		$q = $this->db->query("SELECT
									v.id as 'id',
									v.tipo as 'tipo',
									v.x as 'x',
									v.y as 'y',
									v.x1 as 'x1',
									v.y1 as 'y1',
									v.x2 as 'x2',
									v.y2 as 'y2',
									v.cx as 'cx',
									v.cy as 'cy',
									v.d as 'd',
									v.r as 'r',
									v.rx as 'rx',
									v.ry as 'ry',
									v.width as 'width',
									v.height as 'height',
									v.points as 'points',
									v.transform as 'transform',
									v.localID as 'localID',
									a.vicEstatus as 'status'
								FROM planogramas p
								LEFT JOIN vector v ON v.plazaId=p.id
								LEFT JOIN Art a ON a.Articulo=v.localID
								WHERE p.id = '$planoId'
								AND v.status ='areaPublica'
								AND v.tipo !='text'
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}


	function cargarPlaza(){
		$data = array();
		$q = $this->db->query("SELECT * FROM propiedades");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function buscarClaveLocalVector($id){
		$data = array();
		$q = $this->db->query("SELECT localID, tipo FROM vector WHERE id='$id'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}


	function cargarPlanosAsignar($planogramaID){
		$data = array();
		$q = $this->db->query("SELECT * FROM vector WHERE  plazaId='$planogramaID' AND tipo!='text'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarPlanogramas(){
		$data = array();
		$q = $this->db->query("SELECT * FROM planogramas GROUP BY plaza");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarPlanogramasID($id){
		$data = array();
		$q = $this->db->query("SELECT * FROM planogramas WHERE id='$id' and estatus='1'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarPisos($plaza){
		$data = array();
		$q = $this->db->query("SELECT * FROM planogramas WHERE plaza='$plaza' and estatus='1' order by piso asc ");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarPisosArray($plaza){
		$data = array();
		$q = $this->db->query("SELECT piso FROM planogramas WHERE plaza='$plaza'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row->piso;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarTexto($planoId){
		$data = array();
		$q = $this->db->query("SELECT
								v.id as 'id',
								p.id as 'planogramaID',
								v.transform as 'transform',
								a.Articulo as 'localID'
								FROM planogramas p
								LEFT JOIN vector v ON v.plazaId=p.id
								LEFT JOIN Art a ON a.Articulo=v.localID
								WHERE p.id = '$planoId'
								AND v.status !='borrado'
								AND v.tipo ='text'
								AND orden !=''
								AND infoTipo ='1'
								group by v.localID
			");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function traerID($planoId, $localID, $orden){
		$data = array();
		$q = $this->db->query("SELECT *
								FROM planogramas p
								LEFT JOIN vector v ON v.plazaId=p.id
								LEFT JOIN vic_local i ON i.local=v.localID
								LEFT JOIN contratos c ON c.Clavedelocal=v.localID
								WHERE p.id = '$planoId'
								AND v.localID='$localID'
								AND v.tipo='text'
								AND v.orden='$orden'
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function traerIDNulos($planoId, $localID){
		$data = array();
		$q = $this->db->query("SELECT *
								FROM planogramas p
								LEFT JOIN vector v ON v.plazaId=p.id
								LEFT JOIN vic_local i ON i.local=v.localID
								LEFT JOIN contratos c ON c.Clavedelocal=v.localID
								WHERE p.id = '$planoId'
								AND v.localID='$localID'
								AND v.tipo='text'
								AND v.orden IS NULL
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargaCamposBD(){
		$data = array();
		$q = $this->db->query("SELECT c.*, i.* FROM vic_local i
								LEFT JOIN contratos c ON c.Clavedelocal=i.local
								LIMIT	 1
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
