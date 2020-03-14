<?php
	$opcion = $_GET['opcion'];
	switch($opcion){
		case 'agregar':
?>
<h2>Categor&iacute;a &raquo; Agregar</h2>
<?php
			if(!$_POST){
?>
<form action="?seccion=categoria&amp;opcion=agregar" method="post">
	<p>
		<label for="categoria_titulo">T&iacute;tulo: </label>
		<input type="text" name="categoria_titulo" id="categoria_titulo" size="30" />
	</p>
	<p>
		<label for="categoria_idPadre">Categor&iacute;a Padre: </label>
		<select name="categoria_idPadre" id="categoria_idPadre">
			<option selected="selected" value="0">Esta es una categor&iacute;a padre</option>
			<?php
				$categorias = new Categoria();
				$categorias = $categorias->info('idPadre=0');
				foreach($categorias as $categoria){
					echo '<option value="'.$categoria->id.'">'.$categoria->titulo.'</option>';
				}
			?>
		</select>
	</p>
	<p>
		<input type="submit" value="Agregar" class="boton" />
	</p>
</form>
<?php
			}
			else{
				$idPadre = trim($_POST['categoria_idPadre']);
				$titulo = $_POST['categoria_titulo'];
				$categoria = new Categoria();
				if($categoria->agregar($idPadre, $titulo))
					echo '<div class="mensaje exito">La categor&iacute;a ha sido creada con &eacute;xito.</div>';
				else
					echo '<div class="mensaje error">Hubo un error al crear la categor&iacute;a.</div>';
			}
		break;
		case 'administrar':
?>
<h2>Categor&iacute;a &raquo; Administrar</h2>
<?php
			$categorias_padre = new Categoria();
			$categorias_padre = $categorias_padre->info('idPadre=0');
			echo '
				<table summary="Lista de Categor&iacute;as">
					<tr>
						<th>Nombre</th>
						<th colspan="3"></th>
					</tr>
			';
			foreach($categorias_padre as $categoria_padre){
				echo '
					<tr class="padre">
						<td>'.$categoria_padre->titulo.'</td>
						<td colspan="3" class="centrado"><a href="?seccion=categoria&amp;opcion=editar&amp;id='.$categoria_padre->id.'" title="Editar \''.$categoria_padre->titulo.'\'"><img src="'.url.'/admin/plantillas/imagenes/editar.png" alt="Editar" /></a></td>
					</tr>
				';
				$categorias = new Categoria();
				$categorias = $categorias->info('idPadre='.$categoria_padre->id);
				if(gettype($categorias)=="array"){
					foreach($categorias as $categoria){
						echo '
							<tr class="hijo" id="fila-'.$categoria->id.'">
								<td>
									<a href="?seccion=categoria&amp;opcion=editar&amp;id='.$categoria->id.'" title="Editar \''.$categoria->titulo.'\'">'.$categoria->titulo.'</a>
								</td>
								<td class="centrado">
									<a href="'.url.'/categoria/'.$categoria->nombre.'/" title="Ver \''.$categoria->titulo.'\'"><img src="'.url.'/admin/plantillas/imagenes/ir.png" alt="Ver" /></a>
								</td>
								<td class="centrado">
									<a href="?seccion=categoria&amp;opcion=editar&amp;id='.$categoria->id.'" title="Editar \''.$categoria->titulo.'\'"><img src="'.url.'/admin/plantillas/imagenes/editar.png" alt="Editar" /></a>
								</td>
								<td class="centrado">
									<a href="?seccion=categoria&amp;opcion=eliminar&amp;id='.$categoria->id.'" title="Eliminar \''.$categoria->titulo.'\'" class="eliminar_categoria" id="categoria-'.$categoria->id.'"><img src="'.url.'/admin/plantillas/imagenes/eliminar.png" alt="Eliminar" /></a>
								</td>
							</tr>
						';
					}
				}
				else{
					echo '
							<tr class="hijo" id="fila-'.$categorias->id.'">
								<td>
									<a href="?seccion=categoria&amp;opcion=editar&amp;id='.$categorias->id.'" title="Editar \''.$categorias->titulo.'\'">'.$categorias->titulo.'</a>
								</td>
								<td class="centrado">
									<a href="'.url.'/categoria/'.$categorias->nombre.'/" title="Ver \''.$categorias->titulo.'\'"><img src="'.url.'/admin/plantillas/imagenes/ir.png" alt="Ver" /></a>
								</td>
								<td class="centrado">
									<a href="?seccion=categoria&amp;opcion=editar&amp;id='.$categorias->id.'" title="Editar \''.$categorias->titulo.'\'"><img src="'.url.'/admin/plantillas/imagenes/editar.png" alt="Editar" /></a>
								</td>
								<td class="centrado">
									<a href="?seccion=categoria&amp;opcion=eliminar&amp;id='.$categorias->id.'" title="Eliminar \''.$categorias->titulo.'\'" class="eliminar_categoria" id="categoria-'.$categorias->id.'"><img src="'.url.'/admin/plantillas/imagenes/eliminar.png" alt="Eliminar" /></a>
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
<h2>Categor&iacute;a &raquo; Editar</h2>
<?php
			if(!$_GET['id'] || $_GET['id']==""){
				echo "Debes elegir una categor&iacute;a para editar";
			}
			else{
				$categoria = new Categoria();
				$categoria = $categoria->info('id='.trim($_GET['id']));
				if(!$_POST){
?>
<form action="?seccion=categoria&amp;opcion=editar&amp;id=<?php echo $categoria->id; ?>" method="post">
	<p>
		<label for="categoria_titulo">T&iacute;tulo: </label>
		<input type="text" name="categoria_titulo" id="categoria_titulo" size="30" value="<?php echo $categoria->titulo; ?>" />
	</p>
	<p>
		<label for="categoria_idPadre">Categor&iacute;a Padre: </label>
		<select name="categoria_idPadre" id="categoria_idPadre">
			<option value="0" selected="selected">Esta es una categor&iacute;a padre</option>
			<?php
				$categorias = new Categoria();
				$categorias = $categorias->info('idPadre=0');
				foreach($categorias as $_categoria){
					if($categoria->idPadre==$_categoria->id)
						echo '<option value="'.$_categoria->id.'" selected="selected">'.$_categoria->titulo.'</option>';
					else
						echo '<option value="'.$_categoria->id.'">'.$_categoria->titulo.'</option>';
				}
			?>
		</select>
	</p>
	<p>
		<input type="submit" value="Editar" class="boton" />
	</p>
</form>
<?php
				}
				else{
					if($categoria->editar($_POST['categoria_idPadre'], $_POST['categoria_titulo']))
						echo '<div class="mensaje exito">La categor&iacute;a ha sido editada con &eacute;xito.</div>';
					else
						echo '<div class="mensaje error">Hubo un error al editar la categor&iacute;a.</div>';
				}
			}
		break;
	}
?>