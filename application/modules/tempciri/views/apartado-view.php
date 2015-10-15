<div id="actionsPdf">
	<a onclick="printPDF('iFramePdf')" href="#" title="Imprimir PDF" class="addSmall mt10">
			<i class="iconPlus">
				<img src="<?=base_url()?>assets/graphics/svg/print.svg" alt="Imprimir PDF">
			</i>
			<span>Imprimir PDF</span>
	</a>
	<a class="addSmall mt10" href="<?=base_url()?>tempciri/verCi">
		<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/back.svg" alt="Regresar"></i>
		<span>Regresar a listado</span>
	</a>
	<a class="addSmall mt10 js-open-modal" href="#" data-modal-id="popup" href="#modal">
		<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/firma.svg" alt="Regresar"></i>
		<span>Agregar Firma</span>
	</a>
</div>

<form>
<? $this->load->view('carta-intencion',$op);?>
</form>



<div id="popup" class="modal-box">
  <div>
    <a href="#" class="js-modal-close cerrar"><img src="<?=base_url()?>assets/graphics/svg/close.svg" alt="Cerrar"></a>
    <h3>Ingreso de documentos firmado</h3>
		<p>Como requisito para terminar el proceso necesitara adjuntar los documentos firmados y scaneados.</p>
  </div>
  <form method="post" class="modal-body" enctype="multipart/form-data">
		<fieldset>
			<span id="hideTy"><input type="file" name="firma"></span>
		</fieldset>
		<fieldset>
			<input type="image" src="<?=base_url()?>assets/graphics/finalizarFirma.png" id="enviarFirma">
		</fieldset>
  </div>
</div>

<iframe id="iFramePdf" src="<?=URLPDF . 'CI_' . $documentoId . '.pdf';?>" style="display:none;"></iframe>

<script type="text/javascript">
function printPDF(print){
	var getMyFrame = document.getElementById(print);
		getMyFrame.focus();
		getMyFrame.contentWindow.print();
}
</script>

<script type="text/javascript">
$(function(){
	var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

	$('a[data-modal-id]').click(function(e) {
		e.preventDefault();
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
});
</script>
