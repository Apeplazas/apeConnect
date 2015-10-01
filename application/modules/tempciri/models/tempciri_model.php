<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Tempciri_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	function traepar_plazas(){
		
		$data = array(); 
		$q = $this->db->query("SELECT PROPIEDAD FROM TEMPORA_PROPIEDADES GROUP BY PROPIEDAD");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function traerDatosPLaza($plaza){
		
		$data = array(); 
		$q = $this->db->query("SELECT * FROM TEMPORA_PLAZA WHERE plaza = '$plaza'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function cargarCiPorPLaza($plaza){
		
		$data = array(); 
		$q = $this->db->query("SELECT ci.id,ci.folio 
			FROM TEMPORA_CI ci 
			LEFT JOIN TEMPORA_PLAZA_RENTAS r ON r.ciId = ci.id
			WHERE ci.plaza = '$plaza'
			AND r.riId IS NULL");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function cargarPLazasDir($plaza){
		
		$data = array(); 
		$q = $this->db->query("SELECT pd.* 
			FROM TEMPORA_PLAZA_DIR pd
			LEFT JOIN TEMPORA_PLAZA p ON p.id = pd.plazaid
			WHERE p.plaza = '$plaza'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function cargarCis($userId){
		
		$data = array(); 
		$q = $this->db->query("SELECT ci.contraroInicioMes,ci.estado,ci.pdf,ci.contratoDuracion, ci.diasGracia,ci.id,ci.deposito,ci.ifeFolio,ci.devolucionCuenta,ci.devolucionBanco,ci.diasGracia,ci.gerentePlaza,ci.folioComprobante,ci.folio,ci.fecha,
			c.id as 'clienteId',c.pnombre,c.snombre,c.apellidopaterno,c.apellidomaterno,c.telefono,c.email,c.rfc,
			pr.dir,pr.local,pr.renta,pr.plazaId as 'plazaNombre',pr.dir,
			u.nombreCompleto
			FROM TEMPORA_CI ci 
			LEFT JOIN TEMPORA_CLIENTES c ON c.id = ci.clienteId
			LEFT JOIN TEMPORA_PLAZA_RENTAS pr ON pr.ciId=ci.id
			LEFT JOIN usuarios u ON u.usuarioID = ci.usuarioId
			WHERE ci.usuarioId = '$userId'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function cargarRis($userId){
		
		$data = array(); 
		$q = $this->db->query("SELECT ri.contratoInicio,ri.contratoDuracion, ri.diasGracia,ri.folio,ri.pdf,ri.id,ri.estado,
			c.id as 'clienteId',c.pnombre,c.snombre,c.apellidopaterno,c.apellidomaterno,c.telefono,c.email,c.rfc
			FROM TEMORA_RI ri 
			LEFT JOIN TEMPORA_CLIENTES c ON c.id = ri.clienteId
			WHERE ri.usuarioId = '$userId'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function traerDatosCi($ciId){
		
		$data = array(); 
		$q = $this->db->query("SELECT ci.contraroInicioMes,ci.contratoDuracion, ci.diasGracia,ci.id,ci.deposito,ci.ifeFolio,ci.devolucionCuenta,ci.devolucionBanco,ci.gerentePlaza,ci.folioComprobante,ci.folio,ci.fecha,ci.vendedorNombre,
			c.id as 'clienteId',c.pnombre,c.snombre,c.apellidopaterno,c.apellidomaterno,c.telefono,c.email,c.rfc,c.tipo as 'tipoCliente',c.fechaNacimiento,
			pr.dir,pr.local,pr.renta,pr.plazaId as 'plazaNombre',pr.dir
			FROM TEMPORA_CI ci 
			LEFT JOIN TEMPORA_CLIENTES c ON c.id = ci.clienteId
			LEFT JOIN TEMPORA_PLAZA_RENTAS pr ON pr.ciId=ci.id
			WHERE ci.id = '$ciId'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function traerDatosRi($riId){
		
		$data = array(); 
		$q = $this->db->query("SELECT ri.contratoInicio,ri.contratoDuracion, ri.diasGracia,ri.id,ri.deposito,ri.diasGracia,ri.folio,ri.fecha,ri.ciId,ri.vendedorNombre,ri.observaciones,
			c.id as 'clienteId',c.pnombre,c.snombre,c.apellidopaterno,c.apellidomaterno,c.telefono,c.email,c.rfc,
			pr.dir,pr.local,pr.renta,pr.plazaId as 'plazaNombre',pr.dir,
			ci.deposito as 'depositoCi'
			FROM TEMORA_RI ri 
			LEFT JOIN TEMPORA_CLIENTES c ON c.id = ri.clienteId
			LEFT JOIN TEMPORA_PLAZA_RENTAS pr ON pr.ciId=ri.id
			LEFT JOIN TEMPORA_CI ci ON ci.id = ri.ciId
			WHERE ri.id = '$riId'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function checkRefCi($clientRfc,$plaza,$local){
		
		$data = array(); 
		$q = $this->db->query("SELECT * FROM TEMPORA_PLAZA_RENTAS r
			LEFT JOIN TEMPORA_CLIENTES c ON c.id=r.clienteId
			WHERE c.rfc = '$clientRfc'
			AND r.plazaId = '$plaza'
			AND r.local = '$local'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function checkRefRi($clientRfc,$plaza,$local){
		
		$data = array(); 
		$q = $this->db->query("SELECT * FROM TEMPORA_PLAZA_RENTAS r
			LEFT JOIN TEMPORA_CLIENTES c ON c.id=r.clienteId
			WHERE c.rfc = '$clientRfc'
			AND r.plazaId = '$plaza'
			AND r.local = '$local'
			AND r.riId IS NOT NULL");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
}