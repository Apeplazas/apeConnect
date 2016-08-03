<div id="mainTit">
	<h3>Oracle</h3>
</div>

<div class="wrapList">
	<div id="actions">
	</div>

	<div class="wrapListForm" id="wrapListForm1">
	
	<br class="clear">
		<a href="<?= base_url();?>oracle">Home</a>
		<form action="<?= base_url();?>oracle/insertar_pazas" method="post">
			Plazas:<br/>
			<?php foreach($plazas as $plaza):?>
				<input type="checkbox" value="<?php echo $plaza->Sucursal;?>" name="plaza[]" /><?php echo $plaza->Nombre;?><br/>
			<?php endforeach;?>
			<input type="submit" value="Enviar" />
		</form>
	</div>

</div>
