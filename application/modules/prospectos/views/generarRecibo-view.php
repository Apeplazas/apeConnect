<? foreach($perfil as $row):?>

<h3 id="mainTit">Lista de locales cotizados a <?= $row->pnombre;?> <?= $row->snombre;?> <?= $row->apellidop;?> <?= $row->apellidom;?></h3>
<div class="wrapList">
	<!-- No se debe borrar por que si no los estilos se rompen ese contenedor se queda especificamente para todas las acciones que se tengan que agregar-->
	<div id="actions"></div>
	<form id="formulario-apartado" method="post" action="<?=base_url()?>prospectos/generarReciboInterno">
				<div class="wrapLabel">
		  			<label><input type="radio" name="generador" id="cartIn" value="cartIn" />Generar desde Carta de intención</label>
				</div>
				
				<div class="wrapLabel">
		  			<label><input type="radio" name="generador" id="iniciar" value="iniciar" />Generar desde Cotización</label>
				</div>
				
	            <div id="secCartasInt" style="display:none;">
	            	<h3>Cartas Intención</h3>
	            	<section>
			            <table id="tablaproveed">
							<thead> 
								<tr>
									<th>&nbsp</th>
									<th>Folio</th>
									<th>Ciudades</th>
									<th>Mes de inicio</th>
								</tr> 
							</thead> 
							<tbody>
							  <? foreach($cartasIntencion as $c):?>
							  <tr>
							  	<th><input type="radio" name="cartInId" value="<?= $c->id;?>" />
								<th><?= $c->folio;?></th>
								<th><?= $c->ciudades;?></th>
								<th><?= $c->contraroInicioMes;?></th>
							  </tr>
							  <? endforeach;?>
							</tbody> 
						</table>
					</section>
					<h3>Datos Adicionales</h3>
	            	<section>
			            <div class="wrapListForm">
			        		<fieldset>
								<div class="wrapLabel">
				  					<label>Cantidad pagada</label>
								</div>
			    	    		<input class="bigInp" type="text" name="cantpago">
							</fieldset>
						</div>
					</section>
				</div>
				<div id="wrapListForm1" style="display:none;">
					<h3>Cotizaciones</h3>
			        <section>
			            <table id="tablaproveed">
							<thead> 
								<tr>
									<th>&nbsp</th>
									<th>Folio</th>
									<th>Vigencia</th>
									<th>Plazas</th>
								</tr> 
							</thead> 
							<tbody>
							  <? foreach($cotizaciones as $c):?>
							  <tr>
							  	<th><input type="checkbox" name="cotId" class="showflip" value="<?= $c->cotizacionID;?>" /></th>
								<th><?= $c->folio;?></th>
								<th><?= $c->vigencia;?></th>
								<th><?= $c->ciudades;?></th>
							  </tr>
								<? $locales = $this->prospectos_model->cargaLocalesCotizacion($c->cotizacionID);?>
								<? foreach($locales as $l): ?>
									<tr class="detailsflip flip-<?= $c->cotizacionID;?>" style="display: none">
										<th><input type="radio" class="cotizacionIds" name="cotids" value="<?= $l->id; ?>"/></th>
									 	<th colspan="2">
									 		<?= $l->claveLocal;?>
									 	</th>
									 	<th>
									 		<?= $l->localPrecio;?>
									 	</th> 
									</tr>
								<? endforeach; ?>
							  <? endforeach; ?>
							</tbody> 
						</table>
			        </section>
			        <h3>Datos Adicionales</h3>
			        <section>
			        	<div class="wrapListForm">
			        		<fieldset>
								<div class="wrapLabel">
				  					<label>Cantidad pagada</label>
								</div>
			    	    		<input class="bigInp" type="text" name="cantpago">
							</fieldset>
			        		<span class="msgBar grayBox">Datos del contrato</span>
							<fieldset class="evenBorder">
								<div class="wrapLabel">
				  					<label>Mes de inicio:</label>
								</div>
								<select name="mes" class="selBig">
									<option value="Enero">Enero</option>
									<option value="Febrero">Febrero</option>
									<option value="Marzo">Marzo</option>
									<option value="Abril">Abril</option>
									<option value="Mayo">Mayo</option>
									<option value="Junio">Junio</option>
									<option value="Julio">Julio</option>
									<option value="Agosto">Agosto</option>
									<option value="Septiembre">Septiembre</option>
									<option value="Octubre">Octubre</option>
									<option value="Noviembre">Noviembre</option>
									<option value="Diciembre">Diciembre</option>
								</select>
							</fieldset>
			    
							<fieldset>
			    				<div class="wrapLabel">
				 					<label>Duración:</label>
			    				</div>
			    				<select name="contratotiempo" class="selBig">
			    					<option value="6 meses">6 meses</option>
			    					<option value="12 meses">12 meses</option>
			    					<option value="24 meses">24 meses</option>
			    				</select>
							</fieldset>
						</div>
			            
			        </section>
				</div>
				<input type="hidden" value="<?= $row->id;?>" name="clienteid">
	</form>
</div>
<?endforeach?>

<script>
	$(document).ready(function(){
		$('#cartIn').click(function(){
			if(!$('#secCartasInt').is(":visible"))
				$('#secCartasInt').show();	
			if($('#wrapListForm1').is(":visible"))
				$('#wrapListForm1').hide();
		});
		$('#iniciar').click(function(){
			if(!$('#wrapListForm1').is(":visible"))
				$('#wrapListForm1').show();
			if($('#secCartasInt').is(":visible"))
				$('#secCartasInt').hide();
		});
		$.validator.messages.required = 'este campo es obligatorio';
		var form = $("#formulario-apartado");
		form.validate({
		    errorPlacement: function errorPlacement(error, element) { element.before(error); },
		     rules: {
                
            }
		});
	    
		$("#wrapListForm1, #secCartasInt").steps({
		    headerTag: "h3",
		    bodyTag: "section",
		    transitionEffect: "slideLeft",
		    onStepChanging: function (event, currentIndex, newIndex)
		    {
		        form.validate().settings.ignore = ":disabled,:hidden";
		        return form.valid();
		    },
		    onFinishing: function (event, currentIndex)
		    {
		        form.validate().settings.ignore = ":disabled";
		        return form.valid();
		    },
		    onFinished: function (event, currentIndex)
		    {
		        form.submit();
		    },
		    labels: {
		        cancel: "Cancelar",
		        current: "paso actual:",
		        pagination: "Paginación",
		        finish: "Finalizar",
		        next: "Siguiente",
		        previous: "Anterior",
		        loading: "Cargando..."
		    }
		});
		$('.showflip').click( function(){
			if($(this).is(":checked")){
				$('input:checkbox').not(this).removeAttr('checked');
		        var id = $(this).val();
		        $('.detailsflip').toggle( false );
				$('.flip-'+id).toggle( true );
				$(this).attr('checked','checked');
		    }else{
				var id = $(this).val();
				$('.flip-'+id).toggle( false );
			}
		});
	});
</script>