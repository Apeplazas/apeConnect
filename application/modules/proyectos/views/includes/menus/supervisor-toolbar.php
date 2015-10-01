<div id="toolbar">
<ul>
	<li>
		<a title="Actualizar" href="<?=base_url()?><?= uri_string()?>"><img src="<?=base_url()?>assets/graphics/actualizar.png" alt="Actualizar" /></a>
	</li>
	<li>
		<a href="<?=base_url()?>" title="Borrar"><img src="<?=base_url()?>assets/graphics/borrar.png" alt="Borrar" /></a>
	</li>
	<li>
		<a id="fancy" class="fancy" href="#addDisplay" title="Agregar Proyecto"><img src="<?=base_url()?>assets/graphics/agregarProyecto.png" alt="Agregar Proyecto" /></a>
	</li>
	<li>
		<a href="<?=base_url()?>" title="mas"><img src="<?=base_url()?>assets/graphics/mas.png" alt="mas" /></a>
	</li>
</ul>
	<? if($this->uri->segment(2) != 'obras'):?>
	<div onclick="javascript:showDiv();">
        <div class="fright cpointer"><img src="<?=base_url()?>assets/graphics/comentarios.png" alt="Ver Comentarios" /></div>
    </div>
    <? endif;?>
</div>
