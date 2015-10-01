<? foreach($proyecto as $rowP):?>
	<div id="mainTit"><img src="<?=base_url()?>assets/graphics/proyectos-blackIcon.png" alt="Proyectos y Obras"><?= $rowP->tituloProyecto;?> </div>
	<div id="proy" class="topDiv">
		<p><b>Fecha Apertura: </b> <i><?= $rowP->fechaAltaProyecto;?> <?= $rowP->horaAlta;?></i></p>
		<p class="row"><b>Fecha Cierre Licitación: </b> <i><?= $rowP->fechaCierreProyecto;?></i></p>
		<p><b>Tipo de Proyecto: </b><i><?= $rowP->tipo;?></i></p>
		<p class="row"><b>Status: </b><i><?= $rowP->statusProyecto;?></i></p>
		<a href="<?=base_url();?>usuarios/c/<?=$idproyecto;?>" class="fleft greenBoton"><em><img src="<?=base_url()?>assets/graphics/plus.png" alt="Solicitud de Autorizacion"></em> Cotizar Proyecto</a>
	</div>
	<div id="descSegProy">
		<h1 id="headProy" class="headTit53 topDiv">Descripción de proyecto</h1>
		<p class="desc"><?= $rowP->descripcionProyecto;?></p>
		<? if($archivos):?>
		<h1 id="headProy" class="headTit53 topDiv">Imagenes descriptivas del proyecto</h1>
		<ul id="imagArch">
			<? foreach($archivos as $arch):?>
			<li>
				<? if($arch->archivoTipo == 'gif' || $arch->archivoTipo == 'png' || $arch->archivoTipo == 'jpg'):?>
				<img src="<?=URLPROYECTOS.$arch->nombreArchivo;?>" />
				<? else:?>
				<a href="<?=URLPROYECTOS.$arch->nombreArchivo;?>"><?=$arch->nombreArchivo;?></a>
				<? endif;?>
			</li>
			<? endforeach;?>
		</ul>
		<? endif;?>
	</div>
	<? if($partidas):?>
		<script>
		$(document).ready(function(){
			$("#segmentos tr:even").addClass("even");
			$("#segmentos tr:odd").addClass("odd");
		});
		</script>
		<h4 id="tabHead">Segmentos del proyecto u obra.</h4>
		<table id="segmentos" class="dataTable">
			<thead>
				<tr>
				  <th><span>Concepto</span></th>
				  <th><span>Unidad</span></th> 
				  <th><span>Cantidad</span></th>
				  <!--th></th-->
				</tr>
			</thead>
			<? foreach($partidas as $rowPp):?>
				<tr>
				  <td colspan="3"><p class="boldProy"><?= $rowPp->nombre;?></p></td>
				</tr>
				<?$segmento = $this->proyecto_model->buscaSegmento($rowP->idProyecto,$rowPp->id);?>
				<? if($segmento):?>
					<? foreach($segmento as $rowS):?>
						<tr>
							<td><p id="segmento<?= $rowS->idSegmento;?>"><?= $rowS->descripcion;?></p></td>
						  	<td><strong id="status<?= $rowS->idSegmento;?>"><?= $rowS->nombreUnidad;?></strong></td>
						  	<td><em><?= $rowS->cantidad;?> <?= $rowS->simboloUnidad;?></em></td>
						</tr>
					<? endforeach; ?>
				<? endif;?>
			<? endforeach; ?>
		</table>
		
		
		<div id="comentaUsuarios">
		<? $tieneComentarios = false;
		if($cometarios):
			$tieneComentarios = $cometarios[0]->cID;?>
			<h1 class="headTitSma headProy commentUsuarios">Comentarios</h1>
			<ul id="commProy">
				<? foreach($cometarios as $com):
				$class = ($com->idrole == 2) ? 'repIzq' : 'repDer';?>
				<li>
				  <p class="<?=$class;?>"><em><?= $com->nombreCompleto;?> ESCRIBIO | <?= $com->fechaRespuesta;?></em><?=$com->respuesta;?></p>
				</li>
				<? endforeach;?>
			</ul>
		<? endif;?>
		
		<a class="blackBo fright verProyAut" onclick="$('#showFor').toggle(); return false;" href="#"/>Comentar</a>
		<form id="showFor" method="post" style="display:none;" action="<?=base_url()?>usuarios/cometarProyecto" >
			<input type="hidden" value="<?=$this->uri->segment(3);?>" name="proyectoId" />
			<input type="hidden" value="<?=$tieneComentarios;?>" name="tieneComentarios" />
			<p id="razon">
				<span><a class="closeText" href="#"><img src="<?=base_url()?>assets/graphics/closeGray.png" alt="Cerrar Formulario"></a></span>
				<textarea name="comentario" placeholder="Ingrese un comentario"></textarea>
				<input id="blackEnd" class="cpointer" type="submit" value="Finalizar" />
			</p>
		</form>
		</div>
		
	<? else:?>
		<p class="alerta"><img src="<?=base_url()?>assets/graphics/alerta.png" alt="Alerta" /><strong>Este segmento no tiene ningun segmento registrado.</strong></p>
	<? endif;?>
<? endforeach; ?>