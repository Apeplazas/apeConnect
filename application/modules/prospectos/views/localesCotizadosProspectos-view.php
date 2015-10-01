<? foreach($perfil as $row):?>

<h3 id="mainTit">Lista de locales cotizados a <?= $row->pnombre;?> <?= $row->snombre;?> <?= $row->apellidop;?> <?= $row->apellidom;?></h3>
<div class="wrapList">
	<!-- No se debe borrar por que si no los estilos se rompen ese contenedor se queda especificamente para todas las acciones que se tengan que agregar-->
	<div id="actions"></div>
	<form id="formulario-apartado" method="post" action="<?=base_url()?>prospectos/testapartado">
		<div>
			<h3>Locales</h3>
	        <section>
	            <table id="tablaproveed">
					<thead> 
						<tr>
							<input type="hidden" value="<?= $row->id;?>" name="clienteid">
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
								<th><input type="checkbox" class="cotizacionIds" name="cotids[]" value="<?= $l->id; ?>"/></th>
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
	        <h3>Pago</h3>
	        <section>
	        	
	        	<div class="wrapListForm" id="wrapListForm1">
					<fieldset class="evenBorder">
						<div class="wrapLabel">
		  					<label>Cantidad pagada</label>
						</div>
	    	    		<input class="bigInp"  type="text" name="cantpago" />
					</fieldset>
	    
					<fieldset>
	    				<div class="wrapLabel">
		 					<label>Número de identificación</label>
	    				</div>
	    				<input type="text" name="idnum" class="bigInp" />
					</fieldset>
	    
					<fieldset class="evenBorder">
	    				<div class="wrapLabel">
		  					<label>Referencia:</label>
	    				</div>
	    	    		<input type="text" name="referencia" class="bigInp" />
					</fieldset>
	    
					<fieldset>
	   					<div class="wrapLabel">
		  					<label>Ultimos digitos de la tarjeta</label>
	    				</div>
	    				<input type="number" name="ncard" class="bigInp" />
					</fieldset>
				</div>	
	        </section>
	        <h3>Cliente</h3>
	        <section>
	        	<div class="wrapListForm" id="wrapListForm1">
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
	    
	    			<span class="msgBar grayBox">Datos de devolución</span>
	    
					<fieldset class="evenBorder">
	    				<div class="wrapLabel">
		  					<label>Numero de cuenta</label>
	    				</div>
	    	    		<input type="text" name="remnumcuenta" class="bigInp" />
					</fieldset>
	    
					<fieldset>
	   					<div class="wrapLabel">
		  					<label>Banco</label>
	    				</div>
	    				<select name="rembanco" class="selBig">
						 	<option value="" checked="">Seleccione uno..</option>
						 	<option value="BANCO NACIONAL DE MEXICO, S.A.">BANCO NACIONAL DE MEXICO, S.A.</option>
							<option value="SANTANDER">SANTANDER</option>
							<option value="HSBC">HSBC</option>
							<option value="SCOTIABANK INVERLAT">SCOTIABANK INVERLAT</option>
							<option value="BBVA BANCOMER">BBVA BANCOMER</option>
							<option value="BANCO MERCANTIL DEL NORTE">BANCO MERCANTIL DEL NORTE</option>
							<option value="BANCO INBURSA">BANCO INBURSA</option>
							<option value="BANCA MIFEL">BANCA MIFEL</option>
							<option value="BANCO REGIONAL DE MONTERREY">BANCO REGIONAL DE MONTERREY</option>
							<option value="BANCO INVEX">BANCO INVEX</option>
							<option value="BANCO DEL BAJIO">BANCO DEL BAJIO</option>
							<option value="BANSI">BANSI</option>
							<option value="AFIRME">AFIRME</option>
							<option value="BANK OF AMERICA MEXICO">BANK OF AMERICA MEXICO</option>
							<option value="BANCO J.P. MORGAN">BANCO J.P. MORGAN</option>
							<option value="BANCO VE POR MAS">BANCO VE POR MAS</option>
							<option value="AMERICAN EXPRESS">AMERICAN EXPRESS</option>
							<option value="INVESTA">INVESTA</option>
							<option value="CIBANCO">CIBANCO</option>
							<option value="BANK OF TOKYO-MITSUBISHI UFJ (MEXICO), S.A.">BANK OF TOKYO-MITSUBISHI UFJ (MEXICO), S.A.</option>
							<option value="BANCO MONEX">BANCO MONEX</option>
							<option value="DEUTSCHE BANK MEXICO">DEUTSCHE BANK MEXICO</option>
							<option value="BANCO AZTECA">BANCO AZTECA</option>
							<option value="BANCO CREDIT SUISSE">BANCO CREDIT SUISSE</option>
							<option value="AUTOFIN">AUTOFIN</option>
							<option value="BARCLAYS BANK MEXICO">BARCLAYS BANK MEXICO</option>
							<option value="BANCO AHORRO FAMSA">BANCO AHORRO FAMSA</option>
							<option value="INTERCAM BANCO">INTERCAM BANCO</option>
							<option value="ABC CAPITAL">ABC CAPITAL</option>
							<option value="BANCO ACTINVER">BANCO ACTINVER</option>
							<option value="BANCO COMPARTAMOS">BANCO COMPARTAMOS</option>
							<option value="BANCO MULTIVA">BANCO MULTIVA</option>
							<option value="UBS BANK MEXICO">UBS BANK MEXICO</option>
							<option value="BANCOPPEL">BANCOPPEL</option>
							<option value="CONSUBANCO">CONSUBANCO</option>
							<option value="BANCO WAL-MART DE MEXICO ADELANTE">BANCO WAL-MART DE MEXICO ADELANTE</option>
							<option value="VOLKSWAGEN BANK">VOLKSWAGEN BANK</option>
							<option value="BANCO BASE">BANCO BASE</option>
							<option value="BANCO PAGATODO">BANCO PAGATODO</option>
							<option value="BANCO FORJADORES">BANCO FORJADORES</option>
							<option value="BANKAOOL">BANKAOOL</option>
							<option value="BANCO INMOBILIARIO MEXICANO">BANCO INMOBILIARIO MEXICANO</option>
							<option value="FUNDACION DONDE BANCO">FUNDACION DONDE BANCO</option>
							<option value="BANCO BANCREA">BANCO BANCREA</option>	    
	    				</select>
					</fieldset>
				</div>
	            
	        </section>
		</div>
	</form>
</div>
<?endforeach?>

<script>
	$(document).ready(function(){
		$.validator.messages.required = 'este campo es obligatorio';
		var form = $("#formulario-apartado");
		form.validate({
		    errorPlacement: function errorPlacement(error, element) { element.before(error); },
		     rules: {
                
            }
		});
		
		// must be called after validate()
	    $('.cotizacionIds').each(function () {
	        $(this).rules('add', {
	            required: true
	        });
	    });
	    
		form.children("div").steps({
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