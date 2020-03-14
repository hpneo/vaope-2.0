<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Vao Pe! &raquo; Admin</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="<?php home(); ?>/admin/plantillas/estilos.css" rel="stylesheet" type="text/css" media="all" />
		<script type="text/javascript" language="javascript" src="<?php home(); ?>/plantillas/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="<?php home(); ?>/plantillas/js/editor/tiny_mce.js"></script>
		<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo gmaps_api_key; ?>" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".eliminar").click(function(event){
					event.preventDefault();
					var id = $(this).attr("id");
					var id = id.substring(7);
					if(confirm("¿Estás seguro de querer eliminar esta página?")==true){
						$.ajax({
							type: "GET",
							url: "<?php home(); ?>/ajax.php",
							data: "accion=eliminar_pagina&id="+id,
							success: function(text){
								if(text=="OK"){
									$("#fila-"+id).fadeOut("slow");
								}
							}
						});
					}
				});
				$(".eliminar_categoria").click(function(event){
					event.preventDefault();
					var id = $(this).attr("id");
					var id = id.substring(10);
					if(confirm("¿Estás seguro de querer eliminar esta categoría?")==true){
						$.ajax({
							type: "GET",
							url: "<?php home(); ?>/ajax.php",
							data: "accion=eliminar_categoria&id="+id,
							success: function(text){
								if(text=="OK"){
									$("#fila-"+id).fadeOut("slow");
								}
							}
						});
					}
				});
				$("#zona_idPadre").change(function(){
					if($(this).attr("value") != 0){
						$.ajax({
							type: "GET",
							url: "<?php home(); ?>/ajax.php",
							data: "accion=obtener_prefijo&zona_id=" + $(this).attr("value"),
							success: function(text){
								$("#zona_prefijoTel").attr("value", text);
							}
						});
						$.ajax({
							type: "GET",
							url: "<?php home(); ?>/ajax.php",
							data: "accion=obtener_coordenadas&zona_id=" + $(this).attr("value"),
							success: function(text){
								$("#zona_coordenadas").attr("value", text);
							}
						});
					}
					else{
						$("#zona_prefijoTel").attr("value", "");
						$("#zona_coordenadas").attr("value", "");
					}
				});
				$("#zona_titulo").blur(function(){
					if($(this).attr("value")!=""){
						$.ajax({
							type: "GET",
							url: "<?php home(); ?>/ajax.php",
							data: "accion=obtener_mapa&zona=" + $(this).attr("value"),
							success: function(html){
								$("#zona_mapa").html(html);
							}
						});
					}
				})
			});
		</script>
	</head>
	<body>
		<div id="cabecera">
			<h1>Admin</h1>
		</div>
		