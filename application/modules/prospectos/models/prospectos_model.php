<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prospectos_model extends CI_Model {

	function origenCliente(){
		$data = array();
		$q = $this->db->query("SELECT * from origenProspecto");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarProspectos(){
		$data = array();
		$q = $this->db->query("SELECT * from prospectos");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarProspectoPerfil($id){
		$data = array();
		$q = $this->db->query("SELECT * from prospectos WHERE id='$id' ");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarUsuariosID($id){
		$data = array();
		$q = $this->db->query("SELECT * from usuarios where usuarioID='$id'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarProspectosUsuario($usuarioID){
		$data = array();
		$q = $this->db->query("SELECT * from prospectos where usuarioID='$usuarioID' and status !='borrado' order by id desc");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function validaEmail($email){
		$data = array();
		$q = $this->db->query("SELECT * FROM prospectos p
								LEFT JOIN usuarios u ON u.usuarioID=p.usuarioID
								WHERE p.correo='$email'
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarZonasProspecto($prospectoID){

		$data = array();
        $q = $this->db->query("SELECT * FROM prospectosPlazas p
        						LEFT JOIN propiedades r ON r.clavePropiedad=p.plazaID
        						WHERE usuarioID='$prospectoID'
        						AND p.status='activa'");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}

	function cargarGirosProspecto($prospectoID){

		$data = array();
        $q = $this->db->query("SELECT
        						LCASE(g.giro) as 'giroProspecto'
        						FROM prospectos p
        						LEFT JOIN prospectoGiro g ON g.giroID=p.giro
        						WHERE p.id='$prospectoID'");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}

	function validaPlazaUsuario($usuarioID, $plazaID){

		$data = array();
        $q = $this->db->query("SELECT * FROM prospectosPlazas p
								LEFT JOIN zonas z ON z.idZona=p.plazaID
								WHERE p.usuarioID='$usuarioID'
								AND p.plazaID='$plazaID'
								");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}



	function cargarListaCotizaciones($usuarioID, $prospectoID){

		$cad_busqueda="";

		if( !empty($prospectoID) )
			$cad_busqueda="AND prospectoID='$prospectoID'";

		$query = $this->db->query("SELECT * FROM prospectoCotizacion WHERE usuarioID='$usuarioID' $cad_busqueda");
		if( $query->num_rows()>0 )
			return $query->result();
		else
			return -1;
	}


	function validaCotizacionUsuario($cotizacionID, $usuarioID){

		$data = array();
        $q = $this->db->query("SELECT * from prospectoCotizacion c
        						LEFT JOIN prospectos p ON p.id=c.prospectoID
        						WHERE c.cotizacionID='$cotizacionID' and c.usuarioID='$usuarioID'
        						");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}

	function cargaLocalesCotizacion($cotizacionID){
		$data = array();
        $q = $this->db->query("SELECT * FROM localesProspectosCotizacion where cotizacionID='$cotizacionID'");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}

	function cargaSubCotizacionProspecto($ID){

		$data = array();
        $q = $this->db->query("SELECT * FROM localesProspectosCotizacion where id='$ID'");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}

	function cargaPlazaInfo($ID){

		$data = array();
        $q = $this->db->query("SELECT * FROM localesBorrar where clavedeLocal='$ID'");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}

	function conteoLocales($cotizacionID){

		$data = array();
        $q = $this->db->query("SELECT count(*) as 'cuenta' FROM localesProspectosCotizacion where cotizacionID='$cotizacionID'");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}

	function cuentaCotizacionProspecto($prospectoID){
		$data = array();
        $q = $this->db->query("SELECT count(*) as cuenta from prospectoCotizacion where prospectoID='$prospectoID'");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}

	function cuentaCotizacionProspectoActivas($prospectoID){
		$data = array();
         $q = $this->db->query("SELECT *
					FROM prospectoCotizacion pc
					LEFT JOIN usuarios u ON u.usuarioID=pc.usuarioID
					WHERE prospectoID='$prospectoID'
					AND vigencia >= CURDATE()
					");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}

	function cuentaCotizacionProspectoID($prospectoID){
		$data = array();
         $q = $this->db->query("SELECT *
					FROM prospectoCotizacion pc
					LEFT JOIN usuarios u ON u.usuarioID=pc.prospectoID
					WHERE prospectoID='$prospectoID'
					AND vigencia >= CURDATE()
					");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}

	function cargaCotizacionProspecto($prospectoID){
		$data = array();
        $q = $this->db->query("SELECT * from prospectoCotizacion where prospectoID='$prospectoID' AND cartaIntId IS NULL");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}

	function cargaLocalesCotizadosProspectos($prospectoID){
		$data = array();
        $q = $this->db->query("SELECT * from prospectoCotizacion
        						WHERE prospectoID='$prospectoID'
        						AND vigencia >= CURDATE()
        						");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}

	function cargaCotizacionProspectoPorCot($cotId){
		$data = array();
        $q = $this->db->query("SELECT * from prospectoCotizacion
        						WHERE cotizacionID='$cotId'");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}

	function cargarCartasIntencion($prospectoId){
		$data = array();
        $q = $this->db->query("SELECT * FROM cartasIntencion ci
								LEFT JOIN prospectoCotizacion pc ON pc.cartaIntId = ci.id
								WHERE pc.prospectoID = '$prospectoId'");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}

	function cargarProspectosCotizacion($filtro){
		$data = array();
		$q = $this->db->query("SELECT *, count(pc.cotizacionID) as 'cantidad'
		FROM prospectos p
		LEFT JOIN prospectoCotizacion pc ON p.id=pc.prospectoID
		WHERE (lower(p.correo) LIKE '%$filtro%'
		OR lower(p.pnombre) LIKE '%$filtro%')
		AND pc.vigencia >= CURDATE()
		group by p.correo
		");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarProspectosNombre($filtro){
		$data = array();
		$q = $this->db->query("SELECT * FROM prospectos WHERE lower(pnombre) LIKE '%$filtro%'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarCotizacion($filtro){
		$data = array();
		$q = $this->db->query("SELECT * FROM prospectoCotizacion pc
			LEFT JOIN prospectos p ON p.id=pc.prospectoID
			WHERE folio LIKE '%$filtro%'
			");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarLocalesCotizacionID($busqueda){
		$data = array();
		$q = $this->db->query("SELECT * FROM localesProspectosCotizacion where cotizacionID='$busqueda'
			");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarInfoCompletaCotizacion($cotizacionID){
		$data = array();
		$q = $this->db->query("SELECT * FROM localesProspectosCotizacion lpc
														LEFT JOIN prospectoCotizacion pc ON pc.cotizacionID=lpc.cotizacionID
														LEFT JOIN prospectos p ON p.id=pc.prospectoID
														LEFT JOIN usuarios u ON u.usuarioID=p.usuarioID
														where lpc.id='$cotizacionID'
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
