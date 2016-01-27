<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evaluaciones extends MX_Controller {

	function evaluaciones()
	{
		parent::__construct();
		$this->user_model->checkuser();
		$this->load->model('prospectos/prospectos_model');
		$this->load->model('evaluaciones/evaluaciones_model');
	}

	function guardarCampaniaEvaluacion(){
var_dump($_POST);
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
		
		//redirect('evaluaciones/generaPreguntas/'.$this->db->insert_id());
	}

	//Funcion para enviar mails
	private	function enviarEmail($email){
			
			
			
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

	function usuario($usuarioID,$tipo){
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
			redirect('evaluaciones/usuario/'.$usuarioSesion['usuarioID'].'/1/'.$this->uri->segment(5));
		}
		else if($tipo == '1' && $usuarioSesion['usuarioID'] != $usuarioID ){
			redirect('evaluaciones/usuario/'.$usuarioSesion['usuarioID'].'/2/'.$this->uri->segment(5));
		}
		else if($tipo == '3' && empty($valida)){
			redirect('evaluaciones/usuario/'.$usuarioSesion['usuarioID'].'/2/'.$this->uri->segment(5));
		}

		$verifica = $this->evaluaciones_model->verificaRespuesta($usuarioID, $tipo);
		if(empty($verifica)){
			$this->layouts->profile('evaluacion2015-view', $op);
		}
		else{
			redirect('evaluaciones');
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
