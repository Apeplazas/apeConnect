<? foreach($proveedor as $row): ?>
<div id="firstSeg">
<div id="mainTit"><img src="<?=base_url()?>assets/graphics/proveedoresBlack.png" alt="Datos del Proveedor <?=$row->razonSocial;?>">Datos del Proveedor <?=$row->razonSocial;?></div>

	<div id="proy" class="topDiv">
		<p><b>Representante Legal:</b> <em><?=$row->representante;?></em></p>
		<p><b>Telefono:</b> <em><?=$row->telefono;?></em></p>
		<p><b>Celular:</b> <em><?php if(!empty($row->celular)):?><?=$row->celular;?><? else:?>No proporcionado<?php endif;?></em></p>
		<p><b>Email:</b> <em><?=$row->email;?></em></p>
		<p><b>Fecha de Ingreso:</b> <em><?=$row->fechaincgeso;?></em></p>
		<p><b>Razo Social:</b> <em><?=$row->razonSocial;?></em></p>
		<p><b>Tipo de registro:</b> <em><?=$row->tipoRegistro;?></em></p>
	</div>
	<form id="statusProv">
	  <fieldset>
		<label>Status del proveedor</label>
		<select id="changestatusProv" name="statusProveedor">
			<option value="autorizado" <?php if($row->statusProveedor == 'autorizado') echo "selected";?>>Autorizado</option>
			<option value="cancelado" <?php if($row->statusProveedor == 'cancelado') echo "selected";?>>Cancelad</option>
			<option value="en proceso" <?php if($row->statusProveedor == 'en proceso') echo "selected";?>>En proceso</option>
		</select>
	  </fieldset>
	  <fieldset>
		<label>Rango de costos</label>
		<select id="changerangoProv" name="idRango">
			<?php foreach($costoRango as $rango):?>
				<option value="<?=$rango->idRango;?>" <?php if($row->idRango == $rango->idRango) echo "selected";?>>$<?=$rango->rangoMinimo;?> - $<?=$rango->rangoMaximo;?></option>
			<?php endforeach;?>
		</select>
		<input type="hidden" value="<?=$row->idProveedor;?>" id="proveedorid" />
	  </fieldset>
	</form>
</div>
<div id="estPro">
	<strong class="headTit53 topDiv headTit" style="">Estados en los que puede participar </strong>
		<ul>
			<?php foreach($estados as $estado):?>
				<li><?=$estado->nombreEstado;?></li>
			<?php endforeach;?>
		</ul>
	</div>

<br class="clear">
<div id="direccion">
<strong class="headTit53 topDiv headTit" style="">Ubicación del proveedor</strong>
	<p><b>Municipio:</b> <?=$row->municipio;?></p>
	<p><b>Colonia:</b> <?=$row->colonia;?></p>
	<p><b>Codigo Postal:</b> <?=$row->cp;?></p>
	<p><b>Direccion:</b> <?=$row->direccion;?></p>
</div>
<div id="doc">
<strong class="headTit53 topDiv headTit">Documentos del proveedor</strong>
	<?php if(!empty($row->cedulas)): ?>
		<img src="<?=URLCEDULA.$row->cedulas;?>"/>
	<?php endif;?>
	<?php if(!empty($row->shcp)):?>
		<img src="<?=URLSSHCP.$row->shcp;?>"/>
	<?php endif;?>
	<?php if(!empty($row->edoCuenta)):?>
		<img src="<?=URLEDOCUENTA.$row->edoCuenta;?>"/>
	<?php endif;?>
	<?php if(!empty($row->comprobanteDomicilio)):?>
		<img src="<?=URLDOMICILIO.$row->comprobanteDomicilio;?>"/>
	<?php endif;?>
	<?php if(!empty($row->credencialElector)):?>
		<img src="<?=URLCREDEL.$row->credencialElector;?>"/>
	<?php endif;?>
	<?php if($row->tipoRegistro == 'fisica'): ?>
		<?php if(!empty($row->imss)):?>
			<img src="<?=URLIMSS.$row->imss;?>"/>
		<?php endif;?>
	<?php elseif($row->tipoRegistro == 'moral'):?>
		<?php if(!empty($row->certificado)):?>
			<img src="<?=URLCERTIFICADO.$row->certificado;?>"/>
		<?php endif;?>
		<?php if(!empty($row->actasConstitutivas)):?>
			<img src="<?=DIRACTAS.$row->actasConstitutivas;?>"/>
		<?php endif;?>
	<?php endif;?>
</div>
<?php if($row->statusProveedor == 'autorizado'):?>
	<div>
		<strong class="headTit53 topDiv headTit">Proyectos trabajando actualmente</strong>
		<?php if(!empty($pactuales)):?>
			<ul id="proyActuales">
			<?php foreach($pactuales as $pactual):?>
				<li><?=$pactual->tituloProyecto;?></li>
			<?php endforeach;?>
			</ul>
		<?php else:?>
			<p class="mt10 msgFlash">Actualmente no tiene ningun proyecto en esta seccion</p>
		<?php endif;?>
	</div>
	<?php if(!empty($pfinalizados)):?>
	<div>
	  <strong class="headTit53 topDiv headTit">Proyectos finalizados</strong>
	    <ul id="listProyFin">
	      <li>test</li>
	      <li>test sd fa</li>
	      <?php foreach($pfinalizados as $pfinalizado):?>
	      <li><?=$pfinalizado->tituloProyecto;?></li>
	      <?php endforeach;?>
	    </ul>
	</div>
	<?php endif;?>
<?php endif;?>

<? endforeach; ?>
