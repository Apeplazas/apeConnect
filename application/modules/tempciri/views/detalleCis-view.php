<h3 id="mainTit">Cartas de intención</h3>
<div class="wrapList">

	<div id="actions">
		<a href="<?=base_url()?>tempciri/ciRi" title="Generar carta intencion" class="addSmall">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Generar carta intencion"></i>
			<span>Generar Carta</span>
		</a>
		<a id="bAva" title="Busqueda Avanzada" class ="addSmall">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/search.svg" alt="Busqueda avanzada"></i>
			<span>Búsqueda Avanzada</span>
		</a>
		<a id="exportarExcel" title="Exportar Excel" class ="addSmall" href="<?= base_url();?>tempciri/exportarExcel">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/excelIcon.svg" alt="Exportar excel"></i>
			<span>Exportar excel</span>
		</a>
	</div>

	<? $this->load->view('includes/toolbars/busquedaAvanzadaCartasIntencion')?>

	<table id="tablaproveed">
		<thead>
			<tr>
				<th>Folio</th>
				<th>Cliente</th>
				<th>Plaza</th>
				<th>Usuario</th>
				<th>Deposito</th>
				<th>Estatus</th>
				<!--th></th-->
			</tr>
		</thead>
		<tbody>
			<? foreach($cis as $ci):?>
			<tr>
			  <th><p><?= $ci->folio?></p></th>
				<th><p class="limitTab"><?= $ci->pnombre;?> <?= $ci->snombre;?> <?= $ci->apellidopaterno;?> <?= $ci->apellidomaterno;?></p></th>
			  <th><p><?= $ci->plazaNombre?></p></th>
			  <th><p><?= $ci->nombreCompleto?></p></th>
			  <th>$ <?= number_format("$ci->deposito",2);?></th>
			  	<th>
			  		<a class="mt10" href="<?=base_url()?>tempciri/detalleCi/<?= $ci->cartaIntId;?>" >
			  			<span class="alertTab" ><?= $ci->estado;?></span>
			  		</a>
			  	</th>
				<!--th>
					<a class="svgPdf" href="<?=URLPDF . 'CI_' . $ci->id . '.pdf';?>" >
					<img src="<?=base_url()?>assets/graphics/svg/pdf.svg" alt="Ver documento">
					<span><?= $ci->pdf?></span>
				</a>
				</th-->
			  <? endforeach; ?>
			</tr>
		</tbody>
	</table>

<div id="popup" class="modal-box">
  <div>
    <a href="#" class="js-modal-close cerrar"><img src="<?=base_url()?>assets/graphics/svg/close.svg" alt="Cerrar"></a>
    <h3>Ingreso de documento firmado</h3>
		<p>Como requisito para terminar el proceso necesitara adjuntar el documento scaneado y firmado.</p>
  </div>
  <form id="scanFileDoc" method="post" class="modal-body" enctype="multipart/form-data" action="#" method="post">
		<fieldset>
			<span id="hideTy"><input type="file" name="firma" accept=".pdf,image/*"  required /></span>
		</fieldset>
		<fieldset>
			<input type="hidden" name="cartaIntId" id="cartaIntId" value="" />
			<input type="image" src="<?=base_url()?>assets/graphics/finalizarFirma.png" id="enviarFirma" />
		</fieldset>
	</form>
</div>

<script type="text/javascript">
$("#bAva").click(function() {
	$("#busAvan").toggle();
	$(this).toggleClass("addSmall").toggleClass("addSmallClick");
});

$(document).ready(function() {
	/// Llama al plugin de datatables
	$('#tablaproveed').dataTable( {
		"iDisplayLength": 20
	});
  /// Genera el even de cada lista
  $('.wrapListForm fieldset:even').addClass('evenBorder');

	var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

	$('a[data-modal-id]').click(function(e) {
		e.preventDefault();
		var cartaId = $(this).attr('title');
		$('#cartaIntId').val(cartaId);
		$("body").append(appendthis);
		$(".modal-overlay").fadeTo(500, 0.7);
		//$(".js-modalbox").fadeIn(500);
		var modalBox = $(this).attr('data-modal-id');
		$('#'+modalBox).fadeIn($(this).data());
	});


	$(".js-modal-close, .modal-overlay").click(function() {
	$(".modal-box, .modal-overlay").fadeOut(500, function() {
		$(".modal-overlay").remove();
	});
	});

	$(window).resize(function() {
	$(".modal-box").css({
		top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
		left: ($(window).width() - $(".modal-box").outerWidth()) / 2
	});
	});
	$(window).resize();

	// prepare Options Object
	var options = {
	    url:        ajax_url+'saveSingFile',
	    dataType:	'json',
	    success:    function(data) {
	        if(!data.success){
	        	alert("Favor de ingresar archivos válidos.");
	        }else{
	        	window.onbeforeunload = null;
	        	window.location.href = "<?= base_url();?>tempciri/verCi";
	        }
	    }
	};

	// pass options to ajaxForm
	$('#scanFileDoc').ajaxForm(options);

});
</script>
</div>
<script>
	$(document).ready(function(){
		
	})
</script>