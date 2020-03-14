<?php
	include_once("config.php");
	setcookie("nick", "");
	setcookie("clave", "");
	if(strstr($_SERVER['HTTP_REFERER'], "logout.php")!=""){
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}
	else{
		header('Location: '.url);
	}
?>