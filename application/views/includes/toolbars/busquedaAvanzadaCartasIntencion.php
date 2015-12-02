<form id="busAvan">
  <strong>Filtros de busqueda avanzada</strong>
  <div id="firAvan">
  <fieldset>
    <label>Plaza</label>
    <select class="change" id="plaAja" name="plaza">
      <option value="" checked>Selecciona una plaza</option>
      <?foreach ($ci as $rowC): ?>
      <option value="<?=$rowC->plaza;?>"><?=$rowC->plaza;?></option>
      <?endforeach; ?>
    </select>
  </fieldset>
  <fieldset>
    <label>Gerente de plaza</label>
    <input class="kUp" type="text" id="gerAja" name="gerAja" value="">
  </fieldset>
  <fieldset>
    <label>Estatus</label>
    <select class="change" id="estAja" name="plaza">
      <option value="" checked>Estatus</option>
        <?foreach ($est as $varE): ?>
        <option value="<?=$varE->estado;?>"><?=$varE->estado;?></option>
        <?endforeach; ?>
    </select>
  </fieldset>
  </div>
  <div id="secAvan">
  <fieldset>
    <label>Cliente</label>
    <input class="kUp" type="text" id="cliAja" name="name" value="">
  </fieldset>
  <fieldset>
    <span>
      <i><img src="<?=base_url()?>assets/graphics/svg/calendario.svg" width="14" alt="calendar"></i>
      <label>De</label>
      <input class="change" type="text" id="deFecAka" name="deFecAja" value="">
    </span>
    <span>
      <i><img src="<?=base_url()?>assets/graphics/svg/calendario.svg" width="14" alt="calendar"></i>
      <label>A</label>
      <input class="change" type="text" id="aFecAja" name="aFecAja" value="">
    </span>
  </fieldset>
  </div>
</form>

<div id="ajaxAva">

</div>

<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery-datepicker.css" type="text/css">
<script language="javascript" src="<?=base_url()?>assets/js/jquery-datepicker.js" type="text/javascript"></script>
<script>
$("#aFecAja, #deFecAka").datepicker({
    	dateFormat: 'yy-mm-dd',
    	changeMonth: true,
   		changeYear: true,
      yearRange: "-100:+0",
      numberOfMonths: 3,
      showCurrentAtPos: 2
});


$('.change').change(function(event){
  buscaResultados();
});

$('.kUp, .change').keyup(function(event){
  buscaResultados();
});

function buscaResultados(){

  var plaza = $('#plaAja').val();
  var cliente = $('#cliAja').val();
  var gerente = $('#gerAja').val();
  var estatus = $('#estAja').val();
  var fechaDe = $('#deFecAka').val();
  var fechaA = $('#aFecAja').val();

  $.post(ajax_url+"cargarResultadoCartas", {
    alldata : {
    plaza : plaza,
    cliente : cliente,
    gerente : gerente,
    estatus : estatus,
    fechaDe : fechaDe,
    fechaA : fechaA
    }
  },

  function(data) { sucess:
    $("#tablaproveed_wrapper").hide();

  $("#ajaxAva").empty().append(data);

  });
};
</script>
