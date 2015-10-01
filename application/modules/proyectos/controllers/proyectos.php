<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$controler_instance = new MX_Controller();

$user = $controler_instance->session->userdata('usuario'); 

class Main_proyectos extends MX_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->user_model->checkuser();
		$this->load->model('proyecto_model');
		$this->load->model('admin/admin_model');
	}
	
	function obras()
	{
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/jquery-datepicker.css')
					  ->add_include('assets/js/jquery-datepicker.js');
					  
		//Informacion perfil general//
		$user      = $this->session->userdata('usuario');
		$user_type = strtoupper($user['tipoUsuario']);
		
		$op['tipos'] 	= $this->data_model->cargarTipoCompania();
		$op['rango'] 	= $this->data_model->costoRango();
		$op['zonas'] 	= $this->data_model->cargaZonas();
		$op['userID']   = $user['usuarioID'];
		$op['profile']		= $info = $this->user_model->traeadmin($user['usuarioID']);
		
		//Traer vista correspondiente al ussuaario
		$modulo = $this->uri->segment(1);
		$user_view = $this->user_model->traevista($user['usuarioID'],$modulo);
		
		$this->layouts->profile($user_view, $op);
	}
	
	function agregarPartida(){
		
		$proyecto	= $this->input->post('proyecto');
		$partidaId  = $this->input->post('partidaID');
		
		$op = array(
			'proyectoId'   	=> $proyecto,
			'partidaId'  	=> $partidaId
			);
		$this->db->insert('ProyectosPartidas', $op);
		
		redirect("proyectos/verProyecto/$proyecto");
			
	}
	
	function agregarSeccion(){
		
		$proyecto	= $this->input->post('proyecto');
		$partidaId	= $this->input->post('partidaId');
		//Genera Array y Inserta en la BD 
		
		$seccionDesc  	= $this->input->post('seccionDesc');
		$unidad  		= $this->input->post('unidad');
		$cantidad 		= $this->input->post('cantidad');
		$ubiProy  		= $this->input->post('ubiProy');
		$cierre   		= $this->input->post('fechaCierre');

		$partidaDatos 	= $this->proyecto_model->cargaPartida($partidaId);
		$zonaDatos		= $this->proyecto_model->cargaZonaPorProyecto($proyecto);
		$numeroPartida	= $this->proyecto_model->cargaNumeroPartida($proyecto,$partidaId)+1;
		$clave 			= $zonaDatos[0]->zonaCodigo . '-' . $partidaDatos[0]->clave . '-' . str_pad($numeroPartida, 3, '0', STR_PAD_LEFT);

		$op = array(
			'seccionDesc'  	=> $seccionDesc,
			'unidadID'   	=> $unidad, 
			'idProyecto'   	=> $proyecto, 
			'idPartida'		=> $partidaId,
			'claveSegmento'	=> $clave,
			'cantidad'  	=> $cantidad,
			'horaAlta'   	=> date("H:m:s"),
			'fechaAlta'  	=> date("Y-m-d"),  
			);
		$this->db->insert('segmentoProyectos', $op);
		
		redirect("proyectos/verProyecto/$proyecto#segmentos");
		
	}
	
	function agregarProyecto(){
			
		$user     = $this->session->userdata('usuario');
		
		
		$titProy  = $this->input->post('titProy');
		$tipProy  = $this->input->post('tipProy');
		$costProy = $this->input->post('costProy');
		$ubiProy  = $this->input->post('ubiProy');
		$cierre   = $this->input->post('fechaCierre');
		$fecha    = date('Y-m-d');
		$proyDesc = $this->input->post('proyDesc');
		
		
		//Genera Array y Inserta en la BD 
		$op = array(
			'costoRangoID'           => $costProy,
			'obrasTipoid'            => $tipProy, 
			'zonasID'                => $ubiProy,
			'fechaCierreProyecto'    => $cierre,
			'horaAlta'               => date("H:m:s"),
			'fechaAltaProyecto'      => date("Y-m-d"),  
			'tituloProyecto'         => $titProy,
			'descripcionProyecto'	 => $proyDesc,
			'usuarioID'				 => $user['usuarioID'],
			);
		$this->db->insert('proyectos', $op);
		$proyectoID = $this->db->insert_id();
		
		$concepto = $this->data_model->verificaConceptos($titProy);
		
		if(empty($concepto)){
			//Genera Array y Inserta en la BD 
			$op = array(  
				'concepto'         => $titProy,
				);
			$this->db->insert('diccionarioConceptos', $op);
		}
		
		redirect("proyectos/verProyecto/$proyectoID");

	}

		
	function verComentarios($idproyecto){
		
		$op['proyecto']   = $this->proyecto_model->cargaProyectoID($idproyecto);
		$op['comentarios']   = $this->proyecto_model->traecomentarios($idproyecto);
		$op['conceptos']  = $this->data_model->cargaUnidades();
		
		$this->layouts->profile('comentarios-view', $op);
		
	}
	
	function agregarComentario(){
		
		//Informacion perfil general//
		$user                 = $this->session->userdata('usuario');
		$usuarioID            = $user['usuarioID'];
		$nombreUsuarioEnvia   = $user['nombre'];
		$respuesta            = $this->input->post('respuesta');
		$proyectoID           = $this->input->post('proyectoID');
		$tipoID               = $this->input->post('tipoID');
		$usuarioComentario    = $this->input->post('usuarioComentario');
		$comentarioID         = $this->input->post('comentarioID');
		$converDetalle 		  = $this->proyecto_model->traeConverssacion($comentarioID);
		
		$usuarioIdReceptor 	  = ($converDetalle[0]->idUsuarioUno == $usuarioID) ? $converDetalle[0]->idUsuarioDos : $converDetalle[0]->idUsuarioUno;
		
		//if ($tipoID == '3'){
			$mensaje = 'Comentario sobre Autorización de proyecto '.$proyectoID.' de '.$nombreUsuarioEnvia.'';
			$url ='http://www.apeplazas.com/obras/proyectos/verProyecto/'.$proyectoID.'/1';
		//}
		
		//Genera Array y Inserta en la BD de asunto
		$op = array(
			'respuesta'           	=> $respuesta,
			'idConversacion'      	=> $comentarioID,
			'usuarioId'				=> $usuarioID,
			);
		$this->db->insert('conversacionesRespuestas', $op);
		
		//Genera Array e Inserta para notificar el mensaje 
		$mensajeNotifica = "El usuario " . $user['nombre'] . " te ha mandado un mensaje.";
		$not_user = array(
			'tipo_mensajeid' 	=> $tipoID,
			'usuarioid' 		=> $usuarioIdReceptor,
			'proyectoID'		=> $proyectoID,
			'mensaje'			=> $mensajeNotifica,
			'usuarioEnviaID'	=> $usuarioID,
			'url'				=> $url
		);		
		$this->db->insert('mensajes_usuarios', $not_user);
		
		redirect("proyectos/verProyecto/$proyectoID/1");
		
	}

	function exportarExcel(){
	
		$header = array(
			'Titulo','Descripcion','Id','Tipo','Estado'
		);
		$obras = $this->proyecto_model->buscaProyectos();
	
		$this->data_model->genera_excel($header,$obras);
		
	}

	function contestarProyecto(){
		
		//Datos del comentario
		$proyectoId			= $this->input->post('proyectoId');
		$comentario 		= $this->input->post('comentario');
		$conversacionId 	= $this->input->post('conversacionId');
		$proveedorId 		= $this->input->post('proveedorId');

		//Datos de usuario
		$user			= $this->session->userdata('usuario');
		$usuarioId		= $user['usuarioID'];
			
		$dataResp = array(
			'respuesta'			=> $comentario,
			'idConversacion'	=> $conversacionId,
			'usuarioId'			=> $usuarioId   
		);
		$this->db->insert('conversacionesRespuestas', $dataResp);
		
		
		$mensje = "Tu comentario ha sido respondido";
		
		//Insertar notificacion
		$not_user = array(
				'tipo_mensajeid' 	=> 1,
				'usuarioid' 		=> $proveedorId,
				'proyectoID'		=> $proyectoId,
				'mensaje'			=> $mensje,
				'usuarioEnviaID'	=> $user['usuarioID'],
				'url'				=> base_url()."usuarios/v/".$proyectoId."#comentariosProyecto"
		);
		$this->db->insert('mensajes_usuarios', $not_user);
		
		redirect('proyectos/verProyecto/'.$proyectoId);
		
	}
	
}

if(!@include_once($user['tipoUsuario'].".php")){
	
	class Proyectos extends Main_proyectos{
		
		public function __construct(){
			
			parent::__construct();
			
		}
		
		function verProyecto($proyecto){
			
			

		}
			
	}	
	
}
