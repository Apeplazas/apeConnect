<h3 id="mainTit">Recibos Internos</h3>
<div class="wrapList">

	<div id="actions">
		<a class="btn btn-default btn-lg" href="<?= base_url();?>tempciri/verci">Ver Cartas de Intención</a>
	</div>

	<table id="tablaproveed">
		<thead>
			<tr>
				<th>Folio</th>
				<th>Cliente</th>
				<th>Pdf</th>
				<th>Estatus</th>
			</tr>
		</thead>
		<tbody>
			<? foreach($ris as $ri):?>
			<tr>
			  <td><?= $ri->folio?></td>
			  <td><?= $ri->pnombre;?> <?= $ri->snombre;?> <?= $ri->apellidopaterno;?> <?= $ri->apellidomaterno;?></td>
			  <td><a href="<?=URLPDF . 'RI_' . $ri->id . '.pdf';?>" ><?= $ri->pdf?> </a></td>
			  <?php if($ri->estado == 'Activo'):?>
			  	<td><a href="<?= base_url();?>tempciri/cancelarRi/<?=$ri->id;?>">CANCELAR</a></td>
			  <?php else:?>
			  	<td>CANCELADO</td>
			  <?php endif;?>
			  <? endforeach; ?>
			</tr>
		</tbody>
	</table>

<script type="text/javascript">
$(document).ready(function() {
	/// Llama al plugin de datatables
		$('#tablaproveed').dataTable( {
			"iDisplayLength": 50
		});
    /// Genera el even de cada lista
    $('.wrapListForm fieldset:even').addClass('evenBorder');

    $('.cancelarCi').click(function(){
    	if(confirm('¿Estas seguro de cancelar el documento?')){
    		var riId = $(this).attr('title');
			$.ajax({
				data : {'riId':riId},
				dataType : 'json',
				url : ajax_url + 'cancelarRi',
				type : 'post',
				success : function(response) {
					window.location.reload();
				}
			});
		}
    });

} );

</script>
</div>
