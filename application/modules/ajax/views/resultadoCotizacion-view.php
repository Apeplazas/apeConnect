
<h1>Busqueda de prospecto</h1>
<? foreach($data as $rowE):?>
<p><em><?= $rowE->folio;?> <?= $rowE->prospectoID;?> <?= $rowE->vigencia;?></em> <i><?= $rowE->correo;?></i></p>
<? endforeach; ?>
