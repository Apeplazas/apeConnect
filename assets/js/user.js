jQuery(function($) {
	/********************************************************************************************************************
	Menu on Click
	********************************************************************************************************************/
	$("#loginForm").submit(function(e) {
		
		e.preventDefault();
		
		 $.ajax({
                data:  $(this).serialize(),
				dataType : 'json',
                url:   'registrate/valida',
                type:  'post',
                beforeSend: function () {
                        $(".msgBlack").html("Procesando, espere por favor...");
                },
                success:  function (response) {
					if(response['error'])
                        $(".msgBlack").html(response['error']);
					else if(response['usuario']['fancyUrl'])
						window.location = "perfiles/"+response['usuario']['fancyUrl'];
					else
						$(".msgBlack").html("Ha ocurrido un error");
                }
        });
        
	});
});

