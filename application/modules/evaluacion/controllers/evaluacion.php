<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class evaluacion extends MX_Controller {

	function evaluacion()
	{
		parent::__construct();
		$this->user_model->checkuser();
		$this->load->model('prospectos/prospectos_model');
		$this->load->model('evaluacion/evaluacion_model');
	}

	function index(){
		$this->layouts->add_include('assets/js/jquery-ui.js');
		$this->load->model('evaluacion/evaluacion_model');
		$usuarioSesion	= $this->session->userdata('usuario');

		$op['campanias'] = $this->evaluacion_model->cargaCampaniasEvaluaciones($usuarioSesion['usuarioID']);

		$this->layouts->profile('colaboradorIndex-view', $op);
	}

	function usuarioColaborador($usuarioID,$tipo,$campaniaID){

		$usuarioSesion	= $this->session->userdata('usuario');
		$usuario 				= $this->user_model->traeadmin($usuarioID);

		$op['categorias'] = $this->evaluacion_model->evaluacionListaCategorias($campaniaID);
		$valida = $this->evaluacion_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$usuarioID);
		$eva = $this->evaluacion_model->validaEvala($usuarioSesion['usuarioID'],$usuarioID,$campaniaID);

		if($usuarioSesion['usuarioID'] == $usuarioID && $eva){
			redirect('evaluacion/campania/'.$campaniaID);
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

		$op['categorias'] = $this->evaluacion_model->evaluacionListaCategorias($campaniaID);
		$op['campania'] = $this->evaluacion_model->infoCampania($campaniaID);

		$op['evaluaciones'] = $this->evaluacion_model->cargaListadeEvaluaciones($usuarioSesion['usuarioID'],$campaniaID);

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
		$op['areas'] = $this->evaluacion_model->cargaAreas();
		$op['cat'] = $this->evaluacion_model->listaCategoriasCatalogo();
		$op['campanias'] = $this->evaluacion_model->cargaTodasEvaluaciones();

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

				//$this->enviarEmail($userTemp[0]->email);

				//Insertar Usuarios ----JEFEDIRECTO
				if( $_POST['jefeDirecto'] == 'on' && !empty($userTemp[0]->jefeDirectoID) ){
					$autoEvalData[] = array(
						'usuarioAcalificarID'	=> $userId,
						'usuarioQuecalifica'	=> $userTemp[0]->jefeDirectoID,
						'campaniaID'			=> $evalID
					);
					$tempJefeDir = $this->user_model->traeadmin($userTemp[0]->jefeDirectoID);
					//$this->enviarEmail($tempJefeDir[0]->email);
				}

			}
			$this->db->insert_batch('evaluacion_catalogoevaluadores', $autoEvalData);

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

		redirect('evaluaciones/generaPreguntas/'.$evalID);
	}

	//Funcion para enviar mails
	private	function enviarEmail($email){



	}

	function generaPreguntas($campaniaID){
		$this->layouts->add_include('assets/js/jquery-ui.js');
		$usuarioSesion	= $this->session->userdata('usuario');

		$op['campanias'] = $this->evaluacion_model->cargaTodasEvaluaciones();

		$this->layouts->profile('agregarPreguntas-view', $op);
	}

	function listaEvaluaciones(){
		$this->layouts->add_include('assets/js/jquery-ui.js');
		$this->load->model('evaluaciones/evaluacion_model');
		$usuarioSesion	= $this->session->userdata('usuario');

		$op['campanias'] = $this->evaluacion_model->cargaTodasEvaluaciones();

		$this->layouts->profile('listaEvaluacionesGenerales-view', $op);
	}

	function formEvaluacion(){
		$this->layouts->add_include('assets/js/jquery-ui.js')
									->add_include('assets/css/jquery-steps.css')
									->add_include('assets/js/jquery.steps.js');

		$usuarioSesion	= $this->session->userdata('usuario');

		$op['areas'] = $this->evaluacion_model->cargaAreas();
		$op['cat'] = $this->evaluacion_model->listaCategoriasCatalogo();
		$op['campanias'] = $this->evaluacion_model->cargaTodasEvaluaciones();

		$this->layouts->profile('formularioEvaluacion-view', $op);
	}




	function evaluacionJefeDirecto($usuarioID,$tipo,$campaniaID){
		$usuarioSesion	= $this->session->userdata('usuario');
		$usuario 				= $this->user_model->traeadmin($usuarioID);
		$this->load->model('evaluaciones/evaluacion_model');
		$op['categorias'] = $this->evaluacion_model->evaluacionListaCategorias($campaniaID);
		$valida = $this->evaluacion_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$usuarioID);

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery.validate.js');
		if(empty($this->uri->segment(5))){
			redirect('evaluaciones');
		}

		$verifica = $this->evaluacion_model->verificaFormularioJefeDirecto($campaniaID,$usuarioID);

		//if(empty($verifica)){
			$this->layouts->profile('evaluacionJefeDirecto-view', $op);
		//}else{

			//redirect('evaluacion/campania/'.$campaniaID);
		//}

	}

	function guardarEvaluacionColaborador(){
		$this->load->model('evaluaciones/evaluaciones_model');
		$usuarioSesion	= $this->session->userdata('usuario');
		$usuario 		= $this->user_model->traeadmin($_POST['usuarioAcalificar']);
		$valida 		= $this->evaluacion_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$_POST['usuarioAcalificar']);

		$data = array();
		foreach ($_POST['evaluacion'] as $key => $value) {

			//if (empty($value)){
			//	redirect('evaluacion/usuario/'.$_POST['usuarioAcalificar'].'./2/'.$_POST['campania']);
			//}

			$data[] = array(
				'respuesta'						=> $value,
				'usuarioQueCalifico'	=> $usuarioSesion['usuarioID'],
				'preguntaID' 					=> $key,
				'usuarioAcalificar'		=> $_POST['usuarioAcalificar'],
				'tipo'								=> '1'
			);
		}
		$this->db->insert_batch('evaluacion_respuestas', $data);

		if($usuario[0]->jefeDirectoID){

			$jefeDirecto = $this->user_model->traeadmin($usuario[0]->jefeDirectoID);
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
							<p>El usuario ' . $usuario[0]->nombreCompleto . ' necesita ser evaluado.</p>
						</body>
					</html>
			');
			$this->email->send();

		}

		redirect('evaluacion/campania/'.$_POST['campania']);
	}


	function guardarEvaluacionJefeDirecto(){
		$this->load->model('evaluaciones/evaluacion_model');
		$usuarioSesion	= $this->session->userdata('usuario');
		$usuario 		= $this->user_model->traeadmin($_POST['usuarioAcalificar']);
		$tipo			= $_POST['tipo'];
		$valida = $this->evaluacion_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$_POST['usuarioAcalificar']);


		if($valida){
			$data = array();
			foreach ($_POST['evaluacion'] as $key => $value) {

				if (empty($value)){
					redirect('evaluacion/usuario/'.$_POST['usuarioAcalificar'].'./' . $tipo . '/'.$_POST['campania']);
				}

				$data[] = array(
					'respuesta'				=> $value,
					'usuarioQueCalifico'	=> $usuarioSesion['usuarioID'],
					'preguntaID' 			=> $key,
					'usuarioAcalificar'		=> $_POST['usuarioAcalificar'],
					'tipo'					=> $tipo
				);
			}
			$this->db->insert_batch('evaluacion_respuestas', $data);
			redirect('evaluacion/campania/'.$_POST['campania']);
		}
		else{
			echo "No tiene permiso";
		}

	}

}

?>
