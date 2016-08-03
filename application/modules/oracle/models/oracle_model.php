<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oracle_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	function traer_plazas(){
		$data = array();
		$intelisis = $this->load->database('intelisis',true);
		$q = $intelisis->query("SELECT * FROM sucursal");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	//Paso uno enviar excel a obras
	function traerLocales(){
		$data = array();
		$intelisis = $this->load->database('intelisis',true);
		$q = $intelisis->query("EXEC APECargaObra");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function traer_plazas_a_procesar(){
		
		$data = array();
		$intelisis = $this->load->database('intelisis',true);
		$q = $intelisis->query("SELECT * FROM APESucursalObra");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function traer_clientes_a_procesar(){
		
		$data = array();
		$intelisis = $this->load->database('intelisis',true);
		$q = $intelisis->query("select * from etl.Clientes");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function traer_cliente_ref_bancarias(){
		
		$data = array();
		$intelisis = $this->load->database('intelisis',true);
		$q = $intelisis->query("select * from Final1.CLIENTE_REF_BANCARIAS");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function traer_clientes_solicitudes_a_procesar(){
		
		$data = array();
		$intelisis = $this->load->database('intelisis',true);
		$q = $intelisis->query("select * from final1.CLIENTE_SOLICITUDES");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function traer_cliente_doc_a_procesar(){
		
		$data = array();
		$intelisis = $this->load->database('intelisis',true);
		$q = $intelisis->query("select * from Final1.CLIENTE_DOC");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function traer_contactos_a_procesar(){
		
		$data = array();
		$intelisis = $this->load->database('intelisis',true);
		$q = $intelisis->query("select * from Final1.CONTACTOS");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function traer_direcciones_a_procesar(){
		
		$data = array();
		$intelisis = $this->load->database('intelisis',true);
		$q = $intelisis->query("select * from Final1.DIRECCIONES");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function traer_puntos_contactos_a_procesar(){
		
		$data = array();
		$intelisis = $this->load->database('intelisis',true);
		$q = $intelisis->query("select * from final1.PUNTOS_CONTACTO");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function genera_excel_obras($header_datos = array(),$data = array(),$plazas = array()){

		if(empty($header_datos) || empty($data)) return false;

		$this->load->library('excel');


		$objPHPExcel = new PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Ape plazas")
									 ->setLastModifiedBy("Ape plazas")
									 ->setTitle("Ape plazas");
		
		// Header
		$current_col = 0;
		
		$XXAPE_INMUEBLE = $objPHPExcel->createSheet();
		$XXAPE_INMUEBLE->setTitle("XXAPE_INMUEBLE");

		$header_xxape_inmueble = array('INMUEBLE_ID', 'CODIGO_INMUEBLE', 'NOMBRE_INMUEBLE', 'STATUS', 'FECHA_INICIO', 'FECHA_FIN', 'RAZON_SOCIAL_ID', 'BANCO_ID',
			'NO_CUENTA', 'CLAVE_SERVICIO', 'DIAS_PAGO', 'MOTIVO_CAMBIO', 'CREATED_BY', 'CREATION_DATE', 'LAST_UPDATED_BY', 'LAST_UPDATE_DATE', 'PLANO'
		);

		foreach($header_xxape_inmueble as $head){
			$XXAPE_INMUEBLE->setCellValueByColumnAndRow($current_col, 1, $head);
			++$current_col;
		}
		
		// Freeze panes
		$XXAPE_INMUEBLE->freezePane('A2');

		// Rows to repeat at top
		$XXAPE_INMUEBLE->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

		//Rows
		$row_col = 2;
		foreach($plazas as $value){
			$XXAPE_INMUEBLE->setCellValueByColumnAndRow(0, $row_col, $value->Sucursal);
			++$row_col;
		}
									 
		// Header
		$current_col = 0;
		
		$XXAPE_PREDIAL = $objPHPExcel->createSheet();
		$XXAPE_PREDIAL->setTitle("XXAPE_PREDIAL");

		$header_xxape_predial = array('PREDIO_ID', 'INMUEBLE_ID', 'INMUEBLE_ID', 'NOMBRE_DE_PREDIO', 'ESTATUS_DE_PREDIO', 'FECHA_INICIO', 'FECHA_FIN',
			'SUPERFICIE_TERRENO', 'CALLE', 'NUMERO_EXTERIOR', 'NUMERO_INTERIOR', 'COLONIA', 'DELEGACION_MUNICIPIO', 'CODIGO_POSTAL',
			'ESTADO', 'CIUDAD', 'PAIS', 'NUMERO_PREDIAL', 'CREATED_BY', 'CREATION_DATE', 'LAST_UPDATED_BY', 'LAST_UPDATE_DATE', 'MOTIVO_CAMBIO'
		);

		foreach($header_xxape_predial as $head){
			$XXAPE_PREDIAL->setCellValueByColumnAndRow($current_col, 1, $head);
			++$current_col;
		}
		
		// Header
		$current_col = 0;
		
		$XXAPE_PISO = $objPHPExcel->createSheet();
		$XXAPE_PISO->setTitle("XXAPE_PISO");

		$header_xxape_piso = array('PISO_ID', 'INMUEBLE_ID', 'PREDIO_ID', 'ESTATUS_PISO', 'CATEGORIA_PISO', 'NIVEL_PISO', 'AREA_CONSTRUIDA', 'AREA_RENTABLE',
			'CREATED_BY', 'CREATION_DATE', 'LAST_UPDATED_BY', 'LAST_UPDATE_DATE', 'MOTIVO_CAMBIO');

		foreach($header_xxape_piso as $head){
			$XXAPE_PISO->setCellValueByColumnAndRow($current_col, 1, $head);
			++$current_col;
		}
									 
		// Header
		$current_col = 0;
		
		$XXAPE_LOCAL = $objPHPExcel->createSheet();
		$XXAPE_LOCAL->setTitle("XXAPE_LOCAL");

		$header_xxape_local = array('LOCAL_ID', 'INMUEBLE_ID', 'PREDIO_ID', 'PISO_ID', 'NUMERO', 'AREA_RENTABLE', 'TIPO_DE_LOCAL', 'CATEGORIA_LOCAL', 'ESTATUS_LOCAL',
			'FECHA_INICIO_LOCAL', 'FECHA_FIN_LOCAL', 'AGRUPADO', 'LOCALES_AGRUPADOS', 'PLANO', 'CREATED_BY', 'CREATION_DATE', 'LAST_UPDATED_BY',
			'LAST_UPDATE_DATE', 'MOTIVO_CAMBIO', 'USO_DE_LOCAL', 'LOCAL_INTELISIS_ID'
		);

		foreach($header_xxape_local as $head){
			$XXAPE_LOCAL->setCellValueByColumnAndRow($current_col, 1, $head);
			++$current_col;
		}


		// Header
		$current_col = 0;
		//$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->removeSheetByIndex(0);
		
		$DATOS = $objPHPExcel->createSheet();
		$DATOS->setTitle("DATOS");

		foreach($header_datos as $head){
			$DATOS->setCellValueByColumnAndRow($current_col, 1, $head);
			++$current_col;
		}

		// Freeze panes
		$DATOS->freezePane('A2');

		// Rows to repeat at top
		$DATOS->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

		//Rows
		foreach($data as $key => $dat){
			$current_col = 0;
			if(is_array($dat) || is_object($dat)){
				foreach($dat as $value){
					$DATOS->setCellValueByColumnAndRow($current_col, $key+2, $value);
					++$current_col;
				}
			}
		}

		//Autosizes Columns
		$currentColDim = 0;
		foreach($header_datos as $head){
			$DATOS->getColumnDimensionByColumn($currentColDim)->setAutoSize(true);
			++$currentColDim;
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

}
