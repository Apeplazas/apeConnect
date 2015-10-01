<? foreach($Nvector as $v):?>
<div id="infoCuenta">
<? if (!$local):?>
<span class="noAsignado"><em>Segmento no asignado</em></span>
<? endif;?>
<span class="lineAc" title="<?= $v->id;?>"> <button id="<?= $v->status;?>">Activar</button><em>Status</em></span>

</div>
<? endforeach; ?> 
