<?php
	$opcion = $_GET['opcion'];
	switch($opcion){
		case 'agregar':
?>
<h2>Zona &raquo; Agregar</h2>
<?php
			if(!$_POST){
?>
<form action="?seccion=zona&amp;opcion=agregar" method="post">
	<p>
		<label for="zona_titulo">T&iacute;tulo: </label>
		<input type="text" name="zona_titulo" id="zona_titulo" size="30" />
	</p>
	<p>
		<label for="zona_idPadre">Zona Padre: </label>
		<select name="zona_idPadre" id="zona_idPadre">
			<option value="0" selected="selected">Esta es una zona padre</option>
			<?php
				$zonas = new Zona();
				$zonas = $zonas->info('idPadre=0');
				foreach($zonas as $zona){
					echo '<option value="'.$zona->id.'">'.$zona->titulo.'</option>';
				}
			?>
		</select>
	</p>
	<p>
		<label for="zona_prefijoTel">Prefijo Telef&oacute;nico: </label>
		<input type="text" name="zona_prefijoTel" id="zona_prefijoTel" size="10" />
	</p>
	<p>
		<label for="zona_mapa">Mapa: </label>
	</p>
	<div id="zona_mapa"></div>
	<p>
		<input type="hidden" name="zona_coordenadas" id="zona_coordenadas" />
		<input type="submit" value="Agregar" class="boton" />
	</p>
</form>
<?php
			}
			else{
				$idPadre = trim($_POST['zona_idPadre']);
				$titulo = $_POST['zona_titulo'];
				$prefijo = $_POST['zona_prefijoTel'];
				$coordenadas = $_POST['zona_coordenadas'];
				
				$zona = new Zona();
				if($zona->agregar($idPadre, $titulo, $prefijo, $coordenadas))
					echo '<div class="mensaje exito">La zona ha sido creada con &eacute;xito.</div>';
				else
					echo '<div class="mensaje error">Hubo un error al crear la zona.</div>';
			}
		break;
		case 'administrar':
?>
<h2>Zona &raquo; Administrar</h2>
<?php
			$zonas_padre = new Zona();
			$zonas_padre = $zonas_padre->info('idPadre=0');
			echo '
				<table summary="Lista de Zonas">
					<tr>
						<th>Nombre</th>
						<th colspan="3"></th>
					</tr>
			';
			foreach($zonas_padre as $zona_padre){
				echo '
					<tr class="padre">
						<td>'.$zona_padre->titulo.'</td>
						<td colspan="3" class="centrado"><a href="?seccion=zona&amp;opcion=editar&amp;id='.$zona_padre->id.'" title="Editar \''.$zona_padre->titulo.'\'"><img src="'.url.'/admin/plantillas/imagenes/editar.png" alt="Editar" /></a></td>
					</tr>
				';
				$zonas = new Zona();
				$zonas = $zonas->info('idPadre='.$zona_padre->id);
				if(gettype($zonas)=="array"){
					foreach($zonas as $zona){
						echo '
							<tr class="hijo" id="fila-'.$zona->id.'">
								<td>
									<a href="?seccion=zona&amp;opcion=editar&amp;id='.$zona->id.'" title="Editar \''.$zona->titulo.'\'">'.$zona->titulo.'</a>
								</td>
								<td class="centrado">
									<a href="'.url.'/zona/'.$zona->nombre.'/" title="Ver \''.$zona->titulo.'\'"><img src="'.url.'/admin/plantillas/imagenes/ir.png" alt="Ver" /></a>
								</td>
								<td class="centrado">
									<a href="?seccion=zona&amp;opcion=editar&amp;id='.$zona->id.'" title="Editar \''.$zona->titulo.'\'"><img src="'.url.'/admin/plantillas/imagenes/editar.png" alt="Editar" /></a>
								</td>
								<td class="centrado">
									<a href="?seccion=zona&amp;opcion=eliminar&amp;id='.$zona->id.'" title="Eliminar \''.$zona->titulo.'\'" class="eliminar_zona" id="zona-'.$zona->id.'"><img src="'.url.'/admin/plantillas/imagenes/eliminar.png" alt="Eliminar" /></a>
								</td>
							</tr>
						';
					}
				}
				else{
					echo '
							<tr class="hijo" id="fila-'.$zonas->id.'">
								<td>
									<a href="?seccion=zona&amp;opcion=editar&amp;id='.$zonas->id.'" title="Editar \''.$zonas->titulo.'\'">'.$zonas->titulo.'</a>
								</td>
								<td class="centrado">
									<a href="'.url.'/zona/'.$zonas->nombre.'/" title="Ver \''.$zonas->titulo.'\'"><img src="'.url.'/admin/plantillas/imagenes/ir.png" alt="Ver" /></a>
								</td>
								<td class="centrado">
									<a href="?seccion=zona&amp;opcion=editar&amp;id='.$zonas->id.'" title="Editar \''.$zonas->titulo.'\'"><img src="'.url.'/admin/plantillas/imagenes/editar.png" alt="Editar" /></a>
								</td>
								<td class="centrado">
									<a href="?seccion=zona&amp;opcion=eliminar&amp;id='.$zonas->id.'" title="Eliminar \''.$zonas->titulo.'\'" class="eliminar_categoria" id="zona-'.$zonas->id.'"><img src="'.url.'/admin/plantillas/imagenes/eliminar.png" alt="Eliminar" /></a>
								</td>
							</tr>
						';
				}
			}
			echo '
				</table>
			';
		break;
		case 'editar':
?>
<h2>Zona &raquo; Editar</h2>
<?php
			if(!$_GET['id'] || $_GET['id']==""){
				echo "Debes elegir una zona para editar";
			}
			else{
				$zona = new Zona();
				$zona = $zona->info('id='.trim($_GET['id']));
				if(!$_POST){
?>
<form action="?seccion=zona&amp;opcion=editar&amp;id=<?php echo $zona->id; ?>" method="post">
	<p>
		<label for="zona_titulo">T&iacute;tulo: </label>
		<input type="text" name="zona_titulo" id="zona_titulo" size="30" value="<?php echo $zona->titulo; ?>" />
	</p>
	<p>
		<label for="zona_idPadre">Zona Padre: </label>
		<select name="zona_idPadre" id="zona_idPadre">
			<option value="0" selected="selected">Esta es una zona padre</option>
			<?php
				$zonas = new Zona();
				$zonas = $zonas->info('idPadre=0');
				foreach($zonas as $_zona){
					if($zona->idPadre==$_zona->id)
						echo '<option value="'.$_zona->id.'" selected="selected">'.$_zona->titulo.'</option>';
					else
						echo '<option value="'.$_zona->id.'">'.$_zona->titulo.'</option>';
				}
			?>
		</select>
	</p>
	<p>
		<label for="zona_prefijoTel">Prefijo Telef&oacute;nico: </label>
		<input type="text" name="zona_prefijoTel" id="zona_prefijoTel" size="10" value="<?php echo $zona->prefijoTel; ?>" />
	</p>
	<p>
		<input type="submit" value="Editar" class="boton" />
	</p>
</form>
<?php
				}
				else{
					if($zona->editar($_POST['zona_idPadre'], $_POST['zona_titulo'], $_POST['zona_prefijoTel']))
						echo '<div class="mensaje exito">La zona ha sido editada con &eacute;xito.</div>';
					else
						echo '<div class="mensaje error">Hubo un error al editar la zona.</div>';
				}
			}
		break;
	}
?>