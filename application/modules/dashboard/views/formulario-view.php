<? $predios = $this->dashboard_model->cargarNumeroDePredios($this->uri->segment(3));?>
    <? foreach($predios as $j):?>
	<? $num= $j->predios?>
    <? $nombre= $j->inmuebleNombre ?>
	<? endforeach; ?>
<? $cuenta = $this->dashboard_model->cuentaprediales($this->uri->segment(3));?>
<? foreach($cuenta as $j):?>
	<? $inicio= $j->inicio?>
	<? endforeach; ?>


<!-- <form action="<?=base_url()?>evaluacionestwo/guardarCampaniaEvaluacion" method="post" id="guardarForm"> -->
<div id="mainTit">
  <h3>Agrega tu evaluación</h3>
</div>
<div class="wrapList">
	<div id="actions">
    <span class="back">
     <a class="addSmall" href="javascript:window.history.go(-1);">
       <i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/back.svg" alt="Regresar"></i>
       <span>Regresar</span>
     </a>
    </span>
  </div>
  <div class="wrapListFormThree" id="contentEva">
    
    <div id="wrapListForm1">
  	<section>
    
    
    <div class="wrapListForm" id="uno">

  <?php for($i=$inicio+1;$i<=$num;$i++): ?>
	<?  $cajas =0; ?>
 
	  
  <table>
	  <tbody>
		  <tr>
			  <td class='grayField'><strong><span class='obli'>*</span>Nombre de la calle</strong></td>
			  <td><input class='bigInp datePick' type='text' id='calle<?=$i?>' value='' ></td>
		  </tr>
		  <tr>
			  <td class='grayField'><strong><span class='obli'>*</span># interior</strong></td>
			  <td><input class='bigInp datePick' type='text' id='interior<?=$i?>' value='' ></td>
			</tr>
			<tr>
				<td class='grayField'><strong><span class='obli'>*</span># exterior</strong></td>
				<td><input class='bigInp datePick' type='text' id='exterior<?=$i?>' value='' ></td>
			</tr>
			<tr>
				<td class='grayField'><strong><span class='obli'>*</span>Superficie</strong></td>
				<td><input class='bigInp datePick' type='text' id='superficie<?=$i?>' value='' ></td>
			</tr>
			<tr>
				<td class='grayField'><strong><span class='obli'>*</span>Código postal</strong></td>
				<td><input class='bigInp datePick' type='text' id='postal<?=$i?>' value='' ></td>
			</tr>
			<tr>
				<td class='grayField'><strong><span class='obli'>*</span>Colonia</strong></td>
				<td>
					<select name="colonia" id="colonia<?=$i?>">
						<option value=""></option>
					</select>
				</td>
			</tr>
			<tr>
				<td class='grayField'><strong><span class='obli'>*</span>Municipio</strong></td>
				<td>
					<input name="municipio" id="municipio<?=$i?>" value=''/>
				</td>
			</tr>
			<tr>
				<td class='grayField'><strong><span class='obli'>*</span>Estado</strong></td>
				<td>
					<input name="estado" id="estado<?=$i?>" value=''/>
				</td>
			</tr>
			<tr>
				<td class='grayField'><strong><span class='obli'>*</span>Ciudad</strong></td>
				<td>
					<input name="ciudad" id="ciudad<?=$i?>" value=''/>
				</td>
			</tr>
			<tr>
				<td class='grayField'><strong><span class='obli'>*</span>Pisos</strong></td>
				<td>
					<select class='selBig' id='selpiso<?=$i?>'  title="No tiene los permisos para modificar este campo">
						<option value=''>Seleccione un piso</option>
						<option value='1'>1</option>
						<option value='2'>2</option>
						<option value='3'>3</option>
						<option value='4'>4</option>
						<option value='5'>5</option>
						<option value='6'>6</option>
						<option value='7'>7</option>
						<option value='8'>8</option>
						<option value='9'>9</option>
						<option value='10'>10</option>
						<option value='11'>11</option>
						<option value='12'>12</option>
					</select>
					</td>
				</tr>
			<tbody>
			</table>
			</br class='clear'>
	  <script>
		  $(document).ready(function(){
		  $('#postal<?=$i?>').blur(function() {
			  
			 var val =  $(this).val();
			 var idVal = <?=$i?>;
			  
			 	$.post(ajax_url+'cargarColoniasObras',{val:val, idVal:idVal},function(data){
				  sucess:
				  	$('#colonia<?=$i?>').empty().append(data);
				  	$("#colonia<?=$i?>").removeAttr("disabled");
				});
				
				$.post(ajax_url+"cargarMunicipioObras",{val:val, idVal:idVal},function(data){
				  sucess:
				  	$("#municipio<?=$i?>").val(data);
				  	$("#municipio<?=$i?>").removeAttr("disabled");
				});
				
				$.post(ajax_url+"cargarEstadoObras",{val:val, idVal:idVal},function(data){
				  sucess:
				  	$("#estado<?=$i?>").val(data);
				  	$("#estado<?=$i?>").removeAttr("disabled");
				});
				
				$.post(ajax_url+"cargarCiudadObras",{val:val, idVal:idVal},function(data){
				  sucess:
				  	$("#ciudad<?=$i?>").val(data);
				  	$("#ciudad<?=$i?>").removeAttr("disabled");
				});
				
											
				});
			});	
  	</script>
  <?php $cajas=$cajas+1;?>
        </div>

  <?php endfor;?>
    <? $datos = $this->dashboard_model->prediales($this->uri->segment(3));?>
      
      
      
      <? $id_predio='';?>
	  <? $calle= '';?>
      <? $interior= '';?>
      <? $exterior= ''; ?>
      <? $superficie= '';?>
      <? $postal= '';?>	
      <? $z=1;?>
	<? foreach($datos as $m):?>
      
	  <? $id_predio= $m->PREDIO_ID;?>
	  <? $calle= $m->CALLE?>
      <? $interior= $m->NUMERO_INTERIOR?>
      <? $exterior= $m->NUMERO_EXTERIOR?>
      <? $superficie= $m->SUPERFICIE_TERRENO?>
      <? $postal= $m->CODIGO_POSTAL?>
	  
      <table>
      <tbody>
      <tr>
      	<td class='grayField'><strong><span class='obli'>*</span>Nombre de la calle</strong></td>
        <td><input class='bigInp datePick' type='text' id='calle<?= $z?>' value='<?= $calle?>' ></td>
        <td><input class='bigInp datePick' type='text' id='id<?= $z?>' value='<?= $id_predio?>' hidden="hidden"></td>
      </tr>
      <tr>
      	<td class='grayField'><strong><span class='obli'>*</span># interior</strong></td>
        <td><input class='bigInp datePick' type='text' id='interior<?= $z?>' value='<?= $interior?>' ></td>
      </tr>
      <tr>
      	<td class='grayField'><strong><span class='obli'>*</span># exterior</strong></td>
        <td><input class='bigInp datePick' type='text' id='exterior<?= $z?>' value='<?= $exterior?>' ></td>
      </tr>
      <tr>
      	<td class='grayField'><strong><span class='obli'>*</span>Superficie</strong></td>
        <td><input class='bigInp datePick' type='text' id='superficie<?= $z?>' value='<?= $superficie?>' ></td>
      </tr>
      <tr>
      	<td class='grayField'><strong><span class='obli'>*</span>Código postal</strong></td>
        <td><input class='bigInp datePick' type='text' id='postal<?= $z?>' value='<?= $postal?>' ></td>
      </tr>
      <tr>
      	<td class='grayField'><strong><span class='obli'>*</span>Piso</strong></td>
        <td>
        <select class='selBig' id='selpiso<?= $z?>'  title="No tiene permisos para editar esta informacion">
            <option value=''>Seleccione un piso</option>
            <option value='1'>1</option>
            <option value='2'>2</option>
            <option value='3'>3</option>
            <option value='4'>4</option>
            <option value='5'>5</option>
            <option value='6'>6</option>
            <option value='7'>7</option>
            <option value='8'>8</option>
            <option value='9'>9</option>
            <option value='10'>10</option>
            <option value='11'>11</option>
            <option value='12'>12</option>
        </select>
        </td>
      </tr>
      </tbody>
      </table>
	  
      

   <script>
$('#selpiso<?= $z?>').on('change',function(){
	$( ".p" ).remove();
var val = $('select#selpiso<?= $z?>').val();
var valor = $(this).val();
var cajas=1;
  for(i=1;i<=valor;i++){
  
  document.getElementById("pis").innerHTML+=" <table class='p'><th colspan='4'></th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2 - Piso "+new Number(i)+" Predio <?= $calle?>)</strong></td><td><input  class='bigInp datePick area<?= $z?>' type='text' name='area[]'  value='' ></td><td><input class='bigInp datePick idpiso<?= $id_predio?>' type='text' name='idpiso[]' value='<?= $id_predio?>' hidden='hidden'></td><td><select class='bigInp piso<?= $z?>' id='selpiso<?= $z?>'><option value='ST2'>ST2</option><option value='ST1'>ST1</option><option value='pb'>PB</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option></select></tr></tbody></table></br class='clear'>"
  cajas=cajas+1	
  }
});
</script>   
      
	  
	<? $z++;?> 
	<? endforeach; ?>
    <div id="pis"> </div>
    </div>

    <input type="button" id="guardar" value="GUARDAR" class="mt10 mainBotton" >
    


<script>
$('#guardar').click(function(){
var INMUEBLE_ID= <?= $this->uri->segment(3); ?>;
var val = <?= $num; ?>;
var NOMBRE_DE_PREDIO = '<?= $nombre; ?>';
var inicio = <?= $inicio; ?>;
for(i=1;i<=val;i++){
							var PREDIO_ID = "";
							var CALLE = "";
							var NUMERO_INTERIOR  = "";
							var NUMERO_EXTERIOR  = "";
							var SUPERFICIE_TERRENO  = "";
							var CODIGO_POSTAL  = "";
							var COLONIA = "";
							var DELEGACION_MUNICIPIO = "";
							var ESTADO = "";
							var CIUDAD = "";
							
							
							var PREDIO_ID  =  $('#id'+new Number(i)).val();
							var CALLE  =  $('#calle'+new Number(i)).val();
							var NUMERO_INTERIOR  =  $('#interior'+new Number(i)).val();
							var NUMERO_EXTERIOR  =  $('#exterior'+new Number(i)).val();
							var SUPERFICIE_TERRENO  =  $('#superficie'+new Number(i)).val();
							var CODIGO_POSTAL  =  $('#postal'+new Number(i)).val();
							var COLONIA = $('#colonia'+new Number(i)).val();
							var DELEGACION_MUNICIPIO = $('#municipio'+new Number(i)).val();
							var ESTADO = $('#estado'+new Number(i)).val();
							var CIUDAD = $('#ciudad'+new Number(i)).val();
							
							var vectoresData = {};
							var m = {};
							var piso = $('.piso'+new Number(i));
							var area = $('.area'+new Number(i));
							$.each(area, function(index,val){
							m[index] = {};
							m[index]['piso'] = $(piso[index]).val();
							m[index]['area'] = $(val).val();
							vectoresData[i] = m;
							
							});
							
							console.log(vectoresData);
							
							$.post('<?=base_url()?>ajax/predio', {
								
											vectoresData : vectoresData,
											PREDIO_ID : PREDIO_ID,
											NOMBRE_DE_PREDIO : NOMBRE_DE_PREDIO,
											INMUEBLE_ID : INMUEBLE_ID,
											CALLE : CALLE,
											NUMERO_INTERIOR : NUMERO_INTERIOR,
											NUMERO_EXTERIOR : NUMERO_EXTERIOR,
											SUPERFICIE_TERRENO : SUPERFICIE_TERRENO,
											CODIGO_POSTAL : CODIGO_POSTAL,
											COLONIA : COLONIA,
											DELEGACION_MUNICIPIO : DELEGACION_MUNICIPIO,
											ESTADO : ESTADO,
											CIUDAD : CIUDAD,
											
											
							},'json');
							alert('Datos actualizados');
							
}
						
});
</script>


    
<!-- </form> -->