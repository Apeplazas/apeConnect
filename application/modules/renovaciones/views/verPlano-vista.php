<? foreach($infoPlano as $p):?>
<script src="<?=base_url()?>assets/js/d3.v3.min.js"></script>

<h3 id="mainTitPlano">Planograma <?= $p->plaza;?> | Nivel <?= $p->piso;?></h3>
<div class="wrapListPlano">
	<div id="actionsPlano">
		<? $this->load->view('includes/toolbars/buscaPisos-toolbar');?>
		<input type="hidden" id="text" style="width:100%">
	
		<div id="window" class="link">
			<button class="addToolPlano"><i class="iconWindow">Ventana</i></button>
			<div class="popup" tabindex="-1">
				<div  id="planoGrama" >
				<span class="secTit"><em>Asignacion</em></span>
				<form id="group-locales" method="post" action="#">
				  <fieldset>
					<label>Nombre del grupo</label>
					<input class="smaInpRen" type="text" name="grupo_nombre" id="grupo_nombre" />
				  </fieldset>
				  <fieldset>
					<label>Costo minimo</label>
					<input class="smaInpRen" type="number" name="costo-min" id="costo-min" />
				  </fieldset>
				  <fieldset>
					<label>Costo máximo</label>
					<input class="smaInpRen" type="number" name="costo-max" id="costo-max" />
				  </fieldset>
				 
				  <fieldset>
					<input class="botonCotizRen" type="submit" value="Agrupar" />
				  </fieldset>
				</form>
				
					<div id="formato">
						<i class="topArrow"><img src="<?=base_url()?>assets/graphics/topArrow.png" alt="Señalización" /></i>
						<div id="infoCuentaVer">
							<div id="statusLocal"></div>
						</div>
					    <div id="infLocPl"></div>
					</div>
				</div>
			</div>
		</div>
	<? $this->load->view('includes/toolbars/planoGramas');?>
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
		<rect id="<?= $rowA->id;?>" class="areaPublica" y="<?=$rowA->y;?>" x="<?=$rowA->x;?>" width="<?=$rowA->width;?>" height="<?=$rowA->height;?>"/>
		<? endif;?>
		<? endforeach; ?>
		
		
		<?
		$datosGrupos = array(); 
		foreach($locales as $row):
			$fechaExpiracion = marcaRenovaciones($row->fechaEmision);
			$class = 'click habilitado ';
			if(!empty($row->grupoId)){
				$datosGrupos[$row->grupoId] = $this->renovaciones_model->obtener_grupo($row->grupoId);
				$class .= 'grupo-'.$row->grupoId;
			}elseif($row->status != "RENTADO"){
				$class .= 'sinAsignar ';
			}else{
				$class .= $row->status;
			}
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
		
	<?if(!empty($datosGrupos)) : foreach($datosGrupos as $grupo):?>
			<?= $grupo->grupo_nombre;?>
			<?= $grupo->{'costo-min'};?>
			<?= $grupo->{'cost-max'};?>
	<?php endforeach;?>
	<? endif;?>	
		
		
		
		
	</div>
</div>
<? endforeach; ?>
<!-- Busca informacion y la muestra en ventana -->
<script>
$(function() {

	$(".RENTADO").click(function(e){

		if(d3.select(this).classed( "selected"))
			d3.select(this).classed( "selected", false);
		else
			d3.select(this).classed( "selected", true);

	});

	$("#group-locales").submit(function(event) {
		event.preventDefault();
		var vectores 	= $('.selected');
		var vectoresData = [];
		var cost_min = $('#costo-min').val();
		var cost_max = $('#costo-max').val();
		var grupo_nombre = $('#grupo_nombre').val();

		$.each(vectores,function(key,val){
			vectoresData.push(val.id);
		});
				
		$.post("http://www.apeplazas.com/apeConnect/ajax/agruparLocales", {
			ids : vectoresData,
			cost_min : cost_min,
			cost_max : cost_max,
			grupo_nombre : grupo_nombre
		}, function(data) {
			if (data){
				window.location.reload();
			}else{
				alert('ha ocurrido un error')
			}
		},'json');
	});

/*
	$(".habilitado").click(function(){

		var id = $(this).attr("id");
		$("#forma").removeAttr("disabled");
		$.post("<?=base_url()?>ajax/verLocalID", {
			id : id
		}, function(data) {
			if(jQuery.isEmptyObject(data.local)){
				$('#asigClick').show();
				$("#statusLocal").html('<div class="field"><img src="http://www.apeplazas.com/apeConnect/assets/graphics/alert.png" /><i>Local Desocupado</i></div>');
			}else{
				$("#sel1").text(data.local[0].estatusLocal);
				$("#infLocPl").html(" \
				<div class='fieldText'><span>Nombre: </span><em> "+data.cliente[0].Nombre+"</em></div> \
				<div class='fieldText'><span>Plaza: </span><em> "+data.local[0].Plaza+"</em></div> \
				<div class='fieldText'><span>Contrato: </span><em> "+data.local[0].Contrato+"</em></div> \
				<div class='fieldText'><span>Status: </span><em> "+data.local[0].EstatusContrato+"</em></div> \
				<div class='fieldText'><span>Fecha alta: </span><em> "+data.local[0].FechaEmision+"</em></div> \
				<div class='fieldText'><span>Estatus: </span><em> "+data.local[0].EstatusLocal+"</em></div> \
				<div class='fieldText'><span>Importe: </span><em> "+data.cliente[0].Importe+"</em></div> \
				<div class='fieldText'><span>Plaza: </span><em> "+data.cliente[0].Plaza+"</em></div> \
				");
				if (data.local[0].contrato != ''){
					$("#infLocPl").append(" \
					<div class='fieldText'><span>Contrato: </span><em> "+data.cliente[0].Contrato+"</em></div> \
				");
				}
				$("#statusLocal").attr("class","asignado");
				$("#statusLocal").html("<div id='statVer'><img src='http://www.apeplazas.com/apeConnect/assets/graphics/palomita.png' /><i>Local asignado</i></div>");
				$("#statusLocal").attr("class","asignado");
				
			}
			$("#statusVector").attr("title",id);
			$("#statusVector button").attr("id",data.Nvector[0].status);
		},'json');		
	});
*/
	
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
