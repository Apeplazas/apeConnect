<script>
	$(document).ready(function() {
    $('#tablaproveed').dataTable( {
    	 columnDefs: {
            targets: [ 2 ],
            orderData: [ 4, 2 ]
        }
    }).rowGrouping({bExpandableGrouping: true});
    
});
</script>
<div id="mainTit"><img src="http://www.apeplazas.com/obras/assets/graphics/perfil.png" alt="Proyectos y Obras">Proveedor: <?=$cotizacion[0]->razonSocial;?></div>
<div id="toolbar">
<ul>
	<li id="excelClick">
		<a class="botones" href="<?=base_url()?>cotizaciones/exportarExcel/<?=$cotizacion[0]->id;?>" title="Importar y Exportar Excel"><img src="<?=base_url()?>assets/graphics/excel.png" alt="Importar y Exportar Excel" /> <em class="excelExp">Exportar excel</em></a>
	</li>
</ul>
</div>
<strong id="titProyCot">Proyecto Cotizado:<?=$cotizacion[0]->tituloProyecto;?></strong>
<div id="wrapTable">
<span id="head"></span>
<table id="tablaproveed" class="display dataTable no-footer" role="grid" aria-describedby="tablaproveed_info">
	<thead>
		<tr>
			<th>Partida</th>
			<th class="sorting">Segmento</th>
			<th class="sorting"><p class="tcenter">Cantidad</p></th>
			<th class="sorting"><p class="tcenter">Precio Unitario</p></th>
			<th class="sorting"><p class="tcenter">Total</p></th>
		</tr>
	</thead>
	<tbody>
		<?php $subtotal = 0; $partidaNombre = null;
		foreach($cotizacion as $cot):?>
			<tr>
			<? $obs = $this->cotizaciones_model->traeobservaciones($cot->idSegmento,$usuarioId);?>
				<th><img src="<?=base_url()?>assets/graphics/bullet-cat.png" alt="" /><?=$cot->nombre?></th>
				<th>
				<p class="desCot"><?=$cot->seccionDesc;?></p>
				<? foreach($obs as $rowO):?>
				<em class="obs"><?= $rowO->observacion;?></em>
				<? endforeach; ?>
				</th>
				<th><p class="tcenter"><?=$cot->cantidad . ' ' .$cot->simbolo;?></p></th>
				<th><p class="tcenter">$ <?=number_format($cot->precio_unitario,2);?></p></th>
				<th><p class="tcenter">$ <?=number_format($cot->segtotal,2);?></p></th>
			</tr>
			<?php $subtotal += $cot->segtotal; 
		endforeach;?>
	</tbody>
</table>
</div>

<? if($cotizacion[0]->matrizDesglose):?>
	<h4 id="titMatriz">Matriz de desglose</h4>
	<a class="archivo" href="<?=URLCOTIZ.$cotizacion[0]->matrizDesglose;?>"><img src="<?=base_url()?>assets/graphics/abrirArchivo.png" alt="Abrir Archivo" /> <b>Abri archivo - </b> <em><?=$cotizacion[0]->matrizDesglose;?></em></a>

<? endif;?>

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
	<li>
		<form method="post" action="<?=base_url()?>cotizaciones/asignarProyecto">
			<input type="hidden" name="proyectoId" value="<?=$cotizacion[0]->idproyecto;?>" />
			<input type="hidden" name="proveedorId" value="<?=$cotizacion[0]->idproveedor;?>" />
			<input class="fleft greenBotonForm ml10" type="submit" value="Asignar Proyecto" />
		</form>
	</li>
</ul>

