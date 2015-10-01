<h3 id="mainTitWhi">Cotización <?= $cotizacion['nombre'];?></h3>
<form method="post" action="<?= base_url() . "prospectos/enviarCotizacion";?>">
	<span><img src="<?=base_url()?>assets/graphics/logoApePdf.png" alt="Administraión de plazas especializadas" /></span>
	<br>
	<fieldset>
	<div id="plazasCot">
		<strong>Ciudades Cotizadas</strong>
		<p>México, Guadalajara</p><br>
		<strong>Valida hasta:</strong>
		<p>15 de Junio del 2005</p><br>
		<strong>Folio:</strong>
		<p>12-24324-COT</p>
	</div>
	<div id="direccion">
		<strong>APE Administración de Plazas Especializadas</strong>
		<p>Bosque de Duraznos No. 61 Desp. 6C Col. Bosques de las Lomas México</p>
		<p>11700 Miguel Hidalgo</p>
		<p>Teléfono 10 55 53 20</p>
	</div>
	</fieldset>
	<br>
	<fieldset>
	<input type="hidden" name="prospectoId" value="<?= $cotizacion['prospectoID'];?>" />
	</fieldset>
	<table id="tableCot">
		<thead>
			<tr>
				<th>Plaza</th>
				<th>Zona</th>
				<th>Local</th>
				<th>Renta</th>
				<th>Depósito</th>
				<th>Seguro</th>
				<th>Gastos</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
	<?php foreach($cotizacion['locales'] as $locales): ?>
		<tr>
			<input type="hidden" name="ids[]" value="<?= $locales->id;?>" />
			<td><p class="tpla">Plaza de la Tecnología</p></td>
			<td>Uruguay 17</td>
			<td>LOCAL 1URU01MEX</td>
			<td>$<?= (($locales->precioLocal * 16)/100) + $locales->precioLocal;?></td>
			<td>$5000</td>
			<td>$2500</td>
			<td>$500</td>
			<td>$25000</td>
		</tr>
		<tr>
			<td colspan="8">Cuenta de Deposito *Rap: 4895 Referencia 000221823072<br>Plaza Lopez Cotilla S.A. de C.V</td>
		</tr>
		</tbody>
	<?php endforeach;?>
	</table>
	<fieldset>
	<div class="infoCotImp">
		<strong>Condiciones Generales</strong>
		<p>a) Días de gracia 15 según Plaza.</p>
		<p>b) Locales sujetos a Disponibilidad.</p>
		<p>c) Usted puede apartar un local con el Deposito en Garantía + Seguro de Responsabilidad Civil, por 7 días.</p>
			
		<p class="descCot">Nota: al termino de la vigencia de 7 dias, el local se pondra Disponible.</p>
		Nota: en caso de no contar con Aval, puede dejar mas 2 Depositos en Garantia sumandolos a la Inversion Inicial. (Consulte a su Ejecutivo de Ventas)</p>
	</div>
	</fieldset>
	<fieldset>
	<div class="infoCotImp">
		<strong>Atentamente</strong>
		<p>Jorge Dávila - Ejecutivo de Ventas</p>
		<p>jdavila@apeplazas.com</p>
		<p>Tel.63528962 • Ofi.10555320</p>
<p></p>
	</div>
	</fieldset>
	<fieldset>	<input class="mainBotton" type="submit" value="Enviar" />
	</fieldset>
</form>