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
					else
						window.location.reload();//window.location = response['usuario']['fancyUrl'];
                }
        });
        
	});
});

