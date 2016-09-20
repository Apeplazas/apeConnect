<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registrate extends MX_Controller {

	function registrate()
	{
		parent::__construct();
		$this->load->model('registrate_model');
	}

	function index()
	{
		//Genera metatags
        $url = $this->uri->segment(1);
        $op['tags'] = $this->data_model->cargarOptimizacion($url);

        //Carga estados de Mexico
        $op['estados']	= $this->registrate_model->estados();
        $op['tipos'] 	= $this->data_model->cargarTipoCompania();

		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/css/jquery.fileupload.css');

		//Vista//
		$this->layouts->index('registrate-view', $op);
	}

	function formFisica()
	{
		$this->load->view('formFisica');
	}

	function formMoral()
	{
		$this->load->view('formMoral');
	}

	function guardarRegistro()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('gComp', 'Giros de la Compañia', 'required');
		$this->form_validation->set_rules('rfc', 'RFC', 'required');
		$this->form_validation->set_rules('repLegal', 'Representante Legal', 'required');
		$this->form_validation->set_rules('rTipo', 'Tipo de Registro', 'required');
		$this->form_validation->set_rules('estComp', 'Colonia', 'required');
		$this->form_validation->set_rules('cpComp', 'Codigo Postal', 'required');
		$this->form_validation->set_rules('dirComp', 'Dirección', 'required');
		$this->form_validation->set_rules('admName', 'Nombre', 'required');
		$this->form_validation->set_rules('admTel', 'Nombre Administrador', 'required');
		$this->form_validation->set_rules('admNic', 'Usuario o Marca', 'required');
		$this->form_validation->set_rules('password', 'Contraseña', 'required');
		$this->form_validation->set_rules('admEma', 'Email', 'required');
		$this->form_validation->set_rules('estado', 'Estados', 'required');


		$gComp        = $this->input->post('gComp');
		$rfc          = $this->input->post('rfc');
		$repLegal     = $this->input->post('repLegal');
		$rTipo        = $this->input->post('rTipo');
		$estComp      = $this->input->post('estComp');
		$delComp      = $this->input->post('delComp');
		$colComp      = $this->input->post('colComp');
		$cpComp       = $this->input->post('cpComp');
		$dirComp      = $this->input->post('dirComp');
		$admName      = $this->input->post('admName');
		$admTel       = $this->input->post('admTel');
		$admCel       = $this->input->post('admCel');
		$admNic       = $this->input->post('admNic');
		$fancy        = strtolower(str_replace(" ", "_", $admNic));
		$fancyUrl     = trim($fancy);
		$admEma       = $this->input->post('admEma');
		$password     = $this->input->post('password');
		$fecha        = date('Y-m-d');
		$user_estados = $this->input->post('estado');

		if ($this->form_validation->run() == FALSE)
		{
        	//Genera metatags
        	$url = $this->uri->segment(1);
        	$op['tags'] = $this->data_model->cargarOptimizacion($url);

        	//Carga estados de Mexico
        	$op['estados']	= $this->registrate_model->estados();
        	$op['tipos'] 	= $this->data_model->cargarTipoCompania();
			//Vista//
			$this->layouts->index('registrate-view', $op);
		}
		else
		{
			$mail 		= $this->registrate_model->confirmaEmail($admName);
			$vanityUrl 	= $this->registrate_model->confirmaUrl($fancyUrl);

			if ($mail && $vanityUrl){
				$this->session->set_flashdata('mail','<div class="msg">Su email o Usuario ya han sido escogidos, por favor intente nuevamente.</div>');
				redirect('registrate');
			}
			elseif ($vanityUrl){
				$this->session->set_flashdata('vanityUrl','<div class="msg">No esta disponible este Usuario , por favor intente nuevamente.</div>');
				redirect('registrate');
			}
			elseif ($mail){
				$this->session->set_flashdata('mail','<div class="msg">Este email ya se encuentra registrado, por favor intente nuevamente.</div>');
				redirect('registrate');
			}

			elseif (!$mail && !$vanityUrl) {
				if(isset($_FILES['ced'])){
					// Recibo los datos del track
					$imagenE	= $_FILES['ced']['name'];
					$tipoE 		= $_FILES['ced']['type'];
					$tamanoE	= $_FILES['ced']['size'];
					move_uploaded_file($_FILES['ced']['tmp_name'],DIRCEDULA.$imagenE);
				}else{
					$imagenE	= null;
				}

				if(isset($_FILES['shcp'])){
					// Recibo los datos del track
					$imagenF	= $_FILES['shcp']['name'];
					$tipoF 		= $_FILES['shcp']['type'];
					$tamanoF	= $_FILES['shcp']['size'];
					move_uploaded_file($_FILES['shcp']['tmp_name'],DIRSSHCP.$imagenF);
				}else{
					$imagenF	= null;
				}

				if(isset($_FILES['cuenta'])){
					// Recibo los datos del track
					$imagenG	= $_FILES['cuenta']['name'];
					$tipoG 		= $_FILES['cuenta']['type'];
					$tamanoG	= $_FILES['cuenta']['size'];
					move_uploaded_file($_FILES['cuenta']['tmp_name'],DIREDOCUENTA.$imagenG);
				}else{
					$imagenG	= null;
				}

				if(isset($_FILES['domicilio'])){
					// Recibo los datos del track
					$imagenH	= $_FILES['domicilio']['name'];
					$tipoH 		= $_FILES['domicilio']['type'];
					$tamanoH	= $_FILES['domicilio']['size'];
					move_uploaded_file($_FILES['domicilio']['tmp_name'],DIRDOMICILIO.$imagenH);
				}else{
					$imagenH	= null;
				}

				if(isset($_FILES['elec'])){
					// Recibo los datos del track
					$imagenI	= $_FILES['elec']['name'];
					$tipoI 		= $_FILES['elec']['type'];
					$tamanoI	= $_FILES['elec']['size'];
					move_uploaded_file($_FILES['elec']['tmp_name'],DIRCREDEL.$imagenI);
				}else{
					$imagenI	= null;
				}

				if(strtoupper($rTipo) == 'MORAL'){
					if(isset($_FILES['cer'])){
						// Recibo los datos del track
						$imagenC	= $_FILES['cer']['name'];
						$tipoC 		= $_FILES['cer']['type'];
						$tamanoC	= $_FILES['cer']['size'];
						move_uploaded_file($_FILES['cer']['tmp_name'],DIRCERTIFICADO.$imagenC);
					}else{
						$imagenC	= null;
					}

					if(isset($_FILES['act'])){
						// Recibo los datos del track
						$imagenD	= $_FILES['act']['name'];
						$tipoD 		= $_FILES['act']['type'];
						$tamanoD	= $_FILES['act']['size'];
						move_uploaded_file($_FILES['act']['tmp_name'],DIRACTAS.$imagenD);
					}else{
						$imagenD	= null;
					}
				}else{
					$imagenC	= null;
					$imagenD	= null;
				}

				if(strtoupper($rTipo) == 'FISICA'){
					if(isset($_FILES['imss'])){
						// Recibo los datos del track
						$imagenJ	= $_FILES['imss']['name'];
						$tipoJ 		= $_FILES['imss']['type'];
						$tamanoJ	= $_FILES['imss']['size'];
						move_uploaded_file($_FILES['imss']['tmp_name'],DIRIMSS.$imagenJ);
					}else{
						$imagenJ	= null;
					}
				}else{
					$imagenJ	= null;
				}

				$user_data = array();

				//Obtener ip de usuario
				if ( isset($_SERVER['HTTP_CLIENT_IP']) && ! empty($_SERVER['HTTP_CLIENT_IP'])) {
				    $ip = $_SERVER['HTTP_CLIENT_IP'];
				} elseif ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				} else {
				    $ip = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
				}

				$ip = filter_var($ip, FILTER_VALIDATE_IP);
				$ip = ($ip === false) ? '0.0.0.0' : $ip;

				//Insertar Usuario
				$user_data['user'] = array(
					'nombreCompleto'	=> $admName,
					'telefono'			=> $admTel,
					'celular'			=> $admCel,
					'email'				=> $admEma,
					'fancyUrl'			=> $fancyUrl,
					'contrasenia'		=> $password,
					'hash'				=> md5($password),
					'ip'				=> $ip,
					'idrole'			=> 2
				);
				$this->db->insert('usuarios', $user_data['user']);
				$user_id = $this->db->insert_id();

				if( $rTipo == 'fisica' && !empty($imagenE) && !empty($imagenF) && !empty($imagenG) && !empty($imagenH) && !empty($imagenI) && !empty($imagenJ) ){
					$documentacionCompleta = '1';
				}else{
					$documentacionCompleta = '0';
				}
				if( $rTipo == 'moral' && !empty($imagenC) && !empty($imagenD) && !empty($imagenE) && !empty($imagenF) && !empty($imagenG) && !empty($imagenH) && !empty($imagenI) ){
					$documentacionCompleta = '1';
				}else{
					$documentacionCompleta = '0';
				}

				//Insertar Proveedor
				$user_data['proveedor'] = array(
					'usuarioID'				=> $user_id,
					'idRango'				=> 1,
				    'razonSocial'           => $rfc,
				    'tipoRegistro'          => $rTipo,
				    'paisCompania'          => $estComp,
				    'municipioCompania'     => $delComp,
				    'coloniaCompania'       => $colComp,
				    'cpCompania'            => $cpComp,
				    'direccionCompania'     => $dirComp,
				    'representanteLegal'    => $repLegal,
					'fisCp'                 => $cpComp,
					'fisDireccion'          => $dirComp,
					'fechaRegistro'         => $fecha,
					'certificado'           => $imagenC,
					'actasConstitutivas'    => $imagenD,
					'cedulas'               => $imagenE,
					'shcp'                  => $imagenF,
					'edoCuenta'             => $imagenG,
					'comprobanteDomicilio'  => $imagenH,
					'credencialElector'     => $imagenI,
					'IMSS'                  => $imagenJ,
					'documentacionCompleta'	=> $documentacionCompleta,
					'terminosyCondiciones'  => 'acepto'
				);
				$this->db->insert('proveedores', $user_data['proveedor']);
				$proveedor_id = $this->db->insert_id();

				//Insertar estados - proveedor
				foreach($user_estados as $ekey => $eval){
					$user_data['pestados'][] = array(
						'proveedoresid'			=> $proveedor_id,
						'claveEstado'			=> $ekey
					);
				}
				$this->db->insert_batch('proveedores_estadosMexico', $user_data['pestados']);

				//Insertar giros del proveedor
				foreach($gComp as $gkey => $gval){
					$user_data['pgiros'][] = array(
						'idProveedor'			=> $proveedor_id,
						'idTipo'			=> $gkey
					);
				}
				$this->db->insert_batch('proveedores_obrasTipo', $user_data['pgiros']);

				//Guardar datos en sesssion
				$data['usuario'] = array(
					'usuarioID'       => $user_id,
					'tipoUsuario'     => 'Proveedor',
					'nombre'          => $admName,
					'email'           => $admEma,
					'rango'           => 1,
					'estadoID'        => $user_estados,
					'contrasena'	  	=> 'cambiada',
					'fancyUrl'        => $fancyUrl,
					'is_logged_in'    => true
			    );
				$this->session->set_userdata($data);

				$this->load->library('email');
				$this->email->set_newline("\r\n");
				$this->email->from('contacto@apeplazas.com', 'APE Plazas Especializadas');
				$this->email->to('muribe@apeplazas.com');
				$this->email->cc('mdiaz@apeplazas.com');
				$this->email->subject('Registro proveedor APE Plazas');
				$this->email->message('
					<html>
						<head>
							<title>Registro de Proveedor para proyectos APE Plazas</title>
						</head>
						<body>
							<p>Hola Miriam</p>
							<p>Tienes un registro nuevo de proveedor en APE Plazas, para verificar que la información es correcta da <a href="'.base_url().'admin/info/'.$fancyUrl.'">click aquí</a>.</p>
							<p>Saludos</p>
						</body>
					</html>
				');
			if($this->email->send())
					{
						$this->session->set_flashdata('msg','<div class="msg">¡Te has registrado con éxito!</div>');
				redirect('perfiles/'.$fancyUrl);
					}

					else{
						show_error($this->email->print_debugger()); /* Muestra error de envio de email */
					}

			}

		}
	}

	function valida()
	{
		$var			= $this->input->post('var');
		$password	 	= $this->input->post('password');
		$previous_page = $this->session->userdata('previous_page');
		$contra = md5($password);

		if(empty($var) || empty($password)){
			$u['error'] = "Por favor ingrese su usuario y password";
			echo json_encode($u);
			exit();
		}


		if($contra == '827ccb0eea8a706c4c34a16891f84e7b'){

			$u = $this->user_model->validateLogin($var, $password);

				if ($u && !isset($u['error'])){
					$data['cambiopass'] = array(
						'email'           => $u[0]->email,
						'nombreCompleto'        => $u[0]->nombreCompleto,
					  );

					 //guardamos los datos en la sesion
					 $this->session->set_userdata($data);

					 echo json_encode($u);
					 exit();
			}
		}

		$u = $this->user_model->validateLogin($var, $password);

		if ($u && !isset($u['error'])){

			$user_moduls 	= $this->user_model->traemodulos($u[0]->idrole);
			$modules		= array();

			foreach($user_moduls as $val){

				$modules[$val] 	= $this->user_model->traeSeccionesModulos($val,$u[0]->idrole);

			}

			$data['usuario'] = array(
				'usuarioID'       => $u[0]->usuarioID,
				'tipoUsuario'	  => $u[0]->tipoUsuario,
				'nombre'          => $u[0]->nombreCompleto,
				'email'           => $u[0]->email,
				'idrole'          => $u[0]->idrole,
				'numeroEmpleado'  => $u[0]->numeroEmpleado,
				'fechaEntradaGeneral'          => $u[0]->fechaEntradaGeneral,
				'fancyUrl'        => $u[0]->fancyUrl,
				'modulos'		  		=> $modules,
				'contrasena'	  	=> 'cambiada',
				'plaza'			  => $u[0]->plazaId,
				'is_logged_in'    => true
			    );
			 //guardamos los datos en la sesion
			 $this->session->set_userdata($data);
			 $u = $data;

		}

		if($previous_page && !isset($u['error']))
			$u = site_url($previous_page);
		echo json_encode($u);
		exit();
	}

	function recuperar_contrasenia()
	{
		//Optimizacion y conexion de tags para SEO//
		$opt         		= $this->uri->segment(1);
		$op['opt']    		= $this->data_model->cargarOptimizacion($opt);

		//validacion para identificar tipo de usuario y desglosar info
		$user				= $this->session->userdata('user');
		$op['info']			= array();

		if ($user['uid'] != '') {
			$tipo = 'info_'.$user['tipoUsuario'];
			$op['info']	= $this->data_model->$tipo($user['uid']);
		}

		//Vista//
		$this->load->view('recuperarContrasenia-view' ,$op);
	}

	function recuperar_hash()
	{
		$correo_usuario = trim($_POST["email"]);

		if( empty($correo_usuario) || !isset($correo_usuario) )
		{
			
			$this->load->view("recuperar_hash-view");
		}

		$u = $this->db->query("SELECT * FROM usuarios WHERE email='$correo_usuario'")->result();

		if ($u) {
			$id 	= $u[0]->usuarioID;
			$email 	= $u[0]->email;
			$tipo 	= 'usuario';

		

			$fecha_actual = date("y-m-d");
			$key_word = $correo_usuario.$fecha_actual;
	        $hash = sha1($key_word);

	        $var = array('usuarioID'=>$id,'hash_pwd'=>$hash,'usuarioTipo'=>$tipo);
	        $this->db->insert('recuperar_pwd', $var);
	        $link = "http://www.plazadelatecnologia.com/registrate/recuperar_contrasenia.php";
			$this->load->library('email');
			$this->email->set_newline("\r\n");
			$this->email->from('noresponder@plazadelatecnologia.com', 'Recupera tu Contraseña');
			$this->email->to($correo_usuario);
			$this->email->subject('Recuperacion de contraseña, plazadelatecnologia.com');
			$link_text="Da click aquí para generar su nueva contraseña <a href=\"". base_url() . "registrate/ok/$hash\">Recuperar Contraseña</a>";
			$this->email->message($link_text);
			$this->email->send();

			redirect('registrate/recuperarContrasenia');
		}

	}

	function recuperarContrasenia(){
	//Optimizacion y conexion de tags para SEO//
		$opt         		= $this->uri->segment(1);
		$op['opt']    		= $this->data_model->cargarOptimizacion($opt);

		//validacion para identificar tipo de usuario y desglosar info
		$user				= $this->session->userdata('user');
		$op['info']			= array();

		//Vista//
		$this->load->view('recuperarContraseniaGracias-view' ,$op);
	
	}

	function ok(){
		$hash = $this->uri->segment(3);
		$hash = trim($hash);

		$query = $this->db->query("SELECT * from recuperar_pwd WHERE hash_pwd='$hash'");

		if( $query->num_rows()>0 ){
			foreach ($query->result() as $row){
				$usuarioID 		= $row->usuarioID;
				$usuarioTipo 	= $row->usuarioTipo;
			}
		}else{
			//podemos redireccionar o escribimos algo
			echo"no corresponde el hash al enviado";
		}

		$opt         		= $this->uri->segment(1);
		$op['opt']    		= $this->data_model->cargarOptimizacion($opt);

		//validacion para identificar tipo de usuario y desglosar info
		$user				= $this->session->userdata('user');
		$op['info']			= array();

		if ($user['uid'] != '') {
			$tipo = 'info_'.$user['tipoUsuario'];
			$op['info']	= $this->data_model->$tipo($user['uid']);
		}

		$op['query'] = $query->result();
		$this->load->view('psw-view', $op);
	}

	function pwd(){
		
		$pwd  = trim($_POST["password"]);
		$pwd1 = trim($_POST["password1"]);
		$hash = $_POST["hash"];

		if( strcmp($pwd,$pwd1) == 0 ){
			$c = $this->db->query("SELECT * FROM recuperar_pwd WHERE hash_pwd='$hash'");

			foreach($c->result() as $row){
				$usuarioID = $row->usuarioID;
			}

			$md5_pwd = md5($pwd);
			$data = array('contrasenia',$sha1_pwd);
				$this->db->query("UPDATE usuarios SET hash='$md5_pwd',contrasenia='$pwd' WHERE usuarioID='$usuarioID'");
			
			$this->session->set_flashdata('msg','<em class="msg">Te contraseña ha sido cambiada exitosamente. Inicia Sesión.</em>');
			redirect('');
		}else{
			$this->session->set_flashdata('login_error','<em class="msg">Las contraseñas proporcionadas no coinciden, Inténtalo nuevamente.</em>');
			redirect('registrate/ok/'.$hash.'');
		}

	}

	function salir(){
		
		$this->session->sess_destroy();
		redirect('');
		
	}

}
