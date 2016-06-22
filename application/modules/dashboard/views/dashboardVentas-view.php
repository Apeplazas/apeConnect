<?php
date_default_timezone_set('America/Mexico_City'); 

$today = date('Y-m-d') ;
$firstDateLMonth = date('Y-m-d',strtotime('first day of last month')) ;
$nextMonth= date('Y-m-d',strtotime('first day of next month')) ;
$lastMonth = date('Y-m-d',strtotime('last month')) ;
$thisMonth = date('Y-m-d',strtotime('first day of this month')) ;
// echo $thisMonth;
?>
<? $pros   = $this->dashboard_model->cuentaProspectosDelMes($thisMonth, $today);?>
<!-- MANDA AL DASHBOARD DE SUPERVISION VENTAS -->
<? $vendedores   = $this->dashboard_model->cargaVendedores($thisMonth, $today);?>
<?$sumaA = 0;?>
<?$sumaB = 0;?>
<?$sumaC = 0;?>
<?$sumaT = 0;?>
<?$sumaD = 0;?>
<?$sumaE = 0;?>
<?$sumaF = 0;?>
<?$sumaTotal = 0;?>
<h3 id="mainTit">Dashboard Ventas</h3>
<div class="wrapListLow">
	<? $this->load->view('includes/toolbars/busquedaVendedoresProspectos')?>
		 <div id="aqui">
		<table id="ventasDash">
			<thead>
				<tr>
					<th>Ejecutivo</th>
					<th class="tcenter">Externo</th>
					<th class="tcenter">Cambaceo</th>
					<th class="tcenter">Empleado</th>
					<th class="tcenter">Titular</th>
					<th class="tcenter">Telemarketing</th>
					<th class="tcenter">Web</th>
					<th class="tcenter">Otro</th>
					<th class="tcenter">Total</th>
				</tr>
			</thead>
			<tbody>
				<? $i = 0;?>
				<? foreach($vendedores as $row):?>
				<? $sumaTotal += $row->cuentaTotal;?>
				<? $cExt = $this->dashboard_model->cuentaProspectosTipo($row->usuarioID, 'Cliente Externo', $thisMonth, $today);?>
				<? $cam = $this->dashboard_model->cuentaProspectosTipo($row->usuarioID, 'Cambaceo', $thisMonth, $today);?>
				<? $int = $this->dashboard_model->cuentaProspectosTipo($row->usuarioID, 'Interno Empleado', $thisMonth, $today);?>
				<? $intT = $this->dashboard_model->cuentaProspectosTipo($row->usuarioID, 'Interno Titular', $thisMonth, $today);?>
				<? $tel = $this->dashboard_model->cuentaProspectosTipo($row->usuarioID, 'Telemarketing', $thisMonth, $today);?>
				<? $pag = $this->dashboard_model->cuentaProspectosTipo($row->usuarioID, 'Pagina Web', $thisMonth, $today);?>
				<? $otr = $this->dashboard_model->cuentaProspectosTipo($row->usuarioID, 'Otro', $thisMonth, $today);?>
					<? foreach($cExt as $a):?>
					<? $sumaA += $a->cuenta;?>
					<? foreach($cam as $b):?>
					<? $sumaB += $b->cuenta;?>
					<? foreach($int as $c):?>
					<? $sumaC += $c->cuenta;?>
					<? foreach($intT as $t):?>
					<? $sumaT += $t->cuenta;?>
					<? foreach($tel as $d):?>
					<? $sumaD += $d->cuenta;?>
					<? foreach($pag as $e):?>
					<? $sumaE += $e->cuenta;?>
					<? foreach($otr as $f):?>
					<? $sumaF += $f->cuenta;?>
			<tr>
				<td><b class="eje"><?= $row->nombreCompleto;?></b></td>
				<td class="tcenter"><?= $a->cuenta;?></td>
				<td class="tcenter"><?= $b->cuenta;?></td>
				<td class="tcenter"><?= $c->cuenta;?></td>
				<td class="tcenter"><?= $t->cuenta;?></td>
				<td class="tcenter"><?= $d->cuenta;?></td>
				<td class="tcenter"><?= $e->cuenta;?></td>
				<td class="tcenter"><?= $f->cuenta;?></td>
				<td class="tcenter"><?= $row->cuentaTotal;?></td>
			</tr>
			<? endforeach; ?>
			<? endforeach; ?>
			<? endforeach; ?>
			<? endforeach; ?>
			<? endforeach; ?>
			<? endforeach; ?>
			<? endforeach; ?>
			<? $totVen =  $i++;?>
			<? endforeach; ?>
			<tr id="totVenPros">
				<td></td>
				<td><?= $sumaA?></td>
				<td><?= $sumaB ?></td>
				<td><?= $sumaC ?></td>
				<td><?= $sumaT ?></td>
				<td><?= $sumaD ?></td>
				<td><?= $sumaE ?></td>
				<td><?= $sumaF ?></td>
				<td><?= $sumaTotal ?></td>
			</tr>
			</tbody>
		</table>
		</div>
<<<<<<< HEAD
=======
		<? if (empty($totVen)):?>
		Sin registros
		<?else:?>
>>>>>>> b3621e4447ee238274adb01c42c5b589675da6fa
		<ul id="totMet">
			<li class="brightGray">
				<span>META</span>
				<p><?=$totVen * 48?></p>
			</li>
			<li class="brightGray">
				<? foreach($pros as $pro):?>
				<span>Prospectados</span>
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
			<strong class="titChart">Volumen de ventas por tipo</strong>
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
				{
					value: <?= $sumaE?>,
					color: "#4ct360",
					highlight: "#616774",
					label: "Pagina Web"
				},
				{
					value: <?= $sumaF?>,
					color: "#cct320",
					highlight: "#616774",
					label: "Otro"
				}

			];

			window.onload = function(){
				var ctx = document.getElementById("chart-area").getContext("2d");
				window.myPolarArea = new Chart(ctx).PolarArea(polarData, {
					responsive:true
				});
			};

	</script>