<? if($data): ?>
<h1 id="titAva">Busqueda Avanzada</h1>
<table id="tablaAvan">
<thead>
  <tr>
    <th>Folio</th>
    <th>Cliente</th>
    <th>Plaza</th>
    <th>Usuario</th>
    <th>Deposito</th>
    <th>Estatus</th>
  </tr>
</thead>
<tbody>
  <? foreach($data as $row):?>
  <tr>
    <th><p><?=$row->folio;?></p></th>
    <th><p><?= $row->pnombre;?> <?= $row->snombre;?> <?= $row->apellidopaterno;?> <?= $row->apellidomaterno;?></p></th>
    <th><p><?=$row->plaza;?></p></th>
    <th><p><?=$row->nombreCompleto;?></p></th>
    <th><p><?=$row->deposito;?></p></th>
    <th>
    	<p>
    		<a class="mt10" href="<?=base_url()?>tempciri/detalleCi/<?= $row->cartaIntId;?>" >
    			<?=$row->estado;?>
    		</a>
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
