<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notificaciones extends MX_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/admin_model');
	}
	
	function index()
	{
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');
					  
		//Informacion perfil general//
		$user      			= $this->session->userdata('usuario');
		$op['mensajes_gen']	= $this->notificaciones_model->cargarNotificacionesTodas($user['usuarioID']);
		
		$this->layouts->profile('notificaciones-view', $op);
	}
	
	function marcarleido(){
		$not = $this->input->post('not_id');
		$not_data = explode("-", $not);
		$not_id = $not_data[0];
		$not_type = $not_data[1];
		
		//Marcar mensaje leido
		if($not_type == 'role'){
			$this->db->where('id', $not_id);
	        $this->db->update('mensajes_usuarios_roles', array("leido"=>1));
		}elseif($not_type == 'usuario'){
			$this->db->where('id', $not_id);
	        $this->db->update('mensajes_usuarios', array("leido"=>1));
		}
		
	}	
		
}