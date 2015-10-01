<div class="pdf-container">
	<h4 class="text-center" style="color:#000;">CARTA INTENCION ___________</h4>
	<br/>
	<p class="text-right"><strong>folio ____</strong></p>
	<p class="text-right">Fecha: <span class="underline-text"><?= $fecha;?></span></p>
	<p>C: GERENTE DE ______________ : <span class="underline-text"><?= $usuario['nombre'];?></span></p>
	<br/>
	<p>PRESENTE</p>
	<br/>
	<p>Yo <span class="underline-text"><?= $perfil[0]->pnombre . " " . $perfil[0]->snombre . " " . $perfil[0]->apellidop . " " . $perfil[0]->apellidom; ?></span> 
	con credencial para votar con fotografía con número de folio <span class="underline-text"><?= $crednum;?></span> por la presente le hago 
	saber a la administración de este centro comercial : Que tengo la intenión de aquirir en ARRENDAMIENTO uno de los locales
	comerciales que se encuentran ubicados dentro del Centro Comercial que usted administra y que se encuentra ubicado en:
	<span class="underline-text">_____________________</span></p>
	<br/>
	<p>En relación al local que deseo arrendarles, les pido sean consideradas las siguientes condiciones básicas:
	Contrato a partir del mes de <span class="underline-text"><?= $rentmes;?></span> con una duración de <span class="underline-text"><?= $rentduracion;?></span> 
	con <span class="underline-text">___</span> días de gracia con una renta mensual de $<span class="underline-text">_____</span> mas I.V.A. (<span class="underline-text">____________</span>) 
	una renta de deposito de $<span class="underline-text"><?= $rentant;?></span></p>
	<br/>
	<p>Por la presente, ruego a la administración de <strong>___________</strong>, darme una OPCION para celebrar el correspondiente contrato de 
	ARRENDAMIENTO, quedo en el entendido de que el plazo para concretar el contrato sera de 7 días contados a partir de la presente fecha.
	En el que me comprometo a entregar toda la documentación solicitada y cubrir requisitos que me sean requeridos.</p>
	<br/>
	<p>Y en señal se mi deseo de efectuar la referida operación, en este acto, entrego a la Administración de este Centro Comercial
	la suma de $<span class="underline-text"><?= $rentant;?></span> (<span class="underline-text"><?= $rentantLetra;?></span>) suma que, para el caso de que por cualquier 
	situación no se logre la firma del contrato de arrendamiento sea por cuestiones imputables a mi, o a que la Administración de este Centro Comercial no me 
	otorgue el correspondiente contrato de Arrendamiento, acepto que la cantidad de dinero por mi entregada, me sea reintegrada al transcurrir los 7 días señalados 
	anteriormente, sea depositado al número de cuenta <span class="underline-text"><?= $remnumcuenta;?></span> del banco <span class="underline-text"><?= $rembanco;?></span> 
	a mi nombre, contra entrega del talón comprobante relacionado con esta carta intención con número de folio __________ y no tendré reclamo ni derecho alguno de ejercitar en contra de la Administración
	de _________, en virtud de lo señalado en el presente documento.</p>
	<br/>
	<br/>
	<br/>
	<div class="row">
		<div class="col-md-6" style="width: 45%; display:inline-block;">
	  		<hr class="signing">
	  		<p class="text-center small-text">(nombre y firma de quien manifiesta su intención)</p>
	 	</div>
	  	<div class="col-md-6" style="width: 45%; display:inline-block;">
	  		<hr class="signing">
	  		<p class="text-center small-text">Gerente de NOMBRE DE LA pLAZA</p>
	  		<p class="text-center small-text">(La firma aquí estampada no implica la aceptación de la intención manifestada por el cliente,
	  		 sino solo la receptición de la misma y de la cantidad descrita, obligando únicamente a esta Administración a la devolución
	  		 de dicha cantidad en caso de no concretarse la firma del contrato de arrendamiento)</p>
	  	</div>
	</div>
	<hr style="border-top: 2px dotted #000;">
	<h6 class="text-center">TALON COMPROBANTE</h6>
	<br/>
	<p class="text-right"><strong>folio</strong></p>
	<br/>
	<p>Relacionado con la carta intención con número de Folio <span class="underline-text">_____</span> de fecha <span class="underline-text"><?= $fecha;?></span> mediante
	la cual el C. <span class="underline-text"><?= $perfil[0]->pnombre . " " . $perfil[0]->snombre . " " . $perfil[0]->apellidop . " " . $perfil[0]->apellidom; ?></span>
	manifiesta su deseo de adquirir en arrendamiento un local comercial dentro de <strong>PLAZA</strong> y entrego a esta administración la cantidad de 
	$<span class="underline-text"><?= $rentant;?></span> (<span class="underline-text"><?= $rentantLetra;?></span>) amparando el comprobante dicha cantidad, sin generarle ningún derecho
	mas que la devolucón de la cantidad descrita para el caso de que en un plazo de 7 días contados a partir de esta fecha no se celebre el contrato de arrendamiento correspondiente.</p>
	<br/>
	<br/>
	<br/>
	<div class="row">
		<div class="col-md-6" style="width: 45%; display:inline-block;">
	  		<hr class="signing">
	  		<p class="text-center small-text">(nombre y firma de quien manifiesta su intención)</p>
	 	</div>
	  	<div class="col-md-6" style="width: 45%; display:inline-block;">
	  		<hr class="signing">
	  		<p class="text-center small-text">Gerente de NOMBRE DE LA pLAZA</p>
	  		<p class="text-center small-text">(La firma aquí estampada no implica la aceptación de la intención manifestada por el cliente,
	  		 sino solo la receptición de la misma y de la cantidad descrita, obligando únicamente a esta Administración a la devolución
	  		 de dicha cantidad en caso de no concretarse la firma del contrato de arrendamiento)</p>
	  	</div>
	</div>
</div>