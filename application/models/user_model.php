<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

/****************************************
*	Funciones generaless				*
*****************************************/

	//Funcion para validar login
	function validateLogin($var, $password)
    {
        $data = array();
        //si no existen los datos regresamos false
        if(empty($var) || empty($password) || !isset($var) || !isset($password) )
				return false;
				//Verificar si usuario o email existen
				$check_user_mail = $this->db->query("SELECT * FROM usuarios WHERE fancyUrl='$var' OR email='$var'");

				if($check_user_mail->num_rows() > 0){
					$check_user_mail->free_result();
					//si todo va bien, creamos el md5 del pwd.
        	$passwordShai = md5($password);

					$query = $this->db->query("SELECT
						u.*,
						r.nombre as tipoUsuario
						FROM usuarios u
						LEFT JOIN roles r ON r.id=u.idrole
						WHERE (fancyUrl='$var' OR email='$var')
						AND hash='$passwordShai'
						AND status='Activado'");
			if($query->num_rows() > 0) {
            	foreach($query->result() as $row){
                	$data[] = $row;
            	}
            	$query->free_result();

			 	return $data;
        	}else{
        		$data['error'] = "Contraseña inválida.";
        		return $data;
        	}

        }else{
        	$data['error'] = "Usuario o email inválido.";
        	return $data;
        }

    }

	function traemodulos($roleid){
		$data = array();
		$q = $this->db->query("SELECT m.nombre
			FROM modulos m
			LEFT JOIN roles_modulos rm ON rm.idmodulo=m.id
			WHERE rm.idrole='$roleid'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row->nombre;
			}
			$q->free_result();
		}
		return $data;
	}

	function traeSeccionesModulos($modulo,$roleid){
		$data = array();
		$q = $this->db->query("SELECT s.seccion
			FROM modulos_secciones s
			LEFT JOIN modulos m ON m.id=s.moduloId
			WHERE m.nombre='$modulo'
			AND s.idrole='$roleid'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row->seccion;
			}
			$q->free_result();
		}
		return $data;
	}

	function checkuser(){

		$user = $this->session->userdata('usuario');
			if(!isset($user) || $user != true)
        {
        	$this->session->set_userdata(array('previous_page'=> uri_string()));
         	redirect('');
      }else{
        if(!in_array($this->uri->segment(1), array_keys($user['modulos'])))
				redirect('');
        }
	}

	function checkuserSection(){
		$user = $this->session->userdata('usuario');
        if(!isset($user) || $user != true){
        	$this->session->set_userdata(array('previous_page'=> uri_string()));
         	redirect('');
        }else{
        	if(!in_array($this->uri->segment(2), $user['modulos'][$this->uri->segment(1)]))
				redirect('');
        }
	}

	function traevista($userid,$modulo){
		$data = array();
		$q = $this->db->query("SELECT rv.vista
			FROM roles_vistas rv
			LEFT JOIN usuarios u ON u.idrole=rv.idrole
			LEFT JOIN modulos m ON m.id=rv.idmodulo
			WHERE u.usuarioID='$userid' AND m.nombre='$modulo'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data = $row->vista;
			}
			$q->free_result();
		}
		return $data;
	}

	function numero_mensajes($user_id){
		$data = array();
		$q = $this->db->query("SELECT
			(SELECT count(leido) FROM mensajes_usuarios_roles WHERE usuarioid='$user_id' AND leido=0) + (SELECT count(id) FROM mensajes_usuarios WHERE usuarioid='$user_id' AND leido=0) as total");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data = $row->total;
			}
			$q->free_result();
		}
		return $data;
	}

	//Ver si el usuario puede ejecutar una accion
	function puedeEjecAcc($userId,$moduloId,$accionId,$seccionId = 0){
		$data = array();
		$q = $this->db->query("SELECT ac.usuarioId
			FROM acciones_usuarios ac
			WHERE ac.usuarioId='$userId' AND ac.moduloId='$moduloId' AND ac.seccionId='$seccionId' AND ac.accionId='$accionId'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

/****************************************
*	Funciones proveedores				*
*****************************************/

	//Funcion para traer datos de un proveedor
	function traeproveedor($id){
		$data = array();
		$q = $this->db->query("SELECT p.*,u.fancyUrl as fancyUrl,u.nombreCompleto as nombreAdmin FROM proveedores p LEFT JOIN usuarios u ON u.usuarioID=p.usuarioID WHERE p.usuarioID='$id'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function traeProveeedorEmail($idProv){
		$data = array();
		$q = $this->db->query("SELECT u.email
			FROM usuarios u
			LEFT JOIN proveedores p ON p.usuarioID=u.usuarioID
			WHERE p.idProveedor='$idProv'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data = $row->email;
			}
			$q->free_result();
		}
		return $data;
	}

	function traerproveedordetails($fancyUrl){
		$data = array();
		$q = $this->db->query("SELECT
			u.usuarioID as 'usuarioID', u.nombreCompleto as 'nombre', u.telefono as 'telefono', u.celular as 'celular', u.email as 'email', u.joined_date as 'fechaincgeso',
			p.idProveedor, p.razonSocial, p.tipoRegistro, (SELECT nombreMunicipio FROM estadosMexico WHERE claveMunicipio = p.municipioCompania AND claveColonia = p.coloniaCompania AND codigoCP = p.cpCompania LIMIT 1) as 'municipio', (SELECT nombreColonia FROM estadosMexico WHERE claveColonia = p.coloniaCompania AND claveMunicipio = p.municipioCompania AND codigoCP = p.cpCompania LIMIT 1) as 'colonia', p.cpCompania as 'cp', p.direccionCompania as 'direccion', p.representanteLegal as 'representante', p.certificado, p.actasConstitutivas, p.cedulas, p.shcp, p.edoCuenta, p.comprobanteDomicilio, p.credencialElector, p.IMSS as 'imss', p.statusProveedor,
			c.idRango
			FROM usuarios u
			LEFT JOIN proveedores p ON p.usuarioID=u.usuarioID
			LEFT JOIN costoRango c ON c.idRango=p.idRango
			WHERE u.fancyUrl='$fancyUrl' LIMIT 1");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function traerproveedorestados($idproveedor){
		$data = array();
		$q = $this->db->query("SELECT
			e.nombreEstado
			FROM estadosMexico e
			LEFT JOIN proveedores_estadosMexico pe ON pe.claveEstado=e.claveEstado
			WHERE pe.proveedoresid='$idproveedor'
			GROUP BY e.claveEstado");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function traerproveedor_proyectos($idproveedor,$tipoproyecto){
		$data = array();
		$q = $this->db->query("SELECT
			p.tituloProyecto
			FROM proyectos p
			LEFT JOIN proyectosAsignados pa ON pa.proyectoid=p.idProyecto
			WHERE pa.proveedorId='$idproveedor' AND p.statusProyecto='$tipoproyecto'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	//Proyectos recomendados para proveedor
	function cargarProyectosRecomendacion($usuarioID){
		$data = array();
		$q = $this->db->query("SELECT
								p.zonasid as 'zonaID', p.descripcionProyecto as 'descripcion', 	p.fechaAltaProyecto as 'fechaAltaProyecto', p.fechaCierreProyecto as 'cierreProyecto', p.tituloProyecto as 'tituloProyecto', p.idProyecto,
								e.claveEstado as 'estadosID',
								c.rangoMinimo as 'rangoMinimo', c.rangoMaximo as 'rangoMaximo',
								o.tipo as 'tipoobra',
								z.zona as 'zona'
								FROM proyectos p
								LEFT JOIN obrasTipo o ON o.idTipo=p.obrasTipoid
								LEFT JOIN costoRango c ON c.idRango=p.costoRangoid
								LEFT JOIN zonas_estadosMexico e ON e.zonasid=p.zonasid
								LEFT JOIN zonas z ON z.idZona=e.zonasid
								LEFT JOIN proveedores_estadosMexico pe ON pe.claveEstado=e.claveEstado
								LEFT JOIN proveedores pr ON pr.idProveedor=pe.proveedoresid
								WHERE pr.usuarioID='$usuarioID' AND p.obrasTipoid in (SELECT idTipo FROM proveedores_obrasTipo WHERE idProveedor=pr.idProveedor) AND p.fechaCierreProyecto>NOW() AND p.statusProyecto = 'Contratando'
								GROUP BY p.idProyecto
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

	function traeproveedores(){

		$data = array();
		$q = $this->db->query("SELECT p.*,u.fancyUrl as fancyUrl FROM proveedores p LEFT JOIN usuarios u ON p.usuarioID=u.usuarioID WHERE p.statusProveedor!='Borrado'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;

	}

	function checkdocs($idproveedor){
		$data = array();
		$q = $this->db->query("SELECT certificado,actasConstitutivas,cedulas,shcp,edoCuenta,comprobanteDomicilio,credencialElector,IMSS FROM proveedores WHERE idProveedor='$idproveedor' LIMIT 1");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function hacotizado($idproyecto,$userid){
		$data = array();
		$q = $this->db->query("SELECT c.id
			FROM cotizaciones c
			LEFT JOIN proveedores p ON p.idProveedor=c.idproveedor
			WHERE p.usuarioID='$userid' AND c.idproyecto='$idproyecto'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}


/****************************************
*	Funciones Administradores			*
*****************************************/

	function traeadministradores(){
		$data = array();
		$q = $this->db->query("SELECT * FROM usuarios WHERE idrole='1'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function traeadmin($id){
		$data = array();
		$q = $this->db->query("SELECT u.*,u.nombreCompleto nombreAdmin FROM usuarios u WHERE u.usuarioID='$id'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function traerJefeDirecto($id){
		$data = array();
		$q = $this->db->query("SELECT u.*,u.nombreCompleto nombreAdmin FROM usuarios u WHERE u.numeroEmpleado='$id'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function verificarCiProp($userId,$ciId){

		$data = array();
		$q = $this->db->query("SELECT * FROM TEMPORA_CI c WHERE c.usuarioId='$userId' AND c.id = '$ciId'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;

	}
   function verificarCancelProsp($usuarioID){
   	  $this->db->query(" UPDATE  usuarios SET status='Desactivado' WHERE usuarioID=$usuarioID");
   }

     function verificarActivoProsp($usuarioID){
   	  $this->db->query(" UPDATE  usuarios SET status='Activado' WHERE usuarioID=$usuarioID");
   }


      function verificarCanceladoCartaI($usuarioID){
   	  $this->db->query(" UPDATE  usuarios SET status='Desactivado' WHERE usuarioID=$usuarioID");
   }

     function verificarActivoCartaI($usuarioID){
   	  $this->db->query(" UPDATE  usuarios SET status='Activado' WHERE usuarioID=$usuarioID");
   }
	function verificarRiProp($userId,$riId){

		$data = array();
		$q = $this->db->query("SELECT * FROM TEMORA_RI r WHERE r.usuarioId='$userId' AND r.id = '$riId'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;

	}

}
