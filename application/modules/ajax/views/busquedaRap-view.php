<? if($referencias): ?>
<h1 id="titAva">Busqueda Avanzada</h1>
<table id="tablaAvan">
<thead>
  <tr>
    <th>Referencia</th>
    <th>Prospecto</th>
    <th>Email</th>
    <th>Seleccionar</th>
  </tr>
</thead>
<tbody>
  <? foreach($referencias as $row):?>
  <tr>
    <th><p><?=$row->rap;?></p></th>
    <th><p><?= $row->pnombre;?> <?= $row->snombre;?> <?= $row->apellidop;?> <?= $row->apellidom;?></p></th>
    <th><p><?=$row->correo;?></p></th>
    <th><p><button id="agregar_rap">Seleccionar</button></p></th>
  </tr>
  <?endforeach; ?>
</tbody>
</table>
<script>
$(document).ready(function(){
	$('#agregar_rap').click(function(e){
		e.preventDefault();
		alert($('#plazaId').val());
	});
});
</script>
<?else:?>
<p id="msgAva">No hay coincidencias.</p>
<br class="clear">
<?endif; ?>
