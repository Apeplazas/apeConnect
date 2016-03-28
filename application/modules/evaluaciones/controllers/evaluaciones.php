<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evaluaciones extends MX_Controller {

	function evaluaciones()
	{
		parent::__construct();
		$this->user_model->checkuser();
		$this->load->model('prospectos/prospectos_model');
		$this->load->model('evaluaciones/evaluaciones_model');
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

				$this->enviarEmail($userTemp[0]->email);

				//Insertar Usuarios ----JEFEDIRECTO
				if( $_POST['jefeDirecto'] == 'on' && !empty($userTemp[0]->jefeDirectoI) ){
					$autoEvalData[] = array(
						'usuarioAcalificarID'	=> $userId,
						'usuarioQuecalifica'	=> $userTemp[0]->jefeDirectoID,
						'campaniaID'			=> $evalID
					);
					$tempJefeDir = $this->user_model->traeadmin($userTemp[0]->jefeDirectoID);
					$this->enviarEmail($tempJefeDir[0]->email);
				}

			}
			$this->db->insert_batch('evaluacion_catalogoEvaluadores', $autoEvalData);

		}

		//Insertar Usuarios ----COLABORADORES
		if(isset($_POST['colaboradores']) && $_POST['colaboradores'] == 'on'){
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
		redirect('evaluaciones');
	}

	//Funcion para enviar mails
	private function enviarEmail($email){

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
			 <body>
			 <style>
				body {background-color:#fafafa;}
				strong   {float:left; width:100%; font-weight:700;}
				p, a{float:left; width:100%;}

				</style>
				<span><img width="200" src="http://www.apeplazas.com/apeConnect/assets/graphics/apeplazas.png" alt="Administración de Plazas Especializadas | Apeplazas"/></span>
				<p>Buenas Tardes<p>
				<p>La evaluación del desempeño es una herramienta que permite conocer y evaluar la conducta y el trabajo de cada uno de los colaboradores con relación a las responsabilidades de su puesto de trabajo.</p>

				<p>Para cumplir con esta actividad te indicamos los pasos a seguir:<p>
				<strong>Instrucciones para el Colaborador.</strong>

				<p>1.- (Dale click en el siguiente enlace y teclea el usuario y contraseña proporcionada en este correo) Recibirás un correo electrónico con una liga y contraseña temporal.)</p>
				<p>2.- Deberás ingresar con los datos temporales y cambiar tu contraseña.</p>
				<p>3.- Al entrar al sistema da click en la opción Evaluación de Desempeño 2015.</p>
				<p>4.- Deberás leer y responder tu autoevaluación colocando el valor que consideres mas adecuado a tu opinión en la columna de Autoevaluado. (Recuerda esta es tu autoevaluación y se requiere una información asertiva)</p>
				<p>5.- Al finalizar tus respuestas da click en el botón enviar información.</p>

				<strong>Informacion Personal</strong>
				<p>Email: '.$email.'</p>
				<p>Contraseña: 12345</p>
				<a href="'.base_url().'evaluacionestwo">Da click aquí</a>

			 </body>
			</html>
		 ');
		$this->email->send();

	}

	function generaPreguntas($campaniaID){
		$this->layouts->add_include('assets/js/jquery-ui.js');
		$usuarioSesion	= $this->session->userdata('usuario');

		$op['campanias'] = $this->evaluaciones_model->cargaTodasEvaluaciones();

		$this->layouts->profile('agregarPreguntas-view', $op);
	}

	function listaEvaluaciones(){
		$this->layouts->add_include('assets/js/jquery-ui.js');
		$this->load->model('evaluaciones/evaluaciones_model');
		$usuarioSesion	= $this->session->userdata('usuario');

		$op['campanias'] = $this->evaluaciones_model->cargaTodasEvaluaciones();

		$this->layouts->profile('listaEvaluacionesGenerales-view', $op);
	}

	function formEvaluacion(){
		$this->layouts->add_include('assets/js/jquery-ui.js')
								->add_include('assets/css/jquery-steps.css')
								->add_include('assets/js/jquery.steps.js');

		$usuarioSesion	= $this->session->userdata('usuario');

		$op['areas'] = $this->evaluaciones_model->cargaAreas();
		$op['cat'] = $this->evaluaciones_model->listaCategoriasCatalogo();
		$op['campanias'] = $this->evaluaciones_model->cargaTodasEvaluaciones();

		$this->layouts->profile('formularioEvaluacion-view', $op);
	}

	function index(){
		$this->layouts->add_include('assets/js/jquery-ui.js');
		$this->load->model('evaluaciones/evaluaciones_model');
		$usuarioSesion	= $this->session->userdata('usuario');

		$op['campanias'] = $this->evaluaciones_model->cargaCampaniasEvaluaciones($usuarioSesion['usuarioID']);

		$this->layouts->profile('index-view', $op);
	}

	function campania($campaniaID){
		$this->layouts->add_include('assets/js/jquery-ui.js');
		$this->load->model('evaluaciones/evaluaciones_model');
		$usuarioSesion	= $this->session->userdata('usuario');

		$op['categorias'] = $this->evaluaciones_model->evaluacionListaCategorias();
		$op['campania'] = $this->evaluaciones_model->infoCampania($campaniaID);

		$op['evaluaciones'] = $this->evaluaciones_model->cargaListadeEvaluaciones($usuarioSesion['usuarioID'],$campaniaID);

		$this->layouts->profile('listas-view', $op);
	}

	function usuario($usuarioID,$tipo,$campaniaID){
		$usuarioSesion	= $this->session->userdata('usuario');
		$usuario 				= $this->user_model->traeadmin($usuarioID);
		$this->load->model('evaluaciones/evaluaciones_model');
		$op['categorias'] = $this->evaluaciones_model->evaluacionListaCategorias();
		$valida = $this->evaluaciones_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$usuarioID);

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery.validate.js');
		if(empty($this->uri->segment(5))){
			redirect('evaluaciones');
		}
		// Si el tipo de evauluacion sen encuentra en 2 o 3 se verifica el role
		if($tipo == '2' && $usuarioSesion['usuarioID'] != $usuario[0]->jefeDirectoID ){
			redirect('evaluaciones/usuario/'.$usuarioSesion['usuarioID'].'/1/'.$campaniaID);
		}
		else if($tipo == '1' && $usuarioSesion['usuarioID'] != $usuarioID ){
			redirect('evaluaciones/usuario/'.$usuarioSesion['usuarioID'].'/2/'.$campaniaID);
		}
		else if($tipo == '3' && empty($valida)){
			redirect('evaluaciones/usuario/'.$usuarioSesion['usuarioID'].'/2/'.$campaniaID);
		}

		$verifica = $this->evaluaciones_model->verificaRespuesta($usuarioID, $tipo, $usuarioSesion['usuarioID']);
		if(empty($verifica)){
			$this->layouts->profile('evaluacion2015-view', $op);
		}
		else{
			$this->layouts->profile('evaluaciones-resultados', $op);
		}

	}

	function guardarEvaluacion(){
		$this->load->model('evaluaciones/evaluaciones_model');
		$usuarioSesion	= $this->session->userdata('usuario');
		$usuario 				= $this->user_model->traeadmin($_POST['usuarioAcalificar']);
		$valida = $this->evaluaciones_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$_POST['usuarioAcalificar']);
		$tipo = $_POST['tipo'];

		if($tipo == '1' && $usuarioSesion['usuarioID'] != $_POST['usuarioAcalificar']){
			echo 'Tu usuario ha sido almacenado y puesto en observacion fraudulenta';
			die;
		}
		else if($tipo == '2' && $usuarioSesion['usuarioID'] != $usuario[0]->jefeDirectoID){
			echo 'Tu usuario ha sido almacenado y puesto en observacion fraudulenta';
			die;
		}
		else if($tipo == '3' && !$valida){
			echo 'Tu usuario ha sido almacenado y puesto en observacion fraudulenta';
			die;
		}

		$data = array();
		foreach ($_POST['evaluacion'] as $key => $value) {

			if (empty($value)){
				redirect('evaluaciones/usuario/'.$_POST['usuarioAcalificar'].'/'.$tipo.'/'.$_POST['campania']);
			}

			$data[] = array(
				'respuesta'						=> $value,
				'usuarioQueCalifico'	=> $usuarioSesion['usuarioID'],
				'preguntaID' 					=> $key,
				'usuarioAcalificar'		=> $_POST['usuarioAcalificar'],
				'tipo'								=> $tipo
			);
		}
		$this->db->insert_batch('evaluacion_respuestas', $data);

		redirect('evaluaciones/campania/'.$_POST['campania']);
	}

}

?>
