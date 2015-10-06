<?php $user =	$this->session->userdata('usuario');?>
<aside id="bar">
<ul>
  	<li class="prel inactive">
  	  <a href="<?=base_url()?>">
  	    <span class="fijo" ><img src="<?=base_url()?>assets/graphics/inicio.png" alt="Obras y Proyectos" /></span>
  	    <em>Dashboard</em>
  	  </a>
  	</li>
  	<?php if(isset($user['modulos']) && in_array('proyectos', $user['modulos'])):?>
  		<li class="prel <? if ($this->uri->segment(1) == 'proyectos'):?>active<? else:?>inactive<? endif?>">
  		  <a href="<?=base_url()?>proyectos/obras">
  		    <span class="icon"><img src="<?=base_url()?>assets/graphics/obras.png" alt="Obras y Proyectos" /></span>
  		    <em>Proyectos</em>
  		  </a>
  		</li>
  	<?php endif;
  	if(isset($user['modulos']) && in_array('proveedores', $user['modulos'])):?>
  		<li class="prel <? if ($this->uri->segment(1) == 'proveedores'):?>active<? else:?>inactive<? endif?>">
  		  <a href="<?=base_url()?>proveedores">
  		    <span class="icon"><img src="<?=base_url()?>assets/graphics/proveedores.png" alt="Proveedores" /></span>
  		    <em>Proveedores</em>
  		  </a>
  		</li>
	<?php endif;
	if(isset($user['modulos']) && in_array('cotizaciones', $user['modulos'])):?>
		<li class="prel <? if ($this->uri->segment(1) == 'cotizaciones'):?>active<? else:?>inactive<? endif?>">
		  <a href="<?=base_url()?>cotizaciones">
		  <span class="icon"><img src="<?=base_url()?>assets/graphics/cotizaciones.png" alt="Proveedores" /></span>
		  <em>Cotizaciones</em>
		  </a>
		</li>
	<?php endif;
	if(isset($user['modulos']) && in_array('planogramas', $user['modulos'])):?>
		<li class="prel <? if ($this->uri->segment(1) == 'planogramas'):?>active<? else:?>inactive<? endif?>">
		  <a href="<?=base_url()?>planogramas">
		  <span class="icon"><img src="<?=base_url()?>assets/graphics/cotizaciones.png" alt="planogramas" /></span>
		  <em>planogramas</em>
		  </a>
		</li>
	<?php endif;?>
  	<li class="prel inactive">
  	  <a href="<?=base_url()?>soporte">
  	    <span class="icon"><img src="<?=base_url()?>assets/graphics/soporte.png" alt="Soporte" /></span>
  	    <em>Soporte</em>
  	  </a>
  	</li>
</ul>
</aside>
