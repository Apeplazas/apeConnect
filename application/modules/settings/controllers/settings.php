<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends MX_Controller
{
	
	public function __construct(){
		
		parent::__construct();
		$this->user_model->checkuser();
		$this->load->model('settings_model');
		$this->load->model('registrate_model');
		if( ! ini_get('date.timezone') ){
		    date_default_timezone_set('America/Mexico_City');
		}
		
	}
	
	function index(){		
		$this->layouts->add_include('assets/js/jquery.editinplace.js');
		
		$op['plazas'] = $this->settings_model->traeplazas();
		$op['estados']	= $this->registrate_model->estados();
		
		$this->layouts->profile('index-view',$op);
		
	}
	
	function units(){
		
		$op['unidades'] = $this->settings_model->traeunidades();
		$this->layouts->profile('unidades-view',$op);
		
	}
	
	function partidas(){
		
		$op['partidas'] = $this->settings_model->traepartidas();
		$this->layouts->profile('partidas-view',$op);
		
	}
		
}