<link rel="stylesheet" href="<?=base_url()?>assets/js/mocha/mocha.css" />
<script src="<?=base_url()?>assets/js/d3.v3.min.js"></script>
<? foreach($infoPlano as $p):?>
<? $this->load->view('includes/toolbars/buscaPisos-toolbar');?>

<div id="window" class="link">
	<div class="fright cpointer"><img src="<?=base_url()?>assets/graphics/ventana.png" alt="Ver Información"></div>
</div>

<?php $textsContent = '';?>


<div id="plano">
	<h1><?= $p->plaza;?></h1>
	<div id="pan-parent">
		<div id="panzoom">
		<svg class="grid" version="1.1" id="Layer1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 800 400" enable-background="new 0 0 800 400" xml:space="preserve">
	 		<g>
			<? foreach($locales as $row): ?>
			<? if($row->tipo == 'polyline'): ?>
			<polyline id="<?= $row->id;?>" class="click <?=$row->status;?>" points="<?= $row->points;?>"/>
			<? elseif ($row->tipo == 'path'):?>
			<path  id="<?= $row->id;?>" d="<?= $row->d;?>" class="click <?=$row->status;?>"  />
			<? elseif ($row->tipo == 'line'):?>
			<line id="<?= $row->id;?>" class="click <?=$row->status;?>" x1="<?= $row->x1;?>" y1="<?= $row->y1;?>" x2="<?= $row->x2;?>" y2="<?= $row->y2;?>" />
			<? elseif ($row->tipo == 'polygon'):?>
			<polygon id="<?= $row->id;?>" class="click <?=$row->status;?>" points="<?=$row->points;?>"/>
			<? elseif ($row->tipo == 'rect'):?>
			<rect id="<?= $row->id;?>" class="click <?=$row->status;?>" x="<?=$row->x;?>" y="<?=$row->y;?>" width="<?=$row->width;?>" height="<?=$row->height;?>"/>
			<? elseif ($row->tipo == 'text'):
			$textsContent .= '<text id="' . $row->id . '" class="texto" transform="' . $row->transform . '" >' . $row->contenido . '</text>';
			endif;?>
			<? endforeach; ?>
			<?=$textsContent;?>
			</g>
			</svg>
		</div>
		
		<div class="popup" tabindex="-1">
			<div  id="planoGrama" >
			<span class="secTit"><em>Información de local</em></span>
				<div id="forma">
					<i class="topArrow"><img src="<?=base_url()?>assets/graphics/topArrow.png" alt="Señalización" /></i>
				    <div id="infLocPl"></div>
				    
					<div id="infoCuenta">
						<div id="statusLocal"></div>		
						<span id="statusVector" class="lineAc" title="">
						  <em>Status</em> 
						  <select name="" id="habilitado">
							  <option id="sel1" checked value="">Selecciona una opción</option>
							  <option value="habilitado">Habilitar</option>
							  <option value="deshabilitado">Deshabilitar</option>
							  <option value="borrado">Borrar</option>
							  <option value="areaPublica">Area Publica</option>
						  </select>
						  <!--  <button id="habilitado"></button>//-->
						</span>
						<span id="asigClick"><em>Asignar #local</em> <div class="lightBotDiv fanc" onclick="$('#asig').toggle(); return false;">Asignar</div></span>
					</div>
				</div>
				
				 <form id="asig" method="post" >
				<fieldset>
					<label>*Asigna el numero de local</label>
					<input type="text" name="claveLocal" id="asigInp" />
					<input tabindex="2" class="lightBot fright" type="submit" id="enviarAsignar" value="Terminar" />
				</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
<? endforeach; ?>
<!-- Selecciona para crear grupos de informacion -->
<script>  
$(function() {
	$(".habilitado, .texto").click(function(e){
		d3.select(this).classed( "selected", false);
		console.log(this);
		if (!e.shiftKey) {
			d3.selectAll( '.habilitado, .texto').classed( "selected", false);
    	}
		$(this).attr("class",$(this).attr("class")+" selected");
	});
	
});
</script>
<!-- Manda la busqueda de segmento al seleccionar el filtro -->
<script type="text/javascript">
$(".busqueda").change(function() {
		var action = $("#busquedaUno").val() + "/" +$("#busquedaDos").val() + "/" +$("#busquedaTres").val();
	$("#forma").attr("action", "<?=base_url()?>planogramas/verplano/<?=$this->uri->segment(3)?>/" + action);
});
</script>
<!-- Busca informacion y la muestra en ventana -->
<script>
function clean(){
$("#infLocPl").empty();
}
$(function() {
	$(".habilitado, .reciente, .deshabilitado, .seleccionado, .areaPublica").click(function(){
		clean();
		var id = $(this).attr("id");
		$("#forma").removeAttr("disabled");
		$.post("<?=base_url()?>ajax/verLocalID", {
			id : id
		}, function(data) {
			if(jQuery.isEmptyObject(data.local)){
				$('#asigClick').show();
				$("#statusLocal").html('<em>Segmento no asignado</em>');
			}else{
				$("#sel1").text(data.local[0].estatusLocal);
				$("#infLocPl").html(" \
				<div class='field'><span>Plaza: </span><em> "+data.local[0].plaza+"</em></div> \
				<div class='field'><span>Nombre: </span><em> "+data.local[0].nombre+"</em></div> \
				<div class='field'><span>Clave: </span><em> "+data.local[0].clavedeLocal+"</em></div> \
				<div class='field'><span>Fecha emision: </span><em> "+data.local[0].fechaEmision+"</em></div> \
				<div class='field'><span>Razon social: </span><em> "+data.local[0].razonSocial+"</em></div> \
				<div class='field'><span>Contrato: </span><em> "+data.local[0].contrato+"</em></div> \
				<div class='field'><span>Local: </span><em> "+data.local[0].local+"</em></div> \
				<div class='field'><span>Importe renta: </span><em> "+data.local[0].importe+"</em></div> \
				<div class='field'><span>Fiador: </span><em> "+data.local[0].fiador+"</em></div> \
				<div class='field'><span>Status local: </span><em> "+data.local[0].estatusLocal+"</em></div> \
				<div class='field'><span>Status contrato: </span><em> "+data.local[0].estatusContrato+"</em></div> \
				");
				if (data.local[0].contrato != ''){
					$("#infLocPl").append(" \
					<div class='field'><span>Contrato: </span><em> "+data.local[0].contrato+"</em></div> \
				");
				}
				$("#statusLocal").attr("class","asignado");
				$("#statusLocal").html('<em>Local asignado</em>');
				$("#statusLocal").attr("class","asignado");
				
			}
			$("#statusVector").attr("title",id);
			$("#statusVector button").attr("id",data.Nvector[0].status);
		},'json');		
	});
	
			
	$("#habilitado").change(function() {
		var id        = $('.lineAc').attr("title");
		var status    = $(this).val();
		$.post("<?=base_url()?>ajax/statusVector", {id : id, status : status},
		
		function(data) {
			if(jQuery.isEmptyObject(data.local)){
				$("#statusLocal").attr("class","noAsignado");
				$("#statusLocal").html('<em>Segmento no asignado</em>');
			}
			$("#"+id).attr("class",data.Nvector[0].status);
			$("#statusVector").attr("title",id);
			$("#statusVector button").attr("id",data.Nvector[0].status);
		},'json');
	});
			
	$("#asignar").click(function() {
		var id = $(this).attr("id");
		$("#forma").removeAttr("disabled");
		$.post("<?=base_url()?>ajax/asignarLocal", {
			id : id
		}, function(data) {
			if(jQuery.isEmptyObject(data.local)){
				$("#statusLocal").attr("class","noAsignado");
				$("#statusLocal").html('<em>Segmento no asignado</em>');
			}
			$("#statusVector").attr("title",id);
			$("#statusVector button").attr("id","habilitado");
		},'json');
				
	});
			
	$("#asig").submit(function(event) {
		event.preventDefault();

		var local		= $("#asigInp").val();
		var vectores 	= $('.selected');
		var vectoresData = [];
		
		$.each(vectores,function(key,val){
			vectoresData.push(val.id);
		});
				
		$.post("<?=base_url()?>ajax/asignar", {
			ids : vectoresData,
			local : local
					
		}, function(data) {
			$("#statusLocal").attr("class","asignado");
			$("#infLocPl").html('<em>Local: '+data.local[0].clavedeLocal+'</em>');
			$("#statusLocal").html('<em>Segmento asignado</em>');
			$("#statusVector button").attr("id",data.Nvector[0].status);
			$("#"+id).attr("class",data.Nvector[0].status);
			$('#asigClick').hide();
		},'json');
		$( "#asig" ).hide();
			
	});
	
});
</script>

<script>
var zoom = d3.behavior.zoom()
    .scaleExtent([1, 10])
    .on("zoom", zoomed);
    
var drag = d3.behavior.drag()
	.on("dragstart", dragstarted)
    .on("drag", dragmove)
    .on("dragend", dragended);

var svg = d3.select("#Layer1").call(zoom);

var container = d3.select("g");

d3.selectAll(".texto")
        .call(drag)

function zoomed() {
  container.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
}

function dragstarted(d) {
  d3.event.sourceEvent.stopPropagation();
  d3.select(this).classed("dragging", true);
}

function dragmove(d) {
    d3.select(this)
      .attr("transform", function(d) { return "translate("+d3.event.x+","+d3.event.y+")"; });
}

function dragended() {
  d3.select(this).classed("dragging", false);
  console.log(d3.select(this).attr("id"));
  console.log(d3.select(this).attr("transform"));
 	$.ajax({
		data : {'id':d3.select(this).attr("id"),"coords":d3.select(this).attr("transform")},
		dataType : 'json',
		url : ajax_url + 'actualizaCoord',
		type : 'post',
	});
}
</script>

<script>
var urlPost = (("https:" == document.location.protocol) ? "https://www.apeplazas.com/obrasDos/" : "http://www.apeplazas.com/obrasDos/");
jQuery(function($) {
/********************************************************************************************************************
Ajax para el autocompletar
********************************************************************************************************************/
	$(function() {
		
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
		$("#asigInp").autocomplete(urlPost+"ajax/cargarLocales", {
			width: 650,
			selectFirst: false
		});
		$("#asigInp").result(function(event, data, formatted) {
		if (data == '<h1>Busqueda por tipo</h1>' || data == '<h1>Busqueda por marca</h1>'){
			$("#bckBuscar").val('');
			alert("Por favor ingrese una opcion valida");
			}
		else {
			$("#avanzada").val(data[2]);
			$("#formBuscar").submit();
			}
		});
	});
	
	$('.relB').click(function(){
		var texto = $(this).attr('title');
		$('#formBuscar input[name=key]').val(texto);
		$('#formBuscar').submit();
	});
	
	$("#formBuscar input[name=key]").keypress(function(e) {
		$('#formBuscar input[name=hidden]').val('');
	});
});
</script>