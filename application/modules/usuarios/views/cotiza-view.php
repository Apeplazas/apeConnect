<?php foreach($proyecto as $proy): ?>
	<form action="<?=base_url();?>usuarios/cotizar" method="post" id="enviarcotizacion" enctype="multipart/form-data">
		<div id="mainTit"><img src="<?=base_url()?>assets/graphics/proyectos-blackIcon.png" alt="Cotiza los siguientes conceptos.">Cotiza los siguientes conceptos.</div>
		<?= $this->session->flashdata('msg'); ?>
		<?php if(!empty($partidas)):?>
		<table id="segmentos" class="dataTable">
			<thead>
			  <tr>
			    <th><span>Descripción</span></th>
			    <th><span>Unidad</span></th>
			    <th><span>Cantidad</span></th>
			    <th><span>Precio Unitario</span></th>
			    <th><span>Total</span></th>
			  </tr>
			</thead>
			<tbody id="cotFont">
			<? foreach($partidas as $rowPp):?>
				<tr class="header-table">
				  <td colspan="5"><p><?= $rowPp->nombre;?></p></td>
				</tr>
				<?$segmento = $this->proyecto_model->traeproyecto_secciones($proy->idProyecto,$rowPp->id);?>
				<? if($segmento):?>
					<? foreach($segmento as $rowS): ?>
					
						
						<tr>
						    <td><p><?=$rowS->seccionDesc;?></p></td>
						    <td><em><?=$rowS->unidad;?></em></td>
						    <td><strong><?=$rowS->cantidad;?> <?=$rowS->simbolo;?></strong></td>
						    <td class="eee">
						      <fieldset class="form">
						        <label class="texDec">Escribe el costo de precio por unidad que tienes</label>
						        <input onkeyup="this.value=this.value.replace(/[^\d∂,.]/,'')" class="medFormAjTwo punitario" type="text" name="punitario[<?=$rowS->idSegmento;?>]" value="<?php if(isset($filldata['punitario'][$rowS->idSegmento])) echo $filldata['punitario'][$rowS->idSegmento];?>" />
						      </fieldset>
						      <?php if(isset($error[$rowS->idSegmento])):?>
						        <p>Debe ingresar el precio unitario</p>
						      <?php endif;?>
						    </td>
						    <td class="eee">
						      <fieldset class="formTot">
						        <input placeholder="$ 0,00" disabled class="totAja totalrango" type="text" id="tota-<?=$rowS->idSegmento;?>" name="tota[<?=$rowS->idSegmento;?>]"/>
						      </fieldset>
						    </td>
						</tr>
						<!--tr>
						  <td colspan="5" class="eee">
						    <fieldset class="bb4">
						      <label class="texDec">Si tienes algún observación en tu cotización no dudes en compartirla con nosotros para que sea considerada al momento de elegir.</label>
						      <textarea class="textCot" placeholder="Observaciones" name="observaciones[<?=$seccion->idSegmento;?>]"><?php if(isset($filldata['observaciones'][$seccion->idSegmento])) echo $filldata['observaciones'][$seccion->idSegmento];?></textarea>
						    </fieldset>
						  </td>
						</tr-->
					<? endforeach; ?>
				<? endif;?>
			<? endforeach; ?>
		  </tbody>
		</table>
		<?php endif;?>
		<input type="hidden" name="idproyecto" value="<?=$idproyecto;?>" />
		<div>
			<label>Matriz, desglose de cotización</label>
			<input type="file" name="matrizCot" />
		</div>
		
		<div class="totAco">
		  <span>
		  <p><strong>SubTotal: </strong> <em id="totAj">$ 0.00</em></p>
		  <p><strong>IVA:</strong> <em id="IVA">16%</em></p>
		  <p><strong>Total:</strong> <em id="IVAAj">$ 0.00</em></p>
		  </span>
		 
		  <input id="addCot" type="submit" name="submit" value="Enviar Cotización" />
		</div>
	</form>
<?php endforeach;?>