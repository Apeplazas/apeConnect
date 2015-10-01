<img src="<?= base_url();?>assets/graphics/ape_logo.png" />
<table>
	<thead>
  		<tr>
     		<th>Pos</th>
     		<th>Cantidad</th>
     		<th>Concepto</th>
     		<th>Listado de precios</th>
     		<th>Sub total</th>
     		<th>Descueno</th>
     		<th>Precio sin iva</th>
     		<th>Impuesto (%)</th>
     		<th>Impuesto (MXN)</th>
     		<th>Total</th>
  		</tr>
 	</thead>
 	<tbody>
 		<?php foreach($locales as $local):?>
 			<tr>
 				<?php foreach($local as $data):?>
 					<th><?php echo $data;?></th>
 				<?php endforeach;?>
 			</tr>
 		<?php endforeach;?>
 	</tbody>
</table>
