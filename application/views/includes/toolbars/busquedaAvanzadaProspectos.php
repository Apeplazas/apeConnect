<form id="busAvan">
  <strong>Lista de Prospectos por Vendedor</strong>
  <div id="firAvan">
  <fieldset>
    <label>Vendedor</label>
    <select class="change" id="ven" name="vendedor">
      <option value="" checked>Selecciona un vendedor</option>
      <? foreach($vendedores as $v):?>
      <option value="<?= $v->usuarioID;?>"><?= $v->nombreCompleto?></option>
      <? endforeach; ?>
    </select>
  </fieldset>
  <fieldset>
    <span>
      <i><img src="<?=base_url()?>assets/graphics/svg/calendario.svg" width="14" alt="calendar"></i>
      <label>Fecha de creación | De</label>
      <input class="change" type="text" id="deFecPro" name="deFecPro" value="">
    </span>
    <span>
      <i><img src="<?=base_url()?>assets/graphics/svg/calendario.svg" width="14" alt="calendar"></i>
      <label>A</label>
      <input class="change" type="text" id="aFecPro" name="aFecPro" value="">
    </span>
  </fieldset>
  </div>
</form>

<div id="ajaxAva">

</div>

<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery-datepicker.css" type="text/css">
<script language="javascript" src="<?=base_url()?>assets/js/jquery-datepicker.js" type="text/javascript"></script>
<script>
$("#deFecPro, #aFecPro").datepicker({
    	dateFormat: 'yy-mm-dd',
    	changeMonth: true,
   		changeYear: true,
      yearRange: "-100:+0",
      numberOfMonths: 3,
      showCurrentAtPos: 2
});


$('.change').change(function(event){
  buscaProspectosVendedor();
});

$('.kUp, .change').keyup(function(event){
  buscaProspectosVendedor();;
});

function buscaProspectosVendedor(){

  var ven = $('#ven').val();
  var fechaDe = $('#deFecPro').val();
  var fechaA = $('#aFecPro').val();
  
  var alldata = {
    ven : ven,
    fechaDe : fechaDe,
    fechaA: fechaA,
   };

  $.post(ajax_url+"cargarResultadoProsVend", {
    alldata : alldata
  },

 function(data) { sucess:
	$("#tablaAvan, #infoAvaVen").remove();
  	$("#wraping").append(data);
  });
};
</script>
