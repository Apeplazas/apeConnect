<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class rh extends MX_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->user_model->checkuser();
		$this->load->model('rh_model');
		
		
	}
	
	function index()
	{
		
		$user = $this->session->userdata('usuario');
		$today = date('Y-m-d');
		if($this->uri->segment(1) =='rh'){ ?>
			<script src="<?php echo base_url(); ?>assets/js/jquery-1.9.1.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
			<script type="text/javascript">
					
					$(document).ready(function() {
						var usuarioID	= '<?= $user['usuarioID']?>';
						var fechaAcceso = '<?= $today ?>';
						var modulo = 'rh';
						
						$.post('<?=base_url()?>ajax/cuentaEntradaModulos',{
										usuarioID : usuarioID,
										fechaAcceso : fechaAcceso,
										modulo : modulo
						},'json');
					});
					
			</script>
		<? }
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.dataTables.min.js')
					  ->add_include('assets/css/jquery-datepicker.css')
					  ->add_include('assets/js/jquery-datepicker.js');
					  
		//Informacion perfil general//
		$user      = $this->session->userdata('usuario');
		$user_type = strtoupper($user['tipoUsuario']);
		
		$op['tipos'] 	= $this->data_model->cargarTipoCompania();
		$op['rango'] 	= $this->data_model->costoRango();
		$op['zonas'] 	= $this->data_model->cargaZonas();
		$op['userID']   = $user['usuarioID'];
		$op['profile']	= $info = $this->user_model->traeadmin($user['usuarioID']);
		
		$op['empleados'] = $this->rh_model->traerEmpleados($user['usuarioID']);
		
		$this->layouts->profile('rh-view', $op);
	}
	
	public function test(){
		
		
	}
	
	function editUser($userID){
		
		
		
	}
	
}