<? $cotizacion = $this->session->userdata('cotizacion');?>
<div  id="winRight" class="<? if(sizeof($cotizacion['locales']) > 0):?>barOpen<?else:?>barClose<?endif?>">
	<button class="<? if(sizeof($cotizacion['locales']) > 0):?>winRight<?else:?>winRightClose<?endif?>">Click aquí</button>
	<div id="forma">
		
		<div id="datos-cotizacion">
		<h3 class="secTit"><em>Cotización pendiente</em></h3>
		
		
		</div>
		
		<div id="botCot" class="<? if(sizeof($cotizacion['locales']) > 0):?>botAcCot<?else:?>botAcCotNone<?endif?>">
		  <a class="botonCotiz" href="<?=base_url()?>prospectos/cotizar/1">Seguir Cotizando</a>
		  <a class="botonCotiz" title="Finalizar cotización" href="<?=base_url()?>prospectos/finalizarCotizacion" >Finalizar</a>
		</div>
		
	</div>
</div>
<script>
	$('.remove-cot').on('click',function(){
			var current 	= $(this).closest('div');
			var vectorData 	= $(this).closest('div').attr('id');
			var arr 		= vectorData.split('-');
			var vectoreData = arr[2];
			$('#'+vectoreData).attr("class","click habilitado DESOCUPADO");
			
			$.post("http://www.apeplazas.com/apeConnect/ajax/eliminarLocalCotizacion", {
				id : vectoreData
			}, function(data) {
				current.remove();
			},'json');

		});
</script>
