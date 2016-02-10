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
    <? $respuesta = $this->evaluaciones_model->respuestasCategorias($row->categoria,$this->uri->segment(3));?>
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
<br class="clear">
