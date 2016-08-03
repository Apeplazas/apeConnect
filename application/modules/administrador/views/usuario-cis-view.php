<h3 id="mainTit">Usuarios Carta de Intencion</h3>
<div class="wrapList">

	<div id="actions">
		<a href="<?=base_url()?>administrador/cisUsuario" title="Generar Usuarios" class="addSmall">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Generar usuarios"></i>
			<span>Generar Usuarios</span>
		</a>
		<a id="bAva" title="Busqueda Avanzada" class ="addSmall">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/search.svg" alt="Busqueda avanzada"></i>
			<span>Búsqueda Avanzada</span>
		</a>
	</div>
	<? $this->load->view('includes/toolbars/busquedaAvanzadaUsuarios')?>
	<table id="tablaproveed">
		<thead>
			<tr>
				<th>Nombre Usuario</th>
				<th>Total De Cartas Generadas</th>
				<th>Plaza</th>
				<th>Status</th>
				<!--th></th-->
			</tr>
		</thead>
		<tbody>
			<? foreach($UsuarioCart as $ci):?>
			<tr>

			    <th><p><?= $ci->nombreCompleto?></p></th>
			    <th><p><?= $ci->TotalDeCartas?></p></th>

			  <th><p><?= $ci->plaza?></p></th>
			  <?php if($ci->status == 'Activado'):?>
			  <th>
			  	<a href="<?= base_url();?>administrador/cancelarCartaI/<?=$ci->usuarioID;?>"><?=$ci->status;?></a>
			  </th>
			<?php else:?>
				<th>
					<a href="<?= base_url();?>administrador/ActivadoCartaI/<?=$ci->usuarioID;?>"><?=$ci->status;?></a>
				</th>
			</tr>
			<?php endif;?>
			<?endforeach;?>
		</tbody>
	</table>
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
