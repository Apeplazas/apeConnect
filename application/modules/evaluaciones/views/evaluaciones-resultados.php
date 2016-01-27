<? $usuarioSesion	= $this->session->userdata('usuario');?>
<div id="mainTit">
  <h3>Resultado de evaluación <?= $usuarioSesion['usuarioID']?></h3>
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
    <form class="" action="<?=base_url()?>evaluaciones/guardarEvaluacion" method="post">

    <? foreach ($categorias as $row): ?>
    <table class="infoEva">
      <thead>
        <tr>
          <th class="bigTb"><em><?=$row->categoriaNombre;?></em></th>
          <th class="smaTb">Autoevaluado</th>
          <? if ($this->uri->segment(4) != '1'):?>
          <th class="smaTb">Jefe Directo</th>
          <?endif?>
          <? if ($this->uri->segment(4) == '4'):?>
          <th class="medTb">Planes de Acción</th>
          <?endif;?>
        </tr>
      </thead>

      <tbody>
      <? $pregunta = $this->evaluaciones_model->preguntasCategorias($row->categoria);?>
      <? foreach ($pregunta as $var): ?>
      <tr>
        <td><em><?=$var->pregunta;?></em></td>
        <? $resp = $this->evaluaciones_model->respuestasPorPregunta($var->preguntaID,$this->uri->segment(3));?>

        <td><span><?foreach ($resp as $var2):?><?=$var2->respuesta;?><?endforeach;?></span></td>
        <td> <span>rar</span></td>

        <!--- Muestra solamente al final de la evaluacion --->
        <? if ($this->uri->segment(4) == '4'):?>
        <td><input type="txt" class="big" name="evaluacion[<?=$var->preguntaID;?>]" ></td>
        <?endif?>
      </tr>

      <?endforeach; ?>
      </tbody>

    </table>
    <?endforeach; ?>
    </form>
    <br class="clear">
  </div>

</div>
