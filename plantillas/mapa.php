<?php
	include_once("../config.php");
	include_once("../funciones.php");
	include_once("../clases/class.db.php");
	include_once("../clases/class.usuario.php");
	include_once("../clases/class.categoria.php");
	include_once("../clases/class.zona.php");
	include_once("../clases/class.tag.php");
	include_once("../clases/class.local.php");
	include_once("../clases/class.telefono.php");
	include_once("../clases/class.comentario.php");
	include_once("../clases/class.gmap.php");
	$db = new DB();
	$zona = new Zona();
	$zona = $zona->info('nombre='.$_GET['zona']);
	$categoria = new Categoria();
	$categoria = $categoria->info('nombre='.$_GET['categoria']);
	$local = new Local();
	if(!$_GET['categoria'] || $_GET['categoria']=="")
		$locales = $local->info('zona='.$zona->id);
	else
		$locales = $local->info('zona='.$zona->id.'|categoria='.$categoria->id);
	$div['id'] = 'map';
	$div['width'] = '100%';
	$div['height'] = '400px';
	$GMap = new GMap(gmaps_api_key, $div);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Mapa</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<style type="text/css">
		body{
			font-family:"Trebuchet MS";
			font-size:medium;
			margin:0;
			padding:0;
		}
		h4{
			margin:0;
			padding:0;
		}
		a{
			color:#333333;
			text-decoration:none;
		}
		a:hover{
			text-decoration:underline;
		}
		p{
			margin:4px;
			padding:2px;
		}
	</style>
	<?php $GMap->print_header(); ?>
</head>
<body>
	<?php
		$GMap->center['lat'] = $zona->coordenadas[0];
		$GMap->center['long'] = $zona->coordenadas[1];
		$GMap->zoom = 14;
		if($locales){
			foreach($locales as $local){
				$contenido = '<h4>'.$local->titulo.'</h4><p><a href=\"'.url.'/local/'.$local->nombre.'/\">Ver local &raquo;</a></p>';
				$GMap->add_marker($local->coordenadas[0], $local->coordenadas[1], 'http://www.gmaplive.com/marker_hex.php?n=20&hex=6699cc', $local->titulo, $contenido, false);
			}
		}
		$GMap->print_map();
	?>
</body>
</html>