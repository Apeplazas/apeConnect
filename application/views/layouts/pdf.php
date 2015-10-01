<? $opt = $this->uri->segment(1);?>
<? $op = $this->data_model->cargarOptimizacion($opt);?>
<? $user =	$this->session->userdata('usuario'); ?>
<!-- Sesion de Cotizaciones -->
<? $cotizacion = $this->session->userdata('cotizacion');?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? foreach($op as $rowOpt):?>
<meta name="description" content="<?=$rowOpt->enlaceDescripcion;?>" />
<title><?=$rowOpt->enlaceTitulo;;?></title>
<? endforeach; ?>
<meta name="robots" content="All,index, follow" />
<!-- Google Fonts embed code -->
<script type="text/javascript">
	(function() {
	var link_element = document.createElement("link"),
    s = document.getElementsByTagName("script")[0];
	if (window.location.protocol !== "http:" && window.location.protocol !== "https:") {
    	link_element.href = "http:";
    }
    link_element.href += "//fonts.googleapis.com/css?family=Roboto+Condensed:300italic,300,400italic,400,700italic,700";
    link_element.rel = "stylesheet";
    link_element.type = "text/css";
    s.parentNode.insertBefore(link_element, s);
})();
</script>
<script language="javascript" src="<?=base_url()?>assets/js/jquery-1.8.3.min.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url()?>assets/js/modernizr.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url()?>assets/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url()?>assets/js/functions.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url()?>assets/js/jquery.remodal.js" type="text/javascript"></script>
<link type="text/css" href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet"/>
<link type="text/css" href="<?=base_url()?>assets/css/style.css" rel="stylesheet"/>
<link type="text/css" href="<?=base_url()?>assets/css/tables.css" rel="stylesheet"/>
<link type="text/css" href="<?=base_url()?>assets/css/jquery.remodal.css" rel="stylesheet"/>
<style>
	html{
		background-color: #555;
	}
</style>
<meta name="viewport" content="width=device-width, initial-scale=0, user-scalable=no, minimum-scale=1.0, maximum-scale=0">
<?= $this->layouts->print_includes(); ?>
<link rel="icon" type="image/png" href="<?=base_url()?>assets/graphics/favicon.png" />
<script> var ajax_url = "http://www.apeplazas.com/apeConnect/ajax/"; </script>
<? if($this->uri->segment(2) == 'finalizarCotizacion'):?>
 <style type="text/css">html{background-color:#555}</style> 
<?endif?>
</head>

<body>
<header>
<div class="f100 blue nav">
<nav>
<a id="dash" href="<?=base_url()?>" title="Inicio"><img src="<?=base_url()?>assets/graphics/inicio.png" alt="Dashboard" /></a>
<? $this->load->view('includes/menus/barV2');?>	
	<ul id="preferences">
		<li class="prel">
		  <a class="cheers" id="options">Hola <?=$user['nombre'];?><i id="triangle"></i></a>
		  <div id="popupPref">
			  <ul>
				  <li class="prel"><span id="señal"><img src="<?=base_url()?>assets/graphics/mark.png" alt="Señalizacion" /></span><a href="<?=base_url()?>">Mis Preferencias</a></li>
				  <li><a href="<?=base_url()?>registrate/salir">Salir</a></li>
			  </ul>
          </div>
        </li>
	</ul>
	<ul id="settings">
		<?php $no_not = $this->user_model->numero_mensajes($user['usuarioID']);?>
		<li id="notifBar"><a href="<?=base_url()?>notificaciones"><img src="<?=base_url()?>assets/graphics/inbox.png" alt="Inbox" /><?php if($no_not > 0):?><i id="solicitud"><?=$no_not;?></i><?php endif;?></a></li>
		<?php if(isset($user['modulos']) && in_array('settings', $user['modulos'])):?>
		<li><a href="<?=base_url()?>settings"><img src="<?=base_url()?>assets/graphics/setting.png" alt="Configuracion" /></a></li>
		<?php endif;?>
	</ul>
</nav>

<section id="headBus" class="f100">
<img id="logoHeader" src="<?=base_url()?>assets/graphics/apeplazas.png" alt="Administradora de Plazas Especializadas" />
<form id="search" action="">
<span>Busqueda Avanzada: </span>
	<fieldset>
		<input type="text" id="avanz" placeholder="Escribe la palabra y presiona Enter"/>
	</fieldset>
	<fieldset class="go">
		<input id="searchGo" type="img" src="<?=base_url()?>assets/graphics/search.png"/>
	</fieldset>
</form>
<div id="wrapPlus" class="prel">
<button id="add"><img src="<?=base_url()?>assets/graphics/add.png" alt="Agregar" /></button>
	<div id="popupQuick">
	<strong>Creación rapida</strong>
	<ul>
	  <li class="prel"><span><img src="<?=base_url()?>assets/graphics/mark.png" alt="Señalizacion" /></span></li>
	  <li><a href="<?=base_url()?>prospectos/agregar">Agregar Prospectos</a></li>
	  <li><a href="<?=base_url()?>">Contactos</a></li>
	  <li><a href="<?=base_url()?>">Prospectos</a></li>
	</ul>
    </div>
</div>
</section>
</div>
</header>








<!-- Comienza contenedor -->
<section id="mainContainer">
<br class="clear">

<!-- Ventana derecha -->
<? if($this->uri->segment(2) != 'finalizarCotizacion'):?>
<?= $this->load->view('includes/windows/rightWindow');?>
<?endif?>

<div id="adjustWrapBlack">
	<section id="content" class="open">
	<div id="wrapAll" class="wrapClose">
	<?= $content; ?>
	</div>
	<br class="clear">
	</section>
</div>

</section>



<footer>Powered by APE Plazas CRM Mexico © www.apeplazas.com 1.0.0  © 2015 apeconnect</footer>
<br class="clear"/>
</div>

<script>
    window.remodalGlobals = {
        namespace: "modal",
        defaults: {
            hashTracking: false
        }
    };
</script>

</body>
</html>



