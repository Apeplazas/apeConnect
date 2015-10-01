<link rel="stylesheet" href="<?=base_url()?>assets/js/mocha/mocha.css" />
<script src="<?=base_url()?>assets/js/d3.v3.min.js"></script>
<h2 id="mainTitPlanoDos">Asignación de precios de locales disponibles</h2>
<h3 id="mainTitPlano">Locales disponibles</h3>
<div class="wrapListPlano">
	<div id="actionsPlano">
	<? $this->load->view('includes/toolbars/buscaPisos-toolbar');?>
	<? foreach($infoPlano as $p):?>
	<!-- Solo carga si encuentra mas pisos en los mapas -->
	<? $pisos = $this->planogramas_model->cargarPisos($p->plaza);?>
	<? if (count($pisos) != 1):?>
	<form id="piFor" method="post" action="<?=base_url()?>">
	<h1><?= $p->plaza;?> | pisos</h1>
	<fieldset>
		<select id="selPis">
			<? foreach($pisos as $pi):?>
			<option <? if($pi->id == $this->uri->segment(3)):?>selected<?endif?> value="<?= $pi->id?>"><?= $pi->piso?></option>
			<? endforeach; ?>
		</select>
	</fieldset>
	</form>
	<? endif; ?>
	
	<script>
	/********************************************************************************************************************
	 Manda a los planogramas de cada piso y se agarra del toolbar de ciudades y pisos
	********************************************************************************************************************/
	$("#selPis").change(function() {
		var action = $("#selPis").val();
		$("#piFor").attr("action", "<?=base_url()?>prospectos/<?= $this->uri->segment(2);?>/" + action);
		this.form.submit();
	});
	</script>
	
	<input type="hidden" id="text" style="width:100%">
	
		<div id="window" class="link">
			<button class="addToolSmallRi"><i class="iconWindow">Borrar</i></button>
			
			
			<div class="popup" tabindex="-1">
				<div  id="planoGrama" >
					<div id="formaRen">
						<form id="cotizarLocal" method="post" >
							<fieldset>
								<label>Nombre del grupo</label>
								<input class="inp" type="text" name="grupo" />
							</fieldset>
							<fieldset>
								<label>Rango de precio</label>
								<span class="rangos"><em>Minimo</em><input class="xtrSma soloNumeros" type="text" /></span>
								<span class="rangos"><em>Maximo</em><input class="xtrSma soloNumeros" type="text" /></span>
							</fieldset>
							<fieldset>
								<input tabindex="2" class="lightBot fright" type="submit" id="enviarAsignar" value="Asignar" />
							</fieldset>
						</form>
					</div>
					
					
				</div>
			</div>
		</div>
	</div>
	
	
	
	
	
	
	
	<div id="plano">
		<span class="inf"><img src="<?=base_url()?>assets/graphics/informativoVerPlano.png" alt="Mapa informativo" /></span>
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
			<rect id="<?= $rowA->id;?>" class="areaPublica" y="<?=$rowA->y;?>" width="<?=$rowA->width;?>" height="<?=$rowA->height;?>"/>
			<? endif;?>
			<? endforeach; ?>
			
			
			<? foreach($locales as $row): 
				$fechaExpiracion = marcaRenovaciones($row->fechaEmision);
				$class = 'click habilitado ';
				if ($fechaExpiracion):
					$class .= 'Expirado ';
				else:
					if(!$row->status):
						$class .= 'sinAsignar ';
					else:
						$class .= $row->status;
					endif;
				endif;
			?>
			
			
			
			<? if($row->tipo == 'polyline'): ?>
			<polyline id="<?= $row->id;?>" class="<?=$class?>" 
			points="<?= $row->points;?>"/>
			<? elseif ($row->tipo == 'path'):?>
			<path  id="<?= $row->id;?>" d="<?= $row->d;?>" class="<?=$class?>" />
			<? elseif ($row->tipo == 'line'):?>
			<line id="<?= $row->id;?>" class="<?=$class?>" x1="<?= $row->x1;?>" y1="<?= $row->y1;?>" x2="<?= $row->x2;?>" y2="<?= $row->y2;?>" />
			<? elseif ($row->tipo == 'polygon'):?>
			<polygon id="<?= $row->id;?>" class="<?=$class?>" points="<?=$row->points;?>"/>
			<? elseif ($row->tipo == 'rect'):?>
			<rect id="<?= $row->id;?>" class="<?=$class?>" x="<?=$row->x;?>" y="<?=$row->y;?>" width="<?=$row->width;?>" height="<?=$row->height;?>"/>
			<? endif;?>
			<? endforeach; ?>
							
			<? foreach($texto as $r):?>
			<? $uno = $this->planogramas_model->traerID($r->planogramaID, $r->localID, 2);?>	
				<? foreach($uno as $u):?>
				<text id="<?=$u->id?>" title="<?=$u->Clavedelocal?>" class="texto" transform="<?=$u->transform?>" >
			
					<?= $u->local;?>
				
				</text>
				<? endforeach; ?>
			
			<? $dos = $this->planogramas_model->traerID($r->planogramaID, $r->localID, 3);?>	
				<? foreach($dos as $d):?>
				<text id="<?=$d->id?>" title="<?=$d->Clavedelocal?>" class="texto" transform="<?=$d->transform?>" >
				
				<?=$d->FechaEmision?>
				</text>
				<? endforeach; ?>
						
			<? $tres = $this->planogramas_model->traerID($r->planogramaID, $r->localID, 4);?>	
				<? foreach($tres as $t):?>
				<text id="<?=$t->id?>" title="<?=$t->Clavedelocal?>" class="texto" transform="<?=$t->transform?>" >
				$ <?= $t->precioLocal;?></text>
				<? endforeach; ?>
			<? endforeach; ?>
			
			
			
			
			
			</g>
			</svg>
			</div>
			
			
			
			
			
			
		</div>
	</div>
<? endforeach; ?>
</div>
<!-- Manda la busqueda de segmento al seleccionar el filtro -->
<script type="text/javascript">
$(".busqueda").change(function() {
	var action = $("#busquedaUno").val() + "/" +$("#busquedaDos").val() + "/" +$("#busquedaTres").val();
	$("#formaRen").attr("action", "<?=base_url()?>prospectos/verplano/<?=$this->uri->segment(3)?>/" + action);
});
</script>
<!-- Busca informacion y la muestra en ventana -->
<script>
function clean(){
$("#infLocPl").empty();
}
$(function() {
	$(".habilitado, .deshabilitado, .seleccionado, .areaPublica, .reciente").click(function(){
		clean();
		var id = $(this).attr("id");
		$("#formaRen").removeAttr("disabled");
		$.post("<?=base_url()?>ajax/verLocalID", {
			id : id
		}, function(data) {
			if(jQuery.isEmptyObject(data.local)){
				$('#asigClick').show();
				$("#statusLocal").html('<em>Segmento no asignado</em>');
			}else{
				$("#sel1").text(data.local[0].estatusLocal);
				$("#infLocPl").html(" \
				<div class='field'><span>Nombre: </span><em> "+data.cliente[0].Nombre+"</em></div> \
				<div class='field'><span>Plaza: </span><em> "+data.local[0].Plaza+"</em></div> \
				<div class='field'><span># Contrato: </span><em> "+data.local[0].Contrato+"</em></div> \
				<div class='field'><span>Contrato: </span><em> "+data.local[0].EstatusContrato+"</em></div> \
				<div class='field'><span>Fecha alta: </span><em> "+data.local[0].FechaEmision+"</em></div> \
				<div class='field'><span>Estatus: </span><em> "+data.local[0].EstatusLocal+"</em></div> \
				<div class='field'><span>Importe: </span><em> "+data.cliente[0].Importe+"</em></div> \
				<div class='field'><span>Plaza: </span><em> "+data.cliente[0].Plaza+"</em></div> \
				");
				if (data.local[0].contrato != ''){
					$("#infLocPl").append(" \
					<div class='field'><span>Contrato: </span><em> "+data.cliente[0].Contrato+"</em></div> \
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
		$("#formaRen").removeAttr("disabled");
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
/********************************************************************************************************************
D3.JS CARGA FRAMEWORK PARA SV
********************************************************************************************************************/
var zoom = d3.behavior.zoom()
    .scaleExtent([1, 10])
    .on("zoom", zoomed);
    
var svg = d3.select("#Layer1").call(zoom);
svg.on("click",click);
svg.on("dblclick",dblclick);

var container = d3.select("g");

var path = container.append("path")
	.style("stroke-width", ".5px")
    .style("stroke", "#ccc")
    .style("fill", "#eee")
    .attr("id", "newPath");

// This function sets the path from the input text
function redraw() {
  path.attr("d", $('#text').val());
}

function click(d){
	if (d3.event.shiftKey) {
		d3.event.stopPropagation();
		var t = d3.transform(container.attr("transform")),
	    	xt = t.translate[0],
	    	yt = t.translate[1],
	    	s = zoom.scale();
	
		var p = d3.mouse(this);
		var x = (p[0] - (xt))/s;
	  	var y = (p[1] - (yt))/s;
	  	var oldpath = $('#text').val();
	  	if (!oldpath.match(/M/) || oldpath.match(/Z/)) {
	    	$('#text').val('M ' + x + ' ' + y);
	  	} else {
	    	$('#text').val(oldpath + ' ' + x + ' ' + y);
	  	}
	  	redraw();
  	}
}

function dblclick(d) {
	d3.event.stopPropagation();
  	var oldpath = $('#text').val();
  	$('#text').val(oldpath + ' Z');
  	redraw();
}

$('#guardarPath').click(function(){
	var coordPath = d3.select('#newPath').attr("d");
	var idPLano = "<?php echo $this->uri->segment(3);?>";

	$.ajax({
		data : {'idPlano':idPLano,"coords":coordPath},
		dataType : 'json',
		url : ajax_url + 'agregarPath',
		type : 'post',
	});
	
	var action = $("#busquedaUno").val() + "/" +$("#busquedaDos").val() + "/" +$("#busquedaTres").val();
	$("#formaRen").attr("action", "<?=base_url()?>prospectos/verplano/<?=$this->uri->segment(3)?>/" + action);

});




function zoomed() {
  container.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
}

</script>

<script>
/********************************************************************************************************************
Ajax para el autocompletar
********************************************************************************************************************/
var urlPost = (("https:" == document.location.protocol) ? "https://www.apeplazas.com/apeConnect/" : "http://www.apeplazas.com/apeConnect/");
jQuery(function($) {
	$(function() {

		$(".DESOCUPADO").click(function(e){
			d3.select(this).classed( "selected", false);
			if (!e.shiftKey) {
				d3.selectAll( '.DESOCUPADO').classed( "selected", false);
	    	}
			$(this).attr("class",$(this).attr("class")+" selected");
		});
		
		$(".sinAsignar, .Expirado").click(function(){
			d3.selectAll(".click").classed( "selected", false);
		});

		$("#cotizarLocal").submit(function(event) {
			event.preventDefault();

			var vectores 	= $('.selected');
			var vectoresData = [];
			
			$.each(vectores,function(key,val){
				vectoresData.push(val.id);
			});
					
			$.post("http://www.apeplazas.com/apeConnect/ajax/cotizarLocalProspecto", {
				ids : vectoresData
			}, function(data) {
				if (data){
					
				}else{
					alert('No ha ajustado el texto')
				}
			},'json');
		});

		
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
