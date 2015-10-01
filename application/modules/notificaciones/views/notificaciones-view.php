<script>
$( document ).ready(function() {
    $( "#wrapTableNot li:odd" ).addClass("odd");
    $( "#wrapTableNot li:even" ).addClass("even");
    $(".wrapText").click(function(e){
    	e.preventDefault();
    	var not_id = $(this).attr("title");
    	var redirect = $(this).attr("href");
    	$.ajax({
                data:  {"not_id":not_id},
				dataType : 'json',
                url:   'notificaciones/marcarleido',
                type:  'post',
                success:  function (response) {
					window.location = redirect;
                }
        });
    });
});
</script>
<strong id="mainTit"><img src="<?=base_url()?>assets/graphics/notifications.png" alt="Notificationes" />Notificaciones y alertas</strong>
<div id="wrapTableNot">
<?php if(!empty($mensajes_gen)):?>
	<ul>
		<?php foreach($mensajes_gen as $mensaje):?>
			<li <?php if($mensaje->leido == 0):?>class="noLeido" <?php endif;?>>
			<p class="notGen"><em>Dia y Hora: <?=$mensaje->date;?></em></p>
			  <span>
			   <a href="<?=base_url()?>"><img src="<?=base_url()?>assets/graphics/deleteRow.png" alt="Borrar" /></a>
			  </span>
			  <span>
			  	<?php if($mensaje->leido == 0):?>
			  		<img src="<?=base_url()?>assets/graphics/noLeido.png" alt="No Leido" />
			  	<?php else:?>
			  		<img src="<?=base_url()?>assets/graphics/leido.png" alt="Leido" />
			  	<?php endif;?>	
			  </span>
			  <a class="wrapText" href="<?=$mensaje->url;?>" class="notificaciones" title="<?=$mensaje->id;?>-<?=$mensaje->tipo;?>">
			    <p class="notMain"><?=$mensaje->mensaje;?></p>
			    
			  </a>
			</li>
		<?php endforeach;?>
	</ul>
<?php endif;?>
</div>