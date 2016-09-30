<html>
<head>
<link href="<?=base_url()?>assets/css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
<script src="<?=base_url()?>assets/js/jquery.multi-select.js" type="text/javascript"></script>
</head>
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
					<th onClick="$('.<?= $row->Inmueble;?>').toggle(); return false;" title="Preciona para agregar encargados">
						<img src="<?=base_url()?>assets/graphics/<?= $row->status;?>-alert.png" />	<?= $row->Inmueble;?> -  
                        
					</th>
                    <th>
                    <input type="text" class="addSmall" id="nom<?= $row->Inmueble;?>" value="<?= $row->Nombre;?>" />
                    </th>
					<th><input type="text" class="addSmall" id="clav<?= $row->Inmueble;?>" value="<?= $row->claveCiudad;?>"> </th>
					<? $predios = $this->planogramas_model->cargarPredios($row->Inmueble, 'agrupar');?>
					
                    <th class="pl10">
					<? $pred=0; ?>
					<? foreach($predios as $pre):?> 
					<? $pred= $pre->predios;?>
                    <? endforeach; ?>
                    <input type="text" class="addSmall" id="pred<?= $row->Inmueble;?>" value="<?= $pred?>"> 
					</th>
                    
					<th class="pl10">
                    <? $piso=0;?>
					<? foreach($predios as $pis):?>
                    <? $piso= $pis->pisos;?> 
                    <? endforeach;?>
                    <input type="text" class="addSmall" id="pis<?= $row->Inmueble;?>" value="<?= $piso?>"> 
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
                    	<img src="<?=base_url()?>assets/graphics/actualizar.png" id="<?= $row->Inmueble;?>"/>
                    </th>
				</tr>
				
				<tr class="none <?= $row->Inmueble;?>">
                
                
					<th colspan="6" align="center">
                    <? $encargados = $this->planogramas_model->cargarEncargados($row->Inmueble);?>
                    
                    
                    
                    
                        <select class='pre-selected-options<?= $row->Inmueble;?>' multiple='multiple'>
                        <option disabled>Seleccione una opción</option>
                        <? foreach($usu as $i):?>
                        
                        <? foreach($encargados as $j):?>
                        <?= $seleccionados= $j->usuarioID?>
                        <?= $selec= $j->Inmueble?>
                    	<? endforeach; ?>
                    
                        <? if(($seleccionados == $i->usuarioID) & ($row->Inmueble == $selec)){ ?>
                        
                        <option value="<?= $i->usuarioID;?>" selected><?= $i->nombreCompleto ?></option>
                        
                        <? }else{?>
                        <option value="<?= $i->usuarioID;?>"><?= $i->nombreCompleto ?></option>
                        <? }?>
                        
                        <? endforeach; ?>
                        </select>
                        
                        <script>
						$('.pre-selected-options<?= $row->Inmueble;?>').multiSelect();
						</script>
                        </th>
				</tr>
				<script>
                
					$("#<?= $row->Inmueble;?>").click(function(){
						var id	= <?= $row->Inmueble;?>;
						var foo = [];
						var nombre	= $('#nom<?= $row->Inmueble;?>').val();
						var clave	= $('#clav<?= $row->Inmueble;?>').val();
						var predio	= $('#pred<?= $row->Inmueble;?>').val();
						var piso	= $('#pis<?= $row->Inmueble;?>').val();
						
						
						
						$('.pre-selected-options<?= $row->Inmueble;?> :selected').each(function(i, sel){ 
							foo[i] =$(sel).val();
						});
						$.post('<?=base_url()?>ajax/asignarInmueblePisosYEncargados', {
										id : id,
										usuarioID : foo,
										nombre : nombre,
										clave : clave,
										predio : predio,
										piso : piso
						},'json');
						alert('Datos actializados correctamente');
					});
				
				</script>
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
</html>