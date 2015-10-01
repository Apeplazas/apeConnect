<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends MX_Controller {
	
	function api(){
		
		parent::__construct();
		$this->load->model('prospectos/prospectos_model');
		
	}
	
	function obtenerProspectos(){
		
		$user = $this->session->userdata('usuario');
		$prospectos	= $this->prospectos_model->cargarProspectosUsuario(1);
		echo json_encode($prospectos); 
		exit;
		
	}
	
	function agregar(){
		
		//Optimizacion y conexion de tags para SEO//
		$opt = $this->uri->segment(1);
		$op['opt'] = $this->data_model->cargarOptimizacion($opt);
		
		$op['plazas']     = $this->data_model->cargaZonas(); 
		$op['giros']      = $this->data_model->cargarGiros();
		$op['vendedores'] = $this->data_model->cargarVendedores(); 
		
		//Carga el javascript para jquery//
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/css/jquery-datepicker.css');
		
		$op['origenCliente'] 	= $this->prospectos_model->origenCliente(); // Carga Origen del cliente
		$op['estados'] 	= $this->data_model->estados(); // Carga Estados
		
		//Vista//
		$this->layouts->profile('agregarProspectos-view' ,$op);
	}
	
	function actualizar($prospectoID){
		
		//Optimizacion y conexion de tags para SEO//
		$opt = $this->uri->segment(1);
		$op['opt'] = $this->data_model->cargarOptimizacion($opt);
		
		$op['plazas']     = $this->data_model->cargaZonas(); 
		$op['giros']      = $this->data_model->cargarGiros(); 
		$op['vendedores'] = $this->data_model->cargarVendedores(); 
		
		//Carga el javascript para jquery//
		$this->layouts->add_include('assets/js/functions.js');
		
		$op['origenCliente'] 	= $this->prospectos_model->origenCliente(); // Carga Origen del cliente
		$op['estados'] 	= $this->data_model->estados(); // Carga Estados
		
		
		//Vista//
		$this->layouts->profile('actualizarProspectos-view' ,$op);
	}
	
	function guardarProspecto(){
			
		$this->form_validation->set_rules('primerNombre', 'Nombre', 'required');
		$this->form_validation->set_rules('apellidoPaterno', 'Apellido paterno', 'required');
		$this->form_validation->set_rules('apellidoMaterno', 'Apellido materno', 'required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email');
		$this->form_validation->set_rules('telefono', 'Telefono', 'required');
		$this->form_validation->set_rules('actividad', 'Tipo actividad', 'required');
		$this->form_validation->set_rules('plaza', 'Plaza', 'required');
		$this->form_validation->set_rules('origen', 'Origen del Cliente', 'required');
		
		$titulo           = $this->input->post('titulo');
		$primerNombre     = $this->input->post('primerNombre');
		$segundoNombre    = $this->input->post('segundoNombre');
		$apellidoPaterno  = $this->input->post('apellidoPaterno');
		$apellidoMaterno  = $this->input->post('apellidoMaterno');
		$email            = $this->input->post('email');
		$telefono         = $this->input->post('telefono');
		$mobile           = $this->input->post('mobile');
		$giro             = $this->input->post('giro');
		$actividad        = $this->input->post('actividad');
		$asignado         = $this->input->post('asignado');
		$origen           = $this->input->post('origen');
		$vendedor         = $this->input->post('vendedor');
		$calle            = $this->input->post('calle');
		$estado           = $this->input->post('estado');
		$municipio        = $this->input->post('municipio');
		$colonia          = $this->input->post('colonia');
		$cp               = $this->input->post('cp');
		$exterior         = $this->input->post('exterior');
		$interior         = $this->input->post('interior');
		$comentario       = $this->input->post('comentario');
		$fechaCierre      = $this->input->post('fechaCierre');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			//Optimizacion y conexion de tags para SEO//
			$opt = $this->uri->segment(1);
			$op['opt'] = $this->data_model->cargarOptimizacion($opt);
			
			$op['plazas']     = $this->data_model->cargaZonas(); 
			$op['giros']      = $this->data_model->cargarGiros(); 
			$op['vendedores'] = $this->data_model->cargarVendedores(); 
			
			//Carga el javascript para jquery//
			$this->layouts->add_include('assets/js/jquery-ui.js')
						  ->add_include('assets/css/jquery-datepicker.css');
			
			$op['origenCliente'] 	= $this->prospectos_model->origenCliente(); // Carga Origen del cliente
			$op['estados'] 	= $this->data_model->estados(); // Carga Estados
			
			//Vista//
			$this->layouts->profile('agregarProspectos-view' ,$op);
		}
		
					
		else
		{
			$mail = $this->prospectos_model->validaEmail($email);
			
			if ($mail){
				//Optimizacion y conexion de tags para SEO//
				$opt = $this->uri->segment(1);
				$op['opt'] = $this->data_model->cargarOptimizacion($opt);
				
				$op['plazas']     = $this->data_model->cargaZonas(); 
				$op['giros']      = $this->data_model->cargarGiros(); 
				$op['vendedores'] = $this->data_model->cargarVendedores(); 
				
				//Carga el javascript para jquery//
				$this->layouts->add_include('assets/js/jquery-ui.js')
							  ->add_include('assets/css/jquery-datepicker.css');
				
				$op['origenCliente'] 	= $this->prospectos_model->origenCliente(); // Carga Origen del cliente
				$op['estados'] 	= $this->data_model->estados(); // Carga Estados
				
				$this->session->set_flashdata('msg','<div class="msgAlert">Este prospecto ya se encuentra registrado.</div>');
					
				$this->layouts->profile('agregarProspectos-view' ,$op);
			}
			else{
			
			$user = $this->session->userdata('usuario');
			
			$info = array(
					'pnombre'         => $primerNombre,
					'snombre'         => $segundoNombre,
					'apellidop'       => $apellidoPaterno,
					'apellidom'       => $apellidoMaterno,
					'correo'          => $email,
					'telefono'        => $telefono,
					'celular'         => $mobile,
					'actividad'       => $actividad,
					'origenCliente'   => $origen,
					'giro'            => $giro,
					'estado'          => $estado,
					'municipio'       => $municipio,
					'colonia'         => $colonia,
					'cp'              => $cp,
					'numeroInt'       => $interior,
					'numeroExt'       => $exterior,
					'comentario'      => $comentario,
					'usuarioID'		  => $asignado
					 );
			$this->db->insert('prospectos', $info);
			// llama al ultimo identificador insertado
			$lastID = $this->db->insert_id();
			
			$plaza  =  $_POST['plaza'];
			$datos = array();
				foreach($plaza as $p){
					$datos[] = array(
					'usuarioID' => $lastID,
					'plazaID' => $p
					);	
				}
			$this->db->insert_batch('prospectosPlazas', $datos);
			
			$fecha = array(
				'fechaCierre' => $fechaCierre,
				'usuarioID' => $lastID,
			);
			$this->db->insert('fechaCierreProspectos', $fecha);
			redirect('prospectos');
			}
		}
		
	}	

}