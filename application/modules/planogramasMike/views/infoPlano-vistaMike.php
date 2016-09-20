<script src="<?=base_url()?>assets/js/d3.v3.min.js"></script>
<? foreach($infoPlano as $p):?>

<div class="wrapList" id="wrapListPlano">
	<div id="actions">
		<? $this->load->view('includes/toolbars/buscaPisos-toolbar');?>
		<input type="hidden" id="text" style="width:100%">
		<!-- Empieza boton con ventana de planogramas -->
		<div id="window" class="link">
			<div id="rigWinClose" class="popup" tabindex="-1">
				<!-- Empieza ventana informativa de planogramas -->
				<div  id="planoGrama" >
					<span class="secTit"><em>RENOVACIONES</em></span>
						<div id="actTod">
						<div id="infLocPl"></div>
							
						</div>
					
					
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


		 		<? foreach($areaPublica as $rowA): ?>
				<? if($rowA->tipo == 'polyline'): ?>
				<polyline id="<?= $rowA->id;?>" class="areaPublica" points="<?= $rowA->points;?>"/>
				<? elseif ($rowA->tipo == 'path'):?>
				<path  id="<?= $rowA->id;?>" d="<?= $rowA->d;?>" class="areaPublica" />
				<? elseif ($rowA->tipo == 'line'):?>
				<line id="<?= $rowA->id;?>" class="areaPublica" y1="<?= $rowA->y1;?>" x2="<?= $rowA->x2;?>" y2="<?= $rowA->y2;?>" />
				<? elseif ($rowA->tipo == 'polygon'):?>
				<polygon id="<?= $rowA->id;?>" class="areaPublica" points="<?=$rowA->points;?>"/>
				<? elseif ($rowA->tipo == 'rect'):?>
				<rect id="<?= $rowA->id;?>" class="areaPublica" y="<?=$rowA->y;?>" x="<?=$rowA->x;?>" width="<?=$rowA->width;?>" height="<?=$rowA->height;?>"/>
				<? endif;?>
				<? endforeach; ?>


				<? foreach($locales as $row): ?>
				<? if($row->tipo == 'polyline'): ?>
				<g class="poly">
				<polyline id="<?= $row->id;?>" class="<? if($row->localID == ''):?>click reciente bgrayAsig<?else:?>clean<?endif;?>" points="<?= $row->points;?>"/>
				</g>
				<? elseif ($row->tipo == 'path'):?>
				<g class="path">
				<path  id="<?= $row->id;?>" d="<?= $row->d;?>" class="<? if($row->localID == ''):?>click reciente bgrayAsig<?else:?>clean<?endif;?>"  />
				</g>
				<? elseif ($row->tipo == 'line'):?>
				<g class="line">
				<line id="<?= $row->id;?>" class="<? if($row->localID == ''):?>click reciente bgrayAsig<?else:?>clean<?endif;?>" x1="<?= $row->x1;?>" y1="<?= $row->y1;?>" x2="<?= $row->x2;?>" y2="<?= $row->y2;?>" />
				</g>
				<? elseif ($row->tipo == 'polygon'):?>
				<g class="polyg">
				<polygon id="<?= $row->id;?>" class="<? if($row->localID == ''):?>click reciente bgrayAsig<?else:?>clean<?endif;?>" points="<?=$row->points;?>"/>
				</g>
				<? elseif ($row->tipo == 'rect'):?>
				<g class="rect">
				<rect x="<?=$row->x?>" y="<?=$row->y;?>"  id="<?= $row->id;?>" class="<? if($row->localID == ''):?>click reciente bgrayAsig<?else:?>clean<?endif;?>" width="<?=$row->width;?>" height="<?=$row->height;?>"/>
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
		<div class='field'><span><button onclick='test("+id+")' id='desAs' class='mainBottonSmaDes'>Desasignar</button></div> \
	");
});
</script>

<!-- Busca informacion y la muestra en ventana -->
<script>
function clean(){
$("#infLocPl").empty();
}
$(function() {
	$(".click, .areaPublica, .cleanText, .clean").click(function(){
		clean();
		$("#rigWinClose").show();
		$("#panelRight").addClass("panelRight");
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
				$("#infLocPl").html(" \
				<div class='content-box-yellow'><span>Renta por debajo del promedio </span></div>\
				<div class='content-box-orange'><span>Renta igual al promedio </span></div>\
				<div class='content-box-red'><span>Renta por arriba del promedio </span></div>\
				<div class='content-box-green'><span>Renovados </span></div>\
				<div class='content-box-blue'><span>No rentados </span></div>\
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
				$("#infLocPlSt").html("<div class='field '><img src='<?=base_url()?>assets/graphics/palomita.png' /><i>Local: Activado</i></div>");
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
		$("#asigInp").autocomplete({
			source: ajax_url+"asignarLocales",
			open: function(){
		        $(this).autocomplete('widget').css('z-index', 9999);
		        return false;
		    }
		});
	/*
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
	*/
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
