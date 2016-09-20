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
		
		$op['proyecto']   		= $this->proyecto_model->cargaProyectoID($proyecto);
		$op['archivos']     	= $this->proyecto_model->cargaArchivosProyecto($proyecto);
		$op['tienecot']			= $this->proyecto_model->tiene_cotizacion($proyecto);
		$op['comentarios']  	= $this->proyecto_model->cargaComentarios($proyecto);
		$op['seHaCancelado'] 	= $this->proyecto_model->seHaCancelado($proyecto);

		if(!$op['tienecot'][0]){		
			//$this->layouts->add_include('assets/js/jquery.editinplace.js');
		}
		
		$op['partidas']		= $this->proyecto_model->traePartidas($proyecto);
		//$op['segmento']   = $this->proyecto_model->buscaSegmento($proyecto);
		$op['conceptos']  	= $this->data_model->cargaUnidades();
		$op['userID']   	= $user['usuarioID'];
		
		//Limpiar notificaciones directas al usuario
		$marcarLeido = array(
			'leido' => 1
		);
		$actualizarEn = array(
			'usuarioid' 	=> $user['usuarioID'],
			'proyectoID'	=> $proyecto 
		);

		$this->db->where($actualizarEn);
        $this->db->update('mensajes_usuarios', $marcarLeido);
		
		$this->db->where($actualizarEn);
        $this->db->update('mensajes_usuarios_roles', $marcarLeido);
		
		$this->layouts->profile('proyecto-view-admin', $op);
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
	
	function cambiarStatusProyecto($tipo, $proyecto)
	{
		
		$tipo   			= 'Contratando';
		$proyecto			= $this->uri->segment(4);
		$proyectoDetalle 	= $this->proyecto_model->traeproyecto($proyecto);
		$proyectoTitulo 	= $proyectoDetalle[0]->tituloProyecto;
		
		$data = array(
        	'statusProyecto' => $tipo
        );
		
		if($tipo == 'Autorizado'){
			
			$data['fechaAutorizacion'] = date("Y-m-d");
			
		}

		$this->db->where('idProyecto', $proyecto);
		$this->db->update('proyectos', $data); 
		
		//Notificacion
		$proy_user_id = $this->proyecto_model->traecreador($proyecto);
		$mensje = "EL proyecto '$proyectoTitulo' se le ha puesto el estado de $tipo";
		$not_user = array(
				'tipo_mensajeid' 	=> 1,
				'usuarioid' 		=> $proy_user_id,
				'mensaje'			=> $mensje,
				'url'				=> base_url()."proyectos/verProyecto/".$proyecto."/1"
			);		
		$this->db->insert('mensajes_usuarios', $not_user);
		
		$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Se ha autorizado el proyecto exitosamente.</strong></div><br class="clear">');
		
		redirect("proyectos/obras");
	}
	
	function noAutorizar(){
		
		$proyid			= $this->input->post('proyectoId');
		$razon			= $this->input->post('razon');
		$usrId			= $this->input->post('usuarioId');
		
		$proyDet		= $this->proyecto_model->traeproyecto($proyid);
		$seHaCancelado 	= $this->proyecto_model->seHaCancelado($proyid);
		
		$user       = $this->session->userdata('usuario');
		
		$data = array(
               'statusProyecto' => 'No Autorizado'
            );

		$this->db->where('idProyecto', $proyid);
		$this->db->update('proyectos', $data); 
		
		$usuarioDestinoDatos = $this->user_model->traeadmin($usrId);

		if(empty($seHaCancelado)){
		
			$convData = array(
				'idUsuarioUno'			=> $user['usuarioID'],
				'idUsuarioDos'			=> $usrId,
				'idConversacionTipo' 	=> 3,
				'idProyecto'    		=> $proyid
			);
			
			$this->db->insert('conversaciones', $convData);
			$convID = $this->db->insert_id();
			
			//insertar mensaje
			$mensajeData = array(
				'respuesta' 		=> $razon,
				'usuarioID'			=> $user['usuarioID'],
				'idConversacion'    => $convID
			);
			
			$this->db->insert('conversacionesRespuestas', $mensajeData);
		
		}else{
				
			$op = array(
				'respuesta'           	=> $razon,
				'idConversacion'      	=> $seHaCancelado[0]->cID,
				'usuarioId'				=> $user['usuarioID']
			);
			$this->db->insert('conversacionesRespuestas', $op);		
			
		}
 	
		$this->load->library('email');
		$this->email->set_newline("\r\n");
		$this->email->from('contacto@apeplazas.com', 'APE Plazas Especializadas');
		$this->email->to($usuarioDestinoDatos[0]->email);
		$this->email->subject('Proyecto no autorizado');		
		$this->email->message('
			<html>
				<head>
					<title>Obras</title>
				</head>
				<body>
					<p>' . $razon . '</p>
				</body>
			</html>
				');
		$this->email->send();
		
		$titProyecto = $proyDet[0]->tituloProyecto;
		$mensje = "El Proyecto '$titProyecto' no fue autorizado";
		
		//Insertar notificacion
		$not_user = array(
				'tipo_mensajeid' 	=> 3,
				'usuarioid' 		=> $usrId,
				'proyectoID'		=> $proyid,
				'mensaje'			=> $mensje,
				'usuarioEnviaID'	=> $user['usuarioID'],
				'url'				=> base_url()."proyectos/verProyecto/".$proyid."/1"
			);		
		$this->db->insert('mensajes_usuarios', $not_user);
		
		$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Se ha notificado al usuario exitosamente.</strong></div><br class="clear">');
		
		redirect("proyectos/obras");
		
	}
		
}