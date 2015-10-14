<div class="pdf-container">
<div style="visibility: hidden;">
	<h4 class="text-center" style="color:#FFFFFF; background-color: rgb(175, 167, 167); padding: 6px 0; font-weight: bold;"><?=strtoupper($plaza);?></h4>
	<br/>
	<div class="row" style="margin:0;">
		<div class="col-md-4" style="width: 33.333%; display:inline-block;"><p class="text-left"><strong>www.apeplazas.com</strong></p></div>
	  	<div class="col-md-4" style="width: 33.333%; display:inline-block;">
	  		<p class="text-center"><strong>RECIBO INTERNO</strong></p>
	  		<p class="text-center"><strong>No. <?=$folioDoc;?></strong></p>
	  	</div>
	  	<div class="col-md-4" style="width: 33.333%; display:inline-block;">
	  		<p>Fecha: <?= $fecha;?></p>
	  		<p>Bueno por: <?= money_format('%(#10n',$rentant);?></p>
		</div>
	</div>
	<div class="row" style="margin:0; border: solid 1px black; background-color: rgb(175,167,167); border-radius: 5px;">
		<p>Recibimos del (a) <span class="underline-text"><?= $clientNom; ?></span></p>
		<p>La cantidad de $<span class="underline-text"><?= $rentant;?></span> cantidad con letra <span class="underline-text"><?= $depositoLetra;?></span></p>
		<p>Por concepto de depósito del local: <span class="underline-text"><?= $local;?></span> del área de: <span class="underline-text"><?= $dirplaza;?></span></p>
	</div>
	<br/>
	<p style="font-size:9px;">Dentro del conjunto comercial demoninado <?=$plaza;?>, conforme a las siguientes especificaciones:</p>
	<p style="font-size:9px;">1.- Del presente recibo no se deriva obligación para esta entidad comercial, o derecho alguno para el cliente.</p>
	<p style="font-size:9px;">2.- El presente recibo ampara la cantidad expresamente señalada en el mismo, no genera ninguna clase de interés y se expide exclusivamente por el local indicado.</p>
	<p style="font-size:9px;">3.- El pago total por la operación y la documentación requerida al cliente por la entidad comercial, deberán ser cubiertos en un plazo máximo de 7 días naturales contados a partir de la fecha señalada en el recibo.</p>
	<p style="font-size:9px;">4.- La entidad comercial no se encuentra obligada a respetar el pago total o parcial "Apartado", después de haber transcurrido un máximo de 7 días naturales a partir de la fecha de expedición del mismo, en dicho caso el cliente podrá solicitar la devolución del importe que ampara este recibo, canjeándolo por este recibo provisional.</p>
	<p style="font-size:9px;">5.- El presente recibo no da derechos al liente de celebrar Contrato de Cesión de Derechos con un tercero con respecto a este recibo, ni de celebrar contrato de subarrendamiento con esta entidad comercial, ni de tomar posesión de local alguno.</p>
	<p style="font-size:9px;"><strong>6.- Este recibo no es oficial ni valido para efectos fiscales, una vez que el cliente haya entregado la documentación que se le requiera, celebre el contrato de subarrendamiento respectivo y haya liquidado el importe total de la operación (pago de renta, depósito en garantía, y/o por el concepto que se expida) el presente recibo provisional será canjeado por el (los) correspondiente (s) recibo (s) oficial (es)</strong></p>
	<hr />
	<p><strong>Condiciones Generales:</strong></p>
	<p>Contrato a partir del mes <span class="underline-text"><?= $rentmes;?></span> con una duración de <span class="underline-text"><?= $rentduracion;?></span> con <span class="underline-text"><?= $diasGracia;?></span> días de gracia con una renta mensual de <span class="underline-text"><?=money_format('%(#10n',$rentaCant);?></span> + I.V.A. cantidad con letra (<span class="underline-text"><?=$rentanLocalLetra;?></span>) y una renta de depósito de <span class="underline-text"><?= money_format('%(#10n',$rentaDeposito);?></span> cantidad con letra (<span class="underline-text"><?= $rentaDepositoLet;?></span>)</p>
	<div class="row">
		<? if(!empty($refCi)):?>
		<div class="col-md-6"><p>Folio CI <span class="underline-text"><?=$refCi;?></span></p></div>
	  	<div class="col-md-6"><p><span class="underline-text"><?=money_format('%(#10n',$depositoCi);?></span></p></div>
	  	<?php endif;?>
	</div>
	
	<br/>
	<br/>
	<br/>
	<div class="row">
		<div class="col-md-6" style="width: 45%; display:inline-block;">
	  		<hr class="signing">
	  		<p class="text-center small-text"><?=$plaza;?></p>
	 	</div>
	  	<div class="col-md-6" style="width: 45%; display:inline-block;">
	  		<hr class="signing">
	  		<p class="text-center small-text">El Cliente</p>
	  	</div>
	</div>
	<p class="text-right">NOMBRE DE LA PERSONA QUE REALIZÓ LA VENTA <span class="underline-text"><?= $vendedorNombre;?></span> TELEFONO DEL CLIENTE: <span class="underline-text"><?=$clientetelefono;?></span></p>
	<p class="text-right">Email <span class="underline-text"><?= $clientEmail; ?></span></p>
	<hr style="border-top: 2px dotted #000;">
</div>
	<p>1.- Del presente documento no se deriva obligación para esta entidad comercial, o derecho alguno para el cliente.</p>
	<p>2.- El presente documento ampara únicamente la cantidad expresamente señalada en el mismo, no genera ninguna clase de interés y  se expide exclusivamente por el local indicado.</p>
	<p>3.- El pago total por la operación y la documentación requerida al cliente por la entidad comercial, deberán ser cubiertos en un plazo máximo de 7 días naturales contados a partir de la fecha señalada en el presente  documento.</p>
	<p>4.- Se entiende que una vez transcurridos los 7 días sin que el cliente liquide la totalidad de la inversión inicial o cubra los requisitos requeridos, es deseo del cliente ya no celebrar el contrato y por ende le será devuelta la cantidad señalada en el presente documento, en la cuenta bancaria que para tales efectos designo, liberando con ello de toda responsabilidad a esta entidad comercial.</p>
	<p>5.- El presente documento no da derecho al cliente de celebrar Contrato de Cesión de Derechos con un tercero respecto del presente, ni de celebrar contrato de subarrendamiento con esta entidad comercial, ni de tomar posesión de local alguno.</p>
	<p>6.- <strong>6.- Este documento no es oficial ni válido para efectos fiscales; una vez que el cliente haya entregado la documentación que se le requiera, celebre el contrato de subarrendamiento respectivo y haya liquidado el importe total de la operación (pago de renta, depósito en garantía y/o por el concepto que se expida, el presente le será canjeado por el (los) correspondiente(s) recibo(s) oficial(es).</strong></p>
</div>