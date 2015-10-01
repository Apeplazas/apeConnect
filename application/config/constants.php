<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */

define('BASEURL',	'http://www.apeplazas.com/apeConnect/');

define('DIRCERTIFICADO',	$_SERVER['DOCUMENT_ROOT'].'/apeConnect/assets/graphics/documentosProveedores/certificado/');
define('DIRACTAS',			$_SERVER['DOCUMENT_ROOT'].'/apeConnect/assets/graphics/documentosProveedores/actas/');
define('DIRCEDULA',			$_SERVER['DOCUMENT_ROOT'].'/apeConnect/assets/graphics/documentosProveedores/cedulas/');
define('DIRSSHCP',			$_SERVER['DOCUMENT_ROOT'].'/apeConnect/assets/graphics/documentosProveedores/shcp/');
define('DIREDOCUENTA',		$_SERVER['DOCUMENT_ROOT'].'/apeConnect/assets/graphics/documentosProveedores/edoCuenta/');
define('DIRDOMICILIO',		$_SERVER['DOCUMENT_ROOT'].'/apeConnect/assets/graphics/documentosProveedores/domicilio/');
define('DIRCREDEL',			$_SERVER['DOCUMENT_ROOT'].'/apeConnect/assets/graphics/documentosProveedores/credEl/');
define('DIRIMSS',			$_SERVER['DOCUMENT_ROOT'].'/apeConnect/assets/graphics/documentosProveedores/imss/');
define('DIRPROYECTOS',		$_SERVER['DOCUMENT_ROOT'].'/apeConnect/assets/graphics/documentosProyectos/');
define('DIRCOTIZ',			$_SERVER['DOCUMENT_ROOT'].'/apeConnect/assets/graphics/documentosCotizaciones/');
define('DIRPLANO',			$_SERVER['DOCUMENT_ROOT'].'/apeConnect/assets/graphics/planogramas/');
define('DIRPDF',			$_SERVER['DOCUMENT_ROOT'].'/apeConnect/assets/graphics/cotizaciones/');
define('DIRCIDOCS',			$_SERVER['DOCUMENT_ROOT'].'/apeConnect/assets/graphics/ciDocs/');
define('DIRRIDOCS',			$_SERVER['DOCUMENT_ROOT'].'/apeConnect/assets/graphics/riDocs/');
define('DIREXCELS',			$_SERVER['DOCUMENT_ROOT'].'/apeConnect/assets/graphics/excels/');
define('DIRGRAPHICS',		$_SERVER['DOCUMENT_ROOT'].'/apeConnect/assets/graphics/');

define('URLCERTIFICADO',	BASEURL.'assets/graphics/documentosProveedores/certificado/');
define('URLACTAS',			BASEURL.'assets/graphics/documentosProveedores/actas/');
define('URLCEDULA',			BASEURL.'assets/graphics/documentosProveedores/cedulas/');
define('URLSSHCP',			BASEURL.'assets/graphics/documentosProveedores/shcp/');
define('URLEDOCUENTA',		BASEURL.'assets/graphics/documentosProveedores/edoCuenta/');
define('URLDOMICILIO',		BASEURL.'assets/graphics/documentosProveedores/domicilio/');
define('URLCREDEL',			BASEURL.'assets/graphics/documentosProveedores/credEl/');
define('URLIMSS',			BASEURL.'assets/graphics/documentosProveedores/imss/');
define('URLPROYECTOS',		BASEURL.'assets/graphics/documentosProyectos/');
define('URLCOTIZ',			BASEURL.'assets/graphics/documentosCotizaciones/');
define('URLPLANO',			BASEURL.'assets/graphics/planogramas/');
define('URLPDF',			BASEURL.'assets/graphics/cotizaciones/');
define('URLCIDOCS',			BASEURL.'assets/graphics/ciDocs/');
define('URLRIDOCS',			BASEURL.'assets/graphics/riDocs/');