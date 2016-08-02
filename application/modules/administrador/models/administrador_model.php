<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrador_model extends CI_Model
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
		$q = $this->db->query("SELECT * FROM TEMPORA_PLAZA WHERE plaza = '$plaza' OR id = '$plaza'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;

	}

	function traerGerentePLaza($plazaId){

		$data = array();
		$q = $this->db->query("SELECT u.*
		FROM TEMPORA_PLAZA p
		LEFT JOIN usuarios u ON u.usuarioID = p.gerente
		WHERE p.id = '$plazaId'");

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

 function traerPlazaPisos($plazaId){

		$data = array();
		$q = $this->db->query("SELECT *
			FROM TEMPORA_PLAZA_DIR pp
			WHERE pp.plazaid = '$plazaId'
			GROUP BY pp.piso");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;

	}

	function cargarPLazasDir($plazaId,$plazaPiso){

		$data = array();
		$q = $this->db->query("SELECT pd.*
			FROM TEMPORA_PLAZA_DIR pd
			WHERE pd.piso = '$plazaPiso'
			AND pd.plazaid = '$plazaId'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;

	}
	
	function cargarUsuarioCart($usuarioID){
		$data = array();
		$q = $this->db->query("SELECT  u.usuarioID, u.nombreCompleto,ci.plaza, u.status
		     FROM usuarios u
		     LEFT JOIN TEMPORA_CI ci ON ci.usuarioID = u.usuarioId
		     WHERE u.idrole= '5'
		     		     ");
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
    function cargarUsuariosPros($usuarioID){
    	$data = array();
         $q = $this->db->query("SELECT u.usuarioID,u.nombreCompleto, u.status
                 FROM usuarios u 
                 LEFT JOIN prospectos p ON p.usuarioID = u.usuarioID
                 AND p.status = u.status
                 WHERE u.idrole ='8'
                  ");
        if($q->num_rows()>0){
        	foreach($q->result() as $row){
        		$data[] = $row;		
      
        	}
        	$q->free_result();
        }
        return $data;
    }


	function traerPlazaUsuario($usuarioId,$plazaid = false){
		$extraData = (!empty($plazaid)) ? "AND p.id = '$plazaid'" : "";

		$data = array();

		$q = $this->db->query("SELECT p.*
			FROM TEMPORA_PLAZA p
			LEFT JOIN usuarios u ON u.plazaId = p.id
			WHERE u.usuarioID = '$usuarioId' $extraData");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;

	}
   function traerDatosUsuarios($usuarioID){
   	   $data = array();
   	   $q =$this->db->query("SELECT u.nombreCompleto,u.email, u.status, ci.plaza
   	   	     FROM usuarios u
   	   	     LEFT JOIN TEMPORA_CI ci ON ci.usuarioId = u.usuarioID
              WHERE u.usuarioID = '$usuarioID' ");
   	   if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;

   }	

   function traerDatosUsuariosProsp($usuarioID){
   	    $data = array();
   	   $q =$this->db->query("SELECT u.nombreCompleto,u.email, u.status
   	   	     FROM usuarios u
   	   	     LEFT JOIN prospectos p ON p.usuarioID = u.usuarioID
              WHERE u.usuarioID = '$usuarioID' ");
   	   if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;

   }

 function usuarioExist($usuarioID){
 	$data = array();
 	$q = $this->db->query("SELECT * FROM  usuarios
 		  WHERE usuarioID = '$usuarioID'");
 	if ($q->num_rows()> 0) {
 		foreach ($q->result()as $row) {
 			$data[]=$row;

 		}
 		$q->free_result();
 	}
 	return$data;
 }


	function busquedaEmail($email, $nombreCompleto){

		$data = array();

		$q = $this->db->query("SELECT * FROM roles_modulos r
			LEFT JOIN roles rl ON r.idrole=rl.id
			LEFT JOIN usuarios u ON u.idrole=rl.id
			LEFT JOIN TEMPORA_PLAZA tp ON tp.id = u.plazaId
			where r.idmodulo='12'
			and u.email like '%$email%'
			and u.nombreCompleto like '%$nombreCompleto%'");

		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

   function busquedaEmailPros($email, $nombreCompleto){
   	 $data = array();
   	 $q = $this->db->query("SELECT * FROM roles_modulos mr
   	 	  LEFT JOIN roles r ON mr.idrole = r.id
   	 	  LEFT JOIN usuarios u ON u.idrole = r.id
   	 	  LEFT JOIN prospectos P ON p.usuarioID = u.usuarioID
   	 	  WHERE mr.idmodulo='15'
   	 	  AND u.email like '%$email%'
   	 	  AND  u.nombreCompleto like '%$nombreCompleto%'");

		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
   }
}