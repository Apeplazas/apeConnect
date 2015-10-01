<div clas="container">
	<div class="row">
		<a href="<?=URLPDF . 'CI_' . $documentoId . '.pdf';?>" title="Agregar Contactos" class="addSmall"><i class="iconPlus">Ver PDF</i>Ver PDF</a>
	</div>
</div>
<form>
<? $this->load->view('carta-intencion',$op);?>
</form>