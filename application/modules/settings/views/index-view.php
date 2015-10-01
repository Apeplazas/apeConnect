<script>
$(document).ready(function(){
  $("#segmentos tr:even").addClass("even");
  $("#segmentos tr:odd").addClass("odd");
  
  	$(".nombreEstado").editInPlace({
		url: '<?=base_url()?>ajax/editZonaEstado',
		default_text: 'Seleccionar Estado',
		field_type: "select",
		bg_over: "none",
		select_options: "<?foreach($estados as $estado):?><?=$estado->nombreEstado;?>,<?endforeach;?>"
	});
  
});
</script>
<div>
	<div id="mainTit"><img src="http://www.apeplazas.com/obras/assets/graphics/proyectos-blackIcon.png" alt="Proyectos y Obras">Ajustes de Plazas en Sistema</div>
	<? $this->load->view('toolbar-settings');?>
	<table id="segZonas" class="dataTable">
		<thead>
			<tr>
				<th>Zona</th>
				<th>Código de Zona</th>
				<th>Estado</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($plazas as $plaza): ?>
				<script>
					$(document).ready(function(){
					  
					  	$("#nombreEstado<?=$plaza->idZona;?>").editInPlace({
							url: '<?=base_url()?>ajax/editZonaEstado/<?=$plaza->idZona;?>',
							default_text: '-----------------',
							field_type: "select",
							bg_over: "none",
							select_options: "<?foreach($estados as $estado):?><?=$estado->nombreEstado;?>,<?endforeach;?>"
						});
					  
					});
				</script>
				<tr>
					<th><?=$plaza->zona;?></th>
					<th><?=$plaza->zonaCodigo;?></th>
					<th><span id="nombreEstado<?=$plaza->idZona;?>"><?=$plaza->nombreEstado?></span></th>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<a class="fancy" href="#addPlaza">
	<span id="addSeg" class="mt10 fright redBoton"><em><img src="<?=base_url()?>assets/graphics/plus.png" alt="Agregar Segmento"></em>Agregar Plazas</span>
	</a>
</div>
<div id="addPlaza" style="display:none;">
	<h3>Agregar Plaza</h3>
	<form action="" method="post" id="agregarplaza">
		<fieldset>
			<label>Zona:</label>
			<input type="text" id="zona" name="zona" value=""/>
		</fieldset>
		<fieldset>
			<label>Código de Zona:</label>
			<input type="text" id="czona" name="czona" value=""/>
		</fieldset>
		<fieldset>
			<label>Estado:</label>
			<? foreach($estados as $estadosRow):?>
				<input type="radio" name="estado" value="<?= $estadosRow->idEstado?>"/>
				<i><?= $estadosRow->nombreEstado?></i>
			<?php endforeach;?>
		</fieldset>
		<fieldset>
			<input type="submit" value="Agregar" />
		</fieldset>
	</form>
</div>
<script>
  $(".fancy").fancybox({
			'scrolling'		: 'no',
			'titleShow'		: false
		});
</script>