<?php 
$gComp       = $this->input->post('gComp');
$rfc         = set_value('rfc');
$repLegal    = set_value('repLegal');
$emailLegal  = set_value('emailLegal');
$rTipo       = set_value('rTipo');
$name        = set_value('admName');
$admTel      = set_value('admTel');
$email       = set_value('admEma');
$telefono    = set_value('admTel');
$direccion   = set_value('dirFis');
$password    = set_value('password');
$estComp     = set_value('estComp');
$dirComp     = set_value('dirComp');
$cpComp      = set_value('cpComp');
$admNic      = set_value('admNic');
$cpFis       = set_value('cpFis');
$dirFis      = set_value('dirFis'); 
$estados_user      = $this->input->post('estado');
?>
<div id="regForm">
<div class="msg">
	<h1 class="fOne">Bienvenido registrate con nosotros.</h1>
	<p>Ya te encuentras registrado con nosotros y te gustaria participar en nuestros proyectos y licitaciones <a href="<?=base_url()?>acceso" title="Accesa a tu cuenta aquí">Accésa aquí.</a></p>
</div>
<form action="<?=base_url()?>registrate/guardarRegistro" method="post" enctype="multipart/form-data" >
<span><?= $this->session->flashdata('mail'); ?></span>
<span><?= $this->session->flashdata('vanityUrl'); ?></span>
    <legend>Giros de tu Compañia en los que pudieras participar en nuestras licitaciones.</legend>
    <fieldset id="estPart">
    	<?= form_error('gComp'); ?>
		<? foreach($tipos as $rowTip):?>
		    <span>
		    	<input type="checkbox" name="gComp[<?= $rowTip->idTipo;?>]" value="<?= $rowTip->tipo;?>" <?php if(isset($gComp[$rowTip->idTipo])) echo "checked";?>/>
				<i><?= $rowTip->tipo;?></i>
			</span>
		<? endforeach; ?>
  </fieldset>
  <legend>Información de Cuenta</legend>
  <fieldset class="bbW">
    <label>Tu nombre</label>
    <?= form_error('name'); ?>
	<input class="inBut" type="text" name="admName" value="<?= $name;?>" placeholder="<? if (empty($name)):?>Nombre del Administrador de la Cuenta.<? else:?><?= $name?><? endif;?>" />
  </fieldset>
   <fieldset class="bbW">
    <label>*Telefono</label>
    <?= form_error('admTel'); ?>
    <input id="tel" onkeyup="this.value=this.value.replace(/[^-\d∂,.]/,'')" class="inBut" type="text" name="admTel" value="<?= $admTel;?>" placeholder="<? if (empty($admTel)):?>Ejemplo: 5555-07-62<? else:?><?= $admTel?><? endif;?>" />
  </fieldset>
   <fieldset class="bbW">
    <label>Celular</label>
    <input id="tel" onkeyup="this.value=this.value.replace(/[^-\d∂,.]/,'')" class="inBut" type="text" name="admCel" value="" placeholder="Ejemplo: 04455-5588-0762" />
  </fieldset>
  <fieldset class="bbW mt20">
	<label>Usuario o Marca</label>
	<?= form_error('admNic'); ?>
	<i id="url"><?=base_url()?>tumarca</i>
    <input class="inBut mb20" onkeydown='onlytext(this);' type="text" value="<?= $admNic;?>" name="admNic" placeholder="<? if (empty($admNic)):?>Marca o Alias<? else:?><?= $admNic?><? endif;?>" />
    <em>Este nombre te servira para identificarte con nosotros y acceder a nuestro sistema.</em>
  </fieldset>
  <fieldset class="bbW">
	<label>Correo electronico</label>
	<?= form_error('admName'); ?>
	<i id="ajaxEma"></i>
    <input id="emaCheck" class="inBut" type="text" name="admEma" value="<?= $email;?>" placeholder="<? if (empty($email)):?>ejemplo@gmail.com<? else:?><?= set_value('email'); ?><? endif;?>" />
  </fieldset>
  <fieldset class="bbW">
    <label>Escoge una contraseña</label>
    <?= form_error('password'); ?>
	<input class="inBut" type="password" name="password" value="<?= $password;?>" placeholder="<? if (empty($password)):?>Contraseña<? else:?><?= $password?><? endif;?>" />
  </fieldset>
  <legend>Selecciona los estados en los que puedes realizar proyectos</legend>
  <fieldset id="estPart">
  <?= form_error('estado'); ?>
  <? foreach($estados as $estadosRow):?>
  <span><input type="checkbox" name="estado[<?= $estadosRow->idEstado?>]" value="<?= $estadosRow->nombreEstado?>" <?php if(isset($estados_user[$estadosRow->idEstado])) echo "checked";?>/>
  <i><?= $estadosRow->nombreEstado?></i>
  </span>
  <? endforeach;?>
  </fieldset>
  <legend>Información de la Empresa</legend>
  <fieldset class="bbW">
    <label>Razon Social  o Nombre</label>
    <?= form_error('rfc'); ?>
	<input class="inBut" type="text" name="rfc" value="<?= $rfc;?>" placeholder="<? if (empty($rfc)):?>Ejemplo: Comercio S.A de C.V.<? else:?><?=$rfc ?><? endif;?>" />
  </fieldset>
  <fieldset>
	  <label>Representante Legal</label>
	  <?= form_error('repLegal'); ?>
	  <input type="text" name="repLegal" class="inBut" value="<?= $repLegal;?>" placeholder="<? if (empty($repLegal)):?>Ejemplo: Juan Manuel Prieto<? else:?><?= $repLegal?><? endif;?>" />
  </fieldset>
  <fieldset class="bbW">
    <label class="mediumTitle">Tipo de Registro en Hacienda</label>
    <?= form_error('rTipo'); ?>
    <span class="typPer"><input id="fisica" value="fisica" <? if ($rTipo == 'fisica'):?>checked<? endif;?> type="radio" name="rTipo" /> Persona Fisica </span>
    <span class="typPer"><input id="moral" value="moral" <? if ($rTipo == 'moral'):?>checked<? endif;?> type="radio" name="rTipo"/> Persona Moral </span>
  </fieldset>
  <fieldset class="estad">
  	<label>Pais, Municipio y Colonia</label>
	<select  id="estadoDir" required="required" name="estComp" class="selReg required valid" required="required">
		<option value="">Elige tu estado</option>
	<? foreach($estados as $estadosRow):?>
		<option value="<?= $estadosRow->idEstado?>"><?= $estadosRow->nombreEstado?></option>
	<? endforeach;?>
	</select>
	<select id="municipioDir" name="delComp" required="required" class="selReg">
		<option value="0">Elige tu Municipio</option>
	</select>
	  <select id="coloniaDir" name="colComp" required="required" class="selReg">
		<option value="0">Elige tu Colonia</option>
      </select>
  </fieldset>
  <fieldset>
    <label>Tu Codigo Postal es:</label>
    <?= form_error('cpComp'); ?>
    <input type="text" class="inSmall" id="cpDir" readonly name="cpComp" required="required" value="<?= $cpComp;?>"  placeholder="<? if (empty($cpComp)):?>C.P.<? else:?><?= $cpComp?><? endif;?>"/> 
  </fieldset>
  <fieldset class="bbW">
    <label>Calle y Numero Exterior</label>
    <?= form_error('dirComp'); ?>
    <input class="inBut" type="text" name="dirComp" value="<?= $dirComp;?>"  placeholder="<? if (empty($dirComp)):?>Calle y numero exterior<? else:?><?= $dirComp?><? endif;?>"/>
  </fieldset>
  <div id="loading"></div>
  <fieldset  id="aqui"></fieldset>
  <fieldset id="terms">
	  <em class="mt10">Al dar click y registrarse con nosotros, usted acepta nuestros<a class="mark" href="<?=base_url()?>">Terminos y Condiciones</a> y notifica haber leido nuestros nuestra <a class="mark" href="<?=base_url()?>">Politica de de uso de datos</a>.</em>
  </fieldset>
  <fieldset>
	  <input id="cCuent" class="mt20 redBotonForm fleft" type="submit" value="Crear cuenta" />
  </fieldset>
</form>
</div>
<script>
function onlytext(box){
regexp = /\W/g;
 if(box.value.search(regexp) >= 0){
 box.value = box.value.replace(regexp, '');
 }
}
</script>	   
<script type="text/javascript">
function swap(one, two) {
    document.getElementById(one).style.display = 'block';
    document.getElementById(two).style.display = 'none';
}
document.getElementById('fisica').addEventListener('click',function(e){
    swap('one','two');
});
document.getElementById('moral').addEventListener('click',function(e){
    swap('two','one');
});
</script>
<script type="text/javascript" charset="utf-8">
$('#fisica').click(function (event) {
    var $form = $(this),
        url = ('registrate/formFisica');
    var posting = $.post(url);
    posting.done(function (data) {
        var content = (data);
        $('#aqui').empty().append(content);
    });
});
$('#moral').click(function (event) {
    var $form = $(this),
        url = ('registrate/formMoral');
    var posting = $.post(url);
    posting.done(function (data) {
        var content = (data);
        $('#aqui').empty().append(content);
    });
});
</script>
<script type="text/javascript">
// Busca municipios por estado
$(document).ready(function(){
	//Para cargar los municipios
	$("#estadoDir").change(function(){
		var estadoFiltro = $(this).val();
		$("#municipioDir").removeAttr("disabled");
		$.post("<?=base_url()?>ajax/cargarMunicipios",{estadoFiltro:estadoFiltro},function(data){
			sucess:				
				$("#municipioDir").empty().append(data);
				$("#municipioDir").removeAttr("disabled");
		});
	});
	$("#estadoDirTwo").change(function(){
		var estadoFiltro = $(this).val();
		$("#municipioDirTwo").removeAttr("disabled");
		$.post("<?=base_url()?>ajax/cargarMunicipios",{estadoFiltro:estadoFiltro},function(data){
			sucess:				
				$("#municipioDirTwo").empty().append(data);
				$("#municipioDirTwo").removeAttr("disabled");
		});
	});
	//Para cargar las colonias
	$("#municipioDir").change(function(){
		var estadoFiltro = $("#estadoDir").val();
		var municipioFiltro = $(this).val();
		$("#coloniaDir").removeAttr("disabled");
		$.post("<?=base_url()?>ajax/cargarColonias",{municipioFiltro:municipioFiltro,estadoFiltro:estadoFiltro},function(data){
			sucess:				
				$("#coloniaDir").empty().append(data);
				$("#coloniaDir").removeAttr("disabled");
		});
	});
	//Para cargar las colonias
	$("#municipioDirTwo").change(function(){
		var estadoFiltro = $("#estadoDirTwo").val();
		var municipioFiltro = $(this).val();
		$("#coloniaDirTwo").removeAttr("disabled");
		$.post("<?=base_url()?>ajax/cargarColonias",{municipioFiltro:municipioFiltro,estadoFiltro:estadoFiltro},function(data){
			sucess:				
				$("#coloniaDirTwo").empty().append(data);
				$("#coloniaDirTwo").removeAttr("disabled");
		});
	});
	//Para cargar C.P.
	$("#coloniaDir").change(function(){
		var estadoFiltro 	= $("#estadoDir").val();
		var municipioFiltro = $("#municipioDir").val();
		var coloniaFiltro 	= $(this).val();
		$("#cpDir").removeAttr("disabled");
		$.post("<?=base_url()?>ajax/cargarCP",{municipioFiltro:municipioFiltro,estadoFiltro:estadoFiltro,coloniaFiltro:coloniaFiltro},function(data){
			sucess:				
				$("#cpDir").val(data);
				$("#cpDir").removeAttr("disabled");
		});
	});
	//Para cargar C.P.
	$("#coloniaDirTwo").change(function(){
		var estadoFiltro 	= $("#estadoDirTwo").val();
		var municipioFiltro = $("#municipioDirTwo").val();
		var coloniaFiltro 	= $(this).val();
		$("#cpDirTwo").removeAttr("disabled");
		$.post("<?=base_url()?>ajax/cargarCP",{municipioFiltro:municipioFiltro,estadoFiltro:estadoFiltro,coloniaFiltro:coloniaFiltro},function(data){
			sucess:				
				$("#cpDirTwo").val(data);
				$("#cpDirTwo").removeAttr("disabled");
		});
	});
});
</script>
