<div id="dataPro">
<table>
  <thead>
    <tr><th colspan="5">Busqueda de prospectos</th></tr>
  </thead>
  <tbody>
  <? foreach($data as $rowE):?>
  <tr>
    <td><p><?= $rowE->folio;?></p></td>
    <td><p><?= $rowE->pnombre;?> <?= $rowE->apellidop;?> <?= $rowE->apellidom;?></p></td>
    <td><p><i><?= $rowE->correo;?></i></p></td>
    <td><p>Cotizaciones: <?= $rowE->cantidad;?></p></td>
    <td><a class="callId" href="<?=base_url()?>ajax/cargarResultado/<?= $rowE->prospectoID;?>"><span class="addSmallGray">Ver cotización</span></a></td>
  </tr>
  <? endforeach; ?>
  </tbody>
</table>
  <div id="cotiInfo"></div>
</div>
<script type="text/javascript">
  $('.callId').click(function(event){
    event.preventDefault()
    $("#dataPro table").hide();
    var url = $(this).attr('href');
    $.ajax({
			url : url,
			success : function(response) {
        $('#cotiInfo').html(response);
			}
		});
  });
</script>
