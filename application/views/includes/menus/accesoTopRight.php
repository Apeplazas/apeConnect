<dl class="dropdown fright">
	<dt><a class="fWhite bold med" href="<?=base_url()?>"><span>¿Como funciona?</span></a></dt>
	<dt><a class="fWhite menuForm" href="#"><span>Iniciar Sesion</span></a></dt>
	<dd>
	  <form id="log" action="<?=base_url()?>registrate/valida" method="post">
		  <input class="f90" placeholder="Usuario" name="var" type="text" />
		  <input class="f90" placeholder="Contraseña" name="password" type="password" />
		  <input type="submit" value="entrars" />
	  </form>
	</dd>
	<dt><a class="fWhite menu" href="<?=base_url()?>registrate">Registrate</a></dt>
	<dt><a class="fWhite menu" href="<?=base_url()?>">Encuentra Reparadores</a></dt>
	<dt><a class="fWhite menuDrop" href="#"><span>Busca por categoria</span></a></dt>
	<dd>
	  <ul id="catMenu">
	    <li><a href="<?=base_url()?>">Tablets</span></a></li>
	    <li><a href="<?=base_url()?>">Laptops</span></a></li>
	    <li><a href="<?=base_url()?>">Computadoras</a></li>
	    <li><a href="<?=base_url()?>">Celulares (Smartphones)</a></li>
	  </ul>
	</dd>
</dl>
<br class="clear">