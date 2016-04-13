<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*Web service creado para entregar datos a los sitios de apeplazas
 * */
class Service extends MX_Controller {
	
	public function __construct()
	{
		parent::__construct();
		//$this->load->model('data_model');
		$this->load->model('service_model');
		$this->load->library("soap_lib");
	}
	
	function index(){
		//$this->nusoap_client = new nusoap_client("http://url.servidor.soap");
		//$server = new nusoap_server();

			$server->configureWSDL('Web Service APEConnect', 'urn:serviceape');
			
			// Parametros de entrada
			$server->wsdl->addComplexType(  'datos_entrada', 
			                                'complexType', 
			                                'struct', 
			                                'all', 
			                                '',
			                                array('nombre'   => array('name' => 'nombre','type' => 'xsd:string'))
			);
			// Parametros de Salida
			$server->wsdl->addComplexType(  'datos_salidad', 
			                                'complexType', 
			                                'struct', 
			                                'all', 
			                                '',
			                                array('mensaje'   => array('name' => 'mensaje','type' => 'xsd:string'))
			);
			
			$server->register(  'traeSuc', // nombre del metodo o funcion
			                    array('datos_entrada' => 'tns:datos_persona_entrada'), // parametros de entrada
			                    array('return' => 'tns:datos_salidad'), // parametros de salida
			                    'urn:serviceape', // namespace
			                    'urn:hellowsdl2#traeSuc', // soapaction debe ir asociado al nombre del metodo
			                    'rpc', // style
			                    'encoded', // use
			                    'Consume datos de apeConnect' // documentation
			);
								
			$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
			$server->service($HTTP_RAW_POST_DATA);
	}
	
	/*function traeSuc($plaza){
		
	}*/

}