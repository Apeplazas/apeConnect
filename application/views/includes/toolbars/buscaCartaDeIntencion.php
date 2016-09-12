<?php
date_default_timezone_set('America/Mexico_City'); 

$today = date('Y-m-d') ;
$firstDateLMonth = date('Y-m-d',strtotime('first day of last month')) ;
$nextMonth= date('Y-m-d',strtotime('first day of next month')) ;
$lastMonth = date('Y-m-d',strtotime('last month')) ;
$thisMonth = date('Y-m-d',strtotime('first day of this month')) ;
// echo $thisMonth;
?>

<form id="busAvanDisplay">
  <strong>Búsqueda por fecha</strong>
  <div id="firAvan">
  <fieldset>
    <span>
      <i><img src="<?=base_url()?>assets/graphics/svg/calendario.svg" width="14" alt="calendar"></i>
      <label>Carta de Intencion| De</label>
      <input class="change" type="text" id="deFeccart" name="deFeccart" value="<?=$thisMonth?>">
    </span>
    <span>
      <i><img src="<?=base_url()?>assets/graphics/svg/calendario.svg" width="14" alt="calendar"></i>
      <label>A</label>
      <input class="change" type="text" id="aFeccart" name="aFeccart" value="<?=$today?>">
    </span>
  </fieldset>
  </div>
</form>

<div id="ajaxAva">

</div>

<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery-datepicker.css" type="text/css">
<script language="javascript" src="<?=base_url()?>assets/js/jquery-datepicker.js" type="text/javascript"></script>
<script>
$("#deFeccart, #aFeccart").datepicker({
    	dateFormat: 'yy-mm-dd',
    	changeMonth: true,
   		changeYear: true,
      yearRange: "-100:+0",
      numberOfMonths: 3,
      showCurrentAtPos: 2
});


$('.change').change(function(event){
  cuentaCartaDeIntencion();
});

function cuentaCartaDeIntencion(){

  var fechaDe = $('#deFeccart').val();
  var fechaA = $('#aFeccart').val();
  

  var alldata = {
    fechaDe : fechaDe,
    fechaA: fechaA,
   };

  $.post(ajax_url+"cargaResultadosCartaIntencion", {
    alldata : alldata
  },

 function(data) { sucess:
	$("#cartasIntencionDash").remove();
  	$("#aqui").append(data);
  });
};
</script>