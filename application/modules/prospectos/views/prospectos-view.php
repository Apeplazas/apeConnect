<h3 id="mainTit">Creando nuevo contacto</h3>
<div class="wrapList">

	<div id="actions">
		<a href="<?=base_url()?>prospectos/agregar" title="Agregar Contactos" class="addSmall">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Agregar Prospecto"></i>
			<span>Agregar Prospecto</span>
		</a>
	</div>

	<table id="tablaproveed">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Estado</th>
				<th><span class="Rtel">Telefono</span></th>
				<th>Correo</th>
				<th><span class="Rori">Origen de Cliente</span></th>
				<th>Estatus</th>
				<th>Fecha Creación</th>
                <th>Estatus de interés</th>
				<th></th>
				<!----<th></th>-->
			</tr>
		</thead>
		<tbody>
			<? foreach($prospectos as $p):?>
			<tr>
			  <th>
					<a class="Rema" href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>">
						<span class="bold"><?= $p->pnombre;?> <?= $p->snombre;?> <?= $p->apellidop;?> <?= $p->apellidom;?></span>
						<br><?= $p->correo;?>
					</a>
				</th>
			  <th><a href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>"><?= $p->estado?></a></th>
			  <th><a class="Rtel" href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>"><?= $p->telefono?> </a></th>
			  <th><a href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>"><?= $p->correo?></a></th>
			  <th><a class="Rori" href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>"><?= $p->origenCliente?></a></th>
			  <th><a class="Rsta" href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>"><?= ucfirst($p->status)?></a></th>
			  <th><?= $p->fechaCreacion?></th>
              <th><a><?= $p->statusProspecto?></a></th>
				<th><a class="editPros" href="<?=base_url()?>prospectos/editar/<?= $p->id;?>"><i class="iconEdit"><img src="<?=base_url()?>assets/graphics/svg/pencil.svg" alt="Editar"></i></a></th>
				<!----<th>
					<a href="<?=base_url()?>prospectos/cotizar/<?= $p->id;?>"><span class="addSmallGray">Cotizar</span></a>
				</th>-->
				<? endforeach; ?>
			</tr>
		</tbody>
	</table>

<script type="text/javascript">
$(document).ready(function() {
	/// Llama al plugin de datatables
    $('#tablaproveed').dataTable();
    "ordering": false
    /// Genera el even de cada lista
    $('.wrapListForm fieldset:even').addClass('evenBorder');
} );
</script>
</div>
