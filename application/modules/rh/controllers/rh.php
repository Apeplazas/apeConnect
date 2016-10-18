<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class rh extends MX_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->user_model->checkuser();
		$this->load->model('rh_model');
		if( ! ini_get('date.timezone') ){
		    date_default_timezone_set('America/Mexico_City');
		}
	}
	
	function index()
	{
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/jquery-datepicker.css')
					  ->add_include('assets/js/jquery-datepicker.js');
					  
		//Informacion perfil general//
		$user      = $this->session->userdata('usuario');
		$user_type = strtoupper($user['tipoUsuario']);
		
		$op['tipos'] 	= $this->data_model->cargarTipoCompania();
		$op['rango'] 	= $this->data_model->costoRango();
		$op['zonas'] 	= $this->data_model->cargaZonas();
		$op['userID']   = $user['usuarioID'];
		$op['profile']	= $info = $this->user_model->traeadmin($user['usuarioID']);
		
		$op['empleados'] = $this->rh_model->traerEmpleados($user['usuarioID']);
		
		$this->layouts->profile('rh-view', $op);
	}
	
	public function test(){
		
		
	}
	
	function editUser($userID){
		
		
		
	}
	
}