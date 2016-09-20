<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cargas extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();
		//$this->user_model->checkuser();
		$this->load->model('user_model');
		$this->load->model('cargas_model');
	}

	function index(){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
								->add_include('assets/js/jquery.autocomplete.pack.js')
								->add_include('assets/js/jquery.dataTables.min.js')
								->add_include('assets/css/planogramas.css');

		$op['inmuebles'] = $this->cargas_model->cargarInmuebles();
		
		$this->layouts->profile('listaInmuebles-vista',$op);
	}


}
