<h3 id="mainTit">Lista de prospectos general</h3>
<div class="wrapList">

	<div id="actions">
		<a href="<?=base_url()?>prospectos/agregar" title="Agregar Contactos" class="addSmall">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Agregar Prospecto"></i>
			<span>Agregar Prospecto</span>
		</a>
		<a id="bAva" title="Busqueda Avanzada" class ="addSmall">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/search.svg" alt="Busqueda por Vendedor"></i>
			<span>Búsqueda por Vendedor</span>
		</a>
	</div>
	<!----Busqueda avanzada-->
	<? $this->load->view('includes/toolbars/busquedaAvanzadaProspectos')?>
	<!----Termina -->
	<div id="wraping">
	<div id="busVen">
		<label>Búsqueda de prospecto</label>
		<span id="filVen">
			<select id="selVen" name="selVen">
				<option value="correo" selected>Correo Electronico</option>
				<option value="nombre">Nombre</option>
				<option value="apellido">Apellido Paterno</option>
			</select>
		</span>
		<input id="busIn" name="busVen" placeholder="BUSQUEDA POR PROSPECTO"/>
	</div>
	<table id="tablaAvan">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Estado</th>
				<th><span class="Rtel">Telefono</span></th>
				<th>Dirección</th>
				<th><span class="Rori">Vendedor</span></th>
				<th>Fecha Creación</th>
				<th></th>
			</tr>
		</thead>
		<tbody id="pros">
			<? foreach($prospectos as $p):?>
			<tr  id="<?= $p->id;?>">
			  <td>
					<a class="Rema" href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>">
						<span class="bold"><?= $p->pnombre;?> <?= $p->snombre;?> <?= $p->apellidop;?> <?= $p->apellidom;?></span>
						<br><?= $p->correo;?>
					</a>
				</td>
			  <td><a class="tbEst" href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>"><?= $p->estado?></a></td>
			  <td>
					<a class="Rtel" href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>">
						<? if($p->telefono):?><em class="sp">Tel:</em><?=$p->telefono;?><br><?endif;?>
						<? if($p->celular):?><em class="sp">Cel:</em><?=$p->celular;?><?endif;?>
				</a>
			</td>
			  <td>
					<a href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>">
					<span class="priSeg"> <? if($p->calle):?>Calle: <?=$p->calle;?><br><?endif;?>
					<? if($p->numeroInt):?>Int: <?=$p->numeroInt;?><br><?endif;?>
					<? if($p->numeroExt):?>Ext: <?=$p->numeroExt;?><?endif;?>
					</span>
					<span class="segSeg">
					<? if($p->municipio):?>Colonia: <?=$p->municipio;?><br><?endif;?>
					<? if($p->colonia):?>Colonia: <?=$p->colonia;?><br><?endif;?>
					<? if($p->cp):?>CP: <?=$p->cp;?><?endif;?>
					</span>
					</a>
				</td>
			  <td><a class="Rori" href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>"><?= $p->nombreCompleto?></a></td>
			  <td><a class="fCr" href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>"><?= ucfirst($p->fechaCreacion)?></a></td>
			</tr>
			<? endforeach; ?>
		</tbody>
	</table>
	
	</div>
	<button id="atr" class="paginacion">Cargar menos </button>
	<button id="ade" class="paginacion">Cargar más </button>
</div>


<script>
$("#bAva").click(function() {
	$("#busAvan").toggle();
	$("#busVen").toggle();
	$(this).toggleClass("addSmall").toggleClass("addSmallClick");
});

$('.paginacion').click(function(event){
		var val  = $( "#tablaAvan tr" ).last().attr('id');
		var tipo  = $(this).attr('id');
		
		var alldata = {
		    tipo : tipo,
		    val : val
		};
		
		$.post(ajax_url+"cargarPaginadorVentas", {
	    	alldata : alldata
	    },
	
	  function(data) { sucess:
		$("#tablaAvan tbody").remove();
	  	$("#tablaAvan").append(data);
	  });
  });
  
  
$('#busIn').keyup(function(event){
		var val  = $( "#busVen input" ).val();
		var select  = $( "#selVen" ).val();
		
		var bus = {
		    select : select,
		    val : val
		};
		
		$.post(ajax_url+"buscaContactoVentas", {
	    	bus : bus
	    },
	
	  function(data) { sucess:
		$("#tablaAvan tbody").remove();
	  	$("#tablaAvan").append(data);
	  });
	  
  });
</script>