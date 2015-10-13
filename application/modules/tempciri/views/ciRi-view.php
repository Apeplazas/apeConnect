<div id="mainTit">
<h3>Generador cartas y recibos internos.</h3>
</div>


<div class="wrapList">
<form class="form-horizontal" method="post" action="<?=base_url();?>tempciri/generador" enctype="multipart/form-data">

	<div id="actions">
		<div class="botCart">
		  <label>
		    <input type="radio" name="optionsRadios" id="cartaintencion" value="cartaintencion" checked>
		    <strong>Generar Carta de intención</strong>
		  </label>
		</div>
		<div class="col-sm-4">
		  <label>
		    <input type="radio" name="optionsRadios" id="recibointernoci" value="recibointernoci">
		    <strong>Generar Recibo Interno desde Carta de intención</strong>
		  </label>
		</div>
		<div class="col-sm-4">
		  <label>
		    <input type="radio" name="optionsRadios" id="recibointerno" value="recibointerno">
		    <strong>Generar Recibo Interno desde cero</strong>
		  </label>
		</div>

		<span class="back">
		 <a class="addSmall" href="javascript:window.history.go(-1);">
			 <i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/back.svg" alt="Regresar"></i>
			 <span>Regresar</span>
		 </a>
		</span>
	</div>

	<?= $this->session->flashdata('msg'); ?>

	<div class="wrapListForm" id="wrapListForm1">
	<table>
		<thead>
		<tr>
			<th colspan="2">Datos Generales</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td><label>Plaza</label></td>
			<td>
				<select name="plazaNombre" id="plazaNombre" class="form-control" required>
				<option value="">Seleccione una plaza...</option>
				<?php foreach($plazas as $plaza):?>
				<option value="<?=$plaza->PROPIEDAD?>"><?=$plaza->PROPIEDAD?></option>
				<?php endforeach;?>
			</select>
			<label id="folioAgenerar"></label>
			</td>
		</tr>
		<tr>
			<td><label>Folio CI</label></td>
			<td><select name="refCi" id="refCi" class="form-control"></select></td>
		</tr>
		<tr>
			<td><label>Dirección de la plaza</label></td>
			<td><select name="dirplaza" id="dirplaza" class="form-control" required>
		<option value="">Seleccione una plaza...</option>
	</select></td>
		</tr>
		<tr>
			<td>
				<label>Gerente de la plaza</label>
			</td>
			<td>
				<input type="text" class="form-control soloLetras" name="gerente">
			</td>
		</tr>
		<tr>
			<td>
				<label>Persona que realizó la venta</label>
			</td>
			<td>
				<input type="text" class="form-control soloLetras" name="vendedorNombre" id="vendedorNombre" required>
			</td>
		</tr>
		<tr>
			<td><label>Folio documento</label></td>
			<td><input type="text" class="form-control uppercase" name="folioDoc"></td>
		</tr>
		<tr>
			<td><label>Tipo persona</label></td>
			<td>
				<select name="clienteTipo" id="clienteTipo" required>
					<option value="">Seleccione una opción</option>
					<option value="MORAL">MORAL</option>
					<option value="FISICA">FISICA</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label>Fecha de nacimiento o alta SAT</label>
			</td>
			<td>
				<input name="clienteFecha" type="text" id="clienteFecha" placeholder="año/mes/dia" readonly='true' class="blockClear"><img src="<?=base_url()?>assets/graphics/calendar.jpg" alt="" />
			</td>
		</tr>
		<tr>
			<td>
				<label class="control-label col-sm-3">Nombre del cliente</label>
			</td>
			<td>
				<div class="col-xs-4 col-md-2">
					<input type="text" class="form-control soloLetras blockClear" placeholder="Primer Nombre" name="cpnombre" id="cpnombre" required>
				</div>
				<div class="col-xs-4 col-md-2">
					<input type="text" class="form-control soloLetras blockClear" placeholder="Segundo Nombre" name="csnombre" id="csnombre">
				</div>
			<div class="col-xs-4 col-md-2">
				<input type="text" class="form-control soloLetras blockClear" placeholder="Apellido Paterno" name="capaterno" id="capaterno" required>
			</div>
			<div class="col-xs-4 col-md-2">
				<input type="text" class="form-control soloLetras blockClear" placeholder="Apellido Materno" name="camaterno" id="camaterno">
			</div>
			</td>
		</tr>
		<tr>
			<td>
				<label class="control-label col-sm-3" >Telefono del cliente</label>
			</td>
			<td>
				<input type="text" class="form-control soloNumeros blockClear" name="clientetelefono" id="clientetelefono" required>
			</td>
		</tr>
		<tr>
			<td>
				<label class="blockClear" >Email</label>
			</td>
			<td>
				<input type="email" class="form-control blockClear" name="clientEmail" id="clientEmail" required>
			</td>
		</tr>
		<tr>
			<td>
				<label>RFC</label>
			</td>
			<td>
				<input type="text" class="form-control uppercase blockClear" name="clientrfc" id="clientrfc" required>
			</td>
		</tr>
		<tr>
			<td>
				  <label class="control-label col-sm-3" >Folio de identificación</label>
			</td>
			<td>
				<input type="text" class="form-control uppercase" name="folioident">
			</td>
		</tr>
		</tbody>
	</table>
	<br class="clear">
	</div>


	<div class="wrapListForm" id="wrapListForm2">
	<table>
		<thead>
			<tr>
				<th colspan="2">Contrato</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<label class="control-label col-sm-3" >Número de local</label>
				</td>
				<td>
					<input type="text" class="form-control uppercase blockClear" name="localnum" id="localnum" required>
				</td>
			</tr>
			<tr>
				<td>
					<label>Mes de inicio</label>
				</td>
				<td>
					<select name="mes" id="mes" class="form-control" required>
						<option value="Enero">Enero</option>
						<option value="Febrero">Febrero</option>
						<option value="Marzo">Marzo</option>
						<option value="Abril">Abril</option>
						<option value="Mayo">Mayo</option>
						<option value="Junio">Junio</option>
						<option value="Julio">Julio</option>
						<option value="Agosto">Agosto</option>
						<option value="Septiembre">Septiembre</option>
						<option value="Octubre">Octubre</option>
						<option value="Noviembre">Noviembre</option>
						<option value="Diciembre">Diciembre</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label>Duración</label>
				</td>
				<td>
					<select name="contratotiempo" id="contratotiempo" class="form-control" required>
	    			<option value="12 meses">12 meses</option>
	    			<option value="14 meses">14 meses</option>
	    			<option value="16 meses">16 meses</option>
	    		</select>
				</td>
			</tr>
			<tr>
				<td>
					<label>Días de gracias</label>
				</td>
				<td>
					<select name="diasGracia" id="diasGracia" class="form-control" required>
						<option value="7">7</option>
						<option value="15">15</option>
						<option value="30">30</option>
						<option value="45">45</option>
						<option value="60">60</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label>Renta mensual sin IVA</label>
				</td>
				<td>
					<input type="number" class="form-control soloNumeros blockClear" name="rentaMensual" id="rentaMensual" required>
				</td>
			</tr>
			<tr>
				<td>
					<label>Cantidad pagada</label>
				</td>
				<td>
					<input type="number" class="form-control soloNumeros" name="adelanto" required>
				</td>
			</tr>
			<tr>
				<td>
					<label>Observaciones Adicionales</label>
				</td>
				<td>
					<textarea class="form-control uppercase" name="observaciones"></textarea>
				</td>
			</tr>
		</tbody>
	</table>
	<br class="clear">
	</div>


	<div class="wrapListForm" id="wrapListForm2">
	<table>
	<thead>
		<tr>
			<th colspan="2">Datos de devolución</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><label>Número de cuenta</label></td>
			<td><input type="number" class="form-control soloNumeros" name="devCuenta"></td>
		</tr>
		<tr>
			<td>
				<label>CLABE</label>
			</td>
			<td>
				<input class="form-control soloNumeros" name="devClabe" pattern=".{18,}" maxlength="18">
			</td>
		</tr>
		<tr>
			<td><label>Banco</label></td>
			<td>
				<input type="text" class="form-control soloLetras" name="devBanco">
			</td>
		</tr>
	</tbody>
	</table>
	<br class="clear">
	</div>

	<div class="wrapListForm" id="wrapListForm2">
	<table>
	<thead>
		<tr>
			<th colspan="2">Documentos</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><label>Comprobante de pago</label></td>
			<td>
				<input type="file" class="form-control" name="documentoPago" required />
			</td>
		</tr>
		<tr>
			<td>
				<label>Identificación</label>
			</td>
			<td>
				<input type="file" class="form-control" name="documentoIdentifi" required />
			</td>
		</tr>
		<tr>
			<td>
				<label>Estado de cuenta</label>
			</td>
			<td>
				<input type="file" class="form-control" name="documentoEstadoCuenta" />
			</td>
		</tr>
	</tbody>
	</table>
	<br class="clear">
	</div>

	  	<input type="hidden" name="clienteId" id="clienteId" value="" />
	  	<button type="submit" class="btn btn-primary btn-lg btn-block">Generar</button>

	</form>

</div>


<script>
$(document).ready(function(){

	$("#clienteFecha").datepicker({
    	dateFormat: 'dd-mm-yy',
    	changeMonth: true,
   		changeYear: true,
   		yearRange: "-100:+0",
    	onSelect: function(){
			var dateObject = $(this).datepicker('getDate');
			generarRFC();
		}
   	});

   	$("#clienteTipo").change(function(){
   		generarRFC();
   	});

   	$("#cpnombre, #csnombre, #capaterno, #camaterno").keyup(function(){
   		generarRFC();
   	});

   	function generarRFC(){

   		if( $("#clienteFecha").val() && $("#clienteTipo").val() && $("#cpnombre").val() ){
	   		var cNombre = $.trim( $("#cpnombre").val() + ' ' + $("#csnombre").val() + ' ' + $("#capaterno").val() + ' ' + $("#camaterno").val() + ' ' );
	   		cNombre = cNombre.replace(/\s\s+/g, ' ');
	   		var cFecha = $("#clienteFecha").val();
	   		var cTipo = $("#clienteTipo").val();
			$.ajax({
				data : {'persona':cTipo,'nombre':cNombre,'fecha':cFecha},
				dataType : 'json',
				url : ajax_url + 'genera_rfc',
				type : 'post',
				success : function(response) {
					console.log(response);
					$('#clientrfc').val(response.rfc);
				}
			});
		}

	}



	$('.toggleri').hide();

	$("input[type=radio][name=optionsRadios]").change(function(){
		/*
		$('#dirplaza').empty();
		$option = $("<option></option>")
		.attr("value", '')
		.text('Seleccione una plaza...');
		$('#dirplaza').append($option);
		*/
		clearClientId();
		mostrarFolio();
		clearFields();
		unblockFields();

		if($(this).val() == 'cartaintencion' || $(this).val() == 'recibointerno'){
			$('#showrefCi').hide();
			$('#refCi').empty();
		}

		if($(this).val() == 'cartaintencion'){
			$('.toggleci').show();
			$('.toggleri').hide();
		}else{
			$('.toggleci').hide();
			$('.toggleri').show();
		}

		if($(this).val() == 'recibointernoci'){

			mostrarFolioCi();
		}

	});

	$("#plazaNombre").change(function(){

		clearClientId();
		mostrarPlazaDir();
		mostrarFolio();
		mostrarFolioCi();
		clearFields();
		unblockFields();

	});

	$('#refCi').change(function(){

		clearClientId();
		clearFields();
		var ciId = $(this).val();
		$.ajax({
			data : {'ciId':ciId},
			dataType : 'json',
			url : ajax_url + 'traeCiDatos',
			type : 'post',
			success : function(response) {
				if($.isEmptyObject(response)){
						alert("Ocurrio un error, intentelo de nuevo");
					}else{

						$('#clienteId').val(response.clienteId);

						$('#cpnombre').val(response.pnombre);
						$('#csnombre').val(response.snombre);
						$('#capaterno').val(response.apellidopaterno);
						$('#camaterno').val(response.apellidomaterno);
						$('#clienteFecha').val(response.fechaNacimiento);

						$('#clientEmail').val(response.email);
						$('#clientetelefono').val(response.telefono);
						$('#clientrfc').val(response.rfc);

						$('#mes').empty();
						$option = $("<option></option>")
					    .attr("value", response.contraroInicioMes)
					    .text(response.contraroInicioMes);
					    $('#mes').append($option);

					    $('#clienteTipo').empty();
					    $option = $("<option></option>")
					    .attr("value", response.tipoCliente)
					    .text(response.tipoCliente);
					    $('#clienteTipo').append($option);

					    $('#contratotiempo').empty();
						$option = $("<option></option>")
					    .attr("value", response.contratoDuracion)
					    .text(response.contratoDuracion);
					    $('#contratotiempo').append($option);

					    $('#diasGracia').empty();
						$option = $("<option></option>")
					    .attr("value", response.diasGracia)
					    .text(response.diasGracia);
					    $('#diasGracia').append($option);

					    $('#dirplaza').empty();
						$option = $("<option></option>")
					    .attr("value", response.dir)
					    .text(response.dir);
					    $('#dirplaza').append($option);

					    $('#localnum').val(response.local);
						$('#rentaMensual').val(response.renta);

				   	}
			}
		});
		blockFields();

	});

	function clearClientId(){

		$('#clienteId').val('');

	}

	function blockFields(){

		$(".blockClear").prop('disabled', true);

	}

	function unblockFields(){

		$(".blockClear").prop('disabled', false);

	}

	function clearFields(){

		$('.blockClear').val('');

		var tiposPersona = ['MORAL','FISICA'];
		$('#clienteTipo').empty();
		$option = $("<option></option>")
			.attr("value", '')
			.text('Seleccione una opción');
			$('#clienteTipo').append($option);
		$.each(tiposPersona,function(index,val){
			$option = $("<option></option>")
			.attr("value", val)
			.text(val);
			$('#clienteTipo').append($option);
		});

		var meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
		$('#mes').empty();
		$.each(meses,function(index,val){
			$option = $("<option></option>")
			.attr("value", val)
			.text(val);
			$('#mes').append($option);
		});

		var duracion = ['12 meses','14 meses','16 meses'];
		$('#contratotiempo').empty();
		$.each(duracion,function(index,val){
			$option = $("<option></option>")
			.attr("value", val)
			.text(val);
			$('#contratotiempo').append($option);
		});

		var diasGracias = ['7','15','30','45','60'];
		$('#diasGracia').empty();
		$.each(diasGracias,function(index,val){
			$option = $("<option></option>")
			.attr("value", val)
			.text(val);
			$('#diasGracia').append($option);
		});

	}

	function mostrarFolio(){

		$('#folioAgenerar').html('');
		if($("#plazaNombre").val()){
			var tipodoc;
			if($("input[type=radio][name=optionsRadios]:checked").val() == 'cartaintencion')
				tipodoc = 'CI';
			else
				tipodoc = 'RI';
			$.ajax({
				data : {'plaza':$("#plazaNombre").val(),'documento':tipodoc},
				dataType : 'json',
				url : ajax_url + 'traeFolioGenerar',
				type : 'post',
				success : function(response) {
					$('#folioAgenerar').html('Folio que se va a generar '+response);
				}
			});
		}

	}

	function mostrarFolioCi(){

		if($("input[type=radio][name=optionsRadios]:checked").val() == 'recibointernoci'){
			var self, $option;
    		$('#refCi').empty();
    		self = $('#refCi');
			$.ajax({
				data : {'plaza':$("#plazaNombre").val()},
				dataType : 'json',
				url : ajax_url + 'traeCiPorPlaza',
				type : 'post',
				success : function(response) {
					if($.isEmptyObject(response)){
						$option = $("<option></option>")
					    .attr("value", "")
					    .text("No existen folios en esta plaza");
					    self.append($option);
					}else{
						$option = $("<option></option>")
					    .attr("value", "")
					    .text("Seleccione un folio");
					    self.append($option);
						$.each(response, function(index, option) {
					    	$option = $("<option></option>")
					        .attr("value", option.id)
					        .text(option.folio);
					      	self.append($option);
					    });
				   	}
				}
			});
			$('#showrefCi').show();
		}

	}

	function mostrarPlazaDir(){

		var self, $option;
    	$('#dirplaza').empty();
    	self = $('#dirplaza');
		var plaza = $('#plazaNombre').val();
			$.ajax({
				data : {'plaza':plaza},
				dataType : 'json',
				url : ajax_url + 'cargarPlazasDir',
				type : 'post',
				success : function(response) {
					if($.isEmptyObject(response)){
						$option = $("<option></option>")
					    .attr("value", "")
					    .text("No hay direcciones");
					    self.append($option);
					}else{
						$option = $("<option></option>")
					    .attr("value", "")
					    .text("Seleccione una dirección");
					    self.append($option);
						$.each(response, function(index, option) {
					    	$option = $("<option></option>")
					        .attr("value", option.direccion)
					        .text(option.direccion);
					      	self.append($option);
					    });
				   	}
				}
			});

	}

});
</script>
