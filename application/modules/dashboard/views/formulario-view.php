

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
    
    <div id="steps">
  	<section>

    <div class="wrapListForm" id="wrapListForm1">
    <table>
		  <thead>
			<tr>
				<th colspan="4">Datos del inmueble</th>
			</tr>
		  </thead>
		  <tbody>
			 <? foreach($inmueble as $l):?>
            <tr>
            <!-- Cargar en el value y no editable -->
           <? $in= $l->Inmueble; ?>
				<td class="grayField"><strong><span class="obli">*</span>Nombre del inmueble</strong></td>
				<td><input type="text" class="bigInp datePick" name="nombreInmueble" id="nombreInmueble" value="<?= $l->Nombre ?>" readonly="readonly"></td>
				<td class="grayField"><strong><span class="obli">*</span>Código IATA de tu estado</strong></td>
				<td><input class="bigInp datePick" type="text" name="codigo" id="codigo" value=""></td>
                
                 
                
                
            
			</tr>
             <tr>
				<td class="grayField"><strong><span class="obli">*</span># de pisos</strong></td>
				<td>
				<select name="plazaPisos" id="plazaPisos" class="selBig" required>
						<option value=""># de pisos</option>
						<option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
				</select>
				</td>
				<td class="grayField"><strong><span class="obli">*</span># de predios</strong></td>
				<td>
					<select  name="prediosnum" id="prediosnum" class="selBig" required>
						<option value=""># de predios</option>
						<option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
				</select>
			</tr>
              <tr> 
                <td class="grayField"><strong><span class="obli">*</span>Area construida (m2)</strong></td>
                <td><input class="bigInp datePick" type="text" name="areaInmueble" id="areaInmueble" value=""></td>
                <td class="grayField"></td>
                <td></td>
			 </tr>
             
             <? endforeach; ?>
      </tbody>
    </table>
    <br class="clear">
    </div>
    
    
    <div class="wrapListForm" id="wrapListForm2">
    	
    </div>
    <input type="button" id="guardar" value="GUARDAR" class="mt10 mainBotton" >

<script>
				$('#guardar').click(function(){
						$option = $('#plazaPisos');
						var nombreInmueble  =  $("#nombreInmueble").val();
						var codigo  =  $("#codigo").val();
						var prediosnum  =  $("#prediosnum").val();
						var areaInmueble  =  $("#areaInmueble").val();
						var plazaPisos	=	($option).val();
						var inmu	=	'<?= $in?>';
						
						var pisouno  =  $("#pisouno").val();
						var p1	=	'1';
						var pisodos  =  $("#pisodos").val();
						var p2	=	'2';
						var pisotres  =  $("#pisotres").val();
						var p3	=	'3';
						var pisocuatro  =  $("#pisocuatro").val();
						var p4	=	'4';
						var pisocinco  =  $("#pisocinco").val();
						var p5	=	'5';
						var pisoseis  =  $("#pisoseis").val();
						var p6	=	'6';
						var pisosiete  =  $("#pisosiete").val();
						var p7	=	'7';
						var pisoocho  =  $("#pisoocho").val();
						var p8	=	'8';
						var pisonueve  =  $("#pisonueve").val();
						var p9	=	'9';
						var pisodiez  =  $("#pisodiez").val();
						var p10	=	'10';
						
	//___________________________________________________________________________
						
						if ((pisouno != '' | pisouno != 'NULL') & plazaPisos==1){
							var sumaPisos = parseInt(pisouno);
						}else 
						if ((pisodos != '' | pisodos != 'NULL') & (plazaPisos==1 | plazaPisos==2)){
							
							var sumaPisos = parseInt(pisouno)+parseInt(pisodos);
						}else
						if ((pisotres != '' | pisotres != 'NULL') & (plazaPisos==1 | plazaPisos==2 | plazaPisos==3)){
							
							var sumaPisos = parseInt(pisouno)+parseInt(pisodos)+parseInt(pisotres);
						}else
						if ((pisocuatro != '' | pisocuatro != 'NULL') & (plazaPisos==1 | plazaPisos==2 | plazaPisos==3 | plazaPisos==4)){
							var sumaPisos = parseInt(pisouno)+parseInt(pisodos)+parseInt(pisotres)+parseInt(pisocuatro);
						}else
						if ((pisocinco != '' | pisocinco != 'NULL') & (plazaPisos==1 | plazaPisos==2 | plazaPisos==3 | plazaPisos==4 | plazaPisos==5)){
							var sumaPisos = parseInt(pisouno)+parseInt(pisodos)+parseInt(pisotres)+parseInt(pisocuatro)+parseInt(pisocinco);
						}else
						if ((pisoseis != '' | pisoseis != 'NULL') & (plazaPisos==1 | plazaPisos==2 | plazaPisos==3 | plazaPisos==4 | plazaPisos==5 | plazaPisos==6)){
							var sumaPisos = parseInt(pisouno)+parseInt(pisodos)+parseInt(pisotres)+parseInt(pisocuatro)+parseInt(pisocinco)+parseInt(pisoseis);
						}else
						if ((pisosiete != '' | pisosiete != 'NULL') & (plazaPisos==1 | plazaPisos==2 | plazaPisos==3 | plazaPisos==4 | plazaPisos==5 | plazaPisos==6 | plazaPisos==7)){
							var sumaPisos = parseInt(pisouno)+parseInt(pisodos)+parseInt(pisotres)+parseInt(pisocuatro)+parseInt(pisocinco)+parseInt(pisoseis)+parseInt(pisosiete);
						}else
						if ((pisoocho != '' | pisoocho != 'NULL') & (plazaPisos==1 | plazaPisos==2 | plazaPisos==3 | plazaPisos==4 | plazaPisos==5 | plazaPisos==6 | plazaPisos==7 | plazaPisos==8)){
							var sumaPisos = parseInt(pisouno)+parseInt(pisodos)+parseInt(pisotres)+parseInt(pisocuatro)+parseInt(pisocinco)+parseInt(pisoseis)+parseInt(pisosiete)+parseInt(pisoocho);
						}else
						if ((pisonueve != '' | pisonueve != 'NULL') & (plazaPisos==1 | plazaPisos==2 | plazaPisos==3 | plazaPisos==4 | plazaPisos==5 | plazaPisos==6 | plazaPisos==7 | plazaPisos==8 | plazaPisos==9)){
							var sumaPisos = parseInt(pisouno)+parseInt(pisodos)+parseInt(pisotres)+parseInt(pisocuatro)+parseInt(pisocinco)+parseInt(pisoseis)+parseInt(pisosiete)+parseInt(pisoocho)+parseInt(pisonueve);
						}else
						if ((pisodiez != '' | pisodiez != 'NULL') & (plazaPisos==1 | plazaPisos==2 | plazaPisos==3 | plazaPisos==4 | plazaPisos==5 | plazaPisos==6 | plazaPisos==7 | plazaPisos==8 | plazaPisos==9 | plazaPisos==10)){
							var sumaPisos = parseInt(pisouno)+parseInt(pisodos)+parseInt(pisotres)+parseInt(pisocuatro)+parseInt(pisocinco)+parseInt(pisoseis)+parseInt(pisosiete)+parseInt(pisoocho)+parseInt(pisonueve)+parseInt(pisodiez);
						}			
						
						
	//_________________________________________________________________________
	if(sumaPisos==areaInmueble){					
							$.post('<?=base_url()?>ajax/inmuebles', {
											inmuebleNombre : nombreInmueble,
											codigoIATA : codigo,
											predios : prediosnum,
											areaConstruida : areaInmueble,
											pisos : plazaPisos,
											inmuebleIntelisis : inmu
											
											
						},'json');
						
						
						
						
						if ((pisouno != '' | pisouno != 'NULL') & plazaPisos==1){
							$.post('<?=base_url()?>ajax/piso1', {
											numeroPiso : p1,
											areaConstruida1 : pisouno,
											inmuebleIntelisis : inmu
											
											
							},'json');
							
						}else 
						if ((pisodos != '' | pisodos != 'NULL') & (plazaPisos==1 | plazaPisos==2)){
							$.post('<?=base_url()?>ajax/piso1', {
											numeroPiso : p1,
											areaConstruida1 : pisouno,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso2', {
											numeroPiso : p2,
											areaConstruida2 : pisodos,
											inmuebleIntelisis : inmu
											
											
							},'json');
							
						}else
						if ((pisotres != '' | pisotres != 'NULL') & (plazaPisos==1 | plazaPisos==2 | plazaPisos==3)){
							$.post('<?=base_url()?>ajax/piso1', {
											numeroPiso : p1,
											areaConstruida1 : pisouno,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso2', {
											numeroPiso : p2,
											areaConstruida2 : pisodos,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso3', {
											numeroPiso : p3,
											areaConstruida3 : pisotres,
											inmuebleIntelisis : inmu
											
											
							},'json');
							
						}else
						if ((pisocuatro != '' | pisocuatro != 'NULL') & (plazaPisos==1 | plazaPisos==2 | plazaPisos==3 | plazaPisos==4)){
							$.post('<?=base_url()?>ajax/piso1', {
											numeroPiso : p1,
											areaConstruida1 : pisouno,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso2', {
											numeroPiso : p2,
											areaConstruida2 : pisodos,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso3', {
											numeroPiso : p3,
											areaConstruida3 : pisotres,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso4', {
											numeroPiso : p4,
											areaConstruida4 : pisocuatro,
											inmuebleIntelisis : inmu
											
											
							},'json');
							
						}else
						if ((pisocinco != '' | pisocinco != 'NULL') & (plazaPisos==1 | plazaPisos==2 | plazaPisos==3 | plazaPisos==4 | plazaPisos==5)){
							$.post('<?=base_url()?>ajax/piso1', {
											numeroPiso : p1,
											areaConstruida1 : pisouno,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso2', {
											numeroPiso : p2,
											areaConstruida2 : pisodos,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso3', {
											numeroPiso : p3,
											areaConstruida3 : pisotres,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso4', {
											numeroPiso : p4,
											areaConstruida4 : pisocuatro,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso5', {
											numeroPiso : p5,
											areaConstruida5 : pisocinco,
											inmuebleIntelisis : inmu
											
											
							},'json');
							
						}else
						if ((pisoseis != '' | pisoseis != 'NULL') & (plazaPisos==1 | plazaPisos==2 | plazaPisos==3 | plazaPisos==4 | plazaPisos==5 | plazaPisos==6)){
							$.post('<?=base_url()?>ajax/piso1', {
											numeroPiso : p1,
											areaConstruida1 : pisouno,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso2', {
											numeroPiso : p2,
											areaConstruida2 : pisodos,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso3', {
											numeroPiso : p3,
											areaConstruida3 : pisotres,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso4', {
											numeroPiso : p4,
											areaConstruida4 : pisocuatro,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso5', {
											numeroPiso : p5,
											areaConstruida5 : pisocinco,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso6', {
											numeroPiso : p6,
											areaConstruida6 : pisoseis,
											inmuebleIntelisis : inmu
											
											
							},'json');
							
						}else
						if ((pisosiete != '' | pisosiete != 'NULL') & (plazaPisos==1 | plazaPisos==2 | plazaPisos==3 | plazaPisos==4 | plazaPisos==5 | plazaPisos==6 | plazaPisos==7)){
							$.post('<?=base_url()?>ajax/piso1', {
											numeroPiso : p1,
											areaConstruida1 : pisouno,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso2', {
											numeroPiso : p2,
											areaConstruida2 : pisodos,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso3', {
											numeroPiso : p3,
											areaConstruida3 : pisotres,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso4', {
											numeroPiso : p4,
											areaConstruida4 : pisocuatro,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso5', {
											numeroPiso : p5,
											areaConstruida5 : pisocinco,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso6', {
											numeroPiso : p6,
											areaConstruida6 : pisoseis,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso7', {
											numeroPiso : p7,
											areaConstruida7 : pisosiete,
											inmuebleIntelisis : inmu
											
											
							},'json');
							
						}else
						if ((pisoocho != '' | pisoocho != 'NULL') & (plazaPisos==1 | plazaPisos==2 | plazaPisos==3 | plazaPisos==4 | plazaPisos==5 | plazaPisos==6 | plazaPisos==7 | plazaPisos==8)){
							$.post('<?=base_url()?>ajax/piso1', {
											numeroPiso : p1,
											areaConstruida1 : pisouno,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso2', {
											numeroPiso : p2,
											areaConstruida2 : pisodos,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso3', {
											numeroPiso : p3,
											areaConstruida3 : pisotres,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso4', {
											numeroPiso : p4,
											areaConstruida4 : pisocuatro,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso5', {
											numeroPiso : p5,
											areaConstruida5 : pisocinco,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso6', {
											numeroPiso : p6,
											areaConstruida6 : pisoseis,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso7', {
											numeroPiso : p7,
											areaConstruida7 : pisosiete,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso8', {
											numeroPiso : p8,
											areaConstruida8 : pisoocho,
											inmuebleIntelisis : inmu
											
											
							},'json');
							
						}else
						if ((pisonueve != '' | pisonueve != 'NULL') & (plazaPisos==1 | plazaPisos==2 | plazaPisos==3 | plazaPisos==4 | plazaPisos==5 | plazaPisos==6 | plazaPisos==7 | plazaPisos==8 | plazaPisos==9)){
							$.post('<?=base_url()?>ajax/piso1', {
											numeroPiso : p1,
											areaConstruida1 : pisouno,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso2', {
											numeroPiso : p2,
											areaConstruida2 : pisodos,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso3', {
											numeroPiso : p3,
											areaConstruida3 : pisotres,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso4', {
											numeroPiso : p4,
											areaConstruida4 : pisocuatro,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso5', {
											numeroPiso : p5,
											areaConstruida5 : pisocinco,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso6', {
											numeroPiso : p6,
											areaConstruida6 : pisoseis,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso7', {
											numeroPiso : p7,
											areaConstruida7 : pisosiete,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso8', {
											numeroPiso : p8,
											areaConstruida8 : pisoocho,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso9', {
											numeroPiso : p9,
											areaConstruida9 : pisonueve,
											inmuebleIntelisis : inmu
											
											
							},'json');
							
						}else
						if ((pisodiez != '' | pisodiez != 'NULL') & (plazaPisos==1 | plazaPisos==2 | plazaPisos==3 | plazaPisos==4 | plazaPisos==5 | plazaPisos==6 | plazaPisos==7 | plazaPisos==8 | plazaPisos==9 | plazaPisos==10)){
							$.post('<?=base_url()?>ajax/piso1', {
											numeroPiso : p1,
											areaConstruida1 : pisouno,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso2', {
											numeroPiso : p2,
											areaConstruida2 : pisodos,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso3', {
											numeroPiso : p3,
											areaConstruida3 : pisotres,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso4', {
											numeroPiso : p4,
											areaConstruida4 : pisocuatro,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso5', {
											numeroPiso : p5,
											areaConstruida5 : pisocinco,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso6', {
											numeroPiso : p6,
											areaConstruida6 : pisoseis,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso7', {
											numeroPiso : p7,
											areaConstruida7 : pisosiete,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso8', {
											numeroPiso : p8,
											areaConstruida8 : pisoocho,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso9', {
											numeroPiso : p9,
											areaConstruida9 : pisonueve,
											inmuebleIntelisis : inmu
											
											
							},'json');
							$.post('<?=base_url()?>ajax/piso10', {
											numeroPiso : p10,
											areaConstruida10 : pisodiez,
											inmuebleIntelisis : inmu
											
											
							},'json');
							
						}
						
						//predios
						for(i=1;i<=prediosnum;i++){
							var calle = "";
							var interior  = "";
							var exterior  = "";
							var superficie  = "";
							var postal  = "";
							$option = "";
							var selpiso	= "";
							var calle  =  $('#calle'+new Number(i)).val();
							var interior  =  $('#interior'+new Number(i)).val();
							var exterior  =  $('#exterior'+new Number(i)).val();
							var superficie  =  $('#superficie'+new Number(i)).val();
							var postal  =  $('#postal'+new Number(i)).val();
							$option = $('#selpiso'+new Number(i));
							var selpiso	=	($option).val();
							
							$.post('<?=base_url()?>ajax/predio', {
											inmuebleIntelisis : inmu,
											predioNombre : nombreInmueble,
											nombreCalle : calle,
											numeroExt : exterior,
											numeroInterior : interior,
											superficieTerreno : superficie,
											codigoPostal : postal,
											numeroPiso : selpiso
							},'json');
							
						}
						$.post('<?=base_url()?>ajax/statusInmueble', {
											inmuebleIntelisis : inmu,
											status : 'Actualizado'
							},'json');
						alert('INFORMACIÓN ACTUALIZADA');
						location.reload();
}else{
alert ('ERROR DE MEDIDAS INMUEBLE / PISO(S)');	
}
									
									
				});
				</script>
    
   
<script>
$('select#plazaPisos').on('change',function(){
	var valor = $(this).val();
	
	if(valor==1){
	document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 1</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisouno' value='' ></td></tr></tbody></table><div id='uno'></div></br class='clear'>"
	}else if (valor==2){
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 1</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisouno' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 2</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisodos' value='' ></td></tr></tbody></table><div id='uno'></div></br class='clear'>"
	}else if (valor==3){
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 1</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisouno' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 2</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisodos' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 3</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisotres' value='' ></td></tr></tbody></table><div id='uno'></div></br class='clear'>"
	}
	else if (valor==4){
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 1</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisouno' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 2</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisodos' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 3</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisotres' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 4</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisocuatro' value='' ></td></tr></tbody></table><div id='uno'></div></br class='clear'>"
	}
	else if (valor==5){
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 1</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisouno' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 2</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisodos' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 3</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisotres' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 4</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisocuatro' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 5</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisocinco' value='' ></td></tr></tbody></table><div id='uno'></div></br class='clear'>"
	}
	else if (valor==6){
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 1</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisouno' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 2</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisodos' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 3</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisotres' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 4</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisocuatro' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 5</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisocinco' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 6</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisoseis' value='' ></td></tr></tbody></table><div id='uno'></div></br class='clear'>"		
	}
	else if (valor==7){
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 1</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisouno' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 2</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisodos' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 3</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisotres' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 4</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisocuatro' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 5</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisocinco' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 6</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisoseis' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 7</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisosiete' value='' ></td></tr></tbody></table><div id='uno'></div></br class='clear'>"
	}
	else if (valor==8){
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 1</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisouno' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 2</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisodos' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 3</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisotres' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 4</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisocuatro' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 5</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisocinco' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 6</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisoseis' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 7</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisosiete' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 8</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisoocho' value='' ></td></tr></tbody></table><div id='uno'></div></br class='clear'>"
	}
	else if (valor==9){
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 1</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisouno' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 2</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisodos' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 3</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisotres' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 4</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisocuatro' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 5</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisocinco' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 6</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisoseis' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 7</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisosiete' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 8</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisoocho' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 9</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisonueve' value='' ></td></tr></tbody></table><div id='uno'></div></br class='clear'>"
	}
	else if (valor==10){
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 1</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisouno' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 2</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisodos' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 3</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisotres' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 4</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisocuatro' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 5</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisocinco' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 6</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisoseis' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 7</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisosiete' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 8</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisoocho' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 9</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisonueve' value='' ></td></tr></tbody></table>"
		document.getElementById("wrapListForm2").innerHTML+="<table><th colspan='4'>Piso 10</th><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Area construida (m2)</strong></td><td><input class='bigInp datePick' type='text' id='pisodiez' value='' ></td></tr></tbody></table><div id='uno'></div></br class='clear'>"
	}
	
	
});
</script>

	
<script>
$('#prediosnum').on('change',function(){
var val = $('select#plazaPisos').val();
var valor = $(this).val();
if(val==1){

  for(i=1;i<=valor;i++){
  var cajas=0;
  document.getElementById("uno").innerHTML+="  <table><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Nombre de la calle</strong></td><td><input class='bigInp datePick' type='text' id='calle"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># interior</strong></td><td><input class='bigInp datePick' type='text' id='interior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># exterior</strong></td><td><input class='bigInp datePick' type='text' id='exterior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Superficie</strong></td><td><input class='bigInp datePick' type='text' id='superficie"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Código postal</strong></td><td><input class='bigInp datePick' type='text' id='postal"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Piso</strong></td><td><select class='selBig' id='selpiso"+new Number(i) +"' required><option value=''>Seleccione un piso</option><option value='1'>1</option></select></td></tr><tbody> </table></br class='clear'>"
  cajas=cajas+1	
  }
}else if(val==2){
  for(i=1;i<=valor;i++){
  var cajas=0;
  document.getElementById("uno").innerHTML+="  <table><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Nombre de la calle</strong></td><td><input class='bigInp datePick' type='text' id='calle"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># interior</strong></td><td><input class='bigInp datePick' type='text' id='interior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># exterior</strong></td><td><input class='bigInp datePick' type='text' id='exterior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Superficie</strong></td><td><input class='bigInp datePick' type='text' id='superficie"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Código postal</strong></td><td><input class='bigInp datePick' type='text' id='postal"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Piso</strong></td><td><select class='selBig' id='selpiso"+new Number(i) +"' required><option value=''>Seleccione un piso</option><option value='1'>1</option><option value='2'>2</option></select></td></tr><tbody> </table></br class='clear'>"
  cajas=cajas+1	
  }

}else if (val==3){
  for(i=1;i<=valor;i++){
  var cajas=0;
  document.getElementById("uno").innerHTML+="  <table><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Nombre de la calle</strong></td><td><input class='bigInp datePick' type='text' id='calle"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># interior</strong></td><td><input class='bigInp datePick' type='text' id='interior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># exterior</strong></td><td><input class='bigInp datePick' type='text' id='exterior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Superficie</strong></td><td><input class='bigInp datePick' type='text' id='superficie"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Código postal</strong></td><td><input class='bigInp datePick' type='text' id='postal "+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Piso</strong></td><td><select class='selBig' id='selpiso"+new Number(i) +"' required><option value=''>Seleccione un piso</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select></td></tr><tbody> </table></br class='clear'>"
  cajas=cajas+1	
  }
	
}else if (val==4){
  for(i=1;i<=valor;i++){
  var cajas=0;
  document.getElementById("uno").innerHTML+="  <table><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Nombre de la calle</strong></td><td><input class='bigInp datePick' type='text' id='calle"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># interior</strong></td><td><input class='bigInp datePick' type='text' id='interior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># exterior</strong></td><td><input class='bigInp datePick' type='text' id='exterior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Superficie</strong></td><td><input class='bigInp datePick' type='text' id='superficie"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Código postal</strong></td><td><input class='bigInp datePick' type='text' id='postal"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Piso</strong></td><td><select class='selBig' id='selpiso"+new Number(i) +"' required><option value=''>Seleccione un piso</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option></select></td></tr><tbody> </table></br class='clear'>"
  cajas=cajas+1	
  }
	
}else if (val==5){
  for(i=1;i<=valor;i++){
  var cajas=0;
  document.getElementById("uno").innerHTML+="  <table><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Nombre de la calle</strong></td><td><input class='bigInp datePick' type='text' id='calle"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># interior</strong></td><td><input class='bigInp datePick' type='text' id='interior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># exterior</strong></td><td><input class='bigInp datePick' type='text' id='exterior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Superficie</strong></td><td><input class='bigInp datePick' type='text' id='superficie"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Código postal</strong></td><td><input class='bigInp datePick' type='text' id='postal"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Piso</strong></td><td><select class='selBig' id='selpiso"+new Number(i) +"' required><option value=''>Seleccione un piso</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option></select></td></tr><tbody> </table></br class='clear'>"
  cajas=cajas+1	
  }
	
}else if (val==6){
  for(i=1;i<=valor;i++){
  var cajas=0;
  document.getElementById("uno").innerHTML+="  <table><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Nombre de la calle</strong></td><td><input class='bigInp datePick' type='text' id='calle"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># interior</strong></td><td><input class='bigInp datePick' type='text' id='interior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># exterior</strong></td><td><input class='bigInp datePick' type='text' id='exterior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Superficie</strong></td><td><input class='bigInp datePick' type='text' id='superficie"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Código postal</strong></td><td><input class='bigInp datePick' type='text' id='postal"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Piso</strong></td><td><select class='selBig' id='selpiso"+new Number(i) +"' required><option value=''>Seleccione un piso</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option></select></td></tr><tbody> </table></br class='clear'>"
  cajas=cajas+1	
  }
	
}else if (val==7){
  for(i=1;i<=valor;i++){
  var cajas=0;
  document.getElementById("uno").innerHTML+="  <table><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Nombre de la calle</strong></td><td><input class='bigInp datePick' type='text' id='calle"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># interior</strong></td><td><input class='bigInp datePick' type='text' id='interior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># exterior</strong></td><td><input class='bigInp datePick' type='text' id='exterior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Superficie</strong></td><td><input class='bigInp datePick' type='text' id='superficie"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Código postal</strong></td><td><input class='bigInp datePick' type='text' id='postal"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Piso</strong></td><td><select class='selBig' id='selpiso"+new Number(i) +"' required><option value=''>Seleccione un piso</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option></select></td></tr><tbody> </table></br class='clear'>"
  cajas=cajas+1	
  }

}else if (val==8){
  for(i=1;i<=valor;i++){
  var cajas=0;
  document.getElementById("uno").innerHTML+="  <table><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Nombre de la calle</strong></td><td><input class='bigInp datePick' type='text' id='calle"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># interior</strong></td><td><input class='bigInp datePick' type='text' id='interior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># exterior</strong></td><td><input class='bigInp datePick' type='text' id='exterior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Superficie</strong></td><td><input class='bigInp datePick' type='text' id='superficie"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Código postal</strong></td><td><input class='bigInp datePick' type='text' id='postal"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Piso</strong></td><td><select class='selBig' id='selpiso"+new Number(i) +"' required><option value=''>Seleccione un piso</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option></select></td></tr><tbody> </table></br class='clear'>"
  cajas=cajas+1	
  }
	
}else if (val==9){
  for(i=1;i<=valor;i++){
  var cajas=0;
  document.getElementById("uno").innerHTML+="  <table><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Nombre de la calle</strong></td><td><input class='bigInp datePick' type='text' id='calle"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># interior</strong></td><td><input class='bigInp datePick' type='text' id='interior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># exterior</strong></td><td><input class='bigInp datePick' type='text' id='exterior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Superficie</strong></td><td><input class='bigInp datePick' type='text' id='superficie"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Código postal</strong></td><td><input class='bigInp datePick' type='text' id='postal"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Piso</strong></td><td><select class='selBig' id='selpiso"+new Number(i) +"' required><option value=''>Seleccione un piso</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option></select></td></tr><tbody> </table></br class='clear'>"
  cajas=cajas+1	
  }
	
}else if (val==10){
  for(i=1;i<=valor;i++){
  var cajas=0;
  document.getElementById("uno").innerHTML+="  <table><tbody><tr><td class='grayField'><strong><span class='obli'>*</span>Nombre de la calle</strong></td><td><input class='bigInp datePick' type='text' id='calle"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># interior</strong></td><td><input class='bigInp datePick' type='text' id='interior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span># exterior</strong></td><td><input class='bigInp datePick' type='text' id='exterior"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Superficie</strong></td><td><input class='bigInp datePick' type='text' id='superficie"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Código postal</strong></td><td><input class='bigInp datePick' type='text' id='postal"+new Number(i) +"' value='' ></td></tr><tr><td class='grayField'><strong><span class='obli'>*</span>Piso</strong></td><td><select class='selBig' id='selpiso"+new Number(i) +"' required><option value=''>Seleccione un piso</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option></select></td></tr><tbody> </table></br class='clear'>"
  cajas=cajas+1	
  }
	
}

});
</script>




    
<!-- </form> -->