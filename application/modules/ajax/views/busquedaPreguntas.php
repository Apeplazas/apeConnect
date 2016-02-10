<? if($data): ?>
<table class="tablaPreg">
<tbody>
  <? foreach($data as $row):?>
  <tr id="<?=$row->preguntaID;?>">
    <th><p><?=$row->pregunta;?></p></th>
    <th><p><?=$row->categoria;?></p></th>
  </tr>
  <?endforeach; ?>
</tbody>
</table>
<?endif; ?>
<script type="text/javascript">
$('.tablaPreg tr').click(function(event){
  var info = $(this).text();
  $(this).parent().val(info);
});
</script>
