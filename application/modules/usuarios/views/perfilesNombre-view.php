<h3 id="mainTit">Datos del usuario</h3>
<div class="wrapList">

	<div id="wrapDatos">
		<? foreach($profile as $row):?>
		<ul>
			<li><span>Nombre Completo:</span> <em><?= $row->nombreCompleto?></em></li>
			<li><span>Email:</span><em><?= $row->email?></em></li>
			<li><span>Puesto:</span><em><?= $row->puesto?></em></li>
			<li><span>Area:</span><em><?= $row->area?></em></li>
			<li>
				<span>Contraseña:</span>
				<div>
					 <form  name="mi_formulario" id= "loginForm" onSubmit="return validarPasswd()" action="<?=base_url()?>" method="post">
					   <input type="button" name="RecuperarCont"  value="Cambiar contraseña" onclick="mostrar()" >
					     <div id='oculto' style="display: none;">
						  <fieldset class="bbW">
					 	<label>Nueva contraseña</label>
					    <input class="sans inBut" type="password" name="password" placeholder="Password"/>
					    <a id="forgot" href="<?=base_url()?>forgotpassword"></a>
					    </fieldset>
					    <fieldset class="bbw">
					    <label>Confirmar contraseña</label>
					    <input class="sans inBut" type="password" name="password1" placeholder="Password"/>
					    <a id="forgot" href="<?=base_url()?>forgotpassword"></a>
					    </fieldset>
					    <fieldset>
					    <fieldset class="mt20">
						<button  name="cLog" id="cLog" class="alert-box warning" type="submit" value="" onclick=comprobarClave()>Cambiar Contraseña</button>
					  </fieldset>
					  <div class="alert-div">Tu contraseña ha sido cambiado</div>
					  <div class="alert-div1">Tu contraseña no son las misma</div>
					  <div class="alert-div2">Tu contraseña no puede ser 12345</div>
					  <div class="alert-div3">Los campos no deben de estar vacios</div>
					</div>
					</form>
				</div>
			</li>
		</ul>
		
		<? endforeach; ?>
		<br class="clear">
	</div>
<br class="clear"><br><br><br><br><br><br><br><br>
<style>
.alert-div {
    width: 500px;
    display:none;
    background-color: #ff9999;
    text-align: center;
    border-radius: 5px;
    margin-bottom: 20px;
    padding: 20px;
}
.alert-div1 {
    width: 500px;
    display:none;
    background-color: #ff9999;
    text-align: center;
    border-radius: 5px;
    margin-bottom: 20px;
    padding: 20px;
}
.alert-div2 {
    width: 500px;
    display:none;
    background-color: #ff9999;
    text-align: center;
    border-radius: 5px;
    margin-bottom: 20px;
    padding: 20px;
}
.alert-div3 {
    width: 500px;
    display:none;
    background-color: #ff9999;
    text-align: center;
    border-radius: 5px;
    margin-bottom: 20px;
    padding: 20px;
}
 </style>
<script type="text/javascript">
	function mostrar(){
		$('#oculto').toggle();
	}

	$("button").click(function () {
			});

 $(document).on('click','#cLog',function(e) {
 	e.preventDefault();
  var data = $("#loginForm").serialize();
  pass1 = document.mi_formulario.password.value
  pass2 = document.mi_formulario.password1.value


if (pass1 == pass2 && pass1 != 12345 && pass1 !='') {
	 $.ajax({
         data: data,
         type: "post",
         url:base_url + "usuarios/inserEmail",
         success: function(data){
         }
});
	 $("div.alert-div").fadeIn(300).delay(2000).fadeOut(400);


	}else if(pass1 == 12345){
         $("div.alert-div2").fadeIn(300).delay(2000).fadeOut(400);

	}if (pass1 ==''){
     	$("div.alert-div3").fadeIn(300).delay(2000).fadeOut(400);
     }
	else{
    $("div.alert-div1").fadeIn(300).delay(2000).fadeOut(400);

   	}


 });

</script>
