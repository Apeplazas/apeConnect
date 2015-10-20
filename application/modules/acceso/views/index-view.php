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
<link href='https://fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet' type='text/css'>
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
			<span>
      	<h1>Administración <br>de Plazas Especializadas</h1>
				<p>El trabajo en equipo comienza construyendo confianza</p>
			</span>
      <form  id="loginForm"  method="post">
				<span><div class="msgBlack"></div></span>
        <p>
					<label>Correo Electronico</label>
					<input class="inpLog" type="text" name="var" value="" placeholder="Escribe tu email"></p>
        <p>
					<label>Contraseña</label>
					<input class="inpLog" type="password" name="password" value="" placeholder="Password">
				</p>
        <p class="submit"><input type="submit" name="commit" value="Entrar"></p>
      </form>
    </div>

    <div class="login-help">
      <p id="mesLog">¿Olvidaste tu contraseña? <a href="<?=base_url()?>l">Click aquí</a>.</p>
    </div>
</section>







<br class="clear">
</body>
</html>
