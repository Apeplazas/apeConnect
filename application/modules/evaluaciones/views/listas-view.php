<? $usuarioSesion	= $this->session->userdata('usuario');?>
<? $contestacion = $this->evaluaciones_model->validaContestacion($this->uri->segment(3),$usuarioSesion['usuarioID']);?>
<?foreach ($campania as $info): ?>
<div id="mainTit">
  <h3>Evaluaciones y Encuestas APE Plazas </h3>
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
  <div class="wrapListFormThree" >
    <h3><?=$info->campaniaNombre;?></h3>
		<div id="tabsE<? if($contestacion):?>va<?endif?>">
		  <ul>
        <?if($evaluaciones):?>
		    <li><a href="#tab2">Lista de usuarios por evaluar</a></li>
        <?endif;?>
		    <li>
          <a <? if($contestacion):?>href="#tab1"
            <?else:?>class='acti' href="<?=base_url()?>evaluaciones/usuario/<?=$usuarioSesion['usuarioID']?>/1/<?=$this->uri->segment(3);?>"<?endif?>>Tu evaluación</a>
        </li>
		  </ul>
      <?if($evaluaciones):?>
		  <div id="tab2">

				<table id="tablaproveed" class="dataEva">
		      <thead>
		        <tr>
              <th>Status</th>
		          <th>Nombre Completo</th>
		          <th>Correo Electronico</th>
		          <th>Posición / Puesto</th>
		        </tr>
		      </thead>
		      <tbody>
						<?foreach ($evaluaciones as $var): ?>
		        <tr onclick="window.location.href='<?=base_url()?>evaluaciones/usuario/<?=$var->usuarioID;?>/2/<?=$this->uri->segment(3);?>'">

              <? $consulta = $this->evaluaciones_model->verificaProceso($var->usuarioID);?>
              <? $conteo = sizeof($consulta) ?>

              <th>
                <? if ($conteo > 2):?>
                <img src="<?=base_url()?>assets/graphics/4evaluacion.png" alt="Proceso" />
                <? elseif ($conteo > 1):?>
                <img src="<?=base_url()?>assets/graphics/3evaluacion.png" alt="Proceso" />
              <? elseif (isset($consulta[0]->tipo) && $consulta[0]->tipo == 2):?>
                <img src="<?=base_url()?>assets/graphics/2evaluacion.png" alt="Proceso" />
              <? elseif (isset($consulta[0]->tipo) && $consulta[0]->tipo == 1):?>
                <img src="<?=base_url()?>assets/graphics/1evaluacion.png" alt="Proceso" />
                <? else:?>
                <img src="<?=base_url()?>assets/graphics/0evaluacion.png" alt="Proceso" />
                <? endif?>
              </th>

		          <th><?=$var->nombreCompleto;?></th>
		          <th><?=$var->email;?></th>
		          <th><?=$var->puesto;?></th>
		        </tr>
						<?endforeach?>
		      </tbody>
		    </table>
				<br class="clear">
		  </div>
      <?endif?>


<?if($contestacion):?>
		  <div id="tab1">

        <?
          $sumSizeOf  = 0;
          $sumPromTot = 0;
        ?>
        <? foreach ($categorias as $row): ?>
        <table class="infoEva">
          <thead>
            <tr>
              <th class="bigTb"><em><?=$row->categoria;?></em></th>
              <th class="smaTb">Autoevaluado</th>
              <th class="smaTb">Jefe Directo</th>
              <th class="smaTb">Promedio</th>
              <th class="medTb">Planes de Acción</th>
            </tr>
          </thead>

          <tbody>
          <? $respuesta = $this->evaluaciones_model->respuestasCategorias($row->categoria,$usuarioSesion['usuarioID']);?>
          <? $conteo = sizeof($respuesta);?>
          <?
          $autoSum = 0;
          $jefeSum = 0;
          $promSum = 0;
          ?>
          <?foreach ($respuesta as $data): ?>
          <?
          $autoSum += $data->autoevaluacion;
          $jefeSum += $data->jefeDirecto;
          $promSum += $data->promedio;
          ;?>
          <tr class="desCen">
            <td><em><?=$data->preguntas;?></em></td>
            <td class="tcenter"><?=$data->autoevaluacion;?></td>
            <td class="tcenter"><?=$data->jefeDirecto;?></td>
            <td class="tcenter"><?=$data->promedio;?></td>
            <td><p class="evaDes"><?=$data->plandeaccion;?></p></td>
          </tr>
          <?endforeach; ?>
          <?$sumSizeOf += (($conteo * 4)*2)?>
          <?$sumPromTot += $promSum?>
          <tr class="bckEva">
            <td class="totEva">SUMA DE CALIFICACIONES</td>
            <td class="tcenter"><?=$autoSum?></td>
            <td class="tcenter"><?=$jefeSum?></td>
            <td class="tcenter"><?=$promSum?></td>
            <td></td>
          </tr>
          </tbody>
        </table>
        <?endforeach; ?>
        <table>
          <tr class="bckEva">
            <td class="totEva">SUELDO RECOMENDADO</td>
            <td class="tcenter"><?= ($sumPromTot * 100) / $sumSizeOf ?></td>
            <td class="tcenter">Rango Minimo <?=$info->rangoSueldoMinimo;?> | Maximo <?=$info->rangoSueldoMaximo;?> </td>
            <td class="tcenter">
              <?if($info->rangoSueldoMaximo < 10):?>
              <? $puntos = ($info->rangoSueldoMaximo - $info->rangoSueldoMinimo)+1;?>
              <?else:?>
              <? $puntos = $info->rangoSueldoMaximo - $info->rangoSueldoMinimo ?>
              <?endif?>
              <?=$puntos?>
            </td>
            <td></td>
          </tr>
        </table>

        <br class="clear">
		  </div>
      <?endif?>
		</div>
	</div>
</div>
<?endforeach; ?>
<script type="text/javascript">
	$(function() {
		$( "#tabsEva" ).tabs();
	});
</script>
