<h3 id="mainTit">Listado de cotizaciones</h3>
<div class="wrapList">
	<div id="actions">
		<a href="<?=base_url()?>prospectos" title="Agregar Cotizacion" class="addSmall"><i class="iconPlus">Agregar</i>Agregar Cotizacion</a>
	</div>
	
	<table id="tablaproveed">
		<thead> 
			<tr>
				<th>&nbsp</th>
				<th>Folio</th>
				<th>Prospecto</th>
				<th class="tcenter">Locales Cotizados</th>
				<th>Vigencia</th>
				
			</tr> 
		</thead> 
		<tbody>
			<? if(isset($prospectosCotiza)):?>
			<script type="text/javascript">
			$(document).ready(function() {
			/// Llama al plugin de datatables
				$('#tablaproveed').dataTable();
				/// Genera el even de cada lista
				$('.wrapListForm fieldset:even').addClass('evenBorder');
			});
			</script>	
				<? foreach($prospectosCotiza as $c):?>
				<? $prospecto = $this->prospectos_model->cargarProspectoPerfil($c->prospectoID);?>
				<? $cuenta = $this->prospectos_model->conteoLocales($c->cotizacionID);?>
				<tr>
				  <th>&nbsp</th>
				  <th><a href="<?=base_url()?>prospectos/finalizarCotizacion/<?= $c->cotizacionID;?>"><?= $c->folio;?></a></th>
				  <th>
					  <? foreach($prospecto as $p):?>
					  <a href="<?=base_url()?>prospectos/finalizarCotizacion/<?= $c->cotizacionID;?>"><?= $p->pnombre;?> <?= $p->apellidop;?><br> <?= $p->correo?></a>
					  <? endforeach; ?>
				  </th>
				  <th class="tcenter">
					  <? foreach($cuenta as $row):?>
					   <a href="<?=base_url()?>prospectos/finalizarCotizacion/<?= $c->cotizacionID;?>"><?= $row->cuenta;?></a>
					  <? endforeach; ?>
				  </th>
				  <th><a href="<?=base_url()?>prospectos/finalizarCotizacion/<?= $c->cotizacionID;?>"><?= convierteFechaBDLetra($c->vigencia, 2)?></a></th>
				  <? endforeach; ?>
				    <? else:?>
				  <th colspan="5"> <p class="msgTable">No tiene cotizaciones realizadas</p></th>
			  <? endif;?>
			</tr>
		</tbody> 
	</table>
</div>
