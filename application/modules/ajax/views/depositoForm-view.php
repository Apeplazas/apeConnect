<fieldset class="dataInf">
<img class="closeData" src="<?=base_url()?>assets/graphics/svg/close.svg" alt="Cerrar" />
<table>
  <thead>
    <tr>
      <th colspan="4">Agrega la información de deposito</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="grayField"><label>Nombre de cuenta deposito</label></td>
      <td><input type="text" name="depositos[cuenta][]" value="" class="bigInp soloLetras" required /></td>
      <td class="grayField"><label>Numero de cuenta</label></td>
      <td><input type="text" class="bigInp" name="depositos[numero][]" value="" required /></td>
    </tr>
    <tr>
      <td class="grayField"><label>Fecha de pago</label></td>
      <td><input type="text" name="depositos[fecha][]" value="" class="bigInp fechaDeposito" required /></td>
      <td class="grayField"><label>Numero de movimiento</label></td>
      <td><input type="text" class="bigInp" name="depositos[movimiento][]" value="" required /></td>
    </tr>
    <tr>
      <td class="grayField"><label>Importe</label></td>
      <td><input type="text" name="depositos[importe][]" value="" class="bigInp soloNumeros" required /></td>
      <td class="grayField"><label>Comprobante</label></td>
      <td><input type="file" class="bigInp" name="depositos[comprobante][]" required=""></td>
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
  
  $(".fechaDeposito").datepicker({
    	dateFormat: 'yy-mm-dd',
    	changeMonth: true,
   		changeYear: true,
   		yearRange: "-100:+0"
   });
  
</script>
