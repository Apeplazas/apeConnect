<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prospectos extends MX_Controller {
	
	function testrap(){
		
		$rap = $this->generar_rap("AZ00035SG00002L87","bancomer");
		var_dump($rap);
	}

	public function generar_rap($rap = 'JP13H679',$banco = 'hsbc'){

		if(!preg_match('/^[a-zA-Z0-9]*$/', $rap))
			return false;

		$chars = str_split($rap);
		$chars = array_reverse($chars);


		//if(sizeof($chars) > 19)
			//return false;

		$hsbc_valores = array(
			'A'	=>	1,
			'B' =>	2,
			'C'	=>	3,
			'D'	=>	4,
			'E'	=>	5,
			'F'	=>	6,
			'G'	=>	7,
			'H'	=>	8,
			'I'	=>	9,
			'J'	=>	1,
			'K'	=>	2,
			'L'	=>	3,
			'M'	=>	4,
			'N'	=>	5,
			'O'	=>	6,
			'P'	=>	7,
			'Q'	=>	8,
			'R'	=>	9,
			'S'	=>	2,
			'T'	=>	3,
			'U'	=>	4,
			'V'	=>	5,
			'W'	=>	6,
			'X'	=>	7,
			'Y'	=>	8,
			'Z'	=>	9
		);

		$banorte_valores = array(
			'A'	=>	2,
			'B'	=>	2,
			'C'	=>	2,
			'D'	=>	3,
			'E'	=>	3,
			'F'	=>	3,
			'G'	=>	4,
			'H'	=>	4,
			'I'	=>	4,
			'J'	=>	5,
			'K'	=>	5,
			'L'	=>	5,
			'M'	=>	6,
			'N'	=>	6,
			'O'	=>	6,
			'P'	=>	7,
			'Q'	=>	7,
			'R'	=>	7,
			'S'	=>	8,
			'T'	=>	8,
			'U'	=>	8,
			'V'	=>	9,
			'W'	=>	9,
			'X'	=>	9,
			'Y'	=>	0,
			'Z'	=>	0
		);
		
		$bancomer_valores = array(
			'A' => 1,
			'B' => 2,
			'C' => 3,
			'D' => 4,
			'E' => 5,
			'F'	=> 6,
			'G' => 7,
			'H' => 8,
			'I' => 9,
			'J' => 1,
			'K' => 2,
			'L' => 3,
			'M' => 4,
			'N' => 5,
			'O' => 6,
			'P' => 7,
			'Q' => 8,
			'R' => 9,
			'S' => 1,
			'T' => 2,
			'U' => 3,
			'V' => 4,
			'W' => 5,
			'X' => 6,
			'Y' => 7,
			'Z' => 8
			
		);

		$multiply 	= 2;
		$sum		= 0;

		foreach($chars as $char){

			if(preg_match('/[A-Z]/', strtoupper($char)))
				if($banco == 'hsbc')
					$char = $hsbc_valores[strtoupper($char)];
				elseif($banco == 'banorte')
					$char = $banorte_valores[strtoupper($char)];
				elseif($banco == 'bancomer')
					$char = $bancomer_valores[strtoupper($char)];

			$temp 	= ($char*$multiply>=10) ? floor($char*$multiply/10)+($char*$multiply-10) : $char*$multiply;
			$sum	= $sum + $temp;

			if($multiply == 2)
				$multiply = 1;
			else
				$multiply = 2;
		}
		
		if($banco == 'bancomer'){
			
			$verifi	= (10 * ceil($sum/10))-$sum;
			
		}else{
			
			$res	= $sum-(10 * floor($sum/10));
			$verifi	= (10-$res==10) ? 0 : 10-$res;
			
		}

		return $rap.$verifi;

	}

	function generarReciboInterno(){

		$op['usuario']	= $this->session->userdata('usuario');
		$op['fecha']	= date('d/m/Y');

		//Generamos recibo desde una carta de intencion
		if($_POST['generador'] == 'cartIn'){

			//$op['cartaIntDetalles'] = $this->data_model->cargarCargarCartaIntencion($_POST['cartInId']);
			$op['cantidadPagada']	= $_POST['cantpago'];
			$op['mecontrato']		= $_POST['mes'];
			$op['contratoTiempo']	= $_POST['contratotiempo'];
			$op['clienteDatos']		= $this->prospectos_model->cargarProspectoPerfil($_POST['clienteid']);

		//Generamos Recibo desde cero
		}elseif($_POST['generador'] == 'iniciar'){



		}

		$op['op']			= $op;

		var_dump($_POST);
		$this->layouts->pdf('reciboInterno-view',$op);

	}

	function prospectos()
	{
		parent::__construct();
		$this->user_model->checkuser();
		$this->load->model('prospectos/prospectos_model');
		$this->load->model('tempciri/tempciri_model');
		
		
	}

	function index()
	{
		$user = $this->session->userdata('usuario');
		$today = date('Y-m-d');
		if($this->uri->segment(1) =='prospectos'){ ?>
			<script src="<?php echo base_url(); ?>assets/js/jquery-1.9.1.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
			<script type="text/javascript">
					
					$(document).ready(function() {
						var usuarioID	= '<?= $user['usuarioID']?>';
						var fechaAcceso = '<?= $today ?>';
						var modulo = 'prospectos';
						
						$.post('<?=base_url()?>ajax/cuentaEntradaModulos',{
										usuarioID : usuarioID,
										fechaAcceso : fechaAcceso,
										modulo : modulo
						},'json');
					});
					
			</script>
		<? }
		
		$user = $this->session->userdata('usuario');
		$op['prospectos'] 	= $this->prospectos_model->cargarProspectosUsuario($user['usuarioID']);

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		//Vista//
		$this->layouts->profile('prospectos-view' ,$op);
	}
	function agregarComentario(){
	 	//Informacion perfil General//

		$prospectoID          = $this->input->post('prospectoID');
		$conversacionId           = $this->input->post('conversacionId');
	 	$user                 = $this->session->userdata('usuario');
		$usuarioID            = $user['usuarioID'];
		$respuesta           = $this->input->post('respuesta');
	
		if(empty($conversacionId)){

			if( $user['idrole'] == 4){

				$jefeDirecto = $this->user_model->traerJefeDirecto( $user['numeroEmpleado']);
				$idUsuarioDos = $jefeDirecto[0]->usuarioID;

			}else{
				$prospecto = $this->prospectos_model->cargarProspectoPerfil($prospectoID);
				$idUsuarioDos = $prospecto[0]->usuarioID;	
			}
			$var2 = array(
			'idUsuarioUno'      	=> $usuarioID, 
			'idUsuarioDos'			=> $idUsuarioDos,
			'idConversacionTipo'	=> 6,
			'idReferencia'          => $prospectoID
			);

			$this->db->insert('conversaciones', $var2);
			$conversacionId = $this->db->insert_id();

		}
		//Genera Array y Inserta en la BD de asunto

		$var = array(
			'respuesta'      	=> $respuesta,
			'usuarioId'			=> $usuarioID,
			'idConversacion'		=> $conversacionId
			);

		$this->db->insert('conversacionesRespuestas', $var);
		
		redirect('prospectos/usuarios/'.$prospectoID);
		
	}
 

	function agregar()
	{
		//Optimizacion y conexion de tags para SEO//
		$opt = $this->uri->segment(1);
		$op['opt'] = $this->data_model->cargarOptimizacion($opt);

		$op['plazas']     = $this->data_model->cargaZonas();
		$op['giros']      = $this->data_model->cargarGiros();
		$op['vendedores'] = $this->data_model->cargarVendedores();

		//Carga el javascript para jquery//
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/css/jquery-datepicker.css')
					  ->add_include('assets/css/planogramas.css');

		$op['origenCliente'] 	= $this->prospectos_model->origenCliente(); // Carga Origen del cliente
		$op['estados'] 	= $this->data_model->estados(); // Carga Estados

		$op['cadena']   = '';

		//Vista//
		$this->layouts->profile('agregarProspectos-view' ,$op);
	}

	function solicitarAlta($prospectoID)
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

		$op['cadena']   = '';

		//Vista//
		$this->layouts->profile('solicitarAlta-view' ,$op);
	}
	
	function general(){
		$user = $this->session->userdata('usuario');
		$op['prospectos'] = $this->prospectos_model->cargarProspectosGeneral();
		$op['vendedores'] = $this->prospectos_model->cargaVendedores();
		
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
							  ->add_include('assets/js/jquery.autocomplete.pack.js')
							  ->add_include('assets/js/jquery.dataTables.min.js')
							  ->add_include('assets/css/planogramas.css');

		//Vista//
		$this->layouts->profile('general-view' ,$op);
	}
	
	function editar($prospectoID)
	{
		//Optimizacion y conexion de tags para SEO//
		$opt = $this->uri->segment(1);
		$op['opt'] = $this->data_model->cargarOptimizacion($opt);

		$op['plazas']     = $this->data_model->cargaZonas();
		$op['giros']      = $this->data_model->cargarGiros();
		$op['vendedores'] = $this->data_model->cargarVendedores();

		$id = $this->uri->segment(3);
		$op['zonas']  = $this->prospectos_model->cargarZonasProspecto($id);
		$op['girosSel']  = $this->prospectos_model->cargarGirosProspecto($id);
		$op['perfil'] = $perfil = $this->prospectos_model->cargarProspectoPerfil($id);
		$op['vendedor'] = $this->prospectos_model->cargarUsuariosID($perfil[0]->usuarioID);

		//Carga el javascript para jquery//
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/css/jquery-datepicker.css');

		$op['origenCliente'] 	= $this->prospectos_model->origenCliente(); // Carga Origen del cliente
		$op['estados'] 	= $this->data_model->estados(); // Carga Estados

		$op['cadena']   = '';

		//Vista//
		$this->layouts->profile('editarProspectos-view' ,$op);
	}

	function actualizar($prospectoID)
	{
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

	function guardarProspecto()
	{
		$user = $this->session->userdata('usuario');
		
		if(empty($user['usuarioID'] )){
			echo 'Este ha sido un error de sistema, por favor reportarlo a la ext 1309 con Miguel Diaz, Gracias por su atención';
		}
		else{
			$this->form_validation->set_rules('primerNombre', 'nombre', 'required');
			$this->form_validation->set_rules('segundoNombre' );
			$this->form_validation->set_rules('apellidoPaterno', 'apellido paterno', 'required');
			$this->form_validation->set_rules('apellidoMaterno' );
			$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|callback_email');
			$this->form_validation->set_rules('telefono', 'telefono', 'required');
			$this->form_validation->set_rules('mobile' );
			$this->form_validation->set_rules('estado', 'estado', 'required' );
			$this->form_validation->set_rules('municipio', 'municipio', 'required' );
			$this->form_validation->set_rules('giro' );
			$this->form_validation->set_rules('colonia',  'colonia', 'required' );
			$this->form_validation->set_rules('cp' );
			$this->form_validation->set_rules('calle' );
			$this->form_validation->set_rules('exterior' );
			$this->form_validation->set_rules('interior' );
			$this->form_validation->set_rules('comentario' );
			$this->form_validation->set_rules('actividad', 'tipo actividad', 'required');
			$this->form_validation->set_rules('origen', 'origen del Cliente', 'required');
			$this->form_validation->set_rules('plaza[]', 'plaza', 'required');
	
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
			$asignado         = $user['usuarioID'];
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
			$statusProspecto      = $this->input->post('statusProspecto');
			$plaza            = isset($_POST['plaza']) ? $_POST['plaza'] : '';
	
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
				$op['cadena'] = $plaza;
	
				//Vista//
				$this->layouts->profile('agregarProspectos-view' ,$op);
			}
			else
			{
				$mail = $this->prospectos_model->validaEmail($email);
	
				if ($mail){
	
					$this->session->set_flashdata('msg', '<div class="msgAlert"><img src="../assets/graphics/alert.png" alt="Alerta" /><p>Este prospecto ya fue registrado por el usuario ' .$mail[0]->nombreCompleto.'</p></div><br class="clear">', true);
					redirect('prospectos/agregar','refresh');
	
				}
	
				else{
	
				$user = $this->session->userdata('usuario');
	
				$info = array(
						'titulo'          => strtoupper($titulo),
						'pnombre'         => strtoupper($primerNombre),
						'snombre'         => strtoupper($segundoNombre),
						'apellidop'       => strtoupper($apellidoPaterno),
						'apellidom'       => strtoupper($apellidoMaterno),
						'correo'          => $email,
						'telefono'        => $telefono,
						'celular'         => $mobile,
						'actividad'       => strtoupper($actividad),
						'origenCliente'   => $origen,
						'giro'            => strtoupper($giro),
						'estado'          => strtoupper($estado),
						'municipio'       => strtoupper($municipio),
						'colonia'         => strtoupper($colonia),
						'statusProspecto' => strtoupper($statusProspecto),
						'cp'              => $cp,
						'numeroInt'       => $interior,
						'numeroExt'       => $exterior,
						'comentario'      => strtoupper($comentario),
						'usuarioID'		  => $asignado,
						'calle'			  => strtoupper($calle)
						 );
				$this->db->insert('prospectos', $info);
				// llama al ultimo identificador insertado
				$lastID = $this->db->insert_id();
	
				$datos = array();
					foreach($plaza as $p){
						$datos[] = array(
						'usuarioID' => $lastID,
						'plazaID' => $p
						);
					}
				$this->db->insert_batch('prospectosPlazas', $datos);
	
				redirect('prospectos');
				}
			}
			
		}
		
		

	}

	function editarProspecto()
	{
		$user = $this->session->userdata('usuario');
		
		if(empty($user['usuarioID'] )){
			echo 'Este ha sido un error de sistema, por favor reportarlo a la ext 1309 con Miguel Diaz, Gracias por su atención';
		}else{
			$this->form_validation->set_rules('primerNombre', 'nombre', 'required');
			$this->form_validation->set_rules('segundoNombre' );
			$this->form_validation->set_rules('apellidoPaterno', 'apellido paterno', 'required');
			$this->form_validation->set_rules('apellidoMaterno' );
			$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|callback_email');
			$this->form_validation->set_rules('telefono', 'telefono', 'required');
			$this->form_validation->set_rules('mobile' );
			$this->form_validation->set_rules('estado' );
			$this->form_validation->set_rules('municipio' );
			$this->form_validation->set_rules('giro' );
			$this->form_validation->set_rules('colonia' );
			$this->form_validation->set_rules('cp' );
			$this->form_validation->set_rules('calle' );
			$this->form_validation->set_rules('exterior' );
			$this->form_validation->set_rules('interior' );
			$this->form_validation->set_rules('comentario' );
			$this->form_validation->set_rules('fechaCierre' );
			$this->form_validation->set_rules('origen', 'origen del Cliente', 'required');

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
			$asignado         = $user['usuarioID'];
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

				$op['origenCliente'] = $this->prospectos_model->origenCliente(); // Carga Origen del cliente
				$op['estados']       = $this->data_model->estados(); // Carga Estados
				$op['cadena']        = $plaza;

				//Vista//
				$this->layouts->profile('agregarProspectos-view' ,$op);
			}
			else
			{
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

				redirect('prospectos');
			}
		}
	}

	function gracias()
	{
		//Optimizacion y conexion de tags para SEO//
		$opt = $this->uri->segment(1);
		$op['opt'] = $this->data_model->cargarOptimizacion($opt);

		//Carga el javascript para jquery//
		$this->layouts->add_include('assets/js/functions.js');

		//Vista//
		$this->layouts->index('gracias-view' ,$op);
	}

	function usuarios($prospectoID)
	{
		$user = $this->session->userdata('usuario');
  
		//Optimizacion y conexion de tags para SEO//
		$opt = $this->uri->segment(1);
		$op['opt'] = $this->data_model->cargarOptimizacion($opt);
		$id = $this->uri->segment(3);

		$op['zonas']      	= $this->prospectos_model->cargarZonasProspecto($id);
		$op['giros']      	= $this->prospectos_model->cargarGirosProspecto($id);
		$op['perfil']     	= $perfil = $this->prospectos_model->cargarProspectoPerfil($id);
		$op['vendedor']   	= $this->prospectos_model->cargarUsuariosID($user['usuarioID']);
		$op['plazas']     	= $this->data_model->cargaZonas();
		$op['comentario'] 	= $this->data_model->traeconversacion($prospectoID, 6);
		$op['referencias'] 	= $this->prospectos_model->trae_referencias($prospectoID);

		//Carga el javascript para jquery//
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/css/jquery-datepicker.css')
					  ->add_include('assets/css/planogramas.css');

		//Vista//
		$this->layouts->profile('perfil-view' ,$op);
	}
	
	function generar_referencia($prospectoID){
		
		//Optimizacion y conexion de tags para SEO//
		$opt = $this->uri->segment(1);
		$op['opt'] = $this->data_model->cargarOptimizacion($opt);

		$op['plazas']     = $this->data_model->trae_plazas();

		//Carga el javascript para jquery//
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/css/jquery-datepicker.css')
					  ->add_include('assets/css/planogramas.css');

		//Vista//
		$this->layouts->profile('generar_referencia-view' ,$op);
		
	}

	function guardar_referencia_bancaria(){
	
		$user = $this->session->userdata('usuario');
		$plaza_id 	= $this->input->post('plaza');
		$piso		= $this->input->post('plaza_piso');
		$dir		= $this->input->post('plaza_dir');
		$locales	= $this->input->post('locales');
		$locales	= str_replace (" ", "", $locales);
		
		$prospecto_id = $this->input->post('prospecto_id');
		
		$veridicarap = $this->prospectos_model->verifica_rap($plaza_id,$piso,$locales,$dir);
		
		if(!empty($veridicarap)){
			
			$this->session->set_flashdata('msg', '<div class="msgAlert"><img src="../../assets/graphics/alert.png" alt="Alerta" /><p>Ya se genero una referencia con este prospecto para los locales indicados</p></div><br class="clear">', true);
			redirect('prospectos/generar_referencia/'.$prospecto_id,'refresh');
			
		}else{
		
			$temp_plaza_id		= str_pad($plaza_id, 4, "0", STR_PAD_LEFT);
			$temp_prospecto_id 	= str_pad($prospecto_id, 4, "0", STR_PAD_LEFT);
			$date				= date('dmHisY');
			
			$datos_plaza = $this->tempciri_model->traerDatosPLaza($plaza_id);

			$rap = $this->generar_rap($temp_plaza_id.$temp_prospecto_id.$date,$datos_plaza[0]->banco);

			$dat = array(
				'rap'		=> $rap,
				'plaza_id'	=> $plaza_id,
				'piso'		=> $piso,
				'direccion'	=> $dir,
				'locales'	=> $locales
			);
			$this->db->insert('referencias_rap', $dat);
			$rap_id = $this->db->insert_id();
			
			$datRef = array(
				'prospecto_id'	=> $prospecto_id,
				'referencia_id'	=> $rap_id,
				'usuario_id'	=> $user['usuarioID']
			);
			$this->db->insert('prospectos_referencias_rap', $datRef);
			$this->session->set_flashdata('msg', '<div class="msgAlert"><img src="../assets/graphics/alert.png" alt="Alerta" /><p>Se genero la referencia ' . $rap . '</p></div><br class="clear">', true);
			redirect('prospectos/usuarios/'.$prospecto_id);
			
		}
		
	} 

	function borrar($prospectoID, $status){

	$user = $this->session->userdata('usuario');

	$perfil = $this->prospectos_model->cargarProspectoPerfil($prospectoID);
		if ($perfil[0]->usuarioID == $user['usuarioID']){
			$data = array(
	    	    'status' => $status
				);

			$this->db->where('id', $prospectoID);
			$this->db->update('prospectos', $data);

			redirect('prospectos');
		}

		else{
			redirect('ayuda/statusProspecto');
		}

	}

	function cotizar($prospectoID){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		$this->load->model('planogramas/planogramas_model');
		$op['planos']		= $this->planogramas_model->cargarPlanogramas();
		$op['plaza']		= $this->planogramas_model->cargarPlaza();

		$nombre       = $this->input->post('nombre');
		$prospectoID  = $this->input->post('prospectoID');
		$tipo         = $this->input->post('tipo');

		if ($tipo == 'nuevaCotizacion'){
			$data['cotizacion'] = array(
		            'nombre' 		=> $nombre,
		            'prospectoID'	=> $prospectoID,
		            'locales'		=> array()
	      );
	      //guardamos los datos en la sesion
	      $this->session->set_userdata($data);
		}

		$this->layouts->profile('listaPlanogramas-vista.php', $op);
	}

	function cotizarLocal($planoId){

		$cotizacion = $this->session->userdata('cotizacion');

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		// Carga modelos planogramas
		$this->load->model('planogramas/planogramas_model');
		$op['locales']    	= $this->planogramas_model->traerInfoPlano($planoId);
		$op['texto']      	= $this->planogramas_model->cargarTexto($planoId);
		$op['infoPlano']  	= $this->planogramas_model->cargarPlanogramasID($planoId);
		$op['areaPublica']  = $this->planogramas_model->traerAreaPublica($planoId);
		$op['cotizacion']	= $cotizacion;

		$this->layouts->profile('seleccion-cotizar-local',$op);

	}

	function finalizarCotizacion(){

		$cotizacion   = $this->session->userdata('cotizacion');
		$cotizacionID = $this->uri->segment(3);

		if (sizeof($cotizacion['locales']) > 0){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/css/planogramas.css');

			// Carga modelos planogramas
			$cotizacion = $this->session->userdata('cotizacion');
			foreach($cotizacion['locales'] as $locales){
				$vector = $this->data_model->buscarVector($locales);
				$local 	= $this->data_model->buscarSeleccionVicLocal($vector[0]->localID,$vector[0]->id);
				$data[] = $local[0];
			}

			$cotizacion['locales'] = $data;
			$op['cotizacion'] = $cotizacion;

			$this->layouts->profile('finalizar-cotizacion',$op);
		}
		elseif($cotizacionID){
			$user = $this->session->userdata('usuario');
			$op['validada'] = $validada    = $this->prospectos_model->validaCotizacionUsuario($cotizacionID, $user['usuarioID']);

			if(date('Y-m-d') <= $validada[0]->vigencia){
				$op['locales'] = $this->prospectos_model->cargaLocalesCotizacion($cotizacionID);
				$this->layouts->profile('cotizacionPdf-view' ,$op);
			}else{
				redirect('prospectos/cotizaciones');
			}
		}
		else{
			redirect('prospectos');
		}
	}

	function enviarCotizacion(){

		$ids    		= $_POST['ids'];
		$prospectoId	= $_POST['prospectoId'];
		$data	= array();
		$i 		= 1;

		foreach($ids as $id){
			$vector = $this->data_model->buscarVector($id);
			$local 	= $this->data_model->buscarSeleccionVicLocal($vector[0]->localID,$id);
			$data[] = array($i,1,$local[0]->Nombre,$local[0]->precioLocal,$local[0]->precioLocal,0,$local[0]->precioLocal,16,$local[0]->precioLocal*.16,$local[0]->precioLocal*1.16);
			++$i;

		}

		$prospecto = $this->prospectos_model->cargarProspectoPerfil($prospectoId);
		/*
		$header = array('Pos', 'Cantidad', 'Concepto', 'Listado de precios','Sub total','Descueno','Precio sin iva','Impuesto (%)','Impuesto (MXN)','Total');

		$pdf = $this->load->library('pdf');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',14);
		$pdf->FancyTable($header,$data);
		$pdf->Output("cotizacion.pdf","F");
		*/

		$op['locales'] = $data;

		$this->load->helper(array('dompdf', 'file'));
	    // page info here, db calls, etc.
	    $html = $this->load->view('pdf-view', $op, true);
	    $data = pdf_create($html, '', false);
	    write_file(DIRPDF.'name.pdf', $data);

		$this->load->library('email');
		$this->email->set_newline("\r\n");
		$this->email->from('contacto@apeplazas.com', 'APE Plazas Especializadas');
		$this->email->to($prospecto[0]->correo);
		$this->email->subject('Cotización');
				$this->email->message('
					<html>
						<head>
							<title>Cotización</title>
						</head>
						<body>
							<p>Te adjuntamos tu cotización</p>
						</body>
					</html>
				');
		$this->email->attach(DIRPDF.'name.pdf');
		$this->email->send();

		// Carga modelos planogramas
		$cotizacion = $this->session->userdata('cotizacion');
		$user = $this->session->userdata('usuario');

		//Genera la vigencia de la cotizacion
		$hoy = date('Y-m-d H:i:s');
		$vigencia = date('Y-m-d H:i:s', strtotime($hoy . ' + 14 day'));

		$cot = array(
			'prospectoID'	=> $cotizacion['prospectoID'],
			'folio'			=> $this->db->insert_id(),
			'ciudades'		=> 'México, Puebla',
			'vigencia'		=> $vigencia,
			'usuarioID'		=> $user['usuarioID']
		);
		$this->db->insert('prospectoCotizacion', $cot);

		$ultimoID = $this->db->insert_id();
		$folio = str_pad($ultimoID, 6,"0", STR_PAD_LEFT);
		$data = array(
               'folio' => $folio
            );
		$this->db->where('cotizacionID', $ultimoID);
		$this->db->update('prospectoCotizacion', $data);


		foreach($cotizacion['locales'] as $locales){
			$vector = $this->data_model->buscarVector($locales);
			$local 	= $this->data_model->buscarSeleccionVicLocal($vector[0]->localID,$vector[0]->id);

			$contInfo = array(
				'localPrecio'	=> $local[0]->precioLocal,
				'claveLocal'   	=> $local[0]->local,
				'nombreLocal'   => $local[0]->Nombre,
				'cotizacionID'	=> $ultimoID
			);

			$this->db->insert('localesProspectosCotizacion', $contInfo);
		}



        $this->session->unset_userdata('cotizacion');

		redirect('prospectos/cotizaciones');

	}

	function cotizaciones(){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		$user = $this->session->userdata('usuario');
		$prospectoID = $this->uri->segment(3);
		$op['prospectosCotiza'] = $this->prospectos_model->cargarListaCotizaciones($user['usuarioID'], $prospectoID);

		//Vista//
		$this->layouts->profile('cotizaciones-view' ,$op);
	}

	function borrarSessionCotizacion(){
		$this->session->unset_userdata('cotizacion');
		redirect('prospectos');
	}

	function localesCotizadosProspectos(){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.validate.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/js/jquery.steps.js')
					  ->add_include('assets/css/planogramas.css');

		$user = $this->session->userdata('usuario');
		$prospectoID = $this->uri->segment(3);

		$op['perfil'] 	= $perfil = $this->prospectos_model->cargarProspectoPerfil($prospectoID);
		$op['cotizaciones'] = $this->prospectos_model->cargaLocalesCotizadosProspectos($prospectoID);

		$this->layouts->profile('localesCotizadosProspectos-view' ,$op);
	}

	function generarRecibo(){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.validate.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/js/jquery.steps.js')
					  ->add_include('assets/css/planogramas.css');

		$user = $this->session->userdata('usuario');
		$prospectoID = $this->uri->segment(3);

		$op['perfil'] 			= $perfil= $this->prospectos_model->cargarProspectoPerfil($prospectoID);
		$op['cartasIntencion'] 	= $this->prospectos_model->cargarCartasIntencion($prospectoID);
		$op['cotizaciones'] 	= $this->prospectos_model->cargaLocalesCotizadosProspectos($prospectoID);

		$this->layouts->profile('generarRecibo-view' ,$op);
	}

}
