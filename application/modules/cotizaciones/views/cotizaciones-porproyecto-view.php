<script>
	$(document).ready(function() {
    $('#tablaproveed').dataTable( {
    	 
    });
});
</script>
<div id="wrapTable">
	<span id="head"></span>
	<table id="tablaproveed" class="display">
		<thead> 
			<tr>
				<th>Proyecto</th>
				<th>Número de Cotizaciones</th>
				<th>Cotización minima</th>
				<th>Cotización maxima</th> 
			</tr> 
		</thead> 
		<tbody>
			<?php foreach($cotizaciones as $cot):?>
				<tr>
					<th><a href="<?=base_url()?>cotizaciones/ver_proyecto/<?=$cot->id;?>"><?=$cot->tituloProyecto;?></a></th>
					<th><a href="<?=base_url()?>cotizaciones/ver_proyecto/<?=$cot->id;?>"><?=$cot->ncot;?></a></th>
					<th><a href="<?=base_url()?>cotizaciones/ver_proyecto/<?=$cot->id;?>">$ <?=number_format($cot->cmin += $cot->cmin*.16,2);?></a></th> 
					<th><a href="<?=base_url()?>cotizaciones/ver_proyecto/<?=$cot->id;?>">$ <?=number_format($cot->cmax += $cot->cmax*.16,2);?></a></th>
				</tr> 	
			<?php endforeach;?>
		</tbody> 
	</table>
</div>