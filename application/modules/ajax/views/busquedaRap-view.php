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
  <? foreach($referencias as $row): ?>
  <tr>
    <th><p><?=$row->rap;?></p></th>
    <th><p><?= $row->pnombre;?> <?= $row->snombre;?> <?= $row->apellidop;?> <?= $row->apellidom;?></p></th>
    <th><p><?=$row->correo;?></p></th>
    <th><p><button id="<?php echo $row->referencia_id;?>" class="agregar_rap">Seleccionar</button></p></th>
  </tr>
  <?endforeach; ?>
</tbody>
</table>
<script>
$(document).ready(function(){
	$('.agregar_rap').click(function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		$.post(ajax_url+"cargar_detalle_rap", {
			id : id
		}, function(data) {
				$("#plazaPiso option[value='"+data.piso+"']").prop('selected',true);
				$('#clientEmail').val(data.correo);
				$('#dirplaza').empty();
				$option = $("<option></option>")
				.attr("value", data.direccion)
				.text(data.direccion);
				$('#dirplaza').append($option);
				$('#localnum').val(data.locales);
		},'json');

	});
});
</script>
<?else:?>
<p id="msgRap">No hay coincidencias.</p>
<br class="clear">
<?endif; ?>