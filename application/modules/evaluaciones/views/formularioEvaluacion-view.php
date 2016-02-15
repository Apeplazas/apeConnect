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
  	<h6>Datos de Evaluacion</h6>
  	<section>

    <div class="wrapListForm" id="wrapListForm1">
    <table>
		  <thead>
			<tr>
				<th colspan="4">Datos personales</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
				<td class="grayField" colspan="1">
          <strong><span class="obli">*</span>Nombre de evaluación</strong>
        </td>
				<td colspan="3"><input type="text" class="bigInp" name="campaniaNombre" required></td>
			</tr>
			<tr>
				<td class="grayField"><strong><span class="obli">*</span>Fecha inicia</strong></td>
				<td><i class="calen"><img src="<?=base_url()?>assets/graphics/svg/calendario.svg" width="14" alt="calendar"></i><input type="text" class="bigInp datePick" name="fechaInicio" value=""></td>
				<td class="grayField"><strong><span class="obli">*</span>Fecha limite</strong></td>
				<td><i class="calen"><img src="<?=base_url()?>assets/graphics/svg/calendario.svg" width="14" alt="calendar"></i><input class="bigInp datePick" type="text" name="fechaFin" value=""></td>
			</tr>
      </tbody>
    </table>
    <br class="clear">
    </div>



    <div class="wrapListForm" id="wrapListForm2">
  		<span class="secmainTit">Descriptivo de evaluación</span>
  		<div class="comenWrap">
        <input type="hidden" name="campaniaStatus" value="En Espera">
  	    <textarea class="texBig" name="campaniaDescripcion" value=""></textarea>
  		</div>
      <br class="clear">
  	</div>
  </section>
  <h6>Categorias y Preguntas</h6>
  <section>


    <div id="msgRecAgr">

      <div id="botRecAg">
  			<div id="sCTip" class="addSmallGrayBot">
  				<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Agregar Recibo"></i>
  				<span>Agregar Categoria</span>
  			</div>
  		</div>

			<div id="choTipEva">
				<span>
					<select id="catEvaList" name="categorias">
            <option value="0">Escoge una categoria</option>
            <?foreach ($cat as $var): ?>
            <option value="<?=$var->evaluacionCategoriaID;?>"><?=$var->categoriaNombre;?></option>
            <?endforeach; ?>
					</select>
          <a href="<?=base_url()?>ajax/addCategoriasEva" id="butEva" type="button" name="button">
					<img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Agregar Plaza"><b>Agregar</b></a>
          <p>Si no encuentra la categoria de su gusto, puede agregar una nueva <a href="#">aquí</a></p>
        <fieldset class="none">
          <input type="text" name="name" value="categoria">
        </fieldset>
				</span>
			</div>


      <script type="text/javascript">
      $("#colabSta").change(function(){
        $("#colabora").toggleClass("show");
      });



      $("#catEvaList").change(function(){
        var value = $(this).val()
        if(value != 0 ){
          $("#butEva").show();
        }
        else if(value == 0){
          $("#butEva").hide();
        }
      });

      $("#butEva").click(function(event){
        event.preventDefault();

        var call = $(this).attr('href');
        var value = $('#catEvaList').val();

        if ($('#forAja').find('#'+value).length > 0) {
          alert('Esta categoria ya ha sido dada de alta.');
        }
        else{
          $.ajax({
            data : {'value':value},
            dataType : 'json',
            url : call,
            type : 'post',
            success : function(data) {
              $('#forAja').append(data);
              $('#choTip').removeClass('show');
              $('.msgForm').addClass('hide');
              $("#catEvaList").val('0');
              $("#butEva").hide();
            }
          });
        }
      });
      </script>


      <div id="forAja"> </div>

			<span class="msgForm">
				<img src="<?=base_url()?>assets/graphics/alert.png" alt="Sin información">
				<p>No ha agregado categorias ni preguntas a esta evaluación.</p>
			</span>
			<br class="clear">
		</div>
  </section>
  <h6>Agregar personas a evaluación</h6>
  <section>
    <div class="wrapForm" id="wrapListForm3">
      <span class='secmainTit'>Tipo de esquema</span>
      <table>
      <tr id="tipForm">
        <td>
          <span class="none"><input type="checkbox" checked name="jefeDirecto"><em>Jefe Directo</em></span>
          <span><input id="colabSta" type="checkbox" name="colaboradores"><em>Colaborador vs Colaborador</em></span>
          <span class="none"><input checked type="checkbox" name="autoEval"><em>Autoevaluación</em></span>
        </td>
      </tr>
      </table>
      <br class="clear">


      <script type="text/javascript">
        $('.kUpOne').keyup(function(event){
          buscaUsuariosCalifica();
        });
        $('.kUpTwo').keyup(function(event){
          buscaUsuariosAcalificar();
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


    </div>

  <div id="colabora">

      <div class="blueHead">Buscar Colaborador</div>
      <div id="wrapColabora">
      <div class="span">
      <b>¿Quien quieres que califica?</b>
      <input id="busColOne" class="kUpOne" type="text" value="">
      <input id="busColOneHide" type="hidden" name="colQCalif[]" value="">
      </div>
      <div class="span">
        <b>¿A quien quieres que evalue?</b>
        <input id="busColTwo" class="kUpTwo" type="text" value="">
        <input id="busColTwoHide" type="hidden" name="colACalif[]" value="">
      </div>
      <div class="span">
          <div id="clickAdd" class="addSmallGrayBot">
            <i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Agregar Recibo"></i>
  				  <span>Agregar Categoria</span>
  			  </div>
      </div>
    <br class="clear">

    <div id="ajaxUsu"></div>
    <div id="busFinal"></div>

    <div id="sCTipCol" class="addSmallGrayBot">
      <i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Agregar Recibo"></i>
      <span id="pregCol">Agregar categoria para pregunta a colaborador</span>

      <div id="colPr">
        <span>
          <select id="catEvaList" name="categorias">
            <option value="0">Escoge una categoria</option>
            <?foreach ($cat as $var): ?>
            <option value="<?=$var->evaluacionCategoriaID;?>"><?=$var->categoriaNombre;?></option>
            <?endforeach; ?>
          </select>
          <a href="<?=base_url()?>ajax/addCategoriasEva" id="butEva" type="button" name="button">
          <img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Agregar Plaza"><b>Agregar</b></a>
          <p>Si no encuentra la categoria de su gusto, puede agregar una nueva <a href="#">aquí</a></p>
        <fieldset class="none">
          <input type="text" name="name" value="categoria">
        </fieldset>
        </span>
      </div>

    </div>

    <div id="choTipEvaCol">
      <span>
        <select id="catEvaListCol" name="categoriasCol">
          <option value="0">Escoge una categoria</option>
          <?foreach ($cat as $var): ?>
          <option value="<?=$var->evaluacionCategoriaID;?>"><?=$var->categoriaNombre;?></option>
          <?endforeach; ?>
        </select>
        <a href="<?=base_url()?>ajax/addCategoriasEva" id="butEvaCol" type="button" name="buttonCol">
        <img src="<?=base_url()?>assets/graphics/svg/plusCircle.svg" alt="Agregar Plaza"><b>Agregar</b></a>
      <fieldset class="none">
        <input type="text" name="nameCol" value="categoriaCol">
      </fieldset>
      </span>
    </div>

    </div>
  </div>
  <ul id="usersEva">
    <li>
      <div class="spaHead">
      <input id="allCheck" type="checkbox" checked name="all" id="all" /><em>Todos</em>
      </div>
    <?foreach ($areas as $varA): ?>
    <? $dat = $this->evaluaciones_model->cargaUsuariosDepartamentos($varA->areaID);?>
    <ul>
     <li>
       <div class="areaDiv actEva">
       <input checked class="firInp" type="checkbox" name="title" id="" />
       <span onclick="$('#open<?=$varA->areaID?>').toggle(); return false;" class="areaN" ><b class="actb"></b><?=$varA->area;?></span>
       </div>
       <ul id="open<?=$varA->areaID?>" class="none">
       <li>
         <table class="usuaInfo">
           <?foreach ($dat as $varB): ?>
           <?if($dat):?>
           <tr>
             <td><input checked type="checkbox" name="userAutoEval[]" id="box_1" value="<?php echo $varB->usuarioID ?>" /></td>
             <td><?=$varB->numeroEmpleado;?></td>
             <td><?=$varB->nombreCompleto;?></td>
             <td><?=$varB->email;?></td>
             <td><?=$varB->puesto;?></td>
           </tr>
           <?else:?>
           <tr>
             <td colspan="5">No se encontro ningun colaborador en esta area</td>
           </tr>
           <?endif?>
           <?endforeach; ?>
       </table>
       </li>
      </ul>
     </li>
    </ul>
    <?endforeach; ?>
  </li>
  </ul>
  </section>

		<br class="clear">
	</div>

</div>


<script type="text/javascript">
$(document).ready(function(){
  $('.areaN').click(function(){
    $(this).children().toggleClass("deactb");
  });

  $('input[name="all"],input[name="title"]').bind('click', function(){
  var status = $(this).is(':checked');
  $('input[type="checkbox"]', $(this).parent().parent('li')).attr('checked', status);
  });
});
</script>

<script type="text/javascript">
var form = $("#guardarForm");
$("#steps").steps({
    headerTag: "h6",
    bodyTag: "section",
    labels: {
        cancel: "Cancelar",
        current: "current step:",
        pagination: "Paginacion",
        finish: "Generar",
        next: "Siguiente",
        previous: "Anterior",
        loading: "Cargando ..."
    },
    onFinished: function (event, currentIndex)
    {
        form.submit();
    },
    autoFocus: true
});
</script>

<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery-datepicker.css" type="text/css">
<script language="javascript" src="<?=base_url()?>assets/js/jquery-datepicker.js" type="text/javascript"></script>
<script type="text/javascript">
$(".datePick").datepicker({
    dateFormat: 'yy-mm-dd',
    changeMonth: true,
    changeYear: true,
    yearRange: "-100:+0",
    numberOfMonths: 3,
    showCurrentAtPos: 2
});
</script>
<script type="text/javascript">
("#sCTipCol").click(
  var califica = $('#busColOne').val();
  var acalificar = $('#busColTwo').val();
  var calificaID = $('#busColONe').attr('data-text');
  var acalificaID = $('#busColTwo').attr('data-text');

  if(califica){
      $("#busFinal").append('<div class="agreCali"><a href="#" class="rem"></a><input type="hidden" value="'+califica+'"/> <i>'+califica+'</i><em>Calificara a</em><input type="hidden" name="caliID[]" value="'+calificaID+'"/><input type="text" value="'+acalificar+'"/> <input type="hidden" name="calificacoID[]" value="'+acalificaID+'"/></div>');
      $( "#tablaUsu" ).empty();
      $('#busColOne').val('');
      $('#busColTwo').val('');
  }else{
    alert('No ha escogido a ningun colaborador que participe en su encuesta');
    $( "#tablaUsu" ).empty();
    $('#busColOne').val();
    $('#busColTwo').val();
  }

  $(".rem").click(function(event){
    event.preventDefault();
    $(this).parent().remove();
  });
});
</script>
<script type="text/javascript">
$("#sCTipCol").click(function(){
  $("#choTipEvaCol").toggleClass("show");
});
</script>
</form>
