<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends MX_Controller
{
	
	public function __construct(){
		
		parent::__construct();
		$this->user_model->checkuser();
		$this->load->model('settings_model');
		$this->load->model('registrate_model');
		
		
		
	}
	
	function index(){
		$user = $this->session->userdata('usuario');
		$today = date('Y-m-d');
		if($this->uri->segment(1) =='settings'){ ?>
			<script src="<?php echo base_url(); ?>assets/js/jquery-1.9.1.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
			<script type="text/javascript">
					
					$(document).ready(function() {
						var usuarioID	= '<?= $user['usuarioID']?>';
						var fechaAcceso = '<?= $today ?>';
						var modulo = 'settings';
						
						$.post('<?=base_url()?>ajax/cuentaEntradaModulos',{
										usuarioID : usuarioID,
										fechaAcceso : fechaAcceso,
										modulo : modulo
						},'json');
					});
					
			</script>
		<? }
		
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