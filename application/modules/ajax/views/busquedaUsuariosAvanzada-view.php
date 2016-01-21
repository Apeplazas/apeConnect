<? if($data): ?>
<table id="tablaUsu">
<tbody>
  <? foreach($data as $row):?>
  <tr class="addID" data-text="<?=$row->nombreCompleto;?>" title="<?=$row->usuarioID;?>">
    <th><p><?=$row->nombreCompleto;?></p></th>
    <th><p><?=$row->email;?></p></th>
    <th><p><?=$row->puesto;?></p></th>
  </tr>
  <tr>
    <th>

    </th>
  </tr>
  <?endforeach; ?>
</tbody>
</table>
<?else:?>
<p id="msgAva">No tenemos ningun usuario con esos datos.</p>
<br class="clear">
<?endif; ?>
<script type="text/javascript">
$(document).ready(function(){
  $('.addID').click(function(){
    var id = $(this).attr('title');
    var text = $(this).attr('data-text');

    $('#busColOne').val(text);
    $('#busColONe').attr('id', id);
    $( "#ajaxUsu" ).empty();
  });
});

</script>
