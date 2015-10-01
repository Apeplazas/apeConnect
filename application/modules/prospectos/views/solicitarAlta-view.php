<? $user = $this->session->userdata('usuario'); ?>

<? $nombreCuenta            = set_value('nombreCuenta'); ?>
<? $tipoEmpresa             = set_value('tipoEmpresa'); ?>
<? $rfc                     = set_value('rfc'); ?>
<? $plaza                   = set_value('plaza'); ?>
<? $primerNombre            = set_value('primerNombre'); ?>
<? $segundoNombre           = set_value('segundoNombre'); ?>
<? $apellidoPaterno         = set_value('apellidoPaterno'); ?>
<? $apellidoMaterno         = set_value('apellidoMaterno'); ?>
<? $email                   = set_value('email'); ?>
<? $telefono                = set_value('telefono'); ?>
<? $comentario              = set_value('comentario'); ?>
<? $calle                   = set_value('calle'); ?>
<? $estado                  = set_value('estado'); ?>
<? $municipio               = set_value('municipio'); ?>
<? $colonia                 = set_value('colonia'); ?>
<? $cp                      = set_value('cp'); ?>
<? $exterior                = set_value('exterior'); ?>
<? $interior                = set_value('interior'); ?>
<? $DescDom                 = set_value('DescDom'); ?>


<? $errorNombreCuenta       = form_error('nombreCuenta'); ?>
<? $errorTipoEmpresa        = form_error('tipoEmpresa'); ?>
<? $errorRfc                = form_error('rfc'); ?>
<? $errorPlaza              = form_error('plaza'); ?>
<? $errorPrimerNombre       = form_error('primerNombre'); ?>
<? $errorApellidoPaterno    = form_error('apellidoPaterno'); ?>
<? $errorEmail              = form_error('email'); ?>
<? $errorTelefono           = form_error('telefono'); ?>
<? $errorComentario         = form_error('comentario '); ?>
<? $errorCalle              = form_error('calle'); ?>
<? $errorEstado             = form_error('estado'); ?>
<? $errorColonia            = form_error('colonia'); ?>
<? $errorMunicipio          = form_error('municipio'); ?>
<? $errorCp                 = form_error('cp'); ?>
<? $errorExterior           = form_error('exterior'); ?>
<? $errorDescDom            = form_error('DescDom'); ?>


	
<form action="<?=base_url()?>prospectos/guardarProspecto" method="post">
<?= $this->session->flashdata('msg');?>
<div class="wrapListForm" id="wrapListForm1">
	<span class="msgBar grayBox">Datos empresa</span>	
	<fieldset>
	    <div class="wrapLabel">
		 <label>Nombre constituido</label>
	    </div>
	     <? if($nombreCuenta):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?=$errorNombreCuenta?></em></div><?endif?>
	    <input class="bigInp" id="nombreCuenta" name="nombreCuenta" value="<?=set_value('nombreCuenta');?>" type="text"/>
	</fieldset>
	    
	<fieldset>
	    <div class="wrapLabel">
		  <label><span class="obli">*</span>Tipo cliente</label>
	    </div>
	    <? if($errorTipoEmpresa):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorTipoEmpresa?></em></div><?endif?>
	    
	    <select id="tipoEmpresa" name="tipoEmpresa" class="selBig">
			<? if($tipoEmpresa):?><option checked value="<?= $tipoEmpresa?>"><?= $tipoEmpresa?></option><?endif?>
			<option value="0">Selecciona una opción</option>
		    <option id="moral" value="Moral">Personal moral</option>
		    <option id="fisica" value="Fisica">Persona Fisica</option>
	    </select>
	<script type="text/javascript">
		$('#tipoEmpresa').change(function() {
			if ($(this).val() === 'Moral') {
				$('#tipFec').text('Fecha de creación');	
			}
			else if($(this).val() === 'Fisica'){
				$('#tipFec').text('Fecha de nacimiento');	
			}
	    });
	</script>
	</fieldset>
	
	
	
	
	<fieldset>
	<div class="wrapLabel">
	  <label id="tipFec">Fecha</label>
	</div>
		<input class="medInp bloquea" id="datepicker" name="fechaCierre" value="<?=set_value('fechaCierre');?>"  type="text" />
	<script>
	  $(function() {
	    $( "#datepicker" ).datepicker({
	      showOn: "both",
	      buttonImage: "<?=base_url()?>assets/graphics/calendar.png",
	      buttonImageOnly: true,
	      dateFormat: 'dd-mm-yy',
	      changeMonth: true,
	      changeYear: true,
	      yearRange: "-100:+0"
	    });
	  });
	</script>
	</fieldset>
	
	
	<fieldset>
	    <div class="wrapLabel">
		 <label>Registro Federal (RFC)</label>
	    </div>
	     <? if($errorRfc):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?=$$errorRfc?></em></div><?endif?>
	    <input class="bigInp" id="rfcCuenta" name="rfcCuenta" value="<?=set_value('rfc');?>" type="text"/>
	</fieldset>
	
	<fieldset>
		<div class="wrapLabel">
		  <label><span class="obli">*</span>Plaza</label>
		</div>
		<? if($errorPlaza):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorPlaza?></em></div><?endif?>
		<select name="plaza[]" id="plazaModal" class="selMed selPlaza">
		    <? foreach($plazas as $p):?>
		    <option value="<?= $p->idZona;?>"><?= $p->zona;?></option>
		    <? endforeach; ?>
	    </select>
	    <span class="plusModal">Agregar Plaza</span>
	    <div  id="modalPlazas"></div>
	</fieldset>
		
</div>

<div class="wrapListForm" id="wrapListForm2">
	<span class="msgBar grayBox">Datos persona</span>	
		<fieldset>
		<div class="wrapLabel">
		  <label><span class="obli">*</span>Primer nombre</label>
		</div>
	    <select name="titulo" class="selSma">
		    <option value="Sr" checked>Sr</option>
		    <option value="Sra">Sra</option>
		    <option value="Ing">Ing</option>
		    <option value="Lic">Lic</option>
		    <option value="Otro">Otro</option>
	    </select>
	    <? if($errorPrimerNombre):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorPrimerNombre?></em></div><?endif?>
	    <input class="medInp" name="primerNombre" value="<?= set_value('primerNombre');?>" type="text"/>
	</fieldset>
	    
	<fieldset>
	    <div class="wrapLabel">
		 <label>Segundo nombre</label>
	    </div>
	    <input class="bigInp" name="segundoNombre" value="<?=set_value('segundoNombre');?>" type="text"/>
	</fieldset>
	    
	<fieldset>
	    <div class="wrapLabel">
		  <label><span class="obli">*</span>Apellido paterno</label>
	    </div>
	    <? if($errorApellidoPaterno):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?=$errorApellidoPaterno?></em></div><?endif?>
	    <input class="bigInp" name="apellidoPaterno" value="<?=set_value('apellidoPaterno');?>" type="text"/>
	</fieldset>
	    
	<fieldset>
	   <div class="wrapLabel">
		  <label>Apellido materno</label>
	    </div>
	    <input class="bigInp" name="apellidoMaterno" value="<?=set_value('apellidoMaterno');?>" type="text"/>
	</fieldset>
	    
	<fieldset>
		<div class="wrapLabel">
	      <label><span class="obli">*</span>Correo electrónico</label>
		</div>
		<? if($errorEmail):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorEmail?></em></div><?endif?>
		<input class="bigInp" name="email" value="<?=set_value('email');?>" type="text"/>
	</fieldset>
	<fieldset>
	    <div class="wrapLabel">
	      <label><span class="obli">*</span>Teléfono</label>
		</div>
		<? if($errorTelefono):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorTelefono?></em></div><?endif?>
	    <input class="bigInp soloNumeros" name="telefono" value="<?=set_value('telefono');?>" type="text"/>
	</fieldset>
</div>

<div class="wrapListForm" id="wrapListForm2">
	<span class="msgBar grayBox">Detalles de la dirección</span>
	
	<fieldset>
	    <div class="wrapLabel">
		  <label>Estado</label>
	    </div>
	    <? if($errorEstado):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorEstado?></em></div><?endif?>
	    <select id="estado" class="selBig" name="estado">
		    <? if($estado):?><option checked value="<?= $estado?>"><?= $estado?></option><?endif?>
		    <option value="">Seleccione un estado</option>
		    <? foreach($estados as $estadosRow):?>
		    <option value="<?= $estadosRow->nombreEstado?>"><?= $estadosRow->nombreEstado?></option>
		    <? endforeach;?>
		    
		</select>
	</fieldset>
	
	<fieldset>
	    <div class="wrapLabel">
		  <label>Municipio</label>
	    </div>
	    <? if($errorMunicipio):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorMunicipio?></em></div><?endif?>
	    <select id="municipio" class="selBig" name="municipio">
		    <? if($municipio):?><option checked value="<?= $municipio?>"><?= $municipio?></option><?endif?>
		    <option value="">Seleccione un municipio</option>
		</select>
	</fieldset>
	
	<fieldset>
	    <div class="wrapLabel">
		  <label>Colonia</label>
	    </div>
	    <? if($errorColonia):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorColonia?></em></div><?endif?>
	    <select id="colonia" class="selBig" name="colonia">
		    <? if($colonia):?><option checked value="<?= $colonia?>"><?= $colonia?></option><?endif?>
		    <option value="">Seleccione una colonia</option>
		</select>
	</fieldset>
	
	<fieldset>
	    <div class="wrapLabel">
		  <label>Código postal</label>
	    </div>
	    <? if($errorCp):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorCp?></em></div><?endif?>
	    <input type="text" class="bigInp soloNumeros" id="cp" name="cp" value="<?= set_value('cp');?>" />
	</fieldset>
	
	<fieldset>
	    <div class="wrapLabel">
		  <label>Calle</label>
    	</div>
    	<? if($errorCalle):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorCalle?></em></div><?endif?>
		<textarea class="texMed" name="calle" value=""><?=set_value('calle');?></textarea>
	</fieldset>
	
	<fieldset>
	    <div class="wrapLabel">
		  <label>Número exterior</label>
    	</div>
    	<? if($errorExterior):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorExterior?></em></div><?endif?>
		<input class="bigInp soloNumeros" name="exterior" value="<?=set_value('exterior');?>" type="text"/>
	</fieldset>
	
	<fieldset>
	    <div class="wrapLabel">
		  <label>Número interior</label>
    	</div>
		<input class="bigInp soloNumeros" name="interior" value="<?=set_value('interior');?>" type="text"/>
	</fieldset>
	
	<div class="comenWrap">
	    <div class="wrapLabel">
		  <label>Descripcion domicilio</label>
    	</div>
    	<? if($errorDescDom):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorDescDom?></em></div><?endif?>
		<textarea class="texBig" name="comentario" value=""><?=set_value('DescDom');?></textarea>
	</div>
</div>

<div class="wrapListForm" id="wrapListForm3">
	<span class="msgBar grayBox">Información importante</span>	
	<div class="comenWrap">
	    <div class="wrapLabel">
		  <label>Comentario</label>
    	</div>
    	<? if($errorComentario):?><div class="msgError"><span><img src="<?=base_url()?>assets/graphics/redArrow.png" alt="Notificación" /></span><em><?= $errorComentario?></em></div><?endif?>
		<textarea class="texBig" name="comentario" value=""><?=set_value('comentario');?></textarea>
	</div>
	
	<span id="formSub">
	  <input class="mainBotton" type="submit" name="button" id="button" value="Guardar" class='contacto_enviar' />
	</span>
</form>

<script>
	$(document).ready(function(){
		$('#tipoEmpresa, #datepicker, #nombreCuenta').on('change',function(){
			var persona = $('#tipoEmpresa').val();
			var nombre = $('#nombreCuenta').val();
			var fecha = $('#datepicker').val();

			$.ajax({
				data : {
					'nombre' : nombre,
					'persona' : persona,
					'fecha'	: fecha
				},
				dataType : 'json',
				url : 'http://www.apeplazas.com/apeConnect/ajax/genera_rfc',
				type : 'post',
				success : function(response) {
					$('#rfcCuenta').val(response.rfc);
				}
			});
		});
	});
</script>
