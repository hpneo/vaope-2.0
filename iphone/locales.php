<?php
	include("../config.php");
	include("../clases/class.db.php");
	include("../clases/class.categoria.php");
	include("../clases/class.zona.php");
	include("../clases/class.tag.php");
	include("../clases/class.telefono.php");
	include("../clases/class.usuario.php");
	include("../clases/class.local.php");
	
	$db = new DB();
	if(trim($_GET['categoria'])=="" && trim($_GET['zona'])!=""){
		$seccion = "zonas";
		$id = trim($_GET['zona']);
		$url ="explorar.php?opcion=zonas";
	}
	elseif(trim($_GET['categoria'])!="" && trim($_GET['zona'])==""){
		$seccion = "categorias";
		$id = trim($_GET['categoria']);
		$url ="explorar.php?opcion=categorias";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta id="viewport" name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<title>Vao Pe!</title>
	<link rel="stylesheet" href="css/iphone.css" />
	<link rel="apple-touch-icon" href="imagenes/apple-touch-icon.png" />
	<script type="text/javascript" charset="utf-8">
		window.onload = function() {
		  setTimeout(function(){window.scrollTo(0, 1);}, 100);
		}
	</script>
</head>
<body>
	<div id="header">
		<h1>Vao Pe!</h1>
		<a href="<?php echo $url; ?>" id="backButton">Atr&aacute;s</a>
	</div>
	<?php
		switch($seccion){
			case 'zonas':
				$zona = new Zona();
				$zona = $zona->info('id='.$id);
				$locales = new Local();
				$locales = $locales->info('zona='.$id.'|ordenar=puntuacion');
				echo '
				<h1>Locales en '.$zona->titulo.'</h1>
					<ul>
				';
			break;
			case 'categorias':
				$categoria = new Categoria();
				$categoria = $categoria->info('id='.$id);
				$locales = new Local();
				$locales = $locales->info('categoria='.$id.'|ordenar=puntuacion');
				echo '
				<h1>Locales en la categor&iacute;a '.$categoria->titulo.'</h1>
					<ul>
				';
			break;
		}
		if(gettype($locales)=="array"){
			foreach($locales as $local){
				$tamano = (80*$local->puntuacion)/5;
				echo '<li class="arrow"><a href="local.php?id='.$local->id.'">'.$local->titulo.'</a><div style="width:'.$tamano.'px;background:url(\'imagenes/estrella.png\') repeat-x left center;text-indent:-99em;">'.$local->puntuacion.'</div></li>';
			}
		}
		else{
			$tamano = (80*$locales->puntuacion)/5;
			echo '<li class="arrow"><a href="local.php?id='.$locales->id.'">'.$locales->titulo.'</a><div style="width:'.$tamano.'px;background:url(\'imagenes/estrella.png\') repeat-x left center;text-indent:-99em;">'.$locales->puntuacion.'</div></li>';
		}
		echo '
			</ul>
		';
	?>
</body>
</html>