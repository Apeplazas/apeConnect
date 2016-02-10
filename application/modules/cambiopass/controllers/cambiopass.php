<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cambiopass extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('cambiopass/cambiopass_model');
		$this->load->model('user_model');
		//$this->user_model->checkuser();
	}

	function index(){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css')
					  ->add_include('assets/css/bootstrap.min.css')
					  ->add_include('assets/js/user.js');

		$this->load->view('cambio-view');
	}

	function cambia(){
		$pwd1 	= $this->input->post('pass1');
		$pwd2 	= $this->input->post('pass2');
		$email 	= $this->input->post('email');
		$link		= $this->session->userdata('previous_page');

		if($link){
			if(!strpos($link, "http://") === true){				$link= site_url($link);
			}
		}

		$hash = md5($pwd2);#<-- Genero el nuevo hash, basandome en como lo crean en registrate/guardarRegistro
		//$hash = $userprofile['contrasenia'];

		if($pwd1 === $pwd2){
			$result = $this->cambiopass_model->actualizaPass($pwd2, $hash, $email);

			if(count($result) > 0){

				$u = $this->user_model->validateLogin($email, $pwd2);

				$user_moduls 	= $this->user_model->traemodulos($u[0]->idrole);
				$modules		= array();
				foreach($user_moduls as $val){
					$modules[$val] 	= $this->user_model->traeSeccionesModulos($val,$u[0]->idrole);
				}


				$data['usuario'] = array(
					'usuarioID'       => $u[0]->usuarioID,
					'tipoUsuario'	  	=> $u[0]->tipoUsuario,
					'nombre'          => $u[0]->nombreCompleto,
					'email'           => $u[0]->email,
					'idrole'          => $u[0]->idrole,
					'fancyUrl'        => $u[0]->fancyUrl,
					'contrasena'	  	=> $u[0]->contrasenia,
					'modulos'					=> $modules,
					'plaza'						=> $u[0]->plazaId,
					'is_logged_in'    => true
						);



				 //guardamos los datos en la sesion
				 $this->session->set_userdata($data);
				 $this->session->unset_userdata('cambiopass');

				redirect($link);
			}
			else{
				$err['error'] = "Ocurrio un error al guardar los datos, por favor comunicate con el administrador del sistema";
				$this->load->view('cambio-view', $err);
			}
		}else{
			$err['error'] = "Revisa que hayas colocado la misma contraseña en ambos campos";
			$this->load->view('cambio-view', $err);

		}
	}

}
