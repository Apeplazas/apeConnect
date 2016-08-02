<form id="busAvan">
  <strong>Filtros de busqueda avanzada</strong>
  <div id="firAvan">
    <label>Nombre Del Usuario</label>
    <input class="kUp" type="text" id="nomAja" name="nomAja" value="">
  </fieldset>
  </div>
  <div id="secAvan">
  <fieldset>
    <label>Email</label>
    <input class="kUp" type="emial" id="emailAja" name="emailAja" value="">
  </fieldset>
  </div>
</form>

<div id="ajaxAva">

</div>

<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery-datepicker.css" type="text/css">
<script language="javascript" src="<?=base_url()?>assets/js/jquery-datepicker.js" type="text/javascript"></script>
<script>

$('.change').change(function(event){
  buscaResultados();
});

$('.kUp, .change').keyup(function(event){
  buscaResultados();
});

function buscaResultados(){

  var nombreCompleto = $('#nomAja').val();
  var email = $('#emailAja').val();

  $.post(ajax_url+"cargarResultadoUsuarios", {
    nombreCompleto : nombreCompleto,
    email : email
  },

  function(data) { sucess:
    $("#tablaproveed_wrapper").hide();

  	$("#ajaxAva").empty().append(data);
  });
};
</script>
