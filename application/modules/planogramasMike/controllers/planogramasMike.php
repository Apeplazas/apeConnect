<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PlanogramasMike extends MX_Controller
{
	function test(){

/* ORACLE PHP NATIVE */
		$conn = oci_connect('bolinfo','bolinfo2014','(DESCRIPTION=
			(ADDRESS=(PROTOCOL=tcp)(HOST=172.19.202.112)(PORT=1521))
			(CONNECT_DATA=(SID=APEDEV))
		)');
		if(!$conn){
			$e = oci_error();
			var_dump($e);
		}else{
			echo "siiii";
		}

		$stid = oci_parse($conn, 'SELECT * FROM XXAPE_CT_AVALES');
		oci_execute($stid);

		echo "<table border='1'>\n";
		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			echo "<tr>\n";
			foreach ($row as $item) {
				echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</table>\n";



		$oracle = $this->load->database('apedev',true);
		$q = $oracle->query("SELECT * FROM XXAPE_CT_AVALES");
		var_dump($q);
 		phpinfo();



		$intelisis = $this->load->database('intelisis',true);
		$iq = $intelisis->query("SELECT * FROM WEBPRUEBAS");
		$data = array();
		if($iq->num_rows() > 0) {
			foreach($iq->result() as $row){
				$data[] = $row;
			}
			$iq->free_result();
		}
		var_dump($data);


//$salida = shell_exec('pwd');
//echo "<pre>$salida</pre>";

	}

	public function __construct()
	{
		parent::__construct();
		//$this->user_model->checkuser();
		$this->load->model('user_model');
		$this->load->model('planogramas_modelMike');
		$this->load->model('planogramas/planogramas_model');
	}

	function index(){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramasMike.css');

		$op['planos'] = $this->planogramas_modelMike->cargarPlanogramas();
		$op['plaza'] = $this->planogramas_modelMike->cargarPlaza();

		$this->layouts->profile('listaPlanogramas-vistaMike.php', $op);
	}
	
	function propuestaRenovacion(){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramasMike.css');

		//$op['planos'] = $this->planogramas_modelMike->cargarPlanogramas();
		//$op['plaza'] = $this->planogramas_modelMike->cargarPlaza();
		$op['grupo'] = $this->planogramas_modelMike->cargarGrupos();

		$this->layouts->profile('propuestas-vistaMike.php', $op);
	}

	

	function agregarPlanograma(){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');

		$this->layouts->profile('formulario-vistaMike.php');
	}

	function subirPlano(){

		$plaza	= $this->input->post('plaza');
		$piso	= $this->input->post('piso');

		$userprofile 		= $this->session->userdata('usuario');

		if( isset($_FILES['archivo']) && !empty($_FILES['archivo']) ){

			$permitidos =  array('svg');

			$archivoNombre	= $_FILES['archivo']['name'];
			$archivoTipo	= $_FILES['archivo']['type'];
			$tamanoH		= $_FILES['archivo']['size'];

			$ext = pathinfo($archivoNombre, PATHINFO_EXTENSION);

			if(in_array($ext,$permitidos) ) {

		   		move_uploaded_file($_FILES['archivo']['tmp_name'],DIRPLANO.$archivoNombre);
		   		$data = array(
		   			'plaza'		=> $plaza,
		   			'piso'		=> $piso,
					'archivo'	=> $archivoNombre,
					'usuarioId'	=> $userprofile['usuarioID']
				);

				$this->db->insert('planogramas', $data);
				$planoId = $this->db->insert_id();

				$xml=simplexml_load_file(DIRPLANO.$archivoNombre) or die("Error: Cannot create object");
				$form_data = array();

				$temp_val = '';
				$temp_key = '';
				$temp_xml = '';

				foreach($xml->children() as $key => $val){

					$this->xml_walker($val,$key,$planoId);

				}

				$this->session->set_flashdata('msg','<div class="msg mt20 mb20">El planograma fue cargado.</div>');
				redirect('planogramas/infoPlano/'.$planoId);

			}else{

				$this->session->set_flashdata('msg','<div class="msg mt20 mb20">Favor de Ingresar un Formato valido.</div>');

			}
			redirect('planogramasMike');
		}

	}

	function verplano($planoId){
	
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramasMike.css');

		$op['locales']        = $this->planogramas_modelMike->traerInfoPlano($planoId);
		$op['texto']          = $this->planogramas_modelMike->cargarTexto($planoId);
		$op['infoPlano']      = $this->planogramas_modelMike->cargarPlanogramasID($planoId);
		$op['areaPublica']    = $this->planogramas_modelMike->traerAreaPublica($planoId);
		
		$this->layouts->profile('verPlano-vistaMike.php',$op);

	}
	//grupos Mike
	function verplanoEditar($planoId){
	
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramasMike.css');

		$op['locales']        = $this->planogramas_modelMike->traerInfoPlano($planoId);
		$op['texto']          = $this->planogramas_modelMike->cargarTexto($planoId);
		$op['infoPlano']      = $this->planogramas_modelMike->cargarPlanogramasID($planoId);
		$op['areaPublica']    = $this->planogramas_modelMike->traerAreaPublica($planoId);
		
		
		
		$this->layouts->profile('verPlanoEditar-vistaMike.php',$op);

	}
	//
	
	
	function editarplano($planoId){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramasMike.css');

		$op['locales'] = $this->planogramas_modelMike->traerPlano($planoId);
		$op['infoPlano']  = $this->planogramas_modelMike->cargarPlanogramasID($planoId);
		$op['asignar']  = $this->planogramas_modelMike->cargarPlanosAsignar($planoId);

		$this->layouts->profile('editarPlano-vistaMike.php',$op);

	}

	function infoplano($planoId){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/jquery-ui.css')
					  ->add_include('assets/css/planogramasMike.css');

		$op['locales']        = $this->planogramas_modelMike->traerPlano($planoId);
		$op['infoPlano']      = $this->planogramas_modelMike->cargarPlanogramasID($planoId);
		$op['asignar']        = $this->planogramas_modelMike->cargarPlanosAsignar($planoId);
		$op['areaPublica']    = $this->planogramas_modelMike->traerAreaPublica($planoId);

		$this->layouts->profile('infoPlano-vistaMike.php',$op);

	}

	function asignarplano($planoId){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');

		$op['locales'] = $this->planogramas_modelMike->traerPlano($planoId);
		$op['infoPlano']  = $this->planogramas_modelMike->cargarPlanogramasID($planoId);
		$op['asignar']  = $this->planogramas_modelMike->cargarPlanosAsignar();

		$this->layouts->profile('asignarPlano-vistaMike.php',$op);

	}

	function verPlanoTest($planoId){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');

		$op['locales'] = $this->planogramas_modelMike->trearPlano($planoId);

		$this->layouts->profile('verPlanoTest-vistaMike.php',$op);

	}

	function verPlanoBen($planoId){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');

		$op['locales'] = $this->planogramas_modelMike->traerPlano($planoId);

		$this->layouts->profile('verPlanoBen-vistaMike.php',$op);
	}

	function crearLocal($planoId){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramasMike.css');

		$op['locales'] = $this->planogramas_modelMike->traerPlano($planoId);
		$op['infoPlano']  = $this->planogramas_modelMike->cargarPlanogramasID($planoId);

		$this->layouts->profile('crearLocal-vistaMike.php',$op);
	}

	function xml_walker($xml,$keyMain,$planoId){

		$return = array();

		if (@count($xml->children()) > 0){

			foreach($xml->children() as $key => $val){

				if(@count($val->children()) > 0){

					$this->xml_walker($val,$key,$planoId);

				}else{

					$this->insert_xml_element($key,$val,$planoId);

				}

			}

		}else{

			$this->insert_xml_element($keyMain,$xml,$planoId);

		}

	}

	function insert_xml_element($temp_key,$temp_val,$planoId){

		if($temp_key == 'rect' || $temp_key == 'circle' || $temp_key == 'elipse' || $temp_key == 'polygon' || $temp_key == 'path' || $temp_key == 'line' || $temp_key == 'polyline' || $temp_key == 'text'){

			if($temp_key == 'rect'){

				$form_data = array(
					'tipo' 		=> $temp_key,
					'x'			=> (string)$temp_val['x'],
					'y'			=> (string)$temp_val['y'],
					'width'		=> (string)$temp_val['width'],
					'height'	=> (string)$temp_val['height'],
					'plazaId'	=> $planoId
				);
				$this->db->insert('vector', $form_data);

			}elseif($temp_key == 'circle'){

				$form_data = array(
					'tipo' 	=> $temp_key,
					'cx'	=> (string)$temp_val['cx'],
					'cy'	=> (string)$temp_val['cy'],
					'plazaId'	=> $planoId
				);
				$this->db->insert('vector', $form_data);

			}elseif($temp_key == 'elipse'){

				$form_data = array(
					'tipo' 	=> $temp_key,
					'cx'	=> (string)$temp_val['cx'],
					'cy'	=> (string)$temp_val['cy'],
					'rx'	=> (string)$temp_val['rx'],
					'ry'	=> (string)$temp_val['ry'],
					'plazaId'	=> $planoId
				);
				$this->db->insert('vector', $form_data);

			}elseif($temp_key == 'path'){

				$form_data = array(
					'tipo' 	=> $temp_key,
					'd'		=> (string)$temp_val['d'],
					'plazaId'	=> $planoId
				);
				$this->db->insert('vector', $form_data);

			}elseif($temp_key == 'line'){

				$form_data = array(
					'tipo' 	=> $temp_key,
					'x1'	=> (string)$temp_val['x1'],
					'y1'	=> (string)$temp_val['y1'],
					'x2'	=> (string)$temp_val['x2'],
					'y2'	=> (string)$temp_val['y2'],
					'plazaId'	=> $planoId
				);
				$this->db->insert('vector', $form_data);

			}elseif($temp_key == 'polyline' || $temp_key == 'polygon'){

				$form_data = array(
					'tipo' 		=> $temp_key,
					'points'	=> (string)$temp_val['points'],
					'plazaId'	=> $planoId
				);
				$this->db->insert('vector', $form_data);

			}elseif($temp_key == 'text'){

				$form_data = array(
					'tipo' 		=> $temp_key,
					'transform'	=> (string)$temp_val['transform'],
					'contenido'	=> (string)$temp_val,
					'plazaId'	=> $planoId
				);
				$this->db->insert('vector', $form_data);

			}

		}

	}

	function d3($planoId){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/d3.min.js')
					  ->add_include('assets/css/base.css')
					  ->add_include('assets/js/d3Functions.js');

		$op['locales'] = $this->planogramas_modelMike->trearPlano($planoId);

		$this->load->view('d3-vistaMike.php',$op);
	}

	function asignacionRenovacion($planoId){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramasMike.css');

		$op['locales']        = $this->planogramas_modelMike->traerRenovacionesPlano($planoId);
		$op['texto']          = $this->planogramas_modelMike->cargarTexto($planoId);
		$op['infoPlano']      = $this->planogramas_modelMike->cargarPlanogramasID($planoId);
		$op['areaPublica']    = $this->planogramas_modelMike->traerAreaPublica($planoId);

		$this->layouts->profile('asignacionRenovaciones-viewMike',$op);
	}


}
