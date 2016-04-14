<? $usuarioSesion	= $this->session->userdata('usuario');?>
<? $contestacion = $this->evaluacion_model->validaContestacion($this->uri->segment(3),$usuarioSesion['usuarioID']);?>
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
    <p class="mainSub"><?=$info->campaniaDescripcion;?></p>
    <? if(empty($contestacion)):?>
    <a class="contesta" href="<?=base_url()?>evaluacionestwo/usuario/<?=$usuarioSesion['usuarioID']?>/1/<?=$this->uri->segment(3);?>" title="Contestar evaluación" class="addSmall">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Generar carta intencion"></i>
			<span>Contesta tu evaluación aqui</span>
		</a>
    <br class="clear">
    <?else:?>

		<div id="tabsEva">
		  <ul>
        <?if($evaluaciones):?>
		    <li><a href="#tab2">Evalua a tus colaboradores</a></li>
        <?endif;?>
        <li>
          <a href="#tab1">Tu evaluación</a>
        </li>
		  </ul>
      <?if($evaluaciones):?>
		  <div id="tab2">
				<table id="tablaproveed" class="dataEva">
		      <thead>
		        <tr>
              <th>Status</th>
		          <th>Encuesta enviada por:</th>
              <th>Posición / Puesto</th>
		          <th>Inicio</th>
              <th>Finaliza</th>
              <? if ($usuarioSesion['usuarioID'] == '2' || $usuarioSesion['usuarioID'] == '1'):?>
              <th></th>
              <th></th>
              <?endif?>
		        </tr>
		      </thead>
		      <tbody>
			<?foreach ($evaluaciones as $var): ?>
            <? $verifica = $this->evaluacion_model->checaContestacionesCampaniaUsuario($this->uri->segment(3) ,$var->usuarioID);?>
			<? $consulta = $this->evaluacion_model->verificaProceso($var->usuarioID);?>
            <? $conteo = sizeof($consulta) ?>

		        <tr data="<?=$var->usuarioID;?>">
              <td <? if ($conteo > 1):?>
              onclick="window.location.href='<?=base_url()?>evaluacionestwo/evaluacionJefeDirecto/<?=$var->usuarioID;?>/3/<?=$this->uri->segment(3);?>'"
              <? elseif (isset($consulta[0]->tipo) && $consulta[0]->tipo == 1):?>
              onclick="window.location.href='<?=base_url()?>evaluacionestwo/evaluacionJefeDirecto/<?=$var->usuarioID;?>/2/<?=$this->uri->segment(3);?>'"
              <? else:?>
              class='alertSinAut'
              <? endif?>>
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
              </td>
		          <td class="ingo" <? if ($conteo > 1):?>
              onclick="window.location.href='<?=base_url()?>evaluacionestwo/evaluacionJefeDirecto/<?=$var->usuarioID;?>/3/<?=$this->uri->segment(3);?>'"
              <? elseif (isset($consulta[0]->tipo) && $consulta[0]->tipo == 1):?>
              onclick="window.location.href='<?=base_url()?>evaluacionestwo/evaluacionJefeDirecto/<?=$var->usuarioID;?>/2/<?=$this->uri->segment(3);?>'"
              <? else:?>
              class='alertSinAut'
              <? endif?>>
                <em><?=$var->nombreCompleto;?></em>
                <span ><?=$var->email;?></span>
              </td>
              <td <? if ($conteo > 1):?>
              onclick="window.location.href='<?=base_url()?>evaluacionestwo/evaluacionJefeDirecto/<?=$var->usuarioID;?>/3/<?=$this->uri->segment(3);?>'"
              <? elseif (isset($consulta[0]->tipo) && $consulta[0]->tipo == 1):?>
              onclick="window.location.href='<?=base_url()?>evaluacionestwo/evaluacionJefeDirecto/<?=$var->usuarioID;?>/2/<?=$this->uri->segment(3);?>'"
              <? else:?>
              class='alertSinAut'
            <? endif?>><?=$var->puesto;?></td>
		          <td <? if ($conteo > 1):?>
              onclick="window.location.href='<?=base_url()?>evaluacionestwo/evaluacionJefeDirecto/<?=$var->usuarioID;?>/3/<?=$this->uri->segment(3);?>'"
              <? elseif (isset($consulta[0]->tipo) && $consulta[0]->tipo == 1):?>
              onclick="window.location.href='<?=base_url()?>evaluacionestwo/evaluacionJefeDirecto/<?=$var->usuarioID;?>/2/<?=$this->uri->segment(3);?>'"
              <? else:?>
              class='alertSinAut'
            <? endif?>><?=$var->Inicia;?></td>
              <th <? if ($conteo > 1):?>
              onclick="window.location.href='<?=base_url()?>evaluacionestwo/evaluacionJefeDirecto/<?=$var->usuarioID;?>/3/<?=$this->uri->segment(3);?>'"
              <? elseif (isset($consulta[0]->tipo) && $consulta[0]->tipo == 1):?>
              onclick="window.location.href='<?=base_url()?>evaluacionestwo/evaluacionJefeDirecto/<?=$var->usuarioID;?>/2/<?=$this->uri->segment(3);?>'"
              <? else:?>
              class='alertSinAut'
            <? endif?>><?=$var->Finaliza;?></td>
            
            
            
            
            <? if ($usuarioSesion['usuarioID'] == '2' || $usuarioSesion['usuarioID'] == '1'):?>
            <td>
	              
                <a class="calCol" title="Solicita una evaluacion a un colaborador" href="<?=base_url()?>evaluacionestwo/evaluacionColaborador/<?=$var->usuarioID?>/4/<?=$this->uri->segment(3);?>">Evaluación cruzada</a>
            </td>
              
              
              <td onclick="$('#<?=$var->usuarioID;?>').toggle(); return false;">
                <em class="op">3 ver más cruzadas</em>
              </td>
            <?endif?>
		    </tr>
            <tr id="<?=$var->usuarioID;?>" class="dnone">
              <td colspan="7">
              <table class="colcol">
                <tr>
                  <th colspan="7">
                  <div class="personal">
                  <strong>Carlos Michan</strong>
                  <ul>
                    <li><em>Como calificarias a Juanito al empezar campaña regreso a clases</em><i>3</i></li>
                    <li><em>Termino todos los entregables a tiempo</em> <i>1</i> </li>
                  </ul>
                  </div>
                  
                  <div class="personal">
                  <strong>Juanito Perez</strong>
                  <ul>
                    <li><p>Como calificarias a Juanito al empezar campaña regreso a clases</p><i>3</i></li>
                    <li><p>Termino todos los entregables a tiempo</p> <i>1</i> </li>
                  </ul>
                  </div>
                  </th>
                </tr>
              </table>
              </td>
            </tr>
						<?endforeach?>
		      </tbody>
		    </table>
				<br class="clear">
		  </div>
      <?endif?>

		  <div id="tab1">

        <?
          $sumSizeOf  = 0;
          $sumPromTot = 0;
        ?>
        <? foreach ($categorias as $row): ?>
        <table class="infoEva">
          <thead>
            <tr>
              <th class="bigTb"><em><?=$row->categoriaNombre;?></em></th>
              <th class="smaTb">Autoevaluado</th>
              <th class="smaTb">Jefe Directo</th>
              <th class="smaTb">Promedio</th>
              <? if ($usuarioSesion['idrole'] != 8):?>
              <th class="medTb">Planes de Acción</th>
              <?endif?>
            </tr>
          </thead>

          <tbody>
          <? $respuesta = $this->evaluacion_model->respuestasCategorias($row->categoria,$usuarioSesion['usuarioID'],$this->uri->segment(3));?>
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
            <? if ($usuarioSesion['idrole'] != 8):?>
            <td><p class="evaDes"><?=$data->plandeaccion;?></p></td>
            <?endif?>
          </tr>
          <?endforeach; ?>
          <?$sumSizeOf += (($conteo * 4)*2)?>
          <?$sumPromTot += $promSum?>
          <tr class="bckEva">
            <td class="totEva">SUMA DE CALIFICACIONES</td>
            <td class="tcenter"><?=$autoSum?></td>
            <td class="tcenter"><?=$jefeSum?></td>
            <td class="tcenter"><?=$promSum?></td>
            <? if ($usuarioSesion['idrole'] != 8):?>
            <td></td>
            <?endif?>
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
        </table>

        <br class="clear">
		  </div>




		</div>

    <?endif;?>
	</div>
</div>
<?endforeach; ?>
<script type="text/javascript">
	$(function() {
		$( "#tabsEva" ).tabs();
	});

  $('.alertClick').click(function(){
    alert('Esta evaluacion ya fue contestada');
  });

  $('.alertSinAut').click(function(){
    alert('El usuario aún no contesta su auto evaluación');
  });

</script>
