<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		$this->load->model('dashboard_model');
		$this->load->model('user_model');
		$this->load->model('proyectos/proyecto_model');
		if( ! ini_get('date.timezone') ){
		    date_default_timezone_set('America/Mexico_City');
		}
	}

	//verifica que la sesion esta inciada para poder dar acceso a modulo
	function is_logged_in()
    {
        $user = $this->session->userdata('usuario');
        if(!isset($user) || $user != true)
        {
        	$this->session->set_userdata(array('previous_page'=> uri_string()));
			redirect('');
        }
    }

function testmail(){

		$this->load->library('email');
				$this->email->set_newline("\r\n");
				$this->email->from('contacto@apeplazas.com', 'Reparadores.mx');
				$this->email->to("bcarrera@apeplazas.com");
				$this->email->subject('email del servidor de ape');
				$this->email->message('
					<html>
						<head>
							<title>Ape</title>
						</head>
						<body>
							<p>Se esta verificando que los emails lleguen</p>
							<p>Ape</p>
						</body>
					</html>
				');
				$this->email->send();

	}

	function index()
	{
		//Informacion perfil general//
		$user         = $this->session->userdata('usuario');
		if($user['idrole'] == '8'){
			redirect('prospectos');
		}
		else{
			//Carga el javascript y CSS //
			$this->layouts->add_include('assets/js/jquery-ui.js')
									->add_include('assets/js/jquery.autocomplete.pack.js')
									->add_include('assets/js/jquery.dataTables.min.js');
												
			$user_type    									= strtoupper($user['tipoUsuario']);
			$op['no_cotizaciones']            			= $info = $this->dashboard_model->trae_numcotizaciones();
			$op['no_proveedores_inscitos']    	= $this->dashboard_model->trae_proveedores_estadi();
			$op['ultimos_prov_inscritos']  			= $this->dashboard_model->trae_ultimos_proveedores_inscritos();
			$op['supervisores']							= $this->dashboard_model->trae_supervisores();
			$op['proyectos_activos']         			= $this->dashboard_model->trae_proyectos_porstatus("Contratando");
			$op['proyectos_licitados']       			= $this->dashboard_model->trae_proyectos_porstatus("Licitado");
			$op['proyectos_finalizados']   			= $this->dashboard_model->trae_proyectos_porstatus("Finalizado");
			$op['proyectos_revision']      			= $this->dashboard_model->trae_proyectos_porstatus("En Revision");
			$op['proyectos_pagados'] 				= $this->dashboard_model->trae_proyectos_porstatus("Finalizado");
			$op['total_segmentos']           			= $this->dashboard_model->trae_totsegmentos();
			$op['total_pagado']		          			=	$this->dashboard_model->tre_totalpagado();
			$op['mensajes']                   				= $this->dashboard_model->cargaMensajes($user['usuarioID']);
			$op['no_notificaciones']          			= $this->user_model->numero_mensajes($user['usuarioID']);
			$op['mensajes_gen'] = $this->notificaciones_model->cargarNotificacionesTodas($user['usuarioID']);
			
			if($user['idrole'] == '9' || $user['idrole'] == '5' || $user['usuarioID'] == '1'){
				$this->layouts->profile('dashboardVentas-view', $op);
			}
			else{
				$this->layouts->profile('dashboard-view', $op);
			}

		}
	}

	function info($fancyUrl){
		$op['proveedor']	= $this->user_model->traerproveedordetails($fancyUrl);
		$op['estados']      = $this->user_model->traerproveedorestados($op['proveedor'][0]->idProveedor);
		$op['pactuales']    = $this->user_model->traerproveedor_proyectos($op['proveedor'][0]->idProveedor,'Licitado');
		$op['pfinalizados']	= $this->user_model->traerproveedor_proyectos($op['proveedor'][0]->idProveedor,'Finalizado');
		$op['costoRango']	= $this->data_model->costoRango();
		$this->layouts->profile('proveedor-details-view', $op);
	}

	function perfil($fancyUrl){
		$user	= $this->session->userdata('usuario');
		$op['user']	= $user;
		$this->layouts->profile('perfile-view', $op);
	}
    function GraficaDashboard(){
    	$user = $this->session->userdata('usuario');
    	$op['user'] = $user;
    	$this->layouts->profile('dashboardGrafica-view', $op);
    }

     function DashboardCartaIntencion(){
    	$user = $this->session->userdata('usuario');
    	$op['user'] = $user;
    	$this->layouts->profile('dashboarCartaIntencion-view', $op);
    }
    
    
	function borrarProveedor($idProveedor)
	{
		$proveedor   = $this->uri->segment(3);

		$data = array(
               'statusProveedor' => 'Borrado'
            );

		$this->db->where('idProveedor', $proveedor);
		$this->db->update('proveedores', $data);

		redirect("proveedores");
	}

	function statusprov(){
		$statusProveedor = $this->input->post('statusProveedor');
		$proveedor_id = $this->input->post('proveedorid');
		$data = array(
			'statusProveedor' => $statusProveedor
		);
		$this->db->where('idProveedor', $proveedor_id);
        $this->db->update('proveedores', $data);
		echo json_encode("El proveedor fue actualizado");
		exit();
	}

	function rangoproveedor(){
		$rangoProveedor = $this->input->post('rangoProveedor');
		$proveedor_id = $this->input->post('proveedorid');
		$data = array(
			'idRango' => $rangoProveedor
		);
		$this->db->where('idProveedor', $proveedor_id);
        $this->db->update('proveedores', $data);
		echo json_encode("El proveedor fue actualizado");
		exit();
	}

	function salir()
	{
		$this->session->sess_destroy();
		redirect('');
	}

}
