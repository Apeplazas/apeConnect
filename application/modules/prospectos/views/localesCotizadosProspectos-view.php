<? foreach($perfil as $row):?>
<div id="mainTit">
	<h3 >Lista de locales cotizados a <?= $row->pnombre;?> <?= $row->snombre;?> <?= $row->apellidop;?> <?= $row->apellidom;?></h3>
</div>

<div class="wrapList">
	
</div>
<?endforeach?>

<script>
	$(document).ready(function(){
		$.validator.messages.required = 'este campo es obligatorio';
		var form = $("#formulario-apartado");
		form.validate({
		    errorPlacement: function errorPlacement(error, element) { element.before(error); },
		     rules: {

            }
		});

		// must be called after validate()
	    $('.cotizacionIds').each(function () {
	        $(this).rules('add', {
	            required: true
	        });
	    });

		form.children("div").steps({
		    headerTag: "h3",
		    bodyTag: "section",
		    transitionEffect: "slideLeft",
		    onStepChanging: function (event, currentIndex, newIndex)
		    {
		        form.validate().settings.ignore = ":disabled,:hidden";
		        return form.valid();
		    },
		    onFinishing: function (event, currentIndex)
		    {
		        form.validate().settings.ignore = ":disabled";
		        return form.valid();
		    },
		    onFinished: function (event, currentIndex)
		    {
		        form.submit();
		    },
		    labels: {
		        cancel: "Cancelar",
		        current: "paso actual:",
		        pagination: "Paginación",
		        finish: "Finalizar",
		        next: "Siguiente",
		        previous: "Anterior",
		        loading: "Cargando..."
		    }
		});
		$('.showflip').click( function(){
			if($(this).is(":checked")){
				$('input:checkbox').not(this).removeAttr('checked');
		        var id = $(this).val();
		        $('.detailsflip').toggle( false );
				$('.flip-'+id).toggle( true );
				$(this).attr('checked','checked');
		    }else{
				var id = $(this).val();
				$('.flip-'+id).toggle( false );
			}
		});
	});
</script>
