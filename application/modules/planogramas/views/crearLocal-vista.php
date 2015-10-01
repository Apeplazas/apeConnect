<script src="<?=base_url()?>assets/js/d3.v3.min.js"></script>
<? foreach($infoPlano as $p):?>
<h3 id="mainTit">Creación de locales de Plaza <?= $p->plaza;?> | Nivel <?= $p->piso;?></h3>
<div class="wrapListPlano">
	<div id="actionsPlano">
	
	<? $this->load->view('includes/toolbars/buscaPisos-toolbar');?>

	<? $this->load->view('includes/toolbars/planoGramas');?>
	</div>
<?php $textsContent = '';?>


	<div id="guar">
	<strong>Instruccíones</strong><br>
	<p>1.- Oprime la tecla shift en combinación del botón izquierdo del mouse en la sección deseada y siga dibujando sus intersecciones</p>
	<p>2.- Para borrar un cuadro ya creado antes de presionar el boton guardar de 2 click presionando la tecla shift de su teclado.</p>
	<form action="<?=base_url()?>ajax/agregarPath" method="post" accept-charset="utf-8">
		<input type="hidden" id="text" name="coords" size="100" style="width:100%">
		<input type="hidden" name="planogramaID" value="<?= $this->uri->segment(3);?>" />
		<button class="botRed" id="guardarPath">Guardar</button>
	</form>
	</div>
	
	<div id="planoCreacion">
		<div id="pan-parent">
			<div id="panzoom">
				<svg class="grid" version="1.1" id="Layer1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 800 400" enable-background="new 0 0 800 400" xml:space="preserve">
		 		<g>
				<? foreach($locales as $row): ?>
				<? if($row->tipo == 'polyline'): ?>
				<polyline id="<?= $row->id;?>" class="<?=$row->status;?>" points="<?= $row->points;?>"/>
				<? elseif ($row->tipo == 'path'):?>
				<path  id="<?= $row->id;?>" d="<?= $row->d;?>" class="dragme <?=$row->status;?>" />
				<? elseif ($row->tipo == 'line'):?>
				<line id="<?= $row->id;?>" class="<?=$row->status;?>" x1="<?= $row->x1;?>" y1="<?= $row->y1;?>" x2="<?= $row->x2;?>" y2="<?= $row->y2;?>" />
				<? elseif ($row->tipo == 'polygon'):?>
				<polygon id="<?= $row->id;?>" class="<?=$row->status;?>" points="<?=$row->points;?>"/>
				<? elseif ($row->tipo == 'rect'):?>
				<rect id="<?= $row->id;?>" class="<?=$row->status;?>" x="<?=$row->x;?>" y="<?=$row->y;?>" width="<?=$row->width;?>" height="<?=$row->height;?>"/>
				<? elseif ($row->tipo == 'text'):
				$textsContent .= '<text id="' . $row->id . '" class="texto" transform="' . $row->transform . '" >' . $row->contenido . '</text>';
				endif;?>
				<? endforeach; ?>
				<?=$textsContent;?>
				</g>
				</svg>
			</div>
    	</div>
	</div>
</div>




<script>
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

function zoomed() {
  container.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
}

function dblclick(d) {
	d3.event.stopPropagation();
  	var oldpath = $('#text').val();
  	$('#text').val(oldpath + ' Z');
  	redraw();
}
/*****  Ajax para guardar path
$('#guardarPath').click(function(){

	var coordPath = d3.select('#newPath').attr("d");
	var idPLano = "<?php echo $this->uri->segment(3);?>";

	$.ajax({
		data : {'idPlano':idPLano,"coords":coordPath},
		dataType : 'json',
		url : ajax_url + 'agregarPath',
		type : 'post',
	});

});
******/

</script>

<? endforeach;?>