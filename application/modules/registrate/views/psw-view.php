<? $opt = $this->uri->segment(1);?>
<? $op = $this->data_model->cargarOptimizacion($opt);?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">
<meta name="robots" content="All,index, follow" />
<link href='https://fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet' type='text/css'>
<link type="text/css" href="<?=base_url()?>assets/css/style.css" rel="stylesheet"/>
<script language="javascript" src="<?=base_url()?>assets/js/jquery-1.9.1.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url()?>assets/js/functions.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url()?>assets/js/modernizr.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url()?>assets/js/jquery.ddslick.min.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url()?>assets/js/jquery.cookie.js" type="text/javascript"></script>

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
      <form  action="<?= base_url(); ?>registrate/pwd" id="loginForm"  method="post">
				<div><div class="msgBlack"><?= $this->session->flashdata('login_error'); ?></div></div>
        <p>
					<label>Nueva contraseña</label>
					<input class="inpLog" type="password" name="password" value="" placeholder=""></p>
        <p>
					<label>Confirmar contraseña</label>
					<input class="inpLog" type="password" name="password1" value="" placeholder="">
				</p>
				<input type="hidden" value="<?= $this->uri->segment(3); ?>" name="hash">
        <p class="submit"><input type="submit" name="commit" value="Recuperar"></p>
      </form>
    </div>
</section>







<br class="clear">
</body>
</html>