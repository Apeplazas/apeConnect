<?php $user =	$this->session->userdata('usuario');?>

  	<?php if(isset($user['modulos']) && in_array('proyectos', array_keys($user['modulos']))):?>
  		<li class="main In <?if($this->uri->segment(1) == 'proyectos'):?>bckMark<?endif?>">
        <img class="svgIcon" alt="Proyectos" src="<?=base_url()?>assets/graphics/svg/proyectos.svg" />
        <strong>Proyectos</strong>
        <ul class="submenu">
            <li class="heading"><img src="<?=base_url()?>assets/graphics/markHeading.png" /><h3>Proyectos</h3></li>
          <li><a title="Proyectos" href="<?=base_url()?>proyectos/obras">Lista de proyectos</a></li>
          <li><a href="<?=base_url()?>administrad">Cotizaciones</a></li>
        </ul>
  		</li>
  	<?php endif;

    if(isset($user['modulos']) && in_array('administador', array_keys($user['modulos']))):?>
    <li id="administradorHover" class="main In">
    <img class="svgIcon" alt="Prospectacion" src="<?=base_url()?>assets/graphics/svg/directorio.svg" />
      <strong>ADMinistrador</strong>
      <ul class="submenu">
        <li class="heading"><img src="<?=base_url()?>assets/graphics/markHeading.png" /><h3>Evaluaciones</h3></li>
        <li><a href="<?=base_url()?>evaluacionestwo">Evaluaciones 2015 - 2016</a></li>
      </ul>
    </li>
        <?php endif;


  	if(isset($user['modulos']) && in_array('prospectos', array_keys($user['modulos']))):?>
  		<li class="main In <?if($this->uri->segment(1) == 'prospectos'):?>bckMark<?endif?>">
        <img class="svgIcon" alt="Prospectacion" src="<?=base_url()?>assets/graphics/svg/user.svg" />
        <strong>Prospectos</strong>
        <ul class="submenu">
          <li class="heading"><img src="<?=base_url()?>assets/graphics/markHeading.png" /><h3>Prospectos</h3></li>
          <li>
            <a href="<?=base_url()?>prospectos">Prospectos de plaza</a>
          </li>
          <li>
            <a href="<?=base_url()?>prospectos/cotizaciones">Cotizaciones</a>
          </li>
        </ul>
  		</li>
  	<?php endif;
  	if(isset($user['modulos']) && in_array('proveedores', array_keys($user['modulos']))):?>
  		<li class="main In <?if($this->uri->segment(1) == 'proveedores'):?>bckMark<?endif?>">
        <img class="svgIcon" alt="Prospectacion" src="<?=base_url()?>assets/graphics/svg/proveedor.svg" />
        <strong>Proveedores</strong>
        <ul class="submenu">
          <li class="heading"><img src="<?=base_url()?>assets/graphics/markHeading.png" /><h3>Proveedores</h3></li>
          <li><a href="<?=base_url()?>proveedores">Proveedores</a></li>
        </ul>
  		</li>
	<?php endif;
	if(isset($user['modulos']) && in_array('planogramas', array_keys($user['modulos']))):?>
		<li id="planogramasHover" class="main In <?if($this->uri->segment(1) == 'planogramas'):?>bckMark<?endif?>">
      <img class="svgIcon" alt="Prospectacion" src="<?=base_url()?>assets/graphics/svg/map32.svg" />
      <strong>Planogramas</strong>
      <ul class="submenu">
        <li class="heading">
          <img src="<?=base_url()?>assets/graphics/markHeading.png" /><h3>Planogramas</h3>
        </li>
        <li><a href="<?=base_url()?>planogramas">Lista planogramas</a></li>
      </ul>
		</li>
  <?php endif;
  if(isset($user['modulos']) && in_array('tempciri', array_keys($user['modulos']))):?>
    <li class="main In <?if($this->uri->segment(1) == 'tempciri'):?>bckMark<?endif?>">
      <img class="svgIcon" alt="Cartas de intencion" src="<?=base_url()?>assets/graphics/svg/documents.svg" />
      <strong>Cartas intención</strong>
      <ul class="submenu">
        <li class="heading"><img src="<?=base_url()?>assets/graphics/markHeading.png" /><h3>Cartas Intencion</h3></li>
<?php //validacion temporal, el menu se tiene que generar automaticamente
		if(in_array('verCi', $user['modulos']['tempciri'])):?>
        	<li><a href="<?=base_url()?>tempciri/verCi">Listado de cartas</a></li>
        <?php endif;?>
        <?php if(in_array('ciRi', $user['modulos']['tempciri'])):?>
        	<li><a href="<?=base_url()?>tempciri/ciRi">Generar carta de intención</a></li>
        <?php endif;?>
        <?php if(in_array('detalleCis', $user['modulos']['tempciri'])):?>
        	<li><a href="<?=base_url()?>tempciri/detalleCis">Detalle de cartas</a></li>
        <?php endif;?>
      </ul>
    </li>
	<?php endif;

	if(isset($user['modulos']) && in_array('evaluacionestwo', array_keys($user['modulos']))):?>
		<li id="evaluacionesHover" class="main In">
		<img class="svgIcon" alt="Prospectacion" src="<?=base_url()?>assets/graphics/svg/evaluaciones.svg" />
      <strong>Evaluaciones</strong>
      <ul class="submenu">
        <li class="heading"><img src="<?=base_url()?>assets/graphics/markHeading.png" /><h3>Evaluaciones</h3></li>
        <li><a href="<?=base_url()?>evaluacionestwo">Evaluaciones 2015 - 2016</a></li>
      </ul>
		</li>
	<?php endif;
	if(isset($user['modulos']) && in_array('renovaciones', array_keys($user['modulos']))):?>
		<li id="renovacionesHover" class="main In">
      <strong>Renovaciones</strong>
		  <ul class="submenu">
		    <li><a href="<?=base_url()?>renovaciones">Renovaciones</a></li>
		  </ul>
		</li>
	<?php endif;
	if(isset($user['modulos']) && in_array('rh', array_keys($user['modulos']))):?>
		<li id="rhHover" class="main In">
      <strong>Recursos Humanas</strong>
      <ul class="submenu">
        <li class="heading"><img src="<?=base_url()?>assets/graphics/markHeading.png" /><h3>Recursos Humanos</h3></li>
        <li><a href="<?=base_url()?>rh">Recursos Humanos</a></li>
      </ul>
		</li>
	<?php endif;?>
