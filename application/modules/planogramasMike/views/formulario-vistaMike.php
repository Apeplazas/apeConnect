
	<div id="wrapTable">
		<form action="<?= base_url();?>planogramas/subirPlano" method="post" enctype="multipart/form-data">
			<fieldset>
				<label>
					Archivo svg
				</label>
				<input type="file" name="archivo" />
			</fieldset>
			<fieldset>
				<label>
					Plaza
				</label>
				<input type="text" name="plaza" value="" />
			</fieldset>
			<fieldset>
				<label>
					Piso
				</label>
				<select name="piso">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
				</select>
			</fieldset>
			<fieldset>
				<input type="submit" value="Subir" />
			</fieldset>
		</form>
	</div>