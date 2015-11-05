<link rel="stylesheet" href="<?=base_url()?>assets/js/mocha/mocha.css" />
<script src="<?=base_url()?>assets/js/d3.v3.min.js"></script>
<div id="mainTit">
<h3>Locales disponibles</h3>
</div
>
<div class="wrapList">
	<div id="actions">
	<? foreach($infoPlano as $p):?>
	<!-- Solo carga si encuentra mas pisos en los mapas -->
	<? $pisos = $this->planogramas_model->cargarPisos($p->plaza);?>
	<? if (count($pisos) != 1):?>
	<form id="piFor" method="post" action="<?=base_url()?>">
	<h1>pisos</h1>
	<fieldset>
		<select id="selPis">
			<? foreach($pisos as $pi):?>
			<option <? if($pi->id == $this->uri->segment(3)):?>selected<?endif?> value="<?= $pi->id?>"><?= $pi->piso?></option>
			<? endforeach; ?>
		</select>
	</fieldset>
	</form>

	<span class="back">
	 <a class="addSmall" href="javascript:window.history.go(-1);">
		 <i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/back.svg" alt="Regresar"></i>
		 <span>Regresar</span>
	 </a>
	</span>
	<? endif; ?>

	<input type="hidden" id="text" style="width:100%">
	</div>







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
						if($row->status == "DESOCUPADO"){
							if(in_array($row->id,$cotizacion['locales']))
								$class .= "cotizado";
							else
								$class .= $row->status;
						}else{
							$class .= $row->status;
						}
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
				<? if ($this->uri->segment(4)):?>
					<? if($this->uri->segment(4) == 'Importe' && $d->{$this->uri->segment(4)} != ''):?>$<?endif?>
				<? else:?>
					<? if ($u->Local != ''):?>Local <?= $u->Local;?><?endif?>
				<? endif;?>
				</text>
				<? endforeach; ?>

			<? $dos = $this->planogramas_model->traerID($r->planogramaID, $r->localID, 3);?>
				<? foreach($dos as $d):?>
				<text id="<?=$d->id?>" title="<?=$d->Clavedelocal?>" class="texto" transform="<?=$d->transform?>" >
				<? if ($this->uri->segment(5)):?>
					<? if($this->uri->segment(5) == 'Importe' && $d->{$this->uri->segment(5)} != ''):?>$<?endif?>
				<? else:?>
				<?=$d->FechaEmision?>
				<? endif;?>
				</text>
				<? endforeach; ?>

			<? $tres = $this->planogramas_model->traerID($r->planogramaID, $r->localID, 4);?>
				<? foreach($tres as $t):?>
				<text id="<?=$t->id?>" title="<?=$t->Clavedelocal?>" class="texto" transform="<?=$t->transform?>" >
				<? if ($this->uri->segment(6)):?>
					<? if($this->uri->segment(6) == 'Importe' && $d->{$this->uri->segment(6)} != ''):?>$<?endif?>
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
<br class="clear">
</div>


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
	$("#forma").attr("action", "<?=base_url()?>prospectos/verplano/<?=$this->uri->segment(3)?>/" + action);

});




function zoomed() {
  container.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
}

</script>

<script>
		$('.remove-cot').on('click',function(){
			var current 	= $(this).closest('div');
			var vectorData 	= $(this).closest('div').attr('id');
			var arr 		= vectorData.split('-');
			var vectoreData = arr[2];
			$('#'+vectoreData).attr("class","click habilitado DESOCUPADO");

			$.post("http://www.apeplazas.com/apeConnect/ajax/eliminarLocalCotizacion", {
				id : vectoreData
			}, function(data) {
				current.remove();
			},'json');

		});
var urlPost = (("https:" == document.location.protocol) ? "https://www.apeplazas.com/apeConnect/" : "http://www.apeplazas.com/apeConnect/");
jQuery(function($) {
	$(function() {

		$(".click").click(function(e){

			$('#winRight').removeClass('barClose');
			$('#winRight').addClass('barOpen');
			$('#botCot').removeClass('botAcCotNone');
			$('#botCot').addClass('botAcCot');

			var vectoreData = this.id;
			var current = this;
			if ( $(this).attr("class").search("DESOCUPADO") > 0 ) {
				$(this).attr("class",$(this).attr("class")+" cotizado");
				$.post("http://www.apeplazas.com/apeConnect/ajax/obtenerLocalInfo", {
					id : vectoreData
				}, function(data) {
					if (data){
						if (data[0].Nombre){
							//window.location.reload();
							$('#datos-cotizacion').append('<div id="local-cot-'+vectoreData+'" class="fieldText"><span class="rnot remove-cot-'+vectoreData+' remove-cot">Borrar</span><span>'+data[0].Nombre+'</span><em>  $'+data[0].precioLocal+'</em></div>');
							$('.remove-cot-'+vectoreData).on('click',function(){
								var current 	= $(this).closest('div');
								var vectorData 	= $(this).closest('div').attr('id');
								var arr 		= vectorData.split('-');
								var vectoreData = arr[2];
								$('#'+vectoreData).attr("class","click habilitado DESOCUPADO");

								$.post("http://www.apeplazas.com/apeConnect/ajax/eliminarLocalCotizacion", {
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
				d3.selectAll('.cotizado').classed( "DESOCUPADO", false);
			}
			else if( $(this).attr("class").search("cotizado") > 0 ){
				$(this).attr("class",$(this).attr("class")+" DESOCUPADO");
				$.post("http://www.apeplazas.com/apeConnect/ajax/eliminarLocalCotizacion", {
					id : vectoreData
				}, function(data) {
					$('#local-cot-'+vectoreData).remove();
				},'json');
				d3.selectAll('.DESOCUPADO').classed( "cotizado", false);
			}

		});

		$(".sinAsignar, .Expirado").click(function(){
			d3.selectAll(".click").classed( "selected", false);
		});

		$("#cotizarLocal").click(function(event) {
			event.preventDefault();

			var vectores 	= $('.selected');
			var vectoresData = [];

			$.each(vectores,function(key,val){
				vectoresData.push(val.id);
			});

			$.post("http://www.apeplazas.com/apeConnect/ajax/agregarLocalCotizacion", {
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

});
</script>
