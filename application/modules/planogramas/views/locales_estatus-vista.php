<div id="mainTit">
	<h3>Listado de Locales</h3>
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
	<div class="thbr mt10" id="tablaPlano" >

			<?$inmueble_id = intval($this->uri->segment(3));?>
			<?php foreach($locales as $row): 
				$id 			= (int)$row->Inmueble;
				$local_estatus 	= $this->planogramas_model->traer_local_estatus($row->Local);
				$class_local 	= (sizeof($local_estatus) > 0) ? 'listo' : '';
				?>
				<div class="holder">
					<div class="details_local <?=$class_local;?>" title="<?= $row->Local;?>">
						<?php echo $row->NombreCorto;?>
					</div>	
					<div class="form_local none">
						<span class="cerrarpop" style="float:right; cursor:pointer"><img width="18" src="<?=base_url()?>assets/graphics/cerrar.png"/></span>
						<h2>Esta editando Local "<?= $row->Local;?>"</h2>
						<form data-id="<?php echo $row->Local;?>" class="save_local" action="#" method="post">
							<fieldset>
								<label>Estatus</label>
								<select name="estatus" id="estatus"/>
									<option value="">Seleccione Estatus</option>
									<option value="BAJA" <?php if( isset($local_layout[0]->ESTATUS) && $local_layout[0]->ESTATUS == 'BAJA' ) echo 'selected'?>>BAJA</option>
									<option value="AGRUPADO" <?php if( isset($local_layout[0]->ESTATUS) && $local_layout[0]->ESTATUS == 'AGRUPADO' ) echo 'selected'?>>AGRUPADO</option>
									<option value="CONFINADO" <?php if( isset($local_layout[0]->ESTATUS) && $local_layout[0]->ESTATUS == 'CONFINADO' ) echo 'selected'?>>CONFINADO</option>
								</select>
							</fieldset>
							<input type="hidden" id="intelisis_ref" name="intelisis_ref" value="<?=$row->Local;?>" />
							<input type="submit" class="botonLayouts" value="Actualizar" />
						</form>
					</div>
				</div>
				
				<? endforeach; ?>
				

	</div>
	<br class="clear">
	</div>
<br class="clear">
</div>

<script>
	$(document).ready(function(){
		
		$('.details_local').click(function(e){
			
			if ($(this).siblings('.form_local').hasClass("none")) {
				$('.form_local').addClass("none");
				$(this).siblings('.form_local').removeClass("none");
			}else{
				$('.form_local').addClass("none");
			}
			
		});
		
		$('.cerrarpop').click(function(){
			$(this).parent().addClass("none");
		});
		
		$('.save_local').submit(function(e){
			e.preventDefault();
			var estatus =  $(this).find('#estatus').val();
			var intelisis_ref 	=  $(this).find('#intelisis_ref').val();
			if( !estatus ){
				alert("Favor de ingresar estatus");
				return false;
			}
			$.ajax({
				data : {
						'estatus'	:estatus,
						'intelisis_ref' :intelisis_ref},
				dataType : 'json',
				url : ajax_url + 'guardar_local_estatus_intelisis',
				type : 'post',
				success : function(response) {
					location.reload();
				}
			});
		});
		
	});
</script>

<style type="text/css" media="screen">
	.inmueble .pl10{padding:6px 10px!important}
</style>
