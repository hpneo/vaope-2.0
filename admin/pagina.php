<?php
	$opcion = $_GET['opcion'];
	switch($opcion){
		case 'agregar':
?>
<h2>P&aacute;gina &raquo; Agregar</h2>
<?php
			if(!$_POST){
?>
<form action="?seccion=pagina&amp;opcion=agregar" method="post">
	<p>
		<label for="pagina_titulo">T&iacute;tulo:</label>
		<input type="text" name="pagina_titulo" id="pagina_titulo" size="60" />
	</p>
	<p>
		<label for="pagina_contenido">Contenido: </label>
		<script type="text/javascript">
				tinyMCE.init({
					mode : "exact",
					elements : "pagina_contenido",
					theme : "advanced",
					theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
					theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,forecolor,backcolor",
					theme_advanced_buttons3 : "hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,advhr,|,fullscreen",
					width:"600",
					height:"400",
					theme_advanced_toolbar_location : "top",
					theme_advanced_toolbar_align : "left",
					theme_advanced_statusbar_location : "none",
					theme_advanced_resizing : false
				});
		</script>
		<textarea name="pagina_contenido" id="pagina_contenido"></textarea>
	</p>
	<p>
		<input type="submit" value="Publicar" class="boton" />
	</p>
</form>
<?php
			}
			else{
				$pagina = new Pagina();
				if($pagina->agregar($_POST['pagina_titulo'], $_POST['pagina_contenido']))
					echo '<div class="mensaje exito">La p&aacute;gina ha sido creada con &eacute;xito.</div>';
				else
					echo '<div class="mensaje error">Hubo un error al crear la p&aacute;gina.</div>';
			}
		break;
		case 'administrar':
?>
<h2>P&aacute;gina &raquo; Administrar</h2>
<?php
	$paginas = new Pagina();
	$paginas = $paginas->info();
	echo '
		<table summary="Lista de P&aacute;ginas">
			<tr>
				<th>Nombre</th>
				<th colspan="3"></th>
			</tr>
	';
	foreach($paginas as $pagina){
		echo '
			<tr id="fila-'.$pagina->id.'">
				<td>
					<a href="?seccion=pagina&amp;opcion=editar&amp;id='.$pagina->id.'" title="Editar \''.$pagina->titulo.'\'">'.$pagina->titulo.'</a>
				</td>
				<td class="centrado">
					<a href="'.url.'/'.$pagina->nombre.'/" title="Ver \''.$pagina->titulo.'\'"><img src="'.url.'/admin/plantillas/imagenes/ir.png" alt="Ver" /></a>
				</td>
				<td class="centrado">
					<a href="?seccion=pagina&amp;opcion=editar&amp;id='.$pagina->id.'" title="Editar \''.$pagina->titulo.'\'"><img src="'.url.'/admin/plantillas/imagenes/editar.png" alt="Editar" /></a>
				</td>
				<td class="centrado">
					<a href="?seccion=pagina&amp;opcion=eliminar&amp;id='.$pagina->id.'" title="Eliminar \''.$pagina->titulo.'\'" class="eliminar" id="pagina-'.$pagina->id.'"><img src="'.url.'/admin/plantillas/imagenes/eliminar.png" alt="Eliminar" /></a>
				</td>
			</tr>
		';
	}
	echo '
		</table>
	';
?>
<?php
		break;
		case 'editar':
?>
<h2>P&aacute;gina &raquo; Editar</h2>
<?php
		if(!$_GET['id'] || $_GET['id']==""){
			echo "Debes elegir una pagina para editar";
		}
		else{
			$pagina = new Pagina();
			$pagina = $pagina->info('id='.$_GET['id']);
			if(!$_POST){
?>
<form action="?seccion=pagina&amp;opcion=editar&amp;id=<?php echo $_GET['id']; ?>" method="post">
	<p>
		<label for="pagina_titulo">T&iacute;tulo:</label>
		<input type="text" name="pagina_titulo" id="pagina_titulo" size="60" value="<?php echo $pagina->titulo; ?>" />
	</p>
	<p>
		<label for="pagina_contenido">Contenido: </label>
		<script type="text/javascript">
				tinyMCE.init({
					mode : "exact",
					elements : "pagina_contenido",
					theme : "advanced",
					theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
					theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,forecolor,backcolor",
					theme_advanced_buttons3 : "hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,advhr,|,fullscreen",
					width:"600",
					height:"400",
					theme_advanced_toolbar_location : "top",
					theme_advanced_toolbar_align : "left",
					theme_advanced_statusbar_location : "none",
					theme_advanced_resizing : false
				});
		</script>
		<textarea name="pagina_contenido" id="pagina_contenido"><?php echo $pagina->contenido; ?></textarea>
	</p>
	<p>
		<input type="submit" value="Editar" class="boton" />
	</p>
</form>
<?php
			}
			else{
				if($pagina->editar($_POST['pagina_titulo'], $_POST['pagina_contenido']))
					echo '<div class="mensaje exito">La p&aacute;gina ha sido editada con &eacute;xito.</div>';
				else
					echo '<div class="mensaje error">Hubo un error al editar la p&aacute;gina.</div>';
			}
		}
		break;
	}
?>