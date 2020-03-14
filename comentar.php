<?php
	include_once("config.php");
	include_once("funciones.php");
	include_once("clases/class.db.php");
	include_once("clases/class.comentario.php");
	
	$db = new DB();
	$comentario = new Comentario();
	$comentario->comentar($_POST['autor_comentario'], $_POST['local_comentario'], $_POST['cuerpo_comentario']);
?>