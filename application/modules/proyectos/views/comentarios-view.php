<? foreach($proyecto as $rowP):?>
<div class="separation">
<ul id="toolbar">
	<li><a href="<?=base_url()?>proyectos/verProyecto/<?= $rowP->idProyecto;?>">Regresar</a></li>
</ul>
</div>
<strong id="headProy" class="headTit<?= $rowP->idProyecto;?>">Segmentos de <?= $rowP->tituloProyecto;?> </strong>
<div id="proy">
<p class="even"><b>Fecha Apertura</b> <i><?= $rowP->fechaAltaProyecto;?> - <?= $rowP->horaAlta;?></i></p>
<p class="row"><b>Fecha Cierre Licitación</b> <i><?= $rowP->fechaCierreProyecto;?></i></p>
<p class="even"><b>Tipo de Proyecto</b><i><?= $rowP->tipo;?></i></p>
<p class="row"><b>Status</b><i><?= $rowP->statusProyecto;?></i></p>
</div>
<div id="wrapTable">
	<div id="descSegProy">
	<h1>Descripción de proyecto</h1>
	<p id="pro<?= $rowP->idProyecto;?>" class="desc" ><?= $rowP->descripcionProyecto;?></p>
	</div>
<? if($comentarios):?>

<ol>
<?php foreach($comentarios as $comentario): ?>
	<li>
		<dd>
			<span><?=$comentario->seccionDesc;?></span>
		</dd>
		<dd>
			<span><?=$comentario->observacion;?></span>
		</dd>
		<dd>
			<?php if($comentario->respuesta == 0):?>
				<form method="post" action="<?=base_url()?>proyectos/responder">
					<textarea name="respuesta" placeholder="Respuesta"></textarea>
					<input type="submit" value="Responder" />
					<input type="hidden" name="obserid" value="<?=$comentario->id;?>" />
					<input type="hidden" name="proyectoid" value="<?=$this->uri->segment(3);?>" />
				</form>
			<?php else:
				$repuesta = $this->proyecto_model->traerespuesta($comentario->respuesta);?>
				<span><?=$repuesta[0];?></span>
			<?php endif;?>
		</dd>
	</li>
	<hr/>
<? endforeach; ?>
</ol>
<br class="clear">
<form action="<?=base_url()?>proyectos/agregarSeccion" method="post" id="agregarSeccion">
	<fieldset id="segmento">
		
	</fieldset>
	<fieldset>
	<input type="hidden" name="proyecto" value="<?= $this->uri->segment(3);?>"/>
	</fieldset>
</form>
<? else:?>
<p class="alerta"><img src="<?=base_url()?>assets/graphics/alerta.png" alt="Alerta" /><strong>Este segmento no tiene ningún segmento registrado.</strong></p>
<? endif;?>
<? endforeach; ?>
</div>