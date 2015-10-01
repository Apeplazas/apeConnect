<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mensajes extends MX_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mensajes_model');
	}
	
	function index()
	{
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');
					  
		//Informacion perfil general//
		$user      				= $this->session->userdata('usuario');
		$op['mensajes_admin']	= $this->mensajes_model->traeconversaciones($user['usuarioID']);
		$op['mensajes_usuario']	= $this->mensajes_model->cargaNotificaciones_por_usuario($user['usuarioID']);
		
		$this->layouts->profile('mensajes-view', $op);
	}
		
}