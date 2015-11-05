<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tempciri extends MX_Controller {

	function tempciri()
	{
		parent::__construct();
		//$this->user_model->checkuser();
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

		$user	= $this->session->userdata('usuario');
		$plaza	= $this->tempciri_model->traerPlazaUsuario($user['usuarioID']);

		if(empty($plaza)){
			echo "No tiene permiso para ingesar a esta página";
			return false;
		}

		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/css/jquery-datepicker.css')
					  ->add_include('assets/js/jquery-datepicker.js');

		$op['plaza'] 		= $plaza[0];
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

		$cantidad = trim($_POST['adelanto']);
        $xcantidad = str_replace('.', '', $cantidad);
        if (FALSE === ctype_digit($xcantidad)){
        	$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>La cantidad introducida no es válida.</strong></div><br class="clear">');
			redirect("tempciri/ciRi/");
			return false;
        }

		$op['refCi']			= (isset($_POST['refCi'])) ? $_POST['refCi'] : null;

        $op['depositoLetra'] 	= num_to_letras($cantidad);

		if(!$op['refCi']){

			$op['rentanLocalLetra']	= num_to_letras($_POST['rentaMensual']);
			$op['rentaCant']		= $_POST['rentaMensual'];
			$op['rentaDeposito']	= $_POST['rentaMensual']*1.16;
			$op['local']			= $_POST['localnum'];

			$op['clientrfc']		= $_POST['clientrfc'];
			$op['clientEmail']		= $_POST['clientEmail'];
			$op['clientetelefono']	= $_POST['clientetelefono'];
			$op['clientNom']		= preg_replace('/\s+/',' ',$_POST['cpnombre'] . ' ' . $_POST['csnombre'] . ' ' . $_POST['capaterno'] . ' ' . $_POST['camaterno']);

		}else{

			$previewData	= $this->tempciri_model->traerDatosCi($op['refCi']);

			$op['rentanLocalLetra']	= num_to_letras($previewData[0]->renta);
			$op['rentaCant']		= $previewData[0]->renta;
			$op['rentaDeposito']	= $previewData[0]->renta*1.16;
			$op['local']			= $previewData[0]->local;
			$op['depositoCi']		= $previewData[0]->deposito;

			$op['clientrfc']		= $previewData[0]->rfc;
			$op['clientEmail']		= $previewData[0]->email;
			$op['clientetelefono']	= $previewData[0]->telefono;
			$op['clientNom']		= preg_replace('/\s+/',' ',$previewData[0]->pnombre . ' ' . $previewData[0]->snombre . ' ' . $previewData[0]->apellidopaterno . ' ' . $previewData[0]->apellidomaterno);

		}

		$op['vendedorNombre']	= $_POST['vendedorNombre'];

		$op['crednum']			= $_POST['folioident'];
		$op['rentmes']			= $_POST['mes'];
		$op['rentduracion']		= $_POST['contratotiempo'];
		$op['rentant']			= $_POST['adelanto'];
		$op['remnumcuenta']		= $_POST['devCuenta'];
		$op['rembanco']			= $_POST['devBanco'];
		$op['fecha']			= date('d/m/Y');

		$op['rentaDepositoLet']	= num_to_letras($op['rentaDeposito']);
		$op['plaza']			= $_POST['plazaNombre'];
		$op['dirplaza']			= $_POST['dirplaza'];
		$op['plazaPiso']			= $_POST['plazaPiso'];
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

		if( empty($_FILES['documentoPago']['name']) || empty($_FILES['documentoIdentifi']['name']) ){

			$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Favor de ingresar los documentos.</strong></div><br class="clear">');
			redirect("tempciri/ciRi/");
			return false;
		}

		//Validar archivos
		$permitidos =  array('gif','png','jpg','pdf');

		$extArchivo1 = pathinfo($_FILES['documentoPago']['name'], PATHINFO_EXTENSION);
		$extArchivo2 = pathinfo($_FILES['documentoIdentifi']['name'], PATHINFO_EXTENSION);
		$extArchivo3 = '';

		if( !in_array($extArchivo1,$permitidos) || !in_array($extArchivo2,$permitidos) ) {

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

		if($tipoCarta == 'cartaintencion'){

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

			$op['gerente']		= $_POST['gerente'];
			$op['folioCompro']	= $_POST['folioDoc'];
			$plazaDatos 		= $this->tempciri_model->traerDatosPLaza($op['plaza']);
			$op['folioDoc']		= $plazaDatos[0]->ci_num + 1;
			$this->db->where('plaza', $op['plaza']);
			$this->db->update('TEMPORA_PLAZA', array('ci_num'=>$op['folioDoc']));

			$info = array(
					'folio'				=> $op['folioDoc'],
					'plaza'				=> $op['plaza'],
					'clienteId'			=> $clienteId,
					'vendedorNombre'	=> $op['vendedorNombre'],
					'folioComprobante'	=> $op['folioCompro'],
					'usuarioId'       	=> $op['usuario']['usuarioID'],
					'ifeFolio'        	=> $op['crednum'],
					'deposito'        	=> $cantidad,
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

		}else{

			$checkRef		= $this->tempciri_model->checkRefRi($op['clientrfc'],$op['plaza'],$op['local']);
			if(!empty($checkRef) && sizeof($checkRef) >= 2){
				echo 'El cliente ' . $op['clientNom'] . ' ya ha generado dos documetos para la plaza ' . $op['plaza'] . ' por el local ' . $op['local'];
				return false;
			}

			$op['observaciones']	= $_POST['observaciones'];
			$plazaDatos 		= $this->tempciri_model->traerDatosPLaza($op['plaza']);
			$op['folioDoc']		= $plazaDatos[0]->ri_num + 1;
			$this->db->where('plaza', $op['plaza']);
			$this->db->update('TEMPORA_PLAZA', array('ri_num'=>$op['folioDoc']));

			$info = array(
					'clienteId'			=> $clienteId,
					'usuarioId'       	=> $op['usuario']['usuarioID'],
					'vendedorNombre'	=> $op['vendedorNombre'],
					'folio'				=> $op['folioDoc'],
					'deposito'        	=> $cantidad,
					'contratoInicio' 	=> $op['rentmes'],
					'contratoDuracion'  => $op['rentduracion'],
					'diasGracia'		=> $op['diasGracia'],
					'observaciones'		=> $op['observaciones']
			);
			$this->db->insert('TEMORA_RI', $info);
			$reciboIntId = $this->db->insert_id();

			$this->db->where('id', $reciboIntId);
			$this->db->update('TEMORA_RI', array('pdf'=>$reciboIntId.'_RI.pdf'));

			if(!$op['refCi']){

				$rentaDatos = array(
					'plazaId'			=> $op['plaza'],
					'clienteId'			=> $clienteId,
					'riId'				=> $reciboIntId,
					'renta'				=> $op['rentaCant'],
					'local'				=> $op['local'],
					'dir'        		=> $op['dirplaza']
				);
				$this->db->insert('TEMPORA_PLAZA_RENTAS', $rentaDatos);

			}else{

				$this->db->where('ciId', $op['refCi']);
				$this->db->update('TEMPORA_PLAZA_RENTAS', array('riId'=>$reciboIntId));

			}

			//Insertar archivo comprobante de pago
			$archivoNombre	= 'RI_'.$reciboIntId.'_compPago.'.$extArchivo1;
			$archivoTipo	= $_FILES['documentoPago']['type'];
			$tamanoH		= $_FILES['documentoPago']['size'];

		   	move_uploaded_file($_FILES['documentoPago']['tmp_name'],DIRRIDOCS.$archivoNombre);
		   	$data = array(
		   		'riId'			=> $reciboIntId,
		   		'docTipo'		=> 'comprobantePago',
		   		'archivoNombre'	=> $archivoNombre
			);
			$this->db->insert('TEMPORA_RI_ARCHIVOS', $data);

			//Insertar archivo idenfiticacion
			$archivoNombre	= 'RI_'.$reciboIntId.'_identif.'.$extArchivo2;
			$archivoTipo	= $_FILES['documentoIdentifi']['type'];
			$tamanoH		= $_FILES['documentoIdentifi']['size'];


		   	move_uploaded_file($_FILES['documentoIdentifi']['tmp_name'],DIRRIDOCS.$archivoNombre);
		   	$data = array(
		   		'riId'				=> $reciboIntId,
		   		'docTipo'			=> 'identificacionCliente',
		   		'archivoNombre'		=> $archivoNombre
			);
			$this->db->insert('TEMPORA_RI_ARCHIVOS', $data);

			if(!empty($_FILES['documentoEstadoCuenta']['name'])){
				//Insertar archivo idenfiticacion
				$archivoNombre	= 'RI_'.$reciboIntId.'_estadoCuenta.'.$extArchivo2;
				$archivoTipo	= $_FILES['documentoEstadoCuenta']['type'];
				$tamanoH		= $_FILES['documentoEstadoCuenta']['size'];


			   	move_uploaded_file($_FILES['documentoEstadoCuenta']['tmp_name'],DIRRIDOCS.$archivoNombre);
			   	$data = array(
			   		'riId'				=> $reciboIntId,
			   		'docTipo'			=> 'estadoCuenta',
			   		'archivoNombre'		=> $archivoNombre
				);
				$this->db->insert('TEMPORA_RI_ARCHIVOS', $data);
			}

			$this->load->helper(array('dompdf', 'file'));
		    // page info here, db calls, etc.
			$html = $this->layouts->loadpdf('recibo-interno', $op,'pdf_print', true);
			$data = pdf_create($html, '', false);
			write_file(DIRPDF.'RI_'.$reciboIntId.'.pdf', $data);

			$html = $this->layouts->loadpdf('condiciones-ri', $op,'pdf_print', true);
			$data = pdf_create($html, '', false);
			write_file(DIRPDF.'ConRI_'.$reciboIntId.'.pdf', $data);

			$op['documentoId']	= $reciboIntId;

			$op['op']			= $op;

			//Vista//
			$this->layouts->pdf('reciboInterno-view',$op);

		}


	}

	function cancelarCi(){

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

		$user		= $this->session->userdata('usuario');
		$op['cis'] 	= $this->tempciri_model->cargarCis($user['usuarioID']);

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		//Vista//
		$this->layouts->profile('cis-view' ,$op);

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
