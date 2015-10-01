<h3 id="mainTit">Planogramas APE Plazas</h3>
<div class="wrapList">
<div id="actions">
	<div id="winPlaza" title="Agregar Contactos" class="addSmall"><i class="iconPlus">Agregar</i>
		
		Agregar Planograma
		<div id="addPlaza">
		<form id="formPlano" action="<?= base_url();?>planogramas/subirPlano" method="post" enctype="multipart/form-data">
			<i class="topArrowP"><img src="<?=base_url()?>assets/graphics/topArrow.png" alt="Señalización" /></i>
			
				<fieldset id="cam" class="mt5">
					<div class="containerS_two">
					  <span class="select-wrapper-two">
					    <input type="file" name="archivo" id="image_src_two">
					  </span>
					</div>
					<i id="addFot">Agregar archivo .svg</i>
				</fieldset>
				
				<!-- Tu comentario <fieldset>
					<label>Archivo SVG</label>
					<input type="file" name="archivo" />
				</fieldset>-->
				<fieldset>
					<label>Plaza</label>
					<select name="plaza" id="plaza">
						<option value="" checked>Seleccione la Zona</option>
						<? foreach($plaza as $rowP):?>
						<option value="<?= $rowP->clavePropiedad;?>"><?= $rowP->clavePropiedad;?> - <?= $rowP->propiedad;?></option>
						<? endforeach; ?>
					</select>
				</fieldset>
				<fieldset>
					<label>
						Piso
					</label>
					<select name="piso" id="pisos">
						<option value="">Seleccione una plaza</option>
					</select>
				</fieldset>
				<fieldset>
					<input id="subPlan" type="submit" class="lightBot fright" value="Agregar" />
				</fieldset>
		</form>
		</div>
	</div>	
</div>

<table id="tablaPlano" >
	<thead>
		<tr>
			<th class="space"></th>
			<th></th>
			<th >Ciudad</th>
			<th>Rentados</th>
			<th>Disponibles</th>
			<th>Mantenimiento</th>
			<th>Apartados</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($planos as $row):?>
		
			<tr class="plaza">
				<th class="space"></th>
				<th><a class="iconVermas" href="#" onclick="$('#<?= $row->id;?>').toggle(); return false;">Ver planogramas</a></th>
				<th><a class="f100" href="#" onclick="$('#<?= $row->id;?>').toggle(); return false;"><?= $row->plaza;?></a></th>
				<th><a class="f100" href="#" onclick="$('#<?= $row->id;?>').toggle(); return false;">8</a></th>
				<th><a class="f100" href="#" onclick="$('#<?= $row->id;?>').toggle(); return false;">9</a></th>
				<th><a class="f100" href="#" onclick="$('#<?= $row->id;?>').toggle(); return false;">2</a></th>
				<th><a class="f100" href="#" onclick="$('#<?= $row->id;?>').toggle(); return false;">10</a></th>
			</tr>
			<tr class="none childTab" id="<?= $row->id;?>">
				<th colspan="7">
					<ul>
					<? $list = $this->planogramas_model->cargarPisos($row->plaza);?>
					<? foreach($list as $l):?>
					  <li><a href="<?=base_url()?>planogramas/verplano/<?= $l->id;?>" title="Planta Baja"> &#8226; Piso <?= $l->piso;?></a></li>
					  <? endforeach; ?>
					</ul>
				</th>
			</tr>
			<? endforeach; ?>
	</tbody>
</table>
</div>


<script>
$(document).ready(function() {
    /*('#tablaPlano').dataTable( {
    	 columnDefs: {
            targets: [ 2 ],
            orderData: [ 4, 2 ]
        }
    });
    */
    
});
</script>