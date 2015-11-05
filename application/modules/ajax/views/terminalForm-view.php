<fieldset class="dataInf">
<img class="closeData" src="<?=base_url()?>assets/graphics/svg/close.svg" alt="Cerrar" />
<table>
  <thead>
    <tr>
      <th colspan="4">Agrega la información del voucher</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="grayField"><label>Cuatro ultimos digitos de la tarjeta</label></td>
      <td><input type="text" name="" value="" class="bigInp soloLetras"></td>
      <td class="grayField"><label>Numero de autorización</label></td>
      <td><input type="text" class="bigInp" name="name" value=""></td>
    </tr>
    <tr>
      <td class="grayField"><label>Fecha de pago</label></td>
      <td><input type="text" name="" value="" class="bigInp"></td>
      <td class="grayField"><label>Importe</label></td>
      <td><input type="text" name="" value="" class="bigInp"></td>
    </tr>
    <tr>
      <td class="grayField"><label>Comprobante</label></td>
      <td><input type="file" class="bigInp" name="" required=""></td>
    </tr>
  </tbody>
</table>
</fieldset>

<script type="text/javascript">
  $('.closeData').click(function(){
    $(this).parent().remove();
    //Si no contiene esa clase enseña el div
    if ($('.dataInf').length <= 0) {
      $('.msgForm').removeClass('hide');
    }
  });
</script>
