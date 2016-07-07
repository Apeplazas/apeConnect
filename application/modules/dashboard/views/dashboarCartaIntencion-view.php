<?php
$today = date('Y-m-d') ;
$firstDateLMonth = date('Y-m-d',strtotime('first day of last month')) ;
$nextMonth= date('Y-m-d',strtotime('first day of next month')) ;
$lastMonth = date('Y-m-d',strtotime('last month')) ;
$thisMonth = date('Y-m-d',strtotime('first day of this month')) ;
?>
<? $car   = $this->dashboard_model->cuentaCartaIntencionDelMes($thisMonth, $today);?>
<!-- MANDA AL DASHBOARD DE SUPERVISION DE CARTAS DE INTENCION-->
<? $CartaIntencion   = $this->dashboard_model->cargaCartaIntencion($thisMonth, $today);?>
<?$sumaTotal = 0;?>
<h3 id="mainTit">Dashboard Carta De Intencion</h3>
<div class="wrapListLow">
  <? $this->load->view('includes/toolbars/buscaCartaDeIntencion')?>
  <div id="aqui">		</div>
	<table id="cartasIntencionDash">
				<?php
				$today = date('Y-m-d') ;
				$firstDateLMonth = date('Y-m-d',strtotime('first day of last month')) ;
				$nextMonth= date('Y-m-d',strtotime('first day of next month')) ;
				$lastMonth = date('Y-m-d',strtotime('last month')) ;
				$thisMonth = date('Y-m-d',strtotime('first day of this month')) ;
				?>
			<? $carEnero =$this->dashboard_model->cuentaCartaIntencionPorMes('2016-01-01', '2016-01-31');?>
			<? $carFebrero =$this->dashboard_model->cuentaCartaIntencionPorMes('2016-02-01', '2016-02-29');?>
			<? $carMarzo =$this->dashboard_model->cuentaCartaIntencionPorMes('2016-03-01', '2016-03-31');?>
			<? $carAbril =$this->dashboard_model->cuentaCartaIntencionPorMes('2016-04-01', '2016-04-30');?>
			<? $carMayo =$this->dashboard_model->cuentaCartaIntencionPorMes('2016-05-01', '2016-05-31');?>
			<? $carJunio =$this->dashboard_model->cuentaCartaIntencionPorMes('2016-06-01','2016-06-30');?>
			<? $carJulio =$this->dashboard_model->cuentaCartaIntencionPorMes($thisMonth, $today);?>
		  
			<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.bundle.js"></script>
			     <div id="canvas-holder" style="width:50%">
			        <canvas id="chart-area"></canvas>
			        <canvas id="myChart"></canvas>
			    </div>
		    <script>

// grafica de linea..
		    var data = {
		        labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio"],
		        datasets: [
		            {
		                label: "Datos Mensuales de Carta de Intencion",
		                backgroundColor: "rgba(220,220,220,0.2)",
		                borderColor: "rgba(220,220,220,1)",
		                pointBackgroundColor: "rgba(220,220,220,1)",
		                pointBorderColor: "#3399ff",
		                pointHoverBackgroundColor: "#3399ff",
		                pointHoverBorderColor: "rgba(220,220,220,1)",
		                data: [<?php echo $carEnero[0]->cuenta; ?>, <?php echo $carFebrero[0]->cuenta; ?>, <?php echo $carMarzo[0]->cuenta;?>,<?php echo $carAbril[0]->cuenta;?>,<?php echo $carMayo[0]->cuenta; ?>,<?php echo $carJunio[0]->cuenta;?>, <?php echo $carJulio[0]->cuenta;?>]
		            },   
		        ]
		    };
 //Grafica de circular ..  
		    var config = {
		        data: {
		            datasets: [{
		                data: [
		                    <?php echo $carAbril[0]->cuenta; ?>,
		                    <?php echo $carMayo[0]->cuenta; ?>,
		                    <?php echo $carJunio[0]->cuenta;?>,
		                    <?php echo $carJulio[0]->cuenta;?>,
		                ],
		                backgroundColor: [
		                    "#F7464A",
		                    "#46BFBD",
		                    "#FDB45C",
		                    
		                ],
		                label: 'My dataset' // for legend
		            }],
		            labels: [
		                "Abril",
		                "Mayo",
		                "Junio",
		                "Julio",
		            
		            ]
		        },
		        options: {
		            responsive: true,
		            legend: {
		                position: 'right',
		            },
		            title: {
		                display: true,
		                text: 'Datos Mensuales'
		            },
		            scale: {
		              ticks: {
		                beginAtZero: true
		              },
		              reverse: false
		            },
		            animation: {
		                animateRotate: false,
		                animateScale: true
		            }
		        }
		    };
		  
		    window.onload = function() {
		        var ctx = document.getElementById("chart-area");
		        window.myPolarArea = Chart.PolarArea(ctx, config);
		         var ctx1 = document.getElementById("myChart").getContext("2d");
		        //myNewChart = new Chart(ctx).Line(data);s
		        myNewChart = new Chart(ctx1, {
		          type: 'line',
		          data: data
		        });
		    };
		    $('#addData').click(function() {
		        if (config.data.datasets.length > 0) {
		            config.data.labels.push('dataset #' + config.data.labels.length);
		            $.each(config.data.datasets, function(i, dataset) {
		                dataset.backgroundColor.push(randomColor());
		                dataset.data.push(randomScalingFactor());
		            });
		            window.myPolarArea.update();
		        }
		    });
		    $('#removeData').click(function() {
		        config.data.labels.pop(); // remove the label first
		        $.each(config.data.datasets, function(i, dataset) {
		            dataset.backgroundColor.pop();
		            dataset.data.pop();
		        });
		        window.myPolarArea.update();
		    });
		    </script>

				    <thead>
						<tr>
							<th>Gerente DE Plaza</th>
							<th>Plaza</th>
							<th class="tcenter">Total</th>
						</tr>
					</thead>
					<tbody>
							<? $i = 0;?>
							<? foreach($CartaIntencion as $row):?>
							<? $sumaTotal += $row->cuentaTotal;?>
							<td><b class="eje"><?= $row->gerentePlaza;?></b></td>
							<td><b class="eje"><?= $row->plaza;?></b></td>
							<td class="tcenter"><?= $row->cuentaTotal;?></td>
						</tr>
						<? $totCart =  $i++;?>
						<? endforeach; ?>
			            <tr id="totcartas">
							<td></td>
							<td><?= $sumaTotal ?></td>
						</tr>
					</tbody>
		</table>
		</div>
		<br class="clear">
	      </div>