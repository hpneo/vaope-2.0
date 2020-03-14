<?php
	$url = parsear_url();
	$error = $_GET['error'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo titulo(); ?></title>
		<link href="<?php home(); ?>/plantillas/imagenes/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="<?php home(); ?>/plantillas/css/estilos.css" rel="stylesheet" type="text/css" media="all" />
		<link href="<?php home(); ?>/plantillas/css/negro.css" rel="stylesheet" type="text/css" media="all" />
		<script type="text/javascript" language="javascript" src="<?php home(); ?>/plantillas/js/editor/tiny_mce.js"></script>
		<?php
			imprimir_metatags();
			imprimir_feeds();
			imprimir_js();
		?>
	</head>
	<body>
		<div id="cabecera">
			<h1><a href="<?php home(); ?>" title="Vao Pe!"><?php echo nombre; ?></a></h1>
			<div id="opciones_cabecera">
				<?php
					if(!estas_logueado()){
				?>
				<form method="post" action="<?php home(); ?>/login.php" id="login">
					<label for="nick">Nick: </label>
					<input type="text" name="nick" id="nick" size="10" />
					<label for="clave">Contrase&ntilde;a: </label>
					<?php if($error=="2"){$clase='error';} ?>
					<input type="password" name="clave" id="clave" size="10" class="<?php echo $clase ?>" />
					<input type="submit" value="Entrar" class="boton" />
				</form>
				<a href="<?php home(); ?>/registro" class="resaltado"><img src="<?php home(); ?>/plantillas/imagenes/registrar_usuario.png" alt="Reg&iacute;strate" />Reg&iacute;strate</a>
				<?php
					}
					else{
				?>
				<ul>
					<li><a href="<?php home(); ?>/usuario/<?php echo $_COOKIE['nick']; ?>/" title="Tu Perfil"><strong>Hola, <?php echo $_COOKIE['nick']; ?></strong></a></li>
					<li><a href="<?php home(); ?>/panel/" title="Agrega, edita y elimina locales. Ah, s&iacute;, tambi&eacute;n puedes editar tus datos"><img src="<?php home(); ?>/plantillas/imagenes/llave.png" alt="Panel de Control" />Panel de Control</a></li>
					<li><a href="<?php home(); ?>/panel/agregar/" title="Agrega un local"><img src="<?php home(); ?>/plantillas/imagenes/agregar.png" alt="Agregar local" />Agregar local</a></li>
					<li><a href="<?php home(); ?>/usuario/<?php echo $_COOKIE['nick']; ?>/favoritos/" title="Ve tus locales favoritos"><img src="<?php home(); ?>/plantillas/imagenes/favorito.png" alt="Favoritos" />Favoritos</a></li>
					<li><a href="<?php home(); ?>/logout.php" title="Cierra tu sesi&oacute;n, para evitar que otro manipule tus datos"><img src="<?php home(); ?>/plantillas/imagenes/salir.png" alt="Salir" />Salir</a></li>
				</ul>
				<?php
					}
				?>
				<form method="get" action="<?php home(); ?>/buscar/" id="buscador">
					<input type="text" name="s" id="s" size="36" value="<?php echo stripslashes($_GET['s']); ?>" />
					<input type="submit" value="Buscar" class="boton" />
					<ul class="lineal">
						<li>
							<label for="criterio_etiquetas">Por etiquetas <input type="radio" name="por" value="etiquetas" id="criterio_etiquetas" <?php if($_GET['por']=="etiquetas"){ echo 'checked="checked"';} ?> /></label>
						</li>
						<li>
							<label for="criterio_nombre">Por nombre <input type="radio" name="por" value="nombre" id="criterio_nombre" <?php if($_GET['por']=="nombre"){ echo 'checked="checked"';} ?> /></label>
						</li>
						<li>
							<label for="criterio_descripcion">Por descripci&oacute;n</label><input type="radio" name="por" value="descripcion" id="criterio_descripcion" <?php if($_GET['por']=="descripcion"){ echo 'checked="checked"';} ?> />
						</li>
					</ul>
				</form>
			</div>
			<div class="lista">
				<h2 id="titulo-categorias" title="Revisa todos los locales disponibles">Categor&iacute;as</h2>
				<?php listar_categorias("lista-categorias"); ?>
			</div>
			<div class="lista">
				<h2 id="titulo-zonas" title="Revisa todas las zonas disponibles">Zonas</h2>
				<?php listar_zonas("lista-zonas"); ?>
			</div>
		</div>
<?php
	
?>