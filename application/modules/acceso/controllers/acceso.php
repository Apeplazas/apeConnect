<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acceso extends MX_Controller
{

	function index()
	{
			$userprofile = $this->session->userdata('usuario');
			$cambiopass 	= $this->session->userdata('cambiopass');

			//codigo para hacer el cambio de contraseña
			if($cambiopass){
				redirect("cambiopass");
				return false;
			}

			else if(!isset($userprofile) || $userprofile != true){

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

	      $urlGuardad 		= $this->session->userdata('previous_page');
				if($urlGuardad){
					if(strpos($urlGuardad, "http://") === true)
						$urlGuardad = site_url($urlGuardad);
					redirect($urlGuardad);
				}
        	redirect("dashboard");

        }

	}

}
