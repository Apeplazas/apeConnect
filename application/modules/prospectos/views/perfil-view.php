<? foreach($perfil as $row):?>
<div id="mainTit">
	<h3><img src="<?=base_url()?>assets/graphics/svg/directorio.svg" alt="Perfil de <?= $row->pnombre;?> <?= $row->snombre;?> <?= $row->apellidop;?> <?= $row->apellidom;?>" />
		<?= $row->pnombre;?> <?= $row->snombre;?> <?= $row->apellidop;?> <?= $row->apellidom;?></h3>
</div>

<div class="wrapList" >
	<div id="actions">
		<a href="<?=base_url()?>prospectos/localesCotizadosProspectos/<?= $this->uri->segment(3)?>" title="Agregar Contactos" class="addSmall">
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
		<!-- Valida si hay cotizaciones y muestra la cuenta -->
		<? $cot = $this->prospectos_model->cuentaCotizacionProspecto($this->uri->segment(3));?>

		<? if ($cot[0]->cuenta > '0'):?>
		<a href="<?=base_url()?>prospectos/cotizaciones/<?= $row->id;?>" title="Ver Cotizaciones" class="addSmall"><i class="iconPlus">Agregar</i>Ver Cotizaciones <span><?= $cot[0]->cuenta;?></span></a>
		<?endif?>


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


	<div class="wrapListForm" id="wrapListForm1">


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
		<div class="comenWrap">
	    	<p id="comenW"><b>Comentario</b><?= $row->comentario;?> dsf asdfasdf </p>
		</div>
		<br class="clear">
	</div>
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
				url : 'http://www.apeplazas.com/apeConnect/ajax/genera_rfc',
				type : 'post',
				success : function(response) {
					$('#rfcCuenta').val(response.rfc);
				}
			});
		});
	});
</script>
