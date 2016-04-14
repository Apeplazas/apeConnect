<? $usuarioSesion	= $this->session->userdata('usuario');?>
<div id="mainTit">
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
  	<h3><?= $campania[0]->campaniaNombre?></h3>
  	<h3><?= $campania[0]->campaniaDescripcion?></h3>

    <p>Por favor responde según corresponda se acuerdo a la siguiente escala:</p>

    <table id="infoEva">
      <thead>
        <tr>
          <th><em>Escalas</em></th>
          <th><em>Valores</em></th>
          <th><em>Descripciones</em></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Excelente</td>
          <td>4</td>
          <td>Cumple constantemente y siempre excede los resultados esperados.</td>
        </tr>
        <tr>
          <td>Buena</td>
          <td>3</td>
          <td>Cumple siempre y algunas veces excede el resultado esperado.</td>
        </tr>
        <tr>
          <td>Regular</td>
          <td>2</td>
          <td>Casi siempre cumple y algunas veces tiene errores en los resultados esperados.</td>
        </tr>
        <tr>
          <td>Insuficiente</td>
          <td>1</td>
          <td>Pocas veces cumple y tiene errores constantes en los resultados esperados.</td>
        </tr>
        <tr>
          <td>No aplica</td>
          <td>0</td>
          <td>Este criterio no es aplicable al colaborador.</td>
        </tr>
      </tbody>
    </table>

    <form class="" action="<?=base_url()?>evaluacionestwo/guardarEvaluacionColaborador" method="post">

    <? foreach ($categorias as $row): ?>
    <? $valida = $this->evaluacionestwo_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$this->uri->segment(3));?>


    <table class="infoEva">
      <thead>
        <tr>
          <!--- Primer Segmento--->
          <th class="bigTb"><em><?=$row->categoriaNombre;?></em></th>
          <!--- Segundo Segmento--->
          <? if ($usuarioSesion['usuarioID'] == $this->uri->segment(3) ||  $this->uri->segment(4) == 4):?>
          <th class="smaTb">Autoevaluado</th>
          <?endif?>
        </tr>
      </thead>

      <tbody>
      <? $pregunta = $this->evaluacionestwo_model->preguntasCategorias($row->categoria,$this->uri->segment(5));?>
      <? foreach ($pregunta as $var): ?>
      <tr>
        <!--- Primer Segmento--->
        <td><em><?=$var->pregunta;?></em></td>
        <? $resp = $this->evaluacionestwo_model->respuestasPorPregunta($var->preguntaID,$this->uri->segment(3));?>

        <!--  Segundo segmento --->
        <? if ($usuarioSesion['usuarioID'] == $this->uri->segment(3) ||  $this->uri->segment(4) == 4):?>
        <td>
          <?if($this->uri->segment(4) != 4):?>
          <input type="txt" autocomplete="off" maxlength="1" required  onkeypress='validate(event)' name="evaluacion[<?=$var->preguntaID;?>]">
          <?else:?>
          <span>
            <?foreach ($resp as $var2): ?><?=$var2->respuesta;?><?endforeach; ?>
          </span>
          <?endif?>
        </td>
        <?endif?>

      </tr>

      <?endforeach; ?>
      </tbody>

    </table>
    <?endforeach; ?>
    <? if(isset($resp)):?>
    <input type="hidden" name="campania" value="<?=$this->uri->segment(5);?>">
    <input type="hidden" name="usuarioAcalificar" value="<?=$this->uri->segment(3);?>">
    <input type="submit" id="submit" value="Enviar información" class="mt10 mainBotton">
    <?endif?>
    </form>
    <br class="clear">
  </div>

</div>

<script type="text/javascript">

  //// Solo permite numeros en los inputs de telefonos y numericos
  function validate(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    var regex = /[0-4]|\./;
    if( !regex.test(key) ) {
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
      //alert('Solo se aceptan numeros del 0 al 4');
    }
  }
  
  $('input').keydown(function(e) {
		if (e.keyCode==40) {
			if($(this).closest('tr').next('tr').length == 1){
	        	$(this).closest('tr').next('tr').find('input').focus();
	        }else{
	        	$(this).closest('tr').closest('table').next('table').children('tbody').children('tr:first').find('input').focus();
	        } 

	    }
	});
	
	 $('input').keyup(function(e) {
		if (e.keyCode==38) {
			if($(this).closest('tr').prev('tr').length == 1){
	        	$(this).closest('tr').prev('tr').find('input').focus();
	        }else{
	        	$(this).closest('tr').closest('table').prev('table').children('tbody').children('tr:last').find('input').focus();
	        } 

	    }
	});
  
</script>
