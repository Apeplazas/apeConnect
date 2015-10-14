<div id="mainTit">
	<h3>Cancelación de recibo de intención</h3>
</div>

<div class="wrapList">
	<div id="actions">
		<span class="back">
		 <a class="addSmall" href="javascript:window.history.go(-1);">
			 <i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/back.svg" alt="Regresar"></i>
			 <span>Regresar</span>
		 </a>
		</span>
	</div>

	<div class="wrapListForm" id="wrapListForm1">
	<table>
		<thead>
	  <tr>
	    <th colspan="4">Cliente</th>
	  </tr>
		</thead>
		<tbody>
	  <tr>
	    <td class="grayField">Nombre:</td>
			<td><?= $ci[0]->pnombre . ' ' . $ci[0]->snombre . ' ' . $ci[0]->apellidopaterno . ' ' . $ci[0]->apellidomaterno;?></td>
			<td class="grayField">Teléfono:</td>
			<td><?= $ci[0]->telefono;?></td>
		</tr>
		<tr>
			<td class="grayField">Email:</td>
			<td><?= $ci[0]->email;?></td>
			<td class="grayField">RFC:</td>
			<td><?= $ci[0]->rfc;?></td>
		</tr>
		</tbody>
	</table>
	<br class="clear">
	</div>

	<div class="wrapListForm" id="wrapListForm2">
	<table>
		<thead>
	  <tr>
	    <th colspan="4">Contrato</th>
	  </tr>
		</thead>
		<tbody>
	  <tr>
	    <td class="grayField">Inicio:</td>
			<td><?= $ci[0]->contraroInicioMes;?></td>
			<td class="grayField">Duración:</td>
			<td><?= $ci[0]->contratoDuracion;?></td>
		</tr>
		<tr>
			<td class="grayField">Días de gracia:</td>
			<td><?= $ci[0]->diasGracia;?></td>
			<td class="grayField">Local:</td>
			<td><?= $ci[0]->local;?></td>
		</tr>
		<tr>
			<td>Renta:</td>
			<td><?= $ci[0]->renta;?></td>
			<td></td>
			<td></td>
		</tr>
		</tbody>
	</table>
	<br class="clear">
	</div>

		<?= $this->session->flashdata('msg'); ?>
		<form method="post" action="<?= base_url();?>tempciri/functionCancelarCi" enctype="multipart/form-data">
		<fieldset>
			<label for="exampleInputPassword1">Motivo de cancelación</label>
			<textarea class="form-control uppercase" name="motivoCancelacion" required></textarea>
		</fieldset>
		<fieldset>
			<span>
			  <input type="checkbox" name="devolucionOn" id="devolucionOn"> Devolución
			</span>
		</fieldset>
		<fieldset id="archivoDevolucion" style="display:none;">
			<label for="exampleInputFile">Ficha de devolución</label>
			<input type="file" id="fichaDevolucion" name="fichaDevolucion" />
		</fieldset>
		<fieldset>
			<input type="hidden" name="ciId" value="<?= $ci[0]->id; ?>" />
			<button type="submit" class="btn btn-default">Cancelar Documento</button>
		</fieldset>
	</form>
</div>

<script>
	 $('#devolucionOn').change(function() {
        if($(this).is(":checked")) {
            $('#archivoDevolucion').show();
        }else{
        	$('#archivoDevolucion').hide();
        }
    });
</script>
