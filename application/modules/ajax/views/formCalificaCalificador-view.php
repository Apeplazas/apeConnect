<div class="wrapColabora">
    <div class="span">
    <b>Calificador</b>
        <input id="busColOne" class="kUpOne" type="text" value="">
        <input id="busColOneHide" type="hidden" name="colQCalif[]" value="">
        </div>
        <div class="span">
          <b>Sera calificado</b>
          <input id="busColTwo" disabled="" class="kUpTwo" type="text" value="Benjamin">
          <input type="hidden" disabled="" name="usuarioIDCalificar" value="1">
          <input id="busColTwoHide" type="hidden" name="colACalif[]" value="">
        </div>
        <div class="span">
            <div id="clickAdd" class="addSmallGrayBot">
              <i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Agregar Recibo"></i>
    				  <span>Agregar Grupo</span>
    			  </div>

        </div>
      <br class="clear">

      <div id="ajaxUsu"></div>
      <div id="busFinal">
        <span id="formPre">
        <a href="<?=base_url()?>ajax/agregaPreguntasEvaluacion" id="sCTip" title="1" class="addPreg addSmallGrayBot">
    				<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Agregar Pregunta"></i>
    				<span>Agregar Pregunta</span>
    			</a>
        </span>
      </div>

    </div>
