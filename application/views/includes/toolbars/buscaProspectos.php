<input id="busPros" type="text" value="">


<script type="text/javascript">
$('#busPros').keyup(function(event){
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
