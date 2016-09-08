<?php
$today = date('Y-m-d') ;
$firstDateLMonth = date('Y-m-d',strtotime('first day of last month')) ;
$nextMonth= date('Y-m-d',strtotime('first day of next month')) ;
$lastMonth = date('Y-m-d',strtotime('last month')) ;
$thisMonth = date('Y-m-d',strtotime('first day of this month')) ;
?>
<? $proy  = $this->dashboard_model->cuentaProyectosDelMes($thisMonth, $today);?>

<!-- MANDA AL DASHBOARD DE SUPERVISION VENTAS -->
<? $Proyectos = $this->dashboard_model->cargaProyectos($thisMonth, $today);?>
<?$sumaA = 0;?>
<?$sumaB = 0;?>
<?$sumaC = 0;?>
<?$sumaT = 0;?>
<?$sumaD = 0;?>
<?$sumaE = 0;?>
<?$sumaF = 0;?>
<?$sumaTotal = 0;?>
<h3 id="mainTit">Dashboard Proyectos</h3>
 <div id="aqui">
        <? $this->load->view('includes/toolbars/busquedaProyectos')?>
    <? if (empty($totVen)):?>
    <?else:?>
    <ul id="totMet">
      <li class="brightGray">
        <span>META</span>
        <p><?=$totVen * 48?></p>
      </li>
      <li class="brightGray">
        <? foreach($proy as $pro):?>
        <span>Proyectos</span>
        <p><? $totPro = $pro->cuenta;?> <?=$totPro?></p>
        <? endforeach; ?>
      </li>
      <li>
        <span>Restantes</span>
        <? $final = $totVen - $totPro?> 
        <? $check = substr($final, 0, 1)?>
        <p <?if ($check == '-' ):?>class="redVen"<?endif;?> ><?=$final?></p>
      </li>
    </ul>
    <?endif?>
    <div id="canvas-holder" style="width:30%">
      <strong class="titChart">Volumen de proyectos</strong>
      <canvas id="chart-area" width="300" height="300"/>
    </div>

    <br class="clear">
        </div>
<script src="<?=base_url()?>assets/js/Chart.js"></script>

  <script>

    var polarData = [
        {
          value: <?= $sumaA?>,
          color:"#F7464A",
          highlight: "#FF5A5E",
          label: "Cliente Externo"
        },
        {
          value: <?= $sumaB?>,
          color: "#46BFBD",
          highlight: "#5AD3D1",
          label: "Cambaceo"
        },
        {
          value: <?= $sumaC?>,
          color: "#FDB45C",
          highlight: "#FFC870",
          label: "Empleado Interno"
        },
        {
          value: <?= $sumaT?>,
          color: "#949FB1",
          highlight: "#A8B3C5",
          label: "Interno Titular"
        },
        {
          value: <?= $sumaD?>,
          color: "#4D5360",
          highlight: "#616774",
          label: "TeleMarketing"
        },
      ];

      window.onload = function(){
        var ctx = document.getElementById("chart-area").getContext("2d");
        window.myPolarArea = new Chart(ctx).PolarArea(polarData, {
          responsive:true
        });
      };

  </script>