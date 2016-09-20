<? $CartaIntencion   = $this->dashboard_model->cargaCartaIntencion($data['fechaDe'], $data['fechaA']);?>
     
	<table id="cartasIntencionDash">
			<caption></caption>
			<thead>
				<tr>
					<th>Gerente De Plza</th>
					<th>Plaza</th>
				    <th class="tcenter">Total</th>
				</tr>
			</thead>
			<tbody>
				<? foreach($CartaIntencion as $row):?>
				<tr>
				<td><?= $row->gerentePlaza;?></td>
				<td><?= $row->plaza;?></td>
				<td class="tcenter"><?= $row->cuentaTotal;?></td>
				<? endforeach; ?>
			</tbody>
		</table>
		<br class="clear">