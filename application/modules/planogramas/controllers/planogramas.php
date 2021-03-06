<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Planogramas extends MX_Controller
{
	function test(){
ini_set('display_errors', 'On');
error_reporting(E_ALL);
/* ORACLE PHP NATIVE */
/*
		$conn = oci_connect('XXSCHEMA_CONTRATOS','oracle123','(DESCRIPTION=
			(ADDRESS=(PROTOCOL=tcp)(HOST=apeplazas.maxapex.net)(PORT=1521))
			(CONNECT_DATA=(SID=XE))
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
		$q = $oracle->query("SELECT * FROM XXAPE_CLIENTES");
		var_dump($q);
 		phpinfo();
*/

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

	function test_cfdi(){

		$dom = new DOMDocument('1.0','utf-8');
        $dom->load("C:\Users\bcarrera\Downloads\PLC020415UL9_LNCR_7633.xml");
        
		foreach ($dom->getElementsByTagName('*') as $elemento) {
        	$name = str_replace('cfdi:','',$elemento->nodeName);
			echo "Attribute '$name------------------------<br />";
         	foreach ($elemento->attributes as $attr) {
				$name = $attr->nodeName;
				$value = $attr->nodeValue;
				echo "Attribute '$name' :: '$value'<br />";
			}
		}
		
		$op = array();
		$this->layouts->loadpdf('factura', $op,'pdf_print', true);
		/*
		$html = $this->layouts->loadpdf('factura', $op,'pdf_print', true);
		$data = pdf_create($html, '', false);
		write_file(DIRPDF.'CI_'.$cartaIntId.'.pdf', $data);
		 */
		
	}

	public function __construct()
	{
		parent::__construct();
		$this->user_model->checkuser();
		$this->load->model('user_model');
		$this->load->model('planogramas_model');
		$this->load->model('extracciones/extracciones_model');
		if( ! ini_get('date.timezone') ){
		    date_default_timezone_set('America/Mexico_City');
		}
		
	}

	function index(){
		
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		$op['planos'] = $this->planogramas_model->cargarPlanogramas();
		$op['plaza'] = $this->planogramas_model->cargarPlaza();

		$this->layouts->profile('listaPlanogramas-vista.php', $op);
	}

	function agregarPlanograma(){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');

		$this->layouts->profile('formulario-vista.php');
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
			redirect('planogramas');
		}

	}

	function verplano($planoId){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		$op['locales']        = $this->planogramas_model->traerInfoPlano($planoId);
		$op['texto']          = $this->planogramas_model->cargarTexto($planoId);
		$op['infoPlano']      = $this->planogramas_model->cargarPlanogramasID($planoId);
		$op['areaPublica']    = $this->planogramas_model->traerAreaPublica($planoId);

		$this->layouts->profile('verPlano-vista.php',$op);

	}

	function editarplano($planoId){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		$op['locales'] = $this->planogramas_model->traerPlano($planoId);
		$op['infoPlano']  = $this->planogramas_model->cargarPlanogramasID($planoId);
		$op['asignar']  = $this->planogramas_model->cargarPlanosAsignar($planoId);

		$this->layouts->profile('editarPlano-vista.php',$op);

	}

	function infoplano($planoId){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/jquery-ui.css')
					  ->add_include('assets/css/planogramas.css');

		$op['locales']        = $this->planogramas_model->traerPlano($planoId);
		$op['infoPlano']      = $this->planogramas_model->cargarPlanogramasID($planoId);
		$op['asignar']        = $this->planogramas_model->cargarPlanosAsignar($planoId);
		$op['areaPublica']    = $this->planogramas_model->traerAreaPublica($planoId);

		$this->layouts->profile('infoPlano-vista.php',$op);

	}

	function asignarplano($planoId){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');

		$op['locales'] = $this->planogramas_model->traerPlano($planoId);
		$op['infoPlano']  = $this->planogramas_model->cargarPlanogramasID($planoId);
		$op['asignar']  = $this->planogramas_model->cargarPlanosAsignar();

		$this->layouts->profile('asignarPlano-vista.php',$op);

	}

	function verPlanoTest($planoId){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');

		$op['locales'] = $this->planogramas_model->trearPlano($planoId);

		$this->layouts->profile('verPlanoTest-vista.php',$op);

	}

	function verPlanoBen($planoId){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');

		$op['locales'] = $this->planogramas_model->traerPlano($planoId);

		$this->layouts->profile('verPlanoBen-vista.php',$op);
	}

	function crearLocal($planoId){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		$op['locales'] = $this->planogramas_model->traerPlano($planoId);
		$op['infoPlano']  = $this->planogramas_model->cargarPlanogramasID($planoId);

		$this->layouts->profile('crearLocal-vista.php',$op);
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

		$op['locales'] = $this->planogramas_model->trearPlano($planoId);

		$this->load->view('d3-vista.php',$op);
	}

	function asignacionRenovacion($planoId){

		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		$op['locales']        = $this->planogramas_model->traerRenovacionesPlano($planoId);
		$op['texto']          = $this->planogramas_model->cargarTexto($planoId);
		$op['infoPlano']      = $this->planogramas_model->cargarPlanogramasID($planoId);
		$op['areaPublica']    = $this->planogramas_model->traerAreaPublica($planoId);

		$this->layouts->profile('asignacionRenovaciones-view',$op);
	}
	
	function inmuebles(){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
								->add_include('assets/js/jquery.autocomplete.pack.js')
								->add_include('assets/js/jquery.dataTables.min.js')
								->add_include('assets/css/planogramas.css');

		$op['inmuebles'] = $this->planogramas_model->cargarInmuebles();
		$op['usu']	=	$this->planogramas_model->trae_usuarios();
		
		$this->layouts->profile('listaInmuebles-vista',$op);
	}
	
	function plaza_detalle(){
  
		$inmueble_id = isset($_POST['plaza_id']) ? $_POST['plaza_id'] : 1; 
		
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
			  ->add_include('assets/js/jquery.autocomplete.pack.js')
			  ->add_include('assets/js/jquery.dataTables.min.js')
			  ->add_include('assets/css/planogramas.css');
	  
		$op['inmueble_id'] = $inmueble_id;
		$op['inmuebles']  = $this->planogramas_model->cargarInmuebles();
		$op['predios']  = $this->planogramas_model->cargarPrediosPlaza($inmueble_id);
		
		$this->layouts->profile('plaza_detalle-vista',$op);
 }
	
	function locales($plazaId){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
								->add_include('assets/js/jquery.autocomplete.pack.js')
								->add_include('assets/js/jquery.dataTables.min.js')
								->add_include('assets/css/planogramas.css');

		$op['locales'] = $this->planogramas_model->cargarLocalesPlaza($plazaId);
		
		$this->layouts->profile('locales-vista',$op);
	}
	
	function locales_faltantes($plazaId){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
								->add_include('assets/js/jquery.autocomplete.pack.js')
								->add_include('assets/js/jquery.dataTables.min.js')
								->add_include('assets/css/planogramas.css');

		$op['locales'] = $this->planogramas_model->cargarLocalesPlazaFaltantes($plazaId);
		
		$this->layouts->profile('locales-faltantes-vista',$op);
	}
	
	function locales_estatus($plazaId){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
								->add_include('assets/js/jquery.autocomplete.pack.js')
								->add_include('assets/js/jquery.dataTables.min.js')
								->add_include('assets/css/planogramas.css');

		$op['locales'] = $this->planogramas_model->cargarLocalesEstatusPlaza($plazaId);
		
		$this->layouts->profile('locales_estatus-vista',$op);
	}
	
	function locales_estatusM($plazaId){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
								->add_include('assets/js/jquery.autocomplete.pack.js')
								->add_include('assets/js/jquery.dataTables.min.js')
								->add_include('assets/css/planogramas.css');

		$op['locales'] = $this->planogramas_model->cargarLocalesEstatusPlaza($plazaId);
		
		$this->layouts->profile('locales_estatus-vistaM',$op);
	}
	
	function predios(){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
								->add_include('assets/js/jquery.autocomplete.pack.js')
								->add_include('assets/js/jquery.dataTables.min.js')
								->add_include('assets/css/planogramas.css')
								->add_include('assets/css/multi-select.css')
								->add_include('assets/js/jquery.multi-select.js');

		$op['inmuebles'] = $this->planogramas_model->cargarInmuebles();
		$op['usu']	=	$this->planogramas_model->trae_usuarios();
		
		$this->layouts->profile('listaInmueblesPredios-vista',$op);
	}
	
	function caida_inmuebles(){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
								->add_include('assets/js/jquery.autocomplete.pack.js')
								->add_include('assets/js/jquery.dataTables.min.js')
								->add_include('assets/css/planogramas.css')
								->add_include('assets/css/multi-select.css')
								->add_include('assets/js/jquery.multi-select.js');
		$op['inmuebles'] = $this->planogramas_model->caida_inmuebles();

		$this->layouts->profile('inmuebles_caida_de_datos',$op);
	}
	
	function caida_predios(){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
								->add_include('assets/js/jquery.autocomplete.pack.js')
								->add_include('assets/js/jquery.dataTables.min.js')
								->add_include('assets/css/planogramas.css')
								->add_include('assets/css/multi-select.css')
								->add_include('assets/js/jquery.multi-select.js');
								
		$op['predios'] = $this->planogramas_model->cargarPrediosLayouts();

		$this->layouts->profile('predios-caida',$op);
	
	}

	function caida_piso(){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
								->add_include('assets/js/jquery.autocomplete.pack.js')
								->add_include('assets/js/jquery.dataTables.min.js')
								->add_include('assets/css/planogramas.css')
								->add_include('assets/css/multi-select.css')
								->add_include('assets/js/jquery.multi-select.js');
								
		$op['pisos'] = $this->planogramas_model->cargarPisosLayouts();

		$this->layouts->profile('pisos-caida',$op);
	
	}
	
	function caida_locales(){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
								->add_include('assets/js/jquery.autocomplete.pack.js')
								->add_include('assets/js/jquery.dataTables.min.js')
								->add_include('assets/css/planogramas.css')
								->add_include('assets/css/multi-select.css')
								->add_include('assets/js/jquery.multi-select.js');
								
		$op['locales']				= $this->planogramas_model->cargarLocasLayouts();

		$this->layouts->profile('pisos-locales',$op);
	
	}

	function caida_locales_sin_contrato(){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
								->add_include('assets/js/jquery.autocomplete.pack.js')
								->add_include('assets/js/jquery.dataTables.min.js')
								->add_include('assets/css/planogramas.css')
								->add_include('assets/css/multi-select.css')
								->add_include('assets/js/jquery.multi-select.js');
								
		$op['locales']				= $this->planogramas_model->cargarLocasSinContratosLayouts();

		$this->layouts->profile('pisos-locales',$op);
	
	}
	
	function comparadorEstatus($plazaId){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
								->add_include('assets/js/jquery.autocomplete.pack.js')
								->add_include('assets/js/jquery.dataTables.min.js')
								->add_include('assets/css/planogramas.css');

		$op['locales'] = $this->planogramas_model->cargarLocalesPlaza($plazaId);
		
		$this->layouts->profile('comparador-vista',$op);
	}
	
	function notificar_nuevos_locales(){

		$locales_nuevos = $this->planogramas_model->cargarLocalesPlazaNuevos();
		if(sizeof($locales_nuevos > 0)){
			foreach($locales_nuevos as $nuevo){
				if(!empty($nuevo->email)){
					$this->load->library('email');
					$this->email->set_newline("\r\n");
					$this->email->from('contacto@apeplazas.com', 'APE Plazas Especializadas');
					$this->email->to($nuevo->email);
					$this->email->subject('Asignar nuevos locales');		
					$this->email->message('
						<html>
							<head>
								<title>Locales Nuevos</title>
							</head>
							<body>
								<p>Buen día</p>
								<p>Se he detectado que hay nuevos locales pendientes para asignar su estatus, por favor ingrese a <a href="http://www.apeplazas.com/apeConnect/planogramas/locales/' . $nuevo->Inmueble . '">ApeConnect</a> y actualice los locales en rojo.</p>
							</body>
						</html>
					');
					$this->email->send();	
				}
			}
		}
		
	}

}
