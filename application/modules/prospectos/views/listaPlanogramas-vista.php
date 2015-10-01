<h3 id="mainTit">Selecciona las plaza que desees cotizar.</h3>


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
					  <li><a href="<?=base_url()?>prospectos/cotizarLocal/<?= $l->id;?>" title="Planta Baja"> &#8226; Piso <?= $l->piso;?></a></li>
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