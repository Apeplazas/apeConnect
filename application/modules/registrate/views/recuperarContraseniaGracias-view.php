<? $opt = $this->uri->segment(1);?>
<? $op = $this->data_model->cargarOptimizacion($opt);?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<script> 
	var ajax_url = "<?= BASEURL;?>ajax/"; 
	var base_url = "<?= BASEURL;?>";
</script>

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
	    <div class="login1">
			<span>
		      	<h1>Administración <br>de Plazas Especializadas</h1>
						<p>En breve te llegara un link en tu correo</p>
					</span>
		      <form  id="loginForm"  method="post">
						<div><div class="msgBlack"></div></div>
		        <p>
							<label style="text-align: center;">Gracias!</label>							
						</p>
			    </div>
	</section>
</body>
</html>
