<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_model extends CI_Model {

	function cargarOptimizacion($opt){
		$data = array();
		$q = $this->db->query("SELECT
								s.enlaceTitulo as 'enlaceTitulo',
								s.enlaceDescripcion as 'enlaceDescripcion'
								FROM enlaces s
								WHERE url='$opt'
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function buscarSeleccionLocalID($id){
		$data = array();
		$q = $this->db->query("SELECT * from contratos WHERE Clavedelocal='$id'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function buscarSeleccionContrato($id){
		$data = array();
		$q = $this->db->query("SELECT * from contratos WHERE Clavedelocal='$id'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarTipoCompania(){
		$data = array();
		$q = $this->db->query("SELECT * FROM obrasTipo");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function costoRango(){
		$data = array();
		$q = $this->db->query("SELECT * FROM costoRango");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargaZonas(){
		$data = array();
		$q = $this->db->query("SELECT * FROM propiedades");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargaZonasID($plazaID){
		$data = array();
		$q = $this->db->query("SELECT * FROM zonas where idZona='$plazaID'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}


	function cargaUnidades(){
		$data = array();
		$q = $this->db->query("SELECT * FROM unidades");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargaUnidadesporNombre($nombre){
		$data = array();
		$q = $this->db->query("SELECT * FROM unidades where nombre='$nombre'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargaPartidaporNombre($nombre){
		$data = array();
		$q = $this->db->query("SELECT * FROM partidas where nombre='$nombre'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function verificaPartidaEnProyecto($proyectoId,$partidaId){

		$data = array();
		$q = $this->db->query("SELECT * FROM ProyectosPartidas
			where proyectoId='$proyectoId'
			AND partidaId='$partidaId'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;

	}

	function buscarConceptops($filtro){
		$data = array();
		$q = $this->db->query("SELECT * FROM diccionarioConceptos WHERE lower(concepto)  LIKE '%$filtro%' LIMIT 15");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function verificaConceptos($var){
		$data = array();
		$q = $this->db->query("select * from diccionarioConceptos where concepto='$var'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	/*
	 * $header = array(
			'Columna1','Columna2','Columna3','Columna4'
		);
		$this->data_model->genera_excel($header,$op['proveedores']);
	 * */

	function genera_excel($header = array(),$data = array()){

		if(empty($header) || empty($data)) return false;

		$this->load->library('excel');


		$objPHPExcel = new PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Ape plazas")
									 ->setLastModifiedBy("Ape plazas")
									 ->setTitle("Ape plazas");


		// Header
		$current_col = 0;
		$objPHPExcel->setActiveSheetIndex(0);

		foreach($header as $head){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($current_col, 1, $head);
			++$current_col;
		}

		// Freeze panes
		$objPHPExcel->getActiveSheet()->freezePane('A2');

		// Rows to repeat at top
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

		//Rows
		foreach($data as $key => $dat){
			$current_col = 0;
			if(is_array($dat) || is_object($dat)){
				foreach($dat as $value){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($current_col, $key+2, $value);
					++$current_col;
				}
			}
		}

		//Autosizes Columns
		$currentColDim = 0;
		foreach($header as $head){
			$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($currentColDim)->setAutoSize(true);
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

	function buscarSeleccionLocal($id){
		$data = array();
		$q = $this->db->query("SELECT * FROM vector v
								LEFT JOIN localesBorrar l ON l.id=v.localID
								WHERE v.id='$id'
								AND v.localID != ''
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function buscarVector($id){
		$data = array();
		$q = $this->db->query("select * from vector where id='$id'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function buscarSeleccion($local){
		$data = array();
		$q = $this->db->query("select * from localesBorrar where clavedeLocal='$local'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function buscarSeleccionVicLocal($local,$vactorId){
		$data = array();
		$q = $this->db->query("select l.*,v.id from vic_local l
			LEFT JOIN vector v ON v.localID = l.local
			where l.local='$local' AND v.id='$vactorId'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}


	function cargarAjaxLocales($filtro){
		$data = array();
		$q = $this->db->query("SELECT * from localesBorrar WHERE clavedeLocal LIKE '%$filtro%'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function asignarAjaxLocales($filtro, $implode){
		$data = array();
		$q = $this->db->query("SELECT * from vic_local
								WHERE local not in ($implode)
								AND local LIKE '%$filtro%'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row->local;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarCatalogoLocalesAsignados(){
		$data = array();
		$q = $this->db->query("SELECT localID from catalogoLocalesAsignados");
		$i = 0;
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				if($q->num_rows() == ($i+1))
					$data[] = "'".$row->localID ."'";
				else
					$data[] = "'".$row->localID ."',";
				++$i;
			}
			$q->free_result();
		}
		return $data;
	}

	function estados(){

		$data = array();
        $q = $this->db->query("SELECT claveEstado AS idEstado,
        							  nombreEstado AS nombreEstado
		        					  FROM estadosMexico
		        					  GROUP BY claveEstado
		        					  ORDER BY claveEstado");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}

	function cargarGiros(){

		$data = array();
        $q = $this->db->query("SELECT * FROM prospectoGiro");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}

	function cargarVendedores(){
		$data = array();
        $q = $this->db->query("SELECT * FROM usuarios WHERE idrole='4'");
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            $q->free_result();
        }
        return $data;
	}

}
