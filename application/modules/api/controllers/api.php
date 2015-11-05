<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Api extends REST_Controller {
	
	function api(){
		
		parent::__construct();
		$this->load->model('prospectos/prospectos_model');
		
	}
	
	function login_post(){
		$userAlias		= $this->input->post('userAlias');
		$password	 	= $this->input->post('password');
		
		if(empty($userAlias) || empty($password)){
			$this->response(array('error' => 'Favor de mandar alias y contraseña'), 400);
		}
		
		$u = $this->user_model->validateLogin($userAlias, $password);

		if ($u && !isset($u['error'])){
			
			$user_moduls = $this->user_model->traemodulos($u[0]->idrole);
			
			$data['usuario'] = array(
				'usuarioID'       => $u[0]->usuarioID,
				'tipoUsuario'	  => $u[0]->tipoUsuario,
				'nombre'          => $u[0]->nombreCompleto,
				'email'           => $u[0]->email,
				'idrole'           => $u[0]->idrole,
				'fancyUrl'        => $u[0]->fancyUrl,
				'modulos'		  => $user_moduls,
				'is_logged_in'    => true
			    );
			 $u = $data;
			 $this->response($u, 200);
			
		}else{
			
			$this->response(array('error' => $u['error']), 404);
			
		}
		
	}
	
	function prospectos_post(){
		
		$userId		= $this->post('userId');
		
		if(!$userId){
        	$this->response(array('error' => 'Especifique el id del usuario'), 400);
        }
		
		$prospectos	= $this->prospectos_model->cargarProspectosUsuario($userId);
		if($prospectos){
            $this->response($prospectos, 200); // 200 being the HTTP response code
        }else{
            $this->response(array('error' => 'No se encontraron prospectos'), 404);
        }
		
	}
	
	function prospecto_editar_post(){
		
		$user		= $this->session->userdata('usuario');
		$prospectos	= $this->prospectos_model->cargarProspectosUsuario(1);
		 if($prospectos){
            $this->response($_POST, 200); // 200 being the HTTP response code
        }else{
            $this->response(array('error' => 'No se encontraron usuarios'), 404);
        }
		
	}
		
	private function agregar(){
		
		//Optimizacion y conexion de tags para SEO//		
		$op['plazas']     = $this->data_model->cargaZonas(); 
		$op['giros']      = $this->data_model->cargarGiros();
		$op['vendedores'] = $this->data_model->cargarVendedores(); 
		
		$op['origenCliente'] 	= $this->prospectos_model->origenCliente(); // Carga Origen del cliente
		$op['estados'] 	= $this->data_model->estados(); // Carga Estados
		
		
	}
	
	private function editarProspecto(){

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
		$plaza            = $_POST['plaza'];
		$prospectoID  	  = $this->uri->segment(3);

			$user = $this->session->userdata('usuario');

			$info = array(
					'titulo'          => $titulo,
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
					'usuarioID'		  => $asignado,
					'calle'			  => $calle
					 );
			$this->db->where('id', $prospectoID);
			$this->db->update('prospectos', $info);

			$fecha = $this->prospectos_model->cargaFechaCierre($prospectoID);
			$fechaBD = $fecha[0]->fechaCierre;

			if ($fechaCierre != $fecha[0]->fechaCierre){

				$fecha = array(
				'fechaCierre' => $fechaCierre,
				'usuarioID' => $user['usuarioID'],
				'prospectoID' => $prospectoID,
				'status'  => 'activado'
				);
				$this->db->insert('fechaCierreProspectos', $fecha);

				$dataStatus = array( 'status'  => 'borrado');
				$this->db->where('prospectoID', $prospectoID);
				$this->db->where('fechaCierre', $fechaBD);
				$this->db->update('fechaCierreProspectos', $dataStatus);
			}
	}
	
	function guardarProspecto(){

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
		
		if ($this->form_validation->run($this) == FALSE){
			
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
			
		}else{
			
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
			}else{
			
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