<script>
	$(document).ready(function() {
    $('#tablaproveed').dataTable( {
    	 columnDefs: {
            targets: [ 2 ],
            orderData: [ 4, 2 ]
        }
    });
});
</script>
	<div id="mainTit"><img src="http://www.apeplazas.com/obras/assets/graphics/perfil.png" alt="Proyectos y Obras">Listado de cotizaciones por proveedor</div>
	<div id="wrapTable">
	<span id="head"></span>
	<table id="tablaproveed" class="display">
		<thead> 
			<tr>
				<th>Cotización del proveedor</th>
				<th>Proyecto</th> 
				<th>Total de la Cotización</th> 
				<th>Fecha</th>
			</tr> 
		</thead> 
		<tbody>
			<?php foreach($cotizaciones as $cot):?>
				<tr>
					<th><a href="<?=base_url()?>cotizaciones/ver/<?=$cot->id;?>"><?=$cot->razonSocial;?></a></th>
					<th><a href="<?=base_url()?>cotizaciones/ver/<?=$cot->id;?>"><?=$cot->tituloProyecto;?></a></th> 
					<th><a href="<?=base_url()?>cotizaciones/ver/<?=$cot->id;?>">$ <?=number_format($cot->total += $cot->total*.16,2);?></a></th>
					<th><a href="<?=base_url()?>cotizaciones/ver/<?=$cot->id;?>"><?=$cot->fechaCotizacion;?></a></th>
				</tr> 	
			<?php endforeach;?>
		</tbody> 
	</table>
	</div>