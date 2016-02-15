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
		$usuario 				= $this->user_model->traeadmin($usuarioID);

		$op['categorias'] = $this->evaluacionestwo_model->evaluacionListaCategorias($campaniaID);
		$valida = $this->evaluacionestwo_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$usuarioID);
		$eva = $this->evaluacionestwo_model->validaEvala($usuarioSesion['usuarioID'],$usuarioID,$campaniaID);

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
		$usuario 				= $this->user_model->traeadmin($usuarioID);
		$this->load->model('evaluaciones/evaluacionestwo_model');
		$op['categorias'] = $this->evaluacionestwo_model->evaluacionListaCategorias($campaniaID);
		$valida = $this->evaluacionestwo_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$usuarioID);

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery.validate.js');
		if(empty($this->uri->segment(5))){
			redirect('evaluaciones');
		}

		$verifica = $this->evaluacionestwo_model->verificaFormularioJefeDirecto($campaniaID,$usuarioID);

		//if(empty($verifica)){
			$this->layouts->profile('evaluacionJefeDirecto-view', $op);
		//}else{

			//redirect('evaluacionestwo/campania/'.$campaniaID);
		//}

	}

	function guardarEvaluacionColaborador(){
		$this->load->model('evaluaciones/evaluaciones_model');
		$usuarioSesion	= $this->session->userdata('usuario');
		$usuario 		= $this->user_model->traeadmin($_POST['usuarioAcalificar']);
		$valida 		= $this->evaluacionestwo_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$_POST['usuarioAcalificar']);

		$data = array();
		foreach ($_POST['evaluacion'] as $key => $value) {

			if (empty($value)){
				redirect('evaluacionestwo/usuario/'.$_POST['usuarioAcalificar'].'./2/'.$_POST['campania']);
			}

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

		redirect('evaluacionestwo/campania/'.$_POST['campania']);
	}


	function guardarEvaluacionJefeDirecto(){
		$this->load->model('evaluaciones/evaluacionestwo_model');
		$usuarioSesion	= $this->session->userdata('usuario');
		$usuario 		= $this->user_model->traeadmin($_POST['usuarioAcalificar']);
		$tipo			= $_POST['tipo'];
		$valida = $this->evaluacionestwo_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$_POST['usuarioAcalificar']);


		if($valida){
			$data = array();
			foreach ($_POST['evaluacion'] as $key => $value) {

				if (empty($value)){
					redirect('evaluacionestwo/usuario/'.$_POST['usuarioAcalificar'].'./' . $tipo . '/'.$_POST['campania']);
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
			redirect('evaluacionestwo/campania/'.$_POST['campania']);
		}
		else{
			echo "No tiene permiso";
		}

	}

}

?>
