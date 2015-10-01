<div class="pdf-container">
	<h4 class="text-center" style="color:#000;">_____________________</h4>
	<br/>
	<div class="row">
		<div class="col-md-4"><p class="text-left"><strong>www.apeplazas.com</strong></p></div>
	  	<div class="col-md-4">
	  		<p class="text-center">RECIBO INTERNO</p>
	  		<p class="text-center">No. 8787</p>
	  	</div>
	  	<div class="col-md-4">
	  		<p class="text-right">Fecha: <?= $fecha;?></p>
	  		<p class="text-right">Bueno por:</p>
		</div>
	</div>
	<p>Recibimos del (a) <span class="underline-text"><?= $clienteDatos[0]->pnombre . " " . $clienteDatos[0]->snombre . " " . $clienteDatos[0]->apellidop . " " . $clienteDatos[0]->apellidom; ?></span></p>
	<p>La cantidad de $<span class="underline-text"><?= $cantidadPagada; ?></span></p>
	<p>Por concepto de depósito del local: <span class="underline-text">_____</span> del área de: <span class="underline-text">_____</span></p>
	<br/>
	<p>Dentro del conjunto comercial demoninado ______, conforme a las siguientes especificaciones:</p>
	<p>1.- Del presente recibo no se deriva obligación para esta entidad comercial, o derecho alguno para el cliente.</p>
	<p>2.- El presente recibo ampara la cantidad expresamente señalada en el mismo, no genera ninguna clase de interés y se expide exclusivamente por el local indicado.</p>
	<p>3.- El pago total por la operación y la documentación requerida al cliente por la entidad comercial, deberán ser cubiertos en un plazo máximo de 7 días naturales contados a partir de la fecha señalada en el recibo.</p>
	<p>4.- La entidad comercial no se encuentra obligada a respetar el pago total o parcial "Apartado", después de haber transcurrido un máximo de 7 días naturales a partir de la fecha de expedición del mismo, en dicho caso el cliente podrá solicitar la devolución del importe que ampara este recibo, canjeándolo por este recibo provisional.</p>
	<p>5.- El presente recibo no da derechos al liente de celebrar Contrato de Cesión de Derechos con un tercero con respecto a este recibo, ni de celebrar contrato de subarrendamiento con esta entidad comercial, ni de tomar posesión de local alguno.</p>
	<p><strong>6.- Este recibo no es oficial ni valido para efectos fiscales, una vez que el cliente haya entregado la documentación que se le requiera, celebre el contrato de subarrendamiento respectivo y haya liquidado el importe total de la operación (pago de renta, depósito en garantía, y/o por el concepto que se expida) el presente recibo provisional será canjeado por el (los) correspondiente (s) recibo (s) oficial (es)</strong></p>
	<hr />
	<p><strong>Condiciones Generales:</strong></p>
	<p>Contrato a partir del mes <span class="underline-text">_________</span> con una duración de <span class="underline-text">_________</span> con <span class="underline-text">_________</span> días de gracia con una renta mensual de $<span class="underline-text">_________</span> + I.V.A. cantidad con letra (<span class="underline-text">_________</span>) y una renta de depósito de $<span class="underline-text">_________</span> cantidad con letra (<span class="underline-text">_________</span>)</p>
	<div class="row">
		<div class="col-md-6"><p>Mes pagado <span class="underline-text">_________</span></p></div>
	  	<div class="col-md-6"><p> Próximo pago de renta <span class="underline-text">_________</span></p></div>
	</div>
	<div class="row">
		<div class="col-md-6"><p>Días pagados <span class="underline-text">_________</span></p></div>
	  	<div class="col-md-6"><p> Próximo pago de documento <span class="underline-text">_________</span></p></div>
	</div>
	
	<br/>
	<br/>
	<br/>
	<div class="row">
		<div class="col-md-6" style="width: 45%; display:inline-block;">
	  		<hr class="signing">
	  		<p class="text-center small-text">_______________</p>
	 	</div>
	  	<div class="col-md-6" style="width: 45%; display:inline-block;">
	  		<hr class="signing">
	  		<p class="text-center small-text">El Cliente</p>
	  	</div>
	</div>
	<p>NOMBRE DE LA PERSONA QUE REALIZÓ LA VENTA <span class="underline-text">_____</span> TELEFONO DEL CLIENTE: <span class="underline-text">_____</span></p>
	<hr style="border-top: 2px dotted #000;">
	<div class="row">
		<div class="col-md-4"></div>
	  	<div class="col-md-4"><h6 class="text-center">RECIBO PROVISIONAL</h6></div>
	  	<div class="col-md-4">
	  		<p class="text-right">Fecha: <?= $fecha;?></p>
	  		<p class="text-right">Bueno por:</p>
	  	</div>
	</div>
	<br/>
	<p>Local <span class="underline-text">_____</span> Area <span class="underline-text">_____</span> Depósito Renta $<span class="underline-text">_____</span>
	Depósito $<span class="underline-text">_____</span> Cliente <span class="underline-text">_____</span>
	Observaciones Adicionales: <span class="underline-text">_____</span>
	</p>
	<br/>
	<br/>
	<br/>
	<div class="row">
		<div class="col-md-6" style="width: 45%; display:inline-block;">
	  		<hr class="signing">
	  		<p class="text-center small-text">_____________</p>
	 	</div>
	  	<div class="col-md-6" style="width: 45%; display:inline-block;">
	  		<hr class="signing">
	  		<p class="text-center small-text">El Cliente</p>
	  	</div>
	</div>
	<p>NOMBRE DE LA PERSONA QUE REALIZÓ LA VENTA <span class="underline-text">_____</span> TELEFONO DEL CLIENTE: <span class="underline-text">_____</span></p>
</div>