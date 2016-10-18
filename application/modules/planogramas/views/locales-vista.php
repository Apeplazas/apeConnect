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
				$predios 		= $this->planogramas_model->traer_predios_por_plaza($inmueble_id);
				$local_layout 	= $this->planogramas_model->traer_local_layout($row->Local);
				$class_local 	= (sizeof($local_layout) > 0) ? 'listo' : '';
				$piso_nombre 	= isset($local_layout[0]->PISO_ID) ? $this->planogramas_model->traer_piso($local_layout[0]->PISO_ID) : '';
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
								<label>Marca</label>
								<select name="marca" id="marca"/>
									<option value="">Seleccione Marca</option>
									<option value="PT" <?php if( isset($local_layout[0]->CATEGORIA_LOCAL) && $local_layout[0]->CATEGORIA_LOCAL == 'PT' ) echo 'selected'?>>Plaza de la tecnologia</option>
									<option value="CJ" <?php if( isset($local_layout[0]->CATEGORIA_LOCAL) && $local_layout[0]->CATEGORIA_LOCAL == 'CJ' ) echo 'selected'?>>Centro Joyero</option>
									<option value="FP" <?php if( isset($local_layout[0]->CATEGORIA_LOCAL) && $local_layout[0]->CATEGORIA_LOCAL == 'FP' ) echo 'selected'?>>Friki Plaza</option>
									<option value="CN" <?php if( isset($local_layout[0]->CATEGORIA_LOCAL) && $local_layout[0]->CATEGORIA_LOCAL == 'CN' ) echo 'selected'?>>Centro de Negocios</option>
									<option value="PM" <?php if( isset($local_layout[0]->CATEGORIA_LOCAL) && $local_layout[0]->CATEGORIA_LOCAL == 'PM' ) echo 'selected'?>>Plaza de la Mujer</option>
								</select>
							</fieldset>
							<fieldset>
								<label>Tipo Local</label>
								<select name="tipo" id="tipo"/>
									<option value="">Seleccione Estatus</option>
									<option value="BODEGA" <?php if( isset($local_layout[0]->TIPO_DE_LOCAL) && $local_layout[0]->TIPO_DE_LOCAL == 'BODEGA' ) echo 'selected'?>>BODEGA</option>
									<option value="DEFAULT" <?php if( isset($local_layout[0]->TIPO_DE_LOCAL) && $local_layout[0]->TIPO_DE_LOCAL == 'DEFAULT' ) echo 'selected'?>>DEFAULT</option>
									<option value="DEPARTAMENTO" <?php if( isset($local_layout[0]->TIPO_DE_LOCAL) && $local_layout[0]->TIPO_DE_LOCAL == 'DEPARTAMENTO' ) echo 'selected'?>>DEPARTAMENTO</option>
									<option value="DESPACHO" <?php if( isset($local_layout[0]->TIPO_DE_LOCAL) && $local_layout[0]->TIPO_DE_LOCAL == 'DESPACHO' ) echo 'selected'?>>DESPACHO</option>
									<option value="ESPACIO_RENTABLE" <?php if( isset($local_layout[0]->TIPO_DE_LOCAL) && $local_layout[0]->TIPO_DE_LOCAL == 'ESPACIO_RENTABLE' ) echo 'selected'?>>ESPACIO_RENTABLE</option>
									<option value="EXHIBIDORES" <?php if( isset($local_layout[0]->TIPO_DE_LOCAL) && $local_layout[0]->TIPO_DE_LOCAL == 'EXHIBIDORES' ) echo 'selected'?>>EXHIBIDORES</option>
									<option value="LOCAL" <?php if( isset($local_layout[0]->TIPO_DE_LOCAL) && $local_layout[0]->TIPO_DE_LOCAL == 'LOCAL' ) echo 'selected'?>>LOCAL</option>
									<option value="OFICINA" <?php if( isset($local_layout[0]->TIPO_DE_LOCAL) && $local_layout[0]->TIPO_DE_LOCAL == 'OFICINA' ) echo 'selected'?>>OFICINA</option>
									<option value="SUPERFICIES" <?php if( isset($local_layout[0]->TIPO_DE_LOCAL) && $local_layout[0]->TIPO_DE_LOCAL == 'SUPERFICIES' ) echo 'selected'?>>SUPERFICIES</option>
									<option value="VIDEO JUEGOS" <?php if( isset($local_layout[0]->TIPO_DE_LOCAL) && $local_layout[0]->TIPO_DE_LOCAL == 'VIDEO JUEGOS' ) echo 'selected'?>>VIDEO JUEGOS</option>
									<option value="VITRINA" <?php if( isset($local_layout[0]->TIPO_DE_LOCAL) && $local_layout[0]->TIPO_DE_LOCAL == 'VITRINA' ) echo 'selected'?>>VITRINA</option>
								</select>
							</fieldset>
							
							<fieldset>
								<label>Estatus</label>
								<select name="estatus" id="estatus"/>
									<option value="">Seleccione Estatus</option>
									<option value="BAJA" <?php if( isset($local_layout[0]->ESTATUS_LOCAL) && $local_layout[0]->ESTATUS_LOCAL == 'BAJA' ) echo 'selected'?>>BAJA</option>
									<option value="RENTADO" <?php if( isset($local_layout[0]->ESTATUS_LOCAL) && $local_layout[0]->ESTATUS_LOCAL == 'RENTADO' ) echo 'selected'?>>RENTADO</option>
									<option value="CONFINADO" <?php if( isset($local_layout[0]->ESTATUS_LOCAL) && $local_layout[0]->ESTATUS_LOCAL == 'CONFINADO' ) echo 'selected'?>>CONFINADO</option>
									<option value="DISPONIBLE" <?php if( isset($local_layout[0]->ESTATUS_LOCAL) && $local_layout[0]->ESTATUS_LOCAL == 'DISPONIBLE' ) echo 'selected'?>>DISPONIBLE</option>
									<option value="APARTADO" <?php if( isset($local_layout[0]->ESTATUS_LOCAL) && $local_layout[0]->ESTATUS_LOCAL == 'APARTADO' ) echo 'selected'?>>APARTADO</option>
								</select>
							</fieldset>
								
							<fieldset>
								<label>Medida</label>
								<input type="text" name="medida" id="medida" value="<?php if(isset($local_layout[0]->AREA_RENTABLE)) echo $local_layout[0]->AREA_RENTABLE;?>" placeholder="<?php echo $row->Medida;?>" />
							</fieldset>
							
							<fieldset>
								<label>Uso Local</label>
								<select name="uso_local" id="uso_local"/>
									<option value="">Seleccione Uso Local</option>
									<option value="ESPECIAL COMIDA CON GAS" <?php if( isset($local_layout[0]->USO_LOCAL) && $local_layout[0]->USO_LOCAL == 'ESPECIAL COMIDA CON GAS' ) echo 'selected'?>>ESPECIAL COMIDA CON GAS</option>
									<option value="LOCAL COMUN U OFICINA" <?php if( isset($local_layout[0]->USO_LOCAL) && $local_layout[0]->USO_LOCAL == 'LOCAL COMUN U OFICINA' ) echo 'selected'?>>LOCAL COMUN U OFICINA</option>
									<option value="BODEGAS O VITRINA" <?php if( isset($local_layout[0]->USO_LOCAL) && $local_layout[0]->USO_LOCAL == 'BODEGAS O VITRINA' ) echo 'selected'?>>BODEGAS O VITRINA</option>
									<option value="ESPECIAL COMIDA" <?php if( isset($local_layout[0]->USO_LOCAL) && $local_layout[0]->USO_LOCAL == 'ESPECIAL COMIDA' ) echo 'selected'?>>ESPECIAL COMIDA</option>
									<option value="ALIMENTOS CON INSTALACIONES" <?php if( isset($local_layout[0]->USO_LOCAL) && $local_layout[0]->USO_LOCAL == 'ALIMENTOS CON INSTALACIONES' ) echo 'selected'?>>ALIMENTOS CON INSTALACIONES</option>
									<option value="VIDEO JUEGOS Y ESTETICAS" <?php if( isset($local_layout[0]->USO_LOCAL) && $local_layout[0]->USO_LOCAL == 'VIDEO JUEGOS Y ESTETICAS' ) echo 'selected'?>>VIDEO JUEGOS Y ESTETICAS</option>
								</select>
							</fieldset>
							
							<fieldset>
								<label>Predio</label>
								<select class="predio" name="predio" id="predio">
									<option value="">Seleccione un predio</option>
									<?php foreach($predios as $predio):?>
									<option value="<?=$predio->PREDIO_ID;?>" <?php if(isset($local_layout[0]->PREDIO_ID) && $local_layout[0]->PREDIO_ID == $predio->PREDIO_ID) echo 'selected';?>><?=$predio->CALLE;?> <?=$predio->NUMERO_EXTERIOR;?></option>
									<?php endforeach;?>
								</select>
							</fieldset>
							
							<fieldset>
								<label>Piso</label>
								<select class="piso" name="piso" id="piso">
									<?php if(isset($local_layout[0]->PISO_ID)) echo '<option value="' . $local_layout[0]->PISO_ID . '">' . $piso_nombre[0]->NIVEL_PISO . '</option>';
									else echo '<option value="">Seleccione un predio</option>';?>
								</select>
							</fieldset>
							<input type="hidden" id="inmueble_id" value="<?= $inmueble_id?>" />
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
			var marca	= $(this).find('#marca').val();
			var inmueble_id = $(this).find('#inmueble_id').val();
			var tipo	= $(this).find('#tipo').val();
			var estatus =  $(this).find('#estatus').val();
			var predio 	=  $(this).find('#predio').val();
			var piso 	=  $(this).find('#piso').val();
			var medida	=  $(this).find('#medida').val();
			var uso_local =  $(this).find('#uso_local').val();
			var intelisis_ref 	=  $(this).find('#intelisis_ref').val();
			if( !tipo || !estatus || !predio || !piso || !medida || !marca){
				alert("Favor de ingresar todos los valores");
				return false;
			}
			$.ajax({
				data : {
						'marca'		:marca,
						'inmueble_id' :inmueble_id,
						'tipo'		:tipo,
						'estatus'	:estatus,
						'predio'	:predio,
						'piso'		:piso,
						'medida'	:medida,
						'uso_local'	:uso_local,
						'intelisis_ref' :intelisis_ref},
				dataType : 'json',
				url : ajax_url + 'guardar_local_intelisis',
				type : 'post',
				success : function(response) {
					location.reload();
				}
			});
		});
		
		$('.predio').change(function(){

			var $this = $(this);
			var predio_id = $(this).val();
			var piso = $this.parent().next().children('.piso');
			piso.empty();
			$.ajax({
				data : {'predio_id':predio_id},
				dataType : 'json',
				url : ajax_url + 'trae_pisos_por_predio',
				type : 'post',
				success : function(response) {
				if($.isEmptyObject(response)){
						alert("Ocurrio un error, intentelo de nuevo");
					}else{
					    
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
