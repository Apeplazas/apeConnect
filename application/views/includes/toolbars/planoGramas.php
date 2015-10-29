<?php $user =	$this->session->userdata('usuario'); ?>
<!-- Toolbar para acciones-->
<div id="toolbarPlan">
<ul id="planoAc">
	<? if($this->uri->segment(2) == ''):?>
	<li>
	<a class="botones <? if($this->uri->segment(2) == ''):?>actTool<?endif?>" href="<?=base_url()?>planogramas"><img src="<?=base_url()?>assets/graphics/verPlanoLista.png" alt="Lista de planogramas" /></a>
	</li>
	<li id="excelClick">


		<a class="addSmallPlano" id="planMas"><span class="iconLista" title="Lista de Planogramas">Lista de Planogramas</span></a>

		<div id="addPlaza" style="display:none;">
		<form id="formPlano" action="<?= base_url();?>planogramas/subirPlano" method="post" enctype="multipart/form-data">
			<i class="topArrowP"><img src="<?=base_url()?>assets/graphics/topArrow.png" alt="Señalización" /></i>

				<fieldset id="cam" class="mt5">
					<div class="containerS_two">
					  <span class="select-wrapper-two">
					    <input type="file" name="archivo" id="image_src_two">
					  </span>
					</div>
					<i id="addFot">Agregar archivo .svg</i>
				</fieldset>

				<!-- Tu comentario <fieldset>
					<label>Archivo SVG</label>
					<input type="file" name="archivo" />
				</fieldset>-->
				<fieldset>
					<label>Plaza</label>
					<select name="plaza" id="plaza">
						<option value="" checked>Seleccione la Zona</option>
						<? foreach($plaza as $rowP):?>
						<option value="<?= $rowP->zona;?>"><?= $rowP->zona;?> - <?= $rowP->zonaCodigo;?></option>
						<? endforeach; ?>
					</select>
				</fieldset>
				<fieldset>
					<label>
						Piso
					</label>
					<select name="piso" id="pisos">
						<option value="">Seleccione una plaza</option>
					</select>
				</fieldset>
				<fieldset>
					<input type="submit" class="lightBot fright" value="Agregar" />
				</fieldset>
		</form>
		</div>


	</li>
	<? else:?>

	<? if($this->uri->segment(2) == 'infoplano'):?>
	<li>
		<a class="addSmall <? if($this->uri->segment(2) == 'crearLocal'):?>actTool<?endif?>" href="<?=base_url()?>planogramas/crearLocal/<?= $this->uri->segment(3);?>">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Generar Grafica de Local"></i>
			<span class="iconPlusPlano" title="Crear Local">Generar Local</span>
		</a>
	</li>
	<?endif;?>

	<li>
		<a class="addSmall <?if($this->uri->segment(2) == 'verplano' && $this->uri->segment(4) != ''):?>actTool<?endif?>" id="filtroTool">
			<i class="iconFiltro iconPlus"><img src="<?=base_url()?>assets/graphics/svg/busquedaInfo.svg" alt="Busqueda de información"></i>
			<span>Filtros</span>
		</a>

		<div id="filtro" class="popupTwo" tabindex="-1">
			<div>
			<form id="forma" method="post"  action="">
				<h2>Opciones de vista</h2>
				<i class="topArrowP">
					<img src="<?=base_url()?>assets/graphics/topArrow.png" alt="Señalización">
				</i>
			<fieldset>
				<select class="busqueda" id="busquedaUno" name="primer" id=""></select>
			</fieldset>
			<fieldset>
				<select class="busqueda" id="busquedaDos" name="primer" id="">
					<option value="" checked>Segunda opción</option>
				</select>
			</fieldset>
			<fieldset>
				<select class="busqueda" id="busquedaTres" name="primer" id="">
					<option value="" checked>Tercera opción</option>
					<option value="fechaEmision">Fecha Emision</option>
					<option value="importe">importe</option>
					<option value="Estatus">Estatus</option>
					<option value="Contrato">contrato</option>
				</select>
			</fieldset>
			<fieldset>
				<input id="subPlan" class="mainBottonSma" type="submit" value="Enviar" />
			</fieldset>
			</form>
			<br class="clear">
			</div>
    </div>
	</li>
	<li>
		<a href="<?=base_url()?>planogramas" title="Listado de planogramas" class="addSmall">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/mapBlanco.svg" alt="Lista de planogramas"></i>
			<span>Planogramas</span>
		</a>
	</li>

	<? if($this->uri->segment(2) != 'infoplano'):?>
	<li>
	<a class="<? if($this->uri->segment(2) == 'infoplano'):?>actTool<?endif?>" href="<?=base_url()?>planogramas/infoplano/<?= $this->uri->segment(3);?>">
		<i class="iconEditT">
			<img src="<?=base_url()?>assets/graphics/svg/pencilW.svg" alt="Editar Planograma">
		</i>
		<span class="iconEditPlano" title="Editar Planograma"></span>
	</a>
	</li>
	<?endif;?>

	<li>
		<a id="delTool">
			<i class="iconDeleteT"><img src="<?=base_url()?>assets/graphics/svg/borrar.svg" alt="Borrar Planograma"></i>
		</a>
	</li>
	<? endif?>
</ul>

<div id="delVector" >
	<strong>Esta seguro que quiere borrar el planograma</strong>
	<form action="<?= base_url();?>planogramas/borrarVector" method="post">
		<input type="hidden" name="vectorID" value="<?= $this->uri->segment(3);?>"/>
		<span class="lightBotOut mr10 darkBottom" >CANCELAR</span>
		<input id="canDel"  type="submit" value="Borrar" />
	</form>
</div>

</div>

<!-- Manda la busqueda de segmento al seleccionar el filtro -->
<script type="text/javascript">
$(".busqueda").change(function() {
	var action = $("#busquedaUno").val() + "/" +$("#busquedaDos").val() + "/" +$("#busquedaTres").val();
	$("#forma").attr("action", "<?=base_url()?>planogramas/verplano/<?=$this->uri->segment(3)?>/" + action);
});
</script>


<script type="text/javascript">
var info;
  $.ajax({url: "<?=base_url()?>ajax/formValores", dataType:"json", success: function(data)
  {
	info=data;
	$("#busquedaUno").append("<option checked>Primera opción</option>");
	$.each (info, function(key,val){
		$("#busquedaUno").append(" \
			<option value='"+val+"'> "+val+"</option> \
		");
	});
}});


$("#busquedaUno").change(function() {
	var value = $(this).val();
	$("#busquedaDos").html('');
	$("#busquedaDos").append("<option checked>Segunda opción</option>");
	$.each (info, function(key,val){
		if (value != val){
		$("#busquedaDos").append(" \
			<option value='"+val+"'> "+val+"</option> \
		");
		}
	});

});
$("#busquedaDos").change(function() {
	var value = $(this).val();
	$("#busquedaTres").html('');
	$("#busquedaTres").append("<option checked>Tercera opción</option>");
	$.each (info, function(key,val){
		if (value != val && val != $("#busquedaUno").val()){
		$("#busquedaTres").append(" \
			<option value='"+val+"'> "+val+"</option> \
		");
		}
	});

});
</script>
