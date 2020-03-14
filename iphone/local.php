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
	
	$id = trim($_GET['id']);
	
	$local = new Local();
	$local = $local->info('id='.$id);
	$tamano = (80*$local->puntuacion)/5;
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
		<h1><?php echo $local->titulo; ?></h1>
		<a href="index.php" id="backButton">Inicio</a>
	</div>
	<ul class="field">
		<li class="arrow">
			<h3>Zona: </h3><a href="locales.php?zona=<?php echo $local->zona->id; ?>"><?php echo $local->zona->titulo; ?></a>
		</li>
		<li class="arrow">
			<h3>Categor&iacute;a: </h3><a href="locales.php?categoria=<?php echo $local->categoria->id; ?>"><?php echo $local->categoria->titulo; ?></a>
		</li>
		<li>
			<h3>Direcci&oacute;n: </h3><big><?php echo $local->direccion; ?></big>
		</li>
		<li>
			<h3>Puntuaci&oacute;n: </h3><big><?php echo '<div style="width:'.$tamano.'px;background:url(\'imagenes/estrella.png\') repeat-x left center;text-indent:-99em;">'.$local->puntuacion.'</div>'; ?></big>
		</li>
		<?php if($local->coordenadas[0]!="" && $local->coordenadas[1]!=""): ?>
		<li class="arrow">
			<h3>Ubicaci&oacute;n: </h3><a href="http://maps.google.com/maps?q=<?php echo $local->coordenadas[0].','.$local->coordenadas[1]; ?>">Ver mapa</a>
		</li>
		<?php endif; ?>
		<li>
			<h3>Descripci&oacute;n: </h3><big><?php echo $local->descripcion; ?></big>
		</li>
	</ul>
	<?php
		if($local->telefono){
			if(sizeof($local->telefono)==1)
				echo '<h1>Tel&eacute;fono: </h1>';
			else
				echo '<h1>Tel&eacute;fonos: </h1>';
			echo '<ul class="field">';
			foreach($local->telefono as $telefono){
				if($telefono->tipo=="delivery")
					echo '<li><h3>Delivery: </h3><a href="tel:'.$local->zona->prefijoTel.$telefono->numero.'">('.$local->zona->prefijoTel.') '.$telefono->numero.'</a></li>';
				elseif($telefono->tipo=="reservaciones")
					echo '<li><h3>Reservaciones: </h3><a href="tel:'.$local->zona->prefijoTel.$telefono->numero.'">('.$local->zona->prefijoTel.') '.$telefono->numero.'</a></li>';
			}
			echo '</ul>';
		}
	?>
</body>
</html>