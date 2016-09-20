<div id="mainTit">
	<h3>Listado de Inmuebles</h3>
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
	<table class="thbr mt10" id="tablaPlano" >
		<thead>
			<tr>
				<th >Ciudad</th>
				<th>Predios</th>
				<th>Pisos</th>
				<th>m2</th>
				<th>Información niveles</th>
			</tr>
		</thead>
		<tbody>
			<? foreach($inmuebles as $row):?>
				<tr class="inmueble">
					<th class="pl10">
						<img src="<?=base_url()?>assets/graphics/<?= $row->status;?>-alert.png" />	<?= $row->Inmueble;?> - <?= $row->Nombre;?>
					</th>
					
					<? $predios = $this->cargas_model->cargarPredios($row->Inmueble, 'agrupar');?>
					<th class="pl10"><? foreach($predios as $pre):?><?= $pre->pisos;?><? endforeach; ?></th>
					
					<th class="pl10">9</th>
					<th class="pl10">2</th>
					<th id="asigPi">
						<ul>
						<? $pisos = '';?>
						<? if($pisos =''):?>
						<? foreach($pisos as $p):?>
						<li><a href="<?=base_url()?>planogramas/verplano/<?= $l->id;?>" title="Planta Baja"><?= $l->piso;?></a></li>
						<? endforeach; ?></th>
						<?endif;?>
						</ul>
					</th>
				</tr>
				<? endforeach; ?>
		</tbody>
	</table>
	<br class="clear">
	</div>
<br class="clear">
</div>



<style type="text/css" media="screen">
	.inmueble .pl10{padding:6px 10px!important}
</style>
