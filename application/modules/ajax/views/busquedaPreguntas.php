<? if($data): ?>
<table class="tablaPreg">
<tbody>
  <? foreach($data as $row):?>
  <tr id="<?=$row->preguntaID;?>">
    <th><p><?=$row->pregunta;?></p></th>
    <th><em><?=$row->categoria;?></em></th>
  </tr>
  <?endforeach; ?>
</tbody>
</table>
<?endif; ?>
<script type="text/javascript">
$('.tablaPreg tr').click(function(){
  var info = $(this).find('p').text();
  $(this).parent().parent().siblings('input').val(info);
  $( ".tablaPreg" ).remove();
});
$('html').click(function(){
  $( ".tablaPreg" ).remove();
});
</script>
