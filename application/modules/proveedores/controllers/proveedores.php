<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proveedores extends MX_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->user_model->checkuser();
		$this->load->model('admin_model');
		$this->load->model('user_model');
		$this->load->model('proyectos/proyecto_model');
		
		
		
	}	
    
	function index()
	{
		
		
		//Carga el javascript y CSS //
		$this->layouts->add_include('assets/js/jquery-ui.js')
					  ->add_include('assets/js/jquery.autocomplete.pack.js')
					  ->add_include('assets/js/jquery.dataTables.min.js');
					  
		//Informacion perfil general//
		$user         = $this->session->userdata('usuario');
		$user_type    = strtoupper($user['tipoUsuario']);
		
		$op['profile']		= $info = $this->user_model->traeadmin($user['usuarioID']);
		$op['proveedores']	= $this->user_model->traeproveedores();
		
		
		$today = date('Y-m-d');
		if($this->uri->segment(1) =='proveedores'){ ?>
			<script src="<?php echo base_url(); ?>assets/js/jquery-1.9.1.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
			<script type="text/javascript">
					
					$(document).ready(function() {
						var usuarioID	= '<?= $user['usuarioID']?>';
						var fechaAcceso = '<?= $today ?>';
						var modulo = 'proveedores';
						
						$.post('<?=base_url()?>ajax/cuentaEntradaModulos',{
										usuarioID : usuarioID,
										fechaAcceso : fechaAcceso,
										modulo : modulo
						},'json');
					});
					
			</script>
		<? }
		
		$this->layouts->profile('proveedores-view', $op);
	}	
}

