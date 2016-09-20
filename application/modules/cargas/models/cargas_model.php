<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cargas_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	
	function cargarInmuebles(){
		$data = array();
		$q = $this->db->query("SELECT * FROM BORRAR_vic_Inmueble order by Nombre asc");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function cargarPredios($intelisisInmueble, $grupo){
		
		$concat = '';
		
		if ($grupo == 'agrupar'){
			$concat = 'group by i.inmuebleID';
		}
		
		$data = array();
		$q = $this->db->query("SELECT * FROM Inmuebles i 
												LEFT JOIN predios p ON p.inmuebleID=i.inmuebleID
												where i.inmuebleIntelisis='$intelisisInmueble'
												$concat
												");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

}
