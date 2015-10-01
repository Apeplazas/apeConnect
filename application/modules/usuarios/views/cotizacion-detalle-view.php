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
<div id="mainTit"><img src="http://www.apeplazas.com/obras/assets/graphics/proyectos-blackIcon.png" alt="Proyectos y Obras">Ya cotizaste este proyecto el cual fue:</div>
<strong id="titProyCot">Proyecto: <?=$cotizacion[0]->tituloProyecto;?></strong>
<div id="wrapTable">
<span id="head"></span>
<table id="tablaproveed" class="display dataTable no-footer" role="grid" aria-describedby="tablaproveed_info">
	<thead>
		<tr>
			<th class="sorting">Segmento</th>
			<th class="sorting">Cantidad</th>
			<th class="sorting">Precio Unitario</th>
			<th class="sorting">Total</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$subtotal = 0; 
		foreach($cotizacion as $cot):?>
			<tr>
				<th><?=$cot->seccionDesc;?></th>
				<th><?=$cot->cantidad;?></th>
				<th>$ <?=number_format($cot->precio_unitario,2);?></th>
				<th>$ <?=number_format($cot->segtotal,2);?></th>
			</tr>
		<?php $subtotal += $cot->segtotal;  
		endforeach;?>
	</tbody>
</table>
</div>
<ul class="totAco">
	<li>
		<strong>Subtotal</strong>
		<p>$ <?=number_format($subtotal,2);?></p>
	</li>
	<li>
		<strong>IVA 16%</strong>
		<p>$ <?=number_format($subtotal * .16,2)?></p>
	</li>
	<li>
		<strong>Total</strong>
		<p>$ <?=number_format($subtotal += $subtotal * .16,2)?></p>
	</li>
</ul>