<? $vendedores   = $this->admin_model->cargaVendedores($data['fechaDe'], $data['fechaA']);?>

	<table id="ventasDash">
			<caption></caption>
			<thead>
				<tr>
					<th>Ejecutivo</th>
					<th class="tcenter">Cliente Externo</th>
					<th class="tcenter">Cambaceo</th>
					<th class="tcenter">Interno Empleado</th>
					<th class="tcenter">Interno Titular</th>
					<th class="tcenter">Telemarketing</th>
					<th class="tcenter">Pagina Web</th>
					<th class="tcenter">Otro</th>
					<th class="tcenter">Total</th>
				</tr>
			</thead>
			<tbody>
				<? foreach($vendedores as $row):?>
				<? $cExt = $this->admin_model->cuentaProspectosTipo($row->usuarioID, 'Cliente Externo', $data['fechaDe'], $data['fechaA']);?>
				<? $cam = $this->admin_model->cuentaProspectosTipo($row->usuarioID, 'Cambaceo', $data['fechaDe'], $data['fechaA']);?>
				<? $int = $this->admin_model->cuentaProspectosTipo($row->usuarioID, 'Interno Empleado', $data['fechaDe'], $data['fechaA']);?>
				<? $intT = $this->admin_model->cuentaProspectosTipo($row->usuarioID, 'Interno Titular', $data['fechaDe'], $data['fechaA']);?>
				<? $tel = $this->admin_model->cuentaProspectosTipo($row->usuarioID, 'Telemarketing', $data['fechaDe'], $data['fechaA']);?>
				<? $pag = $this->admin_model->cuentaProspectosTipo($row->usuarioID, 'Pagina Web', $data['fechaDe'], $data['fechaA']);?>
				<? $otr = $this->admin_model->cuentaProspectosTipo($row->usuarioID, 'Otro', $data['fechaDe'], $data['fechaA']);?>
					<? foreach($cExt as $a):?>
					<? foreach($cam as $b):?>
					<? foreach($int as $c):?>
					<? foreach($intT as $t):?>
					<? foreach($tel as $d):?>
					<? foreach($pag as $e):?>
					<? foreach($otr as $f):?>
						<tr>
							<td><?= $row->nombreCompleto;?></td>
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
			<? endforeach; ?>
			</tbody>
		</table>
		<br class="clear">