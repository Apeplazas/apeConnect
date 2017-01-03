<h3 id="mainTit">Lista de Vendedores y Gerentes de Plaza</h3>
<div class="wrapList">
	
	<div id="actions">
		
	</div>

  <div id="tab2" >
    
      <table id="ventasDash">
          <tbody>
              <tr> 
                  <th>Nombre</th>
                  <th>Puesto</th> 
                  <th>PLaza</th>
                  <th>Jefe directo</th> 
              </tr>  
          
              <?php foreach($empleados as $rowO):?>
                  <tr>
                      <td><a> <?=$rowO->nombreCompleto;?> </a></td>
                      <td>
                      <select name="rol" id="rol"/>
					  	<option value="GERENTE PLAZA" <?php if( isset($rowO->nombre) && $rowO->idrole == '5' ) echo 'selected'?>>GERENTE PLAZA</option>
                        <option value="EJECUTIVO DE VENTAS" <?php if( isset($rowO->nombre) && $rowO->idrole == '8' ) echo 'selected'?>>EJECUTIVO DE VENTAS</option>
                        <option value="SUPERVISOR VENTAS" <?php if( isset($rowO->nombre) && $rowO->idrole == '9' ) echo 'selected'?>>SUPERVISOR VENTAS</option>
                      </td>
                      <? if ($rowO->idrole == '5'):?>
                      	<? $encargado   = $this->rh_model->encargadoPlaza($rowO->usuarioID);?>
                        <?php foreach($encargado as $row):?>
                      			<td><a> <?= $row->Nombre;?></a></td>
                           
                        <? endforeach; ?>
                      <? else:?>
                      	<td> </td>
                      <? endif;?>
                      
                       <? if(($rowO->idrole == '5' or $rowO->idrole == '8') and ($rowO->jefeDirectoID != '' or $rowO->jefeDirectoID != NULL)): ?>
                     	<? $supervisor   = $this->rh_model->supervisores($rowO->jefeDirectoID);?>
                        <?php foreach($supervisor as $raw):?>
                        	<td><a> <?= $raw->nombreCompleto ?></a>
                            
                            </td>
                        <? endforeach; ?>
                       <? endif;?>
                  </tr>
               <? endforeach; ?>
          </tbody> 
      </table>      
	</div>
	<br class="clear">
   

	
</div>