<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class evaluacionestwo extends MX_Controller {

	function evaluacionestwo()
	{
		parent::__construct();
		$this->user_model->checkuser();
		$this->load->model('prospectos/prospectos_model');
		$this->load->model('evaluacionestwo/evaluacionestwo_model');
	}

	function index(){
		$this->layouts->add_include('assets/js/jquery-ui.js');
		$this->load->model('evaluacionestwo/evaluacionestwo_model');
		$usuarioSesion	= $this->session->userdata('usuario');

		$op['campanias'] = $this->evaluacionestwo_model->cargaCampaniasEvaluaciones($usuarioSesion['usuarioID']);

		$this->layouts->profile('colaboradorIndex-view', $op);
	}

	function usuarioColaborador($usuarioID,$tipo,$campaniaID){

		$usuarioSesion	= $this->session->userdata('usuario');
		$usuario 		= $this->user_model->traeadmin($usuarioID);

		$op['categorias']	= $this->evaluacionestwo_model->evaluacionListaCategorias($campaniaID);
		$op['campania'] 	= $this->evaluacionestwo_model->cargaCampania($campaniaID);

		$valida	= $this->evaluacionestwo_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$usuarioID);
		$eva 	= $this->evaluacionestwo_model->validaEvala($usuarioSesion['usuarioID'],$usuarioID,$campaniaID);

		if($usuarioSesion['usuarioID'] == $usuarioID && $eva){
			redirect('evaluacionestwo/campania/'.$campaniaID);
		}
		else{
			if(isset($valida) && empty($eva)){
				$this->layouts->profile('usuarioColaboradorResultados-view', $op);
			}
			else{
			echo 'No tiene permiso para visualizar o actualizar esta evaluacion';
			}

		}

	}

	function campania($campaniaID){
		$this->layouts->add_include('assets/js/jquery-ui.js');
		$usuarioSesion	= $this->session->userdata('usuario');

		$op['categorias'] = $this->evaluacionestwo_model->evaluacionListaCategorias($campaniaID);
		$op['campania'] = $this->evaluacionestwo_model->infoCampania($campaniaID);

		$op['evaluaciones'] = $this->evaluacionestwo_model->cargaListadeEvaluaciones($usuarioSesion['usuarioID'],$campaniaID);

		$this->layouts->profile('listas-view', $op);
	}
	
	function guardarEvaluacionCol(){

		//Insertar evaluacuón
		$evalData = array(
			'campaniaNombre'	=> ''
		);

		$this->db->insert('evaluacion_colaborador', $evalData);
		$evalID = $this->db->insert_id();
		
		$this->db->where('campaniaID', $_POST['campId']);
		$this->db->update('evaluacion_campanias', array('evaluacionColaboradorId'=>$evalID));

		//Insertar preguntas
		$preguntas 		= $_POST['categ'];
		$preguntasData	= array();
		foreach($preguntas as $cat => $pregDat){

			foreach($pregDat as $preg){

				$preguntasData[] = array(
					'pregunta'					=> $preg,
					'evaluacionColaboradorID'	=> $evalID
				);

			}

		}
		$this->db->insert_batch('evaluacion_colaborador_preguntas', $preguntasData);

		//Insertar Usuarios ----COLABORADORES
			$colEvalData = array();
			foreach($_POST['calificacoID'] as $key => $userId){
				$usuarioQCalif	= $_POST['caliID'][$key];
				$userTemp		= $this->user_model->traeadmin($usuarioQCalif);

				$colEvalData[] = array(
					'usuarioAcalificarID'		=> $userId,
					'usuarioQuecalifica'		=> $usuarioQCalif,
					'evaluacionColaboradorID'	=> $evalID
				);

				$this->enviarEmail($userTemp[0]->email);

			}
			$this->db->insert_batch('evaluacion_colaborador_catalogoevaluadores', $colEvalData);

		redirect('evaluaciones/campania/'.$_POST['campId']);
	}

	function evaluacionColaborador($usuarioQueCalifica,$tipo,$campania){
		$this->layouts->add_include('assets/js/jquery-ui.js');

		$usuarioSesion	= $this->session->userdata('usuario');

		$op['usuarioCalificar'] = $this->user_model->traeadmin($usuarioQueCalifica);
		$op['areas'] = $this->evaluacionestwo_model->cargaAreas();
		$op['cat'] = $this->evaluacionestwo_model->listaCategoriasCatalogo();
		$op['campanias'] = $this->evaluacionestwo_model->cargaTodasEvaluaciones();

		$this->layouts->profile('evaluacionColaborador-view', $op);
	}
	
	

	function guardarCampaniaEvaluacion(){

		//Insertar evaluacuón
		$evalData = array(
			'campaniaNombre'			=> $_POST['campaniaNombre'],
			'campaniaStatus'			=> $_POST['campaniaStatus'],
			'fechaInicio' 				=> $_POST['fechaInicio'],
			'fechaFin' 						=> $_POST['fechaFin'],
			'campaniaNombre'		=> $_POST['campaniaNombre'],
			'campaniaDescripcion'	=> $_POST['campaniaDescripcion']
		);

		$this->db->insert('evaluacion_campanias', $evalData);
		$evalID = $this->db->insert_id();

		//Insertar preguntas
		$preguntas 		= $_POST['categ'];
		$preguntasData	= array();
		foreach($preguntas as $cat => $pregDat){

			foreach($pregDat as $preg){

				$preguntasData[] = array(
					'pregunta'		=> $preg,
					'categoria'		=> $cat,
					'campaniaID'	=> $evalID
				);

			}

		}
		$this->db->insert_batch('evaluacion_preguntas', $preguntasData);
		
		$time = strtotime("-1 year", time());
  		$date = date("Y", $time);
		
		$emailAutoEval = '<style>
				body {background-color:#fafafa;}
				strong   {float:left; width:100%; font-weight:700;}
				p, a{float:left; width:100%;}

				</style>
				<span><img width="200" src="http://www.apeplazas.com/apeConnect/assets/graphics/apeplazas.png" alt="Administración de Plazas Especializadas | Apeplazas"/></span>
				<p>Buen día<p>
				<p>En APE nos encontramos en un periodo de evaluación, la cual realizaremos mediante una herramienta conocida como
					Evaluacion de Desempeño que nos permite conocer y evaluar la conducta y el trabajo de cada colaborador en relación
					a las responsabilidades de su puesto de trabajo.</p>

				<p>Tiene como objetivo reforzar competencias, detectar personal con potencial para ser promovido y retroalimentar a 
				cada colaborador sobre el resultado de su trabajo.<p>
				
				<p>El periodo a evaluar corresponde de Enero a Diciembre de ' . $date . '. Se incluye al personal eventual, el unico requisito es
					tener al menos un mes en la empresa para que se revise el desempeño del colaborador.</p>
					
				<p>La presente evaluación sustituye a la evaluación que se maneja para saber si se renueva el contrato de trabajo por un 
					mes mas en el caso de los colaboradores de nuevo ingreso.</p>
					
				<strong>A continuación, te indicamos los pasos a seguir para cumplir con esta tarea:</strong>

				<p>1.- Dale click en el siguiente enlace, teclea tu usuario y contraseña, si es la primera vez que ingresas al sistema la contraseña es 12345.</p>
				<p>2.- Deberás leer y responder tu autoevaluación colocando el valor que consideres mas adecuado a tu opinión en la columna de Autoevaluado. (Recuerda esta es tu autoevaluación y se requiere una información asertiva)</p>
				<p>3.- Al finalizar tus respuestas da click en el botón enviar información.</p>

				<strong>Informacion Personal</strong>';

		//Insertar Usuarios ----AUTOEVALUACION
		if($_POST['autoEval'] == 'on'){
			$autoEvalData 		= array();
			foreach($_POST['userAutoEval'] as $userId){

				$userTemp		= $this->user_model->traeadmin($userId);

				$autoEvalData[] = array(
					'usuarioAcalificarID'	=> $userId,
					'usuarioQuecalifica'	=> $userId,
					'campaniaID'			=> $evalID
				);

				$this->enviarEmail($userTemp[0]->email,$emailAutoEval.'<p>Usuario: '.$userTemp[0]->email.'</p><a href="'.base_url().'evaluacionestwo/usuarioColaborador/' . $userId . '/1/' . $evalID . '">Da click aquí</a>');

				//Insertar Usuarios ----JEFEDIRECTO
				$tempJefeDir = $this->user_model->traerJefeDirecto($userTemp[0]->jefeDirectoID);
				if( !empty($tempJefeDir) ){
					
					$autoEvalData[] = array(
						'usuarioAcalificarID'	=> $userId,
						'usuarioQuecalifica'	=> $tempJefeDir[0]->usuarioID,
						'campaniaID'			=> $evalID
					);
					$userTemp		= $this->user_model->traeadmin($userId);
				}

			}
			$this->db->insert_batch('evaluacion_catalogoEvaluadores', $autoEvalData);

		}

		//Insertar Usuarios ----COLABORADORES
		if($_POST['colaboradores'] == 'on'){
			$colEvalData = array();
			foreach($_POST['colACalif'] as $key => $userId){
				$usuarioQCalif	= $_POST['colQCalif'][$key];
				$userTemp		= $this->user_model->traeadmin($usuarioQCalif);

				$colEvalData[] = array(
					'usuarioAcalificarID'	=> $userId,
					'usuarioQuecalifica'	=> $usuarioQCalif,
					'campaniaID'			=> $evalID
				);

				$this->enviarEmail($userTemp[0]->email);

			}
			$this->db->insert_batch('evaluacion_catalogoevaluadores', $colEvalData);

		}

		redirect('evaluacionestwo');
	}

	//Funcion para enviar mails
	private function enviarEmail($email,$message){

	 $this->load->library('email');
		 $this->email->set_newline("\r\n");
		 $this->email->from('contacto@apeplazas.com', 'APE Plazas Especializadas');
		 $this->email->to($email);
		 $this->email->subject('EVALUACIÓN DEL DESEMPEÑO');
		 $this->email->message('
			<html>
			 <head>
				<title>Evaluación</title>
			 </head>
			 <body>'.
			 $message .
			 '</body>
			</html>
		 ');
		$this->email->send();

	}

	function usuario($usuarioID,$tipo,$campaniaID){
		$usuarioSesion	= $this->session->userdata('usuario');
		$usuario 				= $this->user_model->traeadmin($usuarioID);
		$this->load->model('evaluaciones/evaluacionestwo_model');
		$op['categorias'] = $this->evaluacionestwo_model->evaluacionListaCategorias();
		$valida = $this->evaluacionestwo_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$usuarioID);

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery.validate.js');
		if(empty($this->uri->segment(5))){
			redirect('evaluacionestwo');
		}
		// Si el tipo de evauluacion sen encuentra en 2 o 3 se verifica el role
		if($tipo == '2' && $usuarioSesion['usuarioID'] != $usuario[0]->jefeDirectoID ){
			redirect('evaluacionestwo/usuario/'.$usuarioSesion['usuarioID'].'/1/'.$campaniaID);
		}
		else if($tipo == '1' && $usuarioSesion['usuarioID'] != $usuarioID ){
			redirect('evaluacionestwo/usuario/'.$usuarioSesion['usuarioID'].'/2/'.$campaniaID);
		}
		else if($tipo == '3' && empty($valida)){
			redirect('evaluacionestwo/usuario/'.$usuarioSesion['usuarioID'].'/2/'.$campaniaID);
		}

		$verifica = $this->evaluacionestwo_model->verificaRespuesta($usuarioID, $tipo, $usuarioSesion['usuarioID']);
		if(empty($verifica)){
			$this->layouts->profile('evaluacion2015-view', $op);
		}
		else{
			$this->layouts->profile('evaluaciones-resultados', $op);
		}

	}

	function generaPreguntas($campaniaID){
		$this->layouts->add_include('assets/js/jquery-ui.js');
		$usuarioSesion	= $this->session->userdata('usuario');

		$op['campanias'] = $this->evaluacionestwo_model->cargaTodasEvaluaciones();

		$this->layouts->profile('agregarPreguntas-view', $op);
	}

	function listaEvaluaciones(){
		$this->layouts->add_include('assets/js/jquery-ui.js');
		$this->load->model('evaluaciones/evaluacionestwo_model');
		$usuarioSesion	= $this->session->userdata('usuario');

		$op['campanias'] = $this->evaluacionestwo_model->cargaTodasEvaluaciones();

		$this->layouts->profile('listaEvaluacionesGenerales-view', $op);
	}

	function formEvaluacion(){
		$this->layouts->add_include('assets/js/jquery-ui.js')
									->add_include('assets/css/jquery-steps.css')
									->add_include('assets/js/jquery.steps.js');

		$usuarioSesion	= $this->session->userdata('usuario');

		$op['areas'] = $this->evaluacionestwo_model->cargaAreas();
		$op['cat'] = $this->evaluacionestwo_model->listaCategoriasCatalogo();
		$op['campanias'] = $this->evaluacionestwo_model->cargaTodasEvaluaciones();

		$this->layouts->profile('formularioEvaluacion-view', $op);
	}




	function evaluacionJefeDirecto($usuarioID,$tipo,$campaniaID){
		$usuarioSesion	= $this->session->userdata('usuario');
		$usuario 		= $this->user_model->traeadmin($usuarioID);
		$this->load->model('evaluaciones/evaluacionestwo_model');
		$op['categorias'] = $this->evaluacionestwo_model->evaluacionListaCategorias($campaniaID);
		$valida = $this->evaluacionestwo_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$usuarioID);

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery.validate.js');
		if(empty($this->uri->segment(5))){
			redirect('evaluacionestwo');
		}

		$verifica 			= $this->evaluacionestwo_model->verificaFormularioJefeDirecto($campaniaID,$usuarioID,$usuarioSesion['usuarioID']);
		$op['detallesCamp']	= $this->evaluacionestwo_model->detalleCamp($campaniaID,$usuarioID);

		if(empty($verifica)){
			redirect('evaluacionestwo');
		}else{
			$this->layouts->profile('evaluacionJefeDirecto-view', $op);
		}

	}
	
	function mostrarEvaluacion($usuarioID,$campaniaID){
		$usuarioSesion	= $this->session->userdata('usuario');
		$usuario 				= $this->user_model->traeadmin($usuarioID);
		$this->load->model('evaluaciones/evaluacionestwo_model');
		$op['categorias'] = $this->evaluacionestwo_model->evaluacionListaCategorias($campaniaID);
		$valida = $this->evaluacionestwo_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$usuarioID);

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery.validate.js');
		if(empty($valida)){
			redirect('evaluacionestwo');
		}

		$this->layouts->profile('mostrarEvaluacion-view', $op);

	}

	function guardarEvaluacionColaborador(){
		$this->load->model('evaluacionestwo/evaluacionestwo_model');
		$usuarioSesion	= $this->session->userdata('usuario');
		$usuario 		= $this->user_model->traeadmin($_POST['usuarioAcalificar']);
		$campania		= $_POST['campania'];
		$valida 		= $this->evaluacionestwo_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$_POST['usuarioAcalificar']);
		$catId			= $this->evaluacionestwo_model->traeCatalogoId($usuarioSesion['usuarioID'],$_POST['usuarioAcalificar'],$campania);

		$data = array();
		foreach ($_POST['evaluacion'] as $key => $value) {

			//if (empty($value)){
			//	redirect('evaluacionestwo/usuario/'.$_POST['usuarioAcalificar'].'./2/'.$_POST['campania']);
			//}

			$data[] = array(
				'respuesta'		=> $value,
				'catalogoId'	=> $catId,
				'preguntaID' 	=> $key,
				'tipo'			=> '1'
			);
		}
		$this->db->insert_batch('evaluacion_respuestas', $data);

		if($usuario[0]->jefeDirectoID){

			$jefeDirecto = $this->user_model->traerJefeDirecto($usuario[0]->jefeDirectoID);
			$this->load->library('email');
			$this->email->set_newline("\r\n");
			$this->email->from('contacto@apeplazas.com', 'APE Plazas Especializadas');
			$this->email->to($jefeDirecto[0]->email);
			$this->email->subject('Evaluación pendiente');
			$this->email->message('
					<html>
						<head>
							<title>Evaluación pendiente</title>
						</head>
						<body>
							<p>El usuario ' . $usuario[0]->nombreCompleto . ' ha completado su autoevaluación, por favor da click en el siguiente link para evaluarlo.</p>
							<a href="'.base_url().'evaluacionestwo/evaluacionJefeDirecto/' . $_POST['usuarioAcalificar'] . '/2/' . $_POST['campania'] . '">Da click aquí</a>
						</body>
					</html>
			');
			$this->email->send();

		}

		redirect('evaluacionestwo');
	}


	function guardarEvaluacionJefeDirecto(){
		$this->load->model('evaluaciones/evaluacionestwo_model');
		$usuarioSesion	= $this->session->userdata('usuario');
		$usuario 		= $this->user_model->traeadmin($_POST['usuarioAcalificar']);
		$tipo			= $_POST['tipo'];
		$campania		= $_POST['campania'];
		$valida = $this->evaluacionestwo_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$_POST['usuarioAcalificar']);

		if($tipo == 2){
		
			$this->load->library('email');
			$this->email->set_newline("\r\n");
			$this->email->from('contacto@apeplazas.com', 'APE Plazas Especializadas');
			$this->email->to($usuarioSesion["email"]);
			$this->email->subject('Evaluación pendiente');
			$this->email->message('
					<html>
						<head>
							<title>Evaluación pendiente</title>
						</head>
						<body>
							<p>Ahora que has evaluado a ' . $usuario[0]->nombreCompleto . ', reunanse para hacer una plan de acción.</p>
							<a href="'.base_url().'evaluacionestwo/evaluacionJefeDirecto/' . $_POST['usuarioAcalificar'] . '/3/' . $campania . '">Da click aquí</a>
						</body>
					</html>
			');
			$this->email->send();
			
		}

		if($valida){
			
			$data	= array();
			$catId	= $this->evaluacionestwo_model->traeCatalogoId($usuarioSesion['usuarioID'],$_POST['usuarioAcalificar'],$campania);
			
			var_dump($_POST['evaluacion']);
			exit();
			
			foreach ($_POST['evaluacion'] as $key => $value) {

				if (empty($value) && $value != 0){
					redirect('evaluacionestwo/evaluacionJefeDirecto/'.$_POST['usuarioAcalificar'].'./' . $tipo . '/'.$_POST['campania']);
				}

				$data[] = array(
					'respuesta'				=> $value,
					'catalogoId'			=> $catId,
					'preguntaID' 			=> $key,
					'tipo'					=> $tipo
				);
			}
			$this->db->insert_batch('evaluacion_respuestas', $data);
			redirect('evaluacionestwo');
		}
		else{
			echo "No tiene permiso";
		}

	}

}

?>