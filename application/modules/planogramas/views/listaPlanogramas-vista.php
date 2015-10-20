<div id="mainTit">
	<h3>Listado de Planogramas</h3>
</div>

<div class="wrapList">
	<div id="actions">
		<span class="back">
		 <a class="addSmall" href="javascript:window.history.go(-1);">
			 <i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/back.svg" alt="Regresar"></i>
			 <span>Regresar</span>
		 </a>
		</span>

		<div id="winPlaza" title="Agregar Contactos" class="addSmall">
			<i class="iconPlus">
				<img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Agregar Planograma">
				<span>Agregar Planograma</span>
			</i>


			<div id="addPlaza">
			<form id="formPlano" action="<?= base_url();?>planogramas/subirPlano" method="post" enctype="multipart/form-data">
				<h2>Formulario planogramas</h2>
				<i class="topArrowP"><img src="<?=base_url()?>assets/graphics/topArrow.png" alt="Señalización" /></i>

					<!-- Tu comentario <fieldset>
						<label>Archivo SVG</label>
						<input type="file" name="archivo" />
					</fieldset>-->
					<fieldset>
						<select name="plaza" id="plaza">
							<option value="" checked>Seleccionar plaza</option>
							<? foreach($plaza as $rowP):?>
							<option value="<?= $rowP->clavePropiedad;?>"><?= $rowP->clavePropiedad;?> - <?= $rowP->propiedad;?></option>
							<? endforeach; ?>
						</select>
					</fieldset>
					<fieldset>
						<select name="piso" id="pisos">
							<option value="">Seleccionar piso</option>
						</select>
					</fieldset>
					<fieldset id="cam" class="mt5">
						<div class="containerS_two">
						  <span class="select-wrapper-two">
						    <input type="file" name="archivo" id="image_src_two">
						  </span>
						</div>
						<i id="addFot">Agregar archivo .svg</i>
					</fieldset>
					<fieldset>
						<input id="subPlan" class="mainBottonSma" type="submit" class="lightBot fright" value="Agregar" />
					</fieldset>
			</form>
			</div>
		</div>
	</div>

	<div class="wrapListForm" id="wrapListForm1">
	<table class="thbr" id="tablaPlano" >
		<thead>
			<tr>
				<th >Ciudad</th>
				<th>Rentados</th>
				<th>Disponibles</th>
				<th>Mantenimiento</th>
				<th>Apartados</th>
				<th>Pisos</th>
			</tr>
		</thead>
		<tbody>
			<? foreach($planos as $row):?>
				<tr class="plaza">
					<th class="pl10"><?= $row->plaza;?></th>
					<th class="pl10">8</th>
					<th class="pl10">9</th>
					<th class="pl10">2</th>
					<th class="pl10">10</th>
					<th id="asigPi">
						<ul>
							<? $list = $this->planogramas_model->cargarPisos($row->plaza);?>
						<? foreach($list as $l):?>
						<li><a href="<?=base_url()?>prospectos/cotizarLocal/<?= $l->id;?>" title="Planta Baja"><?= $l->piso;?></a></li>
						<? endforeach; ?></th>
						</ul>
					</th>
				</tr>
				<? endforeach; ?>
		</tbody>
	</table>
	<br class="clear">
	</div>

</div>


<script>
$(document).ready(function() {
    /*('#tablaPlano').dataTable( {
    	 columnDefs: {
            targets: [ 2 ],
            orderData: [ 4, 2 ]
        }
    });
    */

});
</script>
