<? foreach($perfil as $row):?>
<div id="mainTit">
	<h3><img src="<?=base_url()?>assets/graphics/svg/directorio.svg" alt="Perfil de <?= $row->pnombre;?> <?= $row->snombre;?> <?= $row->apellidop;?> <?= $row->apellidom;?>" />
		<?= $row->pnombre;?> <?= $row->snombre;?> <?= $row->apellidop;?> <?= $row->apellidom;?></h3>
</div>

<div class="wrapList" >
	<div id="actions">
		<a href="<?=base_url()?>prospectos/agregar" title="Agregar Contactos" class="addSmall">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Agregar contacto"></i>
			<span>Agregar Contacto</span>
		</a>
		<a href="<?=base_url()?>prospectos/localesCotizadosProspectos/<?= $this->uri->segment(3)?>" title="Agregar Contactos" class="addSmall">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/apartado.svg" alt="Ingresar Apartado"></i>
			<span>Ingresar Apartado</span>
		</a>
		<a href="<?=base_url()?>prospectos/generarRecibo/<?= $this->uri->segment(3)?>" title="Agregar Contactos" class="addSmall">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/recibo.svg" alt="Ingresar Recibo"></i>
			<span>Ingresar Recibo</span>
		</a>
		<!-- Formulario para generar cotizacion -->
		<form action="<?=base_url()?>prospectos/cotizar/<?= $this->uri->segment(3)?>" method="post">
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
			<a href="<?=base_url()?>prospectos/borrar/<?= $this->uri->segment(3)?>/borrado" class="addToolSmall" title="Borrar"><i class="iconDelete">Borrar</i></a>

			<a href="<?=base_url()?>prospectos/editar/<?= $this->uri->segment(3)?>" class="addToolSmall" title="Editar"><i class="iconEdit">Editar</i></a>
			</span>
		</div>


	<div class="wrapListForm">
		<span class="msgBar grayBox">Datos personales.</span>
		<div class="divPer">
			<div class="wrapLabelPer">
			  <label><span class="obli">*</span>Primer nombre</label>
			</div>
			<p><?= $row->pnombre;?></p>
		</div>

		<div class="divPer">
		    <div class="wrapLabelPer">
			 <label>Segundo nombre</label>
		    </div>
		    <p><?= $row->snombre;?></p>
		</div>

		<div class="divPer">
		    <div class="wrapLabelPer">
			  <label><span class="obli">*</span>Apellido paterno</label>
		    </div>
		    <p><?= $row->apellidop;?></p>
		</div>

		<div class="divPer">
		   <div class="wrapLabelPer">
			  <label><span class="obli">*</span>Apellido materno</label>
		    </div>
		    <p><?= $row->apellidom;?></p>
		</div>

		<div class="divPer">
			<div class="wrapLabelPer">
		      <label><span class="obli">*</span>Correo electrónico</label>
			</div>
			<p><?= $row->correo;?></p>
		</div>

		<div class="divPer">
		    <div class="wrapLabelPer">
		      <label><span class="obli">*</span>Teléfono</label>
			</div>
			<p><?= $row->telefono;?></p>
		</div>

		<div class="divPer">
		    <div class="wrapLabelPer">
		    <label>Celular</label>
		    </div>
		    <p><?= $row->celular;?></p>
		</div>

		<div class="divPer">
		    <div class="wrapLabelPer">
			  <label><span class="obli">*</span>Actividad</label>
		    </div>
		    <p><?= $row->actividad;?></p>
		</div>

		<div class="divPer">
			<div class="wrapLabelPer">
			  <label><span class="obli">*</span>Plaza</label>
			</div>
			<p id="plazaLista">
			<? foreach($zonas as $p):?>
				<?= $p->zona;?>,
			<? endforeach; ?>
			</p>

		</div>

		<div class="divPer">
		    <div class="wrapLabelPer">
			  <label><span class="obli">*</span>Origen cliente</label>
		    </div>
		    <p><?= $row->origenCliente;?></p>
		</div>

		<div class="divPer">
		    <div class="wrapLabelPer">
			  <label>Giro</label>
		    </div>
		   <? foreach($giros as $g):?>
			<p class="firsUp"><?= $g->giroProspecto;?> </p>
			<? endforeach; ?>
		</div>


		<div class="divPer">
		    <div class="wrapLabelPer">
			  <label>Asignado a:</label>
		    </div>
		    <p>
		    <? foreach($vendedor as $e):?>
			<?= $e->nombreCompleto;?>,
			<? endforeach; ?>
			</p>
		</div>

	</div>

	<div class="wrapListForm">
		<span class="msgBar grayBox">Detalles de la dirección</span>
		<div class="divPer">
		    <div class="wrapLabelPer">
			  <label>Estado</label>
		    </div>
		    <p><?= $row->estado;?></p>
		</div>

		<div class="divPer">
		    <div class="wrapLabelPer">
			  <label>Municipio</label>
		    </div>
		    <p><?= $row->municipio;?></p>
		</div>

		<div class="divPer">
		    <div class="wrapLabelPer">
			  <label>Colonia</label>
		    </div>
		    <p><?= $row->colonia;?></p>
		</div>

		<div class="divPer">
		    <div class="wrapLabelPer">
			  <label>Código postal</label>
		    </div>
		    <p><?= $row->cp;?></p>
		</div>

		<div class="divPer">
		    <div class="wrapLabelPer">
			  <label>Calle</label>
	    	</div>
	    	<p><?= $row->calle;?></p>
		</div>

		<div class="divPer">
		    <div class="wrapLabelPer">
			  <label>Número exterior</label>
	    	</div>
	    	<p><?= $row->numeroExt;?></p>
		</div>

		<div class="divPer">
		    <div class="wrapLabelPer">
			  <label>Número interior</label>
	    	</div>
	    	<p><?= $row->numeroInt;?></p>
		</div>
	</div>

	<div class="wrapListForm">
		<span class="msgBar grayBox">Información importante</span>
		<div class="comenWrap">
		    <div class="wrapLabel">
			  <label>Comentario</label>
	    	</div>
	    	<p><?= $row->comentario;?></p>
		</div>
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
