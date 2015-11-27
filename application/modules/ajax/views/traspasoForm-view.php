<fieldset class="dataInf">
<img class="closeData" src="<?=base_url()?>assets/graphics/svg/close.svg" alt="Cerrar" />
<table>
  <thead>
    <tr>
      <th colspan="4">Agrega la información de traspaso</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="grayField"><label>Nombre de cuenta deposito</label></td>
      <td><input type="text" name="traspaso[cuenta][]" value="" class="bigInp soloLetras" required /></td>
      <td class="grayField"><label>Ultimos cuatro digitos de cuenta</label></td>
      <td><input type="text" class="bigInp" name="traspaso[digitos][]" value="" required /></td>
    </tr>
    <tr>
      <td class="grayField"><label>Fecha de pago</label></td>
      <td><input type="text" name="traspaso[fecha][]" value="" class="bigInp fechaTraspaso" required /></td>
      <td class="grayField"><label>Numero de autorización</label></td>
      <td><input type="text" class="bigInp" name="traspaso[numero][]" value="" required /></td>
    </tr>
    <tr>
      <td class="grayField"><label>Importe</label></td>
      <td><input type="text" name="traspaso[importe][]" value="" class="bigInp soloNumeros" required /></td>
      <td class="grayField"><label>Clave de Rastreo</label></td>
      <td><input type="text" class="bigInp" name="traspaso[clave][]" value="" required /></td>
    </tr>
    <tr>
      <td class="grayField"><label>Comprobante</label></td>
      <td><input type="file" class="bigInp" name="traspaso[comprobante][]" required=""></td>
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
  
  $(".fechaTraspaso").datepicker({
    	dateFormat: 'yy-mm-dd',
    	changeMonth: true,
   		changeYear: true,
   		yearRange: "-100:+0"
   });
   
   //// Solo permite numeros en los inputs de telefonos y numericos
    $(".soloNumeros").keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            (e.keyCode == 65 && e.ctrlKey === true) ||
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
  
  
</script>
