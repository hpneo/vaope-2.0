<?php
	include_once("config.php");
	include_once("funciones.php");
	include_once("clases/class.db.php");
	include_once("clases/class.usuario.php");
	
	$db = new DB();
	$usuario = new Usuario();
	
	if((!$_POST['nick'] || $_POST['nick']=="") && (!$_POST['clave'] || $_POST['clave']=="")){
		if(strstr($_SERVER['HTTP_REFERER'], "login.php")!=""){
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}
		else{
			header('Location: '.url);
		}
	}
	else{
		$nick = mysql_real_escape_string(htmlentities(trim($_POST['nick']), ENT_QUOTES, "utf-8"));
		$clave = mysql_real_escape_string(htmlentities(trim($_POST['clave']), ENT_QUOTES, "utf-8"));
		$usuario = $usuario->info('nick='.$nick);
		if(!$usuario){
			die("El usuario no existe.");
		}
		else{
			if($usuario->clave!=md5($clave)){
				die("La clave no concuerda.");
			}
			else{
				setcookie('nick', $nick, time()+3600*24*365);
				setcookie('clave', md5($clave), time()+3600*24*365);
				if(strstr($_SERVER['HTTP_REFERER'], "login.php")!=""){
					header('Location: '.$_SERVER['HTTP_REFERER']);
				}
				else{
					header('Location: '.url);
				}
			}
		}
	}
?>