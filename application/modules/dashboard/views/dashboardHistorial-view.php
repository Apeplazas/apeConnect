
<h3 id="mainTit">Historial de acceso a modulos</h3>

	
	
<div class="wrapListLow">
		 <div id="aqui">
         
         <table id="gerentePlazaDash" >
				<thead>
					<tr>
						<th>Fecha de acceso</th>
						<th class="tcenter">Modulo al que accesó </th>
                        
					</tr>
				</thead>
				<tbody>
				 <? foreach($historial as $row):?>	
				<tr>
               		<td><b class="eje"><?= $row->fechaAcceso;?></b></td>
					<td class="tcenter"><?= $row->modulo;?></td>
                </tr>
                <? endforeach; ?>
				</tbody>
			</table>
        </div>
       <br class="clear">
  </div>











