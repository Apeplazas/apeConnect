<script>
	$(document).ready(function() {
      $('#tablaproveed').dataTable( {
    });
});
</script>
<div id="mainTit"><img src="<?=base_url()?>assets/graphics/perfil.png" alt="Proyectos y Obras">Listado de proveedores</div>
<? foreach($profile as $row):?>
	<div id="wrapTable">
	<span id="head"></span>
	<table id="tablaproveed" class="display">
		<thead> 
			<tr>
				<th class="acc"></th>
				<th>Razon Social</th> 
				<th>Representante Legal</th> 
				<th>Tipo de Registro</th> 
				<th>Status</th>
				
			</tr> 
		</thead> 
		<tbody>
			<?php foreach($proveedores as $proveedor):?>
				<tr>
					<th class="acc"><a href="<?=base_url()?>admin/borrarProveedor/<?=$proveedor->idProveedor;?>"><img src="<?=base_url()?>assets/graphics/deleteRow.png" alt="Borrar Proveedor" /></a></th>
					<th><a href="<?=base_url()?>admin/info/<?=$proveedor->fancyUrl;?>"><?=$proveedor->razonSocial;?></a></th> 
					<th><a href="<?=base_url()?>admin/info/<?=$proveedor->fancyUrl;?>"><?=$proveedor->representanteLegal;?></a></th> 
					<th><a href="<?=base_url()?>admin/info/<?=$proveedor->fancyUrl;?>"><?=$proveedor->tipoRegistro;?></a></th> 
					<th><a href="<?=base_url()?>admin/info/<?=$proveedor->fancyUrl;?>"><?=$proveedor->statusProveedor;?></a></th>
				</tr>
			<?php endforeach;?>
		</tbody> 
	</table>
	</div>
<? endforeach; ?>