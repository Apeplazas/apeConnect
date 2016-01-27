<? $usuarioSesion	= $this->session->userdata('usuario');?>
<div id="mainTit">
  <h3>Evaluación de desempeño 2015</h3>
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
    <h3>1.- INFORMACION GENERAL.</h3>
    <p><i>a)</i> ¿Qué es La Evaluación del Desempeño? Es una herramienta que permite conocer el resultado que obtiene cada uno de los colaboradores en su puesto de trabajo.</p>

    <p><i>b)</i> ¿Cuál es el objetivo de la Evaluación? Mejorar competencias, determinar promociones y acoplar mejor al colaborador con su puesto de trabajo.</p>

    <p><i>c)</i> El periodo de evaluación es anual, aplica para el personal eventual, solo basta con tener un mes en la empresa para que se revise el desempeño del colaborador.</p>

    <p><i>d)</i> La presente evaluación sustituye a la evaluación que se maneja para saber si se extiende un contrato más de trabajo a los colaboradores de nuevo ingreso.</p>

    <h3>2.-  LAS FORMAS</h3>
    <p><i>a)</i>  Evalúa las características relacionadas con las (Normas, Estándares, Procedimientos, Valores, Políticas, Reglas, etc.)</p>

    <p><i>b)</i>  Evalúa características relacionadas con la conducta como son la (Actitud, Comportamiento, el Actuar y el Decir) y también</p>

    <p><i>c)</i>  Evalúa características relacionadas con los resultados, como la (Productividad, Valor agregado, Contribución a los objetivos de la compañía, etc.)</p>

    <h3>3-  EL MÉTODO</h3>
    <p>Para nuestra evaluación usaremos el método de escalas gráficas discontinuas, donde cada valor tiene una descripción, como se muestra a continuación:</p>

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
          <td>N/A</td>
          <td>Este criterio no es aplicable al colaborador.</td>
        </tr>
      </tbody>
    </table>

    <!--
    <h3>4.-  GUIA PARA EVALUAR EL DESEMPEÑO</h3>
    <p>Los pasos del proceso son los siguientes:</p>
    <p><i>1°</i> El colaborador se Autoevalúa de manera individual, usando este mismo formato y al terminar lo entrega a su jefe inmediato.</p>

    <p><i>2°</i> El Jefe inmediato usa el formato que le entregó su colaborador y califica en el espacio de Jefe Directo.</p>

    <p><i>3°</i> Finalmente se reúnen colaborador y jefe inmediato para revisar resultados, firman evaluación y generan planes de acción para mejorar en su caso.</p>
    -->

    <h3>Contesta el siguiente formulario</h3>
    <form class="" action="<?=base_url()?>evaluaciones/guardarEvaluacion" method="post">

    <? foreach ($categorias as $row): ?>
    <? $valida = $this->evaluaciones_model->validaPermisosEvaluaciones($usuarioSesion['usuarioID'],$this->uri->segment(3));?>


    <table class="infoEva">
      <thead>
        <tr>
          <!--- Primer Segmento--->
          <th class="bigTb"><em><?=$row->categoriaNombre;?></em></th>
          <!--- Segundo Segmento--->
          <? if ($usuarioSesion['usuarioID'] == $this->uri->segment(3) ||  $this->uri->segment(4) == 4):?>
          <th class="smaTb">Autoevaluado</th>
          <?endif?>
          <!--- Tercer Segmento--->
          <? if (($valida && $this->uri->segment(4) == 3) || ($this->uri->segment(4) != 1)):?>
          <th class="smaTb">Respuesta</th>
          <?endif?>
          <!--- Cuarto Segmento--->
          <? if ($valida && $this->uri->segment(4) == 4):?>
          <th class="medTb">Planes de Acción</th>
          <?endif;?>
        </tr>
      </thead>

      <tbody>
      <? $pregunta = $this->evaluaciones_model->preguntasCategorias($row->categoria);?>
      <? foreach ($pregunta as $var): ?>
      <tr>
        <!--- Primer Segmento--->
        <td><em><?=$var->pregunta;?></em></td>
        <? $resp = $this->evaluaciones_model->respuestasPorPregunta($var->preguntaID,$this->uri->segment(3));?>

        <!--  Segundo segmento --->
        <? if ($usuarioSesion['usuarioID'] == $this->uri->segment(3) ||  $this->uri->segment(4) == 4):?>
        <td>
          <?if($this->uri->segment(4) != 4):?>
          <input type="txt" maxlength="1" required  onkeypress='validate(event)' name="evaluacion[<?=$var->preguntaID;?>]">
          <?else:?>
          <span>
            <?foreach ($resp as $var2): ?><?=$var2->respuesta;?><?endforeach; ?>
          </span>
          <?endif?>
        </td>
        <?endif?>

        <!--  Tercer segmento
        Muestra solamente al supervisor que lo calificara y al final de la evaluacion--->
        <? if (($valida && $this->uri->segment(4) == 3) || ($this->uri->segment(4) != 1)):?>
        <td>
          <?if($this->uri->segment(4) != 4):?>
          <input type="txt" maxlength="1" required  onkeypress='validate(event)' name="evaluacion[<?=$var->preguntaID;?>]">
          <?else:?>
          <span>
            <?foreach ($resp as $var2): ?><?=$var2->respuesta;?><?endforeach; ?>
          </span>
          <?endif?>
        </td>
        <?endif?>

        <!--- Cuarto Segmento
        Muestra solamente al final de la evaluacion --->
        <? if ($valida && $this->uri->segment(4) == 4):?>
        <td><input type="txt" maxlength="1" class="big" name="2-evaluacion[<?=$var->preguntaID;?>]" ></td>
        <?endif?>


      </tr>

      <?endforeach; ?>
      </tbody>

    </table>
    <?endforeach; ?>
    <? if(isset($resp)):?>
    <input type="hidden" name="campania" value="<?=$this->uri->segment(5);?>">
    <input type="hidden" name="tipo" value="<?=$this->uri->segment(4);?>">
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
</script>
