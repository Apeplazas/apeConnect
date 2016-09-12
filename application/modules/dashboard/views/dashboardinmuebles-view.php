<h3 id="mainTit">Dashboard Ventas</h3>
<div id="actions" style="top: 160px;">
		<a href="<?=base_url()?>administrador/verUsuarioPros" title="Agregar Contactos" class="addSmall">
			<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Agregar Prospecto"></i>
			<span>Agregar Usuarios Prospectos</span>
		</a>
        <a href="<?=base_url()?>dashboard/dashboardInmuebles" title="Agregar Contactos" class="addSmall">
			<i class="iconPlus" ><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" ></i>
			<span >Agregar encargado plaza</span>
		</a>
	</div><br><br><br><br><br><br><br><br>

		<div id="aqui" > 
           <table id="ventasDash">
				<tbody>
					<tr>
						<th class="tcenter">PLAZAS</th>
						<th class="tcenter">NOMBRE</th>
						<th class="tcenter">CORREO</th>
						<th class="tcenter"></th>
                        <th class="tcenter"></th>
						
					</tr>
				
                <? foreach($plazas as $l):?>
                
					<tr>
                 		
                 		<td ><?= $l->Nombre ?></td>
                        <td ><?= $l->nombreCompleto ?></td>
                        <td ><?= $l->email ?></td>
                        <? if($l->nombreCompleto == '' | $l->nombreCompleto == NULL){?>
                        <td width="5%"><select id="<?= $l->Inmueble ?>">
                        <option value=''>Seleccione una opción</option>
                        <? foreach($usu as $i):?>
                        <option value="<?= $i->usuarioID;?>"><?= $i->nombreCompleto ?></option>
                        <? endforeach; ?>
                        </select></td>
                        <? }else{?>
                        <td align="center" width="5%"><a id="e<?= $l->Inmueble?>">ELIMINAR</a></td>
                        <? }?>
                     </tr>
                     
                     <script>
					$('select#<?= $l->Inmueble ?>').on('change',function(){
						var valor = $(this).val();
						var Inmueble	= '<?= $l->Inmueble;?>';
						
						if(valor==''){
							alert('Elija un valor valido')
							
						}else{$.post('<?=base_url()?>ajax/asignarInmueble', {
										usuario_id : valor,
										Inmueble : Inmueble
						},'json');
						alert('Asignacion exitosa');
						}
					});
					</script>
                     <script>
					$('#e<?= $l->Inmueble?>').click(function(){
						var Inmueble	= '<?= $l->Inmueble;?>';
						
						$.post('<?=base_url()?>ajax/desasignarInmueble',{
										Inmueble : Inmueble
						},'json');
						alert('Inmueble desasignado');
						
					});
					</script>
                     
                     
          		<? endforeach; ?>
				<tbody>
          </table>
		<br class="clear">
	</div>


