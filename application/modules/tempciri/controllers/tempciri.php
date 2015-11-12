<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tempciri extends MX_Controller {

	function tempciri()
	{
		parent::__construct();
		$this->user_model->checkuser();
		$this->load->model('tempciri/tempciri_model');
		setlocale(LC_MONETARY, 'es_MX');
		if( ! ini_get('date.timezone') ){
		    date_default_timezone_set('America/Mexico_City');
		}
	}

	function index()
	{
		$this->layouts->profile('index-view');
	}

	function ciRi(){

		$this->user_model->checkuserSection();
		$user	= $this->session->userdata('usuario');
		$plaza	= $this->tempciri_model->traerPlazaUsuario($user['usuarioID']);

		if(empty($plaza)){
			echo "No tiene permiso para ingesar a esta página";
			return false;
		}

		$this->layouts->add_include('assets/js/jquery.validate.js')
					  ->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/css/jquery-datepicker.css')
					  ->add_include('assets/js/jquery-datepicker.js');

		$datosGerente		= $this->tempciri_model->traerGerentePLaza($plaza[0]->id);

		$op['plaza'] 		= $plaza[0];
		$op['gerente'] 		= $datosGerente[0]->nombreCompleto;
		$op['user'] 		= $user;
		$op['plazaPisos'] 	= $this->tempciri_model->traerPlazaPisos($plaza[0]->id);
		$this->layouts->profile('ciRi-view',$op);

	}


	function generador(){	
	
		$op 	= array();
		$cots 	= array();
		
		$this->layouts->add_include('assets/js/jquery.form.js');

		$tipoCarta = $_POST['optionsRadios'];

		$op['usuario']	= $this->session->userdata('usuario');
/*
		$cantidad = trim($_POST['adelanto']);
        $xcantidad = str_replace('.', '', $cantidad);
        if (FALSE === ctype_digit($xcantidad)){
        	$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>La cantidad introducida no es válida.</strong></div><br class="clear">');
			redirect("tempciri/ciRi/");
			return false;
        }
*/

		$op['rentanLocalLetra']	= num_to_letras($_POST['rentaMensual']);
		$op['rentaCant']		= $_POST['rentaMensual'];
		$op['rentaDeposito']	= $_POST['rentaMensual']*1.16;
		$op['local']			= $_POST['localnum'];

		$op['clientrfc']		= $_POST['clientrfc'];
		$op['clientEmail']		= $_POST['clientEmail'];
		$op['clientetelefono']	= $_POST['clientetelefono'];
		$op['clientNom']		= preg_replace('/\s+/',' ',$_POST['cpnombre'] . ' ' . $_POST['csnombre'] . ' ' . $_POST['capaterno'] . ' ' . $_POST['camaterno']);

		$op['vendedorNombre']	= $_POST['vendedorNombre'];

		$op['crednum']			= $_POST['folioident'];
		$op['rentmes']			= $_POST['mes'];
		$op['rentduracion']		= $_POST['contratotiempo'];
		$op['remnumcuenta']		= $_POST['devCuenta'];
		$op['rembanco']			= $_POST['devBanco'];
		$op['fecha']			= date('d/m/Y');

		$op['rentaDepositoLet']	= num_to_letras($op['rentaDeposito']);
		$op['plaza']			= $_POST['plazaNombre'];
		$op['dirplaza']			= $_POST['dirplaza'];
		$op['plazaPiso']		= $_POST['plazaPiso'];
		$op['diasGracia']		= $_POST['diasGracia'];



		if(!$_POST['clienteId']){

			$info = array(
				'pnombre'			=> $_POST['cpnombre'],
				'rfc'				=> $_POST['clientrfc'],
				'telefono'			=> $_POST['clientetelefono'],
				'snombre'			=> $_POST['csnombre'],
				'email'				=> $_POST['clientEmail'],
				'tipo'				=> $_POST['clienteTipo'],
				'fechaNacimiento'	=> date('Y-m-d', strtotime($_POST['clienteFecha'])),
				'apellidopaterno'   => $_POST['capaterno'],
				'apellidomaterno'   => $_POST['camaterno']
			);
			$this->db->insert('TEMPORA_CLIENTES', $info);
			$clienteId = $this->db->insert_id();

		}else{

			$clienteId = $_POST['clienteId'];

		}
/*
		if( empty($_FILES['documentoPago']['name']) || empty($_FILES['documentoIdentifi']['name']) ){

			$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Favor de ingresar los documentos.</strong></div><br class="clear">');
			redirect("tempciri/ciRi/");
			return false;
		}
*/
		//Validar que se agregue al menos un recibo de deposito con datos
		if( ( !isset($_POST['depositos']) && !isset($_POST['traspaso']) && !isset($_POST['terminal']) ) || 
			( isset($_POST['depositos']) && ( empty($_POST['depositos']['cuenta'][0]) || empty($_POST['depositos']['numero'][0]) || empty($_POST['depositos']['fecha'][0]) || empty($_POST['depositos']['movimiento'][0]) || empty($_POST['depositos']['importe'][0]) 
											) 
			) || 
			( isset($_POST['terminal']) && ( empty($_POST['terminal']['digitos'][0]) || empty($_POST['terminal']['numero'][0]) || empty($_POST['terminal']['fecha'][0]) || empty($_POST['terminal']['importe'][0])
											) 
			) || 
			( isset($_POST['traspaso']) && ( empty($_POST['traspaso']['cuenta'][0]) || empty($_POST['traspaso']['digitos'][0]) || empty($_POST['traspaso']['fecha'][0]) || empty($_POST['traspaso']['numero'][0]) || empty($_POST['traspaso']['importe'][0]) || empty($_POST['traspaso']['clave'][0])  
											) 
			)									
			){
				
			$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Favor de ingresar Recibos de deposito.</strong></div><br class="clear">');
			redirect("tempciri/ciRi/");
			return false;
			
		}
		
		//Validar que ingresaron al menos un archivo para los depositos	
		if( ( !isset($_FILES['depositos']) && !isset($_FILES['traspaso']) && !isset($_FILES['terminal']) ) ){
			
			$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Favor de ingresar archivos del deposito.</strong></div><br class="clear">');
			redirect("tempciri/ciRi/");
			return false;
			
		}

		//Validar archivos
		$permitidos =  array('gif','png','jpg','pdf');

		//$extArchivo1 = pathinfo($_FILES['documentoPago']['name'], PATHINFO_EXTENSION);
		$extArchivo2 = pathinfo($_FILES['documentoIdentifi']['name'], PATHINFO_EXTENSION);
		$extArchivo3 = '';

		if( !in_array($extArchivo2,$permitidos) ) {
			$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Favor de ingresar archivos válidos.</strong></div><br class="clear">');
			redirect("tempciri/ciRi/");
			return false;

		}

		if(!empty($_FILES['documentoEstadoCuenta']['name'])){

			$extArchivo3 = pathinfo($_FILES['documentoEstadoCuenta']['name'], PATHINFO_EXTENSION);
			if( !in_array($extArchivo3,$permitidos) ){

				$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Favor de ingresar archivos válidos.</strong></div><br class="clear">');
				redirect("tempciri/ciRi/");
				return false;

			}

		}

		$checkRef		= $this->tempciri_model->checkRefCi($_POST['clientrfc'],$op['plaza'],$op['local'],$op['dirplaza'],$op['plazaPiso']);
		if(!empty($checkRef) && sizeof($checkRef) >= 3){
			$this->session->set_flashdata("msg","<div class='msgFlash'>
				<img src='http://www.apeplazas.com/obras/assets/graphics/alerta.png' alt='Alerta'>
				<strong>El cliente " . $op['clientNom'] . ' ya ha generado tres documetos para la plaza ' . $op['plaza'] . ' por el local ' . $op['local'] .
				"</strong>
			</div>
			<br class='clear'>");
			redirect("tempciri/ciRi/");
			return false;
		}

		$datosGerente		= $this->tempciri_model->traerGerentePLaza($_POST['plazaId']);
		$op['gerente']		= $datosGerente[0]->nombreCompleto;
		$op['folioCompro']	= $_POST['folioDoc'];
		$plazaDatos 		= $this->tempciri_model->traerDatosPLaza($op['plaza']);
		$op['folioDoc']		= $plazaDatos[0]->ci_num + 1;
		$this->db->where('plaza', $op['plaza']);
		$this->db->update('TEMPORA_PLAZA', array('ci_num'=>$op['folioDoc']));

		$info = array(
				'folio'				=> $op['folioDoc'],
				'plaza'				=> $op['plaza'],
				'gerentePlaza'		=> $op['gerente'],
				'clienteId'			=> $clienteId,
				'vendedorNombre'	=> $op['vendedorNombre'],
				'folioComprobante'	=> $op['folioCompro'],
				'usuarioId'       	=> $op['usuario']['usuarioID'],
				'ifeFolio'        	=> $op['crednum'],
				'deposito'        	=> 0,
				'diasGracia'		=> $op['diasGracia'],
				'contraroInicioMes' => $op['rentmes'],
				'contratoDuracion'  => $op['rentduracion'],
				'devolucionCuenta'	=> $op['remnumcuenta'],
				'devolucionBanco'   => $op['rembanco']
		);
		$this->db->insert('TEMPORA_CI', $info);
		$cartaIntId = $this->db->insert_id();

		$rentaDatos = array(
				'plazaId'			=> $op['plaza'],
				'clienteId'			=> $clienteId,
				'ciId'				=> $cartaIntId,
				'renta'				=> $op['rentaCant'],
				'local'				=> $op['local'],
				'piso'				=> $op['plazaPiso'],
				'dir'        		=> $op['dirplaza']
		);
		$this->db->insert('TEMPORA_PLAZA_RENTAS', $rentaDatos);

		$this->db->where('id', $cartaIntId);
		$this->db->update('TEMPORA_CI', array('pdf'=>$cartaIntId.'_CI.pdf'));
/*
		//Insertar archivo comprobante de pago
		$archivoNombre	= 'CI_'.$cartaIntId.'_compPago.'.$extArchivo1;
		$archivoTipo	= $_FILES['documentoPago']['type'];
		$tamanoH		= $_FILES['documentoPago']['size'];

		move_uploaded_file($_FILES['documentoPago']['tmp_name'],DIRCIDOCS.$archivoNombre);
		$data = array(
			'ciId'			=> $cartaIntId,
			'docTipo'		=> 'comprobantePago',
			'archivoNombre'	=> $archivoNombre
		);
		$this->db->insert('TEMPORA_CI_ARCHIVOS', $data);
*/


		$cantidad = 0;

		//Insertar archivos de deposito en caso de que existan
		if( isset($_FILES['depositos']) && sizeof($_FILES['depositos']['name']['comprobante']) > 0 ){
			
			foreach($_FILES['depositos']['name']['comprobante'] as $key => $val){
				
				$num 			= $key + 1;
				$extArchivo 	= pathinfo($_FILES['depositos']['name']['comprobante'][$key], PATHINFO_EXTENSION);
				$archivoNombre	= "CI_".$cartaIntId."_compPagoDep$num.".$extArchivo;
				$archivoTipo	= $_FILES['depositos']['type']['comprobante'][$key];
				$tamanoH		= $_FILES['depositos']['size']['comprobante'][$key];
				
		
				move_uploaded_file($_FILES['depositos']['tmp_name']['comprobante'][$key],DIRCIDOCS.$archivoNombre);
				$data = array(
					'ciId'			=> $cartaIntId,
					'reciboTipo'	=> 'depositos',
					'cuenta'		=> $_POST['depositos']['cuenta'][$key],
					'numero'		=> $_POST['depositos']['numero'][$key],
					'fecha'			=> $_POST['depositos']['fecha'][$key],
					'movimiento'	=> $_POST['depositos']['movimiento'][$key],
					'importe'		=> $_POST['depositos']['importe'][$key],
					'archivo'		=> $archivoNombre
				);
				$this->db->insert('TEMPORA_CI_DETALLE_DEPOSITOS', $data);
				
				$cantidad += $_POST['depositos']['importe'][$key];	
				
			}
			
		}

		//Insertar archivos de deposito en terminal en caso de que existan
		if( isset($_FILES['terminal']) && sizeof($_FILES['terminal']['name']['comprobante']) > 0 ){
			
			foreach($_FILES['terminal']['name']['comprobante'] as $key => $val){
				
				$num 			= $key + 1;
				$extArchivo 	= pathinfo($_FILES['terminal']['name']['comprobante'][$key], PATHINFO_EXTENSION);
				$archivoNombre	= "CI_".$cartaIntId."_compPagoTer$num.".$extArchivo;
				$archivoTipo	= $_FILES['terminal']['type']['comprobante'][$key];
				$tamanoH		= $_FILES['terminal']['size']['comprobante'][$key];
				
		
				move_uploaded_file($_FILES['terminal']['tmp_name']['comprobante'][$key],DIRCIDOCS.$archivoNombre);
				$data = array(
					'ciId'			=> $cartaIntId,
					'reciboTipo'	=> 'terminal',
					'digitos'		=> $_POST['terminal']['digitos'][$key],
					'numero'		=> $_POST['terminal']['numero'][$key],
					'fecha'			=> $_POST['terminal']['fecha'][$key],
					'importe'		=> $_POST['terminal']['importe'][$key],
					'archivo'		=> $archivoNombre
				);
				$this->db->insert('TEMPORA_CI_DETALLE_DEPOSITOS', $data);	
				
				$cantidad += $_POST['terminal']['importe'][$key];
				
			}
			
		}
		
		//Insertar archivos de deposito spei (traspaso) en caso de que existan
		if( isset($_FILES['traspaso']) && sizeof($_FILES['traspaso']['name']['comprobante']) > 0 ){
			
			foreach($_FILES['traspaso']['name']['comprobante'] as $key => $val){
				
				$num 			= $key + 1;
				$extArchivo 	= pathinfo($_FILES['traspaso']['name']['comprobante'][$key], PATHINFO_EXTENSION);
				$archivoNombre	= "CI_".$cartaIntId."_compPagoTrasp$num.".$extArchivo;
				$archivoTipo	= $_FILES['traspaso']['type']['comprobante'][$key];
				$tamanoH		= $_FILES['traspaso']['size']['comprobante'][$key];
				
		
				move_uploaded_file($_FILES['traspaso']['tmp_name']['comprobante'][$key],DIRCIDOCS.$archivoNombre);
				$data = array(
					'ciId'			=> $cartaIntId,
					'reciboTipo'	=> 'traspaso',
					'cuenta'		=> $_POST['traspaso']['cuenta'][$key],
					'digitos'		=> $_POST['traspaso']['digitos'][$key],
					'fecha'			=> $_POST['traspaso']['fecha'][$key],
					'numero'		=> $_POST['traspaso']['numero'][$key],
					'clave'			=> $_POST['traspaso']['clave'][$key],
					'importe'		=> $_POST['traspaso']['importe'][$key],
					'archivo'		=> $archivoNombre
				);
				$this->db->insert('TEMPORA_CI_DETALLE_DEPOSITOS', $data);	
				
				$cantidad += $_POST['traspaso']['importe'][$key];
				
			}
			
		}

		$op['rentant']			= $cantidad;
		$op['depositoLetra'] 	= num_to_letras($cantidad);
		
		$this->db->where('id', $cartaIntId);
		$this->db->update('TEMPORA_CI', array('deposito'=>$cantidad));
		

		//Insertar archivo idenfiticacion
		$archivoNombre	= 'CI_'.$cartaIntId.'_identif.'.$extArchivo2;
		$archivoTipo	= $_FILES['documentoIdentifi']['type'];
		$tamanoH		= $_FILES['documentoIdentifi']['size'];


		move_uploaded_file($_FILES['documentoIdentifi']['tmp_name'],DIRCIDOCS.$archivoNombre);
		$data = array(
			'ciId'				=> $cartaIntId,
			'docTipo'			=> 'identificacionCliente',
			'archivoNombre'		=> $archivoNombre
		);
		$this->db->insert('TEMPORA_CI_ARCHIVOS', $data);

		if(!empty($_FILES['documentoEstadoCuenta']['name'])){
			//Insertar archivo idenfiticacion
			$archivoNombre	= 'CI_'.$cartaIntId.'_estadoCuenta.'.$extArchivo2;
			$archivoTipo	= $_FILES['documentoEstadoCuenta']['type'];
			$tamanoH		= $_FILES['documentoEstadoCuenta']['size'];


		   	move_uploaded_file($_FILES['documentoEstadoCuenta']['tmp_name'],DIRCIDOCS.$archivoNombre);
		   	$data = array(
		   		'ciId'				=> $cartaIntId,
		   		'docTipo'			=> 'estadoCuenta',
		   		'archivoNombre'		=> $archivoNombre
			);
			$this->db->insert('TEMPORA_CI_ARCHIVOS', $data);
		}

		$this->load->helper(array('dompdf', 'file'));
		// page info here, db calls, etc.
		$html = $this->layouts->loadpdf('carta-intencion', $op,'pdf_print', true);
		$data = pdf_create($html, '', false);

		write_file(DIRPDF.'CI_'.$cartaIntId.'.pdf', $data);


		$op['documentoId']	= $cartaIntId;
		$op['op']			= $op;

		//Vista//
		$this->layouts->pdf('apartado-view',$op);

	}

	function cancelarCi(){

		$this->user_model->checkuserSection();
		$user		= $this->session->userdata('usuario');
		$ciId		= $this->uri->segment(3);

		$valid = $this->user_model->verificarCiProp($user['usuarioID'],$ciId);
		if( empty($valid) ){
			echo "Acceso Denegado";
			return false;
		}
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		$op['ci'] 	= $this->tempciri_model->traerDatosCi($ciId);

		$this->layouts->profile('deleteCi-view' ,$op);

	}

	function cancelarRi(){

		$user		= $this->session->userdata('usuario');
		$riId		= $this->uri->segment(3);

		$valid = $this->user_model->verificarRiProp($user['usuarioID'],$riId);
		if( empty($valid) ){
			echo "Acceso Denegado";
			return false;
		}
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		$op['ri'] 	= $this->tempciri_model->traerDatosCi($riId);

		$this->layouts->profile('deleteRi-view' ,$op);

	}

	function functionCancelarRi(){

		$riId	= $_POST['riId'];
		$motivo = $_POST['motivoCancelacion'];
		$devo	= isset($_POST['devolucionOn']) ? $_POST['devolucionOn'] : '';

		if(empty($motivo)){

			$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Favor de ingresar motivo de cancelación.</strong></div><br class="clear">');
			redirect("tempciri/cancelarRi/" . $riId);
			return false;

		}

		if(isset($devo) && $devo && empty($_FILES['fichaDevolucion']['name'])){

			$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Favor de ingresar la ficha de devolución.</strong></div><br class="clear">');
			redirect("tempciri/cancelarCi/" . $riId);
			return false;

		}elseif(isset($devo) && $devo){

			$permitidos =  array('gif','png','jpg','pdf');

			$archivoNombre	= $_FILES['fichaDevolucion']['name'];
			$archivoTipo	= $_FILES['fichaDevolucion']['type'];
			$tamanoH		= $_FILES['fichaDevolucion']['size'];

			$ext = pathinfo($archivoNombre, PATHINFO_EXTENSION);

			if(in_array($ext,$permitidos) ) {

		   		move_uploaded_file($_FILES['fichaDevolucion']['tmp_name'],DIRFICHASDEV.$archivoNombre);
		   		$data = array(
		   			'riId'			=> $riId,
		   			'fichaNombre'	=> $archivoNombre
				);

				$this->db->insert('TEMPORA_RI_FICHAS_DEVOLUCION', $data);
				$fichadevId = $this->db->insert_id();


			}else{

				$this->session->set_flashdata('msg','<div class="msg mt20 mb20">Favor de Ingresar un Formato valido.</div>');
				redirect("tempciri/cancelarCi/" . $riId);
				return false;

			}

		}

		$RiData	= $this->tempciri_model->traerDatosRi($riId);

		$op['vendedorNombre']	= $RiData[0]->vendedorNombre;
		$op['observaciones']	= $RiData[0]->observaciones;

		$op['refCi']			= (!empty($RiData[0]->ciId)) ? $RiData[0]->ciId : null;
		$op['depositoCi']		= (!empty($RiData[0]->depositoCi)) ? $RiData[0]->depositoCi : null;
		$op['depositoLetra'] 	= num_to_letras($RiData[0]->deposito);

		$op['rentanLocalLetra']	= num_to_letras($RiData[0]->renta);
		$op['rentaCant']		= $RiData[0]->renta;
		$op['rentaDeposito']	= $RiData[0]->renta*1.16;
		$op['local']			= $RiData[0]->local;

		$op['clientrfc']		= $RiData[0]->rfc;
		$op['clientEmail']		= $RiData[0]->email;
		$op['clientetelefono']	= $RiData[0]->telefono;
		$op['clientNom']		= preg_replace('/\s+/',' ',$RiData[0]->pnombre . ' ' . $RiData[0]->snombre . ' ' . $RiData[0]->apellidopaterno . ' ' . $RiData[0]->apellidomaterno);

		$op['crednum']			= $RiData[0]->rfc;
		$op['rentmes']			= $RiData[0]->contratoInicio;
		$op['rentduracion']		= $RiData[0]->contratoDuracion;
		$op['rentant']			= $RiData[0]->deposito;
		$op['fecha']			= date('d/m/Y', strtotime($RiData[0]->fecha));

		$op['rentaDepositoLet']	= num_to_letras($op['rentaDeposito']);
		$op['plaza']			= $RiData[0]->plazaNombre;
		$op['dirplaza']			= $RiData[0]->dir;
		$op['diasGracia']		= $RiData[0]->diasGracia;

		$op['folioDoc']		= $RiData[0]->folio;

		$op['cancelarDoc']		= true;

		$this->load->helper(array('dompdf', 'file'));
		// page info here, db calls, etc.
		$html = $this->layouts->loadpdf('recibo-interno', $op,'pdf_print', true);
		$data = pdf_create($html, '', false);

		write_file(DIRPDF.'RI_'.$riId.'.pdf', $data);

		$this->db->where('id', $riId);
		$this->db->update('TEMORA_RI', array('estado'=>'cancelado','motivoCancelacion'=>$motivo));
		redirect("tempciri/verRi");

	}

	function functionCancelarCi(){

		$ciId	= $_POST['ciId'];
		$motivo = $_POST['motivoCancelacion'];

		if(empty($motivo)){

			$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Favor de ingresar motivo de cancelación.</strong></div><br class="clear">');
			redirect("tempciri/cancelarCi/" . $ciId);
			return false;

		}

		$CiData	= $this->tempciri_model->traerDatosCi($ciId);

		$op['depositoLetra'] 	= num_to_letras($CiData[0]->deposito);
		$op['vendedorNombre']	= $CiData[0]->vendedorNombre;

		$op['rentanLocalLetra']	= num_to_letras($CiData[0]->renta);
		$op['rentaCant']		= $CiData[0]->renta;
		$op['rentaDeposito']	= $CiData[0]->renta*1.16;
		$op['local']			= $CiData[0]->local;

		$op['clientrfc']		= $CiData[0]->rfc;
		$op['clientEmail']		= $CiData[0]->email;
		$op['clientetelefono']	= $CiData[0]->telefono;
		$op['clientNom']		= preg_replace('/\s+/',' ',$CiData[0]->pnombre . ' ' . $CiData[0]->snombre . ' ' . $CiData[0]->apellidopaterno . ' ' . $CiData[0]->apellidomaterno);

		$op['crednum']			= $CiData[0]->rfc;
		$op['rentmes']			= $CiData[0]->contraroInicioMes;
		$op['rentduracion']		= $CiData[0]->contratoDuracion;
		$op['rentant']			= $CiData[0]->deposito;
		$op['remnumcuenta']		= $CiData[0]->devolucionCuenta;
		$op['rembanco']			= $CiData[0]->devolucionBanco;
		$op['fecha']			= date('d/m/Y', strtotime($CiData[0]->fecha));

		$op['rentaDepositoLet']	= num_to_letras($op['rentaDeposito']);
		$op['plaza']			= $CiData[0]->plazaNombre;
		$op['dirplaza']			= $CiData[0]->dir;
		$op['diasGracia']		= $CiData[0]->diasGracia;

		$op['gerente']		= $CiData[0]->gerentePlaza;
		$op['folioCompro']	= $CiData[0]->folioComprobante;
		$op['folioDoc']		= $CiData[0]->folio;

		$op['cancelarDoc']		= true;

		$this->load->helper(array('dompdf', 'file'));
		// page info here, db calls, etc.
		$html = $this->layouts->loadpdf('carta-intencion', $op,'pdf_print', true);
		$data = pdf_create($html, '', false);

		write_file(DIRPDF.'CI_'.$ciId.'.pdf', $data);

		$this->db->where('id', $ciId);
		$this->db->update('TEMPORA_CI', array('estado'=>'cancelado','motivoCancelacion'=>$motivo));
		redirect("tempciri/verCi");

	}

	function devolucionCi(){
		
		$user		= $this->session->userdata('usuario');
		$ciId		= $this->uri->segment(3);

		$valid = $this->user_model->verificarCiProp($user['usuarioID'],$ciId);
		if( empty($valid) ){
			echo "Acceso Denegado";
			return false;
		}
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		$op['ci'] 	= $this->tempciri_model->traerDatosCi($ciId);

		$this->layouts->profile('devolucionCi-view' ,$op);
		
	}
	
	function funtiondevolucionCi(){
		
		$ciId	= $_POST['ciId'];
		$motivo = $_POST['motivoCancelacion'];
		$devo	= isset($_POST['devolucionOn']) ? $_POST['devolucionOn'] : '';

		if(empty($motivo)){

			$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Favor de ingresar motivo de cancelación.</strong></div><br class="clear">');
			redirect("tempciri/cancelarCi/" . $ciId);
			return false;

		}

		if(isset($devo) && $devo && empty($_FILES['fichaDevolucion']['name'])){

			$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Favor de ingresar la ficha de devolución.</strong></div><br class="clear">');
			redirect("tempciri/cancelarCi/" . $ciId);
			return false;

		}elseif(isset($devo) && $devo){

			$permitidos =  array('gif','png','jpg','pdf');

			$archivoNombre	= $_FILES['fichaDevolucion']['name'];
			$archivoTipo	= $_FILES['fichaDevolucion']['type'];
			$tamanoH		= $_FILES['fichaDevolucion']['size'];

			$ext = pathinfo($archivoNombre, PATHINFO_EXTENSION);

			if(in_array($ext,$permitidos) ) {

		   		move_uploaded_file($_FILES['fichaDevolucion']['tmp_name'],DIRFICHASDEV.$archivoNombre);
		   		$data = array(
		   			'ciId'			=> $ciId,
		   			'fichaNombre'	=> $archivoNombre
				);

				$this->db->insert('TEMPORA_CI_FICHAS_DEVOLUCION', $data);
				$fichadevId = $this->db->insert_id();


			}else{

				$this->session->set_flashdata('msg','<div class="msg mt20 mb20">Favor de Ingresar un Formato valido.</div>');
				redirect("tempciri/cancelarCi/" . $ciId);
				return false;

			}

		}

		$CiData	= $this->tempciri_model->traerDatosCi($ciId);

		$op['depositoLetra'] 	= num_to_letras($CiData[0]->deposito);
		$op['vendedorNombre']	= $CiData[0]->vendedorNombre;

		$op['rentanLocalLetra']	= num_to_letras($CiData[0]->renta);
		$op['rentaCant']		= $CiData[0]->renta;
		$op['rentaDeposito']	= $CiData[0]->renta*1.16;
		$op['local']			= $CiData[0]->local;

		$op['clientrfc']		= $CiData[0]->rfc;
		$op['clientEmail']		= $CiData[0]->email;
		$op['clientetelefono']	= $CiData[0]->telefono;
		$op['clientNom']		= preg_replace('/\s+/',' ',$CiData[0]->pnombre . ' ' . $CiData[0]->snombre . ' ' . $CiData[0]->apellidopaterno . ' ' . $CiData[0]->apellidomaterno);

		$op['crednum']			= $CiData[0]->rfc;
		$op['rentmes']			= $CiData[0]->contraroInicioMes;
		$op['rentduracion']		= $CiData[0]->contratoDuracion;
		$op['rentant']			= $CiData[0]->deposito;
		$op['remnumcuenta']		= $CiData[0]->devolucionCuenta;
		$op['rembanco']			= $CiData[0]->devolucionBanco;
		$op['fecha']			= date('d/m/Y', strtotime($CiData[0]->fecha));

		$op['rentaDepositoLet']	= num_to_letras($op['rentaDeposito']);
		$op['plaza']			= $CiData[0]->plazaNombre;
		$op['dirplaza']			= $CiData[0]->dir;
		$op['diasGracia']		= $CiData[0]->diasGracia;

		$op['gerente']		= $CiData[0]->gerentePlaza;
		$op['folioCompro']	= $CiData[0]->folioComprobante;
		$op['folioDoc']		= $CiData[0]->folio;

		$op['cancelarDoc']		= true;

		$this->load->helper(array('dompdf', 'file'));
		// page info here, db calls, etc.
		$html = $this->layouts->loadpdf('carta-intencion', $op,'pdf_print', true);
		$data = pdf_create($html, '', false);

		write_file(DIRPDF.'CI_'.$ciId.'.pdf', $data);

		$this->db->where('id', $ciId);
		$this->db->update('TEMPORA_CI', array('estado'=>'cancelado','motivoCancelacion'=>$motivo));
		redirect("tempciri/verCi");
		
	}

	function verCi(){

		$this->user_model->checkuserSection();
		$user		= $this->session->userdata('usuario');
		$op['cis'] 	= $this->tempciri_model->cargarCis($user['usuarioID']);

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.form.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		//Vista//
		$this->layouts->profile('cis-view' ,$op);

	}
	
	function detalleCis(){
		
		$this->user_model->checkuserSection();
		$op['cis'] 	= $this->tempciri_model->cargarTodoCis();

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.form.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		//Vista//
		$this->layouts->profile('detalleCis-view' ,$op);
		
	}
	
	function detalleCi(){
		
		$this->user_model->checkuserSection();
		$ciId		= $this->uri->segment(3);

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		$op['ci'] 	= $this->tempciri_model->traerDatosCi($ciId);
		$this->layouts->profile('detalleCi-view' ,$op);
		
	}

	function verRi(){

		$user		= $this->session->userdata('usuario');
		$op['ris'] 	= $this->tempciri_model->cargarRis($user['usuarioID']);

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		//Vista//
		$this->layouts->profile('ris-view' ,$op);

	}

}

?>
