<div id="mainTit">
	<h3>Oracle</h3>
</div>

<div class="wrapList">
	<div id="actions">
	</div>

	<div class="wrapListForm" id="wrapListForm1">
	
	<br class="clear">
		<a href="<?= base_url();?>oracle">Home</a>
		<form action="<?= base_url();?>oracle/procesar_archivo_layout_clientes" method="post" enctype="multipart/form-data">
			<input type="file" name="archivo" />
			<input type="submit" value="Enviar" />
		</form>
	</div>

</div>
