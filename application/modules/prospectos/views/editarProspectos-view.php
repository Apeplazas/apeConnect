<? $user = $this->session->userdata('usuario'); ?>

<? $primerNombre            = set_value('primerNombre'); ?>
<? $segundoNombre           = set_value('segundoNombre'); ?>
<? $apellidoPaterno         = set_value('apellidoPaterno'); ?>
<? $apellidoMaterno         = set_value('apellidoMaterno'); ?>
<? $email                   = set_value('email'); ?>
<? $telefono                = set_value('telefono'); ?>
<? $mobile                  = set_value('mobile'); ?>
<? $plaza                   = set_value('plaza[]'); ?>
<? $actividad               = set_value('actividad'); ?>
<? $origen                  = set_value('origen'); ?>
<? $vendedor                = set_value('vendedor'); ?>
<? $calle                   = set_value('calle'); ?>
<? $estado                  = set_value('estado'); ?>
<? $municipio               = set_value('municipio'); ?>
<? $colonia                 = set_value('colonia'); ?>
<? $cp                      = set_value('cp'); ?>
<? $exterior                = set_value('exterior'); ?>
<? $interior                = set_value('interior'); ?>

<? $errorPrimerNombre       = form_error('primerNombre'); ?>
<? $errorApellidoPaterno    = form_error('apellidoPaterno'); ?>
<? $errorEmail              = form_error('email'); ?>
<? $errorTelefono           = form_error('telefono'); ?>
<? $errorActividad          = form_error('actividad'); ?>
<? $errorOrigen             = form_error('origen'); ?>
<? $errorCalle              = form_error('calle'); ?>
<? $errorEstado             = form_error('estado'); ?>
<? $errorColonia            = form_error('colonia'); ?>
<? $errorMunicipio          = form_error('municipio'); ?>
<? $errorCp                 = form_error('cp'); ?>
<? $errorExterior           = form_error('exterior'); ?>
<? $errorComentario         = form_error('comentario'); ?>

<div id="mainTit">
	<h3>Creando nuevo contacto</h3>
</div>

<div class="wrapList">
<? foreach($perfil as $row):?>
<div id="actions">
	<span class="back">
	 <a class="addSmall" href="javascript:window.history.go(-1);">
		 <i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/back.svg" alt="Regresar"></i>
		 <span>Regresar</span>
	 </a>
	</span>
</div>

	<form action="<?=base_url()?>prospectos/editarProspecto/<?=$this->uri->segment(3);?>" method="post">
	<?= $this->session->flashdata('msg');?>
	<div class="wrapListForm" id="wrapListForm1">
	<table>
		<thead>
	  <tr>
	    <th colspan="4">Datos personales</th>
	  </tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<label><span class="obli">*</span>Primer nombre</label>
				</td>
				<td>
					<select name="titulo" class="selSma">
				    <option value="Sr">Sr</option>
				    <option value="Sra">Sra</option>
				    <option value="Ing">Ing</option>
				    <option value="Lic">Lic</option>
				    <option value="Otro">Otro</option>
			    </select>
			    <? if($errorPrimerNombre):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorPrimerNombre?></em></div><?endif?>
			    <input class="medInpSpe soloLetras" name="primerNombre" value="<? if ($row->pnombre):?><?=$row->pnombre?><?endif?><?= set_value('primerNombre');?>" type="text"/>
				</td>
				<td>
					<label>Segundo nombre</label>
				</td>
				<td>
					<input class="bigInp soloLetras" name="segundoNombre" value="<? if ($row->snombre):?><?=$row->snombre?><?endif?><?=set_value('segundoNombre');?>" type="text"/>
				</td>
			</tr>
			<tr>
				<td>
					<label><span class="obli">*</span>Apellido paterno</label>
				</td>
				<td>
					<? if($errorApellidoPaterno):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?=$errorApellidoPaterno?></em></div><?endif?>
			    <input class="bigInp soloLetras" name="apellidoPaterno" value="<? if ($row->apellidop):?><?=$row->apellidop?><?endif?><?=set_value('apellidoPaterno');?>" type="text"/>
				</td>
				<td>
					<label>Apellido materno</label>
				</td>
				<td>
					<input class="bigInp soloLetras" name="apellidoMaterno" value="<? if ($row->apellidom):?><?=$row->apellidom?><?endif?><?=set_value('apellidoMaterno');?>" type="text"/>
				</td>
			</tr>
			<tr>
				<td>
					<label><span class="obli">*</span>Correo electrónico</label>
				</td>
				<td>
					<? if($errorEmail):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorEmail?></em></div><?endif?>
					<input class="bigInp" name="email" value="<? if ($row->correo):?><?=$row->correo?><?endif?><?=set_value('email');?>" type="text"/>
				</td>
				<td>
					<label><span class="obli">*</span>Teléfono</label>
				</td>
				<td>
					<? if($errorTelefono):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorTelefono?></em></div><?endif?>
				    <input class="bigInp soloNumeros" name="telefono" value="<? if ($row->telefono):?><?=$row->telefono?><?endif?><?=set_value('telefono');?>" type="text"/>
				</td>
			</tr>
			<tr>
				<td>
					<label>Celular</label>
				</td>
				<td>
					<input class="bigInp soloNumeros" name="mobile" value="<? if ($row->celular):?><?=$row->celular?><?endif?><?=set_value('mobile');?>" type="text"/>
				</td>
				<td>
					<label><span class="obli">*</span>Actividad</label>
				</td>
				<td>
					<? if($errorActividad):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorActividad?></em></div><?endif?>
			    <select name="actividad" class="selBig">
					<? if($actividad):?><option checked value="<?= $actividad?>"><?= $actividad?></option><?endif?>
					<? if($row->actividad):?> <option value="" checked><?=$row->actividad?></option><?endif;?>
				    <option value="Ventas">Ventas </option>
				    <option value="Servicios">Servicios</option>
			    </select>
				</td>
			</tr>
			<tr>
				<td>
					<label><span class="obli">*</span>Origen cliente</label>
				</td>
				<td>
					<? if($errorOrigen):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorOrigen?></em></div><?endif?>
	 	    	<select name="origen" class="selBig">
	 		    	<? if($origen):?><option value="<?= $origen?>"><?= $origen?></option><?endif?>
	 		    	<? if($row->origenCliente):?> <option value="<?=$row->origenCliente?>" checked><?=$row->origenCliente?></option><?endif;?>
	 		    		<option value="">Seleccione el origen</option>
	 		    		<? foreach($origenCliente as $rowOrigen):?>
	 		    		<option value="<?= $rowOrigen->origen;?>" ><?= $rowOrigen->origen;?></option>
	 		    		<? endforeach; ?>
					</select>
				</td>
				<td>
					<label>Giro</label>
				</td>
				<td>
					<select id="infoGiro" name="giro" class="selBig">
				    <? if($giro):?><option value="<?= $giro?>" checked><?= $giro?></option><?endif?>
				    <? if($row->giro):?>
				    <? $g = $this->prospectos_model->cargarGirosProspecto($row->id);?>
				    <? foreach($g as $gir):?>
				    <option value="<?=$row->giro?>" checked><?=$gir->giroProspecto?></option>
				    <? endforeach; ?>
				    <?endif;?>


				    <? foreach($giros as $g):?>
				    <option value="<?= $g->giroID;?>"><?= $g->giro;?></option>
				    <? endforeach; ?>
			    </select>
				</td>
			</tr>
			<tr>
				<td>
					<? if ($user['tipoUsuario'] == 'Administrador'):?>
					<label>Asignado a:</label>
					<?endif?>
				</td>
				<td>
					<? if ($user['tipoUsuario'] == 'Administrador'):?>
				    <select name="asignado" class="selBig">
					    <option value="<?=$user['usuarioID']?>" checked ><?=$user['nombre'];?></option>
					    <? foreach($vendedores as $v):?>
					      <option value="<?= $v->usuarioID;?>"><?= $v->nombreCompleto;?></option>
					    <? endforeach; ?>
				    </select>
						<?endif?>
				</td>
				<td>
					<label><span class="obli">*</span>Propiedad</label>
				</td>
				<td>
					<select name="plaza[]" id="idPlaza" class="selMed selPlaza">
						<? if(!$cadena):?>
						<option value="" checked>Seleccione una opción</option>
						<? endif?>
					    <? foreach($plazas as $p):?>
					    <option value="<?= $p->clavePropiedad;?>"><?= $p->propiedad;?></option>
					    <? endforeach; ?>
				    </select>
				    <span class="plusPlaza">Agregar Plaza</span>
				    <div  id="masPlazas">
						<? foreach($zonas as $z):?>
						<div class="prel f100">
							<div id="<?= $z->clavePropiedad;?>" class="delToolSmallThree delPlaza"><i class="iconDelete">Borrar</i></div>
							<input type="hidden" name="plaza[]" value="<?= $z->clavePropiedad;?>" />
							<div class="plazaSel"><?= ucfirst($z->propiedad);?></div>
						</div>
						<? endforeach; ?>
				    </div>
				</td>
			</tr>
		</tbody>
	</table>
<br class="clear">
</div>


<div class="wrapListForm" id="wrapListForm2">
	<table>
		<thead>
		<tr>
			<th colspan="4">Detalles de la dirección</th>
		</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<label>Estado</label>
				</td>
				<td>
					<? if($errorEstado):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorEstado?></em></div><?endif?>
			    <select id="estado" class="selBig" name="estado">
				    <? if($estado):?><option checked value="<?= $estado?>"><?= $estado?></option><?endif?>
				    <? if($row->estado):?><option checked value="<?=$row->estado?>"><?= $row->estado?></option><?endif?>
				    <option value="">Seleccione un estado</option>
				    <? foreach($estados as $estadosRow):?>
				    <option value="<?= $estadosRow->nombreEstado?>"><?= $estadosRow->nombreEstado?></option>
				    <? endforeach;?>
					</select>
				</td>
				<td>
					<label>Municipio</label>
				</td>
				<td>
					<? if($errorMunicipio):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorMunicipio?></em></div><?endif?>
			    <select id="municipio" class="selBig" name="municipio">
				    <? if($municipio):?><option checked value="<?= $municipio?>"><?= $municipio?></option><?endif?>
				    <? if($row->municipio):?><option checked value="<?=$row->municipio?>"><?= $row->municipio?></option><?endif?>
				    <option value="">Seleccione un municipio</option>
				</select>
				</td>
			</tr>
			<tr>
				<td>
					<label>Colonia</label>
				</td>
				<td>
					<? if($errorColonia):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorColonia?></em></div><?endif?>
			    <select id="colonia" class="selBig" name="colonia">
				    <? if($colonia):?><option checked value="<?= $colonia?>"><?= $colonia?></option><?endif?>
				    <? if($row->colonia):?><option checked value="<?=$row->colonia?>"><?= $row->colonia?></option><?endif?>
				    <option value="">Seleccione una colonia</option>
				</select>
				</td>
				<td>
					<label>Código postal</label>
				</td>
				<td>
					<? if($errorCp):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorCp?></em></div><?endif?>
					<input type="text" class="bigInp soloNumeros" id="cp" name="cp" value="<? if ($row->cp):?><?=$row->cp?><?endif?><?= set_value('cp');?>" />
				</td>
			</tr>
			<tr>
				<td>
					<label>Calle</label>
				</td>
				<td>
					<? if($errorCalle):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorCalle?></em></div><?endif?>
				<input class="bigInp" name="calle" value="<? if ($row->calle):?><?=$row->calle?><?endif?><?=set_value('calle');?>"/>
				</td>
				<td>
					<label>Número exterior</label>
				</td>
				<td>
					<? if($errorExterior):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorExterior?></em></div><?endif?>
				<input class="bigInp soloNumeros" name="exterior" value="<? if ($row->numeroExt):?><?=$row->numeroExt?><?endif?><?=set_value('exterior');?>" type="text"/>
				</td>
			</tr>
			<tr>
				<td>
					<label>Número interior</label>
				</td>
				<td>
					<input class="bigInp soloNumeros" name="interior" value="<? if ($row->numeroInt):?><?=$row->numeroInt?><?endif?><?=set_value('interior');?>" type="text"/>
				</td>
				<td>

				</td>
				<td>

				</td>
			</tr>
		</tbody>
	</table>
<br class="clear">
</div>

<!-- Tu comentario
<div class="wrapListForm">
	<span class="msgBar grayBox">Datos personales</span>
	<fieldset>
	<? if($errorComentario):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorComentario?></em></div><?endif?>
	<div class="wrapLabel">
		<label>Imagen del Contacto</label>
	</div>
	<div class="imageIcon">
		<span class="selectPicture">
		  <input type="file" name="archivo" id="image_src">
		</span>
	</div>
	<i id="addFot">Fecha de Nacimiento</i>
	</fieldset>
	<fieldset>
	<? if($errorComentario):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorComentario?></em></div><?endif?>
	<div class="wrapLabel">
	  <label>Fecha de nacimiento</label>
	</div>
	<div class="wrapDateForm">
	  <select name="" id="dia">
		<?php for ($i=1;$i<=31;$i++){?>
		  <option value="<?=$i?>" ><?=$i?></option>
		<?php } ?>
	  </select>
	  <select name="" id="mes">
		<?php for ($i=1;$i<=12;$i++){?>
		  <option value="<?=$i?>" ><?=$i?></option>
		<?php } ?>
	  </select>
	  <select name="" id="anio">
		<?php for ($i=1925;$i<=2000;$i++){?>
		  <option value="<?=$i?>" ><?=$i?></option>
		<?php } ?>
	  </select>
	  <span class="calendar">Calendario</span>
	</div>
	</fieldset>
</div>
 -->


<div class="wrapListForm" id="wrapListForm3">
	<span class="secmainTit">Información importante</span>
	<div class="comenWrap">
	    <div class="wrapLabel">
    	<? if($errorComentario):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorComentario?></em></div><?endif?>
		<textarea class="texBig" name="comentario" value=""><? if ($row->comentario):?><?=$row->comentario?><?endif?><?=set_value('comentario');?></textarea>
	</div>

	<span id="formSub">
	  <input class="mainBotton" type="submit" name="button" id="button" value="Guardar" class='contacto_enviar' />
	</span>



</form>
<br class="clear">
<? endforeach; ?>
</div>
<script type="text/javascript">
	$('#wrapListForm1 tbody tr td:even').addClass('grayField');
	$('#wrapListForm2 tbody tr td:even').addClass('grayField');
</script>
</div>
