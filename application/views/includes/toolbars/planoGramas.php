<?php $user =	$this->session->userdata('usuario'); ?>
<!-- Toolbar para acciones-->
<div id="toolbar">
<ul id="planoAc">
	<? if($this->uri->segment(2) == ''):?>
	<li>
	<a class="botones <? if($this->uri->segment(2) == ''):?>actTool<?endif?>" href="<?=base_url()?>planogramas"><img src="<?=base_url()?>assets/graphics/verPlanoLista.png" alt="Lista de planogramas" /></a>
	</li>
	<li id="excelClick">
		<a class="addToolPlano" id="planMas"><span class="iconLista" title="Lista de Planogramas">Lista de Planogramas</span></a>
		
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
	
	
	
	<li>
	  <a class="addTool" href="<?=base_url()?>planogramas"><span class="iconLista" title="Lista de Planogramas">Lista de Planogramas</span></a>
	</li>
	
	<li>
	<a class="addTool <? if($this->uri->segment(2) == 'verplano'):?>actTool<?endif?>" href="<?=base_url()?>planogramas/verplano/<?= $this->uri->segment(3);?>"><span class="iconSee" title="Ver plano"></span></a>
	</li>
	
	<li>
		<a class="addTool <? if($this->uri->segment(2) == 'verplano' && $this->uri->segment(4) != ''):?>actTool<?endif?>" id="filtroTool"><span class="iconFiltro" title="Busqueda por informacion"></span></a>
		
		<div class="popupTwo" tabindex="-1">
			<div id="filtro">
			<form id="forma" method="post"  action="">
			<i class="topArrowfiltro"><img src="<?=base_url()?>assets/graphics/topArrowSmall.png" alt="Señalización" /></i>
			<fieldset>
				<label>Primer Segmento</label>
				<select class="busqueda" id="busquedaUno" name="primer" id="">
				</select>
			</fieldset>
			<fieldset>
				<label>Segundo Segmento</label>
				<select class="busqueda" id="busquedaDos" name="primer" id="">
					<option value="" checked>Selecciona la opcion deseada</option>
				</select>
			</fieldset>
			<fieldset>
				<label>Tercer Segmento</label>
				<select class="busqueda" id="busquedaTres" name="primer" id="">
					<option value="" checked>Selecciona la opción deseada</option>
					<option value="fechaEmision">Fecha Emision</option>
					<option value="importe">importe</option>
					<option value="Estatus">Estatus</option>
					<option value="Contrato">contrato</option>
				</select>
			</fieldset>
			<fieldset>
				<input id="subPlan" type="submit" value="Enviar" />
			</fieldset>
			</form>	
			<br class="clear">
			</div>
        </div>
	</li>
	
	<li>
		<a class="addTool" id="delTool"><span class="iconDelete" title="Borrar Planograma"></span></a>
		<div id="delVector" >
			<p><img src="<?=base_url()?>assets/graphics/alertDelete.png" alt="" /><strong>Esta seguro que quiere borrar el planograma</strong></p>
			<form action="<?= base_url();?>planogramas/borrarVector" method="post">
				<input type="hidden" name="vectorID" value="<?= $this->uri->segment(3);?>"/>
				<span id="canDel" class="lightBotOut mr10" >CANCELAR</span>
				<input type="submit" class="lightBot" value="Borrar" />
			</form>
		</div>
	</li>
	<li>
		<a class="addTool <? if($this->uri->segment(2) == 'crearLocal'):?>actTool<?endif?>" href="<?=base_url()?>planogramas/crearLocal/<?= $this->uri->segment(3);?>" id="delTool"><span class="iconPlusPlano" title="Crear Local"></span></a>
	</li>
	
	<li>
	<a class="addTool <? if($this->uri->segment(2) == 'infoplano'):?>actTool<?endif?>" href="<?=base_url()?>planogramas/infoplano/<?= $this->uri->segment(3);?>"><span class="iconEditPlano" title="Editar Planograma"></span></a>
	</li>
	<? endif?>
</ul>
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
	$("#busquedaUno").append("<option checked>Selecciona la opción deseada</option>");
	$.each (info, function(key,val){
		$("#busquedaUno").append(" \
			<option value='"+val+"'> "+val+"</option> \
		");
	});	
}});
	
		
$("#busquedaUno").change(function() {
	var value = $(this).val();
	$("#busquedaDos").html('');
	$("#busquedaDos").append("<option checked>Selecciona la opción deseada</option>");
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
	$("#busquedaTres").append("<option checked>Selecciona la opción deseada</option>");
	$.each (info, function(key,val){
		if (value != val && val != $("#busquedaUno").val()){
		$("#busquedaTres").append(" \
			<option value='"+val+"'> "+val+"</option> \
		");
		}
	});	
		
});
</script>