<div id="mainTit">
<h3>Creacion  de usuario.</h3>
</div>

<div class="loader" style="display:none;"></div>
<div class="wrapList">
<form class="form-horizontal" method="post" id="creusu" action="<?=base_url();?>administrador/DarAlta/<?=$this->uri->segment(2);?>" enctype="multipart/form-data">
	
<div id="actions" >
<span class="back">
	<a class="addSmall" href="javascript:window.history.go(-1);">
	    <i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/back.svg" alt="Regresar"></i>
	    <span>Regresar</span>
	</a>
</span>
</div>

<div class="wrapListForm" id="wrapLiistForm1">
	<table>
		<thead>
			<tr>
				<th colspan="4">Datos Generales</th>
			</tr>
		</thead>
		<tbody>		
		<tr>
			<td class="grayField"><label>Nombre Completo</label></td>
			<td>
				<input type="text" class="bigInp blockClear" name="nombreCompleto" id="nombreCompleto" required>
			</td>
			<td class="grayField"><label>Puesto</label></td>
			<td colspan="3">
				<input type="text"   class="bigInp blockClear" name="puesto" id="puesto" required>
			</td>
		</tr>
		<tr>
			<td class="grayField"><label>Telefono</label></td>
			<td>
				<input type="text" class="bigInp soloNumeros blockClear" name="telefono" id="telefono" required>
			</td>
			<td class="grayField"><label>Celular</label></td>
			<td colspan="3">
				<input type="text" class="bigInp soloNumeros blockClear" name="celular" id="celular" required>
			</td>
		</tr>
		<tr>
			<td class="grayField"><label class="blockClear" >Email</label></td>
			<td>
				<input type="email" class="bigInp blockClear" name="email" id="email" required>
			</td>
			<td class="grayField"><label>Contraseña</label></td>
			<td colspan="3">
				 <input class="bigInp blockClear" type="contrasenia" name="contrasenia" placeholder="Password"/>
                 <a id="forgot" href="<?=base_url()?>forgotpassword"></a>
			</td>
		</tr>
		<tr>
			<td class="grayField"><label>Fecha de Alta </label></td>
			<td>
				<input name="fechaRegistro" type="text" id="fechaRegistro" placeholder="año/mes/dia" class="bigInp blockClear" required><img class="calInp" src="<?=base_url()?>assets/graphics/svg/calendario.svg" alt="Fecha Alta" />
			</td>
			<td class="grayField"><label>Registro Nuevo</label></td>
			<td colspan="3">
				<select class="selBig" name="registroNuevo" id="registroNuevo" required>
					<option value="">Seleccione una opción</option>
					<option value="si">SI</option>
					<option value="no">No</option>
				</select>
			</td>
			
		</tr>
	   <tr>
	   	<td class="grayField"><label>Plaza</label></td>
	   	<td colspan="3">
	   		<select class="selBig" name="plaza" id="plaza" required=>
	   			<option value="">Selecciona una Opcion</option>
	   			<option value="SanLuis">SAN LUIS POTOSI PM</option>
	   			<option value="TolucaCJ">TOLUCA CJ</option>
	   			<option value="Duraznos61">DURAZNOS 61 </option>
	   			<option value="Bazar">BAZAR</option>
	   			<option value="ChihuahuaPMyPT">CHIHUAHUA PM Y PT</option>
	   			<option value="CuernavacaPT">CUERNAVACA PT</option>
	   			<option value="GuadalajaraPT">GUADALAJARA PT</option>
	   			<option value="LazaroCardenasPT">LAZARO CARDENAS 38</option>
	   			<option value="LeonPT Y PM">LEON PT Y PM</option>
	   			<option value="Mexico PT">MEXICO PT</option>
	   			<option value="Monterrey  2PT">MONTERREY 2 PT</option>
	   			<option value="Pericentro">PERICENTRO</option>
	   			<option value="SanluisPT">SAN LUIS POTOSI PT</option>
                <option value="Toluca PT Y PM">TOLUCA PT Y PM</option>
                <option value="Torreon PT">TORREON PT</option>
                <option value="Uruguay17PT">URUGUAY 17 PT</option>
                <option value="Ags PT Y PM">AGS PT y PM</option>
                <option value="Sinaloa PM">SINALOA PM</option>
                <option value="Morelia PM Y PT">MORELIA PM Y PT</option>
                <option value="Puebla PM Y PT">PUEBLA PM Y PT</option>
                <option value="VillahermosaPM Y PT">VILLAHERMOSA PM Y PT</option>
                <option value="Merida PT ">MERIDA PT</option>
                <option value="PT Queretaro">PT QUERETARO</option>
                <option value="PT Guadalajara"> PT GUADALAJARA</option>
                <option value="Coacalco PT"> COACALCO PT</option>
                <option value="Tijuana PT Y PM">TIJUANA PT Y PM</option>
                <option value="Acapulco PT">ACAPULCO PT</option>
                <option value="Veracruz PT">VERACRUZ PT</option>
                <option value="Tampico PT">TAMPICO PT</option>
                <option value="PT los Reyes">PT LOS REYES</option>
                <option value="Guadalajara PT3">GUADALAJARA PT3</option>
                <option value="Cancun PT">CANCUN PT</option>
                <option value="saltillo PT">SALTILLO PT </option>
                <option value="Acapulco 2"></option>
	   		</select>
	   	</td>
		   		<td class="grayField"><label>Status</label></td>
				<td colspan="3">
				<select class="selBig" name="status" id="status" required>
					<option value="">Seleccione una opción</option>
					<option value="Activado">Activado</option>
					<option value="Desactivado">Desactivado</option>
				</select>
			</td>
	   </tr>
		</tbody>
	</table>
	<input type="hidden" name="usuarioID" id="usuarioID" value="" />
	<input type="hidden" name="creacionUsuarios" id="dardealta" value="dardealta">
	<input type="submit" id="submit" value="Generar" class="mt10 mainBotton">
	<br class="clear">
</div>
</form>
</div>

<script language="javascript" src="<?=base_url()?>assets/js/jquery-datepicker.js" type="text/javascript"></script>
<script>
$("#fechaRegistro").datepicker({
    dateFormat: 'yy-mm-dd',
    changeMonth: true,
   	changeYear: true,
    yearRange: "-100:+0",
    numberOfMonths: 3,
    showCurrentAtPos: 2
});
</script>