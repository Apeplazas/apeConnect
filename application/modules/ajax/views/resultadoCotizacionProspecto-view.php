
<form action="<?=base_url()?>tempCiri/ciriVarias" method="post">
<button id="bac"><img src="<?=base_url()?>assets/graphics/svg/regresarDos.svg" alt="regresar"></button>
<h3>Lista de cotizaciones</h3>
<span id="headCot">
  <strong>Folio</strong>
  <em>Ciudades:</em>
  <i>Vendedor</i>
</span>
  <ul>
    <? foreach ($data as $var): ?>
    <li>
      <p class="styLi">
        <b class="fleAba"></b>
        <strong><?= $var->folio?></strong>
        <em> <?= $var->ciudades?></em>
        <i><?= $var->nombreCompleto?></i>
        <a class="cotID" href="<?=base_url()?>ajax/cargarLocalesBusquedaRapida/<?= $var->cotizacionID?>"></a>
    </p>
    <? $cotizacion = $this->prospectos_model->cargaLocalesCotizacion($var->cotizacionID);?>
    <ul class="prosCoti">
      <?foreach ($cotizacion as $varA):?>
      <li title="<?=$varA->claveLocal;?>">
        <b class="checkInp"><input type="checkbox" name="boxCheca[]" value="<?= $varA->id?>"></b>
        <p>
          <?=$varA->claveLocal;?> - <?=$varA->nombreLocal;?> - <?=$varA->localPrecio;?>
        </p>
      </li>
      <?php endforeach; ?>
    </ul>

    </li>
    <?endforeach; ?>
  </ul>
  <input type="submit" class="mainBotton m10" value="Generar"/>
</form>

<script type="text/javascript">
$('#bac').click(function(){
  $('#dataPro table').show();
  $('#cotiInfo').empty();
});

$('.styLi').click(function(){
  $(this).siblings('ul').toggle();
});


$('.prosCoti li').click(function () {
  if ($(this).find('input:checkbox').is(":checked")) {
    $(this).find('input:checkbox').attr("checked", false);
  }
  else {
  //// Agrega el valor al input escondido para despues mandar a un proceso diferente
  $(this).find('input:checkbox').prop("checked", true);
  }
});
 $('input[type=checkbox]').click(function (e) {
     e.stopPropagation();
 });
</script>
