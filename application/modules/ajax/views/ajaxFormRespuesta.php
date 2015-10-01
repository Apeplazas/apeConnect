<? foreach($comentarios as $rowC):?>
<form class="respCom" id="resp<?=$this->uri->segment(3);?>" action="<?=base_url()?>proyectos/agregarComentario" method="post" >
  <fieldset>
    <span id="iconCom"><img src="<?=base_url()?>assets/graphics/commentBig.png" alt="Escribe tu comentario" /></span>
    <textarea name="respuesta" id="respond" placeholder="Escribe tu comentario..."/></textarea>
    <span><a class="closeForm" href="#"><img src="<?=base_url()?>assets/graphics/closeGray.png" alt="Cerrar Formulario" /></a></span>
  </fieldset>
  <fieldset class="none textComment">
    <input type="hidden" value="<?=$rowC->comentarioID;?>" name="comentarioID" />
    <input type="hidden" value="<?=$rowC->idProyecto;?>" name="proyectoID" />
    <input type="hidden" value="<?=$rowC->idConversacionTipo;?>" name="tipoID" />
  </fieldset>
  <fieldset  id="muestraBoton">
	  <input id="addResp" class="blackSmallForm fright" type="submit" value="finalizar"/>
  </fieldset>
</form>
<? endforeach; ?>
<script>
$(document).ready(function(){
	$( ".closeForm" ).click(function() {
    	$( "#resp<?=$this->uri->segment(3);?>" ).hide();
	});
});	
</script>
