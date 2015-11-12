<div id="mainTit">
	<h3>Detalle de carta de intención</h3>
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
	    <th colspan="4">General</th>
	  </tr>
		</thead>
		<tbody>
	  <tr>
	    <td class="grayField"><strong>Nombre del vendedor:</strong></td>
			<td>
				<p><?= $ci[0]->vendedorNombre;?></p>
			</td>
			<td class="grayField"><strong>Plaza:</strong></td>
			<td><p><?= $ci[0]->plazaNombre;?></p></td>
		</tr>
		</tbody>
	</table>
	<br class="clear">
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
	
	<div class="wrapListForm" id="wrapListForm1">
	<table>
		<thead>
	  <tr>
	    <th colspan="4">Depositos</th>
	  </tr>
		</thead>
		<tbody>
		<?php $depositos = $this->tempciri_model->traerDepositosCi($ci[0]->id);?>
		<?php foreach($depositos as $dep):?>
	  	<tr>
	    	<td class="grayField"><strong>Archivo de <?= $dep->reciboTipo; ?>:</strong></td>
			<td>
				<p><a href="<?= URLCIDOCS . $dep->archivo;?>" >Ver Archivo</a></p>
			</td>
		</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<br class="clear">
	</div>
	
	<div class="wrapListForm" id="wrapListForm1">
	<table>
		<thead>
	  <tr>
	    <th colspan="4">Documentos</th>
	  </tr>
		</thead>
		<tbody>
		<?php $documentos = $this->tempciri_model->traerDocumentosCi($ci[0]->id);?>
		<?php foreach($documentos as $doc):?>
	  	<tr>
	    	<td class="grayField"><strong>Archivo de <?= $doc->docTipo; ?>:</strong></td>
			<td>
				<p><a href="<?= URLCIDOCS . $doc->archivoNombre;?>" >Ver Archivo</a></p>
			</td>
		</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<br class="clear">
	</div>

<br class="clear">
</div>