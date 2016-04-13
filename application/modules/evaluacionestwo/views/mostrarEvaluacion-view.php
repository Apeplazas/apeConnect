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

    <? foreach ($categorias as $row): ?>
    <table class="infoEva">
      <thead>
        <tr>
          <th class="bigTb"><em><?=$row->categoriaNombre;?></em></th>
          <th class="smaTb">Autoevaluado</th>
          <th class="smaTb">Jefe Directo</th>
          <th class="medTb">Planes de Acción</th>
        </tr>
      </thead>

      <tbody>
      <? $pregunta = $this->evaluacionestwo_model->preguntasCategorias($row->categoria, $this->uri->segment(4));?>
      <? foreach ($pregunta as $var): ?>
      <tr>
        <td><em><?=$var->pregunta;?></em></td>
        <? $resp = $this->evaluacionestwo_model->respuestasPorPregunta($var->preguntaID,$this->uri->segment(3));?>

		<?foreach ($resp as $var2):?>
        <td><span><?=$var2->respuesta;?></span></td>
        <?endforeach;?>
      </tr>

      <?endforeach; ?>
      </tbody>

    </table>
    <?endforeach; ?>
    <br class="clear">
  </div>

</div>
