<script src="<?=base_url()?>assets/js/d3.v3.min.js"></script>

<? foreach($infoPlano as $p):?>


<h3 id="mainTit">Asignación de locales a plano de <?= $p->plaza;?></h3>
<div class="wrapListPlano">

	<div id="actionsPlano">
		<? $this->load->view('includes/toolbars/buscaPisos-toolbar');?>
		<input type="hidden" id="text" style="width:100%">
		<!-- Empieza boton con ventana de planogramas -->
		<div id="window" class="link">
			<button class="addToolSmallRi"><i class="iconWindow">Ventana</i></button>
			<div class="popup" tabindex="-1">
				<!-- Empieza ventana informativa de planogramas -->
				<div  id="planoGrama" >
					<span class="secTit"><em>Locales por asignar</em></span>
						<div id="actTod">
						<i class="topArrow"><img src="<?=base_url()?>assets/graphics/topArrow.png" alt="Señalización"></i>
						<div id="infLocPlSt"></div>
						<div id="infLocPl"></div>
							<div id="infoCuenta">	
							<span id="statusVector" class="lineAc" title="">
							<form>
								<fieldset>
								<label>Habilitar</label>
								<input type="radio" checked value="habilitado" class="actionMet" name="actionMet" />
								</fieldset>
								<fieldset>
								<label>Deshabilitar</label>
								<input type="radio" value="deshabilitado" class="actionMet" name="actionMet" />
								</fieldset>
								<fieldset>
								<label>Area Publica</label>
								<input type="radio" value="areaPublica" class="actionMet" name="actionMet" />
								</fieldset>
								<fieldset>
								<label>Borrar</label>
								<input type="radio" value="borrado" class="actionBor" name="actionMet" />
								</fieldset>
								<!-- Tu comentario 
								<select name="" id="habilitado">
									<option id="sel1" checked value="">Selecciona una opción</option>
									<option value="habilitado">Habilitar</option>
									<option value="deshabilitado">Deshabilitar</option>
									<option value="borrado">Borrar</option>
									<option value="areaPublica">Area Publica</option>
								</select>-->
								<!--  <button id="habilitado"></button>//-->
								</form>
							</span>
							</div>
						</div>
					<ul id="asigUl">
					<? foreach($asignar as $l):?>
						<li id="<?= $l->tipo;?>-<?= $l->id;?>" class="closeup"> <?= $l->id;?> - Creado: <?= $l->date;?></li>
					<? endforeach; ?>
					</ul>
					<form id="asig" method="post" class="mt10" >
						<fieldset>
							<label id="idRec">*Asigna el numero de local</label>
							<input type="text" name="claveLocal" id="asigInp" />
							<input type="hidden" id="plazaID" name="plazaId" value="<?= $this->uri->segment(3);?>"/>
							<input type="submit" id="subPlan" value="Agrupar" />
						</fieldset>
					</form>
					<br class="clear">
					</div>
				</div>
				<!-- Cierra ventana informativa de planogramas -->
			</div>
			<? $this->load->view('includes/toolbars/planoGramas');?>
		</div>
		<!-- Cierraboton con ventana de planogramas -->
	
	
<?php $textsContent = '';?>
	<div id="plano">
		<div id="pan-parent">
			<div id="panzoom">
			<svg class="grid" version="1.1" id="Layer1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 800 400" enable-background="new 0 0 800 400" xml:space="preserve">
		 		<g>
		 		
			
				<? foreach($locales as $row): ?>
				<? if($row->tipo == 'polyline'): ?>
				<g id="poly">
				<polyline id="<?= $row->id;?>" class="<? if($row->localID == ''):?>click reciente bgrayAsig<?else:?>clean<?endif;?>" points="<?= $row->points;?>"/>
				</g>
				<? elseif ($row->tipo == 'path'):?>
				<g id="path">
				<path  id="<?= $row->id;?>" d="<?= $row->d;?>" class="<? if($row->localID == ''):?>click reciente bgrayAsig<?else:?>clean<?endif;?>"  />
				</g>
				<? elseif ($row->tipo == 'line'):?>
				<g id="line">
				<line id="<?= $row->id;?>" class="<? if($row->localID == ''):?>click reciente bgrayAsig<?else:?>clean<?endif;?>" x1="<?= $row->x1;?>" y1="<?= $row->y1;?>" x2="<?= $row->x2;?>" y2="<?= $row->y2;?>" />
				</g>
				<? elseif ($row->tipo == 'polygon'):?>
				<g id="polyg">
				<polygon id="<?= $row->id;?>" class="<? if($row->localID == ''):?>click reciente bgrayAsig<?else:?>clean<?endif;?>" points="<?=$row->points;?>"/>
				</g>
				<? elseif ($row->tipo == 'rect'):?>
				<g id="rect">
				<rect id="<?= $row->id;?>" class="<? if($row->localID == ''):?>click reciente bgrayAsig<?else:?>clean<?endif;?>" x="<?=$row->x;?>" y="<?=$row->y;?>" width="<?=$row->width;?>" height="<?=$row->height;?>"/>
				</g>
				<? elseif ($row->tipo == 'text'):
					if(!empty($row->x)):
						$textsContent .= '<text id="' . $row->id .'" transform="translate(' . $row->x . ',' . $row->y . ')" class="texto cleanText" >' . $row->contenido . '</text>';
					else:
						$textsContent .= '<text id="' . $row->id . '" class="texto cleanText" transform="' . $row->transform . '" >' . $row->contenido . '</text>';
					endif;		
				endif;?>
				<? endforeach; ?>
				<?=$textsContent;?>
				</g>
				</svg>
			</div>
			
			
		
		</div>
		
	</div>
</div>
<? endforeach; ?>
<!-- Selecciona para crear grupos de informacion -->
<script>  
$(function() {
	$(".reciente, .texto").click(function(e){
		d3.select(this).classed( "selected", false);
		console.log(this);
		if (!e.shiftKey) {
			d3.selectAll( '.reciente, .texto').classed( "selected", false);
    	}
		$(this).attr("class",$(this).attr("class")+" selected");
	});
	
	$(".closeup").click(function() {
		$(".closeup").removeClass("act");
    	$(this).addClass("act");
    	$('#asig').show();
	});
	
	$(".click, .areaPublica").click(function() {
    	$('#asig').show();
	});
    	
});
</script>
<!-- Muestra boton para quitar asignacion-->
<script>
function test(id){
	$.post("<?=base_url()?>ajax/desasignar", {id : id},
		function(data) {
			if(data){
				location.reload();
			}
		},'json');
	};

$(".clean").click(function(){
	var id = $(this).attr("id");
    $("#infLocPl").html(" \
		<div class='field'><span><button onclick='test("+id+")' id='desAs' class='lightBot fleft'>Desasignar</button></div> \
	");
});
</script>

<!-- Busca informacion y la muestra en ventana -->
<script>
function clean(){
$("#infLocPl").empty();
}
$(function() {
	$(".click, .areaPublica, .cleanText").click(function(){
		clean();
		var id = $(this).attr("id");
		$("#idRec").html("*Asigna el numero de vector " + id);
		$("#statusVector").attr("title",id);
		$("#forma").removeAttr("disabled");
		$.post("<?=base_url()?>ajax/verLocalID", {
			id : id
		}, function(data) {
			if(jQuery.isEmptyObject(data.local)){
				$('#asigClick').show();
			}else{
				$("#sel1").text(data.local[0].estatusLocal);
				$("#infLocPlSt .field").remove();
				$("#infLocPl").html(" \
				<div class='field '><img src='http://www.apeplazas.com/apeConnect/assets/graphics/alert.png' /><i>Local no asignado</i></div> \
				");
			
				
			}
			
			$("#statusVector button").attr("id",data.Nvector[0].status);
		},'json');		
	});
	
			
	$(".actionMet").click(function() {
		var id        = $('.lineAc').attr("title");
		var status    = $(this).val();
		$.post("<?=base_url()?>ajax/statusVector", {id : id, status : status},
		
		function(data) {
			if(jQuery.isEmptyObject(data.local)){
				$("#statusLocal").attr("class","noAsignado");
			}
			$("#"+id).remove();
		},'json');
	});
	
	$(".actionBor").click(function() {
		var id        = $('.lineAc').attr("title");
		var status    = $(this).val();
		//$("polyline[id='"+id"']").remove();
		$.post("<?=base_url()?>ajax/statusVector", {id : id, status : status},
		
		
		function(data) {
			if(jQuery.isEmptyObject(data.local)){
				$("#statusLocal").attr("class","noAsignado");
			}
			$("#"+id).remove();
		},'json');
	});
	
			
	$("#asignar").click(function() {
		var id = $(this).attr("id");
		$("#forma").removeAttr("disabled");
		$.post("<?=base_url()?>ajax/asignarLocal", {
			id : id
		}, function(data) {
			if(jQuery.isEmptyObject(data.local)){
			}
			$("#statusVector").attr("title",id);
			$("#statusVector button").attr("id","habilitado");
		},'json');
				
	});
			
	$("#asig").submit(function(event) {
		event.preventDefault();

		var local		= $("#asigInp").val();
		var plazaId		= $("#plazaID").val();
		var vectores 	= $('.selected');
		var vectDos		= $('.click.selected');
		var vectoresData = [];
		
		$.each(vectores,function(key,val){
			vectoresData.push(val.id);
		});
				
		$.post("<?=base_url()?>ajax/asignarVectorPlano", {
			ids : vectoresData,
			plazaId : plazaId,
			local : local
					
		}, function(data) {
			console.log(data);
			if (data){
				$("#infLocPlSt").html("<div class='field '><img src='http://www.apeplazas.com/apeConnect/assets/graphics/palomita.png' /><i>Local: Activado</i></div>");
				$("#infLocPl .field").remove();
				$('#asigClick').hide();
				$.each(vectDos,function(key,val){
					$(val.nodeName+"[id='"+val.id+"']").attr("class", "clean");
					});
				}
			else{
				alert('No ha ajustado el texto')
			}
		},'json');
		$( "#asig" ).hide();
		
	});
	
});



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
var urlPost = (("https:" == document.location.protocol) ? "https://www.apeplazas.com/apeConnect/" : "http://www.apeplazas.com/apeConnect/");
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
		$("#asigInp").autocomplete(urlPost+"ajax/asignarLocales", {
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
<script>
var width = parseInt(svg.style("width")),
    height = parseInt(svg.style("height")),
    centered;
    
    d3.selectAll('.closeup').on('click',clicked);
    d3.selectAll('.click').on('click', function(d) {
	    
	d3.selectAll(".selected")
		.classed("reciente", true);
		
	d3.selectAll(".reciente")
		.classed("selected", false);
		
	if(this.classList.contains("reciente")) {
		d3.selectAll(".closeup")
		.classed("act", false);
		
        var id = d3.select(this).attr('id');
        
        var seleccion = d3.select("#path-"+id);
        seleccion.classed("act", true); 
        
    } 
	d3.select(this).classed("reciente", false);   
	d3.select(this).classed("selected", true);

});

function clicked(d) {
  var x, y, k;
  
  var vector = d3.select(this).attr('id');
  var vectorData = vector.split("-");
 
  var seleccion = d3.select(vectorData[0]+"[id='"+vectorData[1]+"']");
  d3.selectAll(".selected")
      .classed("reciente", true);
  d3.selectAll(".reciente")
      .classed("selected", false);
   
   seleccion.classed("reciente", false);   
   seleccion.classed("selected", true);
  
   if (seleccion && centered !== seleccion) {
    var centroid = getCentroid(seleccion);
    console.log(centroid);
    x = centroid[0];
    y = centroid[1];
    k = 6;
    centered = seleccion;
  } else {
	  console.log("si");
    x = width / 2;
    y = height / 2;
    k = 1;
    centered = null;
  }

  container.transition()
      .duration(750)
      .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")scale(" + k + ")translate(" + -x + "," + -y + ")");

}
function getCentroid(selection) {
    // get the DOM element from a D3 selection
    // you could also use "this" inside .each()
    var element = selection.node(),
        // use the native SVG interface to get the bounding box
        bbox = element.getBBox();
    // return the center of the bounding box
    return [bbox.x + bbox.width/2, bbox.y + bbox.height/2];
}
</script>