<div id="mainTit">
	<h3>Listado de Locales</h3>
</div>

<div class="wrapList">
	<div id="actions">
		<span class="back">
		 <a class="addSmall" href="javascript:window.history.go(-1);">
			 <i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/back.svg" alt="Regresar"></i>
			 <span>Regresar</span>
		 </a>
		</span>
	</div>
	
	
	
	<div class="wrapListForm" id="wrapListForm1">
	<div class="thbr mt10" id="tablaPlano" >
			<form action="" method="post" id="mostrar_plaza">
				<select name="plaza_id" id="plaza_id">
					<option value="">Seleccione una plaza</option>
					<?php foreach($inmuebles as $inmueble):?>
						<option value="<?=$inmueble->Inmueble?>" <?php if($inmueble_id == $inmueble->Inmueble) echo "selected";?>><?=$inmueble->Nombre?></option>
					<?php endforeach;?>
				</select>
			</form>
			<h2>Numero de predios <?= sizeof($predios);?></h2>
			<hr>
			<table class="bAllBlack">
			<?php foreach($predios as $row):
					$pisos						= $this->planogramas_model->cargarPisosPredioPlaza($row->PREDIO_ID,$inmueble_id);
					$verifica_pisos				= $this->planogramas_model->cargarPisosPlaza($row->PREDIO_ID);
					$total_area_contruida		= 0;
					$gran_total_area_rentable	= 0;
					?>
				<tr class="bcTitEx">
				 	<td>
				 		<strong><?php echo $row->CALLE ." " . $row->NUMERO_EXTERIOR . " " . $row->NUMERO_INTERIOR;?> - Pisos <?=sizeof($pisos);?></strong>
					</td>
					<td><strong>Superficie del terreno</strong></td>
					<td><strong>Piso</strong></td>
					<td><strong>Area construida</strong></td>
					<td><strong>Area rentable</strong></td>
				</tr>
				 	<?php if( sizeof($pisos) != sizeof($verifica_pisos) ):?>
							<p>Hay problemas con la asignacion de pisos con lo predios</p>
					<?php endif;?>
					<? foreach($pisos as $piso): 
						$total_piso_area_rentable = 0;
						$locales			= $this->planogramas_model->cargarLocalesPisoPredio($piso->PISO_ID,$row->PREDIO_ID);
							$verificar_locales	= $this->planogramas_model->cargarLocalesPiso($piso->PISO_ID);
						 	if( sizeof($locales) != sizeof($verificar_locales) ):?>
								<p>Hay problemas con la asignacion de locales con lo predios</p>
							<?php endif;?>
						<tr class="bckGrayEx">
							<td></td>
							<td></td>
							<td>
				 				<p><?php echo $piso->NIVEL_PISO;?> <?php echo " Locales - " . sizeof($locales);?> ------ <?=$piso->PISO_ID;?></p>
				 			</td>
				 			<td>
				 				<p><?php
				 				$total_area_contruida += $piso->AREA_CONSTRUIDA;  
				 				echo $piso->AREA_CONSTRUIDA;?></p>
				 			</td>
					 		<?php 
							
							foreach($locales as $local){
								$total_piso_area_rentable += $local->AREA_RENTABLE;
							}
							$gran_total_area_rentable += $total_piso_area_rentable;?>
							<td>
								<p><?php echo $total_piso_area_rentable;?></p>
							</td>
						</tr>
					<?endforeach;?>
					<tr class="finalExt">
					<td></td>
					<td>
				 		<p><?php echo $row->SUPERFICIE_TERRENO;?></p>
					</td>
					<td></td>
					<td>
						<p><?php echo $total_area_contruida;?></p>
					</td>
					<td><p><?php echo $gran_total_area_rentable;?></p></td>
					</tr>
			<? endforeach; ?>
			</table>	

	</div>
	<br class="clear">
	</div>
<br class="clear">
</div>

<script>
	$(document).ready(function(){
		$('#plaza_id').change(function(){
			$('#mostrar_plaza').submit();
		});
	});
</script>