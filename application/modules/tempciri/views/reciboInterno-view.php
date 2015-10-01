<div clas="container">
	<div class="row">
		<a href="<?=URLPDF . 'RI_' . $documentoId . '.pdf';?>" title="Agregar Contactos" class="addSmall"><i class="iconPlus">Ver PDF</i>Ver PDF</a>
		<a href="<?=URLPDF . 'ConRI_' . $documentoId . '.pdf';?>" title="Agregar Contactos" class="addSmall"><i class="iconPlus">Ver Condiciones</i>Ver Condiciones</a>
	</div>
</div>
<form>
<? $this->load->view('recibo-interno',$op);?>
</form>