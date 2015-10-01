<h3 id="mainTit">Creando nuevo contacto</h3>
<div class="wrapList">
	
	<div id="actions">
		<a href="<?=base_url()?>prospectos/agregar" title="Agregar Contactos" class="addSmall"><i class="iconPlus">Agregar</i>Agregar Prospecto</a>
	</div>
	
	<table id="tablaproveed">
		<thead> 
			<tr>
				<th>&nbsp</th>
				<th>Nombre</th>
				<th>Estado</th>
				<th>Telefono</th>
				<th>Correo</th>
				<th>Origen de Cliente</th>
				<th></th>
			</tr> 
		</thead> 
		<tbody>
			<? foreach($prospectos as $p):?>
			<tr>
			  <th><a class="editPros" href="<?=base_url()?>prospectos/editar/<?= $p->id;?>"><i class="iconEdit">Editar</i></a></th>
			  <th><a href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>"><span class="bold"><?= $p->pnombre;?> <?= $p->snombre;?> <?= $p->apellidop;?> <?= $p->apellidom;?></span><br><?= $p->correo;?></a></th>
			  <th><a href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>"><?= $p->estado?></a></th>
			  <th><a href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>"><?= $p->telefono?> </a></th>
			  <th><a href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>"><?= $p->correo?></a></th>
			  <th><a href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>"><?= $p->origenCliente?></a></th>
			  <th><a href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>"><?= ucfirst($p->status)?></a></th>
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
