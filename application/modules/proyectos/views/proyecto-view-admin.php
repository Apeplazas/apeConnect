<? foreach($proyecto as $rowP):?>
<div id="mainTit" >
  <img src="<?=base_url()?>assets/graphics/proyectos-blackIcon.png" alt="Proyectos y Obras" />
  <p class="headTit<?= $rowP->idProyecto;?>"><?= $rowP->tituloProyecto;?></p>
</div>
<?= $this->load->view('includes/menus/toolbarAdmin');?>
<div id="proy" class="topDiv">
	<p class="even"><b>Apertura proyecto: </b> <i><?= $rowP->fechaAltaProyecto;?> - <?= $rowP->horaAlta;?></i></p>
	<p class="row"><b>Cierre de licitación: </b> <i><?= $rowP->fechaCierreProyecto;?></i></p>
	<p class="even"><b>Tipo de Proyecto: </b><i><?= $rowP->tipo;?></i></p>
	<p class="even"><b>Estado: </b><i><?= $rowP->nombreEstado;?> - <?= $rowP->zona;?></i></p>
	<p class="row"><b>Status: </b><i><?= $rowP->statusProyecto;?></i></p>
	<p class="row"><b>Superviosr: </b><i><?= $rowP->nombreCompleto;?></i></p>
</div>
<?php if($proyecto[0]->statusProyecto == 'En Revision' or $proyecto[0]->statusProyecto == 'No Autorizado'):?>
<div id="wrapAcc">
	<a class="botOraThree" href="<?=base_url()?>proyectos/cambiarStatusProyecto/Autorizado/<?=$this->uri->segment(3);?>"><span class="fleft greenBoton ml10"><em><img src="<?=base_url()?>assets/graphics/checkMark.png" alt="Solicitud de Autorizacion"></em>Autorizar</span></a>
	
	
	<a class="redBoton fleft verProyAut" onclick="$('#showFor').toggle(); return false;" href="#"/><em><img src="<?=base_url()?>assets/graphics/cancel.png" alt="No autorizado"></em>No autorizar</a>
	
	<form id="showFor" method="post" style="display:none;" action="<?=base_url()?>proyectos/noAutorizar" >
		<input type="hidden" value="<?=$this->uri->segment(3);?>" name="proyectoId" />
		<input type="hidden" value="<?=$proyecto[0]->usuarioID;?>" name="usuarioId" />
		<p id="razon">
		<span><a class="closeText" href="#"><img src="<?=base_url()?>assets/graphics/closeGray.png" alt="Cerrar Formulario"></a></span>
		<textarea name="razon" placeholder="Ingrese una descripcion por la cual no autorizo"></textarea>
		<input id="blackEnd" class="cpointer" type="submit" value="Finalizar" />
		</p>
	</form>
</div>
<?php endif;?>
<div id="autoriza">
</div>
<strong class="topDiv">Descripción del proyecto</strong>	
	<div id="descSegProy">
	<p id="pro<?= $rowP->idProyecto;?>" class="desc" ><?= $rowP->descripcionProyecto;?></p>
	<div class="topDivSmall"><h4 id="tabHead">Archivos informativos.</h4></div>
		<? if($archivos):?>
		<div id="imagenPro">
			<? foreach($archivos as $archivo):?>
			<a target="_blank" href="<?=URLPROYECTOS.$archivo->nombreArchivo;?>">
				<? if($archivo->archivoTipo == 'jpg' || $archivo->archivoTipo == 'png' || $archivo->archivoTipo == 'gif' || $archivo->archivoTipo == 'jpeg'):?>
				<img src="<?=URLPROYECTOS.$archivo->nombreArchivo;?>" />
				<? else: ?>
				<?=$archivo->nombreArchivo;?>
				<? endif;?>
			</a>	
			<? endforeach;?>
		</div>
	
		<? endif;?>
	</div>
<? if($partidas):?>
		<div class="topDivSmall"><h4 id="tabHead">Particiones del proyecto.</h4></div>
		<table id="segmentos" class="dataTable">
			<thead>
				<tr>
					<th><span>Clave</span></th>
				  	<th><span>Concepto</span></th>
				  	<th><span>Unidad</span></th> 
				  	<th><span class="tcenter">Cantidad</span></th>
				</tr>
			</thead>
			<? foreach($partidas as $partida):?>
				<tr>
					<td colspan="4"><?=$partida->nombre;?></td>
				</tr>
				<?$segmento = $this->proyecto_model->buscaSegmento($proyecto[0]->idProyecto,$partida->id);?>
				<? if($segmento):?>
				
					<? foreach($segmento as $rowS):?>
					<tr>
						<td><?= $rowS->claveSegmento;?></td>
					  	<td><p id="segmento<?= $rowS->idSegmento;?>"><?= $rowS->descripcion;?></p></td>
					  	<td><strong id="status<?= $rowS->idSegmento;?>"><?= $rowS->nombreUnidad;?></strong></td>
					  	<td class="quantRow"><em class="tcenter" id="quant<?= $rowS->idSegmento;?>"><?= number_format($rowS->cantidad);?></em></td>
					</tr>
					<? endforeach; ?>
				<? else:?>
					<p class="alerta"><img src="<?=base_url()?>assets/graphics/alerta.png" alt="Alerta" /><strong>Esta partida no tiene ningún segmento registrado o agregado.</strong></p>
					<br class="clear">
				<? endif;?>
			<? endforeach;?>
		</table>
		<br class="clear">
	<? else:?>
		<p class="alerta"><img src="<?=base_url()?>assets/graphics/alerta.png" alt="Alerta" /><strong>Este proyecto no tiene ninguna partida registrado o agregado.</strong></p>
		<br class="clear">
	<? endif;?>
<? endforeach; ?>



<div id="addDisplay" style="display:none;">
<form enctype="multipart/form-data" action="http://www.apeplazas.com/obras/ajax/excelimport" method="post">
  <fieldset>
    <a class="iconoFoto">
      <input class="subirExcel" type="file" name="excelfile"/>
    </a>
  </fieldset>
  <fieldset>
    <input type="hidden" name="idproyecto" value="<?=$proyecto[0]->idProyecto;?>" />
  <input id="finalizarExcel" type="submit" value="Finalizar"/>
  </fieldset>
</form>
</div>

<!-- Escode barra derecha de comentarios -->
<div id="comentarios" style="display:none;">
<span class="headWin"><em>Comentarios</em> <a class="fright" id="closeWindow" href="#"><img src="<?=base_url()?>assets/graphics/closeWindow.png" alt="Cerrar Ventana Comentarios" /></a></span>
	<? if($comentarios):?>
	<ul>
	<?php foreach($comentarios as $comentario): ?>
		<li>
		 <div class="pregunta">
		 <!-- Si el mensaje es por proyecto-->
		 <? if($comentario->mensajeTipo == 'proyectos'):?>
		 <p class="headPreg"><span><img src="<?=base_url()?>assets/graphics/perfil.png" alt="Comentario de <?= $comentario->tipo;?> nombre <?= $comentario->usuarioCompleto;?>" /></span> <strong><?= $comentario->usuarioCompleto;?></strong> Pregunta del proyecto <i><?= $comentario->proyecto;?></i> <em><?= $comentario->fecha;?></em></p>
		 <!-- Si el mensaje es por no autorizacion-->
		 <? elseif($comentario->mensajeTipo == 'No autorizado'):?>
		 <p class="headPreg">
		 <span><img src="<?=base_url()?>assets/graphics/perfil.png" alt="<?= $comentario->usuarioCompleto;?> no autorizó tu proyecto" /></span>
		 <strong><?= $comentario->usuarioCompleto;?></strong> No autorizo el proyecto <i><?= $comentario->proyecto;?></i> <em><?= $comentario->fecha;?></em>
		 </p>
		 <? endif;?>
		 <? $resp = $this->proyecto_model->cargaRespuestas($comentario->comentarioID);?>
		 </div>
		 
		 
		 <? foreach($resp as $rowResp):?>
			 <?php $preguntaClass = null; if($rowResp->usuarioID == $userID) $preguntaClass = " uActual";?>
			 <div class="responder<?=$preguntaClass;?>">
			   <strong><?= $rowResp->nombreCompleto;?><em><?= $rowResp->fechaRespuesta;?></em></strong>
			   <p><?= $rowResp->respuesta;?></p>
			 </div>
		 <? endforeach; ?>
		 <div class="form"></div>
		 
		 <div class="botCome">
		   <a class="ajaxSend graySmallBoton" href="<?= base_url()?>ajax/addFormResp/<?=$comentario->comentarioID;?>/<?= $this->uri->segment(3);?>"/>Responder</a>
		   
		
		 <?php if(!empty($seHaCancelado) && ($proyecto[0]->statusProyecto == 'En Revision' or $proyecto[0]->statusProyecto == 'No Autorizado')):?>
		 	  <a class="graySmallBoton" onclick="$('#showFor2').toggle(); return false;" href="#"/>No autorizar</a>
			<form id="showFor2" method="post" style="display:none;" action="<?=base_url()?>proyectos/noAutorizar" >
				<input type="hidden" value="<?=$this->uri->segment(3);?>" name="proyectoId" />
				<input type="hidden" value="<?=$proyecto[0]->usuarioID;?>" name="usuarioId" />
				<p id="razon">
				<span><a class="closeText2" href="#"><img src="<?=base_url()?>assets/graphics/closeGray.png" alt="Cerrar Formulario"></a></span>
				<textarea name="razon" placeholder="Ingrese una descripcion por la cual no autorizo"></textarea>
				<input id="blackEnd" class="cpointer" type="submit" value="Finalizar" />
				</p>
			</form>
			<a class="graySmallBoton" href="<?=base_url()?>proyectos/cambiarStatusProyecto/Autorizado/<?=$this->uri->segment(3);?>"/>Autorizar</a>
		<?php endif;?>
		 </div>	
		</li>
	<? endforeach; ?>
	</ul>
<br class="clear">
<? else:?>
<p class="alerta"><img src="<?=base_url()?>assets/graphics/alerta.png" alt="Alerta" /><strong>Este proyecto no tiene ningún comentario.</strong></p>
<? endif;?>
</div>

<?php if(!$tienecot[0] && $proyecto[0]->statusProyecto != "Contratando"):?>
	<!--script type="text/javascript">
	jQuery(function($){
	<? foreach($segmento as $rowP):?>	
		// Actualiza vendedor
		$("#status<?= $rowP->idSegmento;?>").editInPlace({
			url: '<?=base_url()?>ajax/editConSeg/<?= $rowP->idSegmento;?>',
			default_text: 'Asignar nuevo segmento',
			field_type: "select",
			bg_over: "none",
			select_options: "<? foreach($conceptos as $rowC):?><?= $rowC->nombre;?>,<? endforeach; ?>"
		});
		
		// Actualiza vendedor
		$("#quant<?= $rowP->idSegmento;?>").editInPlace({
			url: '<?=base_url()?>ajax/editQuantSeg/<?= $rowP->idSegmento;?>',
			field_type: "text",
			bg_over: "none",
		});
		// Actualiza vendedor
		$("#segmento<?= $rowP->idSegmento;?>").editInPlace({
			url: '<?=base_url()?>ajax/editSeg/<?= $rowP->idSegmento;?>',
			field_type: "text",
			bg_over: "none",
		});
	<? endforeach; ?>
	<? foreach($proyecto as $rowO):?>	
		// Actualiza vendedor
		$("#pro<?= $rowO->idProyecto;?>").editInPlace({
			url: '<?=base_url()?>ajax/editConPro/<?= $rowO->idProyecto;?>',
			field_type: "textarea",
			bg_over: "none",
		});
		// Actualiza vendedor
		$(".headTit<?= $rowO->idProyecto;?>").editInPlace({
			url: '<?=base_url()?>ajax/editTitPro/<?= $rowO->idProyecto;?>',
			field_type: "text",
			bg_over: "none",
		});
		
	<? endforeach; ?>
		 $("tbody tr:even").addClass("even");
		 $("tbody tr:odd").addClass("odd");
	})
	</script-->
<?php endif;?>
<!-- Trae formulario en ajax -->
<script type="text/javascript" charset="utf-8">
// Trae formulario de respuesta
$(function(){
		$('a.ajaxSend').click(function(event){
		event.preventDefault();
		$('.form').remove();
		$(this).parent().after('<div class="form"></div>');
		$(this).parent().next().load($(this).attr('href'));
		})	
});
$(function(){	
	$('#addSeg').click(function (event) {
	    var $form = $(this),
	        url = ('http://www.apeplazas.com/obras/ajax/agregarSegmento');
	    var posting = $.post(url);
	    posting.done(function (data) {
	        var content = (data);
	        $('#segmento').empty().append(content);
		});
	});
	
	$('#agregarSeccion').submit(function(){
		var form = $(this).serialize();
		if(form.indexOf('=&') > -1 || form.substr(form.length - 1) == '='){
   			alert("Favor de ingresar todos los campos");
   			return false;
		}
	});
});
</script>
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
	'titleShow'		: false,
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
    	
    	var urlPost = (("https:" == document.location.protocol) ? "https://www.apeplazas.com/obras" : "http://www.apeplazas.com/obras/");
		$("ul.subnav").parent().append("<span></span>"); //Muestra el dropdown 
		$("ul.topnav li span").click(function() { //Cuando el trigger acciona muestra estas etiquetas...
		//Sigue el evento y genera un slide Down de efecto para los resultados
		$(this).parent().find("ul.subnav").slideDown('fast').show(); //Drop down the subnav on click
		$(this).parent().hover(function() {}, function(){
			$(this).parent().find("ul.subnav").slideUp('slow'); //Cuando el mouse esta arriba lo vuelve a quitar poco a poco
		});
		}).hover(function() {
			$(this).addClass("subhover"); //en over agrega la clase subhover
		}, function(){	//cuando se quita el over
			$(this).removeClass("subhover"); //remueve la clase subhover
		});
		/*CODIGO PARA generar la busqueda del resultado por ajax*/
		$("#bckBuscar").autocomplete(urlPost+"ajax/buscarDescripcion", {
			width: 550,
			selectFirst: false
		});
		$("#bckBuscar").result(function(event, data, formatted) {
		if (data == '<h1>Busqueda por tipo</h1>' || data == '<h1>Busqueda por marca</h1>'){
			$("#bckBuscar").val('');
			alert("Por favor ingrese una opcion valida");
			}
		else {
			$("#avanzada").val(data[2]);
			$("#formBuscar").submit();
			}
		});
	
		$('.relB').click(function(){
			var texto = $(this).attr('title');
			$('#formBuscar input[name=key]').val(texto);
			$('#formBuscar').submit();
		});
		$('.closeText').click(function(){
			$('#showFor').hide();
		});
		$('.closeText2').click(function(){
			$('#showFor2').hide();
		});
		$("#formBuscar input[name=key]").keypress(function(e) {
			$('#formBuscar input[name=hidden]').val('');
		});
    	
    	$('#addPoy').submit(function(){
			if($('#bckBuscar').val() == '' || $('#tipProy').val() == '' || $('#datepicker').val() == '' || $('#costProy').val() == '' || $('#ubiProy').val() == '' || $('#proyDesc').val() == ''){
				alert("Favor de ingresar todos los campos");
				return false;
			}
		});
		
		$("#noAutorizar").submit(function(){
			if($('#razon').is(":visible")){
				if(!$.trim($('#razon').val()).length > 0){
					alert("Ingrese una descripcion por la cual no autorizo");
					return false;
				}
				return true;
			}else{
				$('#razon').show();
				return false;
			}
			 
		});
		
	});
</script>