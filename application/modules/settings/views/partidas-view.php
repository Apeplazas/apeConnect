<script>
$(document).ready(function(){
  $("#segmentos tr:even").addClass("even");
  $("#segmentos tr:odd").addClass("odd");
});
</script>
<div id="wrapUnid">
	<div id="mainTit"><img src="http://www.apeplazas.com/obras/assets/graphics/proyectos-blackIcon.png" alt="Proyectos y Obras">Ajustes de Unidades en Sistema</div>
	<? $this->load->view('toolbar-settings');?>
	<table id="unidades" class="dataTable">
		<thead>
			<th>Nombre</th>
		</thead>
		<tbody>
			<?php foreach($partidas as $partida):?>
				<tr>
					<th><?=$partida->nombre;?></th>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<a class="fancy" href="#addUnidad">
	<span id="addSeg" class="mt10 fright redBoton mb20"><em><img src="<?=base_url()?>assets/graphics/plus.png" alt="Agregar Segmento"></em>Agregar Partida</span>
	</a>

</div>
<div id="addUnidad" style="display:none;">
	<h3>Agregar Unidad</h3>
	<form action="" method="post" id="agregarpartida">
		<fieldset>
			<label>Nombre:</label>
			<input class="inBut" type="text" id="pnombre" name="pnombre" value=""/>
		</fieldset>
		<fieldset>
			<label>Clave:</label>
			<input class="inBut" type="text" id="pclave" name="pclave" value=""/>
		</fieldset>
		<fieldset>
			<input class="blackBoton fright" type="submit" value="Agregar" />
		</fieldset>
	</form>
</div>

<script>
$(".fancy").fancybox({
	'scrolling'		: 'no',
	'titleShow'		: false
});
</script>