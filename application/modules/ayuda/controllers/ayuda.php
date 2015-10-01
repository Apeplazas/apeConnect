<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ayuda extends MX_Controller {
	
	function ayuda()
	{
		parent::__construct();
		$this->load->model('prospectos/prospectos_model');
	}
	
	function index(){
		echo 'hola';	
	}
	
	function statusProspecto()
	{
		//Optimizacion y conexion de tags para SEO//
		$opt = $this->uri->segment(1); 
		$op['opt'] = $this->data_model->cargarOptimizacion($opt);
		
		$user = $this->session->userdata('usuario');
		$op['prospectos'] 	= $this->prospectos_model->cargarProspectosUsuario($user['usuarioID']); 
		
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');
		
		//Vista//
		$this->layouts->profile('error-view' ,$op);
	}
}