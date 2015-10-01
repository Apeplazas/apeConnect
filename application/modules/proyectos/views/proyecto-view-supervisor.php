<? foreach($proyecto as $rowP):?>
	<div id="mainTit"><img src="<?=base_url()?>assets/graphics/proyectos-blackIcon.png" alt="Proyectos y Obras" />Obras y Proyectos</div>
	<?= $this->session->flashdata('msg'); ?>
	<div id="wrapTableTwo">
		<?= $this->load->view('includes/menus/toolbar');?>
		<div id="proy" class="topDiv">
			<p class="even"><b>Apertura proyecto: </b> <i><?= $rowP->fechaAltaProyecto;?> - <?= $rowP->horaAlta;?></i></p>
			<p class="row"><b>Cierre de licitación: </b> <i><?= $rowP->fechaCierreProyecto;?></i></p>
			<p class="even"><b>Tipo de Proyecto: </b><i><?= $rowP->tipo;?></i></p>
			<p class="even"><b>Estado: </b><i><?= $rowP->nombreEstado;?> - <?= $rowP->zona;?></i></p>
			<p class="row"><b>Status: </b><i><?= $rowP->statusProyecto;?></i></p>
			<? if (empty($seHaCancelado) && ($rowP->statusProyecto == 'Pausado' or $rowP->statusProyecto == 'No Autorizado')):?>
				<a class="botOraThree" href="<?=base_url()?>proyectos/notificacion_proyecto/<?=$this->uri->segment(3);?>"><span class="fleft greenBoton"><em><img src="<?=base_url()?>assets/graphics/plus.png" alt="Solicitud de Autorizacion" /></em> Solicitar Autorización</span></a>
			<? endif;?>
			<? if(!empty($seHaCancelado) && $proyecto[0]->statusProyecto == "No Autorizado"):?>
				<a class="botOraThree" href="<?=base_url()?>proyectos/notificacion_proyecto/<?=$this->uri->segment(3);?>"><span class="fleft greenBoton"><em><img src="<?=base_url()?>assets/graphics/plus.png" alt="Solicitar nueva revisión" /></em> Solicitar nueva revisión</span></a>
			<? endif;?>
		</div>
		<strong id="headProy" class="topDiv">Conceptos de <?= $rowP->tituloProyecto;?> </strong>
		<div id="descSegProy">
			<p id="pro<?= $rowP->idProyecto;?>" class="desc" ><?= $rowP->descripcionProyecto;?></p>
		</div>
	
		
		
		<div class="topDivSmall"><h4 id="tabHead">Archivos informativos.</h4></div>
		<form action="<?=base_url()?>proyectos/agrgarArchivo" method="post" enctype="multipart/form-data">
		  <fieldset>
		  <input type="hidden" name="proyecto" value="<?= $this->uri->segment(3);?>"/>
		  </fieldset>
		  
		  <span class="frameProyIma">
			<fieldset>
				<a class="iconImagen" >
					<input class="subirFotoArc" type="file" name="archivoProyecto" onchange="readURL(this)" />
				</a>
				<input id="addImag" type="submit" value="Agregar Archivo" onclick="this.disabled=true; this.form.submit(); return true;" />
				
			</fieldset>
		</span>
		
		  
		  
		</form>
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


	<div id="comentariosProyecto">
		<? if($cometarios):
			$tieneComentarios = $cometarios[0]->cID;?>
			<strong class="headTit34 headTit topDiv">Comentarios de proveedores</strong>
			<ul id="comenSup">
				<? foreach($cometarios as $com):
				$class = ($com->idrole == 3) ? 'repIzq' : 'repDer';?>
				<li class="<?=$class;?>">
				  <p class="comm"><em><?= $com->fechaRespuesta;?></em><?=$com->respuesta;?></p>
				<? if($com->usuarioId != $userID ): ?>
				<a class="botConte" onclick="$('#showFor-<?=$com->respuestaID;?>').toggle(); return false;" href="#"/>Responder</a>
				<form id="showFor-<?=$com->respuestaID;?>" method="post" style="display:none;" action="<?=base_url()?>proyectos/contestarProyecto" >
					<input type="hidden" value="<?=$this->uri->segment(3);?>" name="proyectoId" />
					<input type="hidden" value="<?=$com->idConversacion;?>" name="conversacionId" />
					<input type="hidden" value="<?=$com->usuarioId;?>" name="proveedorId" />
					<p class="razon">
						<span><a class="closeText" href="#"><img src="<?=base_url()?>assets/graphics/closeGray.png" alt="Cerrar Formulario"></a></span>
						<textarea name="comentario" placeholder="Ingrese un comentario"></textarea>
						<input id="blackEndSmall" class="cpointer" type="submit" value="Finalizar" />
					</p>
				</form>
				<? endif; ?>  
				</li>
				<? endforeach;?>
			</ul>
		
		<? endif;?>
		</div>
		
		<div class="topDivSmall">
			<a href="#addDisplay" class="fancy" onclick="javascript:$('#excelimport').attr('action', function(i, value) {
        return '<?=base_url()?>ajax/excelFullImport';});">
				Exportar Proyecto Completo<img alt="Importar Excel" src="<?=base_url()?>assets/graphics/excelImport.png">
			</a>		
		</div>
			
	<? if($partidas):?>
		<div class="topDivSmall"><h4 id="tabHead">Particiones del proyecto.</h4></div>
		<table id="segmentos" class="dataTable">
			<thead>
				<tr>
				  <th class="tAlign"></th>
				  <th><span>Clave</span></th>
				  <th><span>Concepto</span></th>
				  <th><span>Unidad</span></th> 
				  <th><span class="tcenter">Cantidad</span></th>
				</tr>
			</thead>
			<? foreach($partidas as $partida):?>
				<tr>
					<td class="borrarRow">
						<a href="<?=base_url()?>proyectos/borrarPartida/<?= $partida->id;?>/<?= $this->uri->segment(3);?>"><img src="<?=base_url()?>assets/graphics/deleteRow.png" alt="Borrar" /></a>
						<a href="#addDisplay" class="fancy" onclick="javascript:$('#excelimport').attr('action', function(i, value) {
        return '<?=base_url()?>ajax/excelimport/<?=$partida->id;?>';
    });">
    						<img alt="Importar y Exportar Excel" src="<?=base_url()?>assets/graphics/excelImport.png">
    					</a>
					</td>
					<td colspan="2"><?=$partida->nombre;?></td>
					<td class="noborder" colspan="2">
						<? if ( $rowP->statusProyecto == 'Pausado' or $rowP->statusProyecto == 'No Autorizado' ):?>
								<fieldset id="segmento-<?=$partida->id;?>" class="regular <? if($this->uri->segment(4) == '1'):?>wide<? endif;?>">
								</fieldset>
							<span title="<?=$partida->id;?>" class="addSeg fright redBoton mb4"><em><img src="<?=base_url()?>assets/graphics/plus.png" alt="Agregar Concepto" /></em>Agregar Concepto</span>
						<?php endif;?>
					</td>
				</tr>
				<?$segmento = $this->proyecto_model->buscaSegmento($proyecto[0]->idProyecto,$partida->id);?>
				<? if($segmento):?>
				
					<? foreach($segmento as $rowS): ?>
					<tr>
					  <td class="borrarRow"><a class="staIconBor" href="<?=base_url()?>proyectos/secAdmStatus/<?= $rowS->idSegmento;?>/<?= $this->uri->segment(3);?>"><img src="<?=base_url()?>assets/graphics/borrarParticion.png" alt="Borrar" /></a></td>
					  <td><?= $rowS->claveSegmento;?></td>
					  <td><p id="segmento<?= $rowS->idSegmento;?>"><?= $rowS->descripcion;?></p></td>
					  <td><strong id="status<?= $rowS->idSegmento;?>"><?= $rowS->nombreUnidad;?></strong></td>
					  <td class="quantRow"><em class="tcenter" id="quant<?= $rowS->idSegmento;?>"><?= number_format($rowS->cantidad);?></em></td>
					</tr>
					<? endforeach; ?>
				<? else:?>
					<p class="alerta"><img src="<?=base_url()?>assets/graphics/alerta.png" alt="Alerta" /><strong>Esta partida no tiene ningún concepto registrado o agregado.</strong></p>
					<br class="clear">
				<? endif;?>
			<? endforeach;?>
		</table>
		<br class="clear">
	<? else:?>
		<p class="alerta"><img src="<?=base_url()?>assets/graphics/alerta.png" alt="Alerta" /><strong>Este proyecto no tiene ninguna partida registrado o agregado.</strong></p>
		<br class="clear">
	<? endif;?>
	</div>
<? endforeach; ?>

<? if ( $rowP->statusProyecto == 'Pausado' or $rowP->statusProyecto == 'No Autorizado' ):?>
	
	<?php if($nombrePartidas):?>
		<form method="post" id="partida" action="<?=base_url()?>proyectos/agregarPartida">
			<select name="partidaID">
				<?php foreach($nombrePartidas as $partida):?>
					<option value="<?=$partida->id;?>"><?=$partida->nombre;?></option>
				<?php endforeach;?>	
			</select>
			<input type="hidden" name="proyecto" value="<?= $this->uri->segment(3);?>"/>
			<input type="submit" id="addPart" value="Agregar Partida" onclick="this.disabled=true; this.form.submit(); return true;" />
		</form>
		
	<?php endif;?>
	
	
	
<? endif;?>

<div id="addDisplay" style="display:none;">
<form id="excelimport" enctype="multipart/form-data" action="http://www.apeplazas.com/obras/ajax/excelimport" method="post">
	<input type="file" name="excelfile"/>
	<input type="hidden" name="idproyecto" value="<?=$proyecto[0]->idProyecto;?>" />
	<input type="submit" value="Importar" />
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
		   <a class="graySmallBoton enviarAjax" href="<?= base_url()?>ajax/addFormResp/<?=$comentario->comentarioID;?>/<?= $this->uri->segment(3);?>"/>Responder</a>
		   <? if(!empty($seHaCancelado) && $proyecto[0]->statusProyecto == "No Autorizado"):?>
				<a class="graySmallBoton" href="<?=base_url()?>proyectos/notificacion_proyecto/<?=$this->uri->segment(3);?>"/>Solicitar nueva revisión</a>
		   <? endif;?>
		 </div>
		</li>
	<? endforeach; ?>
	</ul>
<br class="clear">
<? else:?>
<p class="alerta"><img src="<?=base_url()?>assets/graphics/alerta.png" alt="Alerta" /><strong>Este proyecto no tiene ningún comentario.</strong></p>
<? endif;?>
</div>



<?php if(!$tienecot[0] || $proyecto[0]->statusProyecto == "No Autorizado" ||  $proyecto[0]->statusProyecto == "Pausado"):?>
<script type="text/javascript">
	jQuery(function($){
	<? foreach($partidas as $partida):?>
	<?$segmento = $this->proyecto_model->buscaSegmento($proyecto[0]->idProyecto,$partida->id);?>
	
	<? foreach($segmento as $rowP):?>	
		// Actualiza vendedor
		$("#status<?= $rowP->idSegmento;?>").editInPlace({
			url: '<?=base_url()?>ajax/editConSeg/<?= $rowP->idSegmento;?>',
			default_text: 'Asignar nuevo concepto',
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
</script>
<?php endif;?>




	
<script type="text/javascript" charset="utf-8">
// Trae formulario de respuesta
$(function(){
		$('a.enviarAjax').click(function(event){
		event.preventDefault();
		$('.form').remove();
		$(this).parent().after('<div class="form"></div>');
		$(this).parent().next().load($(this).attr('href'));
		})	
})
$(function(){

	var objetoAbierto = false;

	$('.addSeg').click(function (event) {
		var title = $(this).attr('title');
	    var $form = $(this),
	        url = ('http://www.apeplazas.com/obras/ajax/agregarSegmento');
	    var posting = $.post(url);
	    posting.done(function (data) {
	    		
	        	var content = (data);
	        	$('#tb').remove();
	        	$('#segmento-'+title).empty().closest('tr').after('<tr id="tb"><td colspan="4"><form action="<?=base_url()?>proyectos/agregarSeccion" method="post" id="agregarSeccion" ><input type="hidden" name="proyecto" value="<?=$this->uri->segment(3);?>"/><input type="hidden" name="partidaId" value="'+title+'"/>'+content+'</td></tr>');
	        	$(this).hide();
	        	objetoAbierto = true;
	        
	        
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
		
		
		$( ".closeText" ).click(function( event ) {
		  event.preventDefault();
		  $('.repDer form, .repIzq form').hide();
		});

		$('.relB').click(function(){
			var texto = $(this).attr('title');
			$('#formBuscar input[name=key]').val(texto);
			$('#formBuscar').submit();
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
	});
</script>