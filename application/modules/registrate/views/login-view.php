<section id="regFormWhite">
<div class="msg">
	<h1 class="fOne">Bienvenido crea tu cuenta con nosotros.</h1>
	<p>Si aun no cuentas con una cuenta,  <a class="sans fOne" title="Registrate aquí" href="<?=base_url()?>registrate">Registrate ahora!</a></p>
</div>
<form id="loginForm" action="<?=base_url()?>" method="post">
  <span><div class="msgBlack"></div></span>
  <fieldset class="bbW">
    <label>User or Email</label>
	<input class="sans inBut" type="text" name="var" placeholder="Username or email" />
  </fieldset>
  <fieldset class="bbW">
    <label>Password</label>
	<input class="sans inBut" type="password" name="password" placeholder="Password" />
	<a id="forgot" href="<?=base_url()?>forgotpassword">Forgot your password?</a>
  </fieldset>
  <fieldset class="mt20">
	  <input id="cLog" class="sans bYel" type="submit" value="Entrar" />
  </fieldset>
  <fieldset>
	  <em id="or">o</em>
  </fieldset>
  <fieldset>
	  <input id="faceButton" class="sans" type="text" value="Conectate con Facebook"/>
  </fieldset>
  <fieldset class="mt10">
	  <i class="sans fOne">Al dar click en el boton entrar confirmas que aceptas nuestros</i><a class="sans fOne" href="<?=base_url()?>">Terminos  de Servicio</a>
  </fieldset>
</form>
</section>