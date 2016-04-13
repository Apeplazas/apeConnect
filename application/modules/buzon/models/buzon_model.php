<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class buzon_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		//$this->load->model('data_model');
		//$this->load->library('soap_lib.php');
	}
	
	function insertaBuzon($plaza, $nombre, $tel, $email, $colonia, $sucursal, $local, $factura, $coment){
		$data = array(
					   'plaza' => $plaza ,
					   'nombre' => $nombre ,
					   'email' => $email,
					   'tel' => $tel,
					   'sucursal' => $sucursal,
					   'colonia' => $colonia,
					   'no_local' => $local,
					   'factura_recibo' => $factura,
					   'comentario' => $coment
					);
					
					
	$this->db->insert('buzon', $data); 
	
	return $this->db->affected_rows();
		/*$data = array(); 
		$q = $this->db->query("SELECT * FROM usuarios WHERE email='$admEmail'
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;*/
	}
}