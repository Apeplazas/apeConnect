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
			<h2>Numero de predios <?= sizeof($predios);?></h2>
			<hr>
			<?$inmueble_id = intval($this->uri->segment(3));?>
			<?php foreach($predios as $row):?>
				<div>
					<?php
					$pisos				= $this->planogramas_model->cargarPisosPredioPlaza($row->PREDIO_ID,$inmueble_id);
					$verifica_pisos		= $this->planogramas_model->cargarPisosPlaza($row->PREDIO_ID);
				 	
				 	echo $row->CALLE ." " . $row->NUMERO_EXTERIOR . " " . $row->NUMERO_INTERIOR;?> - Pisos <?=sizeof($pisos);
					
				 	if( sizeof($pisos) != sizeof($verifica_pisos) ):?>
							<p>Hay problemas con la asignacion de pisos con lo predios</p>
					<?php endif;?>
					</br>
					<? foreach($pisos as $piso):
				 		echo " Piso " . $piso->NIVEL_PISO;
						$locales			= $this->planogramas_model->cargarLocalesPisoPredio($piso->PISO_ID,$row->PREDIO_ID);
						$verificar_locales	= $this->planogramas_model->cargarLocalesPiso($piso->PISO_ID);
						echo " Locales - " . sizeof($locales);
					 	if( sizeof($locales) != sizeof($verificar_locales) ):?>
							<p>Hay problemas con la asignacion de locales con lo predios</p>
						<?php endif;?>
						</br>
					<?endforeach;?>
				</div>
				<hr>
			<? endforeach; ?>
				

	</div>
	<br class="clear">
	</div>
<br class="clear">
</div>