<? $usuarioSesion	= $this->session->userdata('usuario');?>
<div id="mainTit">
  <h3>Evaluaciones Administración de Plazas Especializadas</h3>
</div>
<div class="wrapList">
  <div id="actions">
	<? if ($usuarioSesion['usuarioID'] == '403' || $usuarioSesion['usuarioID'] == '2'):?>
    <a href="<?=base_url()?>evaluaciones/formEvaluacion" title="Generar evaluacion" class="addSmall">
			<i class="iconPlus"><img src="<?=base_url();?>assets/graphics/svg/plusCircle.svg" alt="Generar carta intencion"></i>
			<span>Generar Evaluación</span>
		</a>
	<?endif?>
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
        <? $ver = $this->evaluacionestwo_model->verificaRespuestaIndexColaborador($var->campaniaID,$usuarioSesion['usuarioID']);?>
		      <tr onclick="window.location.href='<?=base_url()?>evaluacionestwo/usuarioColaborador/<?=$usuarioSesion['usuarioID']?>/1/<?=$var->campaniaID;?>'">
		        <td><p><?=$var->campaniaNombre;?><br><em class="des"><?=$var->campaniaDescripcion;?></em></p></td>
		        <td><?=$var->fechaInicio;?></td>
		        <td><?=$var->fechaFin;?></td>
						<td><?=$var->campaniaStatus;?></td>
		      </tr>
				<?endforeach?>
		  </tbody>
		</table>
		<br class="clear">
	</div>
</div>
