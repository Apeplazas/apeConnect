<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('data_model');
		$this->load->model('proyectos/proyecto_model');
		$this->load->model('prospectos/prospectos_model');
		$this->load->model('planogramas/planogramas_model');
		$this->load->model('evaluacionestwo/evaluacionestwo_model');
		$this->load->model('notificaciones/notificaciones_model');
		$this->load->model('dashboard/dashboard_model');
		$this->load->model('user_model');

		$this->load->model('tempciri/tempciri_model');
		$this->load->model('administrador/administrador_model');

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
	
	/*function buzon(){
		var_dump($_POST);
		$nombre = $_POST['nombre'];
		$tel = $_POST['tel'];
		$email = $_POST['email'];
		$colonia = $_POST['colonia'];
		$sucursal = $_POST['sucursal'];
		$local = $_POST['local'];
		$factura = $_POST['factura'];
		$coment = $_POST['comentario'];
		$plaza = $_POST['plaza'];
		
		//$result = $this->buzon_model->insertaBuzon($plaza, $nombre, $tel, $email, $colonia,$sucursal, $local, $factura, $coment);
		//var_dump($result);
		if($result > 0){
			echo 'true';			
		}else{
			echo 'false';
		}
		exit;
	}*/
    
    function cargarPaginadorVentas(){
	    $d 				= $_POST['alldata'];
	    
	    if($d['tipo'] == 'ade'){
	    $op['data']	= $this->prospectos_model->prospectosAde($d['val'] );
	    }
	    else{
		$op['data']	= $this->prospectos_model->prospectosAtr($d['val'] );
	    }
		$this->load->view('paginacionVentas-view' ,$op);    
    }
    
    function buscaContactoVentas(){
	    $value = $_POST['bus'];
	    
	    
	    if ($value['select'] == 'correo'){
		     $op['data']	= $this->prospectos_model->cargarProspectosCorreo($value['val'] );
	    }
	    elseif ($value['select'] == 'apellido'){
		     $op['data']	= $this->prospectos_model->cargarProspectosApellido($value['val'] );
	    }
	    elseif ($value['select'] == 'nombre'){
		     $op['data']	= $this->prospectos_model->cargarProspectosNom($value['val']);
		     
	    }
	    
	    $this->load->view('paginacionVentas-view' ,$op);    
    }
    
	function addCategoriasEva(){
		$value = $_POST['value'];
		$query = $this->db->query("SELECT * FROM evaluacion_categorias WHERE evaluacionCategoriaID='$value'");


		foreach($query->result() as $row){
			$data = "
			<div class='sinPre' id='preg".$row->evaluacionCategoriaID."'>
			<fieldset>
			<label>
				<a href='http://localhost:8888/apeConnect/prospectos/borrar/4/borrado' class='addToolSmall remove' title='Borrar'>
				<i class='removeT'></i>
				</a>
				<div class='catNomEva'>".$row->categoriaNombre."</div>
			</label>
			<div class='secPreg'>
			<input name='categ[".$row->evaluacionCategoriaID."][]' class='noMsgEv' placeholder='Agrega aqui tu  pregunta'/>
			</div>
			<a href='../ajax/agregaPreguntasEvaluacion' id='sCTip' title='".$row->evaluacionCategoriaID."' class='addPreg addSmallGrayBot'>
  				<i class='iconPlus'><img src='../assets/graphics/svg/plusCircle.svg' alt='Agregar Pregunta'></i>
  				<span>Agregar Pregunta</span>
  			</a>
			</fieldset>
			</div>

			<script type='text/javascript'>
			$('.sinPre').click(function(event){
				event.preventDefault();
      });
			$('.remove').click(function(){
				$(this).parent().parent().remove();
			});

			$('.addPreg').click(function(){
				event.preventDefault();
				var call = $(this).attr('href');
				var value = $(this).attr('title');
				var tthis = $(this);

				$.ajax({
					data : {'value':value},
					dataType : 'json',
					url : call,
					type : 'post',
					success : function(data) {
						tthis.before(data);
						$('.sinPre p').addClass('hide');
					}
				});
			});

			$('.noMsgEv').keyup(function(event){
				var busca = $(this).val();
				var este = $(this);
				$('.tablaPreg').remove();

				$.post(ajax_url+'buscaPreguntas', {
		    busca : busca
				},

				function(data) { sucess:
			  	este.parent().append(data);
				});

			});
			</script>";
		}

		echo json_encode($data);
	}
	
	

	function agregaPreguntasEvaluacion(){
		echo json_encode("<div class='secPreg'>
			<span class='borrar'>x</span>
			<input class='noMsgEv' name='categ[".$_POST['value']."][]' type='text' placeholder='Agrega aquí tu pregunta.'/>
		</div>
		<script type='text/javascript'>
		$('.borrar').click(function(){
			$(this).parent().remove();
		});

		$('.noMsgEv').keyup(function(event){
			var busca = $(this).val();
			var este = $(this);
			$('.tablaPreg').remove();

			$.post(ajax_url+'buscaPreguntas', {
	    busca : busca
			},

			function(data) { sucess:
		  	este.parent().append(data);
			});

		});
		</script>");

	}

	function buscaPreguntas(){

		$var = $_POST['busca'];
		$op['data'] = $this->evaluaciones_model->buscaPregunta($var);

		$this->load->view('busquedaPreguntas' ,$op);
	}

	function verificaUrl()
	{
		$url       = $_POST['filtro'];
		$base = base_url();
		$fancyUrl = strtolower(str_replace(" ", "_", $url));

		$verificado = $this->registrate_model->confirmaUrl($url);

		if (!$verificado){
			echo $base,$fancyUrl;
		}
		else{
			$aviso = "<div class='aviso'><img src='/apeplazas/assets/graphics/alert.png' /><i>Este alias ya ha sido asignado</i></div>";

			echo $aviso;
		}
	}

	function verificaPisos()
	{
		$plaza	= $_POST['plaza'];
		$base	 = base_url();

		$info = $this->planogramas_model->cargarPisosArray($plaza);

		if(!in_array('PB', $info)){ echo '<option value="PB">PB</option>';}
		if(!in_array('1', $info)){ echo '<option value="1">1</option>';}
		if(!in_array('2', $info)){ echo '<option value="2">2</option>';}
		if(!in_array('3', $info)){ echo '<option value="3">3</option>';}
		if(!in_array('4', $info)){ echo '<option value="4">4</option>';}
		if(!in_array('5', $info)){ echo '<option value="5">5</option>';}
		if(!in_array('6', $info)){ echo '<option value="6">6</option>';}
		if(!in_array('7', $info)){ echo '<option value="7">7</option>';}
		if(!in_array('Azotea', $info)){ echo '<option value="Azotea">Azotea</option>';}

	}

	function verLocal()
	{
		$id = $_POST['id'];

		$op['Nvector'] = $this->data_model->buscarVector($id);
		$op['local'] = $this->data_model->buscarSeleccionLocal($id);

		echo json_encode($op);
	}

	function verLocalID()
	{
		$id       = $_POST['id'];

		$vector = $op['Nvector'] = $this->data_model->buscarVector($id);
		$op['local'] = $this->data_model->buscarSeleccionLocalID($vector[0]->localID);
		$op['cliente'] = $this->data_model->buscarSeleccionContrato($vector[0]->localID);


		echo json_encode($op);
	}

	function formValores()
	{
		$campos = $this->planogramas_model->cargaCamposBD();
		$variable= array();
		foreach($campos[0] as $key => $val){
			$variable[]=$key;
		}
		echo json_encode($variable);
		exit();
	}

	function desasignar()
	{
		$id       = $_POST['id'];

		$query = $this->planogramas_model->buscarClaveLocalVector($id);

		$update = array('localID' => NULL);
		$this->db->where('localID', $query[0]->localID);
		$this->db->update('vector', $update);

		$this->db->delete('catalogoLocalesAsignados', array('localID' => $query[0]->localID));

		echo json_encode($query[0]);
	}

	function statusVector()
	{
		$id       	  	= $_POST['id'];
		$status       	= $_POST['status'];

		$vector   		= $this->data_model->buscarVector($id);
		$op['local']  	= $this->data_model->buscarSeleccionLocal($id);

		$update = array('status' => $status,'localID' => NULL);
		$this->db->where('id', $id);
		$this->db->update('vector', $update);

		$op['Nvector'] = $this->data_model->buscarVector($id);

		echo json_encode($op);
	}

	function cargaNotificacionesBarra()
	{
		//Carga Session para sacar informacion de //
		$user                 = $this->session->userdata('usuario');
		$op['notificaciones'] = $this->notificaciones_model->cargaNotificacionesBarra($user['usuarioID']);

		$this->load->view('notificacionesAjax-view', $op);
	}

	function addFormResp($comentarioID, $proyectoID)
	{
		$op['comentarios']    = $this->proyecto_model->cargaComentariosID($proyectoID, $comentarioID);

		$this->load->view('ajaxFormRespuesta', $op);
	}

	function verificaEmail()
	{
		$email	= $_POST['filtro'];
		$base	= base_url();

		$verificar = $this->registrate_model->confirmaEmail($email);

		if (!$verificar){
			echo '';
		}
		else{
			$aviso = "<div class='avisoEmail'><img src='/apeplazas/assets/graphics/alert.png' /><i>Este email ya se encuentra registrado</i>s</div>";

			echo $aviso;
		}
	}

	function buscarCiudad()
	{
		$filtro = strtolower($_POST['q']);
		$op['ciudad']	= $this->data_model->buscaCiudades($filtro);

		//Vista//
		$this->load->view('busquedaAuto-view' ,$op);

	}

	function fechaNac()
	{
		$dia = $var	= $_POST['filtro'];
		$valores	= $_POST['accion'];

		//Separa segmentos accion y id
		$segmento = explode("-", $valores);
		$accion   = $segmento[0];
		$id       = $segmento[1];

		if (strlen($var) == '1') {
			$dia = '0'.$var;
		}

		$actualiza = $this->usuario_model->buscaPerfilID($id);

		//Separa segmentos accion y id
		$nuevaAct = explode("-", $actualiza[0]->fechaNacimiento);
		$diaAct   = $nuevaAct[2];
		$mesAct   = $nuevaAct[1];
		$anioAct  = $nuevaAct[0];

		$final = $anioAct.'-'.$mesAct.'-'.$dia;
		$update = array('fechaNacimiento' => $final,);
			$this->db->where('usuarioID', $id);
			$this->db->update('usuarios', $update);

		echo $final;

	}

	function profile($var)
	{
		$var	= $_POST['filtro'];
		$field	= $this->uri->segment(3);
		$id		= '1';

		if($field == 'age'){

			if($var == '0' || $var >= '90'){
			echo 'No has escogido una edad correcta';
			}
			else{
				$update = array('age' => $var,);
				$this->db->where('userID', $id);
				$this->db->update('users', $update);
			}

		}

		if($field == 'gender'){
			$update = array('gender' => 'Femenino',);
			$this->db->where('userID', $id);
			$this->db->update('users', $update);
			echo $var;
		}

	}

	function gender($gender,$userID)
	{
		$type	= $this->uri->segment(3);
		$id		= $this->uri->segment(4);

		$update = array('gender' => $type,);
			$this->db->where('userID', $id);
			$this->db->update('users', $update);
			echo $type;


	}

	function edo()
	{
		$var	= $_POST['filtro'];

		$piece = explode("-", $var);
		$edo = $piece[0]; // Estado Civil
		$id = $piece[1]; // userID
		$row = $piece[2]; // database field

		if ($row == 'gender') {
			$update = array($row => $edo,);
				$this->db->where('userID', $id);
				$this->db->update('users', $update);
		echo $edo;
		}
		elseif ($row == 'cs'){
			$update = array('civilStatement' => $edo,);
				$this->db->where('userID', $id);
				$this->db->update('users', $update);
		echo $edo;

		}


	}

	function cargarMunicipios()
	{
		$estadoFiltro = strtolower($_POST['estadoFiltro']);

		$sc = $this->db->query("SELECT claveMunicipio AS idMunicipio,
									   nombreMunicipio AS nombreMunicipio
									   FROM estadosMexico
									   WHERE nombreEstado = '$estadoFiltro'
									   GROUP BY claveMunicipio
									   ORDER BY claveMunicipio");

		$lista_opciones = '<option value="0">Municipio</option>
		';

		foreach($sc->result() as $row){
			$lista_opciones .= "<option value='".$row->nombreMunicipio."'>".$row->nombreMunicipio."</option>";
		}

		echo $lista_opciones;
	}

	function cargarColonias()
	{
		$municipioFiltro 	= strtolower($_POST['municipioFiltro']);
		$estadoFiltro 		= strtolower($_POST['estadoFiltro']);

		$sc = $this->db->query("SELECT claveColonia AS idColonia,
									   nombreColonia AS nombreColonia
									   FROM estadosMexico
									   WHERE nombreEstado = '$estadoFiltro'
									   AND nombreMunicipio = '$municipioFiltro'
									   GROUP BY claveColonia
									   ORDER BY nombreColonia ASC");

		$lista_opciones = '<option value="0">Colonia</option>
		';

		foreach($sc->result() as $row){
			$lista_opciones .= "<option value='".$row->nombreColonia."'>".$row->nombreColonia."</option>";
		}

		echo $lista_opciones;
	}

	function cargarCP()
	{
		$municipioFiltro 	= strtolower($_POST['municipioFiltro']);
		$estadoFiltro 		= strtolower($_POST['estadoFiltro']);
		$coloniaFiltro 		= strtolower($_POST['coloniaFiltro']);

		$sc = $this->db->query("SELECT codigoCP
									   FROM estadosMexico
									   WHERE nombreEstado = '$estadoFiltro'
									   AND nombreMunicipio = '$municipioFiltro'
									   AND nombreColonia = '$coloniaFiltro'");


		$lista_opciones = '';
		foreach($sc->result() as $row){
			$lista_opciones = $row->codigoCP;
		}

		if ($lista_opciones >= '0'){
		echo $lista_opciones;
		}
		else{
			echo 'Intente Nuevamente';
		}

	}

	function agregarSegmento()
	{
		$op['unidad'] = $this->data_model->cargaUnidades();

		$this->load->view('agregaSegmentoForm-view', $op);
	}

	function excelimport($partidaId){

		$idproyecto = $this->input->post('idproyecto');


		$excelname	= $_FILES['excelfile']['name'];
		$exceltype 	= $_FILES['excelfile']['type'];
		$excelsize	= $_FILES['excelfile']['size'];

		$contadorTemporal = array();

		$aceptypes = array(
			'application/vnd.ms-excel',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		);

		if(!in_array($exceltype,$aceptypes) ){
			redirect("proyectos/verProyecto/$idproyecto");
			exit();
		}

		move_uploaded_file($_FILES['excelfile']['tmp_name'],DIREXCELS.$excelname);

		$this->load->library('excel');

		$objPHPExcel = PHPExcel_IOFactory::load(DIREXCELS.$excelname);
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();

		$data = array();

		// Loop de cada fila dentro del excel
		for ($row = 1; $row <= $highestRow; $row++){
		    // Leer la fila del excel y pasarla a un array
		    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
		                                    NULL,
		                                    TRUE,
		                                    FALSE);

			if(empty($rowData[0][1]))
				continue;


			$unidadId = $this->data_model->cargaUnidadesporNombre($rowData[0][1]);

			if(isset($unidadId[0]->idUnidad)){

				if(isset($rowData[0][2])){

					$partidaDatos 	= $this->proyecto_model->cargaPartida($partidaId);
					$zonaDatos		= $this->proyecto_model->cargaZonaPorProyecto($idproyecto);

					if(!isset($contadorTemporal[$idproyecto][$partidaId])){
						$contadorTemporal[$idproyecto] = array();
						$contadorTemporal[$idproyecto][$partidaId] = $this->proyecto_model->cargaNumeroPartida($idproyecto,$partidaId);
					}
					$contadorTemporal[$idproyecto][$partidaId]  = $contadorTemporal[$idproyecto][$partidaId] + 1;
					$numeroPartida	= $contadorTemporal[$idproyecto][$partidaId];
					$clave 			= $zonaDatos[0]->zonaCodigo . '-' . $partidaDatos[0]->clave . '-' . str_pad($numeroPartida, 3, '0', STR_PAD_LEFT);

					$data[] = array(
						'seccionDesc'	=> $rowData[0][0],
						'unidadID'   	=> $unidadId[0]->idUnidad,
						'idPartida'		=> $partidaId,
						'claveSegmento'	=> $clave,
						'idProyecto'   	=> $idproyecto,
						'cantidad'   	=> $rowData[0][2],
						'horaAlta'   	=> date("H:m:s"),
						'fechaAlta'  	=> date("Y-m-d"),
					);
				}

			}else{

				$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Por favor ingrese la unidad ' . $rowData[0][1] . ' de forma correcta.</strong></div><br class="clear">');
				redirect("proyectos/verProyecto/$idproyecto");

			}

		}

		if(!empty($data)){
			$this->db->insert_batch('segmentoProyectos', $data);
		}
		redirect("proyectos/verProyecto/$idproyecto");

	}

	function excelFullImport(){

		$idproyecto = $this->input->post('idproyecto');

		$excelname	= $_FILES['excelfile']['name'];
		$exceltype 	= $_FILES['excelfile']['type'];
		$excelsize	= $_FILES['excelfile']['size'];

		$contadorTemporal = array();

		$aceptypes = array(
			'application/vnd.ms-excel',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		);

		if(!in_array($exceltype,$aceptypes) ){
			redirect("proyectos/verProyecto/$idproyecto");
			exit();
		}

		move_uploaded_file($_FILES['excelfile']['tmp_name'],DIREXCELS.$excelname);

		$this->load->library('excel');

		$objPHPExcel = PHPExcel_IOFactory::load(DIREXCELS.$excelname);
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();

		$data = array();

		// Loop de cada fila dentro del excel
		for ($row = 1; $row <= $highestRow; $row++){
		    // Leer la fila del excel y pasarla a un array
		    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
		                                    NULL,
		                                    TRUE,
		                                    FALSE);

			if(empty($rowData[0][2]))
				continue;

			$partidaId = $this->data_model->cargaPartidaporNombre($rowData[0][0]);

			if(isset($partidaId[0]->id)){

				$partidaAgregada = $this->data_model->verificaPartidaEnProyecto($idproyecto,$partidaId[0]->id);

				if(empty($partidaAgregada)){

					$op = array(
						'proyectoId'   	=> $idproyecto,
						'partidaId'  	=> $partidaId[0]->id
						);
					$this->db->insert('ProyectosPartidas', $op);

				}

				$unidadId = $this->data_model->cargaUnidadesporNombre($rowData[0][2]);

				if(isset($unidadId[0]->idUnidad)){

					if(isset($rowData[0][3])){

						$partidaDatos 	= $this->proyecto_model->cargaPartida($partidaId[0]->id);
						$zonaDatos		= $this->proyecto_model->cargaZonaPorProyecto($idproyecto);

						if(!isset($contadorTemporal[$idproyecto][$partidaId[0]->id])){
							$contadorTemporal[$idproyecto] = array();
							$contadorTemporal[$idproyecto][$partidaId[0]->id] = 0;
						}
						$contadorTemporal[$idproyecto][$partidaId[0]->id]  = $contadorTemporal[$idproyecto][$partidaId[0]->id] + 1;
						$numeroPartida	= $contadorTemporal[$idproyecto][$partidaId[0]->id];
						$clave 			= $zonaDatos[0]->zonaCodigo . '-' . $partidaDatos[0]->clave . '-' . str_pad($numeroPartida, 3, '0', STR_PAD_LEFT);

						$data[] = array(
							'seccionDesc'	=> $rowData[0][1],
							'unidadID'   	=> $unidadId[0]->idUnidad,
							'idPartida'		=> $partidaId[0]->id,
							'claveSegmento'	=> $clave,
							'idProyecto'   	=> $idproyecto,
							'cantidad'   	=> $rowData[0][3],
							'horaAlta'   	=> date("H:m:s"),
							'fechaAlta'  	=> date("Y-m-d"),
						);
					}

				}else{

					$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Por favor ingrese la unidad ' . $rowData[0][2] . ' de forma correcta.</strong></div><br class="clear">');
					redirect("proyectos/verProyecto/$idproyecto");

				}

			}else{

				$this->session->set_flashdata('msg','<div class="msgFlash"><img src="http://www.apeplazas.com/obras/assets/graphics/alerta.png" alt="Alerta"><strong>Por favor ingrese la partida ' . $rowData[0][0] . ' de forma correcta.</strong></div><br class="clear">');
				redirect("proyectos/verProyecto/$idproyecto");


			}

		}

		if(!empty($data)){
			$this->db->insert_batch('segmentoProyectos', $data);
		}
		redirect("proyectos/verProyecto/$idproyecto");

	}

	function editConSeg(){

		$unidad = $this->data_model->cargaUnidadesporNombre($_POST['update_value']);
		$idSegmento = $this->uri->segment(3);

		$update = array('unidadID' => $unidad[0]->idUnidad);
				$this->db->where('idSegmento', $idSegmento);
				$this->db->update('segmentoProyectos', $update);

		echo $unidad[0]->nombre;


	}

	function editZonaEstado($zonaId){

		if($_POST['original_value'] != $_POST['update_value'] && !empty($_POST['update_value'])){

			$estadoId = $this->registrate_model->cargaEstadoId($_POST['update_value']);

			if(!$_POST['original_value']){

				//Insertar Usuario
				$user_data['zona'] = array(
					'zonasid'		=> $zonaId,
					'claveEstado'	=> $estadoId[0]->claveEstado
				);
				$this->db->insert('zonas_estadosMexico', $user_data['zona']);

			}elseif($_POST['original_value']){

				$update = array(
					'claveEstado' => $estadoId[0]->claveEstado
				);
				$this->db->where('zonasid', $zonaId);
				$this->db->update('zonas_estadosMexico', $update);

			}


		}

		echo $_POST['update_value'];

	}

	function editQuantSeg()
	{
		$idSegmento	= $this->uri->segment(3);
		$value    	= str_replace(' ', '', $_POST['update_value']);

		if (is_numeric($value)){

			$update = array('cantidad' => $value);
			$this->db->where('idSegmento', $idSegmento);
			$this->db->update('segmentoProyectos', $update);

			echo $value;
		}
		else{
			echo 'Solo se aceptan caracteres numericos';
		}


	}

	function editConPro()
	{
		$idProyecto	= $this->uri->segment(3);

		$update = array('descripcionProyecto' => $_POST['update_value']);
		$this->db->where('idProyecto', $idProyecto);
		$this->db->update('proyectos', $update);

		echo nl2br($_POST['update_value']);
	}

	function editTitPro()
	{
		$idProyecto	= $this->uri->segment(3);

		$update = array('tituloProyecto' => $_POST['update_value']);
		$this->db->where('idProyecto', $idProyecto);
		$this->db->update('proyectos', $update);

		echo nl2br($_POST['update_value']);
	}

	function buscarDescripcion()
	{
		$filtro = strtolower($_POST['q']);
		$op['descripciones'] = $this->data_model->buscarConceptops($filtro);

		$this->load->view('busquedaConceptos-view', $op);

	}

	function addplaza(){
		$zona	= $this->input->post('zona');
		$czona	= $this->input->post('czona');
		$estado	= $this->input->post('estado');

		//Insertar plaza
		$dataplaza = array(
					'zona'			=> $zona,
					'zonaCodigo'	=> $czona
				);
		$this->db->insert('zonas', $dataplaza);
		$plaza_id = $this->db->insert_id();

		$dataref = array(
			'zonasid'		=> $plaza_id,
			'claveEstado'	=> $estado
		);

		$this->db->insert('zonas_estadosMexico', $dataref);

		exit();
	}

	function addunidad(){
		$unombre	= $this->input->post('unombre');
		$sunidad	= $this->input->post('sunidad');

		$data = array(
			'nombre'	=> $unombre,
			'simbolo'	=> $sunidad
		);

		$this->db->insert('unidades', $data);

		exit();
	}

	function agregarpartida(){

		$pnombre	= $this->input->post('pnombre');
		$pclave		= $this->input->post('pclave');

		$data = array(
			'nombre'	=> $pnombre,
			'clave'		=> $pclave
		);

		$this->db->insert('partidas', $data);

		exit();

	}

	function totalsegmento(){
		$idsegmento		= $this->input->post('segmentoid');
		$punitario		= $this->input->post('cunitario');
		$cantidadseg 	= $this->proyecto_model->tresegentocant($idsegmento);
		$totalseg = $cantidadseg[0]->cantidad * $punitario;

		echo json_encode($totalseg);
		exit();
	}

	function editSeg()
	{
		$idSegmento	= $this->uri->segment(3);
		$value    	= $_POST['update_value'];

		$update = array('seccionDesc' => $value);
		$this->db->where('idSegmento', $idSegmento);
		$this->db->update('segmentoProyectos', $update);

		echo $value;




	}

	function borrarProyectos(){

		$idProyectos = $this->input->post('idProyectos');
		$actualizarDatos = array();

		foreach($idProyectos as $id){
			$actualizarDatos[] = array(
				'idProyecto'	 => $id,
				'statusProyecto' => 'Borrado'
			);
		}

		$this->db->update_batch('proyectos', $actualizarDatos, 'idProyecto');
		exit();

	}

	function cargarLocales()
	{
		$op['filtro'] = $filtro = strtolower($_POST['q']);
	    $op['local']			= $this->data_model->cargarAjaxLocales($filtro);

		//Vista//
		$this->load->view('busqueda-view' ,$op);
	}

	function asignarLocales()
	{
		$op['filtro']	= $filtro = strtolower($_GET['term']);
		//consulta a catalogoLocalesAsignados
		$localID	= $this->data_model->cargarCatalogoLocalesAsignados();

		$implode = implode('', $localID);
	    $local	= $this->data_model->asignarAjaxLocales($filtro, $implode);

		//Vista//
		//$this->load->view('busqueda-view' ,$op);
		echo json_encode($local);
		exit;
	}

	function asignar()
	{
		$ids    = $_POST['ids'];
		$local	= $_POST['local'];
		$textos	= array();

		foreach($ids as $id){

			$vector = $this->data_model->buscarVector($id);
			if($vector[0]->tipo == "text"){
				$tempcoord = explode(",",str_replace(array("(",")","translate"),"",$vector[0]->transform));
				$textos[] = array(
					"id"	=> $vector[0]->id,
					"coord" => $tempcoord[1]
				);
			}

			if(!isset($op['local']) && !isset($locales))
				$op['local'] = $locales = $this->data_model->buscarSeleccion($local);

			if ($vector[0]->localID == ''){
				$update = array('localID' => $locales[0]->id, 'status' => 'seleccionado');
				$this->db->where('id', $id);
				$this->db->update('vector', $update);
			}

		}

		foreach($textos as $key => $val){

			$idvect[$key]		= $val["id"];
			$coordvect[$key] 	= $val["coord"];

		}

		array_multisort($coordvect, SORT_ASC, $idvect, SORT_REGULAR, $textos);

		foreach($textos as $key => $val){

			$update = array('orden' => $key+1);
			$this->db->where('id', $val["id"]);
			$this->db->update('vector', $update);

		}

		$op['Nvector'] = $this->data_model->buscarVector($ids[0]);
		echo json_encode($op);

	}

	function asignarVector()
	{
		$ids    = $_POST['ids'];
		$local	= $_POST['local'];
		$textos	= array();

		foreach($ids as $id){

			$vector = $this->data_model->buscarVector($id);
			if($vector[0]->tipo == "text"){
				$tempcoord = explode(",",str_replace(array("(",")","translate"),"",$vector[0]->transform));
				$textos[] = array(
					"id"	=> $vector[0]->id,
					"coord" => $tempcoord[1]
				);
			}

			if(!isset($op['local']) && !isset($locales))
				$op['local'] = $locales = $this->data_model->buscarSeleccionVicLocal($local,$vector[0]->id);

			if ($vector[0]->localID == ''){
				$update = array('localID' => $locales[0]->local, 'status' => 'habilitado');
				$this->db->where('id', $id);
				$this->db->update('vector', $update);
			}

		}

		foreach($textos as $key => $val){

			$idvect[$key]		= $val["id"];
			$coordvect[$key] 	= $val["coord"];

		}

		array_multisort($coordvect, SORT_ASC, $idvect, SORT_REGULAR, $textos);

		foreach($textos as $key => $val){

			$update = array('orden' => $key+1);
			$this->db->where('id', $val["id"]);
			$this->db->update('vector', $update);

		}

		$op['Nvector'] = $this->data_model->buscarVector($ids[0]);
		echo json_encode($op);

	}

	public function asignarVectorPlano()
	{
		$ids      = $_POST['ids'];
		$local    = $_POST['local'];
		$plazaId  = $_POST['plazaId'];
		$textos	= array();

		krsort($ids);

		foreach($ids as $id){

			$vector = $this->data_model->buscarVector($id);
			$val = explode(",",str_replace(array("(",")","translate"),"",$vector[0]->transform));

			if($vector[0]->tipo == "text"){

				$tempcoord = explode(",",str_replace(array("(",")","translate"),"",$vector[0]->transform));

				if(!isset($tempcoord[1]))
				exit();

				$textos[] = array(
					"id"	=> $vector[0]->id,
					"coord" => $tempcoord[1]
				);
			}

			if(!isset($op['local']) && !isset($locales))
				$op['local'] = $locales = $this->data_model->buscarSeleccionVicLocal($local,$vector[0]->id);



			if ($vector[0]->localID == ''){
				$update = array('localID' => $local, 'status' => 'habilitado');
				$this->db->where('id', $id);
				$this->db->update('vector', $update);
				}

			}

			$uno = $tempcoord[0];
			$dos = $tempcoord[1] + 2;
			$tres = $tempcoord[1] + 4;
			$cuatro = $tempcoord[1] + 6;

			$insert = array('tipo' => 'text', 'infoTipo' => '1', 'localID' => $local, 'plazaId' => $plazaId, 'transform' => 'translate('.$uno.','.$dos .')');
			$this->db->insert('vector', $insert);
			$textoIdUno = $this->db->insert_id();

			$textos[1] = array(
			"id"	=> $textoIdUno,
			"coord" => $dos
			);

			$insertDos = array('tipo' => 'text', 'infoTipo' => '1', 'localID' => $local, 'plazaId' => $plazaId, 'transform' => 'translate('.$uno.','.$tres .')');
			$this->db->insert('vector', $insertDos);
			$textoIdDos = $this->db->insert_id();

			$textos[2] = array(
				"id"	=> $textoIdDos,
				"coord" => $tres
				);


			$insertTres = array('tipo' => 'text', 'infoTipo' => '1', 'localID' => $local, 'plazaId' => $plazaId,  'transform' => 'translate('.$uno.','.$cuatro .')');
			$this->db->insert('vector', $insertTres);
			$textoIdTres = $this->db->insert_id();

			$textos[3] = array(
				"id"	=> $textoIdTres,
				"coord" => $cuatro
				);


			$catalogo = array('localID' => $local, 'vectorID' => $vector[0]->id);
			$this->db->insert('catalogoLocalesAsignados', $catalogo);


		foreach($textos as $key => $val){

			$idvect[$key]		= $val["id"];
			$coordvect[$key] 	= $val["coord"];

		}

		array_multisort($coordvect, SORT_ASC, $idvect, SORT_REGULAR, $textos);

		foreach($textos as $key => $val){

			$update = array('orden' => $key+1);
			$this->db->where('id', $val["id"]);
			$this->db->update('vector', $update);

		}

		$op['Nvector'] = $this->data_model->buscarVector($ids[0]);
		echo json_encode($op);
		exit;

	}

	function actualizaCoord(){

		$id		= $_POST['id'];
		$coords	= $_POST['coords'];

		$update = array('transform' => $coords, 'x' => NULL, 'y' => NULL );
		$this->db->where('id', $id);
		$this->db->update('vector', $update);

		exit;

	}

	function agregarPath(){

		$planoId 	= $_POST['planogramaID'];
		$coord		= $_POST['coords'];

		if(!empty($planoId) && !empty($coord)){

			$data = array(
				'tipo'		=> "path",
				'd'			=> $coord,
				'plazaId'	=> $planoId,
				'status'	=> 'reciente'
			);
			$this->db->insert('vector', $data);

			$c = explode(' ',$coord);
			$x   = $c[1];
			$y   = $c[2] + 3;
			$y1  = $c[2] + 6;
			$y2  = $c[2] + 9;

			$data0 = array(
				'tipo'		=> "text",
				'x'			=> $x,
				'y'			=> $y,
				'plazaId'	=> $planoId,
				'contenido'	=> 'texto 1',
				'status'	=> 'reciente'
			);
			$this->db->insert('vector', $data0);

			$data1 = array(
				'tipo'		=> "text",
				'x'			=> $x,
				'y'			=> $y1,
				'plazaId'	=> $planoId,
				'contenido'	=> 'texto 2',
				'status'	=> 'reciente'
			);
			$this->db->insert('vector', $data1);

			$data2 = array(
				'tipo'		=> "text",
				'x'			=> $x,
				'y'			=> $y2,
				'plazaId'	=> $planoId,
				'contenido'	=> 'texto 3',
				'status'	=> 'reciente'
			);
			$this->db->insert('vector', $data2);

			redirect('planogramas/editarplano/'.$planoId);

		}

	}

	function cargarMasPlazas()
	{
		$idPlaza 	= strtolower($_POST['idPlaza']);
		$sc = $this->db->query("SELECT * FROM propiedades");
		$lista_opciones = '<option value="0">Agrega mas plazas</option>
		';

		foreach($sc->result() as $row){
			$lista_opciones .= "<option value='".$row->clavePropiedad."'>".$row->propiedad."</option>";
		}

		echo '<div class="prel f100"><div class="delToolSmallTwo delThis"><i class="iconDelete"><img src="../assets/graphics/svg/borrar.svg" alt="Agregar Plaza"/></i></div><div class="delToolSmall "><span class="plusTwo"><img src="../assets/graphics/svg/plusCircle.svg" alt="Agregar Plaza"/></span></div><select name="plaza[]" class="selExtra">'.$lista_opciones.'</select>
		<script>
			$(".delThis").click(function() {
				$(this).parent().remove();
				$(".plus").removeClass("none");
			});
		</script>
		<script>
		$(".plusTwo").click(function(){
			$(".delToolSmall").addClass("none");
			var idPlaza 	= $("#idPlaza").val();
			$.post("../ajax/cargarMasPlazas",{idPlaza:idPlaza},function(data){
			sucess:
			$("#masPlazas").append(data);
			});
		});
		</script>
		</div>' ;
	}

	function borrarPlazaUsuario()
	{
		$idPlaza  = strtolower($_POST['idPlaza']);
		$user     = $this->session->userdata('usuario');

		$valido = $this->prospectos_model->validaPlazaUsuario($user['usuarioID'], $idPlaza);

		if ($valido){
			$data = array(
	    	    'status' => 'borrada'
				);

			$this->db->where('plazaID', $idPlaza);
			$this->db->where('usuarioID', $user['usuarioID']);
			$this->db->update('prospectosPlazas', $data);

		}

		else{
			echo'<span>Ocurrio un error, Contacte a su administrador</span>';
		}
	}

	function agregarPlazaPost()
	{
		$idPlaza      = strtolower($_POST['idPlaza']);
		$user         = $this->session->userdata('usuario');
		$textoPlaza   = $_POST['textoPlaza'];

		$chequeo = $this->prospectos_model->validaPlazaUsuario($user['usuarioID'], $idPlaza);

		if($chequeo){
			$data = array(
	    	    'status' => 'activa'
				);

				foreach($chequeo as $row){

					if($row->zona != $textoPlaza || $row->status == 'borrada'){

					$this->db->where('plazaID', $idPlaza);
					$this->db->where('usuarioID', $user['usuarioID']);
					$this->db->update('prospectosPlazas', $data);

				echo'
				<div class="prel f100">
				<div id="'.$idPlaza.'" class="delToolSmallThree delPlaza"><i class="iconDelete">Borrar</i></div>
					<input type="hidden" name="plaza[]" value="'.$idPlaza.'">
					<div class="plazaSel">'.$textoPlaza.'</div>
				</div>
				<script type="text/javascript">
				jQuery(function($) {
					/// Borra en edicion la plaza seleccionada de la bd
					$(".delPlaza").click(function() {
						var idPlaza = $(this).attr("id");
						$.post("../../ajax/borrarPlazaUsuario",{idPlaza:idPlaza},function(data){
						sucess:
							$("#masPlazas").append(data);
						});
						$(this).parent().remove();
					});
				});
				</script>

				';
				}
			}
		}
		else{
			$data = array(
	    	    'status' => 'activa',
	    	    'plazaID' => $idPlaza,
	    	    'usuarioID' => $user['usuarioID'],
				);
			$this->db->insert('prospectosPlazas', $data);
			echo'<div class="prel f100">
						<div id="'.$idPlaza.'" class="delToolSmallThree delPlaza"><i class="iconDelete">Borrar</i></div>
					<input type="hidden" name="plaza[]" value="'.$idPlaza.'">
					<div class="plazaSel">'.$textoPlaza.'</div>
				</div>

				<script type="text/javascript">
				jQuery(function($) {
					/// Borra en edicion la plaza seleccionada de la bd
					$(".delPlaza").click(function() {
						var idPlaza = $(this).attr("id");
						$.post("../../ajax/borrarPlazaUsuario",{idPlaza:idPlaza},function(data){
						sucess:
							$("#masPlazas").append(data);
						});
						$(this).parent().remove();
					});
				});
				</script>

				';

		}
	}

	function plazasEmpresas()
	{
		$user         = $this->session->userdata('usuario');

		$sc = $this->db->query("SELECT * FROM zonas");
		$lista_opciones = '<option value="0">Agrega mas plazas</option>';

		foreach($sc->result() as $row){
			$lista_opciones .= "<option value='".$row->idZona."'>".$row->zona."</option>";
		}
		echo '<div class="prel f100"><div class="delToolSmallTwo delThis"><i class="iconDelete">Borrar</i></div><div class="delToolSmall "><span class="plusThree">Agregar</span></div><select name="plaza[]" class="selExtra">'.$lista_opciones.'</select>
		<script>
			$(".delThis").click(function() {
				$(this).parent().remove();
				$(".plusModal").removeClass("none");
			});
		</script>
		<script>
		$(".plusThree").click(function(){
			$(".delToolSmall").addClass("none");
			$.post("http://www.apeplazas.com/apeConnect/ajax/plazasEmpresas",{},function(data){
			sucess:
				$("#modalPlazas").append(data);
			});
		});

		</script>
		</div>' ;
	}

	public function genera_rfc(){

		$persona = ($_POST['persona'] == 'MORAL') ? false : true;
	    $rfc = $this->load->library('rfc',array(
											    'nombre' => $_POST['nombre'],
											    'fecha' => $_POST['fecha'],
											    'personaFisica' => $persona
											    ));
	    $data['rfc'] = $rfc->rfc;

	    echo  json_encode($data);

	}

	public function obtenerLocalInfo(){

		$id    = $_POST['id'];

		$cotizacion = $this->session->userdata('cotizacion');
		if(!in_array($id, $cotizacion['locales'])){
			$vector = $this->data_model->buscarVector($id);
			$local 	= $this->data_model->buscarSeleccionVicLocal($vector[0]->localID,$id);
			$cotizacion['locales'][] = $id;
			$data['cotizacion'] = $cotizacion;
			$this->session->set_userdata($data);
			echo json_encode($local);
		}else{
			$local[0]['Nombre'] = '';
			echo json_encode($local);
		}
		exit;

	}

	public function eliminarLocalCotizacion(){

		$id    = 1;

		$cotizacion = $this->session->userdata('cotizacion');
		if(in_array($id, $cotizacion['locales'])){
			if(($key = array_search($id, $cotizacion['locales'])) !== false) {
			    unset($cotizacion['locales'][$key]);
			}
			$data['cotizacion'] = $cotizacion;
			$this->session->set_userdata($data);
		}
		exit;

	}
//MIKEE
	public function asignarInmueblePisosYEncargados(){
		$id    	= $_POST['id'];
		$foo    	= $_POST['usuarioID'];
		$nombre	= $_POST['nombre'];
		$clave	= $_POST['clave'];
		$predio	= $_POST['predio'];
		$piso	= $_POST['piso'];

		
			$update = array('claveCiudad' => $clave, 'nombre'=> $nombre);
			$this->db->where('Inmueble', $id);
			$this->db->update('borrar_vic_inmueble', $update);
			
			$query = $this->db->query("SELECT inmuebleIntelisis FROM inmuebles WHERE inmuebleIntelisis='$id'");
			
	
			
			if($query->result()){
				$op = array('inmuebleNombre' => $nombre,'codigoIATA' => $clave, 'predios' => $predio, 'pisos' => $piso, 'inmuebleIntelisis' => $id);
				$this->db->where('inmuebleIntelisis', $id);
				$this->db->update('inmuebles', $op);
			}else{
				$op = array('inmuebleNombre' => $nombre,'codigoIATA' => $clave, 'predios' => $predio, 'pisos' => $piso, 'inmuebleIntelisis' => $id);
				$this->db->insert('inmuebles', $op);
			}
			
			
			
			
			$data = array();
			foreach($foo as $ids){

				$data[] = array(
				      'usuarioID' 		=> $ids,
				      'Inmueble'	=> $id
				);

			}
			$this->db->insert_batch('borrar_encargado_inmueble', $data);

		

		echo true;
		exit;

	}


	public function agruparLocales(){

		$ids    	= $_POST['id'];
		$grupo_nom	= $_POST['nombre'];
		$cost_min	= $_POST['minimo'];
		$cost_max	= $_POST['maximo'];
		$descu	= $_POST['descuento'];
		$periodo	= $_POST['periodo'];

		if(!empty($cost_min)){

			$op = array(
				'nombre'	=> $grupo_nom,
				'minimo'   	=> $cost_min,
				'maximo'	=> $cost_max,
				'descuento'	=> $descu,
				'status'	=> 'no autorizado',
				'periodo'	=> $periodo
			);
			$this->db->insert('tempora_grupos_locales', $op);
			$grupo_id = $this->db->insert_id();
			$data = array();

			foreach($ids as $id){

				$data[] = array(
				      'id' 		=> $id,
				      'grupoId'	=> $grupo_nom
				);

			}
			$this->db->update_batch('vector', $data, 'id');

		}

		echo true;
		exit;

	}
	
	public function inmuebles(){

		$inmuebleNombre   	= $_POST['inmuebleNombre'];
		$codigoIATA 	= $_POST['codigoIATA'];
		$predios	= $_POST['predios'];
		$areaConstruida	= $_POST['areaConstruida'];
		$pisos	= $_POST['pisos'];
		$inmueble = $_POST['inmuebleIntelisis'];
		

		

			$op = array(
				'inmuebleNombre'	=> $inmuebleNombre,
				'codigoIATA'   	=> $codigoIATA,
				'predios'	=> $predios,
				'areaConstruida'	=> $areaConstruida,
				'pisos'	=> $pisos,
				'inmuebleIntelisis' => $inmueble
			);
			$this->db->insert('inmuebles', $op);
		echo true;
		exit;

	}
	
	public function piso1(){
		$inmueble = $_POST['inmuebleIntelisis'];
		$numeroPiso1 = $_POST['numeroPiso'];
		$areaConstruida1 = $_POST['areaConstruida1'];
		
		
		$op1 = array(
				'numeroPiso'	=> $numeroPiso1,
				'areaConstruida'	=> $areaConstruida1,
				'inmuebleIntelisis' => $inmueble
			);
			$this->db->insert('pisos', $op1);

		echo true;
		exit;

	}
	
	public function piso2(){
		$inmueble = $_POST['inmuebleIntelisis'];
		$numeroPiso2 = $_POST['numeroPiso'];
		$areaConstruida2 = $_POST['areaConstruida2'];
		
		
		$op2 = array(
				'numeroPiso'	=> $numeroPiso2,
				'areaConstruida'	=> $areaConstruida2,
				'inmuebleIntelisis' => $inmueble
			);
			$this->db->insert('pisos', $op2);

		echo true;
		exit;

	}
	
	public function piso3(){
		$inmueble = $_POST['inmuebleIntelisis'];
		$numeroPiso3 = $_POST['numeroPiso'];
		$areaConstruida3 = $_POST['areaConstruida3'];
		
		
		$op3 = array(
				'numeroPiso'	=> $numeroPiso3,
				'areaConstruida'	=> $areaConstruida3,
				'inmuebleIntelisis' => $inmueble
			);
			$this->db->insert('pisos', $op3);

		echo true;
		exit;

	}
	
	public function piso4(){
		$inmueble = $_POST['inmuebleIntelisis'];
		$numeroPiso4 = $_POST['numeroPiso'];
		$areaConstruida4 = $_POST['areaConstruida4'];
		
		
		$op4 = array(
				'numeroPiso'	=> $numeroPiso4,
				'areaConstruida'	=> $areaConstruida4,
				'inmuebleIntelisis' => $inmueble
			);
			$this->db->insert('pisos', $op4);

		echo true;
		exit;

	}
	
	public function piso5(){
		$inmueble = $_POST['inmuebleIntelisis'];
		$numeroPiso5 = $_POST['numeroPiso'];
		$areaConstruida5 = $_POST['areaConstruida5'];
		
		
		$op5 = array(
				'numeroPiso'	=> $numeroPiso5,
				'areaConstruida'	=> $areaConstruida5,
				'inmuebleIntelisis' => $inmueble
			);
			$this->db->insert('pisos', $op5);

		echo true;
		exit;

	}
	
	public function piso6(){
		$inmueble = $_POST['inmuebleIntelisis'];
		$numeroPiso6 = $_POST['numeroPiso'];
		$areaConstruida6 = $_POST['areaConstruida6'];
		
		
		$op6 = array(
				'numeroPiso'	=> $numeroPiso6,
				'areaConstruida'	=> $areaConstruida6,
				'inmuebleIntelisis' => $inmueble
			);
			$this->db->insert('pisos', $op6);

		echo true;
		exit;

	}
	
	public function piso7(){
		$inmueble = $_POST['inmuebleIntelisis'];
		$numeroPiso7 = $_POST['numeroPiso'];
		$areaConstruida7 = $_POST['areaConstruida7'];
		
		
		$op7 = array(
				'numeroPiso'	=> $numeroPiso7,
				'areaConstruida'	=> $areaConstruida7,
				'inmuebleIntelisis' => $inmueble
			);
			$this->db->insert('pisos', $op7);

		echo true;
		exit;

	}
	
	public function piso8(){
		$inmueble = $_POST['inmuebleIntelisis'];
		$numeroPiso8 = $_POST['numeroPiso'];
		$areaConstruida8 = $_POST['areaConstruida8'];
		
		
		$op8 = array(
				'numeroPiso'	=> $numeroPiso8,
				'areaConstruida'	=> $areaConstruida8,
				'inmuebleIntelisis' => $inmueble
			);
			$this->db->insert('pisos', $op8);

		echo true;
		exit;

	}
	
	public function piso9(){
		$inmueble = $_POST['inmuebleIntelisis'];
		$numeroPiso9 = $_POST['numeroPiso'];
		$areaConstruida9 = $_POST['areaConstruida9'];
		
		
		$op9 = array(
				'numeroPiso'	=> $numeroPiso9,
				'areaConstruida'	=> $areaConstruida9,
				'inmuebleIntelisis' => $inmueble
			);
			$this->db->insert('pisos', $op9);

		echo true;
		exit;

	}
	
	public function piso10(){
		$inmueble = $_POST['inmuebleIntelisis'];
		$numeroPiso10 = $_POST['numeroPiso'];
		$areaConstruida10 = $_POST['areaConstruida10'];
		
		
		$op10 = array(
				'numeroPiso'	=> $numeroPiso10,
				'areaConstruida'	=> $areaConstruida10,
				'inmuebleIntelisis' => $inmueble
			);
			$this->db->insert('pisos', $op10);

		echo true;
		exit;

	}
	
	public function predio(){

		$PREDIO_ID = $_POST['PREDIO_ID'];		
		$NOMBRE_DE_PREDIO = $_POST['NOMBRE_DE_PREDIO'];
		$INMUEBLE_ID = $_POST['INMUEBLE_ID'];
		$CALLE = $_POST['CALLE'];
		$NUMERO_INTERIOR = $_POST['NUMERO_INTERIOR'];
		$NUMERO_EXTERIOR = $_POST['NUMERO_EXTERIOR'];
		$SUPERFICIE_TERRENO = $_POST['SUPERFICIE_TERRENO'];
		$CODIGO_POSTAL = $_POST['CODIGO_POSTAL'];
		$COLONIA = $_POST['COLONIA'];
		$DELEGACION_MUNICIPIO = $_POST['DELEGACION_MUNICIPIO'];
		$ESTADO = $_POST['ESTADO'];
		$CIUDAD = $_POST['CIUDAD'];
		
		$AREA_CONSTRUIDA = $_POST['vectoresData'];
		explode(",",$AREA_CONSTRUIDA);
		
		if($PREDIO_ID == ''){
		
				if($NUMERO_EXTERIOR != ""){		
				$op10 = array(
						'NOMBRE_DE_PREDIO' => $NOMBRE_DE_PREDIO,
						'INMUEBLE_ID' => $INMUEBLE_ID,
						'ESTATUS_DE_PREDIO' => 'ALTA',
						'FECHA_INICIO' => '2009-01-01',
						'CALLE' => $CALLE.'-',
						'NUMERO_EXTERIOR' => $NUMERO_EXTERIOR,
						'NUMERO_INTERIOR' => $NUMERO_INTERIOR,
						'SUPERFICIE_TERRENO' => $SUPERFICIE_TERRENO,
						'COLONIA' => $COLONIA,
						'DELEGACION_MUNICIPIO' => $DELEGACION_MUNICIPIO,
						'ESTADO' => $ESTADO,
						'CIUDAD' => $CIUDAD,
						'CODIGO_POSTAL' => $CODIGO_POSTAL,
						'PAIS' => 'MEXICO',
						'CREATED_BY' => '-1',
						'CREATION_DATE' => '2009-01-01'
					);
					$this->db->insert('layouts_predial', $op10);
					echo true;
				exit;
				}else{
					$op10 = array(
						'NOMBRE_DE_PREDIO' => $NOMBRE_DE_PREDIO,
						'INMUEBLE_ID' => $INMUEBLE_ID,
						'ESTATUS_DE_PREDIO' => 'ALTA',
						'FECHA_INICIO' => '2016-07-07',
						'CALLE' => $CALLE.'-',
						'NUMERO_EXTERIOR' => ',',
						'NUMERO_INTERIOR' => $NUMERO_INTERIOR,
						'SUPERFICIE_TERRENO' => $SUPERFICIE_TERRENO,
						'COLONIA' => $COLONIA,
						'DELEGACION_MUNICIPIO' => $DELEGACION_MUNICIPIO,
						'ESTADO' => $ESTADO,
						'CIUDAD' => $CIUDAD,
						'CODIGO_POSTAL' => $CODIGO_POSTAL,
						'PAIS' => 'MEXICO',
						'CREATED_BY' => '-1',
						'CREATION_DATE' => '2009-01-01'
					);
					$this->db->insert('layouts_predial', $op10);
					echo true;
				exit;
					
				}
		}else{
			
				if($NUMERO_EXTERIOR != ""){		
				$op10 = array(
						'NOMBRE_DE_PREDIO' => $NOMBRE_DE_PREDIO,
						'INMUEBLE_ID' => $INMUEBLE_ID,
						'ESTATUS_DE_PREDIO' => 'ALTA',
						'FECHA_INICIO' => '2009-01-01',
						'CALLE' => $CALLE,
						'NUMERO_EXTERIOR' => $NUMERO_EXTERIOR,
						'NUMERO_INTERIOR' => $NUMERO_INTERIOR,
						'SUPERFICIE_TERRENO' => $SUPERFICIE_TERRENO,
						'CODIGO_POSTAL' => $CODIGO_POSTAL,
						'PAIS' => 'MEXICO',
						'CREATED_BY' => '-1',
						'CREATION_DATE' => '2009-01-01'
					);
					$this->db->where('PREDIO_ID', $PREDIO_ID);
					$this->db->update('layouts_predial', $op10);
				
				foreach($AREA_CONSTRUIDA as $ar){
					foreach($ar as $a){
					$actualizarDatos[] = array(
						'INMUEBLE_ID' => $INMUEBLE_ID,
						'PREDIO_ID' => $PREDIO_ID,
						'ESTATUS_PISO' => 'ALTA',
						'CATEGORIA_PISO' => 'PT',
						'NIVEL_PISO' => $a['piso'],
						'AREA_CONSTRUIDA' => $a['area'],
						'CREATED_BY' => '-1',
						'CREATION_DATE' => '2009-01-01'
					);
					}
				}
				
				$this->db->insert_batch('layouts_piso', $actualizarDatos);	
					
					
					echo true;
				exit;
				}else{
					$op10 = array(
						'NOMBRE_DE_PREDIO' => $NOMBRE_DE_PREDIO,
						'INMUEBLE_ID' => $INMUEBLE_ID,
						'ESTATUS_DE_PREDIO' => 'ALTA',
						'FECHA_INICIO' => '2016-07-07',
						'CALLE' => $CALLE,
						'NUMERO_EXTERIOR' => ',',
						'NUMERO_INTERIOR' => $NUMERO_INTERIOR,
						'SUPERFICIE_TERRENO' => $SUPERFICIE_TERRENO,
						'CODIGO_POSTAL' => $CODIGO_POSTAL,
						'PAIS' => 'MEXICO',
						'CREATED_BY' => '-1',
						'CREATION_DATE' => '2009-01-01'
					);
					$this->db->where('PREDIO_ID', $PREDIO_ID);
					$this->db->update('layouts_predial', $op10);
					
					foreach($AREA_CONSTRUIDA as $ar){
						foreach($ar as $a){	
						$actualizarDatos[] = array(
							'INMUEBLE_ID' => $INMUEBLE_ID,
							'PREDIO_ID' => $PREDIO_ID,
							'ESTATUS_PISO' => 'ALTA',
							'CATEGORIA_PISO' => 'PT',
							'NIVEL_PISO' => $a['piso'],
							'AREA_CONSTRUIDA' => $a['area'],
							'CREATED_BY' => '-1',
							'CREATION_DATE' => '2009-01-01'
						);
						}
				}
				
				$this->db->insert_batch('layouts_piso', $actualizarDatos);	
					
					
					echo true;
				exit;
					
				}
			
		}
		
		

	}
	
	function statusInmueble()
	{
		$status       	= $_POST['status'];
		$inmueble       	= $_POST['inmuebleIntelisis'];

		$update = array('status' => $status);
		$this->db->where('Inmueble', $inmueble);
		$this->db->update('borrar_vic_inmueble', $update);

		echo json_encode($op);
	}
	
	function statusGrupo()
	{
		$status       	= $_POST['status'];
		$nombre       	= $_POST['nombre'];

		$update = array('status' => $status);
		$this->db->where('nombre', $nombre);
		$this->db->update('tempora_grupos_locales', $update);

		echo json_encode($op);
	}
	
	function eliminarGrupo()
	{
		$nombre       	= $_POST['nombre'];
		$id       	= $_POST['id'];
		$minimo       	= $_POST['minimo'];
		$maximo       	= $_POST['maximo'];
		$descuento       	= $_POST['descuento'];
		$status       	= $_POST['status'];
		$periodo       	= $_POST['periodo'];

		$update = array('id'=>$id,'nombre'=> $nombre, 'minimo'=> $minimo, 'maximo'=> $maximo, 'descuento'=> $descuento, 'status'=> $status, 'periodo'=> $periodo);
		$upd = array('grupoId'=>'');
		$this->db->where('nombre', $nombre);
		$this->db->delete('tempora_grupos_locales', $update);
		$this->db->where('grupoId', $nombre);
		$this->db->update('vector', $upd) ;

		echo json_encode($op);
	}
	
	function asignarInmueble()
	{
		$Inmueble       	= $_POST['Inmueble'];
		$usuario       	= $_POST['usuario_id'];

		$update = array('usuario_id' => $usuario);
		$this->db->where('Inmueble', $Inmueble);
		$this->db->update('borrar_vic_inmueble', $update);

		echo json_encode($op);
		
	}
	function desasignarInmueble()
	{
		$Inmueble       	= $_POST['Inmueble'];

		$update = array('usuario_id' => '');
		$this->db->where('Inmueble', $Inmueble);
		$this->db->update('borrar_vic_inmueble', $update);

		echo json_encode($op);
		
	}
	
	function cuentaEntradaModulos()
	{
		$user = $this->session->userdata('usuario');
		
		$usuarioID       					= $_POST['usuarioID'];
		$fechaAcceso						= $_POST['fechaAcceso'];
		$modulo       						= $_POST['modulo'];
		$numeroEntradasGeneral	= $_POST['numeroEntradasGeneral'];
		
		if ($user['fechaEntradaGeneral'] != $fechaAcceso){
			$update = array('numeroEntradasGeneral' => $numeroEntradasGeneral, 'fechaEntradaGeneral' => $fechaAcceso);
			$this->db->where('usuarioID', $usuarioID);
			$this->db->update('usuarios', $update);
			
			echo json_encode($op);
		}
		
		$insert = array('usuarioID' => $usuarioID, 'fechaAcceso' => $fechaAcceso, 'modulo' => $modulo); 
		$this->db->insert('usuarios_accesos', $insert);
			
		echo json_encode($op);
		
	}
	

//----------------------------------------
	function traeCiPorPlaza(){

		$plaza 	= $_POST['plaza'];
		$ci		= $this->tempciri_model->cargarCiPorPLaza($plaza);
		echo json_encode($ci);
		exit;

	}

	function cargarPlazasDir(){

		$plazaId	= $_POST['plazaId'];
		$plazaPiso 	= $_POST['plazaPiso'];
		$ci			= $this->tempciri_model->cargarPLazasDir($plazaId,$plazaPiso);
		echo json_encode($ci);
		exit;

	}
	
	function cargarPlazaPisos(){

		$plazaId	= $_POST['plazaId'];
		$ci			= $this->tempciri_model->cargarPLazaPisos($plazaId);
		echo json_encode($ci);
		exit;

	}

	function traeFolioGenerar(){

		$documento 	= $_POST['documento'];
		$plaza		= $_POST['plaza'];

		$plazaDatos 		= $this->tempciri_model->traerDatosPLaza($plaza);
		if($documento == 'CI')
			echo $plazaDatos[0]->ci_num + 1;
		else
			echo $plazaDatos[0]->ri_num + 1;

		exit;

	}

	function traeCiDatos(){

		$ciId		= $_POST['ciId'];
		$datosCi	= $this->tempciri_model->traerDatosCi($ciId);
		echo json_encode($datosCi[0]);
		exit;

	}
	
	function trae_pisos_por_predio(){

		$predio_id		= $_POST['predio_id'];
		$datos_pisos	= $this->prospectos_model->traer_pisos_por_predio($predio_id);
		echo json_encode($datos_pisos);
		exit;

	}

	function guardar_local_intelisis(){

		$intelisis_ref = $_POST['intelisis_ref'];
		
		$inmueble_id = $_POST['inmueble_id'];
		$marca 		= $_POST['marca'];
		$tipo		= $_POST['tipo'];
		$estatus	= $_POST['estatus'];
		$predio		= $_POST['predio'];
		$piso		= $_POST['piso'];
		$medida		= $_POST['medida'];
		$uso_local	= $_POST['uso_local'];

		$local_layout = $this->planogramas_model->traer_local_layout($intelisis_ref);

		if(sizeof($local_layout) > 0){
			$info = array(
				'CATEGORIA_LOCAL'	=> $marca,
				'TIPO_DE_LOCAL'		=> $tipo,
				'ESTATUS_LOCAL'		=> $estatus,
				'PREDIO_ID'			=> $predio,
				'PISO_ID'			=> $piso,
				'AREA_RENTABLE'		=> $medida,
				'USO_LOCAL'			=> $uso_local
			);
			$this->db->where('INTELISIS_ID', $intelisis_ref);
			$this->db->update('layouts_local', $info);
			
		}else{
			$info = array(
				'CATEGORIA_LOCAL'	=> $marca,
				'INMUEBLE_ID'		=> $inmueble_id,
				'TIPO_DE_LOCAL'		=> $tipo,
				'ESTATUS_LOCAL'		=> $estatus,
				'PREDIO_ID'			=> $predio,
				'PISO_ID'			=> $piso,
				'AREA_RENTABLE'		=> $medida,
				'INTELISIS_ID'		=> $intelisis_ref,
				'USO_LOCAL'			=> $uso_local
			);
			$this->db->insert('layouts_local', $info);
		}
		exit;
		
	}

	function cancelarCi(){

		$ciId = $_POST['ciId'];

		$this->db->where('id', $ciId);
		$this->db->update('TEMPORA_CI', array('estado'=>'cancelado'));

	}

	function cancelarRi(){

		$riId = $_POST['riId'];

		$this->db->where('id', $riId);
		$this->db->update('TEMORA_RI', array('estado'=>'cancelado'));

	}

	function saveSingFile(){

		$return = array();

		$cartaIntId = $_POST['cartaIntId'];

		$permitidos =  array('gif','png','jpg','pdf');

		$extArchivo = pathinfo($_FILES['firma']['name'], PATHINFO_EXTENSION);

		if( !in_array($extArchivo,$permitidos) || empty($extArchivo) ) {

			$return['message']	= "Favor de ingresar archivos válidos";
			$return['success']	= false;
			echo json_encode($return);
			exit;

		}

		//Insertar archivo comprobante de pago
		$archivoNombre	= 'CI_'.$cartaIntId.'_firmado.'.$extArchivo;

		move_uploaded_file($_FILES['firma']['tmp_name'],DIRCIDOCS.$archivoNombre);
		$data = array(
			'ciId'			=> $cartaIntId,
		   	'docTipo'		=> 'documentoFirmado',
		   	'archivoNombre'	=> $archivoNombre
		);
		$this->db->insert('TEMPORA_CI_ARCHIVOS', $data);

		$this->db->where('id', $cartaIntId);
		$this->db->update('TEMPORA_CI', array('estado'=>'Activo'));

		$return['message']	= "Documento cargado.";
		$return['success']	= true;
		echo json_encode($return);
		exit;

	}

	function cargar_detalle_rap(){
	
		$id	= $_POST['id'];
		$detalle_rap = $this->prospectos_model->detalle_rap($id);
		echo json_encode($detalle_rap[0]);
		exit;
	
	}

	function tipoDepositoVista(){
		// Si es traspaso lo manda a la vista traspaso
		if($this->uri->segment(3) == '1'){
			$this->load->view('traspasoForm-view');
		}
		if($this->uri->segment(3) == '3'){
			$this->load->view('depositoForm-view');
		}
		if($this->uri->segment(3) == '2'){
			$this->load->view('terminalForm-view');
		}

	}

	function cargarProspectos(){
		$filtro = $this->uri->segment(3);
		if(!$filtro){
			echo '<span class="errorAjax">Escriba un dato valido</span>';
		}
		else{
			$op['data']	= $email = $this->prospectos_model->cargarProspectosCotizacion($filtro);
			if($email){
			$this->load->view('resultadoProspectos-view' ,$op);
		}
		else{
			$op['data']	= $cotizacion = $this->prospectos_model->cargarCotizacion($filtro);
			if($cotizacion){
				$this->load->view('resultadoCotizacion-view' ,$op);
			}
			else{
				echo '<span class="errorAjax">No se encontro ningun cliente con esa información</span>';
				}
			}
		}
	}

	function cargarResultado(){
		$prospectoID = $this->uri->segment(3);
		$op['data'] = $this->prospectos_model->cuentaCotizacionProspectoActivas($prospectoID);

		$this->load->view('resultadoCotizacionProspecto-view' ,$op);

	}

	function cargarLocalesBusquedaRapida(){
		$busqueda = $this->uri->segment(3);
		$op['data'] = $this->prospectos_model->cargarLocalesCotizacionID($busqueda);

		$this->load->view('resFinal-view' ,$op);

	}

	function cargarResultadoCartas(){
		$data 		= $_POST['alldata'];

		$op['data'] = $this->tempciri_model->busquedaCartasIntencion($data);

		$this->load->view('busquedaCIAvanzada-view' ,$op);

	}
	
	function cargarResultadoUsuarios(){

		
		$nombreCompleto	= $_POST['nombreCompleto'];
		$email		= $_POST['email'];

		$op['data']  = $this->administrador_model->busquedaEmail($email, $nombreCompleto);
		  $this->load->view('busquedaEmailAvanzada', $op);	
	}

	function cargarResultadoUsuariosPosp(){

		$nombreCompleto	= $_POST['nombreCompleto'];
		$email		= $_POST['email'];

		$op['data']  = $this->administrador_model->busquedaEmailPros($email, $nombreCompleto);

		  $this->load->view('busquedaEmailAvandazadaPrpspectos', $op);	

	}

     

	function cargarResultadoRap(){
		
		$plaza_id	= $_POST['plaza_id'];
		$rap		= $_POST['rap'];

		$op['referencias'] = $this->prospectos_model->busquedaRaps($rap,$plaza_id);

		$this->load->view('busquedaRap-view' ,$op);

	}
	
	function cargarResultadoProsVend(){
		$data 		= $_POST['alldata'];

		$op['data'] = $this->prospectos_model->busquedaProsVenFec($data);
		$op['cuenta'] = $this->prospectos_model->busquedaCuentaVenFec($data);

		$this->load->view('prospectosVendedorFecha-view' ,$op);

	}
	
	function cargaResultadosVendedores(){
		$op['data']  = $_POST['alldata'];

		$this->load->view('cargaResultadosVendedores' ,$op);
	}

	function cargaResultadosCartaIntencion(){
		$op['data']  =$_POST['alldata'];

		$this->load->view('cargaResultadosCartaIntencion' ,$op);
	}

	function cargarUsuarios(){
		$data 		= $_POST['alldata'];
		$op['data'] = $this->evaluaciones_model->busquedaUsuariosAjax($data);

		$this->load->view('busquedaUsuariosAvanzada-view' ,$op);

	}

	function cargarUsuariosAcalificar(){
		$data 		= $_POST['alldata'];
		$op['data'] = $this->evaluaciones_model->busquedaUsuariosAjax($data);

		$this->load->view('busquedaUsuariosAvanzadaAcalificar-view' ,$op);
	}

	function calificaCalificador(){
		$this->load->view('formCalificaCalificador-view');
	}
	
	
	function cargarColoniasObras()
	{
		$val = $_POST['val'];
		$idVal = $_POST['idVal'];
		$sc = $this->db->query("select nombreColonia from estadosmexico where codigoCP ='$val' group by nombreColonia");

		$lista_opciones = '<option value="0">Colonia</option>
		';

		foreach($sc->result() as $row){
			$lista_opciones .= "<option value='".$row->nombreColonia."'>".$row->nombreColonia."</option>";
		}
		echo $lista_opciones;
	}
	
	function cargarMunicipioObras()
	{
		$val = $_POST['val'];
		$idVal = $_POST['idVal'];

		$sc = $this->db->query("select nombreMunicipio from estadosmexico where codigoCP ='$val' group by nombreMunicipio");
		
		$lista_opciones ='';
		
		foreach($sc->result() as $row){
			$lista_opciones =  $row->nombreMunicipio;
		}
		echo $lista_opciones;
	}
	
	function cargarEstadoObras()
	{
		$val = $_POST['val'];
		$idVal = $_POST['idVal'];

		$sc = $this->db->query("select nombreEstado from estadosmexico where codigoCP ='$val' group by nombreEstado");
		$lista_opciones ='';
		
		foreach($sc->result() as $row){
			$lista_opciones =  $row->nombreEstado;
		}

		echo $lista_opciones;
	}
	
	function cargarCiudadObras()
	{
		$val = $_POST['val'];
		$idVal = $_POST['idVal'];
		$sc = $this->db->query("select nombreCiudad from estadosmexico where codigoCP ='$val' group by nombreCiudad");
		$lista_opciones ='';
		
		foreach($sc->result() as $row){
			$lista_opciones =  $row->nombreCiudad;
		}

		echo $lista_opciones;
	}

}
