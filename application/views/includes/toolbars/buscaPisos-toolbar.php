<!-- Solo carga si encuentra mas pisos en los mapas -->
<? foreach($infoPlano as $p):?>
<? $pisos = $this->planogramas_model->cargarPisos($p->plaza);?>
<? if (count($pisos) != 1):?>
<form id="piFor" method="post" action="<?=base_url()?>">
<h1>Nivel</h1>
<fieldset>
	<select id="selPis">
		<? foreach($pisos as $pi):?>
		<option <? if($pi->id == $this->uri->segment(3)):?>selected<?endif?> value="<?= $pi->id?>"><?= $pi->piso?></option>
		<? endforeach; ?>
	</select>
</fieldset>
</form>
<? endif; ?>
<?endforeach?>
<script>
/********************************************************************************************************************
 Manda a los planogramas de cada piso y se agarra del toolbar de ciudades y pisos
********************************************************************************************************************/
$("#selPis").change(function() {
	var action = $("#selPis").val();
	$("#piFor").attr("action", "<?=base_url()?>planogramas/<?= $this->uri->segment(2);?>/" + action);
	this.form.submit();
});
</script>
