<? foreach($profile as $row): ?>
<? if($row->statusProveedor == 'en proceso'):?>
<p class="alerta"><img src="<?=base_url()?>assets/graphics/alerta.png" alt="Alerta" /><strong>Su cuenta se encuentra en proceso de autorización el cual puede tardar de 24 a 48 horas.</strong></p>
<? endif;?>
<? if($row->documentacionCompleta != '1'):?>
	<h3 class="info">Su perfil no ha sido finalizado todavia, para poder participar en nuestras licitaciones suba toda la documentacion solicitada</h3>
	<section id="docFis">
	<form enctype="multipart/form-data" method="post" action="<?=base_url()?>usuarios/savedoc">
	<?php if(empty($row->cedulas)): ?>
		<span class="frame">
			<fieldset>
				<a class="iconCedula" >
					<input class="subirFoto required" value="" type="file" size="35" name="ced" onchange="readURL(this)" />
				</a>
				<div id="cedwrap" class="wrapIma" style="display:none;">
					<img id="cedimg" src="#" alt="Preview" />
				</div>
			</fieldset>
		</span>
	<?php endif;?>
	<?php if(empty($row->shcp)):?>
		<span class="frame">
			<fieldset>
				<a class="iconSHCP" >
					<input class="subirFoto required" value="" type="file" size="35" name="shcp" onchange="readURL(this)" />
				</a>
				<div id="shcpwrap" class="wrapIma" style="display:none;">
					<img id="shcpimg" src="#" alt="Preview" />
				</div>
			</fieldset>
		</span>
	<?php endif;?>
	<?php if(empty($row->edoCuenta)):?>
		<span class="frame">
			<fieldset>
				<a class="iconLoad" >
				<input class="subirFoto required" value="" type="file" size="35" name="cuenta" onchange="readURL(this)" />
				</a>
				<div id="cuentawrap" class="wrapIma" style="display:none;">
					<img id="cuentaimg" src="#" alt="Preview" />
				</div>
			</fieldset>
		</span>
	<?php endif;?>
	<?php if(empty($row->comprobanteDomicilio)):?>
		<span class="frame">
			<fieldset>
				<a class="iconDomicilio" >
				<input class="subirFoto required" value="" type="file" size="35" name="domicilio" onchange="readURL(this)" />
				</a>
				<div id="domiciliowrap" class="wrapIma" style="display:none;">
					<img id="domicilioimg" src="#" alt="Preview" />
				</div>
			</fieldset>
		</span>
	<?php endif;?>
	<?php if(empty($row->credencialElector)):?>
		<span class="frame">
			<fieldset>
				<a class="iconElector" >
				<input class="subirFoto required" value="" type="file" size="35" name="elec" onchange="readURL(this)" />
				</a>
				<div id="elecwrap" class="wrapIma" style="display:none;">
					<img id="elecimg" src="#" alt="Preview" />
				</div>
			</fieldset>
		</span>
	<?php endif;?>
	
	
	<?php if($row->tipoRegistro == 'fisica'):?>
		<?php if(empty($row->IMSS)): ?>
		<span class="frame">
			<fieldset>
				<a class="iconImss" >
				<input class="subirFoto required" value="" type="file" size="35" name="imss" onchange="readURL(this)" />
				</a>
				<div id="imsswrap" class="wrapIma" style="display:none;">
					<img id="imssimg" src="#" alt="Preview" />
				</div>
			</fieldset>
		</span>
		<?php endif;?>
		
	
	<?php elseif($row->tipoRegistro == 'moral'):?>
		<?php if(empty($row->certificado)):?>
		<span class="frame">
			<fieldset>
				<a class="iconCer" >
				<input class="subirFoto required" value="" type="file" size="35" name="cer" onchange="readURL(this)" />
				</a>
				<div id="cerwrap" class="wrapIma" style="display:none;">
					<img id="cerimg" src="#" alt="Preview" />
				</div>
			</fieldset>
		</span>
		<?php endif;?>
		<?php if(empty($row->actasConstitutivas)):?>
		<span class="frame">
			<fieldset>
				<a class="iconAct" >
				<input class="subirFoto required" value="" type="file" size="35" name="act" onchange="readURL(this)" />
				</a>
				<div id="actwrap" class="wrapIma" style="display:none;">
					<img id="actimg" src="#" alt="Preview" />
				</div>
			</fieldset>
		</span>
		<?php endif;?>
	<?php endif;?>
	<span class="fle100">
		<fieldset>
			<input class="subIma mt20" type="submit" value="Finalizar" />
		</fieldset>
	</span>
		</form>
	</section>
<? endif;?>
<script>
$(document).ready(function(){
  $("#tab li:even").addClass("even");
  $("#tab li:odd").addClass("odd");
});
</script>
<section id="infoProf">
<?= $this->session->flashdata('msg'); ?>
	<h4>Proyectos y obras disponibles para cotizar en tu área.</h4>
	<p> Te deseamos mucha suerte.</p>
	<ul id="tab">
		<? foreach($recomendados as $rowRec):
			
			//Fechas de proyecto fecha aactual,inicio de proyecto y fin de proyecto
			$currentdate = new DateTime("now");
			$startdate = new DateTime($rowRec->fechaAltaProyecto);
			$enddate = new DateTime($rowRec->cierreProyecto);
			
			//Diferencias de fecha de inicio y fin del proyecto
			$diffstart = $currentdate->diff($startdate);
			$diffend = $currentdate->diff($enddate);
			//$diffend->format('%R%a días');
			
			//Ha Cotizado?
			$haCotizado = $this->user_model->hacotizado($rowRec->idProyecto,$profile[0]->usuarioID);
			
			if(!empty($haCotizado))
				$cotLink = base_url() . "usuarios/verCotizacion/" . $haCotizado[0]->id;
			else 
				$cotLink = base_url() . "usuarios/v/" . $rowRec->idProyecto;
			?>
			<li>
				<strong><?= $rowRec->tituloProyecto;?></strong>
				<?php if(!empty($haCotizado)):?>
					<span>Ya Cotizó para este proyecto</span>
				<?php endif;?>
				<div class="stats">
					 <span class="espMin">Creado hace: <?= $diffstart->format('%a días');?>  |  Fin de licitación: <?= $diffend->format('%a días');?></span>
					 <p class="parra"><?= character_limiter($rowRec->descripcion,150);?> <span>ver más...</span></p>
					 
					 <p class="tip"><i>Tipo:</i> <b><?= $rowRec->tipoobra;?> -</b>  <i>Lugar:</i> <b><?= $rowRec->zona;?></b></p>
					 <p class="bold"><i>Capacidad financiera a comprobar:</i> <em>$<?=  number_format($rowRec->rangoMaximo);?></em></p>
				</div>
			  <a href="<?=$cotLink;?>" title="<?= $rowRec->tituloProyecto;?>"><span id="addSeg" class="mt10 fleft redBoton"><em><img src="<?=base_url()?>assets/graphics/plus.png" alt="Agregar Segmento"></em>Ver más...</span></a>
			</li>
		<? endforeach; ?>
	</ul>
</section>
<? endforeach; ?>


<script>
	function readURL(input) {
		
		var imageUrl = input.name+'img';
        if (input.files && input.files[0]) {
        	var reader = new FileReader();
            reader.onload = function(e) {
            	if (/^image/.test(input.files[0].type)){
            		$('#'+imageUrl).attr('src', e.target.result);
            	}else if(/^application\/pdf/.test(input.files[0].type)){
            		$('#'+imageUrl).attr('src', "http://raisedfromthegrave.com/images/pdf.png");
            	}else{
            		alert("No se acepta este tipo de archivo");
            		return false;
            	}            	
            }
            
            reader.readAsDataURL(input.files[0]);
 
            $('#'+input.name+"wrap").show();
       }
	}
</script>
