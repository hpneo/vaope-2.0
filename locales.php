<?php
	include_once("config.php");
	include_once("funciones.php");
	include_once("plantillas.php");
	include_once("clases/class.db.php");
	include_once("clases/class.pagina.php");
	include_once("clases/class.categoria.php");
	include_once("clases/class.zona.php");
	
	$db = new DB();
	
	if(trim($_GET['categoria'])!="" && trim($_GET['zona'])==""){
		$categoria = new Categoria();
		$categoria = $categoria->info('titulo='.htmlentities(trim($_GET['categoria']), ENT_QUOTES, "utf-8"));
		if(existe('categoria', $categoria->nombre)){
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: ".url."/categoria/".$categoria->nombre."/");
		}
		else{
			if(existe('categoria', crear_nombre($_GET['categoria']))){
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: ".url."/categoria/".crear_nombre($_GET['categoria'])."/");
			}
			else{
				include('plantillas/404.php');
			}
		}
	}
	elseif(trim($_GET['zona'])!="" && trim($_GET['categoria'])==""){
		$zona = new Zona();
		$zona = $zona->info('titulo='.htmlentities(trim($_GET['zona']), ENT_QUOTES, "utf-8"));
		if(existe('zona', $zona->nombre)){
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: ".url."/zona/".$zona->nombre."/");
		}
		else{
			if(existe('zona', crear_nombre($_GET['zona']))){
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: ".url."/zona/".crear_nombre($_GET['zona'])."/");
			}
			else{
				include('plantillas/404.php');
			}
		}
	}
	elseif(trim($_GET['categoria'])!="" && trim($_GET['zona'])!=""){
		$categoria = new Categoria();
		$categoria = $categoria->info('titulo='.htmlentities(trim($_GET['categoria']), ENT_QUOTES, "utf-8"));
		$zona = new Zona();
		$zona = $zona->info('titulo='.htmlentities(trim($_GET['zona']), ENT_QUOTES, "utf-8"));
		if(existe('categoria', $categoria->nombre) && existe('zona', $zona->nombre)){
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: ".url."/locales/".$zona->nombre."/".$categoria->nombre."/");
		}
		else{
			if(existe('categoria', crear_nombre($_GET['categoria'])) && existe('zona', crear_nombre($_GET['zona']))){
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: ".url."/locales/".crear_nombre($_GET['zona'])."/".crear_nombre($_GET['categoria'])."/");
			}
			else{
				include('plantillas/404.php');
			}
		}
	}
?>