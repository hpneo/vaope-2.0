<?php
	include_once("config.php");
	include_once("funciones.php");
	include_once("clases/class.db.php");
	include_once("clases/class.mail.php");
	include_once("clases/class.pagina.php");
	include_once("clases/class.usuario.php");
	include_once("clases/class.categoria.php");
	include_once("clases/class.zona.php");
	include_once("clases/class.tag.php");
	include_once("clases/class.media.php");
	include_once("clases/class.gmap.php");
	include_once("clases/class.local.php");
	include_once("clases/class.telefono.php");
	include_once("clases/class.comentario.php");
	include_once("plantillas.php");
	
	$db = new DB();
	if(estas_logueado()){
		$usuario = new Usuario();
	}
	inicializar();
?>