<?php $user =	$this->session->userdata('usuario'); ?>
<?php $no_not = $this->user_model->numero_mensajes($user['usuarioID']);?>
<a id="notif" class="menuCount" href="<?=base_url()?>notificaciones"><img src="<?=base_url()?>assets/graphics/notificacionesIcono.png" alt="Notificaciones" /><?php if($no_not > 0):?><i id="solicitud"><?=$no_not;?></i><?php endif;?></a>
<?php if($no_not > 0):?>
<ul id="notifList">
<img id="triangulo" src="<?=base_url()?>assets/graphics/trianguloBlanco.png" alt="" />
<? foreach($notificaciones as $row):?>
	<li>
	    <a href="<?= $row->url;?>">
	    <strong><?= $row->date;?></strong>
	    <p><?= $row->mensaje;?></p>
	  </a>
	</li>
<? endforeach; ?>
<?php endif;?>
</ul>