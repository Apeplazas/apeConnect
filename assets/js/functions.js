jQuery(function($) {
	/********************************************************************************************************************
	 Menu on Click
	 ********************************************************************************************************************/
	$(".menuDrop").click(function() {
		$(".dropdown dd ul").toggle();
	});
	$(".menuForm").click(function() {
		$(".dropdown form").toggle();
	});
	$(".menuRep").click(function() {
		$("#subCat").toggle();
	});

	$(document).bind('click', function(e) {
		var $clicked = $(e.target);
		if (! $clicked.parents().hasClass("dropdown"))
			$(".dropdown dd ul, .dropdown form").hide();
	});
	$(document).bind('click', function(e) {
		var $clicked = $(e.target);
		if (! $clicked.parents().hasClass("drop"))
			$("#subCat").hide();
	});
	/********************************************************************************************************************
	 Busca y verifica si esta url disponible
	 ********************************************************************************************************************/
	$("#fancy").keyup(function() {
		var filtro = $("#fancy").val();
		$("#url").removeAttr("disabled");
		$.post("http://www.apeplazas.com/obras/ajax/verificaUrl", {
			filtro : filtro
		}, function(data) { sucess:
			$("#url").empty().append(data);
			$("#url").removeAttr("disabled");
		});

	})
	/********************************************************************************************************************
	 Busca y verifica si existe email disponible
	 ********************************************************************************************************************/
	$("#emaCheck").keyup(function() {
		var filtro = $("#emaCheck").val();
		$("#ajaxEma").removeAttr("disabled");
		$.post("http://localhost:8888/apeConnect/ajax/verificaEmail", {
			filtro : filtro
		}, function(data) { sucess:
			$("#ajaxEma").empty().append(data);
			$("#ajaxEma").removeAttr("disabled");
		});

	})
	/********************************************************************************************************************
	 Ajax login
	 ********************************************************************************************************************/
	$("#loginForm").submit(function(e) {
		e.preventDefault();
		$.ajax({
			data : $(this).serialize(),
			dataType : 'json',
			url : 'http://localhost:8888/apeConnect/registrate/valida',
			type : 'post',
			beforeSend : function() {
				$(".msgBlack").html("<span class='msg<'>Procesando, espere por favor...</span>");
			},
			success : function(response) {
				if (response['error'])
					$(".msgBlack").html(response['error']);
				else
					window.location.reload();
			}
		});

	});

	/********************************************************************************************************************
	 Cotización
	********************************************************************************************************************/
	if ($("#enviarcotizacion").length != 0) {
		$('.punitario').keyup(function() {
			var rango = $(this).attr('name');
			var rangoid = rango.match(/\[([^|]*)\]/)[1];
			var cunitario = $(this).val();

			$.ajax({
				data : {
					'segmentoid' : rangoid,
					'cunitario' : cunitario
				},
				dataType : 'json',
				url : ajax_url + 'totalsegmento',
				type : 'post',
				success : function(response) {
					$('#tota-' + rangoid).val(response);
					$('#tota-' + rangoid).formatCurrency();
					actualizatotal();
				}
			});

		});

		function actualizatotal() {
			var total = 0;
			$('.totalrango').each(function() {
				var temp = $(this).val();
				var tempnum = Number(temp.replace(/[^0-9\.]+/g, ""));
				total = total + tempnum;
			});
			$("#totAj").html(total);
			$("#totAj").formatCurrency();
			$("#IVAAj").html(total + (total * .16));
			$("#IVAAj").formatCurrency();
		}

	}
	/********************************************************************************************************************
	 Ajax Actualiza estatus proveedor
	 ********************************************************************************************************************/
	$("#changestatusProv").change(function(e) {

		e.preventDefault();
		var status = $(this).val();
		var proveedorid = $('#proveedorid').val();

		if (confirm("Se cambiara el estado del proveedor")) {
			$.ajax({
				data : {
					'statusProveedor' : status,
					'proveedorid' : proveedorid
				},
				dataType : 'json',
				url : '../statusprov',
				type : 'post',
				success : function(response) {
					alert(response);
					window.location.reload();
				}
			});
		}

	});

	$("#changerangoProv").change(function(e) {

		e.preventDefault();
		var status = $(this).val();
		var proveedorid = $('#proveedorid').val();

		if (confirm("Se cambiara el rango del proveedor")) {
			$.ajax({
				data : {
					'rangoProveedor' : status,
					'proveedorid' : proveedorid
				},
				dataType : 'json',
				url : '../rangoproveedor',
				type : 'post',
				success : function(response) {
					alert(response);
					window.location.reload();
				}
			});
		}

	});
	/********************************************************************************************************************
	 Ajax Agregar Plaza
	 ********************************************************************************************************************/
	$("#agregarplaza").submit(function(e) {
		e.preventDefault();
		if ($('#zona').val() == '' || $('#czona').val() == '') {
			return false;
		}
		$.ajax({
			data : $(this).serialize(),
			dataType : 'json',
			url : ajax_url + "addplaza",
			type : 'post',
			success : function(response) {
				window.location.reload();
			},
			error : function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
			}
		});

	});

	/********************************************************************************************************************
	 Ajax Agregar Unidad
	 ********************************************************************************************************************/
	$("#agregarunidad").submit(function(e) {
		e.preventDefault();
		if ($('#unombre').val() == '' || $('#sunidad').val() == '') {
			return false;
		}
		$.ajax({
			data : $(this).serialize(),
			dataType : 'json',
			url : ajax_url + "addunidad",
			type : 'post',
			success : function(response) {
				window.location.reload();
			},
			error : function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
			}
		});

	});
	/********************************************************************************************************************
	 Ajax Agregar Partida
	 ********************************************************************************************************************/
	$("#agregarpartida").submit(function(e) {

		e.preventDefault();

		if ($('#pnombre').val() == '' || $('#pclave').val() == '') {
			alert("Favor de ingresar todos los datos");
			return false;
		}
		$.ajax({
			data : $(this).serialize(),
			dataType : 'json',
			url : ajax_url + "agregarpartida",
			type : 'post',
			success : function(response) {
				window.location.reload();
			},
			error : function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
			}
		});

	});
	/********************************************************************************************************************
	 Menu toolbar
	 ********************************************************************************************************************/
	$(function() {
		$('#excelClick').hover(function() {
			//Enseña submenu en slidedown
			$('.subMenu', this).slideDown(90);
		}, function() {
			//Esconde el submenu en slideUp
			$('.subMenu', this).fadeOut(15);
		});
	});
	$("#excelList a").click(function() {
		$(".subMenu").hide();
	});
	/********************************************************************************************************************
	 Busca pisos disponibles de plazas
	 ********************************************************************************************************************/
	$("#plaza").change(function() {
		var plaza = $("#plaza").val();
		$("#pisos").removeAttr("disabled");
		$.post("http://www.apeplazas.com/obras/ajax/verificaPisos", {
			plaza : plaza
		}, function(data) { sucess:
			$("#pisos").empty().append(data);
			$("#pisos").removeAttr("disabled");
		});

	})


	/********************************************************************************************************************
	Cierra ventana en click afuera de ventana
	+********************************************************************************************************************/
	$(".link, .click").click(function(e){
    	e.preventDefault();
		$(".popup").show();
    });
    $("#delTool").click(function(e){
    	e.preventDefault();
		$("#delVector").show();
    });
    $("#filtroTool").click(function(e){
    	e.preventDefault();
		$(".popupTwo").show();
    });
    $("#planMas").click(function(e){
    	e.preventDefault();
		$("#addPlaza").show();
    });


	$('html').click(function() {
		$(".popup").hide();
		$(".popupTwo").hide();
		$("#addPlaza").hide();
		$("#asig").hide();
		$("#delVector").hide();
	});
	$('#filtroTool').click(function() {
		$("#addPlaza").hide();
	});
	$('#planMas').click(function() {
		$(".popupTwo").hide();
	});
	$('#canDel').click(function() {
		$(".delVector").hide();
	});


	$('.link, #filtroTool, .busqueda, .fanc, #asigInp, .habilitado, #habilitado, .seleccionado, .areaPublica, #planoGrama, #planoGramaAsig, #addPlaza, #planMas, #delTool, .reciente, .deshabilitado, .texto, .selected').click(function(event){
    	event.stopPropagation();
    });

    // Cambia clase en barra izquierda menu
    $('#bar button').click(function() {
	    $('#bar').toggleClass('barLeft');
	    $('#wrapAll').toggleClass('wrapOpen');
	    $('#wrapAll').toggleClass('wrapClose');
	    $('#barTwo').toggleClass('barRight');
    	$(this).toggleClass('arrowLeft');
    	$(this).toggleClass('arrowRight');
    });

	// Cambia clase en barra derecha
    $('#winRight button').click(function() {;
	    $('#winRight').toggleClass('barClose');
	     $('#winRight').toggleClass('barOpen');
    	$(this).toggleClass('winRightClose');
    	$(this).toggleClass('winRight');
    });

	$(".main strong").click(function(e){
		$(this).siblings().toggle();
		$(this).toggleClass('titActive');
    });
    //// Solo permite numeros en los inputs de telefonos y numericos
    $(".soloNumeros").keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            (e.keyCode == 65 && e.ctrlKey === true) ||
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });


    $(".soloLetras").keydown (function (e){
       key = e.keyCode || e.which;

       tecla = String.fromCharCode(key).toLowerCase();
       letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
       var especiales = [];
       especiales.push("8");
       especiales.push("37");
       especiales.push("39");
       especiales.push("46");
       especiales.push("192");
       especiales.push("0");

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
     });

    $(".soloLetras, .uppercase").keyup(function (e){
        $(this).val($(this).val().toUpperCase());
    });



    $('.bloquea').keyup(function() {
	    var sanitized = $('.bloquea').val().replace(/[^]/g, '');
	    $(this).val(sanitized);
	});

    //// Carga estados y municipio desde la base de datos
    //Para cargar los municipios
	$("#estado").change(function(){
		var estadoFiltro = $(this).val();
		$("#municipioDir").removeAttr("disabled");
		$.post("http://localhost:8888/apeConnect/ajax/cargarMunicipios",{estadoFiltro:estadoFiltro},function(data){
			sucess:
				$("#municipio").empty().append(data);
				$("#municipio").removeAttr("disabled");
		});

	});
	//Para cargar las colonias
	$("#municipio").change(function(){
		var estadoFiltro = $("#estado").val();
		var municipioFiltro = $(this).val();
		$("#colonia").removeAttr("disabled");
		$.post("http://localhost:8888/apeConnect/ajax/cargarColonias",{municipioFiltro:municipioFiltro,estadoFiltro:estadoFiltro},function(data){
			sucess:
				$("#colonia").empty().append(data);
				$("#colonia").removeAttr("disabled");
		});

	});
	//Para cargar C.P.
	$("#colonia").change(function(){
		var estadoFiltro 	= $("#estado").val();
		var municipioFiltro = $("#municipio").val();
		var coloniaFiltro 	= $(this).val();
		$.post("http://localhost:8888/apeConnect/ajax/cargarCP",{municipioFiltro:municipioFiltro,estadoFiltro:estadoFiltro,coloniaFiltro:coloniaFiltro},function(data){
			sucess:
				$("#cp").val(data);
		});

	});
	//Carga un select nuevo con mas plazas
	$(".plus, .plusTwo").click(function(){
		$(".plus").addClass("none");
		var idPlaza 	= $("#idPlaza").val();
		$.post("http://localhost:8888/apeConnect/ajax/cargarMasPlazas",{idPlaza:idPlaza},function(data){
			sucess:
				$("#masPlazas").append(data);
		});

	});


	/********************************************************************************************************************
	 Borrar Proyectos
	 ********************************************************************************************************************/
/*
	$('#proyectosBorrar').click(function(e){
		e.preventDefault();
		var allVals = [];
		$('input:checkbox[name=borrarProyecto]:checked').each(function() {
	    	allVals.push($(this).val());
	    });
	    if(allVals.length === 0){
	    	alert("Favor de elegir proyectos para borrar");
	    }else{
	    	$.ajax({
			data : {'idProyectos':allVals},
			dataType : 'json',
			url : ajax_url + "borrarProyectos",
			type : 'post',
			success : function(response) {
				window.location.reload();
			},
			error : function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
			}
		});
	    }

	});
*/
	$(".delThis").click(function() {
		$(this).parent().remove();
	});

	/// Borra en edicion la plaza seleccionada de la bd
	$(".delPlaza").click(function() {
		var idPlaza = $(this).attr("id");
		$.post("http://localhost:8888/apeConnect/ajax/borrarPlazaUsuario",{idPlaza:idPlaza},function(data){
		sucess:
			$("#masPlazas").append(data);
		});
		$(this).parent().remove();
	});

	/// Agrega  plazas al usuario
	$(".plusPlaza").click(function() {
		var idPlaza = $("#idPlaza").val();
		var textoPlaza = $("#idPlaza option:selected").text();
		if(idPlaza == ''){
			alert("No ha seleccionado ninguna plaza");
		}
		$.post("http://localhost:8888/apeConnect/ajax/agregarPlazaPost",{idPlaza:idPlaza,textoPlaza:textoPlaza},function(data){
		sucess:
			$("#masPlazas").append(data);
		});
	});

	//Carga un select nuevo con mas plazas
	$(".plusModal").click(function(){
		var textoPlaza	= $("#plazaModal option:selected").text();
		if (textoPlaza == 'Seleccione una opción'){
			alert('Aun no has seleccionado una plaza.');
		}
		else{
			$.post("http://localhost:8888/apeConnect/ajax/plazasEmpresas",{},function(data){
			sucess:
				$("#modalPlazas").append(data);
			});
			$(".plusModal").addClass("none");
		}
	});

	/********************************************************************************************************************
	 Nueva Version Modo CRM
	 ********************************************************************************************************************/

	$("#options").click(function(e){
    	e.preventDefault();
		$("#popupPref").show();
    });
    $("#winPlaza").click(function(e){
    	e.preventDefault();
		$("#addPlaza").show();
    });
    $("#add").click(function(e){
    	e.preventDefault();
		$("#popupQuick").show();
    });
    $('#add').click(function() {
		$("#popupPref").hide();
	});
	$('.msgError').click(function() {
		$(this).hide();
	});
	$('.bigInp, .medInp, .selBig, .selMed').click(function() {
		$(this).prev('.msgError').hide()
	});

	$('#options').click(function() {
		$("#popupQuick").hide();
	});
	$('html').click(function() {
		$("#popupQuick, #popupPref").hide();
	});
	$('#options, #add, #winPlaza').click(function(event){
    	event.stopPropagation();
    });

});
