<h3 id="mainTit">Edición de gerentes de plaza</h3>

<div class="wrapList">
<div id="actions">
		<? if(($user['idrole'] == '9' and $user['email']=='brodriguez@apeplazas.com') | ($user['idrole'] == '1')):?>
        <a href="<?=base_url()?>dashboard/dashboardVendedores" title="Agregar vendedores" class="addSmall">
			<i class="iconPlus" ><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" ></i>
			<span >Agregar vendedores</span>
		</a>
         <? endif?>
        <br class="clear">
	</div><br>
		<div id="tab2" > 
           <table id="ventasDash">
				<tbody>
					<tr>
						<th >PLAZAS</th>
						<th >NOMBRE</th>
						<th >CORREO</th>
						<th ></th>
                        <th ></th>
						
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
						window.location.reload();
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
						window.location.reload();
					});
					</script>
                     
                     
          		<? endforeach; ?>
				<tbody>
          </table>
		<br class="clear">
	</div>
 </div>


