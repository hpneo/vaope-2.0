<?php
	include_once("config.php");
	include_once("funciones.php");
	include_once("clases/class.db.php");
	include_once("clases/class.usuario.php");
	
	$db = new DB();
	
	$nick = trim($_POST['registro_nick']);
	$clave = trim($_POST['registro_clave']);
	$email = trim($_POST['registro_email']);
	if($nick=="" || $clave=="" || $email==""){
		die('Faltan datos.');
	}
	else{
		if(!validar_email($email))
			die('El email no es v&aacute;lido');
		$usuario = new Usuario();
		if($usuario->agregar($nick, $clave, "", "no", $email, "")){
			setcookie('nick', mysql_real_escape_string(htmlentities(trim($nick), ENT_QUOTES, "utf-8")), time()+3600*24*365);
			setcookie('clave', md5(mysql_real_escape_string(htmlentities(trim($clave), ENT_QUOTES, "utf-8"))), time()+3600*24*365);
			header("Location: ".url);
		}
	}
?>