<?php

class Proyectos extends Main_proyectos
{
	
	public function __construct()
	{
		parent::__construct();
	}

	function verProyecto($proyecto)
	{
			//Informacion perfil general//
		$user      = $this->session->userdata('usuario');
		$user_type = strtoupper($user['tipoUsuario']);
		
		$proyecto = $this->uri->segment(3);
		
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/jquery-datepicker.css')
					  ->add_include('assets/js/jquery-datepicker.js');
		
		$op['proyecto']       = $this->proyecto_model->cargaProyectoID($proyecto);
		$op['archivos']       = $this->proyecto_model->cargaArchivosProyecto($proyecto);
		$op['tienecot']       = $this->proyecto_model->tiene_cotizacion($proyecto);
		$op['comentarios']    = $this->proyecto_model->cargaComentarios($proyecto);
		$op['seHaCancelado']  = $this->proyecto_model->seHaCancelado($proyecto);
		$op['cometarios']	  = $this->proyecto_model->comentariosProy($proyecto);

		if(!$op['tienecot'][0]){		
			$this->layouts->add_include('assets/js/jquery.editinplace.js');
		}
		
		$op['partidas']   		= $this->proyecto_model->traePartidas($proyecto);
		$op['nombrePartidas']   = $this->proyecto_model->traeNombrePartidas($proyecto);
		//$op['segmento']   = $this->proyecto_model->buscaSegmento($proyecto);
		$op['conceptos']  = $this->data_model->cargaUnidades();
		$op['userID']   = $user['usuarioID'];
		
		//Limpiar notificaciones
		$marcarLeido = array(
			'leido' => 1
		);
		$actualizarEn = array(
			'usuarioid' 	=> $user['usuarioID'],
			'proyectoID'	=> $proyecto 
		);
		
		$this->db->where($actualizarEn);
        $this->db->update('mensajes_usuarios', $marcarLeido);
		
		$this->layouts->profile('proyecto-view-supervisor', $op);
	}
	
	function responder(){
		$proyid		= $this->input->post('proyectoid');
		$respuesta 	= $this->input->post('respuesta');
		$obserid 	= $this->input->post('obserid');
		
		$user       = $this->session->userdata('usuario');
		
		//Insertart respuesta
		$respuesta_data = array(
			'respuesta'		=> $respuesta,
			'userid'		=> $user['usuarioID']  
		);
		
		//Insertar resspuesta
		$this->db->insert('respuestas', $respuesta_data);
		$respuesta_id = $this->db->insert_id();
		
		$obser_data = array(
			'respuesta'	=> $respuesta_id 
		);
		
		//Inserta repuestaa en observaciones
		$this->db->where('id', $obserid);
        $this->db->update('observaciones', $obser_data);
		
		redirect('proyectos/verComentarios/'.$proyid);
	}
	
	function secAdmStatus($idSeccion, $proyecto)
	{
		$seccion      = $this->uri->segment(3);
		$proyecto   = $this->uri->segment(4);
		
		$data = array(
               'status' => 'borrado'
            );

		$this->db->where('idSegmento', $seccion);
		$this->db->update('segmentoProyectos', $data); 
		
		redirect("proyectos/verProyecto/$proyecto"."#segmentos");
	}

	function borrarStatusProy($proyecto)
	{
		$proyecto   = $this->uri->segment(3);
		
		$data = array(
               'statusProyecto' => 'Borrado'
            );

		$this->db->where('idProyecto', $proyecto);
		$this->db->update('proyectos', $data); 
		
		redirect("proyectos/obras");
	}
	
	function notificacion_proyecto($proyectoID){
		
		$user       = $this->session->userdata('usuario');
		
		//Poner Proyecto en proceso de espera para autorizacion
		$this->db->where('idProyecto', $proyectoID);
        $this->db->update('proyectos', array('statusProyecto'=>'En Revision','fechaUltimaRevision'=>date("Y-m-d")));
		
		$menUsuarios = "El usuario ".$user['nombre']." ha solicitado una autorizacion para su proyecto";
		$seHaCancelado = $this->proyecto_model->seHaCancelado($proyectoID);
		if(!empty($seHaCancelado))
			$menUsuarios = "El usuario ".$user['nombre']." ha solicitado una nueva revisión para su proyecto";
		
		//Generar notificacion general
		$proyecto_url = base_url()."proyectos/verProyecto/".$proyectoID;
		$notificacion = array(
			'tipo_menssajeid' 	=> 1, //Proyectos
			'roleid'			=> 1, //Administradores
			'mensaje'			=> $menUsuarios,
			"url"				=> $proyecto_url 
		);
		$this->db->insert('mensajes_roles', $notificacion);
		$mroleid = $this->db->insert_id();
		
		$revionDatos = array(
			'proyectoId'	=> $proyectoID
		);
		$this->db->insert('revisionesProyectos', $revionDatos);
		
		$administradores = $this->user_model->traeadministradores();
		$not_rol_user = array();
		
		$mensajeAdministradores = "<html>
				<head>
					<title>Nuevo Proyecto</title>
				</head>
				<body>
					<p>Hay un nuevo proyecto en espera de aprovación. Para ver los detalles haga <a href='" . $proyecto_url . "'>click aquí</a> </p>
				</body>
			</html>";
			
		$this->load->library('email');
		
		foreach($administradores as $admin){
			//Notificar Administradores por medio del sistema
			$not_rol_user[] = array(
				'mensajerole_id' 	=> $mroleid,
				'usuarioid'			=> $admin->usuarioID,
				'proyectoID'		=> $proyectoID
			);
			
			//Notificar Administradores por medio del email
			$this->email->set_newline("\r\n");
			$this->email->from('contacto@apeplazas.com', 'APE Plazas Especializadas');
			$this->email->to($admin->email);
			$this->email->subject("Han dado de alta un nuevo proyecto");		
			$this->email->message($mensajeAdministradores);
			$this->email->send();
			
		}
		$this->db->insert_batch('mensajes_usuarios_roles', $not_rol_user);
		
		//abre session para mensaje de flashdata//
		$this->load->library('session');
		$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Se solicito la autorización exitosamente.</strong></div><br class="clear">');
				
		redirect("proyectos/obras");
			
	}

	function borrarPartida($partidaId,$proyectoId){
		
		$wherePart = array(
			'partidaId'		=> $partidaId,
			'proyectoId'	=> $proyectoId
		);
		
		$data = array(
			'status' => 'borrado'
        );

		$this->db->where($wherePart);
		$this->db->update('ProyectosPartidas', $data); 
		
		$whereSec = array(
			'idProyecto'	=> $proyectoId,
			'idPartida'		=> $partidaId
		);

		$this->db->where($whereSec);
		$this->db->update('segmentoProyectos', $data);
		
		redirect("proyectos/verProyecto/$proyectoId"."#segmentos");		
		
	}


	function agrgarArchivo(){
		
		$proyectoId = $this->input->post('proyecto');
		
		if(isset($_FILES['archivoProyecto']) && !empty($_FILES['archivoProyecto'])){
			
			$permitidos =  array('gif','png','jpg','pdf','dwg');
						
			$archivoNombre	= $_FILES['archivoProyecto']['name'];
			$archivoTipo	= $_FILES['archivoProyecto']['type'];
			$tamanoH		= $_FILES['archivoProyecto']['size'];
			
			$ext = pathinfo($archivoNombre, PATHINFO_EXTENSION);			

			if(in_array($ext,$permitidos) ) {
				
    			move_uploaded_file($_FILES['archivoProyecto']['tmp_name'],DIRPROYECTOS.$archivoNombre);
    			$data = array(			
					'idProyecto'	=> $proyectoId,
					'nombreArchivo'	=> $archivoNombre,
					'archivoTipo'	=> $ext  
				);
				
				$this->db->insert('archivosProyectos', $data);
				
			}else{
				
				$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Este archivo no esta permitido.</strong></div><br class="clear">');
				
			}
			
		}
		
		redirect("proyectos/verProyecto/$proyectoId"."#segmentos");
		
	}
		
}