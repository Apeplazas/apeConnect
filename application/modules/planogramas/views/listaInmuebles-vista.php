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
				<th>IATA</th>
				<th>Predios</th>
				<th>Pisos</th>
				<th>m2</th>
				<th>Información niveles</th>
			</tr>
		</thead>
		<tbody>
			<? foreach($inmuebles as $row):?>
				<tr class="inmueble" onclick="$('.<?= $row->Inmueble;?>').toggle(); return false;">
					<th class="pl10">
						<img src="<?=base_url()?>assets/graphics/<?= $row->status;?>-alert.png" />	<?= $row->Inmueble;?> - <?= $row->Nombre;?>
					</th>
					<th><?= $row->claveCiudad;?> </th>
					<? $predios = $this->planogramas_model->cargarPredios($row->Inmueble, 'agrupar');?>
					<th class="pl10"><? foreach($predios as $pre):?><?= $pre->predios;?><? endforeach; ?></th>
					<th class="pl10"><? foreach($predios as $pis):?><?= $pis->pisos;?><?endforeach;?></th>
					<? $metrosCubicos = $this->planogramas_model->cargarPredios($row->Inmueble, '');?>
					<th class="pl10">
						<? $sum = 0; ?>
						<? foreach($metrosCubicos as $m2):?>
						<? $sum += $m2->superficieTerreno;?>
						<?endforeach;?>
						<?=$sum?>
					</th>
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
				
				<tr class="none <?= $row->Inmueble;?>">
					<th colspan="6" align="center">
						
						
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
