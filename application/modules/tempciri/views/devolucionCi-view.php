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
	    <td class="grayField"><strong>Nombre:</strong></td>
			<td>
				<p><?= $ci[0]->pnombre . ' ' . $ci[0]->snombre . ' ' . $ci[0]->apellidopaterno . ' ' . $ci[0]->apellidomaterno;?></p>
			</td>
			<td class="grayField"><strong>Teléfono:</strong></td>
			<td><p><?= $ci[0]->telefono;?></p></td>
		</tr>
		<tr>
			<td class="grayField"><strong>Email:</strong></td>
			<td><p><?= $ci[0]->email;?></p></td>
			<td class="grayField"><strong>RFC:</strong></td>
			<td><p><?= $ci[0]->rfc;?></p></td>
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
	    <td class="grayField"><strong>Inicio:</strong></td>
			<td><p><?= $ci[0]->contraroInicioMes;?></p></td>
			<td class="grayField"><strong>Duración:</strong></td>
			<td><p><?= $ci[0]->contratoDuracion;?></p></td>
		</tr>
		<tr>
			<td class="grayField"><strong>Días de gracia:</strong></td>
			<td><p><?= $ci[0]->diasGracia;?></p></td>
			<td class="grayField"><strong>Local:</strong></td>
			<td><p><?= $ci[0]->local;?></p></td>
		</tr>
		<tr>
			<td class="grayField"><strong>Renta:</strong></td>
			<td><p><?= $ci[0]->renta;?></p></td>
			<td></td>
			<td></td>
		</tr>
		</tbody>
	</table>
	<br class="clear">
	</div>

	<div class="wrapListForm" id="wrapListForm3">
	<?= $this->session->flashdata('msg'); ?>
	<form method="post" action="<?= base_url();?>tempciri/functionCancelarCi" enctype="multipart/form-data">
		<fieldset id="archivoDevolucion">
			<span>Ficha de devolución</span>
			<input type="file" id="fichaDevolucion" name="fichaDevolucion" required/>
		</fieldset>
		<fieldset>
			<input type="hidden" name="ciId" value="<?= $ci[0]->id; ?>" />
			<button type="submit" class="mainBotton">Cancelar Documento</button>
		</fieldset>
	</form>
	<br class="clear">
	</div>
<br class="clear">
</div>