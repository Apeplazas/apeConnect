<div id="mainTit">
	<h3>Oracle</h3>
</div>

<div class="wrapList">
	<div id="actions">
	</div>

	<div class="wrapListForm" id="wrapListForm1">
	
	<br class="clear">
		<a href="<?= base_url();?>oracle/iniciar_proceso">Iniciar Proceso</a><br>
		<?php 
		$plazas = $this->oracle_model->traer_plazas_a_procesar(); 
		if(!empty($plazas)):?>
		<a href="<?= base_url();?>oracle/exportar_obras">Obtener Excel - Obras</a><br>
		<a href="<?= base_url();?>oracle/subir_archivo_obras">Subir Archivo - Obras</a><br>
		<a href="<?= base_url();?>oracle/procesar_pasos_29">Procesar paso hasta el 29</a><br>
		<a href="<?= base_url();?>oracle/exportar_clientes">Obtener Excel - Clientes</a><br>
		<a href="<?= base_url();?>oracle/subir_archivo_clientes">Subir archivo - Clientes</a><br>
		<?php endif;?>
		<a href="<?= base_url();?>oracle/subir_archivo_layout_clientes">Subir archivo - Layout Clientes -----------------------</a><br>
	</div>

</div>
