<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Enlaces extends MX_Controller
{

	function links($var)
	{
		$userprofile = $this->session->userdata('usuario');

			if(!isset($userprofile) || $userprofile != true){

        	//Genera metatags
			$url = $this->uri->segment(1);

			$op['tags'] = $this->data_model->cargarOptimizacion($url);

			$this->layouts->add_include('assets/js/jquery-ui.js');
			$this->layouts->add_include('assets/js/user.js');

			//Vista//
			$this->load->view('index-view',$op);

        }
        else{

			//Codigo temporal para redirigir Gerentes a la lista de cartas de intencion
			if($userprofile['tipoUsuario'] == "Gerente Plaza"){
				redirect("tempciri/verCi");
				return false;
			}

			//codigo para hacer el cambio de contraseña
			if($userprofile['contrasena'] == 'cambiar'){
				redirect("cambiopass");
				return false;
			}

      $urlGuardad 		= $this->session->userdata('previous_page');
			if($urlGuardad){
				if(strpos($urlGuardad, "http://") === true)
					$urlGuardad = site_url($urlGuardad);
				redirect($urlGuardad);
			}
        	redirect("perfiles/".$userprofile['fancyUrl']);

        }

	}

}
