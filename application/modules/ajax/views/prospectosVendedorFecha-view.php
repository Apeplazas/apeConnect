<div id="infoAvaVen">
	<? foreach($cuenta as $c):?>
	<span class="canCue">Cantidad <?= $c->cuenta;?></span> | <span class="nomCom"><span>Nombre del Vendedor <?= $c->nombreCompleto;?></span>
	<? endforeach; ?>
</div>
				
			
<table id="tablaAvan">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Estado</th>
				<th><span class="Rtel">Telefono</span></th>
				<th>Dirección</th>
				<th><span class="Rori">Vendedor</span></th>
				<th>Fecha Creación</th>
				<th></th>
			</tr>
		</thead>
		<tbody id="pros">
			<? foreach($data as $p):?>
			<tr  id="<?= $p->id;?>">
				<td>
					<a class="Rema" href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>">
						<span class="bold"><?= $p->pnombre;?> <?= $p->snombre;?> <?= $p->apellidop;?> <?= $p->apellidom;?></span>
						<br><?= $p->correo;?>
					</a>
				</td>
				<td><a class="tbEst" href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>"><?= $p->estado?></a></td>
				<td>
					<a class="Rtel" href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>">
						<? if($p->telefono):?><em class="sp">Tel:</em><?=$p->telefono;?><br><?endif;?>
						<? if($p->celular):?><em class="sp">Cel:</em><?=$p->celular;?><?endif;?>
					</a>
				</td>
				<td>
					<a href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>">
						<span class="priSeg"> <? if($p->calle):?>Calle: <?=$p->calle;?><br><?endif;?>
						<? if($p->numeroInt):?>Int: <?=$p->numeroInt;?><br><?endif;?>
						<? if($p->numeroExt):?>Ext: <?=$p->numeroExt;?><?endif;?>
						</span>
						<span class="segSeg">
						<? if($p->municipio):?>Colonia: <?=$p->municipio;?><br><?endif;?>
						<? if($p->colonia):?>Colonia: <?=$p->colonia;?><br><?endif;?>
						<? if($p->cp):?>CP: <?=$p->cp;?><?endif;?>
						</span>
					</a>
				</td>
				<td><a class="Rori" href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>"><?= $p->nombreCompleto?></a></td>
				<td><a class="fCr" href="<?=base_url()?>prospectos/usuarios/<?= $p->id;?>"><?= ucfirst($p->fechaCreacion)?></a></td>
			</tr>
			<? endforeach; ?>
		</tbody>
</table>