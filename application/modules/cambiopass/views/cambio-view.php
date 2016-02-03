<? $user	= $this->session->userdata('usuario');?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap-responsive.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/style.css">

<meta charset="UTF-8">
 <div class="container">
 	<div class="row">
 		<br />
 	</div>
 	<div class="row">
 		<br />
 	</div>
 	<?php if(isset($error)):?>
 		<div class="alert-warning">
 			<p><?php echo $error;?></p>
 		</div>
 	<?php endif;?>
        <div class="row">
            <div id="cambiopass">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                    	<center><h2 class="panel-title">ADMINISTRACIÓN DE PLAZAS ESPECIALIZADAS</h2></center>
                    	<br />
                        <h3 class="panel-title">Cambio de contraseña</h3>
                        <br />
                		<p class="">Elige una contraseña nueva para tu proximo inicio de sesion</p>
                    </div>
                    <div class="panel-body">
                        <form name="cambiopass" action="<?=base_url()?>cambiopass/cambia" method="post" role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Contraseña nueva" name="pass1" type="password" autofocus required="required">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Introduce de nuevo la contraseña nueva" name="pass2" type="password" value="" required="required">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="hidden" name="email" value="<?=$user['email'];?>">
                                <input type="hidden" name="link" value="<?=$user['link'];?>">
                                <button type="submit" class="btn btn-lg btn-success btn-block">Cambiar Contraseña!</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?$this->session->sess_destroy();?>
<script>
$(document).keydown(function(e) {
var element = e.target.nodeName.toLowerCase();
if (element != 'input' && element != 'textarea') {
    if (e.keyCode === 8) {
        return false;
    }
}
});
</script>
<script Language="JavaScript">
if(history.forward(1)){
history.replace(history.forward(1));
}
</script>
