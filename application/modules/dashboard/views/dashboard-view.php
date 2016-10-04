<? $user         = $this->session->userdata('usuario');?>
 
<? if($user['idrole'] == '10'):?>
 
 
 <div id="popupAct">
			<form id="formPlano" action="<?= base_url();?>planogramas/inmuebles" method="post" enctype="multipart/form-data">
				<h2>Actualiza la información de tu plaza.</h2>
				<p>Con la finalidad de mantener la información de nuestras plazas actualizada se te solicita completar la siguiente información</p>
					<fieldset>
						<input id="subPlan" class="mainBottonCenter" type="submit" class="lightBot fright" value="Enviar" />
					</fieldset>
			</form>
			</div>
 <? endif ?>


<div id="mainTit">Dashboard</div>
<div id="wrapDash">
	<div id="barTop">
	<ul>
		<li class="squareOne">
			<strong>Proveedores en registro</strong>
			<p class="numberDash"><?= number_format($no_proveedores_inscitos[0]->mes_actual);?></p>
			<?php 
				if ($no_proveedores_inscitos[0]->porcentaje > 100){
					$porTexto = "más que la semana pasada";
					$porcentaje = $no_proveedores_inscitos[0]->porcentaje - 100;
				}else{
					$porTexto = "menos que la semana pasada";
					$porcentaje = 100 - $no_proveedores_inscitos[0]->porcentaje;
				}
			?>
			<p class="porcen"><i><?= number_format($porcentaje, 2);?>%</i> <?=$porTexto;?></p>
		</li>
		<li class="squareTwo">
			<strong>Nuevos Proyectos</strong>
			<p class="numberProy"><em><?=$proyectos_activos[0]->total_proyectos;?></em> <i>Proyectos</i></p>
			<p class="numberPart"><b>*</b><em><?=$total_segmentos[0]->total_segmentos;?></em> <i>Particiones</i></p>
			<p class="numberPart"><em><?=$no_cotizaciones[0]->cot_total;?></em> <i>Cotizaciones</i></p>
			<p class="porcen"><i>*</i> segmentos divididos por proyectos</p>
		</li>
		<li>
			<div id="notifi">
			<span><?=$proyectos_activos[0]->total_proyectos;?></span>
			<p>Proyectos en concurso</p>
			</div>
		</li>
		<li>
			<div id="licitados">
			<span><?=$proyectos_revision[0]->total_proyectos;?></span>
			<p>Proyectos en revisión</p>
			</div>
		</li>
	</ul>
	</div>
	<div id="wrapMoreDash">
		<div id="regLast">
		<span class="sty"><img src="<?=base_url()?>assets/graphics/proveedoresBlack.png" alt="Registros" /><strong>Proveedores en Registro</strong></span>
		<ul>
		  <?php foreach($ultimos_prov_inscritos as $prov):
		  		$obrasAsignadas = $this->proyecto_model->cargeObrasProveedor($prov->idProveedor); ?>
		  <li>
		    <strong><?=$prov->razonSocial;?></strong><span><?=$obrasAsignadas;?></span>
		    <p class="dirDash"><span>Direccion: <?=$prov->fisDireccion;?><br>Estado <?=$prov->nombreEstado;?></span></p>
		    <p class="telDash">Tel: <?=$prov->telefono;?> </p>
		    
		  </li>
		  <?php endforeach;?>
		</ul>
		</div>
		<div id="regLast">
		<span class="sty"><img src="<?=base_url()?>assets/graphics/proveedoresBlack.png" alt="Registros" /><strong>Supervisores</strong></span>
		<ul id="lastInfo">
			<?php foreach($supervisores as $supervisor):
		  		$proyectosAutorizados 	= $this->proyecto_model->cargaProyectosPorEstatusSupervisor($supervisor->usuarioID,'Contratando');
				$proyectosEnRevision	= $this->proyecto_model->cargaProyectosPorEstatusSupervisor($supervisor->usuarioID,'En Revision'); ?>
		  <li>
		    <strong><?=$supervisor->nombreCompleto;?></strong>
		    <p>Proyectos autorizados: <span><?=$proyectosAutorizados;?></span></p>
		    <p>proyectos en revisión: <span><?=$proyectosEnRevision;?></span></p>
		  </li>
		  <?php endforeach;?>
		</ul>
		</div>
		<!--ul id="lastInfo">
			<li>
				<em><?=$proyectos_finalizados[0]->total_proyectos;?></em>
				<p>Proyectos Completados</p>
			</li>
			<li>
				<em><?=$proyectos_pagados[0]->total_proyectos;?></em>
				<p>Proyectos Pagados</p>
			</li>
			<li>
				<?php
				$total = 0;
				foreach($total_pagado as $tot){
					$total += $tot->total;
				}
				if($total > 0)
					$total += $total * .16;
				?>
				<i>$ <?=number_format($total,2);?></i>
				<p>Total Pagado</p>
			</li>
		</ul-->
		<div id="inboxDash">
			<div id="infoMen">
			  <span>
				  <img src="<?=base_url()?>assets/graphics/mensajesRecientes.png" alt="Mensajes" />
				  <strong>Mensajes Recientes</strong>
				  <a class="verTMen" href="<?=base_url()?>"><img src="<?=base_url()?>assets/graphics/verTodos.png" alt="Ver todos los mensajes" />Ver todos...</a>
			  </span>
			  <ul>
			  	<li>
			  		<a href="#usuarioMenssajes">Mensajes</a>
			  	</li>
			  	<li>
			  		<a href="#usuarioNotificaciones">Notificaciones</a>
			  	</li>
			  </ul>
			  <div id="usuarioMenssajes">
			  	<? if($mensajes):?>			  		
				  <ul id="usuarioMenssajes">
				  <? foreach($mensajes as $rowM):?>
				  	<li>
						<div class="headMen"><em><?=$rowM->nombreCompleto;?></em> <i> / <?= $rowM->fechaRespuesta;?></i></div>
				  	  	<? if(!empty($rowM->idProyecto)):?>
				  		<a href="<?=base_url()?>proyectos/verProyecto/<?=$rowM->idProyecto?>/1">
					  	<? endif;?>
					  	  	<?= $rowM->respuesta;?>
					  	<? if(!empty($rowM->idProyecto)):?>
						</a>
				  		<? endif; ?>
				  	</li>
				  <? endforeach; ?>
				  </ul>
				<? endif;?>
			  </div>
			  <div id="usuarioNotificaciones">
			  	<?php if(!empty($mensajes_gen)):?>
				<ul id="usuarioNot">
					<?php foreach($mensajes_gen as $mensaje):?>
						<li <?php if($mensaje->leido == 0):?>class="noLeido" <?php endif;?>>
						<div class="headMenTwo"><em>Dia y Hora: <?=$mensaje->date;?></em></div>
						<a class="wrapTextTwo" href="<?=$mensaje->url;?>" class="notificaciones" title="<?=$mensaje->id;?>-<?=$mensaje->tipo;?>">
						<p class="notMen"><?=$mensaje->mensaje;?></p>
						</a>
						</li>
					<?php endforeach;?>
				</ul>
				<?php endif;?>
			  </div>
			</div>
		</div>
	</div>
</div>
 <script>
$(function() {
$( "#infoMen" ).tabs();
});
</script>