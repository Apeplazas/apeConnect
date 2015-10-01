<?php $user =	$this->session->userdata('usuario');?>
<ul id="menu">
  	<?php if(isset($user['modulos']) && in_array('proyectos', $user['modulos'])):?>		
  		<li class="<? if ($this->uri->segment(1) == 'proyectos'):?>active<? else:?>inactive<? endif?>">
  		  <a href="<?=base_url()?>proyectos/obras">Proyectos</a>
  		</li>
  	<?php endif;
  	if(isset($user['modulos']) && in_array('prospectos', $user['modulos'])):?>
  		<li class="prel <? if ($this->uri->segment(1) == 'prospectos'):?>active<? else:?>inactive<? endif?>">
  		  <a href="<?=base_url()?>prospectos">Prospectos</a>
  		</li>
  	<?php endif;
  	if(isset($user['modulos']) && in_array('contactos', $user['modulos'])):?>
  		<li class="prel <? if ($this->uri->segment(1) == 'contactos'):?>active<? else:?>inactive<? endif?>">
  		  <a href="<?=base_url()?>contactos">Contactos</a>
  		</li>
  	<?php endif;
	if(isset($user['modulos']) && in_array('clientes', $user['modulos'])):?>
		<li id="planogramasHover" class="prel <? if ($this->uri->segment(1) == 'clientes'):?>active<? else:?>inactive<? endif?>">
		  <a href="<?=base_url()?>clientes">Clientes</a>
		</li>
	<?php endif;
  	if(isset($user['modulos']) && in_array('proveedores', $user['modulos'])):?>
  		<li class="prel <? if ($this->uri->segment(1) == 'proveedores'):?>active<? else:?>inactive<? endif?>">
  		  <a href="<?=base_url()?>proveedores">Proveedores</a>
  		</li>
	<?php endif;
	if(isset($user['modulos']) && in_array('cotizaciones', $user['modulos'])):?>
		<li id="cotizacionesHover" class="prel <? if ($this->uri->segment(1) == 'cotizaciones'):?>active<? else:?>inactive<? endif?>">
		  <a href="<?=base_url()?>cotizaciones">Cotizaciones</a>
		</li>
	<?php endif;
	if(isset($user['modulos']) && in_array('planogramas', $user['modulos'])):?>
		<li id="planogramasHover" class="prel <? if ($this->uri->segment(1) == 'planogramas'):?>active<? else:?>inactive<? endif?>">
		  <a href="<?=base_url()?>planogramas">Planogramas</a>
		</li>
	<?php endif;
	if(isset($user['modulos']) && in_array('renovaciones', $user['modulos'])):?>
		<li id="planogramasHover" class="prel <? if ($this->uri->segment(1) == 'renovaciones'):?>active<? else:?>inactive<? endif?>">
		  <a href="<?=base_url()?>renovaciones">Renovaciones</a>
		</li>
	<?php endif;
	if(isset($user['modulos']) && in_array('rh', $user['modulos'])):?>
		<li id="planogramasHover" class="prel <? if ($this->uri->segment(1) == 'rh'):?>active<? else:?>inactive<? endif?>">
		  <a href="<?=base_url()?>rh">Recursos Humanos</a>
		</li>
	<?php endif;?>
</ul>