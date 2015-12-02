<?foreach ($cotizacion as $cot): ?>
<div id="mainTit">
<h3>Generador cartas de intención.</h3>
</div>


<div class="wrapListLow">
<form class="form-horizontal" method="post" action="<?=base_url();?>tempciri/generador" enctype="multipart/form-data">

	<?= $this->session->flashdata('msg'); ?>
	<div id="steps">
	<h6>Datos de cliente</h6>
	<section>
	<div class="wrapListForm" id="wrapListForm1">
		<div id="folioPrint">
		<em>Folio</em>
		<span id="folioAgenerar"><?=$plaza->ci_num+1;?></span>
		</div>
	<table id="optional">
		<thead>
		<tr>
			<th colspan="4">Datos de Cliente</th>
		</tr>
		</thead>
		<tbody>

		<tr>
			<td class="grayField"><label>Primer nombre</label></td>
			<td>
					<input type="text" class="bigInp soloLetras blockClear" name="cpnombre" id="cpnombre" required value="<?=$cot->pnombre?>">
			</td>
			<td class="grayField"><label>Segundo nombre</label></td>
			<td>
				<input type="text" class="bigInp soloLetras blockClear" name="csnombre" id="csnombre" value="<?=$cot->snombre?>">
			</td>
		</tr>
		<tr>
			<td class="grayField"><label>Apellido Paterno</label></td>
			<td>
				<input type="text" class="bigInp soloLetras blockClear" name="capaterno" id="capaterno" value="<?=$cot->apellidop?>" required>
			</td>
			<td class="grayField"><label>Apellido Materno</label></td>
			<td>
				<input type="text" value="<?=$cot->apellidom?>" class="bigInp soloLetras blockClear" name="camaterno" id="camaterno">
			</td>
		</tr>
		<tr>
			<td class="grayField"><label class="blockClear" >Email</label></td>
			<td>
				<input type="email" class="bigInp blockClear" name="clientEmail" id="clientEmail" required>
			</td>
			<td class="grayField"><label>Telefono del cliente</label></td>
			<td>
				<input type="text" class="bigInp soloNumeros blockClear" name="clientetelefono" id="clientetelefono" required>
			</td>
		</tr>
		<tr>
			<td class="grayField"><label>Fecha de nacimiento o alta SAT</label></td>
			<td>
				<input name="clienteFecha" type="text" id="clienteFecha" placeholder="año/mes/dia" class="bigInp blockClear"><img class="calInp" src="<?=base_url()?>assets/graphics/svg/calendario.svg" alt="Fecha Nacimiento" />
			</td>
			<td class="grayField"><label>Tipo persona</label></td>
			<td>
				<select class="selBig" name="clienteTipo" id="clienteTipo" required>
					<option value="">Seleccione una opción</option>
					<option value="MORAL">MORAL</option>
					<option value="FISICA">FISICA</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="grayField"><label>RFC</label></td>
			<td>
				<input type="text" class="bigInp uppercase blockClear" name="clientrfc" id="clientrfc" required>
			</td>
			<td class="grayField"><label>Numero IFE </label></td>
			<td>
				<input type="text" class="bigInp uppercase" name="folioident">
			</td>
		</tr>
		</tbody>
	</table>
	<span id="copyDatos">
		<label class="infDa" id="siInf"><input type="radio" name="name" value="si"> Si</label>
		<label class="infDa" id="noInf"><input type="radio" name="name" value="no"> No</label>
		<p>Usar la misma información para los todos los contratos que se generaran.</p>
	</span>
	<br class="clear">
	</div>
	</section>

	<h6>Información de locales</h6>
	<section>
	<div class="wrapListForm" id="wrapListForm2">

	<h3 class="mb10">Cotizaciones</h3>
	<?foreach ($cotizacionID as $var): ?>
	<? $cotizaciones = $this->prospectos_model->cargaSubCotizacionProspecto($var);?>
	<div class="wrapConTab">
	<table>
		<?foreach ($cotizaciones as $cotInfos): ?>
		<tbody>
			<tr class="optional">
				<td class="grayField"><label>Primer Nombre</label></td>
				<td><input type="text" class="cpnombre bigInp blockClear" name="name" value=""></td>
				<td class="grayField"><label>Segundo Nombre</label></td>
				<td><input type="text" class="csnombre bigInp blockClear" name="name" value=""></td>
			</tr>
			<tr class="optional">
				<td class="grayField"><label>Apellido Paterno</label></td>
				<td><input type="text" class="capaterno bigInp blockClear" name="name" value=""></td>
				<td class="grayField"><label>Apellido Materno</label></td>
				<td><input type="text" class="camaterno bigInp blockClear" name="name" value=""></td>
			</tr>
			<tr class="optional">
				<td class="grayField"><label>Email</label></td>
				<td><input type="text" class="clientEmail bigInp blockClear" name="name" value=""></td>
				<td class="grayField"><label>Telefono del Cliente</label></td>
				<td><input type="text" class="clientetelefono bigInp blockClear" name="name" value=""></td>
			</tr>
			<tr class="optional">
				<td class="grayField"><label>Fecha de Nacimiento o Alta SAT</label></td>
				<td><input type="text" class="clienteFecha bigInp blockClear" name="name" value=""> <img class="calInp" src="<?=base_url()?>assets/graphics/svg/calendario.svg" alt="Fecha Nacimiento"></td>
				<td class="grayField"><label>Tipo Persona</label></td>
				<td><input type="text" class="bigInp blockClear" name="name" value=""></td>
			</tr>
			<tr class="optional">
				<td class="grayField"><label>Folio</label></td>
				<td><input type="text" class="folioident bigInp blockClear" name="name" value=""></td>
				<td class="grayField"><label>Numero IFE</label></td>
				<td><input type="text" class="clienteTipo bigInp blockClear" name="name" value=""></td>
			</tr>
			<tr class="optional">
				<td class="grayField"><label>RFC</label></td>
				<td><input type="text" class="clientrfc bigInp blockClear" name="name" value=""></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="grayField"><label>Número de local</label></td>
				<td>
					<input type="text" class="bigInp uppercase blockClear" value="<?=$cotInfos->nombreLocal;?>" disabled name="localnum" id="localnum" required>
				</td>
				<td class="grayField"><label>Mes de inicio</label></td>
				<td>
					<select name="mes" id="mes" class="selBig" required>
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
				<td class="grayField"><label>Duración</label></td>
				<td>
					<select class="selBig" name="contratotiempo" id="contratotiempo" class="form-control" required>
	    			<option value="12 meses">12 meses</option>
	    			<option value="14 meses">14 meses</option>
	    			<option value="16 meses">16 meses</option>
	    		</select>
				</td>
				<td class="grayField"><label>Días de gracias</label></td>
				<td>
					<select name="diasGracia" id="diasGracia" class="selBig" required>
						<option value="7">7</option>
						<option value="15">15</option>
						<option value="30">30</option>
						<option value="45">45</option>
						<option value="60">60</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="grayField"><label>Renta mensual sin IVA</label></td>
				<td>
					<input type="text" class="bigInp soloNumeros blockClear" name="rentaMensual" id="rentaMensual" disabled value="<?=number_format($cotInfos->localPrecio);?>" required>
				</td>
				<td class="grayField"><label>Cantidad pagada</label></td>
				<td>
					<input type="text" class="bigInp soloNumeros" name="adelanto" required>
				</td>
			</tr>
			<tr>
				<td class="grayField"><label>Plaza</label></td>
				<td>
					<input type="hidden" name="plazaId" id="plazaId" value="" />
					<input type="text" name="plazaNombre" id="plazaNombre" class="bigInp" value="Ingresar valor" readonly required />
				</td>
				<td class="grayField"><label>Piso</label></td>
				<td>
					<select name="plazaPiso" id="plazaPiso" class="selBig" required>
							<option value="">Seleccione un piso</option>
					<? foreach($plazaPisos as $piso):
						if(empty($piso->piso)) $piso->piso = "N/A";?>
						<option value="<?=$piso->piso?>"><?=$piso->piso?></option>
					<? endforeach;?>
				</select>
				</td>
			</tr>
			<tr>
				<td class="grayField"><label>Dirección de la plaza</label></td>
				<td>
				<select name="dirplaza" id="dirplaza" class="selBig" required>
					<option value="">Seleccione una plaza...</option>
				</select>
				</td>
				<td class="grayField"><label>Folio documento</label></td>
				<td><input type="text" class="bigInp uppercase" name="folioDoc"></td>
			</tr>
			<tr>
				<td class="grayField">
					<label>Observaciones Adicionales</label>
				</td>
				<td><input class="bigInp uppercase" name="observaciones"/></td>
				<td>&nbsp</td>
				<td>&nbsp</td>
			</tr>
		</tbody>
		<?endforeach; ?>
	</table>
	<span class="valAdd"><p>Agregar datos nuevos</p></span>
	<span class="valGen"><p>Usar datos generales</p></span>
	</div>
	<?endforeach; ?>

	<br class="clear">
	</div>
		</section>


		<h6>Datos para devolución</h6>
		<section>
	<div class="wrapListForm" id="wrapListForm4">

	<table>
	<thead>
		<tr>
			<th colspan="4">Datos de devolución</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="grayField"><label>Número de cuenta</label></td>
			<td><input type="text" class="bigInp soloNumeros" name="devCuenta"></td>
			<td class="grayField"><label>CLABE</label></td>
			<td>
				<input class="bigInp soloNumeros" name="devClabe" pattern=".{18,}" maxlength="18">
			</td>
		</tr>
		<tr>
			<td class="grayField"><label>Banco</label></td>
			<td>
				<input type="text" class="bigInp soloLetras" name="devBanco">
			</td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
	</table>

	<br class="clear">
	</div>
	</section>

	<h6>Recibos de deposito</h6>
	<section>
	<div class="wrapListForm" id="wrapListForm4">

		<b class="titFormMain">Recibos de deposito.</b>
		<div id="botRecAg">
			<div id="sCTip" class="addSmallGrayBot">
				<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Agregar Recibo" /></i>
				<span>Agregar recibo </span>
			</div>
		</div>
		<div id="msgRecAgr">
			<div id="choTip">
				<span>
					<img id="closeCho" src="<?=base_url()?>assets/graphics/svg/close.svg" />
					<a class="trasForm" href="<?=base_url()?>ajax/tipoDepositoVista/1">Traspaso SPEI</a>
					<a class="trasForm" href="<?=base_url()?>ajax/tipoDepositoVista/2">Terminal</a>
					<a class="trasForm" href="<?=base_url()?>ajax/tipoDepositoVista/3">Deposito bancario</a>
				</span>
			</div>
			<div id="forAja"></div>

			<span class="msgForm">
				<img src="<?=base_url()?>assets/graphics/alert.png" alt="Sin información" />
				<p>Sin recibos agregados.</p>
			</span>
			<br class="clear">
		</div>

		<br class="clear">
	</div>
	</section>

	<h6>Documentos del cliente</h6>
	<section>
	<div class="wrapListForm" id="wrapListForm3">

	<table>
	<thead>
		<tr>
			<th colspan="4">Documentos</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="grayField"><label>Identificación</label></td>
			<td>
				<input type="file" class="bigInp" name="documentoIdentifi" required />
			</td>
		</tr>
		<tr>
			<td class="grayField"><label>Estado de cuenta</label></td>
			<td>
				<input type="file" class="bigInp" name="documentoEstadoCuenta" />
			</td>
		</tr>
	</tbody>
	</table>

	<input type="hidden" class="bigInp soloLetras" name="gerente" value="<?= $user['nombre'];?>" readonly/>
	<input type="hidden" class="bigInp soloLetras" name="vendedorNombre" id="vendedorNombre" disabled value="<?=$cot->nombreCompleto;?>" required>
	<input type="hidden" name="clienteId" id="clienteId" value="" />
	<input type="hidden" name="optionsRadios" id="cartaintencion" value="cartaintencion">
	<br class="clear">
	</div>
	</form>
</div>
</section>
</div>
<?endforeach; ?>
<script type="text/javascript" charset="utf-8">

$('.trasForm').click(function(event){
	event.preventDefault();
	var call = $(this).attr('href');
	$.ajax({
			url: call,
			})
			.done(function(data) {
				$('#forAja').append(data);
				$('#choTip').removeClass('show');
				$('.msgForm').addClass('hide');
		});
});
</script>

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


	$("#plazaPiso").change(function(){

		clearClientId();
		mostrarPlazaDir();
		mostrarFolio();
		mostrarFolioCi();
		unblockFields();
	});

//Pega valores de cotizacion en formulario
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
					$('#folioAgenerar').html(+response);
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
		var plazaPiso = $('#plazaPiso').val();
		var plazaId = $('#plazaId').val();
			$.ajax({
				data : {'plazaId': plazaId,'plazaPiso':plazaPiso},
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

$("#steps").steps({
    headerTag: "h6",
    bodyTag: "section",
		labels: {
        cancel: "Cancelar",
        current: "current step:",
        pagination: "Paginacion",
        finish: "Generar",
        next: "Siguiente",
        previous: "Anterior",
        loading: "Cargando ..."
    },
    autoFocus: true
});

$('.infDa').click(function () {
  if ($(this).find('input:radio').is(":checked")) {
    $(this).find('input:radio').attr("checked", false);
  }
  else{
  //// Agrega el valor al input escondido para despues mandar a un proceso diferente
  $(this).find('input:radio').prop("checked", true);
  }
});
 $('input[type=radio]').click(function (e) {
     e.stopPropagation();
 });

$('#noInf').click(function () {
	$('.optional').removeClass('hide');
	$.each( $('.optional input'), function( key, value ) {
  	$(this).val("");
	});
});

$('#optional input').focusout(function () {
	$('.optional').addClass('hide');
	var cpnombre = $('#cpnombre').val();
	var csnombre = $('#csnombre').val();
	var capaterno = $('#capaterno').val();
	var camaterno = $('#camaterno').val();
	var clientEmail = $('#clientEmail').val();
	var clientetelefono = $('#clientetelefono').val();
	var clienteFecha = $('#clienteFecha').val();
	var clientrfc = $('#clientrfc').val();
	var folioident = $('#folioident').val();
	var clienteTipo = $('#clienteTipo').val();

	$.each( $('.cpnombre'), function( key, value ) {
  	$(this).val(cpnombre);
	});
	$.each( $('.csnombre'), function( key, value ) {
  	$(this).val(csnombre);
	});
	$.each( $('.capaterno'), function( key, value ) {
  	$(this).val(capaterno);
	});
	$.each( $('.camaterno'), function( key, value ) {
  	$(this).val(camaterno);
	});
	$.each( $('.clientEmail'), function( key, value ) {
  	$(this).val(clientEmail);
	});
	$.each( $('.clientetelefono'), function( key, value ) {
  	$(this).val(clientetelefono);
	});
	$.each( $('.clienteFecha'), function( key, value ) {
  	$(this).val(clienteFecha);
	});
	$.each( $('.clientrfc'), function( key, value ) {
  	$(this).val(clientrfc);
	});
	$.each( $('.folioident'), function( key, value ) {
  	$(this).val(folioident);
	});
	$.each( $('.clienteTipo'), function( key, value ) {
  	$(this).val(clienteTipo);
	});
});

$('.valAdd').click(function () {
	$(this).parent().find('.optional input').val('');
	$(this).parent().find('.optional').removeClass('hide');
});

$('#siInf').click( function(){

	$('.wrapListForm').find('.optional').addClass('hide');

	var cpnombre = $('#cpnombre').val();
	var csnombre = $('#csnombre').val();
	var capaterno = $('#capaterno').val();
	var camaterno = $('#camaterno').val();
	var clientEmail = $('#clientEmail').val();
	var clientetelefono = $('#clientetelefono').val();
	var clienteFecha = $('#clienteFecha').val();
	var clientrfc = $('#clientrfc').val();
	var folioident = $('#folioident').val();
	var clienteTipo = $('#clienteTipo').val();

	$('.wrapListForm').find('.optional input').val('');
	$('.wrapListForm').find('.cpnombre').val(cpnombre);
	$('.wrapListForm').find('.csnombre').val(csnombre);
	$('.wrapListForm').find('.capaterno').val(capaterno);
	$('.wrapListForm').find('.camaterno').val(camaterno);
	$('.wrapListForm').find('.clientEmail').val(clientEmail);
	$('.wrapListForm').find('.clientetelefono').val(clientetelefono);
	$('.wrapListForm').find('.clienteFecha').val(clienteFecha);
	$('.wrapListForm').find('.clientrfc').val(clientrfc);
	$('.wrapListForm').find('.folioident').val(folioident);
	$('.wrapListForm').find('.clienteTipo').val(clienteTipo);
});

$('#noInf').click( function(){

	$('.wrapListForm').find('.hide').removeClass();
	$('.wrapListForm').find('.optional input').val('');

	var cpnombre = $('#cpnombre').val();
	var csnombre = $('#csnombre').val();
	var capaterno = $('#capaterno').val();
	var camaterno = $('#camaterno').val();
	var clientEmail = $('#clientEmail').val();
	var clientetelefono = $('#clientetelefono').val();
	var clienteFecha = $('#clienteFecha').val();
	var clientrfc = $('#clientrfc').val();
	var folioident = $('#folioident').val();
	var clienteTipo = $('#clienteTipo').val();

});


// llama el iframe de depositos
$('.trasForm').click(function(event){
	event.preventDefault();
	var call = $(this).attr('href');
	$.ajax({
			url: call,
			})
			.done(function(data) {
				$('#forAja').append(data);
				$('#choTip').removeClass('show');
				$('.msgForm').addClass('hide');
		});
});

$('.valGen').click(function () {
	var cpnombre = $('#cpnombre').val();
	var csnombre = $('#csnombre').val();
	var capaterno = $('#capaterno').val();
	var camaterno = $('#camaterno').val();
	var clientEmail = $('#clientEmail').val();
	var clientetelefono = $('#clientetelefono').val();
	var clienteFecha = $('#clienteFecha').val();
	var clientrfc = $('#clientrfc').val();
	var folioident = $('#folioident').val();
	var clienteTipo = $('#clienteTipo').val();

	$(this).parent().find('.optional input').val('');
	$(this).parent().find('.optional').removeClass('hide');

	$(this).parent().find('.cpnombre').val(cpnombre);
	$(this).parent().find('.csnombre').val(csnombre);
	$(this).parent().find('.capaterno').val(capaterno);
	$(this).parent().find('.camaterno').val(camaterno);
	$(this).parent().find('.clientEmail').val(clientEmail);
	$(this).parent().find('.clientetelefono').val(clientetelefono);
	$(this).parent().find('.clienteFecha').val(clienteFecha);
	$(this).parent().find('.clientrfc').val(clientrfc);
	$(this).parent().find('.folioident').val(folioident);
	$(this).parent().find('.clienteTipo').val(clienteTipo);
});
</script>
