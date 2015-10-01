<?php
//Acciones de usuario
$borrar =  $this->user_model->puedeEjecAcc($userID,1,1);
$verComentarios = $this->user_model->puedeEjecAcc($userID,1,2,1);
?>
<div id="toolbar">
<ul>
	<li>
		<a class="botones" title="Actualizar" href="<?=base_url()?><?= uri_string()?>"><img src="<?=base_url()?>assets/graphics/actualizar.png" alt="Actualizar" /><em class="actPro">Actualizar</em></a>
	</li>	
	<?php if(!empty($borrar)):?>
		<li>
			<a href="<?=base_url()?>proyectos/borrarStatusProy/<?=$this->uri->segment(3);?>" title="Borrar"  id="proyectosBorrar"><img src="<?=base_url()?>assets/graphics/borrar.png" alt="Borrar" /></a>
		</li>
	<?php endif;?>
	<li id="excelClick">
		<a class="botones" href="<?=base_url()?>proyectos/exportarExcel" title="Importar y Exportar Excel"><img src="<?=base_url()?>assets/graphics/excel.png" alt="Importar y Exportar Excel" /> <em class="excelExp">Exportar excel</em></a>
	</li>
</ul>
	<?php if(!empty($verComentarios) && $this->uri->segment(2) == 'verProyecto'):?>
		<div onclick="javascript:showDiv();">
	        <div class="fright cpointer"><img src="<?=base_url()?>assets/graphics/comentarios.png" alt="Ver Comentarios" /></div>
	    </div>
	<?php endif;?>
</div>
