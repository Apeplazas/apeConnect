<div class="wrapList">
	
	<div class="container">
		<div class="row">
			<a class="btn btn-default btn-lg" href="<?= base_url();?>tempciri/verCi">Ver Lista de Cartas de Intención</a>
		</div>
	</div>
	<br/>
	<br/>
	<div class="container">
		<div class="row">
			<div class="col-xs-6">
				<h2>Cliente</h2>
				<p>Nombre: <?= $ri[0]->pnombre . ' ' . $ri[0]->snombre . ' ' . $ri[0]->apellidopaterno . ' ' . $ri[0]->apellidomaterno;?></p>
				<p>Teléfono: <?= $ri[0]->telefono;?></p>
				<p>Email: <?= $ri[0]->email;?></p>
				<p>RFC: <?= $ri[0]->rfc;?></p>
			</div>
			<div class="col-xs-6">
				<h2>Contrato</h2>
				<p>Inicio: <?= $ri[0]->contraroInicioMes;?></p>
				<p>Duración: <?= $ri[0]->contratoDuracion;?></p>
				<p>Días de gracia: <?= $ri[0]->diasGracia;?></p>
				<p>Local: <?= $ri[0]->local;?></p>
				<p>Renta: <?= $ri[0]->renta;?></p>
			</div>
		</div>
		
		<div class="row">
			<?= $this->session->flashdata('msg'); ?>
			<form style="max-width: 390px;" method="post" action="<?= base_url();?>tempciri/functionCancelarRi" enctype="multipart/form-data">
				<div class="form-group">
			    	<label for="exampleInputPassword1">Motivo de cancelación</label>
			    	<textarea class="form-control uppercase" name="motivoCancelacion" required></textarea>
			  	</div>
			  	<div class="checkbox">
			    	<label>
			      		<input type="checkbox" name="devolucionOn" id="devolucionOn"> Devolución
			    	</label>
			  	</div>
			  	<div class="form-group" id="archivoDevolucion" style="display:none;">
			    	<label for="exampleInputFile">Ficha de devolución</label>
			   		<input type="file" id="fichaDevolucion" name="fichaDevolucion" />
			  	</div>
			  	<input type="hidden" name="riId" value="<?= $ri[0]->id; ?>" />
			  	<button type="submit" class="btn btn-default">Cancelar Documento</button>
			</form>
		</div>
	</div>
</div>
<script>
	 $('#devolucionOn').change(function() {
        if($(this).is(":checked")) {
            $('#archivoDevolucion').show();
        }else{
        	$('#archivoDevolucion').hide();	
        }
    });
</script>
