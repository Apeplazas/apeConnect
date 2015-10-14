<h3 id="mainTit">Cartas de intención</h3>
<div class="wrapList">

	<div id="actions">
	
	</div>

	<table id="tablaproveed">
		<thead>
			<tr>
				<th>Folio</th>
				<th>plaza</th>
				<th>Usuario</th>
				<th>Cliente</th>
				<th>Pdf</th>
				<th>x</th>
			</tr>
		</thead>
		<tbody>
			<? foreach($cis as $ci):?>
			<tr>
			  <th><?= $ci->folio?></th>
			  <th><?= $ci->plazaNombre?></th>
			  <th><?= $ci->nombreCompleto?></th>
			  <th><?= $ci->pnombre;?> <?= $ci->snombre;?> <?= $ci->apellidopaterno;?> <?= $ci->apellidomaterno;?></th>
			  <th><a href="<?=URLPDF . 'CI_' . $ci->id . '.pdf';?>" ><?= $ci->pdf?> </a></th>
			  <?php if($ci->estado == 'Activo'):?>
			  	<th><a href="<?= base_url();?>tempciri/cancelarCi/<?=$ci->id;?>" title="<?=$ci->id;?>">Cancelar</a></th>
			  <?php else:?>
			  	<th>CANCELADO</th>
			  <?php endif;?>
			  <? endforeach; ?>
			</tr>
		</tbody>
	</table>

<script type="text/javascript">
$(document).ready(function() {
	/// Llama al plugin de datatables
    $('#tablaproveed').dataTable();
    /// Genera el even de cada lista
    $('.wrapListForm fieldset:even').addClass('evenBorder');

} );
</script>
</div>
