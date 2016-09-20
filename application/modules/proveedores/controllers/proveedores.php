<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proveedores extends MX_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->user_model->checkuser();
		$this->load->model('admin_model');
		$this->load->model('user_model');
		$this->load->model('proyectos/proyecto_model');
		
		
		
	}	
    
	function index()
	{
		
		
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');
					  
		//Informacion perfil general//
		$user         = $this->session->userdata('usuario');
		$user_type    = strtoupper($user['tipoUsuario']);
		
		$op['profile']		= $info = $this->user_model->traeadmin($user['usuarioID']);
		$op['proveedores']	= $this->user_model->traeproveedores();
				
		$this->layouts->profile('proveedores-view', $op);
	}	
}

