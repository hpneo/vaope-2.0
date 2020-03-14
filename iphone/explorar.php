<?php
	include("../config.php");
	include("../clases/class.db.php");
	include("../clases/class.categoria.php");
	include("../clases/class.zona.php");
	
	$db = new DB();
	
	$opcion = trim($_GET['opcion']);
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
<body id="normal">
	<div id="header">
		<h1>Vao Pe!: <?php if($opcion=="categorias"): echo 'Categor&iacute;as'; else: echo 'Zonas'; endif; ?></h1>
		<a href="index.php" id="backButton">Inicio</a>
	</div>
	<?php
		switch($opcion){
			case 'categorias':
				$categorias_padre = new Categoria();
				$categorias_padre = $categorias_padre->info('idPadre=0');
				foreach($categorias_padre as $categoria_padre){
					echo '<h4>'.$categoria_padre->titulo.'</h4>';
					$categorias = $categoria_padre->info('idPadre='.$categoria_padre->id);
					echo '<ul>';
					if(gettype($categorias)=="array"){
						foreach($categorias as $categoria){
							echo '
							<li class="arrow">
								<small class="counter">'.$categoria->n_locales().'</small><a href="locales.php?categoria='.$categoria->id.'">'.$categoria->titulo.'</a>
							</li>
							';
						}
					}
					else{
						echo '
						<li class="arrow">
							<small class="counter">'.$categorias->n_locales().'</small><a href="locales.php?categoria='.$categorias->id.'">'.$categorias->titulo.'</a>
						</li>
						';
					}
					echo '</ul>';
				}
			break;
			case 'zonas':
				$zonas_padre = new Zona();
				$zonas_padre = $zonas_padre->info('idPadre=0');
				foreach($zonas_padre as $zona_padre){
					echo '<h4>'.$zona_padre->titulo.'</h4>';
					$zonas = $zona_padre->info('idPadre='.$zona_padre->id);
					echo '<ul>';
					if(gettype($zonas)=="array"){
						foreach($zonas as $zona){
							echo '
							<li class="arrow">
								<small class="counter">'.$zona->n_locales().'</small><a href="locales.php?zona='.$zona->id.'">'.$zona->titulo.'</a>
							</li>
							';
						}
					}
					else{
						echo '
						<li class="arrow">
							<small class="counter">'.$zonas->n_locales().'</small><a href="locales.php?zona='.$zonas->id.'">'.$zonas->titulo.'</a>
						</li>
						';
					}
					echo '</ul>';
				}
			break;
		}
	?>
</body>
</html>