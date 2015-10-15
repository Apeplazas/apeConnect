<h3 id="mainTit">Cartas de intención</h3>
<div class="wrapList">

	<div id="actions">
		<a href="<?=base_url()?>tempCiri/ciRi" title="Generar carta intencion" class="addSmall">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Generar carta intencion"></i>
			<span>Generar Carta</span>
		</a>
	</div>

	<table id="tablaproveed">
		<thead>
			<tr>
				<th>Folio</th>
				<th>Plaza</th>
				<th>Usuario</th>
				<th>Cliente</th>
				<th>Estatus</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<? foreach($cis as $ci):?>
			<tr>
			  <th><?= $ci->folio?></th>
			  <th><?= $ci->plazaNombre?></th>
			  <th><?= $ci->nombreCompleto?></th>
			  <th><?= $ci->pnombre;?> <?= $ci->snombre;?> <?= $ci->apellidopaterno;?> <?= $ci->apellidomaterno;?></th>

			  <?php if($ci->estado == 'Activo'):?>
					<th>
						<a href="<?= base_url();?>tempciri/cancelarCi/<?=$ci->id;?>" title="<?=$ci->id;?>">CANCELAR</a>
					</th>
			  <?php else:?>
			  	<th><span class="alertTab" >CANCELADO</span></th>
			  <?php endif;?>
				<th>
					<a class="svgPdf" href="<?=URLPDF . 'CI_' . $ci->id . '.pdf';?>" >
					<img src="<?=base_url()?>assets/graphics/svg/pdf.svg" alt="Ver documento">
					<span><?= $ci->pdf?></span>
				</a>
				</th>
			  <? endforeach; ?>
			</tr>
		</tbody>
	</table>

<script type="text/javascript">
$(document).ready(function() {
		/// Llama al plugin de datatables
		$('#tablaproveed').dataTable( {
		  "iDisplayLength": 20
		});
    /// Genera el even de cada lista
    $('.wrapListForm fieldset:even').addClass('evenBorder');

} );
</script>
</div>
