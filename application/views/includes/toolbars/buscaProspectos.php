<div class="addSmall">
	<div id="busqForm">
	<i class="iconPlus"><img src="<?=base_url()?>assets/graphics/svg/back.svg" alt="Regresar"></i>
	<span>Busqueda de cotización</span>
	</div>
	<div id="busPros">
	<input type="text" value="" placeholder="Escribe el numero de folio, nombre o email">
	<em><img id="closing" class="closeData" src="<?=base_url()?>assets/graphics/svg/close.svg"></em>
	</div>
</div>

<script type="text/javascript">

$('#busqForm').click(function() {
	$('#busPros').show();
});
$('#closing').click(function() {
	$('#busPros').hide();
	$('#busPros input').val('');
});

$('#busPros input').keyup(function(event){
	var data = $(this).val();
	$.ajax({
			url: "<?=base_url()?>ajax/cargarProspectos/"+data,
      success: function(data)
        {
          $('#resultadosView').html(data);
        },
      error: function(XMLHttpRequest, textStatus, errorThrown)
        {
          alert('Fallo de conexion');
        },
      beforeSend: function()
        {
          $("#loading").show();
        },
      complete: function(data)
        {
          $("#loading").hide();
        },
			})
});
</script>
