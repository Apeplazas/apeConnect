<?php $obras = $this->proyecto_model->buscaProyectosSupervisor($userID);?>
<script>
/********************************************************************************************************************
Calendario
********************************************************************************************************************/
var dateObject = null;
$('#fechaCierre').datepicker({
	inline:false,
	minDate:'+1d',  //d m w y
	defaultDate:'+1d',
	'dateFormat': 'mm/dd/yy'
});	
$(".fancy").fancybox({
	'scrolling'		: 'no',
	'titleShow'		: null,
	'onClosed'		: function() {
		$("#login_error").hide();
	}
});

	$(document).ready(function() {
	    $('#tablaproveed').dataTable({
	    	"bPaginate": false,
    	});
    	
    	$("#datepicker").datepicker({ 
    		dateFormat: 'yy-mm-dd',
    		onSelect: function(){ 
		        var dateObject = $(this).datepicker('getDate'); 
		    } 
    	});
    	
  
	});
</script>
<div id="mainTit"><img src="<?=base_url()?>assets/graphics/proyectos-blackIcon.png" alt="Proyectos y Obras" />Tus Obras y Proyectos</div>
<?= $this->session->flashdata('msg'); ?>
<?= $this->load->view('includes/menus/toolbar');?>
<form id="wrapTableTwo" action="<?=base_url()?>" method="post" >
<? foreach($profile as $row):?>
	<span id="head"></span>
	<table id="tablaproveed" class="display">
		<thead> 
			<tr> 
				<th class="tools"></th>
				<th>Titulo Proyecto</th> 
				<th>Descripción Proyecto</th> 
				<th>Tipo</th> 
				<th>Status</th>
			</tr> 
		</thead> 
		<tbody>
			<?php foreach($obras as $rowO):?>
				<tr>
					<th class="tools">
					  <input class="check" type="checkbox" name="borrarProyecto" value="<?=$rowO->idProyecto;?>" />
					  <!-- Tu comentario <a class="tcenter" href="<?=base_url()?>proyectos/borrarStatusProy/<?=$rowO->idProyecto;?>"><img src="<?=base_url()?>assets/graphics/borrar.png" alt="Borrar" /></a>-->
					</th>
					<th class="titPro"><a class="fle100" href="<?=base_url()?>proyectos/verProyecto/<?=$rowO->idProyecto;?>"><span><?=$rowO->tituloProyecto;?></span></a></th> 
					<th><a class="fle100" href="<?=base_url()?>proyectos/verProyecto/<?=$rowO->idProyecto;?>"><p><?=character_limiter($rowO->descripcionProyecto, '180');?></p></a></th> 
					<th><a class="fle100 obraTipo" href="<?=base_url()?>proyectos/verProyecto/<?=$rowO->idProyecto;?>"><span><?=$rowO->obraTipo;?></span></a></th> 
					<th><a class="fle100" href="<?=base_url()?>proyectos/verProyecto/<?=$rowO->idProyecto;?>"><span><?=$rowO->status;?></span></a></th>
					
				</tr>
			<?php endforeach;?>
		</tbody> 
	</table>
<? endforeach; ?>
</form>

<div id="addProyect" style="display:none;">
<h3>Agregar Proyecto</h3>
<form id="addPoy" action="<?=base_url()?>proyectos/agregarProyecto" method="post">
	<fieldset>
		<label>Titulo Proyecto</label>
		<input id="bckBuscar" type="text" class="inBut" name="titProy" />
	</fieldset>
	<fieldset>
		<label>Tipo Proyecto</label>
		<select id="tipProy" name="tipProy" class="selRegBig">
	    <option selected >Elige una opción</option>
	    <? foreach($tipos as $rowTip):?>
	    <option value="<?= $rowTip->idTipo;?>"><?= $rowTip->tipo;?></option>
	    <? endforeach; ?>
		</select>
	</fieldset>
	<fieldset>
		<label>Fecha Cierre Licitación</label>
		<span id="calen"><input name="fechaCierre" type="text" id="datepicker" class="inSmall" placeholder="año/mes/dia"><img src="<?=base_url()?>assets/graphics/calendar.jpg" alt="" /></span>
	</fieldset>
	<fieldset>
		<label>Costo aproximado por proyecto</label>
		<select id="costProy" name="costProy" class="selRegBig">
	    <option selected value="" >Elige una opción</option>
	    <? foreach($rango as $rowR):?>
	    <option value="<?= $rowR->idRango;?>">$<?= number_format($rowR->rangoMinimo,2);?> - $<?= number_format($rowR->rangoMaximo,2);?></option>
	    <? endforeach; ?>
		</select>
	</fieldset>
	<fieldset>
		<label>Proyecto Ubicación</label>
		<select id="ubiProy" name="ubiProy" class="selRegBig">
	    <option selected value="" >Elige una opción</option>
	    <? foreach($zonas as $rowZ):?>
	    <option value="<?= $rowZ->idZona;?>"><?= $rowZ->zona;?></option>
	    <? endforeach; ?>
		</select>
	</fieldset>
	<fieldset>
		<textarea class="textMed" id="proyDesc" name="proyDesc" placeholder="Descripción del proyecto"></textarea>
	</fieldset>
	<fieldset>
		<input class="fright greenBotonForm" type="submit" value="Crear proyecto" onclick="this.disabled=true; this.form.submit(); return true;" />
	</fieldset>
</form>
</div>