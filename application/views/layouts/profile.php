
<? $opt = $this->uri->segment(1);?>
<? $op = $this->data_model->cargarOptimizacion($opt);?>
<? $user =	$this->session->userdata('usuario'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? foreach($op as $rowOpt):?>
<meta name="description" content="<?=$rowOpt->enlaceDescripcion;?>" />
<meta name="viewport" content="width=device-width, initial-scale=0, user-scalable=no, minimum-scale=1.0, maximum-scale=0">
<title><?=$rowOpt->enlaceTitulo;;?></title>
<? endforeach; ?>
<meta name="robots" content="All,index, follow" />
<link href='https://fonts.googleapis.com/css?family=Lato:700,300,400' rel='stylesheet' type='text/css'>
<script>
	var ajax_url = "<?= BASEURL;?>ajax/";
	var base_url = "<?= BASEURL;?>";
</script>
<script language="javascript" src="<?=base_url()?>assets/js/jquery-1.8.3.min.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url()?>assets/js/modernizr.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url()?>assets/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url()?>assets/js/functions.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url()?>assets/js/jquery.remodal.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url()?>assets/js/jquery.cookie.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url()?>assets/js/loadImg.js" type="text/javascript"></script>
<link type="text/css" href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet"/>
<link type="text/css" href="<?=base_url()?>assets/css/style.css" rel="stylesheet"/>
<link type="text/css" href="<?=base_url()?>assets/css/tables.css" rel="stylesheet"/>
<link type="text/css" href="<?=base_url()?>assets/css/jquery.remodal.css" rel="stylesheet"/>
<meta name="viewport" content="width=device-width, initial-scale=0, user-scalable=no, minimum-scale=1.0, maximum-scale=0">
<?= $this->layouts->print_includes(); ?>
<link rel="icon" type="image/png" href="<?=base_url()?>assets/graphics/favicon.png" />
<? if($this->uri->segment(2) == 'finalizarCotizacion'):?>
 <style type="text/css">html{background-color:#555}</style>
<?endif?>
</head>

<body id="bckWhite" class="<? if ($this->uri->segment(1) == 'planogramas' && $this->uri->segment(2) != ''):?>ohid<?endif;?>">
	<script type="text/javascript">
	$(window).load(function() {
		// Loading de la pagina
		$(".se-pre-con").fadeOut("slow");;
	});
	</script>
<div class="se-pre-con"></div>
<header>
<img id="logoHeader" src="<?=base_url()?>assets/graphics/apeplazas.png" alt="Administradora de Plazas Especializadas" />
<nav>
	<button id="panelRight" class="panelLeft">Abrir</button>
	<ul id="preferences">
		<li class="prel">
		  <a class="cheers" id="options">
        <span class="proImg"><img alt="Perfil" src="<?=base_url()?>assets/graphics/svg/profile.svg" alt="" /></span>
        <i id="triangle"><?=$user['nombre'];?></i></a>
		  <div id="popupPref">
			  <ul>
				  <li class="prel"><span id="senial"><img src="<?=base_url()?>assets/graphics/mark.png" alt="Señalizacion" /></span><a href="<?=base_url()?>">Mis Preferencias</a></li>
				  <li><a href="<?=base_url()?>registrate/salir">Salir</a></li>
			  </ul>
          </div>
        </li>
	</ul>
  <?php if(isset($user['modulos']) && in_array('settings', $user['modulos'])):?>
  <ul id="obPref">
    <li id="sets">
      <a href="<?=base_url()?>settings"><img src="<?=base_url()?>assets/graphics/svg/sets.svg" alt="Configuracion" />
      <span>Ajustes</span>
      </a>
    </li>
  </ul>
  <?php endif;?>
	<ul id="settings">
		<?php $no_not = $this->user_model->numero_mensajes($user['usuarioID']);?>
		<li id="notifBar">
      <a href="<?=base_url()?>notificaciones"><img src="<?=base_url()?>assets/graphics/svg/mensajes.svg" alt="Inbox" />
        <span>Mensajes</span>
        <?php if($no_not > 0):?><i id="solicitud"><?=$no_not;?></i><?php endif;?>
      </a>
      </li>
	</ul>

  <div id="wrapPlus" class="prel">
  <button id="add"><img src="<?=base_url()?>assets/graphics/svg/add.svg" alt="Agregar" />
    <span>Creación Rapida</span>
  </button>
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
</nav>
</header>







<br class="clear">
<!-- Comienza contenedor -->
<section id="mainContainer">


<!-- Ventana derecha -->
<? if($this->uri->segment(2) != 'finalizarCotizacion'):?>
<?= $this->load->view('includes/windows/rightWindow');?>
<?endif?>

<div id="adjustWrap<?if($this->uri->segment(2)== 'finalizarCotizacion'):?>Black<?endif?>">
<section id="content" class="open">


	<div id="bar" class="">
	<nav id="navMenu" class="prel">
	<div id="butImg" >
    <button class="arrowLeft">Cerrar</button>
    <img id="logoSmall" class="none" src="<?=base_url()?>assets/graphics/apeplazas.png" alt="Administradora de Plazas Especializadas" />
  </div>
  <h1><?= ucfirst($this->uri->segment(1));?></h1>
	<ul id="padMenu">
		<?
		//Temporal para usuarios de recibos internos y cartas de intencion
		if($user['tipoUsuario'] != "Gerente Plaza"):?>
		<li class="main <?if($this->uri->segment(1) == 'admin'):?>bckMark<?endif?>">
     		<a href="<?=base_url()?>" title="Dashboard">
	        	<img class="svgIcon" alt="Dashboard" src="<?=base_url()?>assets/graphics/svg/dashboardTwo.svg" />
	        	<em>Dashboard</em>
      		</a>
    	</li>
    	<? endif; ?>
		<? $this->load->view('includes/menus/barV3');?>
	</ul>



	</nav>
</div>


	<div id="wrapAll" class="">
	<?= $content; ?>
	</div>
	<br class="clear">
</section>
</div>

</section>

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
