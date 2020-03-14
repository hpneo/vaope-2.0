<?php
	obtener_cabecera();
?>
	<div id="cuerpo">
		<h4>Registro</h4>
		<form id="registro" action="<?php home(); ?>/registro.php" method="post">
			<p>
				<label for="registro_nick">Nick:</label>
				<input type="text" name="registro_nick" id="registro_nick" class="validate['required','length[5,16]','alphanum'] text-input" />
			</p>
			<p>
				<label for="registro_clave">Contrase&ntilde;a:</label>
				<input type="password" name="registro_clave" id="registro_clave" class="validate['required','length[6,-1]','alphanum'] text-input" />
			</p>
			<p>
				<label for="registro_email">E-mail:</label>
				<input type="text" name="registro_email" id="registro_email" class="validate['required','email'] text-input" />
			</p>
			<input type="submit" value="Registrar" class="submit boton" />
		</form>
	</div>
<?php
	obtener_pie();
?>