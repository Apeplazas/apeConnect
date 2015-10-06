<?php $user =	$this->session->userdata('usuario');?>

  	<?php if(isset($user['modulos']) && in_array('proyectos', $user['modulos'])):?>
  		<li class="main">
        <strong>Proyectos</strong>
        <ul class="submenu">
          <li><a title="Proyectos" href="<?=base_url()?>proyectos/obras">Lista de proyectos</a></li>
        </ul>
  		</li>
  	<?php endif;
  	if(isset($user['modulos']) && in_array('prospectos', $user['modulos'])):?>
  		<li class="main">
        <strong>Prospectación</strong>
        <ul class="submenu">
          <li><a href="<?=base_url()?>prospectos">Prospectos de plaza</a></li>
        </ul>
  		</li>
  	<?php endif;
  	if(isset($user['modulos']) && in_array('contactos', $user['modulos'])):?>
  		<li class="main">
        <strong>Contactos</strong>
        <ul class="submenu">
          <li><a title="Contactos" href="<?=base_url()?>contactos">Contactos</a></li>
        </ul>
  		</li>
  	<?php endif;
	if(isset($user['modulos']) && in_array('clientes', $user['modulos'])):?>
		<li id="planogramasHover" class="main">
      <strong>Clientes</strong>
      <ul class="submenu">
        <li><a href="<?=base_url()?>clientes">Clientes de plaza</a></li>
      </ul>
		</li>
	<?php endif;
  	if(isset($user['modulos']) && in_array('proveedores', $user['modulos'])):?>
  		<li class="main">
        <strong>Proveedores</strong>
        <ul class="submenu">
          <li><a href="<?=base_url()?>proveedores">Proveedores</a></li>
        </ul>
  		</li>
	<?php endif;
	if(isset($user['modulos']) && in_array('cotizaciones', $user['modulos'])):?>
		<li id="cotizacionesHover" class="main">
      <strong>Cotizaciones</strong>
      <ul class="submenu">
        <li><a href="<?=base_url()?>cotizaciones">Cotizaciones</a></li>
      </ul>
		</li>
	<?php endif;
	if(isset($user['modulos']) && in_array('planogramas', $user['modulos'])):?>
		<li id="planogramasHover" class="main">
      <strong>Planogramas</strong>
      <ul class="submenu">
        <li><a href="<?=base_url()?>planogramas">Lista planogramas</a></li>
      </ul>
		</li>
	<?php endif;
	if(isset($user['modulos']) && in_array('renovaciones', $user['modulos'])):?>
		<li id="planogramasHover" class="main">
      <strong>Renovaciones</strong>
		  <ul class="submenu">
		    <li><a href="<?=base_url()?>renovaciones">Renovaciones</a></li>
		  </ul>
		</li>
	<?php endif;
	if(isset($user['modulos']) && in_array('rh', $user['modulos'])):?>
		<li id="planogramasHover" class="main">
      <strong>Recursos Humanas</strong>
      <ul class="submenu">
        <li><a href="<?=base_url()?>rh">Recursos Humanos</a></li>
      </ul>
		</li>
	<?php endif;?>
