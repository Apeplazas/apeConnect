<?php $textsContent = '';?>
<link rel="stylesheet" href="<?=base_url()?>assets/js/mocha/mocha.css" />
<script src="<?=base_url()?>assets/js/mocha/mocha.js"></script>
<script>mocha.setup("bdd")</script>
<script src="<?=base_url()?>assets/js/chai.js"></script>
<script>expect = chai.expect</script>
<script src="<?=base_url()?>assets/js/jquery.js"></script>
<script src="<?=base_url()?>assets/js/jquery.panzoom.js"></script>

<div id="mocha" style="display:none"></div>
<div id="plano">
	
<form id="asig" method="post">
	<span onclick="$('#asig').toggle(); return false;" class="cerWin"><img src="<?=base_url()?>assets/graphics/cerrar.png" alt="Cerrar" /></span>
	<fieldset>
		<label>*Asigna el numero de local</label>
		<input type="text" name="claveLocal" id="asigInp" />
		<input type="submit" id="enviarAsignar" value="Asignar" />
	</fieldset>
</form>

<div id="forma">
	    <div id="infLocPl"></div>
	    
		<div id="infoCuenta">
			<div id="statusLocal"></div>		
			<span id="statusVector" class="lineAc" title=""><em>Status</em> <button id="habilitado"></button></span>
			<span id="asigClick"><em>Asignar #local</em> <button onclick="$('#asig').toggle(); return false;">Asignar</button></span>
		</div>
	</div>
	
<script>
function clean(){
	$("#infLocPl").empty();
}

$(function() {
	$(".habilitado, .deshabilitado").click(function() {
		clean();
		var id = $(this).attr("id");
		$("#forma").removeAttr("disabled");
		$.post("<?=base_url()?>ajax/verLocal", {
			id : id
		}, function(data) {
			if(jQuery.isEmptyObject(data.local)){
				$('#asigClick').show();
				$("#statusLocal").attr("class","noAsignado");
				$("#statusLocal").html('<em>Segmento no asignado</em>');
			}
			else{
				$("#infLocPl").html(" \
				<div class='field'><span>Local: </span><em> "+data.local[0].clavedeLocal+"</em></div> \
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
	})
	
	
	$('.habilitado, .deshabilitado').click(function() {
		$('#forma').animate({ width: '0px' }, 0);
		$('#forma').animate({ width: '200px' }, 500);
	});
			
			$(".lineAc").click(function() {
				var id = $(this).attr("title");
				$.post("<?=base_url()?>ajax/statusVector", {
					id : id
				}, function(data) {
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
				
				var id = $('#statusVector').attr("title");
				var local = $("#asigInp").val();
				
				$.post("<?=base_url()?>ajax/asignar", {
					id : id,
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


			
	<div id="pan-parent">
		<div id="panzoom">
			<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="800px" height="443px" viewBox="0 0 800 443" enable-background="new 0 0 800 443" xml:space="preserve">
	
			<? foreach($locales as $row): ?>
			<? if($row->tipo == 'polyline'): ?>
			<polyline id="<?= $row->id;?>" class="<?=$row->status;?>" points="<?= $row->points;?>"/>
			<? elseif ($row->tipo == 'path'):?>
			<path  id="<?= $row->id;?>" d="<?= $row->d;?>" />
			<? elseif ($row->tipo == 'line'):?>
			<line id="<?= $row->id;?>" class="<?=$row->status;?>" x1="<?= $row->x1;?>" y1="<?= $row->y1;?>" x2="<?= $row->x2;?>" y2="<?= $row->y2;?>" />
			<? elseif ($row->tipo == 'polygon'):?>
			<polygon id="<?= $row->id;?>" class="<?=$row->status;?>" points="<?=$row->points;?>"/>
			<? elseif ($row->tipo == 'rect'):?>
			<rect id="<?= $row->id;?>" class="<?=$row->status;?>" x="<?=$row->x;?>" y="<?=$row->y;?>" width="<?=$row->width;?>" height="<?=$row->height;?>"/>
			<? elseif ($row->tipo == 'text'):
			$textsContent .= '<text id="' . $row->id . '" class="' . $row->status . '" transform="' . $row->transform . '" >' . $row->contenido . '</text>';
			endif;?>
			<? endforeach; ?>
			<?=$textsContent;?>
			</svg>
		</div>
    </div>
    
    
  
    <div class="buttons">
      <button class="zoom-in">Zoom In</button>
      <button class="zoom-out">Zoom Out</button>
      <input type="range" class="zoom-range">
      <button class="reset">Reset</button>
    </div>
    
    
    
    


    
</div>  
<script src="<?=base_url()?>assets/js/bdd/test.js"></script>
<script>onload = function() { mocha.run(); }</script>
<script>
var urlPost = (("https:" == document.location.protocol) ? "https://www.apeplazas.com/obras/" : "http://www.apeplazas.com/obras/");
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


