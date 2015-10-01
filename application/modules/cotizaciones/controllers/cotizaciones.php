<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cotizaciones extends MX_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->user_model->checkuser();
		$this->load->model('cotizaciones_model');
		$this->load->model('user_model');
		$this->load->model('proyectos/proyecto_model');
	}
	
	function index(){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');
		$op['cotizaciones'] = $this->cotizaciones_model->traecotizaciones();
		$this->layouts->profile('cotizaciones-porproveedor-view', $op);
	}

	function porproyecto(){
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');
		$op['cotizaciones'] = $this->cotizaciones_model->traecotizaciones_porproyecto();
		$this->layouts->profile('cotizaciones-porproyecto-view', $op);
	}

	function ver($idcot){
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/js/jquery.dataTables.rowGrouping.js');
		$op['cotizacion'] = $this->cotizaciones_model->traecotizacion($idcot);
		$op['usuarioId'] = $op['cotizacion'][0]->usuarioID;
		
		$this->layouts->profile('cotizacion-detalle-view', $op);
	}
	
	function ver_proyecto($idproyecto){
		$op['cotizacion'] = $this->cotizaciones_model->traecotizacion_deproyecto($idproyecto);
		$this->layouts->profile('cotizacion-proyecto-detalle-view', $op);
	}
	
	function asignarProyecto(){
		
		//Datos para la asignacion del proyecto
		$proyId			= $this->input->post('proyectoId');
		$proveedorId 	= $this->input->post('proveedorId');
		$provEmail 		= $this->user_model->traeProveeedorEmail($proveedorId);
		$detalleAsig	= $this->cotizaciones_model->traeDetalleCot($proyId,$proveedorId);
		$detalleAsig[0]->total += $detalleAsig[0]->total * .16;		
		
		//Iniciar libreria para enviar emails
		$this->load->library('email');
		
		//Enviar Email al proveedor elegido
		$this->email->set_newline("\r\n");
		$this->email->from('contacto@apeplazas.com', 'APE Plazas Especializadas');
		$this->email->to($provEmail);
		$this->email->subject('Se le asignó el proyecto ' . $detalleAsig[0]->tituloProyecto);		
		$this->email->message('
			<html>
				<head>
					<title>Proyecto Asignado</title>
				</head>
				<body>
					<p><strong>&#161;Felicidades!</strong></p>
					<p>Se te asigno el proyecto ' . $detalleAsig[0]->tituloProyecto . '</p>
					<p>Tu cotizaci&oacute; fue de $' . number_format($detalleAsig[0]->total,2) . '</p>
				</body>
			</html>
		');
		$this->email->send();
		
		//Enviar email a los proveedores que participaron en el proyecto
		$mensajeProveedores = "<html>
				<head>
					<title>Proyecto Asignado</title>
				</head>
				<body>
					<p>El proyecto ya ha sido asignado a otro usuario por la cantidad de $" . number_format($detalleAsig[0]->total,2) . "</p>
				</body>
			</html>";
			
		$proveedoresEmails = $this->cotizaciones_model->traeParticipantesProyecto($proyId,$proveedorId);
		
		foreach($proveedoresEmails as $email){
			
			$this->email->set_newline("\r\n");
			$this->email->from('contacto@apeplazas.com', 'APE Plazas Especializadas');
			$this->email->to($email->email);
			$this->email->subject("Proyecto " . $detalleAsig[0]->tituloProyecto . " ha sido asignado");		
			$this->email->message($mensajeProveedores);
			$this->email->send();
			
		}

		$datosAsignarProyecto = array(
				'proyectoId' 		=> $proyId,
				'proveedorId' 		=> $proveedorId
		);
		$this->db->insert('proyectosAsignados', $datosAsignarProyecto);
		
		//Actualizar estado del proyecto
		$proyectoData = array(
			'statusProyecto'	=> 'Licitado',
			'fechaAsignacion'	=> date("Y-m-d")
		);
		$this->db->where('idProyecto', $proyId);
        $this->db->update('proyectos', $proyectoData);
        
        redirect('cotizaciones');
		
	}

	function exportarExcel($cotId){
				
		$header = array(
			'Segmento','Cantidad','Precio Unitario','Total'
		);
		$cotizacion = $this->cotizaciones_model->traecotizacion($cotId);
		$usuarioId	= $cotizacion[0]->usuarioID;
		$detalleCot = array();
		$tempName 	= '';

		$subtotal = 0; $partidaNombre = null; $i = 0;

		foreach($cotizacion as $cot):
			$obs = $this->cotizaciones_model->traeobservaciones($cot->idSegmento,$usuarioId);
			if($tempName != $cot->nombre){
				$detalleCot[$i]['nombre'] = $cot->nombre;
				$tempName = $cot->nombre;
				++$i;
			}
			$detalleCot[$i]['descrip'] = $cot->seccionDesc;
			foreach($obs as $rowO):
				$rowO->observacion;
			endforeach;
			$detalleCot[$i]['cantidad'] = $cot->cantidad . ' ' .$cot->simbolo;
			$detalleCot[$i]['punitario'] = '$' . number_format($cot->precio_unitario,2);
			$detalleCot[$i]['total'] = '$' . number_format($cot->segtotal,2);
			$subtotal += $cot->segtotal;
			++$i;
		endforeach;
		
		$detalleCot[$i]['descrip'] = null;
		$detalleCot[$i]['cantidad'] = null;
		$detalleCot[$i]['punitario'] = 'Subtotal';
		$detalleCot[$i]['total'] = '$' . number_format($subtotal,2);
		++$i;
		
		$detalleCot[$i]['descrip'] = null;
		$detalleCot[$i]['cantidad'] = null;
		$detalleCot[$i]['punitario'] = 'IVA 16%';
		$detalleCot[$i]['total'] = '$' . number_format($subtotal * .16,2);
		++$i;
		
		$detalleCot[$i]['descrip'] = null;
		$detalleCot[$i]['cantidad'] = null;
		$detalleCot[$i]['punitario'] = 'Total';
		$detalleCot[$i]['total'] = '$' . number_format($subtotal += $subtotal * .16,2);
		++$i;
	
		$this->data_model->genera_excel($header,$detalleCot);	
		
	}

}