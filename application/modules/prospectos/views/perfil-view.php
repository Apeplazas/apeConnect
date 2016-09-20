<? $usuarioSesion	= $this->session->userdata('usuario');?>
<? foreach($perfil as $row):?>
<div id="mainTit">
	<h3><img src="<?=base_url()?>assets/graphics/svg/directorio.svg" alt="Perfil de <?= $row->pnombre;?> <?= $row->snombre;?> <?= $row->apellidop;?> <?= $row->apellidom;?>" />
		<?= $row->pnombre;?> <?= $row->snombre;?> <?= $row->apellidop;?> <?= $row->apellidom;?></h3>
</div>

<div class="wrapList">
	
	<div id="actions">
		<? if ($usuarioSesion['usuarioID'] == '2' || $usuarioSesion['usuarioID'] == '1'):?>
		<a id="showC" href="<?=base_url()?>prospectos/localesCotizadosProspectos/<?= $this->uri->segment(3)?>" title="Agregar Comentario" class="addSmall">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/comentarios.svg" alt="Agregar Comentario"></i>
			<span>Agregar Comentario</span>
		</a>
		<?endif?>
		<? if ($usuarioSesion['usuarioID'] == '2' || $usuarioSesion['usuarioID'] == '1'):?>
			<a href="<?=base_url()?>prospectos/localesCotizadosProspectos/<?= $this->uri->segment(3)?>" title="Ingresar Apartados" class="addSmall">
				<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/apartado.svg" alt="Ingresar Apartado"></i>
				<span>Ingresar Apartado</span>
			</a>
			<!-- Formulario para generar cotizacion -->
			<form class="fleft" action="<?=base_url()?>prospectos/cotizar/<?= $this->uri->segment(3)?>" method="post">
			<fieldset class="addSmall">
				<div class="fleft">
					<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/cotizarLocal.svg" alt="Cotizar Local"></i>
				</div>
				<input type="hidden" name="prospectoID" value="<?= $this->uri->segment(3)?>">
				<input type="hidden" name="nombre" value="<?=$row->pnombre;?> <?= $row->apellidop;?> <?= $row->apellidom;?>">
				<input type="hidden" name="tipo" value="nuevaCotizacion" />
				<input id="cotLoc" class="formBotonBig mtb10" type="submit" value="Cotizar local" alt="Comprar">
			</fieldset>
			</form>
			<a href="<?=base_url()?>prospectos/generar_referencia/<?= $this->uri->segment(3)?>" title="Generar Referencia" class="addSmall">
				<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/apartado.svg" alt="Generar Referencia"></i>
				<span>Generar Referencia</span>
			</a>
			<!-- Valida si hay cotizaciones y muestra la cuenta -->
			<? $cot = $this->prospectos_model->cuentaCotizacionProspecto($this->uri->segment(3));?>
	
			<? if ($cot[0]->cuenta > '0'):?>
			<a href="<?=base_url()?>prospectos/cotizaciones/<?= $row->id;?>" title="Ver Cotizaciones" class="addSmall">
				<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/ver.svg" alt="Ver cotizaciones"></i>
				<span>Ver Cotizaciones </span>
				<div class="countRed"><?= $cot[0]->cuenta;?></div>
			</a>
			<?endif?>
		
		<?endif;?>
		<!-- Alta de usuarios solo por gerentes de plaza <a href="<?=base_url()?>prospectos/solicitarAlta/<?= $this->uri->segment(3)?>" title="Agregar Contactos" class="addSmall"><i class="iconPlus">Agregar</i>Solicitar alta</a>-->


			<span class="toolBar">
			<a href="<?=base_url()?>prospectos/borrar/<?= $this->uri->segment(3)?>/borrado" class="addToolSmall" title="Borrar">
				<i class="iconDeleteT">
					<img src="<?=base_url()?>assets/graphics/svg/borrar.svg" alt="Borrar Prospecto"></i>
			</a>

			<a href="<?=base_url()?>prospectos/editar/<?= $this->uri->segment(3)?>" class="addToolSmall" title="Editar">
				<i class="iconEditT">
					<img src="<?=base_url()?>assets/graphics/svg/pencilW.svg" alt="Editar Prospecto">
				</i>
			</a>
			</span>
		</div>
		
		
		<?= $this->session->flashdata('msg');?>
		
		
		
	
	
	<div class="wrapListForm mt10" id="wrapListForm1">
	<table>
		<thead>
			<tr>
				<th colspan="4">Datos personales</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="grayField"><strong>Primer nombre</strong></td>
				<td><p><?= $row->pnombre;?></p></td>
				<td class="grayField"><strong>Segundo nombre</strong></td>
				<td><p><?= $row->snombre;?></p></td>
			</tr>
			<tr>
				<td class="grayField"><strong>Apellido paterno</strong></td>
				<td><p><?= $row->apellidop;?></p></td>
				<td class="grayField"><strong>Apellido materno</strong></td>
				<td><p><?= $row->apellidom;?></p></td>
			</tr>
			<tr>
				<td class="grayField"><strong>Correo electrónico</strong></td>
				<td><p><?= $row->correo;?></p></td>
				<td class="grayField"><strong>Teléfono</strong></td>
				<td><p><?= $row->telefono;?></p></td>
			</tr>
			<tr>
				<td class="grayField"><strong>Celular</strong></td>
				<td><p><?= $row->celular;?></p></td>
				<td class="grayField"><strong>Actividad</strong></td>
				<td><p><?= $row->actividad;?></p></td>
			</tr>
			<tr>
				<td class="grayField"><strong>Plaza</strong></td>
				<td>
					<p id="plazaLista">
					<? foreach($zonas as $p):?>
						<?= $p->zona;?>,
					<? endforeach; ?>
					</p>
				</td>
				<td class="grayField"><strong>Origen cliente</strong></td>
				<td><p><?= $row->origenCliente;?></p></td>
			</tr>
			<tr>
				<td class="grayField"><strong>Asignado a:</strong></td>
				<td>
					<? foreach($vendedor as $e):?>
					<p><?= $e->nombreCompleto;?>,</p>
					<? endforeach; ?>
				</td>
				<td class="grayField"><strong>Giro</strong></td>
				<td>
					<? foreach($giros as $g):?>
	 					<p class="firsUp"><?= $g->giroProspecto;?> </p>
	 				<? endforeach; ?>
				</td>
			</tr>
		</tbdody>
	</table>
	<br class="clear">
	</div>

	<div class="wrapListForm"  id="wrapListForm2">
		<table>
			<thead>
				<tr>
					<th colspan="4">Detalles de la dirección</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="grayField"><strong>Estado</strong></td>
					<td><p><?= $row->estado;?></p></td>
					<td class="grayField"><strong>Municipio</strong></td>
					<td><p><?= $row->municipio;?></p></td>
				</tr>
				<tr>
					<td class="grayField"><strong>Colonia</strong></td>
					<td><p><?= $row->colonia;?></p></td>
					<td class="grayField"><strong>Municipio</strong></td>
					<td><p><?= $row->municipio;?></p></td>
				</tr>
				<tr>
					<td class="grayField"><strong>Código postal</strong></td>
					<td><p><?= $row->cp;?></p></td>
					<td class="grayField"><strong>Calle</strong></td>
					<td><p><?= $row->calle;?></p></td>
				</tr>
				<tr>
					<td class="grayField"><strong>Número exterior</strong></td>
					<td><p><?= $row->numeroExt;?></p></td>
					<td class="grayField"><strong>Número interior</strong></td>
					<td><p><?= $row->numeroInt;?></p></td>
				</tr>
			</tbody>
		</table>
		<br class="clear">
	</div>
	
	
	
		

	
	<div class="wrapListForm" id="wrapListForm3">
		<span class="secmainTit">Información importante</span>
		
			<? $conversacionId = 0;
				if (sizeof($comentario) > 0):
		        	$conversacionId=$comentario[0]->cID;
			?>
			<ul id="creaInfo">
				<? $conversacion = $this->data_model->traeRespuesta($comentario[0]->cID);
				foreach($conversacion as $row2):?>
				<li>
				<b><em> <?= $row2->nombreCompleto?> </em> - <span><?=convierteFechaBDLetra($row2->fechaRespuesta,'2');?></span> </b>
				<p><?= $row2->respuesta?></p>
				</li>
				<? endforeach;?>
			</ul>
			<? endif ?>
			
			<? if ($row->comentario):?>
			<div class="comenWrap">
		    	<p id="comenW"><b>Comentario de apertura</b><?= $row->comentario;?> </p>
			</div>
			<?endif?>
			<br class="clear">
		
	</div>
	<div class="wrapListForm">
		<span class="secmainTit mb10">Referencias</span>
		<div class="comenWrap">
	    	<?php if(!empty($referencias)):?>
	    		<table id="referencias">
	    			<thead>
	    				<tr>
	    					<td class="grayField">Referencia</td>
	    					<td class="grayField">Plaza</td>
	    					<td class="grayField">Piso</td>
	    					<td class="grayField">Locales</td>
	    				</tr>
	    			</thead>
	    			<tbody>
	    		<?php foreach($referencias as $ref):
	    			$plaza_datos = $this->tempciri_model->traerDatosPLaza($ref->plaza_id);?>
	    			<tr>
		    			<td><?php echo $ref->rap;?></td>
		    			<td><?php echo $plaza_datos[0]->plaza;?></td>
		    			<td><?php echo $ref->piso;?></td>
		    			<td><?php echo $ref->locales;?></td>
	    			</tr>
	    		<?php endforeach;?>
	    			</tbody>
	    		</table>	
	    	<?php else:?>
	    		<p>Aún no se han generado referencias para este prospecto</p>
	    	<?php endif;?>
		</div>
		<br class="clear">
	</div>
	
	
	<!------  AQUI SE MUESTRA EL TEXTAREA PARA INSERTAR UN COMENTARIO SOBRE EL PROSPECTO   ----->
		<div class="wrapListForm" id="commentC">
			<form  action="<?=base_url()?>prospectos/agregarComentario" method="post">
				<textarea name="respuesta" placeholder="Agrega tu comentario"></textarea>
				<input type="hidden" name="conversacionId" value="<?=$conversacionId;?>" />
				<input type="hidden" name="prospectoID" value="<?=$this->uri->segment(3);?>" />
				<input class="mainBotton" type="submit" value="Enviar Comentario" />
			</form>
			<br class="clear">
		</div>
		<!---Aqui termina comentario textarea--->
	</div>
</div>

<? endforeach; ?>
<script>
	$(document).ready(function(){
		$('#tipoEmpresa').on('change',function(){

			var persona = $('#tipoEmpresa').val();
			var nombre = $('#nombreCuenta').val();
			var fecha = $('#datepicker').val();

			$.ajax({
				data : {
					'nombre' : nombre,
					'persona' : persona,
					'fecha'	: fecha
				},
				dataType : 'json',
				url : ajax_url+'genera_rfc',
				type : 'post',
				success : function(response) {
					$('#rfcCuenta').val(response.rfc);
				}
			});
		});
	});
</script>
