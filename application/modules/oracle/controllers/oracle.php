<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oracle extends MX_Controller
{
	function test(){
		ini_set('display_errors', 'On');
		error_reporting(E_ALL);
		$oracle = $this->load->database('apedev',true);
		$intelisis = $this->load->database('intelisis',true);
	/*
		foreach($_POST['plaza'] as $plaza){
				
			$datos = array(
				'Sucursal' => $plaza
			);
			$intelisis->insert('APESucursalObra', $datos);
			
		}
		
		redirect('oracle');
	 
		$data = array();
		$intelisis->query("SET IDENTITY_INSERT Final1.Clientes ON
INSERT INTO Final1.Clientes (CLIENTE_ID, NUMERO_CLIENTE, TIPO_CLIENTE, RFC, RAZON_SOCIAL_FACTURADOR, PRIMER_NOMBRE,
	SEGUNDO_NOMBRE, A_PATERNO, A_MATERNO, FECHA_NACIMIENTO, ESTADO_CIVIL, NACIONALIDAD, NOMBRE_ORG, SEXO, INCLUIR_INTERESES)
SELECT CLIENTE_ID, CLIENTE_ID AS NUMERO_CLIENTE, 'EST' AS TIPO_CLIENTE, RFC, FACTURADOR AS RAZON_SOCIAL_FACTURADOR, PRIMER_NOMBRE,
	SEGUNDO_NOMBRE + ISNULL(' ' + TERCER_NOMBRE, '') + ISNULL(' ' + CUARTO_NOMBRE, '') AS SEGUNDO_NOMBRE,
	PRIMER_APELLIDO AS A_PATERNO, SEGUNDO_APELLIDO AS A_MATERNO, FECHA_NACIMIENTO, 'SOLTERO' AS ESTADO_CIVIL,
	'MEXICANA' AS NACIONALIDAD, NOMBRE_ORG, 'MASCULINO' AS SEXO, A.AplicaMoratorios AS INCLUIR_INTERESES
FROM ETL.Clientes C
INNER JOIN #AplicaMoratorios A
ON C.CLIENTE_ID = A.Cliente
WHERE C.TIPO_PERSONA = 'PF'

INSERT INTO Final1.Clientes (CLIENTE_ID, NUMERO_CLIENTE, TIPO_CLIENTE, RFC, RAZON_SOCIAL_FACTURADOR, PRIMER_NOMBRE,
	SEGUNDO_NOMBRE, A_PATERNO, A_MATERNO, FECHA_NACIMIENTO, ESTADO_CIVIL, NACIONALIDAD, NOMBRE_ORG, SEXO, INCLUIR_INTERESES)
SELECT CLIENTE_ID, CLIENTE_ID AS NUMERO_CLIENTE, 'EST' AS TIPO_CLIENTE, RFC, FACTURADOR AS RAZON_SOCIAL_FACTURADOR, 'CARGA_APEX' AS PRIMER_NOMBRE,
	'' SEGUNDO_NOMBRE,
	'CARGA_APEX' AS A_PATERNO, 'CARGA_APEX' AS A_MATERNO, FECHA_NACIMIENTO, '' AS ESTADO_CIVIL,
	'MEXICANA' AS NACIONALIDAD, NOMBRE_ORG, 'MASCULINO' AS SEXO, A.AplicaMoratorios AS INCLUIR_INTERESES
FROM ETL.Clientes C
INNER JOIN #AplicaMoratorios A
ON C.CLIENTE_ID = A.Cliente
WHERE C.TIPO_PERSONA = 'PM'
SET IDENTITY_INSERT Final1.Clientes OFF");
		
/*		
		$test = $this->oracle_model->traerLocales();
var_dump($test);
 * */
 
 		$data = array();
		$q = $oracle->query("SELECT * FROM XXAPE_LOV_VALUES");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
	$intelisis->query("SET IDENTITY_INSERT ETL.VALORES_LISTAS_DETALLE ON");
		foreach($data as $dat){
			$insert_datos = array(
				'Value_Id' => $dat->VALUE_ID,
				'Lov_Id' => $dat->LOV_ID,
				'Sort_Sequence' => $dat->SORT_SEQUENCE,
				'Value_Code' => $dat->VALUE_CODE,
				'Value_Meaning' => $dat->VALUE_MEANING
			);
			$intelisis->insert('ETL.VALORES_LISTAS_DETALLE', $insert_datos);
		}
$intelisis->query("SET IDENTITY_INSERT ETL.VALORES_LISTAS_DETALLE OFF");
		
	}

	public function __construct()
	{
		parent::__construct();
		$this->user_model->checkuser();
		$this->load->model('user_model');
		$this->load->model('oracle_model');
	}

	function index(){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		$this->layouts->profile('oracle-vista.php', $op);
	}
	
	function iniciar_proceso(){
		
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		$op['plazas'] = $this->oracle_model->traer_plazas();

		$this->layouts->profile('iniciar-proceso-vista.php', $op);
		
	}
	
	function insertar_pazas(){
			
		$intelisis = $this->load->database('intelisis',true);
		$oracle = $this->load->database('apedev',true);
		
		//Procesar 6 veces para asegurar su ejecucion
		@$intelisis->query("EXEC APEExtractorPaso1");
		@$intelisis->query("EXEC APEExtractorPaso1");
		@$intelisis->query("EXEC APEExtractorPaso1");
		@$intelisis->query("EXEC APEExtractorPaso1");
		@$intelisis->query("EXEC APEExtractorPaso1");
		@$intelisis->query("EXEC APEExtractorPaso1");
		@$intelisis->query("DELETE FROM APESucursalObra");
		@$intelisis->query("DELETE FROM APEClientesOracle");
		
		$intelisis->query("CREATE SCHEMA Final1");
		$intelisis->query("APEExtractorPaso2")->free_result();
		$intelisis->query("APEExtractorPaso3")->free_result();
		
		$intelisis->query("UPDATE Final1.PREDIAL SET NOMBRE_DE_PREDIO = CALLE + '-' + NUMERO_EXTERIOR");
		
		//Insertar fiadores
		$data = array();
		$q = $oracle->query("select * from XXAPE_FIADORES");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
	
		foreach($data as $dat){
			$insert_datos = array(
				'FiadorNombre' => preg_replace('/\s+/', '', $dat->NOMBRE_COMPLETO)
			);
			$intelisis->insert('APEFiadoresOracle', $insert_datos);
		}

		foreach($_POST['plaza'] as $plaza){
				
			$datos = array(
				'Sucursal' => $plaza
			);
			$intelisis->insert('APESucursalObra', $datos);
			
		}
		
	 	$data = array();
		$q = $oracle->query("SELECT * FROM XXAPE_CLIENTES");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
	
		foreach($data as $dat){
			$insert_datos = array(
				'Cliente' => $dat->NUMERO_CLIENTE
			);
			$intelisis->insert('APEClientesOracle', $insert_datos);
		}
		redirect('oracle');
	}
	
	function exportar_obras(){
	
		$header = array(
			'LOCAL_ID', 'INMUEBLE_ID', 'INMUEBLE_ID', 'PREDIO_ID', 'AREA_INTELISIS', 'AREA_nombre', 'PISO_ID', 'NUMERO', 'AREA_RENTABLE', 'TIPO_DE_LOCAL', 'CATEGORIA_LOCAL', 'ESTATUS_LOCAL', 'FECHA_INICIO_LOCAL', 
			'FECHA_FIN_LOCAL', 'AGRUPADO', 'LOCALES_AGRUPADOS', 'PLANO', 'CREATED_BY', 'CREATION_DATE', 'LAST_UPDATED_BY', 'LAST_UPDATE_DATE', 'MOTIVO_CAMBIO', 'USO_DE_LOCAL', 'Categoria', 'Familia', 'Medida'
		);
		
		$plazas = $this->oracle_model->traer_plazas_a_procesar();

		$data = $this->oracle_model->traerLocales();

		$this->oracle_model->genera_excel_obras($header,$data,$plazas);
		
	}
	
	function exportar_clientes(){
		
		$this->load->library('excel');


		$objPHPExcel = new PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Ape plazas")
									 ->setLastModifiedBy("Ape plazas")
									 ->setTitle("Ape plazas");
/********************************
 *			CLIENTES			*
 ********************************/
		
		// Header
		$current_col = 0;
		
		$Clientes = $objPHPExcel->createSheet();
		$Clientes->setTitle("Clientes");
		
		//Variable Clientes
		$clientes_data =  $this->oracle_model->traer_clientes_a_procesar();

		$header_clientes = array("CLIENTE_ID", "NOMBRE", "TIPO_PERSONA", "PLAZA", "PRIMER_NOMBRE", "SEGUNDO_NOMBRE", "TERCER_NOMBRE", 
			"CUARTO_NOMBRE", "PRIMER_APELLIDO", "SEGUNDO_APELLIDO", "RFC", "DIRECCION", "NUMERO", "NUMERO_INTERIOR", "DELEGACION", "COLONIA", 
			"POBLACION", "ESTADO", "PAIS", "CODIGO_POSTAL", "FACTURADOR", "OBSERVACIONES", "ALTA", "FECHA_NACIMIENTO", "NOMBRE_ORG", "SEXO"
		);

		foreach($header_clientes as $head){
			$Clientes->setCellValueByColumnAndRow($current_col, 1, $head);
			++$current_col;
		}
		
		// Freeze panes
		$Clientes->freezePane('A2');

		// Rows to repeat at top
		$Clientes->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

		//Rows
		foreach($clientes_data as $key => $dat){
			$current_col = 0;
			if(is_array($dat) || is_object($dat)){
				foreach($dat as $value){
					$Clientes->setCellValueByColumnAndRow($current_col, $key+2, $value);
					++$current_col;
				}
			}
		}
		
/********************************************
 *			CLIENTE_REF_BANCARIAS			*
 ********************************************/
									 
		// Header
		$current_col = 0;
		
		$CLIENTE_REF_BANCARIAS = $objPHPExcel->createSheet();
		$CLIENTE_REF_BANCARIAS->setTitle("CLIENTE_REF_BANCARIAS");
		
		//Variable Clientes
		$cliente_ref_bancarias_data =  $this->oracle_model->traer_cliente_ref_bancarias();

		$header_cliente_ref_bancarias = array("REFERENCIA_BANCARIA_ID", "CLIENTE_ID", "SEC", "REFERENCIA_BANCARIA", "INMUEBLE_ID", "PREDIO_ID", "PISO_ID", 
			"LOCAL_ID", "EFFECTIVE_START_DATE", "EFFECTIVE_END_DATE", "VERSION_NUMBER", "CREATED_BY", "CREATION_DATE", "LAST_UPDATED_BY", 
			"LAST_UPDATE_DATE", "CLIENTE_ID_INTELISIS");

		foreach($header_cliente_ref_bancarias as $head){
			$CLIENTE_REF_BANCARIAS->setCellValueByColumnAndRow($current_col, 1, $head);
			++$current_col;
		}
		
		// Freeze panes
		$CLIENTE_REF_BANCARIAS->freezePane('A2');

		// Rows to repeat at top
		$CLIENTE_REF_BANCARIAS->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

		//Rows
		foreach($cliente_ref_bancarias_data as $key => $dat){
			$current_col = 0;
			if(is_array($dat) || is_object($dat)){
				foreach($dat as $value){
					$CLIENTE_REF_BANCARIAS->setCellValueByColumnAndRow($current_col, $key+2, $value);
					++$current_col;
				}
			}
		}
		
/****************************************
 *			CLIENTE_SOLICITUDES			*
 ****************************************/
		
		// Header
		$current_col = 0;
		
		$CLIENTE_SOLICITUDES = $objPHPExcel->createSheet();
		$CLIENTE_SOLICITUDES->setTitle("CLIENTE_SOLICITUDES");
		
		//Variable
		$cliente_solucitudes_data =  $this->oracle_model->traer_clientes_solicitudes_a_procesar();

		$header_cliente_solicitudes = array("SOLICITUD_ID", "CLIENTE_ID", "NUMERO_SOLICITUD", "APPROVED_BY", "APPROVED_DATE", "CANCELLED_BY", 
			"CANCELLATION_DATE", "ESTADO_SOLICITUD", "EFFECTIVE_START_DATE", "EFFECTIVE_END_DATE", "VERSION_NUMBER", "CREATED_BY", "CREATION_DATE", 
			"LAST_UPDATED_BY", "LAST_UPDATE_DATE", "CLIENTE_ESPECIAL", "TIPO_CLIENTE_ESPECIAL", "TIPO_PERSONA", "ENVIADO_POR", "ENVIADO_FECHA", 
			"CLIENTE_ID_INTELISIS");

		foreach($header_cliente_solicitudes as $head){
			$CLIENTE_SOLICITUDES->setCellValueByColumnAndRow($current_col, 1, $head);
			++$current_col;
		}
		
		// Freeze panes
		$CLIENTE_SOLICITUDES->freezePane('A2');

		// Rows to repeat at top
		$CLIENTE_SOLICITUDES->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

		//Rows
		foreach($cliente_solucitudes_data as $key => $dat){
			$current_col = 0;
			if(is_array($dat) || is_object($dat)){
				foreach($dat as $value){
					$CLIENTE_SOLICITUDES->setCellValueByColumnAndRow($current_col, $key+2, $value);
					++$current_col;
				}
			}
		}
		
/********************************
 *			CLIENTE_DOC			*
 ********************************/
									 
		// Header
		$current_col = 0;
		
		$CLIENTE_DOC = $objPHPExcel->createSheet();
		$CLIENTE_DOC->setTitle("CLIENTE_DOC");
		
		//Variable
		$cliente_doc_data =  $this->oracle_model->traer_cliente_doc_a_procesar();

		$header_cliente_doc = array("DOCUMENTO_ID", "SOLICITUD_ID", "TIPO_DOCUMENTO", "DESCRIPCION", "COMENTARIOS", "ARCHIVO_ID", "HIPERLINK", 
			"TIPO_ARCH_HIPERLINK", "ESTADO_DOCUMENTO", "EFFECTIVE_START_DATE", "EFFECTIVE_END_DATE", "VERSION_NUMBER", "CREATED_BY", 
			"CREATION_DATE", "LAST_UPDATED_BY", "LAST_UPDATE_DATE");

		foreach($header_cliente_doc as $head){
			$CLIENTE_DOC->setCellValueByColumnAndRow($current_col, 1, $head);
			++$current_col;
		}
		
		// Freeze panes
		$CLIENTE_DOC->freezePane('A2');

		// Rows to repeat at top
		$CLIENTE_DOC->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

		//Rows
		foreach($cliente_doc_data as $key => $dat){
			$current_col = 0;
			if(is_array($dat) || is_object($dat)){
				foreach($dat as $value){
					$CLIENTE_DOC->setCellValueByColumnAndRow($current_col, $key+2, $value);
					++$current_col;
				}
			}
		}
		
/********************************
 *			CONTACTOS			*
 ********************************/


		// Header
		$current_col = 0;
		//$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->removeSheetByIndex(0);
		
		$CONTACTOS = $objPHPExcel->createSheet();
		$CONTACTOS->setTitle("CONTACTOS");
		
		//Variable
		$contratod_data =  $this->oracle_model->traer_contactos_a_procesar();
		
		$header_contactos = array("CONTACTO_ID", "CLIENTE_ID", "TIPO_CONTACTO", "NOMBRE_CONTACTO", "EFFECTIVE_START_DATE", "EFFECTIVE_END_DATE", 
			"VERSION_NUMBER", "CREATED_BY", "CREATION_DATE", "LAST_UPDATED_BY", "LAST_UPDATE_DATE", "CLIENTE_ID_INTELISIS");

		foreach($header_contactos as $head){
			$CONTACTOS->setCellValueByColumnAndRow($current_col, 1, $head);
			++$current_col;
		}

		// Freeze panes
		$CONTACTOS->freezePane('A2');

		// Rows to repeat at top
		$CONTACTOS->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

		//Rows
		foreach($contratod_data as $key => $dat){
			$current_col = 0;
			if(is_array($dat) || is_object($dat)){
				foreach($dat as $value){
					$CONTACTOS->setCellValueByColumnAndRow($current_col, $key+2, $value);
					++$current_col;
				}
			}
		}
		
/********************************
 *			DIRECCIONES			*
 ********************************/


		// Header
		$current_col = 0;
		//$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->removeSheetByIndex(0);
		
		$DIRECCIONES = $objPHPExcel->createSheet();
		$DIRECCIONES->setTitle("DIRECCIONES");
		
		//Variable
		$direcciones_data =  $this->oracle_model->traer_direcciones_a_procesar();
		
		$header_direcciones = array("DIRECCION_ID", "CLIENTE_ID", "SECUENCIA", "ES_DIR_PRIMARIA", "ES_DIR_FACTURACION", "DOMICILIO_1", 
			"DOMICILIO_2", "DOMICILIO_3", "NUM_EXT", "NUM_INT", "ESTADO", "MUNICIPIO", "CIUDAD", "PAIS", "CP", "EFFECTIVE_START_DATE", 
			"EFFECTIVE_END_DATE", "VERSION_NUMBER", "CREATED_BY", "CREATION_DATE", "LAST_UPDATED_BY", "LAST_UPDATE_DATE", "FIADOR_ID", 
			"CLIENTE_ID_INTELISIS");

		foreach($header_direcciones as $head){
			$DIRECCIONES->setCellValueByColumnAndRow($current_col, 1, $head);
			++$current_col;
		}

		// Freeze panes
		$DIRECCIONES->freezePane('A2');

		// Rows to repeat at top
		$DIRECCIONES->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

		//Rows
		foreach($direcciones_data as $key => $dat){
			$current_col = 0;
			if(is_array($dat) || is_object($dat)){
				foreach($dat as $value){
					$DIRECCIONES->setCellValueByColumnAndRow($current_col, $key+2, $value);
					++$current_col;
				}
			}
		}
		
/********************************
 *			PUNTOS_CONTACTO			*
 ********************************/


		// Header
		$current_col = 0;
		//$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->removeSheetByIndex(0);
		
		$PUNTOS_CONTACTO = $objPHPExcel->createSheet();
		$PUNTOS_CONTACTO->setTitle("PUNTOS_CONTACTO");
		
		//Variable
		$puntos_contacto_data =  $this->oracle_model->traer_puntos_contactos_a_procesar();
		
		$header_puntos_contacto = array("PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID", 
			"PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID"
		);

		foreach($header_puntos_contacto as $head){
			$PUNTOS_CONTACTO->setCellValueByColumnAndRow($current_col, 1, $head);
			++$current_col;
		}

		// Freeze panes
		$PUNTOS_CONTACTO->freezePane('A2');

		// Rows to repeat at top
		$PUNTOS_CONTACTO->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

		//Rows
		foreach($puntos_contacto_data as $key => $dat){
			$current_col = 0;
			if(is_array($dat) || is_object($dat)){
				foreach($dat as $value){
					$PUNTOS_CONTACTO->setCellValueByColumnAndRow($current_col, $key+2, $value);
					++$current_col;
				}
			}
		}
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Products_'.date('dMy').'.xls"');
        header('Cache-control: private, must-revalidate');

        $objWriter->save('php://output');
		exit();
		
	}
	
	function subir_archivo_obras(){
		
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		$this->layouts->profile('subir-archivo-obras-vista.php', $op);
		
	}
	
	function subir_archivo_layout_clientes(){
		
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		$this->layouts->profile('subir-archivo-layout-clientes-vista.php', $op);
		
	}
	
	function subir_archivo_clientes(){
		
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/planogramas.css');

		$this->layouts->profile('subir-archivo-clientes-vista.php', $op);
		
	}
/*
	function procesar_archivo_layout_clientes(){
	var_dump($_FILES);	
		if( isset($_FILES['archivo']) && !empty($_FILES['archivo']) ){
			
			$permitidos =  array('xls','xlsx','XLS','XLSX');

			$archivoNombre	= $_FILES['archivo']['name'];
			$archivoTipo	= $_FILES['archivo']['type'];
			$tamanoH		= $_FILES['archivo']['size'];

			$ext = pathinfo($archivoNombre, PATHINFO_EXTENSION);

			if(in_array($ext,$permitidos) ) {

		   		move_uploaded_file($_FILES['archivo']['tmp_name'],DIRORACLE.$archivoNombre);
				
				$this->load->library('excel');
				
				//** Set default timezone (will throw a notice otherwise)
				//date_default_timezone_set('America/Los_Angeles');
				//date_default_timezone_set('UTC');
				$saveTimeZone = date_default_timezone_get();

				date_default_timezone_set($saveTimeZone);
				
				//include 'Classes/PHPExcel/IOFactory.php';
				
				$inputFileName = DIRORACLE.$archivoNombre;
				
				//  Read your Excel workbook
				try {
				    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
					
					//initialize cache, so the phpExcel will not throw memory overflow
    				$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
    				$cacheSettings = array(' memoryCacheSize ' => '8MB');
    				PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
					
				    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
					
					//read only data (without formating) for memory and time performance
    				$objReader->setReadDataOnly(true);
					
				    $objPHPExcel = $objReader->load($inputFileName);
				} catch (Exception $e) {
				    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
				    . '": ' . $e->getMessage());
				}
		
				$worksheetNames = $objPHPExcel->getSheetNames($inputFileName);
		
		    	foreach($worksheetNames as $key => $sheetName){
		    		var_dump($sheetName);
				}
				
			}
			
		}
		
	}
*/

	function procesar_archivo_clientes(){
	
		$this->load->library('excel');


		$objPHPExcel = new PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Ape plazas")
									 ->setLastModifiedBy("Ape plazas")
									 ->setTitle("Ape plazas");
									 
		$continue_process = true;
/******************************************************************************************/	

		
/********************************
 *			DIRECCIONES			*
 ********************************/
		
		//Variable
		$direcciones_data =  $this->oracle_model->traer_direcciones_a_procesar();

		//Rows
		foreach($direcciones_data as $dat){
			
			$data_layout_clientes = $this->oracle_model->traer_layout_cliente($dat->CLIENTE_ID);
			//hay un error con el id del cliente
			if(sizeof($data_layout_clientes) > 1){
				continue;
			}elseif(!isset($data_layout_clientes[0])){
				continue;
			}
			
			
			//Verificar Domicilio 1
			if($dat->DOMICILIO_1 != $data_layout_clientes->DOMICILIO_1){
				$update = array(
					'nombre_campo'		=> 'DOMICILIO_1',
					'tabla'				=> 'etl.Clientes',
					'referencia'		=> $dat->CLIENTE_ID,
					'valor_anterior'	=> $dat->DOMICILIO_1,
					'valor_actual'		=> $data_layout_clientes->DOMICILIO_1
				);
				$this->db->insert('tempora_historial_updates', $update);
				
			}
			
			//Verificar Domicilio 3
			if($dat->DOMICILIO_3 != $data_layout_clientes->DOMICILIO_3){
				$update = array(
					'nombre_campo'		=> 'DOMICILIO_3',
					'tabla'				=> 'etl.Clientes',
					'referencia'		=> $dat->CLIENTE_ID,
					'valor_anterior'	=> $dat->DOMICILIO_3,
					'valor_actual'		=> $data_layout_clientes->DOMICILIO_3
				);
				$this->db->insert('tempora_historial_updates', $update);
				
			}
			
			//Verificar Num ext
			if($dat->NUM_EXT != $data_layout_clientes->NUM_EXT){
				$update = array(
					'nombre_campo'		=> 'NUM_EXT',
					'tabla'				=> 'etl.Clientes',
					'referencia'		=> $dat->CLIENTE_ID,
					'valor_anterior'	=> $dat->NUM_EXT,
					'valor_actual'		=> $data_layout_clientes->NUM_EXT
				);
				$this->db->insert('tempora_historial_updates', $update);
				
			}

			//Verificar Num Int
			if($dat->NUM_INT != $data_layout_clientes->NUM_INT){
				$update = array(
					'nombre_campo'		=> 'NUM_INT',
					'tabla'				=> 'etl.Clientes',
					'referencia'		=> $dat->CLIENTE_ID,
					'valor_anterior'	=> $dat->NUM_INT,
					'valor_actual'		=> $data_layout_clientes->NUM_INT
				);
				$this->db->insert('tempora_historial_updates', $update);
				
			}
			
			//Verificar Estado
			if($dat->ESTADO != $data_layout_clientes->ESTADO){
				$update = array(
					'nombre_campo'		=> 'ESTADO',
					'tabla'				=> 'etl.Clientes',
					'referencia'		=> $dat->CLIENTE_ID,
					'valor_anterior'	=> $dat->ESTADO,
					'valor_actual'		=> $data_layout_clientes->ESTADO
				);
				$this->db->insert('tempora_historial_updates', $update);
				
			}
			
			//Verificar Municipio
			if($dat->MUNICIPIO != $data_layout_clientes->MUNICIPIO){
				$update = array(
					'nombre_campo'		=> 'MUNICIPIO',
					'tabla'				=> 'etl.Clientes',
					'referencia'		=> $dat->CLIENTE_ID,
					'valor_anterior'	=> $dat->MUNICIPIO,
					'valor_actual'		=> $data_layout_clientes->MUNICIPIO
				);
				$this->db->insert('tempora_historial_updates', $update);
				
			}
			
			//Verificar CIUDAD
			if($dat->CIUDAD != $data_layout_clientes->CIUDAD){
				$update = array(
					'nombre_campo'		=> 'CIUDAD',
					'tabla'				=> 'etl.Clientes',
					'referencia'		=> $dat->CLIENTE_ID,
					'valor_anterior'	=> $dat->CIUDAD,
					'valor_actual'		=> $data_layout_clientes->CIUDAD
				);
				$this->db->insert('tempora_historial_updates', $update);
				
			}
			
			//Verificar PAIS
			if($dat->PAIS != $data_layout_clientes->PAIS){
				$update = array(
					'nombre_campo'		=> 'PAIS',
					'tabla'				=> 'etl.Clientes',
					'referencia'		=> $dat->CLIENTE_ID,
					'valor_anterior'	=> $dat->PAIS,
					'valor_actual'		=> $data_layout_clientes->PAIS
				);
				$this->db->insert('tempora_historial_updates', $update);
				
			}
			
			//Verificar CP
			if($dat->CP != $data_layout_clientes->CP){
				$update = array(
					'nombre_campo'		=> 'CP',
					'tabla'				=> 'etl.Clientes',
					'referencia'		=> $dat->CLIENTE_ID,
					'valor_anterior'	=> $dat->CP,
					'valor_actual'		=> $data_layout_clientes->CP
				);
				$this->db->insert('tempora_historial_updates', $update);
				
			}
			$data_layout_clientes = $data_layout_clientes[0];
			var_dump($dat);
			var_dump($data_layout_clientes);
			exit;
			
		}
		
/********************************
 *			PUNTOS_CONTACTO			*
 ********************************/


		// Header
		$current_col = 0;
		//$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->removeSheetByIndex(0);
		
		$PUNTOS_CONTACTO = $objPHPExcel->createSheet();
		$PUNTOS_CONTACTO->setTitle("PUNTOS_CONTACTO");
		
		//Variable
		$puntos_contacto_data =  $this->oracle_model->traer_puntos_contactos_a_procesar();
		
		$header_puntos_contacto = array("PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID", 
			"PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID", "PUNTO_CONTACTO_ID"
		);

		foreach($header_puntos_contacto as $head){
			$PUNTOS_CONTACTO->setCellValueByColumnAndRow($current_col, 1, $head);
			++$current_col;
		}

		// Freeze panes
		$PUNTOS_CONTACTO->freezePane('A2');

		// Rows to repeat at top
		$PUNTOS_CONTACTO->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

		//Rows
		foreach($puntos_contacto_data as $key => $dat){
			$current_col = 0;
			if(is_array($dat) || is_object($dat)){
				foreach($dat as $value){
					$PUNTOS_CONTACTO->setCellValueByColumnAndRow($current_col, $key+2, $value);
					++$current_col;
				}
			}
		}
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Products_'.date('dMy').'.xls"');
        header('Cache-control: private, must-revalidate');

        $objWriter->save('php://output');
		exit();
		
	}

	function procesar_archivo_obras(){

		if( isset($_FILES['archivo_obras']) && !empty($_FILES['archivo_obras']) ){
			
			$intelisis = $this->load->database('intelisis',true);
	 		$oracle = $this->load->database('apedev',true);
			//datos de predio id para insertarlos en las otras tablas
			$datos_predio	= array();
			$datos_piso		= array();
			$inmueble_datos	= array();
			$letters = range('a','z');
			
			$bancos = array("HSBC" => "021", 
				"BBVA Bancomer" => "012" );
			
			$headers_inmueble = array( 
				1 => 'Inmueble_Id',
				2 => 'Codigo_Inmueble',
				3 => 'Nombre_Inmueble',
				4 => 'Status',
				5 => 'Fecha_Inicio',
				//6 => 'FECHA_FIN',
				7 => 'Razon_Social_Id',
				8 => 'BANCO_ID',
				9 => 'NO_CUENTA',
				10 => 'CLAVE_SERVICIO',
				11 => 'Dias_Pago',
				//12 => 'MOTIVO_CAMBIO',
				//13 => 'CREATED_BY',
				14 => 'Creation_Date',
				//15 => 'LAST_UPDATED_BY',
				//16 => 'LAST_UPDATE_DATE',
				//17 => 'PLANO'
			);
			
			$headers_predial = array(
				1 => 'Predio_Id',
				2 => 'Inmueble_id',
				//3 => 'INMUEBLE_ID',
				4 => 'Nombre_De_Predio',
				5 => 'Estatus_De_Predio',
				//6 => 'FECHA_INICIO',
				//7 => 'FECHA_FIN',
				8 => 'Superficie_Terreno',
				9 => 'Calle',
				10 => 'Numero_Exterior',
				11 => 'Numero_Interior',
				12 => 'Colonia',
				13 => 'Delegacion_Municipio',
				14 => 'Codigo_Postal',
				15 => 'Estado',
				16 => 'Ciudad',
				//17 => 'PAIS',
				//18 => 'NUMERO_PREDIAL',
				//19 => 'CREATED_BY',
				//20 => 'CREATION_DATE',
				//21 => 'LAST_UPDATED_BY',
				//22 => 'LAST_UPDATE_DATE',
				//23 => 'MOTIVO_CAMBIO'
			);
			
			$headers_piso = array(
				1 => 'PISO_ID',
				2 => 'INMUEBLE_ID',
				3 => 'PREDIO_ID',
				4 => 'ESTATUS_PISO',
				5 => 'CATEGORIA_PISO',
				6 => 'NIVEL_PISO',
				7 => 'AREA_CONSTRUIDA',
				8 => 'AREA_RENTABLE',
				//9 => 'CREATED_BY',
				//10 => 'CREATION_DATE',
				//11 => 'LAST_UPDATED_BY',
				//12 => 'LAST_UPDATE_DATE',
				//13 => 'MOTIVO_CAMBIO'
			);
	
			$headers_local = array(
				1 => 'LOCAL_ID',
				2 => 'INMUEBLE_ID',
				3 => 'PREDIO_ID',
				4 => 'PISO_ID',
				5 => 'NUMERO',
				6 => 'AREA_RENTABLE',
				7 => 'TIPO_DE_LOCAL',
				8 => 'CATEGORIA_LOCAL',
				9 => 'ESTATUS_LOCAL',
				//10 => 'FECHA_INICIO_LOCAL',
				//11 => 'FECHA_FIN_LOCAL',
				//12 => 'AGRUPADO',
				//13 => 'LOCALES_AGRUPADOS',
				//14 => 'PLANO',
				//15 => 'CREATED_BY',
				//16 => 'CREATION_DATE',
				//17 => 'LAST_UPDATED_BY',
				//18 => 'LAST_UPDATE_DATE',
				//19 => 'MOTIVO_CAMBIO',
				20 => 'USO_LOCAL',
				21 => 'LOCAL_INTELISIS_ID'
			);

			$permitidos =  array('xls','xlsx','XLS','XLSX');

			$archivoNombre	= $_FILES['archivo_obras']['name'];
			$archivoTipo	= $_FILES['archivo_obras']['type'];
			$tamanoH		= $_FILES['archivo_obras']['size'];

			$ext = pathinfo($archivoNombre, PATHINFO_EXTENSION);

			if(in_array($ext,$permitidos) ) {

		   		move_uploaded_file($_FILES['archivo_obras']['tmp_name'],DIRORACLE.$archivoNombre);
				
				$this->load->library('excel');
		
				/*
				 * PHP Excel - Read a simple 2007 XLSX Excel file
				 */
				
				/** Set default timezone (will throw a notice otherwise) */
				//date_default_timezone_set('America/Los_Angeles');
				//date_default_timezone_set('UTC');
				$saveTimeZone = date_default_timezone_get();

				date_default_timezone_set($saveTimeZone);
				
				//include 'Classes/PHPExcel/IOFactory.php';
				
				$inputFileName = DIRORACLE.$archivoNombre;
				
				//  Read your Excel workbook
				try {
				    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
				    $objPHPExcel = $objReader->load($inputFileName);
				} catch (Exception $e) {
				    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
				    . '": ' . $e->getMessage());
				}
		
				$worksheetNames = $objPHPExcel->getSheetNames($inputFileName);
		
		    	foreach($worksheetNames as $key => $sheetName){

					//  Get worksheet dimensions
					$sheet 			= $objPHPExcel->getSheetByName($sheetName);
					$highestRow 	= $sheet->getHighestRow();
					$highestColumn 	= $sheet->getHighestColumn();
					
					//Insertar Datos tabla XXAPE_INMUEBLE
					if($sheetName == 'XXAPE_INMUEBLE'){
						//  Loop para recorrer todos las filas de la hoja
						for ($row = 2; $row <= $highestRow; $row++) {
							$banco_id		= null;
							$no_cuenta 		= null;
							$clave_servicio	= null;
							
						    // Obtener row completo en array
						    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
						    NULL, TRUE, FALSE);
							$temp_insert_inmueble = array();
							//Recorrer el row que obtuvimos
							foreach($rowData[0] as $k=>$v){
								if(isset($headers_inmueble[$k+1]) && $headers_inmueble[$k+1] == 'Inmueble_Id'){
								
									$inmueble_datos[$rowData[0][1]] = $v;

									$oracle_data_inmueble = array();
									$q = $intelisis->query("SELECT * FROM CUENTAS_BANCARIAS WHERE SUCURSAL_ID = $v");
								
									if($q->num_rows() > 0) {
										foreach($q->result() as $intel_data_cuentas){
											$oracle_data_inmueble = $intel_data_cuentas;
										}
										$q->free_result();
									}
									if( !empty($oracle_data_inmueble) ){
										$banco_id		= $bancos[$oracle_data_inmueble->BANCO];
										$no_cuenta 		= $oracle_data_inmueble->NCUENTA;
										$clave_servicio	= $oracle_data_inmueble->CLAVEDESERVICIO;
									}
									$temp_insert_inmueble[$headers_inmueble[$k+1]] = $v;
								}elseif(isset($headers_inmueble[$k+1]) && $headers_inmueble[$k+1] == 'BANCO_ID'){
									$temp_insert_inmueble[$headers_inmueble[$k+1]] = $banco_id;
								}elseif(isset($headers_inmueble[$k+1]) && $headers_inmueble[$k+1] == 'NO_CUENTA'){
									$temp_insert_inmueble[$headers_inmueble[$k+1]] = $no_cuenta;
								}elseif(isset($headers_inmueble[$k+1]) && $headers_inmueble[$k+1] == 'CLAVE_SERVICIO'){
									$temp_insert_inmueble[$headers_inmueble[$k+1]] = $clave_servicio;
								}elseif(isset($headers_inmueble[$k+1])){
									//Instertar Fecha en formato correcto
									if($headers_inmueble[$k+1] == "Fecha_Inicio" || $headers_inmueble[$k+1] == "Creation_Date"){
										$cell = $objPHPExcel->getActiveSheet()->getCell(strtoupper($letters[$k]) . $row);
										$InvDate= $cell->getValue();
										if(PHPExcel_Shared_Date::isDateTime($cell)) {
	     									$InvDate = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($InvDate)); 
										}
										$temp_insert_inmueble[$headers_inmueble[$k+1]] = $InvDate;
									}else{
										$temp_insert_inmueble[$headers_inmueble[$k+1]] = $v;
									}
								}
							}

							$intelisis->insert('Final1.INMUEBLE', $temp_insert_inmueble);
							
							
						}
					}

					//Insertar Datos tabla XXAPE_PREDIAL
					if($sheetName == 'XXAPE_PREDIAL'){
						
						//Autoincrementa PREDIO_ID
						$q = $oracle->query("SELECT (MAX(PREDIO_ID)+ 1) as PREDIO_ID FROM xxape_predial");
						if($q->num_rows() > 0) {
							foreach($q->result() as $ora_data_predial){
								$predio_id = $ora_data_predial->PREDIO_ID;
							}
							$q->free_result();
						}
		
						//  Loop para recorrer todos las filas de la hoja
						for ($row = 2; $row <= $highestRow; $row++) {
						    // Obtener row completo en array
						    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
						    NULL, TRUE, FALSE);
							$temp_insert_predial = array();
							//Recorrer el row que obtuvimos
							foreach($rowData[0] as $k=>$v){
								//Insertamos Predio_Id
								if(isset($headers_predial[$k+1]) && $headers_predial[$k+1] == 'Predio_Id'){
									$temp_insert_predial[$headers_predial[$k+1]] = $predio_id;
									$datos_predio[$rowData[0][3]] = $predio_id;
								}
								//Insertamos Inmueble_id
								elseif(isset($headers_predial[$k+1]) && $headers_predial[$k+1] == 'Inmueble_id'){
									
									$temp_insert_predial[$headers_predial[$k+1]] = $inmueble_datos[$rowData[0][2]];
									
								}
								//Insertamos los otros datos
								elseif(isset($headers_predial[$k+1])){
									$temp_insert_predial[$headers_predial[$k+1]] = $v;
								}
							}
							++$predio_id;
							$intelisis->insert('Final1.PREDIAL', $temp_insert_predial);
						}
					}

					//Insertar Datos tabla XXAPE_PISO
					if($sheetName == 'XXAPE_PISO'){
						$q = $oracle->query("SELECT (MAX(PISO_ID)+ 1) as PISO_ID FROM xxape_piso");
						if($q->num_rows() > 0) {
							foreach($q->result() as $ora_data_piso){
								$piso_id = $ora_data_piso->PISO_ID;
							}
							$q->free_result();
						}

						//  Loop para recorrer todos las filas de la hoja
						for ($row = 2; $row <= $highestRow; $row++) {
						    // Obtener row completo en array
						    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
						    NULL, TRUE, FALSE);
							$temp_insert = array();
							//Recorrer el row que obtuvimos
							foreach($rowData[0] as $k=>$v){
								//Insertamos Piso_Id
								if(isset($headers_piso[$k+1]) && $headers_piso[$k+1] == 'PISO_ID'){
									$temp_insert[$headers_piso[$k+1]] = $piso_id;
								}elseif(isset($headers_piso[$k+1]) && $headers_piso[$k+1] == 'PREDIO_ID'){
									$temp_insert[$headers_piso[$k+1]] = $datos_predio[$v];
								}elseif(isset($headers_piso[$k+1])){
									$temp_insert[$headers_piso[$k+1]] = $v;
								}
								if(isset($headers_piso[$k+1]) && $headers_piso[$k+1] == 'NIVEL_PISO'){

									$datos_piso[$v] = $piso_id;
								}

							}
							++$piso_id;

							$intelisis->insert('Final1.PISO', $temp_insert);
						}

					}
					
					//Insertar Datos tabla XXAPE_LOCAL
					if($sheetName == 'XXAPE_LOCAL'){
						
						$q = $oracle->query("SELECT (MAX(LOCAL_ID)+ 1) as LOCAL_ID FROM xxape_local");
						if($q->num_rows() > 0) {
							foreach($q->result() as $ora_data_local){
								$local_id = $ora_data_local->LOCAL_ID;
							}
							$q->free_result();
						}

						//  Loop para recorrer todos las filas de la hoja
						for ($row = 2; $row <= $highestRow; $row++) {
						    // Obtener row completo en array
						    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
						    NULL, TRUE, FALSE);
							$temp_insert = array();
							//Recorrer el row que obtuvimos
							foreach($rowData[0] as $k=>$v){
								//Insertamos Local_Id
								if(isset($headers_local[$k+1]) && $headers_local[$k+1] == 'LOCAL_ID'){
									$temp_insert[$headers_local[$k+1]] = $local_id;
								}elseif(isset($headers_local[$k+1]) && $headers_local[$k+1] == 'PREDIO_ID'){
									$temp_insert[$headers_local[$k+1]] = $datos_predio[$v];
								}elseif(isset($headers_local[$k+1]) && $headers_local[$k+1] == 'PISO_ID'){
									$temp_insert[$headers_local[$k+1]] = $datos_piso[$v];
								}elseif(isset($headers_local[$k+1])){
									$temp_insert[$headers_local[$k+1]] = $v;
								}
							}
							++$local_id;

							$intelisis->insert('Final1.LOCAL', $temp_insert);
						}

					}
		
		    	}				

				$this->session->set_flashdata('msg','<div class="msg mt20 mb20">El archivo fue cargado.</div>');

			}else{

				$this->session->set_flashdata('msg','<div class="msg mt20 mb20">Favor de Ingresar un Formato valido.</div>');

			}
			redirect('oracle');
		}
		
	}

	function procesar_pasos_29(){
		
		$intelisis = $this->load->database('intelisis',true);
		$oracle = $this->load->database('apedev',true);
		
		$solicitud_id 		= null;
		$documento_id 		= null;
		$contacto_id		= null;
		$contrato_id		= null;
		$punto_id			= null;
		$direccion_id		= null;
		$ref_bancaria_id	= null;

		$intelisis->query("APEExtractorPaso4")->free_result();

		//Ejecutar paso por paso archivo 21 
		$intelisis->query("UPDATE ETL.Clientes SET TIPO_PERSONA = 'PF' WHERE TIPO_PERSONA = 'FISICA'");
		$intelisis->query("UPDATE ETL.Clientes SET TIPO_PERSONA = 'PM' WHERE TIPO_PERSONA = 'MORAL'");
		$intelisis->query("UPDATE ETL.Clientes
			SET TIPO_PERSONA = CASE WHEN C1.FiscalRegimen = 'Persona Fisica' THEN 'PF' ELSE 'PM' END, RFC = C1.RFC
			FROM ETL.Clientes C
			INNER JOIN Cte C1
			ON CAST(C.CLIENTE_ID AS VARCHAR(20)) = C1.CLIENTE
			WHERE C.TIPO_PERSONA IS NULL");
		$intelisis->query("UPDATE ETL.Clientes SET FECHA_NACIMIENTO = '1900-01-01' WHERE TIPO_PERSONA = 'PF' AND RFC IN ('XAXX010101000', 'XAX010101000')");
		$intelisis->query("WITH IntentosFecha AS (
			SELECT CLIENTE_ID, '19' + SUBSTRING(RFC, 5, 2) + SUBSTRING(RFC, 7, 2) + SUBSTRING(RFC, 9, 2) AS FechaNacimiento FROM ETL.Clientes WHERE TIPO_PERSONA = 'PF' AND RFC NOT IN ('XAXX010101000', 'XAX010101000')
				)
				UPDATE ETL.Clientes
				SET ERROR = 'RFC no válido'
				WHERE CLIENTE_ID IN (
					SELECT CLIENTE_ID
					FROM IntentosFecha
					WHERE ISDATE(FechaNacimiento) = 0
				)")->free_result();
		$intelisis->query("UPDATE ETL.Clientes SET NOMBRE_ORG = NOMBRE WHERE TIPO_PERSONA = 'PM'");
		$intelisis->query("SELECT * INTO Error.Clientes FROM ETL.Clientes WHERE NOT ERROR IS NULL")->free_result();
		$intelisis->query("DELETE ETL.Clientes WHERE NOT ERROR IS NULL");
		$intelisis->query("SELECT * FROM Error.Clientes")->free_result();
		$intelisis->query("UPDATE ETL.Clientes SET SEXO = 'M'");
		$intelisis->query("ALTER TABLE ETL.Clientes DROP COLUMN Error");
		$intelisis->query("SELECT Cliente, CASE WHEN AplicaMoratorios = 1 THEN 'Y' ELSE 'N' END AS AplicaMoratorios
			INTO #AplicaMoratorios
			FROM (
				SELECT C.Cliente, VC.AplicaMoratorios, ROW_NUMBER()OVER(PARTITION BY C.Cliente ORDER BY VC.AplicaMoratorios DESC) AS RowNumber
				FROM Contrato C
				INNER JOIN vic_contrato VC
				ON C.ID = VC.ID
				INNER JOIN (
					SELECT DISTINCT IDContrato
					FROM vic_condicion
					WHERE Articulo = 'REN'
				) AS A
				ON A.IDContrato = C.ID
				WHERE C.Sucursal IN (SELECT Sucursal FROM APESucursalObra ao) --modificar las sucursales en cuestion
				AND NOT C.Estatus IN ('BAJA', 'SINAFECTAR', 'SINLOCAL')
				AND VC.ESTATUS2 NOT IN ('prestados','baja')
				AND C.MovID IS NOT NULL
			) AS B
			WHERE RowNumber = 1")->free_result();
		$intelisis->query("SET IDENTITY_INSERT Final1.Clientes ON");
		$intelisis->query("INSERT INTO Final1.Clientes (CLIENTE_ID, NUMERO_CLIENTE, TIPO_CLIENTE, RFC, RAZON_SOCIAL_FACTURADOR, PRIMER_NOMBRE,
				SEGUNDO_NOMBRE, A_PATERNO, A_MATERNO, FECHA_NACIMIENTO, ESTADO_CIVIL, NACIONALIDAD, NOMBRE_ORG, SEXO, INCLUIR_INTERESES)
			SELECT CLIENTE_ID, CLIENTE_ID AS NUMERO_CLIENTE, 'EST' AS TIPO_CLIENTE, RFC, FACTURADOR AS RAZON_SOCIAL_FACTURADOR, PRIMER_NOMBRE,
				SEGUNDO_NOMBRE + ISNULL(' ' + TERCER_NOMBRE, '') + ISNULL(' ' + CUARTO_NOMBRE, '') AS SEGUNDO_NOMBRE,
				PRIMER_APELLIDO AS A_PATERNO, SEGUNDO_APELLIDO AS A_MATERNO, FECHA_NACIMIENTO, 'SOLTERO' AS ESTADO_CIVIL,
				'MEXICANA' AS NACIONALIDAD, NOMBRE_ORG, 'MASCULINO' AS SEXO, A.AplicaMoratorios AS INCLUIR_INTERESES
			FROM ETL.Clientes C
			INNER JOIN #AplicaMoratorios A
			ON C.CLIENTE_ID = A.Cliente
			WHERE C.TIPO_PERSONA = 'PF'");
		$intelisis->query("INSERT INTO Final1.Clientes (CLIENTE_ID, NUMERO_CLIENTE, TIPO_CLIENTE, RFC, RAZON_SOCIAL_FACTURADOR, PRIMER_NOMBRE,
				SEGUNDO_NOMBRE, A_PATERNO, A_MATERNO, FECHA_NACIMIENTO, ESTADO_CIVIL, NACIONALIDAD, NOMBRE_ORG, SEXO, INCLUIR_INTERESES)
			SELECT CLIENTE_ID, CLIENTE_ID AS NUMERO_CLIENTE, 'EST' AS TIPO_CLIENTE, RFC, FACTURADOR AS RAZON_SOCIAL_FACTURADOR, 'CARGA_APEX' AS PRIMER_NOMBRE,
				'' SEGUNDO_NOMBRE,
				'CARGA_APEX' AS A_PATERNO, 'CARGA_APEX' AS A_MATERNO, FECHA_NACIMIENTO, '' AS ESTADO_CIVIL,
				'MEXICANA' AS NACIONALIDAD, NOMBRE_ORG, 'MASCULINO' AS SEXO, A.AplicaMoratorios AS INCLUIR_INTERESES
			FROM ETL.Clientes C
			INNER JOIN #AplicaMoratorios A
			ON C.CLIENTE_ID = A.Cliente
			WHERE C.TIPO_PERSONA = 'PM'");
		$intelisis->query("SET IDENTITY_INSERT Final1.Clientes OFF");
		$intelisis->query("SELECT C.CLIENTE_ID, LD.Value_Code
			INTO #Facturadores
			FROM Final1.Clientes C
			INNER JOIN ETL.VALORES_LISTAS_DETALLE LD
			ON REPLACE(C.RAZON_SOCIAL_FACTURADOR, ' SA DE CV', '') = LD.Value_Meaning
			AND LD.LOV_ID = 117")->free_result();
		$intelisis->query("UPDATE Final1.CLIENTES
			SET RAZON_SOCIAL_FACTURADOR = F.Value_Code
			FROM Final1.CLIENTES C
			INNER JOIN #Facturadores F
			ON C.CLIENTE_ID = F.CLIENTE_ID");
		$intelisis->query("UPDATE Final1.CLIENTES
			SET FECHA_NACIMIENTO = A.FechaNacimiento
			FROM Final1.CLIENTES C
			INNER JOIN (
				SELECT CLIENTE_ID, CAST('19' + SUBSTRING(RFC, 5, 2) + SUBSTRING(RFC, 7, 2) + SUBSTRING(RFC, 9, 2) AS DATE) AS FechaNacimiento FROM ETL.Clientes WHERE TIPO_PERSONA = 'PF' AND RFC NOT IN ('XAXX010101000', 'XAX010101000')
			) AS A
			ON C.CLIENTE_ID = A.CLIENTE_ID");
		$intelisis->query("UPDATE Final1.CLIENTES
			SET FECHA_NACIMIENTO = A.FechaNacimiento
			FROM Final1.CLIENTES C
			INNER JOIN (
				SELECT CLIENTE_ID, CAST('19' + SUBSTRING(RFC, 5, 2) + SUBSTRING(RFC, 7, 2) + SUBSTRING(RFC, 9, 2) AS DATE) AS FechaNacimiento FROM ETL.Clientes WHERE TIPO_PERSONA = 'PF' AND RFC NOT IN ('XAXX010101000', 'XAX010101000')
			) AS A
			ON C.CLIENTE_ID = A.CLIENTE_ID");
		$intelisis->query("SET IDENTITY_INSERT Final1.CLIENTES ON");
		$intelisis->query("INSERT INTO Final1.CLIENTES (CLIENTE_ID)
			SELECT CLIENTE_ID FROM Error.CLIENTES");
		$intelisis->query("SET IDENTITY_INSERT Final1.CLIENTES OFF");
		$intelisis->query("insert into ETL.Clientes (CLIENTE_ID , NOMBRE , TIPO_PERSONA , PLAZA , PRIMER_NOMBRE , SEGUNDO_NOMBRE , TERCER_NOMBRE , CUARTO_NOMBRE , PRIMER_APELLIDO , SEGUNDO_APELLIDO , RFC , DIRECCION , NUMERO , NUMERO_INTERIOR , DELEGACION , COLONIA , POBLACION , ESTADO , PAIS , CODIGO_POSTAL , FACTURADOR , OBSERVACIONES , ALTA , FECHA_NACIMIENTO , NOMBRE_ORG , SEXO )
			select CLIENTE_ID , NOMBRE , TIPO_PERSONA , PLAZA , PRIMER_NOMBRE , SEGUNDO_NOMBRE , TERCER_NOMBRE , CUARTO_NOMBRE , PRIMER_APELLIDO , SEGUNDO_APELLIDO , RFC , DIRECCION , NUMERO , NUMERO_INTERIOR , DELEGACION , COLONIA , POBLACION , ESTADO , PAIS , CODIGO_POSTAL , FACTURADOR , OBSERVACIONES , ALTA , FECHA_NACIMIENTO , NOMBRE_ORG , SEXO from Error.Clientes");		
		
		//Fin del archivo 21
		
		$q = $oracle->query("select (MAX(solicitud_id)+1) as solicitud_id from XXAPE_CLIENTE_SOLICITUDES");
		if($q->num_rows() > 0) {
			foreach($q->result() as $ora_solicitudes){
				$solicitud_id = $ora_solicitudes->SOLICITUD_ID;
			}
			$q->free_result();
		}
		
		$q = $oracle->query("select (MAX(documento_id)+1) as documento_id from XXAPE_CLIENTE_DOC");
		if($q->num_rows() > 0) {
			foreach($q->result() as $ora_cliente_doc){
				$documento_id = $ora_cliente_doc->DOCUMENTO_ID;
			}
			$q->free_result();
		}
		
		$q = $oracle->query("select (MAX(contacto_id)+1) as contacto_id from XXAPE_CONTACTOS");
		if($q->num_rows() > 0) {
			foreach($q->result() as $contactos){
				$contacto_id = $contactos->CONTACTO_ID;
			}
			$q->free_result();
		}
		
		$q = $oracle->query("select (MAX(punto_contacto_id)+1) as punto_contacto_id from XXAPE_PUNTOS_CONTACTO");
		if($q->num_rows() > 0) {
			foreach($q->result() as $puntos_contacto){
				$punto_id = $puntos_contacto->PUNTO_CONTACTO_ID;
			}
			$q->free_result();
		}
		
		$q = $oracle->query("select (MAX(CONTRATO_ID)+1) as CONTRATO_ID from XXAPE_CONTRATOS");
		if($q->num_rows() > 0) {
			foreach($q->result() as $puntos_contrato){
				$contrato_id = $puntos_contrato->CONTRATO_ID;
			}
			$q->free_result();
		}
		
		$q = $oracle->query("select (MAX(direccion_id)+1) as direccion_id from XXAPE_DIRECCIONES");
		if($q->num_rows() > 0) {
			foreach($q->result() as $direcciones){
				$direccion_id = $direcciones->DIRECCION_ID;
			}
			$q->free_result();
		}
		
		$q = $oracle->query("select (MAX(REFERENCIA_BANCARIA_ID)+1) as REFERENCIA_BANCARIA_ID from XXAPE_CLIENTE_REF_BANCARIAS");
		if($q->num_rows() > 0) {
			foreach($q->result() as $cliente_ref_bancarias){
				$ref_bancaria_id = $cliente_ref_bancarias->REFERENCIA_BANCARIA_ID;
			}
			$q->free_result();
		}
				
		$intelisis->query("EXEC APEExtractorPaso5 $solicitud_id, $documento_id, $contacto_id, $punto_id, $direccion_id")->free_result();
		
		$intelisis->query("EXEC APEExtractorPaso6 $contrato_id, $ref_bancaria_id")->free_result();

	} 
}