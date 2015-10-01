<div id="mainTit">Lista de Vendedores y Gerentes de Plaza</div>
<?= $this->session->flashdata('msg'); ?>
<form id="wrapTableTwo" action="<?=base_url()?>" method="post" >
<? foreach($profile as $row):?>
	<span id="head"></span>
	<table id="tablaproveed" class="display">
		<thead> 
			<tr> 
				<th>Nombre</th>
				<th>Puesto</th> 
				<th>PLaza</th> 
			</tr> 
		</thead> 
		<tbody>
			<?php foreach($empleados as $rowO):?>
				<tr>
					<th class="asigPro"><a class="fle100" href="<?=base_url()?>rh/editUser/<?=$rowO->usuarioID;?>"><span><?=$rowO->nombreCompleto;?></span></a></th>
					<th><?=$rowO->nombre;?></th>
				</tr>
			<?php endforeach;?>
		</tbody> 
	</table>
<? endforeach; ?>
</form>

<div id="addDisplay" style="display:none;">
	<h3>Agregar Proyecto</h3>
	<fieldset>
		<label>Titulo Proyecto</label>
		<input id="bckBuscar" type="text" class="inBut" name="titProy" />
	</fieldset>
	<fieldset>
		<label>Tipo Proyecto</label>
		<select id="tipProy" name="tipProy" class="selRegBig">
	    <option selected >Elige una opción</option>
	    <? foreach($tipos as $rowTip):?>
	    <option value="<?= $rowTip->idTipo;?>"><?= $rowTip->tipo;?></option>
	    <? endforeach; ?>
		</select>
	</fieldset>
	<fieldset>
		<label>Fecha Cierre Licitación</label>
		<span id="calen"><input name="fechaCierre" type="text" id="datepicker" class="inSmall" placeholder="año/mes/dia"><img src="<?=base_url()?>assets/graphics/calendar.jpg" alt="" /></span>
	</fieldset>
	<fieldset>
		<label>Costo aproximado por proyecto</label>
		<select id="costProy" name="costProy" class="selRegBig">
	    <option selected value="" >Elige una opción</option>
	    <? foreach($rango as $rowR):?>
	    <option value="<?= $rowR->idRango;?>"><?= $rowR->rangoMaximo;?></option>
	    <? endforeach; ?>
		</select>
	</fieldset>
	<fieldset>
		<label>Proyecto Ubicación</label>
		<select id="ubiProy" name="ubiProy" class="selRegBig">
	    <option selected value="" >Elige una opción</option>
	    <? foreach($zonas as $rowZ):?>
	    <option value="<?= $rowZ->idZona;?>"><?= $rowZ->zona;?></option>
	    <? endforeach; ?>
		</select>
	</fieldset>
	<fieldset>
		<textarea class="textMed" id="proyDesc" name="proyDesc" placeholder="Descripción del proyecto"></textarea>
	</fieldset>
	<fieldset>
		<input class="botOra fWhite crear" type="submit" value="Crear proyecto" />
	</fieldset>