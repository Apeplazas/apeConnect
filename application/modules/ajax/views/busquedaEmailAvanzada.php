<? if($data): ?>
<h1 id="titAva">Busqueda Avanzada</h1>
<table id="tablaAvan">
<thead>
  <tr>
    <th>Nombre Usuario</th>
    <th>Plaza</th>
    <th>status</th>
  </tr>
</thead>
<tbody>
  <? foreach($data as $row):?>
  <tr>
    <th><p><?=$row->nombreCompleto;?></p></th>
    <th><p><?=$row->plaza;?></p></th>
    <th>
    <p>
      <a class="mt10" href="<?=base_url()?>administrador/detalleUsua">
      <?=$row->status;?>
    </p>
    </th>
  </tr>
  <?endforeach; ?>
</tbody>
</table>
<?else:?>
<p id="msgAva">No tenemos ningún dato con la información proporcionada</p>
<br class="clear">
<?endif; ?>
