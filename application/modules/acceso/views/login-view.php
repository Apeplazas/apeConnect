<section id="regFormWhite">
<form id="loginForm" action="<?=base_url()?>" method="post">
  <div id="bckWhite">
  <div class="msg">
	<h1 class="fOne">Bienvenido.</h1>
	<p>No cuentas con una cuenta,  <a class="sans fOne" title="Registrate aquí" href="<?=base_url()?>registrate">Registrate ahora!</a></p>
  </div>
  <span><div class="msgBlack"></div></span>
  <fieldset class="bbW">
    <label>Usuario or Email</label>
	<input class="sans inBut" type="text" name="var" placeholder="Username or email" />
  </fieldset>
  <fieldset class="bbW">
    <label>Contraseña</label>
	<input class="sans inBut" type="password" name="password" placeholder="Password" />
	<a id="forgot" href="<?=base_url()?>forgotpassword">¿Olvidaste tu contraseña?</a>
  </fieldset>
  <fieldset class="mt10">
	  <i class="sans fOne">Al dar click en el boton entrar confirmas que aceptas nuestros<a class="sans fOne" href="<?=base_url()?>"> Términos de Servicio</a></i>
  </fieldset>
  <fieldset class="mt20">
	  <input id="cLog" class="sans bBlue" type="submit" value="Entrar" />
  </fieldset>
  </div>
</form>
</section>