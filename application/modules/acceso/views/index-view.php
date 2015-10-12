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
<script language="javascript" src="<?=base_url()?>assets/js/jquery.cookie.js" type="text/javascript"></script>
<?= $this->layouts->print_includes(); ?>
<link rel="icon" type="image/png" href="<?=base_url()?>assets/graphics/test.ico" />
</head>
<body class="bckIndex">


<section class="conLog">
	<span></span>
    <div class="login">
      <h1>Administración de Plazas Especializadas</h1>
      <form  id="loginForm"  method="post">
        <p><input type="text" name="var" value="" placeholder="Username or Email"></p>
        <p><input type="password" name="password" value="" placeholder="Password"></p>

        <p class="submit"><input type="submit" name="commit" value="Entrar"></p>
      </form>
    </div>

    <div class="login-help">
      <p>¿Olvidaste tu contraseña? <a href="<?=base_url()?>l">Click aquí</a>.</p>
    </div>
</section>







<br class="clear">
</body>
</html>
