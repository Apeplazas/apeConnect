<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buzon extends MX_Controller {
	
	public function __construct()
	{
		parent::__construct();
		//$this->load->model('data_model');
		$this->load->model('buzon_model');
	}
	
	function index(){
		//echo "test";
		
		//echo $_SERVER['SERVER_NAME'];
		//echo $_SERVER['SERVER_ADDR'];
		//var_dump($_POST);
		$nombre = preg_replace('[*$#@|!&¬ ^="]','', $_POST['nombre']);
		$tel = preg_replace('[*$#@|!&¬ ^="]','', $_POST['tel']);
		$email = preg_replace('[*$#@|!&¬ ^="]','', $_POST['email']);
		$colonia = preg_replace('[*$#@|!&¬ ^="]','', $_POST['colonia']);
		$sucursal = preg_replace('[*$#@|!&¬ ^="]','', $_POST['sucursal']);
		$local = preg_replace('[*$#@|!&¬ ^="]','', $_POST['local']);
		$factura = preg_replace('[*$#@|!&¬ ^="]','', $_POST['factura']);
		$coment = preg_replace('[*$#@|!&¬ ^="]','', $_POST['comentario']);
		$plaza = preg_replace('[*$#@|!&¬ ^="]','', $_POST['plaza']);
		
		if($_SERVER['SERVER_ADDR'] == "198.154.246.178"){
			$result = $this->buzon_model->insertaBuzon($plaza, $nombre, $tel, $email, $colonia,$sucursal, $local, $factura, $coment);
			$msg = "correcto";
		}else{
			$msg = "incorrecto";
		}
		
		switch ($plaza) {
		    case 'cnbbosques':
		        header('Location: http://www.cnbbosques.com/buzon?'.$msg.''); 
		        break;
		}
		
		//$op[] = "Gracias por contactarnos";
		//$result = $this->buzon_model->insertaBuzon($plaza, $nombre, $tel, $email, $colonia,$sucursal, $local, $factura, $coment);
		//Vista//
		//s$this->layouts->blanco('respuesta-view' ,$op);
		//$mensaje = "gracias";
		/*switch ($plaza) {
		    case 'cnbbosques':
		        header('Location: http://www.cnbbosques.com/buzon?action); 
		        break;
		}*/
	}
	
	/*function statusProspecto()
	{
		//Optimizacion y conexion de tags para SEO//
		$opt = $this->uri->segment(1); 
		$op['opt'] = $this->data_model->cargarOptimizacion($opt);
		
		$user = $this->session->userdata('usuario');
		$op['prospectos'] 	= $this->prospectos_model->cargarProspectosUsuario($user['usuarioID']); 
		
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');
		
		//Vista//
		$this->layouts->profile('error-view' ,$op);
	}*/
}