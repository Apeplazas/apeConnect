<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends MX_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		$this->load->model('proyectos/proyecto_model');
		$this->load->model('cotizaciones/cotizaciones_model');
	}
	
	//verifica que la sesion esta inciada para poder dar acceso a modulo
	function is_logged_in()
    {
        $user = $this->session->userdata('usuario');
        if(!isset($user) || $user != true)
        {
        	$this->session->set_userdata(array('previous_page'=> uri_string()));
         	redirect('');
        }
    }
	
	function perfiles($fancyUrl)
	{
		//Informacion perfil general//
		$user      = $this->session->userdata('usuario');
		$user_type = strtoupper($user['tipoUsuario']);

		if($user_type == 'PROVEEDOR'){
			
			//Carga el javascript y CSS //
			$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');

			$op['profile']			= $info = $this->user_model->traeproveedor($user['usuarioID']);
			$op['recomendados']   	= $this->user_model->cargarProyectosRecomendacion($user['usuarioID']);
	
			$this->layouts->profile('proveedor-view', $op);
			
		}else{
			redirect('admin');
		}
		
	}
	
	function insertarPerfil()
	{
		//Genera informacion perfil//
		$user	=	$this->session->userdata('usuario');
		$op['profile'] = $profile = $this->usuario_model->buscaPerfilID($user['usuarioID']);
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('genero', 'Genero', 'required');
		$this->form_validation->set_rules('alias', 'Alias', 'required');
		$this->form_validation->set_rules('ciudad', 'Ciudad', 'required');
		
		$dia              = $this->input->post('dia');
		$mes              = $this->input->post('mes');
		$anio             = $this->input->post('anio');
		$bio 	          = $this->input->post('bio');
		$genero           = $this->input->post('genero');
		$alias            = $this->input->post('alias');
		$ciudad           = $this->input->post('ciudad');
		$amigos           = $this->input->post('amigos');
		$libreria         = $this->input->post('libreria');
		$actividad        = $this->input->post('actividad');
		$recomendaciones  = $this->input->post('recomendaciones');
		$lanzamientos     = $this->input->post('lanzamientos');
		$seguidores       = $this->input->post('seguidores');
		$noticias         = $this->input->post('noticias');
		
		if ($this->form_validation->run() == FALSE)
		{
			//Carga el javascript y CSS //
			$this->layouts->add_include('assets/js/jquery-ui.js')
					 	  ->add_include('assets/js/jquery.autocomplete.pack.js');
					  
			//Vista//
			$this->layouts->profile('user-view', $op);
		}
		else
		{
		   $config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' 	=> 'assets/graphics/fotosPerfil',
			'max_size' 		=> 5000,
			'encrypt_name' 	=> TRUE,
			'maintain_ration' => TRUE,
		   );
			
	 	   $this->load->library('upload', $config);
		   $this->upload->do_upload();
		   $image_data = $this->upload->data();
		   
		   $this->load->library('image_lib');
		   //[ THUMB IMAGE ]
			$img_config_0['source_image'] = $image_data['full_path'];
			$img_config_0['maintain_ratio'] = TRUE;
			$img_config_0['width'] = 190;
			$img_config_0['height'] = 290;
			$img_config_0['create_thumb'] = TRUE;
			$img_config_0['thumb_marker '] = '_thumb';
			
			//[ MAIN IMAGE ]
			$img_config_1['source_image'] = $image_data['full_path'];
			$img_config_1['maintain_ratio'] = TRUE;
			$img_config_1['width'] = 300;
			$img_config_1['height'] = 300;
			$img_config_1['create_thumb'] = FALSE;
			
			for($i=0;$i<2;$i++){
				eval("\$this->image_lib->initialize(\$img_config_".$i.");");
				$this->image_lib->resize();
			} 
			
			$image = $image_data['raw_name'].'_thumb'.$image_data['file_ext'];
			if($image == '_thumb'){
				$image = $profile[0]->fotografiaPerfil;
			}
			if(empty($bio)){
				$bio = $profile[0]->bio;
			}
			
			$info = array('alias'        		  => $alias,
						  'genero'                => $genero,
						  'ciudad'                => $ciudad,
						  'bio'		              => $bio,
						  'notificacionAmigos'    => $amigos,
						  'suscripcionLibrerias'  => $libreria,
						  'actividadAmigos'       => $actividad,
						  'recomendaciones'       => $recomendaciones,
						  'lanzamientos'          => $lanzamientos,
						  'nuevosSeguidores'      => $seguidores,
						  'noticias'              => $noticias,
						  'fotografiaPerfil'	  => $image,
						  'fechaNacimiento'		  => $anio.'-'.$mes.'-'.$dia,
						  'terminosyCondiciones'  => 'acepto',
						  'registroNuevo'		  => 'no'
						  );
			$this->db->where('usuarioID', $user['usuarioID']);
			$this->db->update('usuarios', $info);
			
			$this->session->set_flashdata('msg','<div class="msg">¡Gracias empieza interactuando!</div>');
			
			redirect($user['fancyUrl']);
		}
	}

	function savedoc(){
		$user			= $this->session->userdata('usuario');
		$proveedor		= $info = $this->user_model->traeproveedor($user['usuarioID']);
		$proveedor_id 	= $proveedor[0]->idProveedor; 
		
		if(isset($_FILES['ced'])){
			// Recibo los datos del track
			$imagenE	= $_FILES['ced']['name'];
			$tipoE 		= $_FILES['ced']['type'];
			$tamanoE	= $_FILES['ced']['size'];
			move_uploaded_file($_FILES['ced']['tmp_name'],DIRCEDULA.$imagenE);
			$data = array(
				'cedulas' => $imagenE
			);
			$this->db->where('idProveedor', $proveedor_id);
            $this->db->update('proveedores', $data);
		}
				
		if(isset($_FILES['shcp'])){
			// Recibo los datos del track
			$imagenF	= $_FILES['shcp']['name'];
			$tipoF 		= $_FILES['shcp']['type'];
			$tamanoF	= $_FILES['shcp']['size'];
			move_uploaded_file($_FILES['shcp']['tmp_name'],DIRSSHCP.$imagenF);
			$data = array(
				'shcp' => $imagenF
			);
			$this->db->where('idProveedor', $proveedor_id);
            $this->db->update('proveedores', $data);
			$afftectedRows = $this->db->affected_rows();
		}
				
		if(isset($_FILES['cuenta'])){
			// Recibo los datos del track
			$imagenG	= $_FILES['cuenta']['name'];
			$tipoG 		= $_FILES['cuenta']['type'];
			$tamanoG	= $_FILES['cuenta']['size'];
			move_uploaded_file($_FILES['cuenta']['tmp_name'],DIREDOCUENTA.$imagenG);
			$data = array(
				'edoCuenta' => $imagenG
			);
			$this->db->where('idProveedor', $proveedor_id);
            $this->db->update('proveedores', $data);
		}

		if(isset($_FILES['domicilio'])){
			// Recibo los datos del track
			$imagenH	= $_FILES['domicilio']['name'];
			$tipoH 		= $_FILES['domicilio']['type'];
			$tamanoH	= $_FILES['domicilio']['size'];
			move_uploaded_file($_FILES['domicilio']['tmp_name'],DIRDOMICILIO.$imagenH);
			$data = array(
				'comprobanteDomicilio' => $imagenH
			);
			$this->db->where('idProveedor', $proveedor_id);
            $this->db->update('proveedores', $data);
		}

		if(isset($_FILES['elec'])){
			// Recibo los datos del track
			$imagenI	= $_FILES['elec']['name'];
			$tipoI 		= $_FILES['elec']['type'];
			$tamanoI	= $_FILES['elec']['size'];
			move_uploaded_file($_FILES['elec']['tmp_name'],DIRCREDEL.$imagenI);
			$data = array(
				'credencialElector' => $imagenI
			);
			$this->db->where('idProveedor', $proveedor_id);
            $this->db->update('proveedores', $data);
		}
				
		if(isset($_FILES['cer'])){
			// Recibo los datos del track
			$imagenC	= $_FILES['cer']['name'];
			$tipoC 		= $_FILES['cer']['type'];
			$tamanoC	= $_FILES['cer']['size'];
			move_uploaded_file($_FILES['cer']['tmp_name'],DIRCERTIFICADO.$imagenC);
			$data = array(
				'certificado' => $imagenC
			);
			$this->db->where('idProveedor', $proveedor_id);
            $this->db->update('proveedores', $data);
		}
					
		if(isset($_FILES['act'])){
			// Recibo los datos del track
			$imagenD	= $_FILES['act']['name'];
			$tipoD 		= $_FILES['act']['type'];
			$tamanoD	= $_FILES['act']['size'];
			move_uploaded_file($_FILES['act']['tmp_name'],DIRACTAS.$imagenD);
			$data = array(
				'actasConstitutivas' => $imagenD
			);
			$this->db->where('idProveedor', $proveedor_id);
            $this->db->update('proveedores', $data);
		}
		
		if(isset($_FILES['imss'])){
			// Recibo los datos del track
			$imagenJ	= $_FILES['imss']['name'];
			$tipoJ 		= $_FILES['imss']['type'];
			$tamanoJ	= $_FILES['imss']['size'];
			move_uploaded_file($_FILES['imss']['tmp_name'],DIRIMSS.$imagenJ);
			$data = array(
				'IMSS' => $imagenJ
			);
			$this->db->where('idProveedor', $proveedor_id);
            $this->db->update('proveedores', $data);
		}
		
		$incompletedata = $this->user_model->checkdocs($proveedor_id);
		if($proveedor[0]->tipoRegistro == 'fisica'){
			unset($incompletedata[0]->certificado);
			unset($incompletedata[0]->actasConstitutivas);
		}elseif($proveedor[0]->tipoRegistro == 'moral'){
			unset($incompletedata[0]->IMSS);
		}	

		$incompletedata = $this->fulldoc($incompletedata[0]);
		if($incompletedata){
			$data = array(
					'documentacionCompleta' => '1'
			);
			$this->db->where('idProveedor', $proveedor_id);
	        $this->db->update('proveedores', $data);
	    }
		redirect('perfiles/'.$user['fancyUrl']);
	}
	
	function salir()
	{
		$this->session->sess_destroy();
		redirect('');
	}
	
	function fulldoc($docs)
	{
		foreach($docs as $d){
			if(empty($d))
				return false;
		}
		return true;
	}
	
	//verifica que la sesion esta inciada para poder dar acceso a modulo
	function v($idproyecto)
    {
    	$op['idproyecto']	= $this->uri->segment(3);
		$op['proyecto']   	= $this->proyecto_model->cargaProyectoID($idproyecto);
		$op['partidas']   	= $this->proyecto_model->traePartidas($idproyecto);
		$op['cometarios']   = $this->proyecto_model->comentariosProy($idproyecto);
		$op['archivos']     = $this->proyecto_model->cargaArchivosProyecto($idproyecto);
		//$op['segmento']   = $this->proyecto_model->buscaSegmento($idproyecto);
		$this->layouts->profile('preview-proyectos', $op);
    }
	
	function c($idproyecto)
    {
    	$user			= $this->session->userdata('usuario');
    	$hacotizado = $this->user_model->hacotizado($idproyecto,$user['usuarioID']);
		if(!empty($hacotizado)){
			$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Usted ya cotizó para este proyecto.</strong></div><br class="clear">');
			redirect('');
		}else{
	    	$op['idproyecto']  = $idproyecto;
	    	$op['proyecto']   = $this->proyecto_model->traeproyecto($idproyecto);
			$op['partidas']   		= $this->proyecto_model->traePartidas($idproyecto);
			//$op['psecciones']     = $this->proyecto_model->traeproyecto_secciones($idproyecto);
			$this->layouts->profile('cotiza-view', $op);
		}
    }

	function cotizar(){
		$user		=	$this->session->userdata('usuario');
		$idproveedor = $this->user_model->traeproveedor($user['usuarioID']);
		$idproyecto = $this->input->post('idproyecto');
		$punitario 	= $this->input->post('punitario');
		$observaciones = $this->input->post('observaciones');

		$partidas = $this->proyecto_model->traePartidas($idproyecto);
		$isvalid = true;
		$filldata = array();
		$insertdata = array();
		$error= array();
		$matrizDesg = null;
		
		if(isset($_FILES['matrizCot']['name']) && !empty($_FILES['matrizCot']['name'])){

			$permitidos =  array('gif','png','jpg','pdf');
						
			$archivoNombre	= $_FILES['matrizCot']['name'];
			$archivoTipo	= $_FILES['matrizCot']['type'];
			$archivoTama	= $_FILES['matrizCot']['size'];
			
			$ext = pathinfo($archivoNombre, PATHINFO_EXTENSION);			

			if(in_array($ext,$permitidos) ) {
				
    			move_uploaded_file($_FILES['matrizCot']['tmp_name'],DIRCOTIZ.$archivoNombre);
    			$matrizDesg	= $archivoNombre;
				
			}else{
				
				$isvalid = false;
				$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Este archivo no esta permitido.</strong></div><br class="clear">');
				
			}

		}
		
		foreach($partidas as $partida){
			$segmentos = $this->proyecto_model->traeproyecto_secciones($idproyecto,$partida->id);
			foreach($segmentos as $segmento){
				if(!empty($punitario[$segmento->idSegmento])){
					$tempunitario = $punitario[$segmento->idSegmento];
					$insertdata['cotizacion'][] = array(
						'idproyecto'		=> $idproyecto,
						'idproveedor' 		=> $idproveedor[0]->idProveedor,
						'idsegmento'		=> $segmento->idSegmento,
						'precio_unitario'	=> $punitario[$segmento->idSegmento],
						'matrizDesglose'	=> $matrizDesg
					);
					$filldata['punitario'][$segmento->idSegmento] = $punitario[$segmento->idSegmento];
				}else{
					$isvalid = false;
					$error[$segmento->idSegmento] = true;
				}
				if(!empty($observaciones[$segmento->idSegmento])){
					$insertdata['observaciones'][] = array(
						'idsegmento'		=> $segmento->idSegmento,
						'idusuario'			=> $user['usuarioID'],
						'observacion'	=> $observaciones[$segmento->idSegmento]
					);
					$filldata['observaciones'][$segmento->idSegmento] = $observaciones[$segmento->idSegmento];
				}
			}
		}

		if(!$isvalid){
			
			$op['idproyecto'] = $idproyecto;
    		$op['proyecto'] = $this->proyecto_model->traeproyecto($idproyecto);
			$op['partidas']   		= $this->proyecto_model->traePartidas($idproyecto);
			//$op['psecciones'] = $segmentos;
			$op['filldata'] = $filldata;
			$op['error'] = $error;
			
			$this->layouts->profile('cotiza-view', $op);
			
		}else{
			
			$this->db->insert_batch('cotizaciones', $insertdata['cotizacion']);
			$convID = $this->db->insert_id();
			
			$menUsuarios = "Se ha hecho una nueva cotiación.";
			
			//Generar notificacion general
			$proyecto_url = base_url()."cotizaciones/ver/".$convID;
			$notificacion = array(
				'tipo_menssajeid' 	=> 4, //Cotizaciones
				'roleid'			=> 1, //Administradores
				'mensaje'			=> $menUsuarios,
				"url"				=> $proyecto_url 
			);
			$this->db->insert('mensajes_roles', $notificacion);
			$mroleid = $this->db->insert_id();
			
			$administradores = $this->user_model->traeadministradores();
			$not_rol_user = array();
			foreach($administradores as $admin){
				$not_rol_user[] = array(
					'mensajerole_id' 	=> $mroleid,
					'usuarioid'			=> $admin->usuarioID
				);
			}
			$this->db->insert_batch('mensajes_usuarios_roles', $not_rol_user);
			
			if(!empty($insertdata['observaciones'])){
				$this->db->insert_batch('observaciones', $insertdata['observaciones']);
			}
			$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Gracias por tu cotización, en caso de que tu cotización sea elegida se te notificará vía email.</strong></div><br class="clear">');
			redirect('');
			
		}
	}

	function verCotizacion($cotId){
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');
		$op['cotizacion'] = $this->cotizaciones_model->traecotizacion($cotId);
		$this->layouts->profile('cotizacion-detalle-view', $op);
	}
	
	function cometarProyecto(){
		
		//Datos del comentario
		$proyectoId			= $this->input->post('proyectoId');
		$comentario 		= $this->input->post('comentario');
		$tieneComentarios 	= $this->input->post('tieneComentarios');
		
		//Datos de usuario
		$user			= $this->session->userdata('usuario');
		$usuarioId		= $user['usuarioID'];		
		$converIniciada = $this->proyecto_model->converIniciada($proyectoId,$usuarioId);
		
		$usuarioIdCreador = $this->proyecto_model->traeProyectoCreador($proyectoId);
		
		// Si ya se ha cometado solo insertamos el cometario
		if(!empty($converIniciada)){
			
			$data = array(
				'respuesta'			=> $comentario,
				'idConversacion'	=> $converIniciada[0]->cID,
				'usuarioId'			=> $usuarioId   
			);
			$this->db->insert('conversacionesRespuestas', $data);
			
		//Si no se ha cometado insertamos una conversacion	
		}else{
			
			$dataConv = array(
				'idUsuarioUno'			=> $usuarioId,
				'idUsuarioDos'			=> $usuarioIdCreador[0]->usuarioID,
				'idConversacionTipo'	=> 4,
				'idProyecto'			=> $proyectoId   
			);
			$this->db->insert('conversaciones', $dataConv);
			$convId = $this->db->insert_id();
			
			$dataResp = array(
				'respuesta'			=> $comentario,
				'idConversacion'	=> $convId,
				'usuarioId'			=> $usuarioId   
			);
			$this->db->insert('conversacionesRespuestas', $dataResp);
			
		}
		
		$mensje = "El proveedor ".$user['nombre']." ha hecho un cometario";
		
		//Insertar notificacion
		$not_user = array(
				'tipo_mensajeid' 	=> 1,
				'usuarioid' 		=> $usuarioIdCreador[0]->usuarioID,
				'proyectoID'		=> $proyectoId,
				'mensaje'			=> $mensje,
				'usuarioEnviaID'	=> $user['usuarioID'],
				'url'				=> base_url()."proyectos/verProyecto/".$proyectoId."#comentariosProyecto"
		);
		$this->db->insert('mensajes_usuarios', $not_user);
		
		redirect('usuarios/v/'.$proyectoId);
		
	}
	
}