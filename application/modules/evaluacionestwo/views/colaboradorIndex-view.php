<? $usuarioSesion	= $this->session->userdata('usuario');?>
<div id="mainTit">
  <h3>Evaluaciones Administración de Plazas Especializadas</h3>
</div>
<div class="wrapList">
  <div id="actions">
	<? if ($usuarioSesion['usuarioID'] == '403' || $usuarioSesion['usuarioID'] == '2' || $usuarioSesion['usuarioID'] == '1'):?>
    <a href="<?=base_url()?>evaluacionestwo/formEvaluacion" title="Generar evaluacion" class="addSmall">
			<i class="iconPlus"><img src="<?=base_url();?>assets/graphics/svg/plusCircle.svg" alt="Generar carta intencion"></i>
			<span>Generar Evaluación</span>
		</a>
	<?endif?>
  </div>
  <div class="wrapListFormThree" id="contentEva">
    <p class="subTit">Contestar la siguiente evaluación.<p>
    <table id="tablaproveedTwo" class="dataEva">
		  <thead>
		    <tr>
		    <th>Nombre y descripción de la evaluación</th>
		    <th>Fecha de Inicio</th>
		    <th>Fecha de Finalización</th>
		    </tr>
		  </thead>
		  <tbody>
				<?foreach ($campanias as $var): ?>
		      <tr onclick="window.location.href='<?=base_url()?>evaluacionestwo/usuarioColaborador/<?=$usuarioSesion['usuarioID']?>/1/<?=$var->campaniaID;?>'">
		        <td><p><?=$var->campaniaNombre;?><br><em class="des"><?=$var->campaniaDescripcion;?></em></p></td>
		        <td><?=$var->fechaInicio;?></td>
		        <td><?=$var->fechaFin;?></td>
		      </tr>
				<?endforeach?>
		  </tbody>
		</table>
		<br class="clear">
	</div>
</div>
