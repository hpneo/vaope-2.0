<?php
	obtener_cabecera();
?>
		<div id="cuerpo">
			<div class="mensaje info" id="bienvenida">
				<div class="cerrar"><img src="<?php home(); ?>/plantillas/imagenes/cerrar.png" id="cerrar_bienvenida" /></div>
				<h2 class="centrado">Bienvenido a Vao Pe!, tu gu&iacute;a de locales en el Per&uacute;</h2>
				<p>Si deseas buscar locales ingresa primero la categor&iacute;a y luego la zona. En ambos casos aparecerá una lista de la categor&iacute;a y zona que deseas encontrar.</p>
				<p>Tambi&eacute;n puedes ver las categor&iacute;as y las zonas listadas arriba, quiz&aacute; sea de mejor ayuda.</p>
			</div>
			<?php
				if($_GET['categoria']=="" || $_GET['zona']==""){
			?>
			<form method="get" action="<?php home(); ?>/locales.php" id="buscador_principal">
				<label for="categoria">Buscar </label>
				<input type="text" name="categoria" id="categoria" size="22" title="Escribe una categor&iacute;a" />
				<label for="zona">en</label>
				<input type="text" name="zona" id="zona" size="22" title="Escribe una zona" />
				<input type="submit" value="Vao?" class="boton" />
			</form>
			<?php
				}
				else{
				}
			?>
		</div>
<?php
	obtener_pie();
?>