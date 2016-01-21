<div id="mainTit">
  <h3>Evaluaciones Administración de Plazas Especializadas</h3>
</div>
<div class="wrapList">
  <div id="actions">
    <a href="<?=base_url()?>evaluaciones/formEvaluacion" title="Generar carta intencion" class="addSmall">
			<i class="iconPlus"><img src="http://localhost:8888/apeConnect/assets/graphics/svg/plusCircle.svg" alt="Generar carta intencion"></i>
			<span>Generar Evaluación</span>
		</a>
  </div>
  <div class="wrapListFormThree" id="contentEva">
    <table id="tablaproveedTwo" class="dataEva">
		  <thead>
		    <tr>
		    <th>Nombre & Descripción</th>
		    <th>Inicia</th>
		    <th>Finaliza</th>
				<th>Status</th>
		    </tr>
		  </thead>
		  <tbody>
				<?foreach ($campanias as $var): ?>
		      <tr onclick="window.location.href='<?=base_url()?>evaluaciones/campania/<?=$var->campaniaID;?>'">
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
