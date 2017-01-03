<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Dashboard_model extends CI_Model
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
	
	function trae_numcotizaciones(){
		$data = array(); 
		$q = $this->db->query("SELECT count(coti) as cot_total
			FROM
			(SELECT 
				distinct(c.idproyecto) as coti,c.idproveedor
				FROM cotizaciones c
				LEFT JOIN proyectos p ON p.idProyecto = c.idproyecto
				WHERE p.statusProyecto = 'Contratando'
			) cotiza");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function trae_proveedores_estadi(){
		$data = array(); 
		$q = $this->db->query("SELECT ((mes_actual*100)/mes_pasado) as porcentaje, mes_actual FROM
			(SELECT 
				count(u.usuarioID) as mes_pasado,
				(SELECT 
					count(usuarioID)
					FROM usuarios
					WHERE idrole=2 
					AND joined_date >= DATE_FORMAT( CURRENT_DATE, '%Y/%m/01' )
				) as mes_actual
				FROM usuarios u 
				WHERE u.idrole=2 
				AND u.joined_date >= DATE_FORMAT( CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01' ) 
				AND u.joined_date < DATE_FORMAT( CURRENT_DATE, '%Y/%m/01' )
			) result");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function trae_ultimos_proveedores_inscritos(){
		$data = array(); 
		$q = $this->db->query("
							SELECT
							p.razonSocial as 'razonSocial',
							p.tipoRegistro as 'tipoRegistro',
							p.fisDireccion as 'fisDireccion',
							p.idProveedor,
							u.telefono as 'telefono',
							e.nombreEstado as 'nombreEstado'
							FROM proveedores p 
							LEFT JOIN usuarios u ON u.usuarioID=p.usuarioID
							LEFT JOIN estadosMexico e ON e.claveEstado=p.fisEstado
							group by p.idProveedor, e.claveEstado
							ORDER BY p.fechaRegistro 	
							DESC LIMIT 4			
							");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	//MIKEE
	
	function prediales($prediales){
		$data = array(); 
		$q = $this->db->query("SELECT * FROM layouts_predial
										where INMUEBLE_ID = '$prediales'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	function cuentaprediales($prediales){
		$data = array(); 
		$q = $this->db->query("SELECT count(*) as inicio FROM layouts_predial
										where INMUEBLE_ID = '$prediales'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function cargarNumeroDePredios($Inmueble){
		$data = array(); 
		$q = $this->db->query("SELECT predios, inmuebleNombre FROM inmuebles
										where inmuebleIntelisis = '$Inmueble'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function historial($historialID){
		$data = array(); 
		$q = $this->db->query("SELECT * FROM usuarios_accesos
										where '$historialID' = usuarioID");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function trae_plazas(){
		$data = array(); 
		$q = $this->db->query("SELECT i.Nombre as 'Nombre',
									  i.usuario_id as 'usuario_id',
									  u.nombreCompleto as 'nombreCompleto',
									  i.Inmueble as 'Inmueble',
									  u.email as 'email',
									  u.usuarioID as 'usuarioID'
									  FROM borrar_vic_inmueble i
									  LEFT JOIN usuarios u ON u.usuarioID=i.usuario_id");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function trae_inmueble($us){
		$data = array(); 
		$q = $this->db->query("SELECT * FROM borrar_vic_inmueble where '$us' = usuario_id");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function trae_usuarios(){
		$data = array(); 
		$q = $this->db->query("SELECT * FROM usuarios");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function cargaGerentesPlaza(){
		$data = array(); 
		$q = $this->db->query("SELECT 
			u.*, 
			count(c.usuarioId) as total     
		FROM usuarios u
		LEFT JOIN TEMPORA_CI c ON u.usuarioID=c.usuarioId
		WHERE idrole='5'
		GROUP BY u.usuarioID");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	
	function trae_proyectos_porstatus($status){
		$data = array(); 
		$q = $this->db->query("SELECT count(p.idProyecto) as total_proyectos FROM proyectos p WHERE p.statusProyecto='$status'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function tre_totalpagado(){
		$data = array(); 
		$q = $this->db->query("SELECT sum(total) as total FROM
			(SELECT
				(sp.cantidad*c.precio_unitario) as total
				FROM cotizaciones c 
				LEFT JOIN segmentoProyectos sp On sp.idSegmento=c.idsegmento
				LEFT JOIN proyectos p ON p.idProyecto = sp.idProyecto
				LEFT JOIN proyectosAsignados pa On pa.proyectoId=sp.idProyecto
				WHERE pa.proveedorId=c.idproveedor AND p.statusProyecto='Finalizado'
				GROUP BY sp.idSegmento
			) cot");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function trae_totsegmentos(){
		$data = array(); 
		$q = $this->db->query("SELECT 
			count(s.idSegmento) as total_segmentos
			FROM segmentoProyectos s
			LEFT JOIN proyectos p ON p.idProyecto=s.idProyecto
			WHERE s.`status`='activo'
			AND p.statusProyecto='Contratando'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function cargaMensajes($usrId){
		$data = array(); 
		$q = $this->db->query("SELECT
			c.cID,
			cr.fechaRespuesta, cr.respuesta,
			u.nombreCompleto
			FROM conversaciones c 
			LEFT JOIN conversacionesRespuestas cr ON cr.idConversacion=c.cID
			LEFT JOIN usuarios u ON u.usuarioID=cr.usuarioId
			WHERE 
			(c.idUsuarioUno = '$usrId' OR c.idUsuarioDos = '$usrId') AND cr.usuarioId not in ('$usrId')
			ORDER BY cr.fechaRespuesta DESC
			LIMIT 4
		");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function trae_supervisores(){
		
		$data = array(); 
		$q = $this->db->query("SELECT * 
							FROM usuarios
							WHERE idrole = 3 AND status = 'Activado'
							");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
		
	}
	function cuentaProyectosDelMes($fechaDe, $fechaA){
		$data = array();
		$q = $this->db->query("SELECT COUNT(*) as cuenta from proyectos 
												WHERE fechaAltaProyecto > '$fechaDe'
												AND fechaAltaProyecto < '$fechaA'
												");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;

	}
	  
     function cargaProyectos($fechaDe, $fechaA){
     	$data = array(); 
		$q = $this->db->query("SELECT 
			u.usuarioID as 'usuarioID',
			p.tituloProyecto as 'tituloProyecto', 
			count(p.usuarioID) as cuentaTotal     
		FROM proyectos p
		LEFT JOIN usuarios u ON u.usuarioID=p.usuarioID
		WHERE idrole='8'
		OR idrole='1'
		AND p.fechaAltaProyecto > '$fechaDe'
		AND p.fechaAltaProyecto< '$fechaA'
		GROUP BY p.usuarioID
		ORDER BY cuentaTotal desc");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	function cuentaProspectosTipo($usuarioID, $tipo, $fechaDe, $fechaA){
		$data = array(); 
		$q = $this->db->query("SELECT COUNT(*) as cuenta from prospectos 
												WHERE usuarioID='$usuarioID'
												AND origenCliente='$tipo'
												AND fechaCreacion > '$fechaDe'
												AND fechaCreacion < '$fechaA'
												");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
   
	function cuentaProspectosDelMes($fechaDe, $fechaA){
		$data = array(); 
		$q = $this->db->query("SELECT COUNT(*) as cuenta from prospectos 
												WHERE fechaCreacion > '$fechaDe'
												AND fechaCreacion < '$fechaA'
												");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function cargaVendedores($fechaDe, $fechaA){
		$data = array(); 
		$q = $this->db->query("SELECT 
			u.usuarioID as 'usuarioID',
			u.nombreCompleto as 'nombreCompleto', 
			count(p.usuarioID) as cuentaTotal     
		FROM prospectos p
		LEFT JOIN usuarios u ON u.usuarioID=p.usuarioID
		WHERE (idrole='8' 
		OR idrole='1')
		AND p.fechaCreacion > '$fechaDe'
		AND p.fechaCreacion < '$fechaA'
		GROUP BY p.usuarioID
		ORDER BY cuentaTotal desc");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	

	function cuentaCartaIntencionDelMes($fechaDe, $fechaA){
		$data = array();
		$q = $this->db->query("SELECT COUNT(*) as cuenta from tempora_ci
												WHERE fecha >= '$fechaDe'
												AND fecha <= '$fechaA'
												");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;

	}
    
    function cargaCartaIntencion($fechaDe, $fechaA){
     	$data = array(); 
		$q = $this->db->query("SELECT 
			C.gerentePlaza as 'gerentePlaza', 
			c.plaza as 'plaza',
			count(C.plaza) as cuentaTotal     
		FROM tempora_ci C 
		WHERE  C.fecha  >= '$fechaDe'
		AND C.fecha  <= '$fechaA'
		GROUP BY C.plaza
		ORDER BY cuentaTotal desc");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}

	function cuentaCartaIntencion($usuarioID, $fechaDe, $fechaA){
		$data = array(); 
		$q = $this->db->query("SELECT COUNT(*) as cuenta from tempora_ci
												WHERE usuarioID='$usuarioID'
												AND fecha >= '$fechaDe'
												AND fecha <= '$fechaA'
												");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}

   function cuentaCartaIntencionPorMes($fechaDe, $fechaA){
   	    $data = array();
   	    $q = $this->db->query("SELECT COUNT(*) as cuenta from tempora_ci
   	    	                                    WHERE fecha >= '$fechaDe'
   	    	                                    AND fecha  <= '$fechaA'
   	    	           
   	    	                                    ");
   	    if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
   }
   
   function vendedores(){
		$data = array(); 
		$q = $this->db->query("SELECT 
			usuarioID , nombreCompleto, email, status 
		FROM usuarios
		WHERE idrole='8'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function trae_gerentesVentas(){
		$data = array(); 
		$q = $this->db->query("SELECT * FROM usuarios WHERE idrole='9'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
   
   function trae_gerentesPlazas(){
		$data = array(); 
		$q = $this->db->query("SELECT * FROM usuarios WHERE idrole='5'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function prospectosvendedores($usuario){
		$data = array(); 
		$q = $this->db->query("SELECT * 
		FROM prospectos
		WHERE usuarioID='$usuario'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}

}