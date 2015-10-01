<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EditarPerfil extends MX_Controller
{
	
	function index()
	{
		//Genera informacion perfil//
		$user	=	$this->session->userdata('usuario');
		$op['profile'] = $info = $this->usuario_model->buscaPerfilID($user['usuarioID']);
		
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js');
		
		$this->layouts->profile('user-view', $op);
	}
		
}

