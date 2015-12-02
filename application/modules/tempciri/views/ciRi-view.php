<div id="mainTit">
<h3>Generador cartas de intención.</h3>
</div>

<div class="loader" style="display:none;"></div>
<div class="wrapList">
<form class="form-horizontal" method="post" id="generateCi" action="<?=base_url();?>tempciri/generador" enctype="multipart/form-data">

	<div id="actions">
		<div class="busquedaForm">
			<!-- <? $this->load->view('includes/toolbars/buscaProspectos');?>--->
		</div>
		<span class="back">
		 <a class="addSmall" href="javascript:window.history.go(-1);">
			 <i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/back.svg" alt="Regresar"></i>
			 <span>Regresar</span>
		 </a>
		</span>
	</div>

	<?= $this->session->flashdata('msg'); ?>


	<div id="resultadosView">
		<span id="loading" style="display:none; margin-top:20px; text-align:center;"><img width="30" src="<?=base_url()?>assets/graphics/svg/loading.svg" alt="Cargando" /></span>
		<br class="clear">
	</div>
<br class="clear">

	<div class="wrapListForm" id="wrapListForm1">
	<table>
		<thead>
		<tr>
			<th colspan="4">Datos Generales</th>
		</tr>
		</thead>
		<tbody>
			
		<tr>
			<td class="grayField"><label>Tipo persona</label></td>
			<td colspan="3">
				<select class="selBig" name="clienteTipo" id="clienteTipo" required>
					<option value="">Seleccione una opción</option>
					<option value="MORAL">MORAL</option>
					<option value="FISICA">FISICA</option>
				</select>
			</td>
		</tr>
		
		<tr class="personamoral">
			<td class="grayField"><label>Nombre de la empresa</label></td>
			<td colspan="3">
					<input type="text" class="bigInp blockClear" name="empresanombre" id="empresanombre" required>
			</td>
		</tr>
		<tr class="personamoral">
			<td colspan="4"><label style="text-align: center;">Representante legal</label></td>
		</tr>

		<tr class="personagen">
			<td class="grayField"><label>Primer nombre</label></td>
			<td>
					<input type="text" class="bigInp soloLetras blockClear" name="cpnombre" id="cpnombre" required>
			</td>
			<td class="grayField"><label>Segundo nombre</label></td>
			<td>
				<input type="text" class="bigInp soloLetras blockClear" name="csnombre" id="csnombre">
			</td>
		</tr>
		<tr class="personagen">
			<td class="grayField"><label>Apellido Paterno</label></td>
			<td>
				<input type="text" class="bigInp soloLetras blockClear" name="capaterno" id="capaterno" required>
			</td>
			<td class="grayField"><label>Apellido Materno</label></td>
			<td>
				<input type="text" class="bigInp soloLetras blockClear" name="camaterno" id="camaterno">
			</td>
		</tr>
		<tr>
			<td class="grayField"><label>Plaza</label></td>
			<td>
				<input type="hidden" name="plazaId" id="plazaId" value="<?=$plaza->id; ?>" />
				<input type="text" name="plazaNombre" id="plazaNombre" class="bigInp" value="<?=$plaza->plaza;?>" readonly required />
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
			<td class="grayField"><label>Gerente de la plaza</label></td>
			<td>
				<input type="text" class="bigInp soloLetras" name="gerente" value="<?= $gerente;?>" readonly/>
			</td>
			<td class="grayField"><label>Persona que realizó la venta</label></td>
			<td>
				<input type="text" class="bigInp soloLetras" name="vendedorNombre" id="vendedorNombre" required>
			</td>
		<tr>
			<td class="grayField"><label>Fecha de nacimiento o alta SAT</label></td>
			<td>
				<input name="clienteFecha" type="text" id="clienteFecha" placeholder="año/mes/dia" class="bigInp blockClear" required><img class="calInp" src="<?=base_url()?>assets/graphics/svg/calendario.svg" alt="Fecha Nacimiento" />
			</td>
			<td class="grayField"><label>Telefono del cliente</label></td>
			<td>
				<input type="text" class="bigInp soloNumeros blockClear" name="clientetelefono" id="clientetelefono" required>
			</td>
		</tr>
		<tr>
			<td class="grayField"><label class="blockClear" >Email</label></td>
			<td>
				<input type="email" class="bigInp blockClear" name="clientEmail" id="clientEmail" required>
			</td>
			<td class="grayField"><label>RFC</label></td>
			<td>
				<input type="text" class="bigInp uppercase blockClear" name="clientrfc" id="clientrfc" required>
			</td>
		</tr>
		<tr>
			<td class="grayField"><label>Numero IFE </label></td>
			<td>
				<input type="text" class="bigInp uppercase" name="folioident">
			</td>
			<td class="grayField"><label>Folio</label></td>
			<td><span id="folioAgenerar"><?=$plaza->ci_num+1;?></span></td>
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
		</tbody>
	</table>
	<br class="clear">
	</div>


	<div class="wrapListForm" id="wrapListForm2">
	<table>
		<thead>
			<tr>
				<th colspan="4">Contrato</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="grayField"><label>Número de local</label></td>
				<td>
					<input type="text" class="bigInp uppercase blockClear" name="localnum" id="localnum" required>
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
					<input type="text" class="bigInp soloNumeros" name="rentaMensual" id="rentaMensual" required>
				</td>
				<td>&nbsp</td>
				<td>&nbsp</td>
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
	</table>
	<br class="clear">
	</div>


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
			<td><input type="text" class="bigInp soloNumeros" name="devCuenta" maxlength="18" required></td>
			<td class="grayField"><label>CLABE</label></td>
			<td>
				<input class="bigInp soloNumeros" name="devClabe" maxlength="18" required>
			</td>
		</tr>
		<tr>
			<td class="grayField"><label>Banco</label></td>
			<td>
				<input type="text" class="bigInp soloLetras" name="devBanco" required>
			</td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
	</table>
	<br class="clear">
	</div>

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
	<input type="hidden" name="clienteId" id="clienteId" value="" />
	<input type="hidden" name="optionsRadios" id="cartaintencion" value="cartaintencion">
	<input type="submit" id="submit" value="Generar" class="mt10 mainBotton">
	<br class="clear">
	</div>



	</form>

</div>
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
   		$('.personagen').show();
   		if( $(this).val() == "MORAL" ){
   			$('.personafisica').hide();
   			$('.personamoral').show();
   		}
   		else if( $(this).val() == "FISICA" ){
   			$('.personamoral').hide();
   			$('.personafisica').show();
   		}
   		console.log();
   		generarRFC();
   	});

   	$("#cpnombre, #csnombre, #capaterno, #camaterno").keyup(function(){
   		generarRFC();
   	});

   	function generarRFC(){

   		if( $("#clienteFecha").val() && $("#clienteTipo").val() && $("#cpnombre").val() ){
	   		var cNombre = ( $("#clienteTipo").val() == "FISICA" ) ? $.trim( $("#cpnombre").val() + ' ' + $("#csnombre").val() + ' ' + $("#capaterno").val() + ' ' + $("#camaterno").val() + ' ' ) : $("#empresanombre").val();
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


	$("#plazaPiso").change(function(){

		clearClientId();
		mostrarPlazaDir();
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

	// validate signup form on keyup and submit
	$.validator.messages.required = 'campo requerido';
	$("#generateCi").validate({
        rules: {
          devClabe:{
            required: true,
            rangelength:[18,18]
          }
        },
		messages: {
			devClabe: {
				rangelength: "La clabe tiene que ser de 18 digitos"
			}
		},
		submitHandler: function(form) {
			$('#submit').prop( "disabled", true );
			$(".loader").fadeIn("slow");
			//Delay form submit to let the loader show
		    $(form).unbind('submit').delay(2000).submit();
		}
      });

});
</script>
