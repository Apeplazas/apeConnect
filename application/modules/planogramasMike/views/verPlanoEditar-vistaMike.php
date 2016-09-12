<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<? foreach($infoPlano as $p):?>
<script src="<?=base_url()?>assets/js/d3.v3.min.js"></script>
<div class="wrapList" id="wrapListPlano">
	<div id="actions">
		<? $this->load->view('includes/toolbars/buscaPisos-toolbar');?>

		<input type="hidden" id="text" style="width:100%">

		<div id="window" class="link">
			<div id="rigWinClose" tabindex="-1">
				<div  id="planoGrama" >
				<span class="secTit"><em>Grupos</em></span>
					<div id="formato">
						
						<div id="infoCuentaVer">
							<div id="statusLocal"></div>
						</div>
					    <div id="infLocPl"></div>
                        	<div id="desc"></div>
					</div>
				</div>
			</div>
		</div>
	<? $this->load->view('includes/toolbars/planoGramas');?>
	</div>

<div id="plano">

	<div id="pan-parent">
		<div id="panzoom">
		<svg class="grid" version="1.1" id="Layer1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 900 500" enable-background="new 0 0 900 500" xml:space="preserve">
		<g>
		<? foreach($areaPublica as $rowA): ?>
		<? if($rowA->tipo == 'polyline'): ?>
		<polyline id="<?= $rowA->id;?>" class="areaPublica" points="<?= $rowA->points;?>" />
		<? elseif ($rowA->tipo == 'path'):?>
		<path  id="<?= $rowA->id;?>" d="<?= $rowA->d;?>" class="areaPublica" />
		<? elseif ($rowA->tipo == 'line'):?>
		<line id="<?= $rowA->id;?>" class="areaPublica" y1="<?= $rowA->y1;?>" x2="<?= $rowA->x2;?>" y2="<?= $rowA->y2;?>" />
		<? elseif ($rowA->tipo == 'polygon'):?>
		<polygon id="<?= $rowA->id;?>" class="areaPublica" points="<?=$rowA->points;?>" />
		<? elseif ($rowA->tipo == 'rect'):?>
		<rect id="<?= $rowA->id;?>" class="areaPublica" y="<?=$rowA->y;?>" width="<?=$rowA->width;?>" height="<?=$rowA->height;?>" />
		<? endif;?>
		<? endforeach; ?>


		<? foreach($locales as $row):
			$fechaExpiracion = '';//marcaRenovaciones($row->fechaEmision);
			$class = 'click habilitado ';
			
				if(!$row->status):
					$class .= 'sinAsignar ';
				else:
					$class .= $row->EstatusContrato;
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
		<polygon id="<?= $row->id;?>" class="<?=$class?>" points="<?=$row->points;?>" />
		<? elseif ($row->tipo == 'rect'):?>
		<rect id="<?= $row->id;?>" class="<?=$class?>" x="<?=$row->x;?>" y="<?=$row->y;?>" width="<?=$row->width;?>" height="<?=$row->height;?>"/>
		<? endif;?>
		<? endforeach; ?>

		<? foreach($texto as $r):?>
		<? $uno = $this->planogramas_model->traerID($r->planogramaID, $r->localID, 2);?>
			<? foreach($uno as $u):?>
			<text id="<?=$u->id?>" title="<?=$u->Clavedelocal?>" class="texto" transform="<?=$u->transform?>" >
			<? if ($this->uri->segment(4)):?>
				<? if($this->uri->segment(4) == 'Importe' && $d->{$this->uri->segment(4)} != ''):?>$<?endif?> <?= $u->{$this->uri->segment(4)};?>
			<? else:?>	
				<? if ($u->Local != ''):?>Local <?= $u->Local;?><?endif?>
			<? endif;?>
			</text>
			<? endforeach; ?>

		<? $dos = $this->planogramas_model->traerID($r->planogramaID, $r->localID, 3);?>
			<? foreach($dos as $d):?>
			<text id="<?=$d->id?>" title="<?=$d->Clavedelocal?>" class="texto" transform="<?=$d->transform?>" >
			<? if ($this->uri->segment(5)):?>
				<? if($this->uri->segment(5) == 'Importe' && $d->{$this->uri->segment(5)} != ''):?>$<?endif?> <?= $d->{$this->uri->segment(5)};?>
			<? else:?>
			<?=$d->FechaEmision?>
			<? endif;?>
			</text>
			<? endforeach; ?>

		<? $tres = $this->planogramas_model->traerID($r->planogramaID, $r->localID, 4);?>
			<? foreach($tres as $t):?>
			<text id="<?=$t->id?>" title="<?=$t->Clavedelocal?>" class="texto" transform="<?=$t->transform?>" >
			<? if ($this->uri->segment(6)):?>
				<? if($this->uri->segment(6) == 'Importe' && $d->{$this->uri->segment(6)} != ''):?>$<?endif?> <?= $t->{$this->uri->segment(6)};?>
			<? else:?>
				<? if ($t->Importe != ''):?>$ <?= $t->Importe;?><?endif?>
			<? endif;?>
			</text>
			<? endforeach; ?>
		<? endforeach; ?>





		</g>
		</svg>
		</div>






	</div>
</div>
<? endforeach; ?>


<div id="modal" tabindex="-1" hidden="hidden()">
  <div  id="ventanamodal" >
    <span class="secTit">
    	<p align="right" onclick="cierre()" style="padding: 1px 8px; cursor: pointer;">X</p>
    	<em>INFORMACIÓN DEL LOCAL</em>
     </span>
    	<div id="status"></div>
        	<div id="formato">
            	<div id="infoCuentaVer"></div>
            		<div id="inf"> </div>
        	</div>
  	</div>
</div>
<!-- Busca informacion y la muestra en ventana -->
<script>
function clean(){
$("#infLocPl").empty();
}
$(function() {
	$(".VENCIDO").click(function(){
		clean();
		
		$("#rigWinClose").show();
		$("#panelRight").addClass("panelRight");
		var id = $(this).attr("id");
		$("#forma").removeAttr("disabled");
		
		$.post("<?=base_url()?>ajax/verLocalID", {
			id : id
		}, function(data) {
			if(jQuery.isEmptyObject(data.local)){
				
			}else{
				
				$("#infLocPl").html(" \
				<div class='fieldText'><span>Nombre del grupo: </span></div> \
				<input type='text' name='nombre' id='nombre' required placeholder='Nombre_1' >\
				<div class='fieldText'><span>Minimo: </span></div> \
				<input type='text' name='minimo' id='minimo' placeholder='1000' required>\
				<div class='fieldText'><span>Máximo: </span></div> \
				<input type='text' name='maximo' id='maximo' placeholder='2000' required><br>\
				<select name='periodo' id='periodo' required><option value=''>Seleccione una opción</option><option value='q1'>Primer cuatrimestre</option><option value='q2'>Segundo cuatrimestre</option><option value='q3'>Tercer cuatrimestre</option></select> \
				<button id='grupo' >Crear grupo</button> \
				<button id='btndesc'>agregar descuento</button> \
				<div id='modal1' tabindex='-1' hidden='hidden()'><p align='center' style='padding: 0px 0px; cursor: pointer;'>_____________________________________</p><p align='right' onclick='cierree()' style='padding: 0px 24px; cursor: pointer;'>X</p><em>DESCUENTOS</em><br><br><em>Monto del descuento: </em><input type='text' name='descuento' id='descuento'></div>\
				");
				
      		
				
				$("#btndesc").click(function (){
				$("#modal1").show(); 
				});

				$('#grupo').click(function(){
					
					//window.location.reload(true);
					$option = $('#periodo');
					var vectores 	= $('.seleccionado');
					var vectoresData = [];
					var nombre  =  $("#nombre").val();
					var minimo  =  $("#minimo").val();
					var maximo  =  $("#maximo").val();
					var descuento  =  $("#descuento").val();
					var periodo	=	($option).val();
					
					$.each(vectores,function(key,val){
					  vectoresData.push(val.id);
					  
					});
					if(nombre=='' | periodo==''){
						alert('Los campos estan incompletos, intenta de nuevo');
						
					}
					else{
						$.post('<?=base_url()?>ajax/agruparLocales', {
										id : vectoresData,
										nombre : nombre,
										minimo : minimo,
										maximo : maximo,
										descuento : descuento,
										periodo	:	periodo
					},'json');
					alert('Grupo creado con exito');
					window.location='<?=base_url()?>planogramasMike/propuestaRenovacion';
					}
					
					
				});
				
			}
			
			
		},'json');
		
	});
	

	$("#habilitado").change(function() {
		var id        = $('.lineAc').attr("title");
		var status    = $(this).val();
		$.post("<?=base_url()?>ajax/statusVector", {id : id, status : status},

		function(data) {
			if(jQuery.isEmptyObject(data.local)){
				$("#statusLocal").attr("class","noAsignado");
				$("#statusLocal").html('<div class="field"><img src="<?=base_url()?>assets/graphics/svg/warning.svg" /><i>Local no asignado</i></div>');
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
				$("#statusLocal").html('<div class="field"><img src="<?=base_url()?>assets/graphics/svg/warning.svg" /><i>Local no asignado</i></div>');
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
			$("#statusLocal").html('<div class="field"><img src="<?=base_url()?>assets/graphics/svg/warning.svg" /><i>Local no asignado</i></div>');
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
	$("#forma").attr("action", "<?=base_url()?>planogramas/verplano/<?=$this->uri->segment(3)?>/" + action);

});


var drag = d3.behavior.drag()
	.on("dragstart", dragstarted)
    .on("drag", dragmove)
    .on("dragend", dragended);

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
/********************************************************************************************************************
Ajax para el autocompletar
********************************************************************************************************************/
var urlPost = (("https:" == document.location.protocol) ? "https://www.apeplazas.com/apeConnect/" : "<?=base_url()?>");
jQuery(function($) {
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
<script>
/**************************************************************************************
Seleccion de multiples locales
****************************************************************************************/
$(".click").click(function(e){

			$('#winRight').removeClass('barClose');
			$('#winRight').addClass('barOpen');
			$('#botCot').removeClass('botAcCotNone');
			$('#botCot').addClass('botAcCot');

			var vectoreData = this.id;
			var current = this;
			if ( $(this).attr("class").search("VENCIDO") > 0 ) {
				$(this).attr("class",$(this).attr("class")+" seleccionado");
				
				$.post("<?=base_url()?>ajax/obtenerLocalInfo", {
					id : vectoreData
				}, function(data) {
					if (data){
						if (data[0].Nombre){
							//window.location.reload();
							//$('#datos-cotizacion').append('<div id="local-cot-'+vectoreData+'" class="fieldText"><span class="rnot remove-cot-'+vectoreData+' remove-cot">Borrar</span><span>'+data[0].Nombre+'</span><em>  $'+data[0].precioLocal+'</em></div>');
							$('.remove-cot-'+vectoreData).on('click',function(){
								var current 	= $(this).closest('div');
								var vectorData 	= $(this).closest('div').attr('id');
								var arr 		= vectorData.split('-');
								var vectoreData = arr[2];
								$('#'+vectoreData).attr("class","click habilitado VENCIDO");

								$.post("<?=base_url()?>ajax/eliminarLocalCotizacion", {
									id : vectoreData
								}, function(data) {
									current.remove();
								},'json');

							});
						}
					}else{
						alert('No hay información de este local')
					}
				},'json');
				d3.selectAll('.seleccionado').classed( "VENCIDO", false);
			}
			else if( $(this).attr("class").search("seleccionado") > 0 ){
				$(this).attr("class",$(this).attr("class")+" VENCIDO");
				$.post("http://www.apeplazas.com/apeConnect/ajax/eliminarLocalCotizacion", {
					id : vectoreData
				}, function(data) {
					$('#local-cot-'+vectoreData).remove();
				},'json');
				d3.selectAll('.VENCIDO').classed( "seleccionado", false);
			}

		});
</script>



<script>
	$(document).ready(function(){ 
  $("table").oncontextmenu = function() {return false;};

  $(".habilitado.VENCIDO ").on("mousedown",function(e){ 
    if( e.button == 2 ) { 
	  $("#modal").show(); 
	  $("#panelRight").addClass("panelRight");
		var id = $(this).attr("id");
		$("#forma").removeAttr("disabled");
		$.post("<?=base_url()?>ajax/verLocalID", {
			id : id
		}, function(data) { 
			if(jQuery.isEmptyObject(data.local)){
				$('#asigClick').show();
				$("#status").html('<div class="field"><img src="<?=base_url()?>assets/graphics/svg/warning.svg" /><i>Local Desocupado</i></div>');
			}else{
				$("#sel1").text(data.local[0].estatusLocal);
				$("#inf").html(" <br> \
				<div class='fieldText'><span>Nombre: </span><em> "+data.cliente[0].Nombre+"</em></div> \
				<div class='fieldText'><span>Plaza: </span><em> "+data.local[0].Plaza+"</em></div> \
				<div class='fieldText'><span>Contrato: </span><em> "+data.local[0].Contrato+"</em></div> \
				<div class='fieldText'><span>Fecha alta: </span><em> "+data.local[0].FechaEmision+"</em></div> \
				<div class='fieldText'><span>Estatus: </span><em> "+data.local[0].EstatusLocal+"</em></div> \
				<div class='fieldText'><span>Importe: </span><em> "+data.cliente[0].Importe+"</em></div> \
				");
				
				$("#status").attr("class","asignado");
				$("#status").html("<div id='statVer' class='field'><img src='<?=base_url()?>assets/graphics/svg/warning.svg' /><i>Local asignado</i></div>");
				$("#status").attr("class","asignado");

			}
			$("#statusVector").attr("title",id);
			$("#statusVector button").attr("id",data.Nvector[0].status);
		},'json');
      
	  return false; 
    } 
    return true; 
  }); 
});
</script>

<script>
function cierre(){
$("#modal").hide();
}
</script>
<script>
function cierree(){
$("#modal1").hide();
}
</script>
<script language=JavaScript>
function inhabilitar(){ 
   	return false 
} 
document.oncontextmenu=inhabilitar 
</script>

   


