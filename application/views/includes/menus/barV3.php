<?php $user =	$this->session->userdata('usuario');?>

  	<?php if(isset($user['modulos']) && in_array('proyectos', $user['modulos'])):?>
  		<li class="main In">
        <strong>Proyectos</strong>
        <ul class="submenu">
          <li><a title="Proyectos" href="<?=base_url()?>proyectos/obras">Lista de proyectos</a></li>
        </ul>
  		</li>

  	<?php endif;
  	if(isset($user['modulos']) && in_array('prospectos', $user['modulos'])):?>
  		<li class="main In <?if($this->uri->segment(1) == 'prospectos'):?>bckMark<?endif?>">
        <img alt="Prospectacion" src="<?=base_url()?>assets/graphics/svg/user.svg" />
        <strong>Prospectos</strong>
        <ul class="submenu">
          <li class="heading"><img src="<?=base_url()?>assets/graphics/markHeading.png" /><h3>Prospectos</h3></li>
          <li>
            <a href="<?=base_url()?>prospectos">Prospectos de plaza</a>
          </li>
        </ul>
  		</li>
  	<?php endif;
  	if(isset($user['modulos']) && in_array('contactos', $user['modulos'])):?>
  		<li class="main In">
        <strong>Contactos</strong>
        <ul class="submenu">
          <li><a title="Contactos" href="<?=base_url()?>contactos">Contactos</a></li>
        </ul>
  		</li>
  	<?php endif;
	if(isset($user['modulos']) && in_array('clientes', $user['modulos'])):?>
		<li id="planogramasHover" class="main In">
      <img alt="Prospectacion" src="<?=base_url()?>assets/graphics/svg/business.svg" />
      <strong>Clientes</strong>
      <ul class="submenu">
        <li class="heading"><img src="<?=base_url()?>assets/graphics/markHeading.png" /><h3>Clientes</h3></li>
        <li>
        <li><a href="<?=base_url()?>clientes">Clientes de plaza</a></li>
      </ul>
		</li>
	<?php endif;
  	if(isset($user['modulos']) && in_array('proveedores', $user['modulos'])):?>
  		<li class="main In">
        <strong>Proveedores</strong>
        <ul class="submenu">
          <li><a href="<?=base_url()?>proveedores">Proveedores</a></li>
        </ul>
  		</li>
	<?php endif;
	if(isset($user['modulos']) && in_array('cotizaciones', $user['modulos'])):?>
		<li id="cotizacionesHover" class="main In">
      <strong>Cotizaciones</strong>
      <ul class="submenu">
        <li class="heading"><img src="<?=base_url()?>assets/graphics/markHeading.png" /><h3>Cotizaciones</h3></li>
        <li>
        <li><a href="<?=base_url()?>cotizaciones">Cotizaciones</a></li>
      </ul>
		</li>
	<?php endif;
	if(isset($user['modulos']) && in_array('planogramas', $user['modulos'])):?>
		<li id="planogramasHover" class="main In">
      <img alt="Prospectacion" src="<?=base_url()?>assets/graphics/svg/map32.svg" />
      <strong>Planogramas</strong>
      <ul class="submenu">
        <li class="heading"><img src="<?=base_url()?>assets/graphics/markHeading.png" /><h3>Planogramas</h3></li>
        <li>
        <li><a href="<?=base_url()?>planogramas">Lista planogramas</a></li>
      </ul>
		</li>
	<?php endif;
	if(isset($user['modulos']) && in_array('renovaciones', $user['modulos'])):?>
		<li id="planogramasHover" class="main In">
      <strong>Renovaciones</strong>
		  <ul class="submenu">
		    <li><a href="<?=base_url()?>renovaciones">Renovaciones</a></li>
		  </ul>
		</li>
	<?php endif;
	if(isset($user['modulos']) && in_array('rh', $user['modulos'])):?>
		<li id="planogramasHover" class="main In">
      <strong>Recursos Humanas</strong>
      <ul class="submenu">
        <li class="heading"><img src="<?=base_url()?>assets/graphics/markHeading.png" /><h3>Recursos Humanos</h3></li>
        <li>
        <li><a href="<?=base_url()?>rh">Recursos Humanos</a></li>
      </ul>
		</li>
	<?php endif;?>
