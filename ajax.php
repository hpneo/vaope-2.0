<?php
	include_once("config.php");
	include_once("funciones.php");
	include_once("clases/class.gmap.php");
	include_once("clases/class.db.php");
	include_once("clases/class.usuario.php");
	include_once("clases/class.categoria.php");
	include_once("clases/class.zona.php");
	include_once("clases/class.local.php");
	include_once("clases/class.telefono.php");
	include_once("clases/class.tag.php");
	include_once("clases/class.media.php");
	include_once("clases/class.pagina.php");
	include_once("plantillas.php");
	
	$db = new DB();
	
	$accion = $_GET['accion'];
	if($accion!=""){
		switch($accion){
			case 'mostrar_mapa':
				$div['id'] = 'map';
				$div['width'] = '560px';
				$div['height'] = '360px';
				$mapa = new GMap(gmaps_api_key, $div);
				$mapa->zoom = 15;
				if($_GET['zona']!=""){
					$zona = new Zona();
					$zona = $zona->info('id='.$_GET['zona']);
					$mapa->center['lat'] = $zona->coordenadas[0];
					$mapa->center['long'] = $zona->coordenadas[1];
				}
				elseif(trim($_GET['coordenadas'])!=""){
					$coordenadas = ereg_replace("\((.*)\)","\\1", trim($_GET['coordenadas']));
					$coordenadas = explode(',', $coordenadas);
					$mapa->center['lat'] = trim($coordenadas[0]);
					$mapa->center['long'] = trim($coordenadas[1]);
				}
				$mapa->add_marker($mapa->center['lat'], $mapa->center['long'], "", "", "", true, "local_coordenadas");
				$mapa->print_map();
			break;
			case 'mostrar_mapa_locales':
				$div['id'] = 'map';
				$div['width'] = '680px';
				$div['height'] = '360px';
				$mapa = new GMap(gmaps_api_key, $div);
				$zona = new Zona();
				$zona = $zona->info('nombre='.$_GET['zona']);
				$categoria = new Categoria();
				$categoria = $categoria->info('nombre='.$_GET['categoria']);
				$local = new Local();
				if(!$_GET['categoria'] || $_GET['categoria']=="")
					$locales = $local->info('zona='.$zona->id);
				else
					$locales = $local->info('zona='.$zona->id.'|categoria='.$categoria->id);
				$mapa->center['lat'] = $zona->coordenadas[0];
				$mapa->center['long'] = $zona->coordenadas[1];
				$mapa->zoom = 14;
				if($locales){
					foreach($locales as $local){
						$contenido = '<h4>'.$local->titulo.'</h4><p><a href=\"'.url.'/local/'.$local->nombre.'/\">Ver local &raquo;</a></p>';
						if($local->coordenadas[0]!="" && $local->coordenadas[1]!="")
							$mapa->add_marker($local->coordenadas[0], $local->coordenadas[1], 'http://www.gmaplive.com/marker_hex.php?n=20&hex=6699cc', $local->titulo, $contenido, false);
					}
				}
				$mapa->print_map();
			break;
			case 'marcar_favorito':
				$usuario = new Usuario();
				$usuario = $usuario->info('nick='.$_COOKIE['nick']);
				$local = new Local();
				$local = $local->info('id='.$_GET['local']);
				$local->marcar_favorito($usuario->id);
			break;
			case 'desmarcar_favorito':
				$usuario = new Usuario();
				$usuario = $usuario->info('nick='.$_COOKIE['nick']);
				$local = new Local();
				$local = $local->info('id='.$_GET['local']);
				$local->desmarcar_favorito($usuario->id);
			break;
			case 'eliminar_local':
				$local = new Local();
				$id = trim($_GET['id']);
				$local = $local->info('id='.$id);
				if(!es_autor($local->autor->id)){
					echo "FAIL";
				}
				else{
					if(!$local->eliminar())
						echo "FAIL";
					else
						echo "OK";
				}
			break;
			case 'autocompletar_categoria':
				$q = trim($_GET['q']);
				$rs = $db->consultar("SELECT * FROM categorias WHERE categoria_titulo LIKE '$q%' AND categoria_idPadre!=0");
				if($rs){
					if(mysql_num_rows($rs)!=0){
						while($categoria = mysql_fetch_array($rs)){
							echo html_entity_decode($categoria['categoria_titulo']."\n", ENT_QUOTES, "utf-8");
						}
					}
				}
				else{
					echo "ERROR";
				}
			break;
			case 'autocompletar_zona':
				$q = trim($_GET['q']);
				$rs = $db->consultar("SELECT * FROM zonas WHERE zona_titulo LIKE '$q%' AND zona_idPadre!=0");
				if($rs){
					if(mysql_num_rows($rs)!=0){
						while($zona = mysql_fetch_array($rs)){
							echo html_entity_decode($zona['zona_titulo']."\n", ENT_QUOTES, "utf-8");
						}
					}
				}
				else{
					echo "ERROR";
				}
			break;
			case 'eliminar_pagina':
				$pagina = new Pagina();
				$id = trim($_GET['id']);
				$pagina = $pagina->info('id='.$id);
				if(!$pagina->eliminar())
					echo "FAIL";
				else
					echo "OK";
			break;
			case 'eliminar_categoria':
				$categoria = new Categoria();
				$id = trim($_GET['id']);
				$categoria = $categoria->info('id='.$id);
				if(!$categoria->eliminar())
					echo "FAIL";
				else
					echo "OK";
			break;
			case 'obtener_prefijo':
				$zona = new Zona();
				$id = trim($_GET['zona_id']);
				$zona = $zona->info('id='.$id);
				echo $zona->prefijoTel;
			break;
			case 'obtener_mapa':
				$direccion = trim($_GET['zona']).", Peru";
				$div['id'] = 'map';
				$div['width'] = '800px';
				$div['height'] = '400px';
				$mapa = new GMap(gmaps_api_key, $div);
				$mapa->zoom = 14;
				$mapa->print_map_geocoded($direccion);
			break;
			case 'obtener_coordenadas':
				$zona = new Zona();
				$id = trim($_GET['zona_id']);
				$zona = $zona->info('id='.$id);
				echo $zona->coordenadas[0].','.$zona->coordenadas[1];
			break;
			case 'votar_local':
				$local = new Local();
				$id = trim($_GET['local_id']);
				$voto = trim($_POST['rating']);
				$local = $local->info('id='.$id);
				echo $local->votar($voto);
			break;
		}
	}
?>