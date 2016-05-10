<script>
	$(document).ready(function() {
    $('#tablaproveed').dataTable( {
    });
});
</script>
<? foreach($profile as $row):?>
	<div id="headTwo">
	<span><img src="<?=base_url()?>assets/graphics/listado.png" alt="Lista" /></span><strong>Listado de proveedores</strong>
	</div>
	<table id="tablaproveed" class="display">
		<thead> 
			<tr>
				<th></th>
				<th>Razon Social</th> 
				<th>Representante Legal</th> 
				<th>Tipo de Registro</th> 
				<th>Status</th>
				<th></th>
			</tr> 
		</thead> 
		<tbody>
			<?php foreach($proveedores as $proveedor):?>
				<tr>
					<th><a href="<?=base_url()?>admin/borrarProveedor/<?=$proveedor->idProveedor;?>"><img src="<?=base_url()?>assets/graphics/borrar.png" alt="Borrar Proveedor" /></a></th>
					<th><?=$proveedor->razonSocial;?></th> 
					<th><?=$proveedor->representanteLegal;?></th> 
					<th><?=$proveedor->tipoRegistro;?></th> 
					<th><?=$proveedor->statusProveedor;?></th>
					<th><a href="<?=base_url()?>admin/info/<?=$proveedor->fancyUrl;?>"><img src="<?=base_url()?>assets/graphics/vermas.png" alt="Ver mas" /></a></th>
				</tr>
			<?php endforeach;?>
		</tbody> 
	</table>
<? endforeach; ?>