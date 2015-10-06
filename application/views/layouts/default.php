<? $opt = $this->uri->segment(1);?>
<? $op = $this->data_model->cargarOptimizacion($opt);?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<? foreach($tags as $rowOpt):?>
<title><?= $rowOpt->enlaceTitulo;?></title>
<meta name="description" content="<?=$rowOpt->enlaceDescripcion;?>" />
<? endforeach; ?>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">
<meta name="robots" content="All,index, follow" />
<link type="text/css" href="<?=base_url()?>assets/css/style.css" rel="stylesheet"/>
<script language="javascript" src="<?=base_url()?>assets/js/jquery-1.9.1.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url()?>assets/js/functions.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url()?>assets/js/modernizr.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url()?>assets/js/jquery.ddslick.min.js" type="text/javascript"></script>
<?= $this->layouts->print_includes(); ?>
<link rel="icon" type="image/png" href="<?=base_url()?>assets/graphics/test.ico" />
</head>
<body class="bckReg">
<header id="mainHead">
	<a id="logo" href="<?=base_url()?>"><img src="<?=base_url()?>assets/graphics/apelogo.png" alt="Ape Logo" /></a>
	<ul id="topMenu">
		<li><a class="botClean" href="<?=base_url()?>"><img src="<?=base_url()?>assets/graphics/iniciar-sesion.png" alt="Entrar" /><em>Entrar</em></a></li>
		<li class="botOraTwo"><a href="<?=base_url()?>registrate">Registrate</a></li>
	</ul>
</header>
<div id="content">
<?= $content; ?>
</div>
<br class="clear">
</body>
</html>
