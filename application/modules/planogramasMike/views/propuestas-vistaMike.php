<div id="mainTit"><br>
	<h3>Renovación de locales</h3>
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
	<table class="thbr" id="tablaPlano" >
    <h1>PRIMER CUATRIMESTRE</h1>
		<thead>
			<tr>
				<th>GRUPO</th>
				<th>LOCAL</th>
				<th>RANGOS PROPUESTOS</th>
                <th>DESCUENTO</th>
				<th>MONTO DE RENOVACIÓN</th>
                <th>ESTATUS</th>
                
			</tr>
		</thead>
		<tbody>
       
        
        
			<? foreach($grupo as $row):?>
            <? if($row->periodo =='q1'){ ?>
            <? $var= 'autorizado'.$row->nombre;?> 
            <? $elim= $row->nombre;?>
            
				<tr class="plaza">
					<th align="center" width="15%"><?= $row->nombre;?></th>
                    
					<th align="center" width="10%">
                    <ul>
                    <? $list = $this->planogramas_modelMike->localesGrupos($row->nombre);?>
                    <? foreach($list as $l):?>
                    	<a href="<?=base_url()?>planogramasMike/verplanoEditar/<?= $l->plazaId;?>"><?= $l->id;?></a>
                    <? endforeach; ?>
                    </ul>
                    </th>
					<th align="center"> de  $ <?= $row->minimo;?>  a  $ <?= $row->maximo;?></th>
                    <th align="center"> $ <?= $row->descuento;?></th>
					<th align="center"> $ </th>
                    <th align="center"> <button id="<? echo $var ?>">AUTORIZAR</button><br>
                    <?= $row->status;?></th>
                    <th align="center"> 
                    <a id="<? echo $elim ?>">Eliminar</a>
                    </th>
				</tr>
                <script>
				$("#<? echo $var?>").click(function() {
				  var status  = 'autorizado';
				  var nombre	= '<?= $row->nombre;?>';
				  
				  $.post("<?=base_url()?>ajax/statusGrupo",
					  { 
					  status : status,
					  nombre : nombre
				  },'json');
				 location.reload();
				});
				</script>
                
                <script>
				$("#<? echo $elim?>").click(function() {
				  var nombre	= '<?= $row->nombre;?>';
				  var id	= '<?= $row->id;?>';
				  var minimo	= '<?= $row->minimo;?>';
				  var maximo	= '<?= $row->maximo;?>';
				  var descuento	= '<?= $row->descuento;?>';
				  var status	= '<?= $row->status;?>';
				  var periodo	= '<?= $row->periodo;?>';
				  
				  $.post("<?=base_url()?>ajax/eliminarGrupo",
					  { 
					  nombre : nombre,
					  id	:	id,
					  minimo	:	minimo,
					  maximo	:	maximo,
					  descuento	:	descuento,
					  status	:	status,
					  periodo	:	periodo
				  },'json');
				 location.reload();
				});
				</script>
                
                 <? }?>
				<? endforeach; ?>
		</tbody>
	</table><br><br><br>
   
   
   
   <table class="thbr" id="tablaPlano" >
    <h1>SEGUNDO CUATRIMESTRE</h1>
		<thead>
			<tr>
				<th>GRUPO</th>
				<th>LOCAL</th>
				<th>RANGOS PROPUESTOS</th>
                <th>DESCUENTO</th>
				<th>MONTO DE RENOVACIÓN</th>
                <th>ESTATUS</th>
                
			</tr>
		</thead>
		<tbody>
       
        
        
			<? foreach($grupo as $row):?>
            <? if($row->periodo =='q2'){ ?>
            <? $var= 'autorizado'.$row->nombre;?> 
            <? $elim= $row->nombre;?>
				<tr class="plaza">
					<th align="center" width="15%"><?= $row->nombre;?></th>
                    
					<th align="center" width="10%">
                    <ul>
                    <? $list = $this->planogramas_modelMike->localesGrupos($row->nombre);?>
                    <? foreach($list as $l):?>
                    	<a href="<?=base_url()?>planogramasMike/verplanoEditar/<?= $l->plazaId;?>"><?= $l->id;?></a>
                    <? endforeach; ?>
                    </ul>
                    </th>
					<th align="center"> de  $ <?= $row->minimo;?>  a  $ <?= $row->maximo;?></th>
                    <th align="center"> $ <?= $row->descuento;?></th>
					<th align="center"> $ </th>
                    <th align="center"> 
                    <button id="<? echo $var ?>">AUTORIZAR</button><br>
                    <?= $row->status;?>
                    </th>
                    <th align="center"> 
                    <a id="<? echo $elim ?>">Eliminar</a>
                    </th>
                    
				</tr>
                <script>
				$("#<? echo $var?>").click(function() {
				  var status  = 'autorizado';
				  var nombre	= '<?= $row->nombre;?>';
				  
				  $.post("<?=base_url()?>ajax/statusGrupo",
					  { 
					  status : status,
					  nombre : nombre
				  },'json');
				 location.reload();
				});
				</script>
                <script>
				$("#<? echo $elim?>").click(function() {
				  var nombre	= '<?= $row->nombre;?>';
				  var id	= '<?= $row->id;?>';
				  var minimo	= '<?= $row->minimo;?>';
				  var maximo	= '<?= $row->maximo;?>';
				  var descuento	= '<?= $row->descuento;?>';
				  var status	= '<?= $row->status;?>';
				  var periodo	= '<?= $row->periodo;?>';
				  
				  $.post("<?=base_url()?>ajax/eliminarGrupo",
					  { 
					  nombre : nombre,
					  id	:	id,
					  minimo	:	minimo,
					  maximo	:	maximo,
					  descuento	:	descuento,
					  status	:	status,
					  periodo	:	periodo
				  },'json');
				 location.reload();
				});
				</script>
                 <? }?>
				<? endforeach; ?>
		</tbody>
	</table><br><br><br>
    
    
    
    <table class="thbr" id="tablaPlano" >
    <h1>TERCER CUATRIMESTRE</h1>
		<thead>
			<tr>
				<th>GRUPO</th>
				<th>LOCAL</th>
				<th>RANGOS PROPUESTOS</th>
                <th>DESCUENTO</th>
				<th>MONTO DE RENOVACIÓN</th>
                <th>ESTATUS</th>
                
			</tr>
		</thead>
		<tbody>
       
        
        
			<? foreach($grupo as $row):?>
            <? if($row->periodo =='q3'){ ?>
            <? $var= 'autorizado'.$row->nombre;?> 
            <? $elim= $row->nombre;?>
				<tr class="plaza">
					<th align="center" width="15%"><?= $row->nombre;?></th>
                    
					<th align="center" width="10%">
                    <ul>
                    <? $list = $this->planogramas_modelMike->localesGrupos($row->nombre);?>
                    <? foreach($list as $l):?>
                    	<a href="<?=base_url()?>planogramasMike/verplanoEditar/<?= $l->plazaId;?>"> <?= $l->id;?></a>
                    <? endforeach; ?>
                    </ul>
                    </th>
					<th align="center"> de  $ <?= $row->minimo;?>  a  $ <?= $row->maximo;?></th>
                    <th align="center"> $ <?= $row->descuento;?></th>
					<th align="center"> $ </th>
                    <th align="center"> 
                    <button id="<? echo $var ?>">AUTORIZAR</button><br>
                    <?= $row->status;?>
                    </th>
                    
                 
                 	<th align="center"> 
                    <a id="<? echo $elim ?>">Eliminar</a>
                    </th>
                    
				</tr>
                <script>
				$("#<? echo $var?>").click(function() {
				  var status  = 'autorizado';
				  var nombre	= '<?= $row->nombre;?>';
				  
				  $.post("<?=base_url()?>ajax/statusGrupo",
					  { 
					  status : status,
					  nombre : nombre
				  },'json');
				 location.reload();
				});
				</script>
                
				<script>
				$("#<? echo $elim?>").click(function() {
				  var nombre	= '<?= $row->nombre;?>';
				  var id	= '<?= $row->id;?>';
				  var minimo	= '<?= $row->minimo;?>';
				  var maximo	= '<?= $row->maximo;?>';
				  var descuento	= '<?= $row->descuento;?>';
				  var status	= '<?= $row->status;?>';
				  var periodo	= '<?= $row->periodo;?>';
				  
				  
				  $.post("<?=base_url()?>ajax/eliminarGrupo",
					  { 
					  nombre : nombre,
					  id	:	id,
					  minimo	:	minimo,
					  maximo	:	maximo,
					  descuento	:	descuento,
					  status	:	status,
					  periodo	:	periodo,
					 
				  },'json');
				 location.reload();
				});
				</script>
                 <? }?>
				<? endforeach; ?>
		</tbody>
	</table><br><br><br>
    
	<br class="clear">
	</div>

</div>



