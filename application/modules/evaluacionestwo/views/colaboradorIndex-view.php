<? $usuarioSesion	= $this->session->userdata('usuario');?>
<div id="mainTit">
  <h3>Evaluaciones Administración de Plazas Especializadas</h3>
</div>
<div class="wrapList">
  <div id="actions">
    <a href="<?=base_url()?>evaluacionesTwo/formEvaluacion" title="Generar carta intencion" class="addSmall">
			<i class="iconPlus"><img src="<?=base_url();?>assets/graphics/svg/plusCircle.svg" alt="Generar carta intencion"></i>
			<span>Generar Evaluación</span>
		</a>
  </div>
  <div class="wrapListFormThree" id="contentEva">
    <p class="subTit">Contestar las siguientes evaluaciones, tus respuestas son muy importantes para nosotros.<p>
    <table id="tablaproveedTwo" class="dataEva">
		  <thead>
		    <tr>
		    <th>Nombre y descripción de la evaluación</th>
		    <th>Fecha de Inicio</th>
		    <th>Fecha de Finalización</th>
				<th>Status</th>
		    </tr>
		  </thead>
		  <tbody>
				<?foreach ($campanias as $var): ?>
        <? $ver = $this->evaluacionesTwo_model->verificaRespuestaIndexColaborador($var->campaniaID,$usuarioSesion['usuarioID']);?>
		      <tr onclick="window.location.href='<?=base_url()?>evaluacionesTwo/usuarioColaborador/<?=$usuarioSesion['usuarioID']?>/1/<?=$var->campaniaID;?>'">
		        <th><p><?=$var->campaniaNombre;?><br><em class="des"><?=$var->campaniaDescripcion;?></em></p></th>
		        <th><?=$var->fechaInicio;?></th>
		        <th><?=$var->fechaFin;?></th>
						<th><?=$var->campaniaStatus;?></th>
		      </tr>
				<?endforeach?>
		  </tbody>
		</table>
		<br class="clear">
	</div>
</div>
