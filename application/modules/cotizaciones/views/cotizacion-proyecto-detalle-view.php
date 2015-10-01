<?php

	$i = -1;
	$tempid = 0;
	$cols = array();	
	$proyect_title = '';
	
	$data = array();
	foreach($cotizacion as $cot){
		$proyect_title = $cot->tituloProyecto;
		if($tempid == $cot->idproveedor){
			$data[$i][] = array('v'=>(float)$cot->totalseg,'f'=>"$".number_format($cot->totalseg,2));
		}else{
			$tempid = $cot->idproveedor;
			++$i;
			$data[$i][] = $cot->razonSocial;
			$data[$i][] = array('v'=>(float)$cot->totalseg,'f'=>"$".number_format($cot->totalseg,2));
		}
		if($i == 0){
			$cols[] = $cot->seccionDesc;	
		}
	}
		
?>


    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        
        var cols = <?php echo json_encode($cols);?>;
        
        data.addColumn('string', 'Proveedor'); // Implicit domain column.
        
        $.each(cols,function(key,val){
        	data.addColumn('number', val); // Implicit data column.
        });
        
       	data.addRows(<?php echo json_encode($data);?>);
		
        // Set chart options
        var options = {'title':'<?=$proyect_title;?>',
                       'width':"95%",
                       'height':700};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        
        google.visualization.events.addListener(chart, 'select', selectHandler);
        
      }
      
		function selectHandler(e){   
      		alert("test");
    	}
    </script>
<div id="chart_div"></div>
