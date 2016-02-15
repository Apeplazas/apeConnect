<?foreach ($usuarioCalificar as $evaluado): ?>
<form action="<?=base_url()?>evaluaciones/guardarCampaniaEvaluacion" method="post" id="guardarForm">
<div id="mainTit">
  <h3>Agrega tu evaluación</h3>
</div>
<div class="wrapList">
	<div id="actions">
    <span class="back">
     <a class="addSmall" href="javascript:window.history.go(-1);">
       <i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/back.svg" alt="Regresar"></i>
       <span>Regresar</span>
     </a>
    </span>
  </div>
  <div class="wrapListFormThree" id="contentEva">
    <div id="steps">
  	<section>
    <div id="colabora">
        <div class="blueHead">Seleccion de evaluadores</div>
        <div id="wrapColabora">
        <div class="span">
        <b>Calificador</b>
        <input id="busColOne" class="kUpOne" type="text" value="">
        <input id="busColOneHide" type="hidden" name="colQCalif[]" value="">
        </div>
        <div class="span">
          <b>Sera calificado</b>
          <input id="busColTwo" disabled class="kUpTwo" type="text" value="<?=$evaluado->nombreCompleto;?>">
          <input type="hidden" disabled name="usuarioIDCalificar" value="<?=$evaluado->usuarioID;?>">
          <input id="busColTwoHide" type="hidden" name="colACalif[]" value="">
        </div>
        <div class="span">
            <div id="clickAdd" class="addSmallGrayBot">
              <i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Agregar Recibo"></i>
    				  <span>Agregar Grupo</span>
    			  </div>

        </div>
      <br class="clear">

      <div id="ajaxUsu"></div>
      <div id="forAjaTwo">
        <strong class="none">Define las preguntas al colaborador</strong>
      </div>
      <div id="busFinal">
        <span id="formPre">
        <a href="<?=base_url()?>ajax/agregaPreguntasEvaluacion" id="sCTip" title="1" class="addPreg addSmallGrayBot">
    				<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Agregar Pregunta"></i>
    				<span>Agregar Pregunta</span>
    			</a>
        </span>
      </div>

    </div>
    <input id="finEvaCol" class="mainBotton none" type="submit" value="Finalizar">
    </section>
		<br class="clear">

	</div>


</div>



</form>
<?endforeach; ?>



<script type="text/javascript">
  $('.kUpOne').keyup(function(event){
    buscaUsuariosCalifica();
  });

  function buscaUsuariosCalifica(){
    var alldata = $('#busColOne').val();

    $.post(ajax_url+"cargarUsuarios", {
      alldata : alldata
    },

    function(data) { sucess:
      $("#ajaxUsu").empty().append(data);
    });
  };
  function buscaUsuariosAcalificar(){
    var alldata = $('#busColTwo').val();

    $.post(ajax_url+"cargarUsuariosAcalificar", {
      alldata : alldata
    },

    function(data) { sucess:
      $("#ajaxUsu").empty().append(data);
    });
  };
</script>
<script type="text/javascript">
$("#clickAdd").click(function(){
  var califica = $('#busColOne').val();
  var acalificar = $('#busColTwo').val();
  var calificaID = $('#busColONe').attr('data-text');
  var acalificaID = $('#busColTwo').attr('data-text');

  if(califica){
      $("#busFinal").append('<div class="agreCali"><a href="#" class="rem"></a><input type="hidden" value="'+califica+'"/> <i>'+califica+'</i><em>Calificara a</em><input type="hidden" name="caliID[]" value="'+calificaID+'"/><input type="text" value="'+acalificar+'"/> <input type="hidden" name="calificacoID[]" value="'+acalificaID+'"/></div>');
      $("#formPre").addClass("show");
      $("#busFinal").addClass("p46");
      $( "#tablaUsu" ).empty();
      $('#busColOne').val('');
  }else{
    alert('No ha escogido a ningun colaborador que participe en su encuesta');
    $( "#tablaUsu" ).empty();
    $('#busColOne').val();
  }

  $(".rem").click(function(event){
    event.preventDefault();
  });
});
</script>
<script type="text/javascript">
$('.addPreg').click(function(){
  event.preventDefault();
  var call = $(this).attr('href');
  var value = $(this).attr('title');
  var tthis = $(this);

  $.ajax({
    data : {'value':value},
    dataType : 'json',
    url : call,
    type : 'post',
    success : function(data) {
      $('#forAjaTwo').append(data);
      $('#forAjaTwo strong').addClass("show");
      $('#finEvaCol').addClass("show");
    }
  });
});
</script>
