<h3 id="mainTit">Prospectos Usuarios</h3>
<div class="wrapList">

	<div id="actions">
		<a href="<?=base_url()?>administrador/prospectosUsuarios" title="Generar Usuarios" class="addSmall">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Generar usuarios"></i>
			<span>Generar Usuarios</span>
		</a>
		<a id="bAva" title="Busqueda Avanzada" class ="addSmall">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/search.svg" alt="Busqueda avanzada"></i>
			<span>Búsqueda Avanzada</span>
		</a>
	</div>
	<? $this->load->view('includes/toolbars/busquedaAvanzadaUsuariosPros')?>
  <div id="tablaproveed_wrapper">
	<table id="tablaproveed">
		<thead>
			<tr>
				<th>Nombre Usuario</th>
				<th>Status</th>
				<!--th></th-->
			</tr>
		</thead>
		<tbody>
			<? foreach($UsuarioPost as $ci):?>
			<tr>

			    <th><p><?= $ci->nombreCompleto?></p></th>
 				<?php if($ci->status == 'Activado'):?>
			  	<th>
			  		<a href="<?= base_url();?>administrador/cancelarpros/<?=$ci->usuarioID;?>" ><?= $ci->status;?></a>
			  	</th>
			  <?php else:?>
			  	<th>
			  		<a href="<?= base_url();?>administrador/activadopros/<?=$ci->usuarioID;?>"><?= $ci->status;?></a>
			  	</th>
			  <?php endif;?>
			 <? endforeach; ?>
			</tr>
		</tbody>
	</table>
	</div>
	<fieldset>
	   <input type="hidden" name="cartaIntId" id="cartaIntId" value="" />		
  </fieldset>

</div>

<script type="text/javascript">
$("#bAva").click(function() {
	$("#busAvan").toggle();
	$(this).toggleClass("addSmall").toggleClass("addSmallClick");
});
</script>
