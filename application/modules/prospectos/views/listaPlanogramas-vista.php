<div id="mainTit">
	<h3>Listado informativo de plazas.</h3>
</div>


<div class="wrapList">
	<div id="actions">
		<span class="back">
		 <a class="addSmall" href="javascript:window.history.go(-1);">
			 <i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/back.svg" alt="Regresar"></i>
			 <span>Regresar</span>
		 </a>
		</span>
	</div>

	<div class="wrapListForm" id="wrapListForm1">
		<table class="thbr" id="tablaPlano" >
			<thead>
				<tr>
					<th>Ciudad</th>
					<th>Rentados</th>
					<th>Disponibles</th>
					<th>Mantenimiento</th>
					<th>Apartados</th>
					<th>Pisos</th>
				</tr>
			</thead>
			<tbody>
				<? foreach($planos as $row):?>
					<tr>
						<th class="pl10"><?= $row->plaza;?></th>
						<th class="pl10">8</th>
						<th class="pl10">9</th>
						<th class="pl10">2</th>
						<th class="pl10">10</th>
						<th id="asigPi">
							<ul>
								<? $list = $this->planogramas_model->cargarPisos($row->plaza);?>
							<? foreach($list as $l):?>
							<li><a href="<?=base_url()?>prospectos/cotizarLocal/<?= $l->id;?>" title="Planta Baja"><?= $l->piso;?></a></li>
							<? endforeach; ?></th>
							</ul>
					</tr>
					<? endforeach; ?>
			</tbody>
		</table>
		<br class="clear">
	</div>
</div>


<script>
$(document).ready(function() {
    /*('#tablaPlano').dataTable( {
    	 columnDefs: {
            targets: [ 2 ],
            orderData: [ 4, 2 ]
        }
    });
    */

});
</script>
