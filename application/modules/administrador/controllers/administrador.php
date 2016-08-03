<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Administrador extends MX_Controller {

	function administrador()
	{
		parent::__construct();
		$this->user_model->checkuser();
		$this->load->model('administrador/administrador_model');
		setlocale(LC_MONETARY, 'es_MX');
		if( ! ini_get('date.timezone') ){
		    date_default_timezone_set('America/Mexico_City');
		}
	}

	function index()
	{
		echo"holas";
	}
	
	
	function detalleUsua(){
		$this->user_model->checkuserSection();
		$ciId		= $this->uri->segment(3);
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');
		$op['ci'] 	= $this->administrador_model->traerDatosUsuarios($usuarioID);
		$this->layouts->profile('usuario-cis-view' ,$op);
	}

	function detalleUsuaProsp(){
		$ciId		= $this->uri->segment(3);
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');
		$op['ci'] 	= $this->administrador_model->traerDatosUsuariosProsp($usuarioID);
		$this->layouts->profile('prospecto-usuarios-view' ,$op);
	}
	function verUsuarioCi(){

		//$this->user_model->checkuserSection();
		$user       =$this->session->userdata('usuario');
			$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.form.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');


		 				$op['UsuarioCart']  =$this->administrador_model->cargarUsuarioCart($user['usuarioID']);

                         $this->layouts->profile('usuario-cis-view', $op);
	    				 	       					 	     
    }	

    function verUsuarioPros(){

		//$this->user_model->checkuserSection();
		$user       =$this->session->userdata('usuario');
			$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.form.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');


		 				$op['UsuarioPost']  =$this->administrador_model->cargarUsuariosPros($user['usuarioID']);

	    				 	       					 	     	
	    				$this->layouts->profile('prospecto-usuarios-view', $op); 
	    					
    }	

	function cisUsuario(){

		$user		= $this->session->userdata('usuario');
		$plazaid 	= (isset($user['plaza'])) ? $user['plaza'] : '';
		$plaza	= $this->administrador_model->traerPlazaUsuario($user['usuarioID'],$plazaid);

		if(empty($plaza)){
			echo "No tiene permiso para ingesar a esta página";
			return false;
		}

		$this->layouts->add_include('assets/js/jquery.validate.js')
					  ->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/css/jquery-datepicker.css')
					  ->add_include('assets/js/jquery-datepicker.js')
						->add_include('assets/js/jquery.autocomplete.pack.js');

		$datosGerente		= $this->administrador_model->traerGerentePLaza($plaza[0]->id);

		$op['plaza'] 		= $plaza[0];
		$op['gerente'] 		= $datosGerente[0]->nombreCompleto;
		$op['user'] 		= $user;
		$op['plazaPisos'] 	= $this->administrador_model->traerPlazaPisos($plaza[0]->id);
		$this->layouts->profile('cis-usuario-view',$op);

	}

	function prospectosUsuarios(){

		$user		= $this->session->userdata('usuario');
		$plazaid 	= (isset($user['plaza'])) ? $user['plaza'] : '';
		$plaza	= $this->administrador_model->traerPlazaUsuario($user['usuarioID'],$plazaid);

		if(empty($plaza)){
			echo "No tiene permiso para ingesar a esta página";
			return false;
		}

		$this->layouts->add_include('assets/js/jquery.validate.js')
					  ->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/css/jquery-datepicker.css')
					  ->add_include('assets/js/jquery-datepicker.js')
						->add_include('assets/js/jquery.autocomplete.pack.js');

		$datosGerente		= $this->administrador_model->traerGerentePLaza($plaza[0]->id);

		$op['plaza'] 		= $plaza[0];
		$op['gerente'] 		= $datosGerente[0]->nombreCompleto;
		$op['user'] 		= $user;
		$op['plazaPisos'] 	= $this->administrador_model->traerPlazaPisos($plaza[0]->id);
		$this->layouts->profile('AltaUsuarioProspectos',$op);

	}


	function DarAlta($var){


		$op         = array();
		$cots       = array();


		if($this->uri->segment(3) == 'prospectosUsuarios'){
			$tipo = '8';
		}
		  elseif ($this->uri->segment(3) == 'cisUsuario'){
		  	$tipo = '5';
		  }
		
		$this->layouts->add_include('asset/js/jquery.form.js');

		$tipoUsuario  = $_POST['creacionUsuarios'];

		$op['usuario'] =$this->session->userdata('usuario');

		if(!$_POST['usuarioID']){

	  		$usuarioExist  = $this->administrador_model->usuarioExist($_POST['usuarioID']);

	  		if(empty($usuarioExist)){

	     		$info = array(
		            'nombreCompleto'         => $_POST['nombreCompleto'],
		            'puesto'                 => $_POST['puesto'],
		            'telefono'               => $_POST['telefono'],
		            'celular'                => $_POST['celular'], 
		            'email'		             => $_POST['email'],
		            'contrasenia'             =>$_POST['contrasenia'], 
		            'hash'                    =>md5('hash'),
		            'fechaRegistro'          => date('y-m-d', strtotime($_POST['fechaRegistro'])),
		            'plazaId'                => $_POST['plaza'], 
		            'registroNuevo'          => $_POST['registroNuevo'],
		            'idrole'             		=>$tipo, 
		            'status'                 => $_POST['status']);
	            $this->db->insert('usuarios', $info);
	            $usuarioID = $this->db->insert_id();

	  		}else {

	      		$usuarioID = $usuarioExist[0]->id;
	  		}

		}else{
	    	$usuarioID = $_POST['usuarioID'];
	 	}
	
	}


	function cancelarpros($usuarioID){
		$user		= $this->session->userdata('usuario');
		$usuarioID		= $this->uri->segment(3);
			$this->user_model->verificarCancelProsp($usuarioID);
		redirect('http://localhost/apeConnect/administrador/verUsuarioPros');
		}
   
    function activadopros($usuarioID){
		$user		= $this->session->userdata('usuario');
		$usuarioID		= $this->uri->segment(3);
		$this->user_model->verificarActivoProsp($usuarioID);
		redirect('http://localhost/apeConnect/administrador/verUsuarioPros');
		}

		function cancelarCartaI($usuarioID){
		$user		= $this->session->userdata('usuario');
		//$usuarioID		= $this->uri->segment;
		echo $usuarioID."prueba";
		$this->user_model->verificarCanceladoCartaI($usuarioID);
		redirect('http://localhost/apeConnect/administrador/verUsuarioCi');
		}
   
    function ActivadoCartaI($usuarioID){
		$user		= $this->session->userdata('usuario');
		//$usuarioID		= $this->uri->segment(2);
		echo $usuarioID."prueba";
		$this->user_model->verificarActivoCartaI($usuarioID);
		redirect('http://localhost/apeConnect/administrador/verUsuarioCi');
		}



}
?>