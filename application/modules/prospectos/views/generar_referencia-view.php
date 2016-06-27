<? $plaza   	= set_value('plaza'); ?>
<? $piso		= set_value('plaza_piso'); ?>
<? $plaza_dir 	= set_value('plaza_dir'); ?>
<? $locales 	= set_value('locales'); ?>

<div id="mainTit">
<h3>Generar Referencia Bancaria</h3>
</div>

<div class="wrapList" >
	<div id="actions">
		<span class="back">
		 <a class="addSmall" href="javascript:window.history.go(-1);">
			 <i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/back.svg" alt="Regresar"></i>
			 <span>Regresar</span>
		 </a>
		</span>
	</div>

	<?= $this->session->flashdata('msg');?>

	<form id="addPros" action="<?=base_url()?>prospectos/guardar_referencia_bancaria" method="post">
	
	<div class="wrapListForm" id="wrapListForm1">
	<table>
		<tbody>
	<tr>
	    <td>
	    	<label>Plaza</label>
	    </td>
	    <td>
			<select id="plaza" name="plaza" required>
				<option value="">Seleccione una plaza</option>
				<?php foreach($plazas as $plaza):?>
					<option value="<?php echo $plaza->id;?>" <?php if($plaza == $plaza->id) echo "selected";?>><?php echo $plaza->plaza;?></option>
				<?php endforeach;?>
			</select>
		</td>
		<td>
	    	<label>Piso</label>
	    </td>
	    <td>
			<select id="plaza_piso" name="plaza_piso" required>
				<?php if($piso):?>
				<option value="<?php echo $piso;?>"><?php echo $piso;?></option>
				<?php else:?>
				<option value="">Seleccione una plaza</option>	
				<?php endif;?>
			</select>
		</td>
	</tr>
	<tr>
		<td>
	    	<label>Dirección de la plaza</label>
	    </td>
	    <td>
			<select id="plaza_dir" name="plaza_dir" required>
				<?php if($plaza_dir):?>
				<option value="<?php echo $plaza_dir;?>"><?php echo $plaza_dir;?></option>
				<?php else:?>
				<option value="">Seleccione una plaza</option>
				<?php endif;?>
			</select>
		</td>
	    <td>
			<label>Local(es)</label>
		</td>
	    <td>
		    <input class="bigInp" name="locales" value="<?php if($locales) echo $locales;?>" type="text" required/>
		</td>
	  </tr>
		</tbody>
	</table>

		<span id="formSub">
			<input type="hidden" name="prospecto_id" value="<?php echo $this->uri->segment(3);?>" />
		  	<input class="mainBotton" type="submit" name="button" id="button" value="Generar Referencia">
		</span>
		<br class="clear">
	</div>
	
	</form>
	<script>
		$(document).ready(function(){
			$('#plaza').change(function(){
				var self, $option;
				self = $('#plaza_piso');
	    		self.empty();
				var plazaId = $(this).val();
				$.ajax({
					data : {'plazaId': plazaId},
					dataType : 'json',
					url : ajax_url + 'cargarPlazaPisos',
					type : 'post',
					success : function(response) {
						if($.isEmptyObject(response)){
							$option = $("<option></option>")
						    .attr("value", "")
						    .text("No hay direcciones");
						    self.append($option);
						}else{
							$option = $("<option></option>")
						    .attr("value", "")
						    .text("Seleccione una dirección");
						    self.append($option);
							$.each(response, function(index, option) {
						    	$option = $("<option></option>")
						        .attr("value", option.piso)
						        .text(option.piso);
						      	self.append($option);
						    });
					   	}
					}
				});

			});
			$('#plaza_piso').change(function(){
				var self, $option;
				self = $('#plaza_dir');
	    		self.empty();
				var plazaId = $('#plaza').val();
				var plazaPiso = $('#plaza_piso').val();
				$.ajax({
					data : {'plazaId': plazaId,'plazaPiso':plazaPiso},
					dataType : 'json',
					url : ajax_url + 'cargarPlazasDir',
					type : 'post',
					success : function(response) {
						if($.isEmptyObject(response)){
							$option = $("<option></option>")
						    .attr("value", "")
						    .text("No hay direcciones");
						    self.append($option);
						}else{
							$option = $("<option></option>")
						    .attr("value", "")
						    .text("Seleccione una dirección");
						    self.append($option);
							$.each(response, function(index, option) {
						    	$option = $("<option></option>")
						        .attr("value", option.direccion)
						        .text(option.direccion);
						      	self.append($option);
						    });
					   	}
					}
				});

			});
		});
	</script>
	<br class="clear">
</div>
<script type="text/javascript">
	$('#wrapListForm1 tbody tr td:even').addClass('grayField');
	$('#wrapListForm2 tbody tr td:even').addClass('grayField');
</script>
