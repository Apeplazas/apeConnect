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
	<table class="thbr mt10" id="tablaPlano" >
		<thead>
			<tr>
				<th ></th>
				<th ></th>
			</tr>
		</thead>
		<tbody>
			<?
			foreach($locales as $row): ?>
				<tr>
					<td class="details_local">
						<?php echo $row->NombreCorto;
						$id = (int)$row->Inmueble;
						$predios = $this->planogramas_model->traer_predios_por_plaza($this->uri->segment(3));
						?>
					</td>	
					<td class="form_local" style="display:none;">
						<form data-id="<?php echo $row->Local;?>" class="save_local" action="#" method="post">
							<fieldset>
								<label>Local</label>
								<input type="text" name="tipo" id="tipo" value="" placeholder="<?php echo $row->Tipo;?>" />
							</fieldset>
							
							<fieldset>
								<label>Estatus</label>
								<input type="text" name="estatus" id="estatus" value="" placeholder="<?php echo $row->Estatus;?>" />
							</fieldset>
								
							<fieldset>
								<label>Medida</label>
								<input type="text" name="medida" id="medida" value="" placeholder="<?php echo $row->Medida;?>" />
							</fieldset>
							
							<fieldset>
								<label>Unidad de Medida</label>
								<input type="text" name="unidad" id="unidad" value="" placeholder="<?php echo $row->Unidad;?>" />
							</fieldset>
							
							<fieldset>
								<label>Predio</label>
								<select class="predio" name="predio" id="predio">
									<option value="">Seleccione un predio</option>
									<?php foreach($predios as $predio):?>
									<option value="<?=$predio->PREDIO_ID;?>"><?=$predio->NOMBRE_DE_PREDIO;?></option>
									<?php endforeach;?>
								</select>
							</fieldset>
							
							<fieldset>
								<label>Piso</label>
								<select class="piso" name="piso" id="piso">
									<option value="">Seleccione un predio</option>
								</select>
							</fieldset>
							
							<input type="hidden" id="intelisis_ref" name="intelisis_ref" value="<?=$row->Local;?>" />
							<input type="submit" value="Actualizar" />
						</form>
					</td>
				</tr>
				
				<? endforeach; ?>
				
		</tbody>
	</table>
	<br class="clear">
	</div>
<br class="clear">
</div>

<script>
	$(document).ready(function(){
		
		$('.details_local').click(function(e){
			$(this).siblings('.form_local').toggle();
		});
		
		$('.save_local').submit(function(e){
			e.preventDefault();
			var tipo	= $('#tipo').val();
			var estatus =  $('#estatus').val();
			var predio 	=  $('#predio').val();
			var piso 	=  $('#piso').val();
			var medida	=  $('#medida').val();
			var unidad	=  $('#unidad').val();
			var intelisis_ref 	=  $('#intelisis_ref').val();
			if( !tipo || !estatus || !predio || !piso ){
				alert("Favor de ingresar todos los valores");
			}
			$.ajax({
				data : {'tipo'		:tipo,
						'estatus'	:estatus,
						'predio'	:predio,
						'piso'		:piso,
						'medida'	:medida,
						'unidad'	:unidad,
						'intelisis_ref' :intelisis_ref},
				dataType : 'json',
				url : ajax_url + 'guardar_local_intelisis',
				type : 'post',
				success : function(response) {
					
				}
			});
		});
		
		$('.predio').change(function(){

			var $this = $(this);
			var predio_id = $(this).val();
			$.ajax({
				data : {'predio_id':predio_id},
				dataType : 'json',
				url : ajax_url + 'trae_pisos_por_predio',
				type : 'post',
				success : function(response) {
				if($.isEmptyObject(response)){
						alert("Ocurrio un error, intentelo de nuevo");
					}else{
						var piso = $this.parent().next().children('.piso');
						console.log(piso.val());
						piso.empty();
					    
					    $.each(response,function(index,val){
							$option = $("<option></option>")
							.attr("value", val.PISO_ID)
							.text(val.NIVEL_PISO);
							piso.append($option);
						});
					}
				}
			});
		});
		
	});
</script>

<style type="text/css" media="screen">
	.inmueble .pl10{padding:6px 10px!important}
</style>
