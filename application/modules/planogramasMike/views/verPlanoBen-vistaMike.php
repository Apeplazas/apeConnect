<?php $textsContent = '';?>

<script src="<?=base_url()?>assets/js/d3.v3.min.js"></script>

<input type="hidden" id=text size=100 style="width:100%">
<button id="guardarPath">Guardar</button>

	<div id="pan-parent">
		<div id="panzoom">
			<svg version="1.1" id="Layer1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	   xml:space="preserve">
	 		<g>
			<? foreach($locales as $row): ?>
			<? if($row->tipo == 'polyline'): ?>
			<polyline id="<?= $row->id;?>" class="<?=$row->status;?>" points="<?= $row->points;?>"/>
			<? elseif ($row->tipo == 'path'):?>
			<path  id="<?= $row->id;?>" d="<?= $row->d;?>" class="dragme" />
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

<!--script>

// Set up some objects on a Raphael drawing surface
var draw = Raphael(0, 0, $(window).width(), $(window).height());
var path = draw.path();
path.attr({stroke: 'black', 'stroke-width': 3, fill: '#147EDB'});

// This function sets the path from the input text
function redraw() {
  path.attr({path: $('#text').val()});
}

$('body').click(function(event) {
  var x = event.pageX;
  var y = event.pageY;
  var oldpath = $('#text').val();
  if (!oldpath.match(/M/) || oldpath.match(/Z/)) {
    $('#text').val('M ' + x + ' ' + y);
  } else {
    $('#text').val(oldpath + ' ' + x + ' ' + y);
  }
  redraw();
});

$('body').dblclick(function(event) {
  var oldpath = $('#text').val();
  $('#text').val(oldpath + ' Z');
  redraw();
});

// stopPropagation keeps clicks on text from propagating up to <body>
$('#text').click(function(event) { event.stopPropagation(); });
$('#text').dblclick(function(event) { event.stopPropagation(); });

</script-->

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

console.log(d3.select('text[id="611"]'));
$('#guardarPath').click(function(){

/*
	var coordPath = d3.select('#newPath').attr("d");
	var idPLano = "<?php echo $this->uri->segment(3);?>";

	$.ajax({
		data : {'idPlano':idPLano,"coords":coordPath},
		dataType : 'json',
		url : ajax_url + 'agregarPath',
		type : 'post',
	});
	*/

});

</script>