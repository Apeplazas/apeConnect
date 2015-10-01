<script language="javascript" src="http://www.apeplazas.com/obras/assets/js/jquery.autocomplete.pack.js" type="text/javascript"></script>
<ul id="segAjax">
  <li>
    <a id="cerrar" href="#"><img src="<?=base_url()?>assets/graphics/cerrar-dos.png" alt="Cerrar" /></a>
  </li>
  <li>
    <input id="bckBu" name="seccionDesc" type="text" placeholder="Descripcion del Concepto" />
  </li>
  <li>
    <select name="unidad" id="uni">
	 <option value="" selected>Elige una opción</option>
	 <? foreach($unidad as $rowU):?>
	 <option value="<?= $rowU->idUnidad;?>"><?= $rowU->simbolo;?></option>
	 <? endforeach; ?>
	</select>
  </li>
  <li>
    <input class="smallFormAj" name="cantidad" onkeyup="this.value=this.value.replace(/[^\d∂,.]/,'')" type="text" placeholder="Cantidad" />
  </li>
  <li><input class="termi" type="submit" value="Finalizar" onclick="this.disabled=true; this.form.submit(); return true;" /></li>
</ul>
<script>
$("#cerrar").click(function(){
	$(this).closest('tr').remove();
	$("#addSeg").show();
});
</script>

<script>
$(document).ready(function() {
    	var urlPost = (("https:" == document.location.protocol) ? "https://www.apeplazas.com/obras" : "http://www.apeplazas.com/obras/");
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
		$("#bckBuscar").autocomplete(urlPost+"ajax/buscarDescripcion", {
			width: 550,
			selectFirst: false
		});
		$("#bckBuscar").result(function(event, data, formatted) {
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
</script>