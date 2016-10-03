
<div id="mainTit">
	<h3>Listado de Inmuebles</h3>
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
	<table class="thbr mt10" id="tablaPlano" >
		<thead>
			<tr>
            	<th ># Inmueble</th>
				<th >Nombre Inmueble</th>
				<th >Codigo Inmueble</th>
				<th>Predios</th>
				<th>Pisos</th>
				<th>Información niveles</th>
			</tr>
		</thead>
		<tbody>
			<? foreach($inmuebles as $row):?>
             
				<tr class="inmueble" >
					<th >
						<img src="<?=base_url()?>assets/graphics/<?= $row->status;?>-alert.png" />	<?= $row->Inmueble;?> -  
                        
					</th>
                    <th>
                    <input type="text" class="addSmall" id="nom<?= $row->Inmueble;?>" value="<?= $row->Nombre;?>" readonly>
                    </th>
					<th><input type="text" class="addSmall" id="clav<?= $row->Inmueble;?>" value="<?= $row->claveCiudad;?>" readonly> </th>
					<? $predios = $this->planogramas_model->cargarPredios($row->Inmueble, 'agrupar');?>
					
                    <th class="pl10">
					<? $pred=0; ?>
					<? foreach($predios as $pre):?> 
					<? $pred= $pre->predios;?>
                    <? endforeach; ?>
                    <input type="text" class="addSmall" id="pred<?= $row->Inmueble;?>" value="<?= $pred?>" readonly> 
					</th>
                    
					<th class="pl10">
                    <? $piso=0;?>
					<? foreach($predios as $pis):?>
                    <? $piso= $pis->pisos;?> 
                    <? endforeach;?>
                    <input type="text" class="addSmall" id="pis<?= $row->Inmueble;?>" value="<?= $piso?>" readonly> 
					</th>
                   
					<th id="asigPi">
						<ul>
						<? $pisos = '';?>
						<? if($pisos =''):?>
						<? foreach($pisos as $p):?>
						<li><a href="<?=base_url()?>planogramas/verplano/<?= $l->id;?>" title="Planta Baja"><?= $l->piso;?></a></li>
						<? endforeach; ?></th>
						<?endif;?>
						</ul>
					</th>
                    <th>
                    	<a href="<?=base_url()?>dashboard/formulario/<?= $row->Inmueble;?>"><img src="<?=base_url()?>assets/graphics/actualizar.png" id="<?= $row->Inmueble;?>"/></a>
                    </th>
				</tr>
				
				<? endforeach; ?>
				
                
		</tbody>
	</table>
	<br class="clear">
	</div>
<br class="clear">
</div>



<style type="text/css" media="screen">
	.inmueble .pl10{padding:6px 10px!important}
</style>
