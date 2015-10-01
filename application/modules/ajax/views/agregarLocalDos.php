<div id="infoCuenta">
<? foreach($vector as $v):?>
<? if (!$local):?>
<span class="noAsignado"><em>Segmento no asignado</em></span>
<? endif;?>
<span class="lineAc" title="<?= $v->id;?>"> <button id="<?= $v->status;?>">Activar</button><em>Status</em></span>
<? endforeach; ?>
</div>

<script>
$(".lineAc").click(function() {
	var id = $(this).attr("title");
	$.post("<?=base_url()?>ajax/statusVector", {
		id : id
	}, function(data) {
		$("#forma").empty().append(data);
		$("#forma").removeAttr("disabled");
	});
})
</script>