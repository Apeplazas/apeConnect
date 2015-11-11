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
      <td><input type="text" name="terminal[digitos][]" value="" class="bigInp soloLetras" required /></td>
      <td class="grayField"><label>Numero de autorización</label></td>
      <td><input type="text" class="bigInp" name="terminal[numero][]" value="" required /></td>
    </tr>
    <tr>
      <td class="grayField"><label>Fecha de pago</label></td>
      <td><input type="text" name="terminal[fecha][]" value="" class="bigInp fechaTernimal" required /></td>
      <td class="grayField"><label>Importe</label></td>
      <td><input type="text" name="terminal[importe][]" value="" class="bigInp soloNumeros" required /></td>
    </tr>
    <tr>
      <td class="grayField"><label>Comprobante</label></td>
      <td><input type="file" class="bigInp" name="terminal[comprobante][]" required=""></td>
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
  
  $(".fechaTernimal").datepicker({
    	dateFormat: 'yy-mm-dd',
    	changeMonth: true,
   		changeYear: true,
   		yearRange: "-100:+0"
   });
  
</script>