<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Compranet extends MX_Controller {
	
	function compranet()
	{
		parent::__construct();
		$this->load->model('registrate_model');
	}

	function index()
	{
		
		//Vista//
		$this->load->view('compranet-view');
	}
	
	
	
}


