<?php
/**
 * Funciones internas del sistema
**/
	function crear_nombre($cadena){
		$cadena = trim(strtolower($cadena));
		$cadena = str_replace(" ", "-", $cadena);
		$cadena = ereg_replace("&(.?)acute;", "\\1", $cadena);
		$cadena = ereg_replace("&(.?)tilde;", "\\1", $cadena);
		$cadena = ereg_replace("[!,._/:@\{}()['|]", "", $cadena);
		$cadena = ereg_replace("[]%#$=?+*^`��~\\]", "", $cadena);
		$cadena = ereg_replace("&(.+);", "", $cadena);
		return $cadena;
	}
	function validar_email($cadena){
		if(ereg('^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$', $cadena))
			return true;
		else
			return false;
	}
	function parsear_url(){
		$solicitud_url = ereg_replace('/+$', '', $_SERVER['REQUEST_URI']);
		$solicitud_url = ereg_replace('/vaope/?', '', $solicitud_url);
		$solicitud_url = ereg_replace('^\/', '', $solicitud_url);
		return $solicitud_url;
	}
	function estas_logueado(){
		if(!$_COOKIE['nick'] || $_COOKIE['nick']=="")
			return false;
		else
			return true;
	}
	function es_autor($id_autor){
		if($_COOKIE['nick']!=""){
			$usuario = new Usuario();
			$usuario = $usuario->info('nick='.$_COOKIE['nick']);
			if($usuario->id!=$id_autor)
				return false;
			else
				return true;
		}
		else{
			return false;
		}
	}
	function esta_votado($local_id){
		$usuario = new Usuario();
		$usuario = $usuario->info('nick='.$_COOKIE['nick']);
		$db = new DB();
		$rs = $db->consultar("SELECT * FROM votos WHERE local_id=$local_id AND voto_autor=".$usuario->id);
		if(mysql_num_rows($rs)==0)
			return false;
		else
			return true;
	}
	function existe($tipo, $nombre){
		switch($tipo){
			case 'categoria':
				$categoria = new Categoria();
				if(!$categoria->info('nombre='.$nombre))
					return false;
				else
					return true;
			break;
			case 'zona':
				$zona = new Zona();
				if(!$zona->info('nombre='.$nombre))
					return false;
				else
					return true;
			break;
			case 'local':
				$local = new Local();
				if(!$local->info('nombre='.$nombre))
					return false;
				else
					return true;
			case 'tag':
				$tag = new Tag();
				if(!$tag->infoTag('nombre='.$nombre))
					return false;
				else
					return true;
			break;
		}
	}
	function estas_en($seccion){
		$url = parsear_url();
		switch ($seccion){
			case 'inicio':
				if($url=="")
					return true;
				else
					return false;
			break;
			case 'busqueda':
				if(ereg('^buscar/(.+)', $url) && trim($_GET['por'])!="" && trim($_GET['s'])!="")
					return true;
				else
					return false;
			break;
			case 'categoria':
				if(ereg('^categoria/(.+)$', $url, $resultado))
					if(ereg('(.+)/(.+)', $resultado[1], $resultado))
						return $resultado;
					else
						return $resultado;
				else
					return false;
			break;
			case 'zona':
				if(ereg('^zona/(.+)$', $url, $resultado))
					if(ereg('(.+)/(.+)', $resultado[1], $resultado))
						return $resultado;
					else
						return $resultado;
				else
					return false;
			break;
			case 'tag':
				if(ereg('^tag/(.+)$', $url, $resultado))
					if(ereg('(.+)/(.+)', $resultado[1], $resultado))
						return $resultado;
					else
						return $resultado;
				else
					return false;
			break;
			case 'locales':
				if(ereg('^locales/(.+)/(.+)$', $url, $resultado))
					if(ereg('(.+)/(.+)', $resultado[1], $resultado))
						return $resultado;
					else
						return $resultado;
				else
					return false;
			break;
			case 'local':
				if(ereg('^local/(.+)$', $url, $resultado))
					return $resultado;
				else
					return false;
			break;
			case 'usuario':
				if(ereg('^usuario/(.+)$', $url, $resultado))
					if(ereg('(.+)/(.+)', $resultado[1], $resultado))
						return $resultado;
					else
						return $resultado;
				else
					return false;
			break;
			case 'registro':
				if(ereg('^registro$', $url))
					return true;
				else
					return false;
			break;
			case 'panel':
				if(ereg('^panel$', $url, $resultado))
					return $resultado[0];
				elseif(ereg('^panel/(.+)$', $url, $resultado))
					if(ereg('^panel/(.+)/(.+)$', $url, $resultado))
						return $resultado[1];
					else
						return $resultado[1];
				else
					return false;
			break;
			case 'pagina':
				ereg('^(.+)$', $url, $resultado);
				$pagina = new Pagina();
				if($pagina->info('nombre='.$resultado[1]))
					return $pagina;
				else
					return false;
			break;
			case 'categoria_feed':
				if(ereg('^feed/categoria/(.+)$', $url, $resultado)){
					$nombre = ereg_replace('/(.+)$', '', $resultado[1]);
					return $nombre;
				}
				else
					return false;
			break;
			case 'zona_feed':
				if(ereg('^feed/zona/(.+)$', $url, $resultado)){
					$nombre = ereg_replace('/(.+)$', '', $resultado[1]);
					return $nombre;
				}
				else
					return false;
			break;
			case 'tag_feed':
				if(ereg('^feed/tag/(.+)$', $url, $resultado)){
					$nombre = ereg_replace('/(.+)$', '', $resultado[1]);
					return $nombre;
				}
				else
					return false;
			break;
			case 'locales_feed':
				if(ereg('^feed/locales/(.+)/(.+)$', $url, $resultado)){
					if(ereg('(.+)/(.+)', $resultado[1], $resultado))
						return $resultado;
					else
						return $resultado;
				}
				else
					return false;
			break;
			case 'feed':
				if(ereg('^feed$', $url, $resultado))
					return true;
				else
					return false;
			break;
		}
	}
	function hay_locales($criterio){
		$criterio = explode("|", $criterio);
		for($i=0;$i<sizeof($criterio);$i++){
			$criterio[$i] = explode("=", $criterio[$i]);
			if($criterio[$i][0]=="categoria"){
				$categoria = new Categoria();
				$categoria = $categoria->info('nombre='.$criterio[$i][1]);
				$busqueda.="categoria=".$categoria->id."|";
			}
			if($criterio[$i][0]=="zona"){
				$zona = new Zona();
				$zona = $zona->info('nombre='.$criterio[$i][1]);
				$busqueda.="zona=".$zona->id."|";
			}
			elseif($criterio[$i][0]=="tag"){
				$tag = new Tag();
				$tag = $tag->infoTag('nombre='.$criterio[$i][1]);
				$busqueda="tag=".$tag[0]->id."|";
			}
		}
		$local = new Local();
		if(!$local->info($busqueda)){
			return false;
		}
		else{
			return true;
		}
	}
	function es_favorito($id_local){
		$usuario = new Usuario();
		$usuario = $usuario->info('nick='.$_COOKIE['nick']);
		$local = new Local();
		$local = $local->info('id='.$id_local);
		if($local->es_favorito($usuario->id))
			return true;
		else
			return false;
	}
	function fecha($formato, $timestamp){
		$traductor = array(
			'January'	=>	'Enero',
			'February'	=>	'Febrero',
			'March'		=>	'Marzo',
			'April'		=>	'Abril',
			'May'		=>	'Mayo',
			'June'		=>	'Junio',
			'July'		=>	'Julio',
			'August'	=>	'Agosto',
			'September'	=>	'Septiembre',
			'October'	=>	'Octubre',
			'November'	=>	'Noviembre',
			'December'	=>	'Diciembre'
		);
		$fecha = date($formato, $timestamp);
		ereg(' de (.+)', $fecha, $resultado);
		$fecha = str_replace($resultado[1], $traductor[$resultado[1]], $fecha);
		echo $fecha;
	}
	function buscar($criterio, $busqueda, $n){
		$busqueda = trim($busqueda);
		$busqueda = htmlentities($busqueda, ENT_QUOTES, "utf-8");
		$criterio = trim($criterio);
		$db = new DB();
		
		switch($criterio){
			case 'etiquetas':
				$sql = "SELECT relaciones.* FROM relaciones LEFT JOIN tags ON tags.tag_id=relaciones.relacion_idElemento WHERE tags.tag_titulo LIKE '$busqueda%' AND relaciones.relacion_tipo='tag'";
			break;
			case 'nombre':
				$sql = "SELECT local_id FROM locales WHERE local_titulo LIKE '%$busqueda%'";
			break;
			case 'descripcion':
				$sql = "SELECT local_id FROM locales WHERE local_descripcion LIKE '%$busqueda%'";
			break;
		}
		
		if(!$_GET['p'] || $_GET['p']=="" || $_GET['p']=="1"){
			$p = 1;
			$limite = $n;
			$inicio = 1;
		}
		else{
			$p = $_GET['p'];
		}
		$limite_inferior = ($p-1)*$n;
		if(!isset($p)){
			$p = 1;
			$inicio = 1;
			$limite = $n;
		}
		else{
			$seccionActual = intval(($p-1)/$n);
			$inicio = ($seccionActual*$n)+1;
			if($p<$n){
				$limite = $inicio+$n-1;
			}
			else{
				$limite = $n;
			}
			if($limite>$n){
				$limite = $n;
			}
		}
		$sql .= " LIMIT $limite_inferior, $limite";
		$rs = $db->consultar($sql);
		if($rs){
			if(mysql_num_rows($rs)!=0){
				$i=0;
				while($dato_local = mysql_fetch_array($rs)){
					$local[$i] = new Local();
					$local[$i] = $local[$i]->info("id=".$dato_local['local_id']);
					$i++;
				}
				return $local;
			}
		}
		else{
			return false;
		}
	}
	function getPaginationString($targetStart, $totalitems, $page, $limit = 10, $adjacents = 1, $pagestring = "?p=") {
		$prev = $page - 1;									//previous page is page - 1
		$next = $page + 1;									//next page is page + 1
		$lastpage = ceil($totalitems / $limit);				//lastpage is = total items / items per page, rounded up.
		$lpm1 = $lastpage - 1;								//last page minus 1
		
		$pagination = "";
		if($lastpage > 1){
			$pagination .= "<div class=\"pagination\"";
			if($margin || $padding){
				$pagination .= " style=\"";
				if($margin)
					$pagination .= "margin: $margin;";
				if($padding)
					$pagination .= "padding: $padding;";
				$pagination .= "\"";
			}
			$pagination .= ">";
	
			//previous button
			if ($page > 1) 
				$pagination .= "<a href=\"$targetStart$pagestring$prev\">&laquo;Anterior</a>";
			else
				$pagination .= "<span class=\"disabled\">&laquo;Anterior</span>";	
			
			//pages	
			if ($lastpage < 7 + ($adjacents * 2)){	
				for ($counter = 1; $counter <= $lastpage; $counter++){
					if ($counter == $page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"$targetStart$pagestring$counter\">$counter</a>";					
				}
			}
			elseif($lastpage >= 7 + ($adjacents * 2)){
				if($page < 1 + ($adjacents * 3)){
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
						if ($counter == $page)
							$pagination .= "<span class=\"current\">$counter</span>";
						else
							$pagination .= "<a href=\"$targetStart$pagestring$counter\">$counter</a>";					
					}
					$pagination .= "...";
					$pagination .= "<a href=\"$targetStart$pagestring$lpm1\">$lpm1</a>";
					$pagination .= "<a href=\"$targetStart$pagestring$lastpage\">$lastpage</a>";		
				}
				elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
					$pagination .= "<a href=\"$targetStart$pagestring1\">1</a>";
					$pagination .= "<a href=\"$targetStart$pagestring2\">2</a>";
					$pagination .= "...";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
						if ($counter == $page)
							$pagination .= "<span class=\"current\">$counter</span>";
						else
							$pagination .= "<a href=\"$targetStart$pagestring$counter\">$counter</a>";					
					}
					$pagination .= "...";
					$pagination .= "<a href=\"$targetStart$pagestring$lpm1\">$lpm1</a>";
					$pagination .= "<a href=\"$targetStart$pagestring$lastpage\">$lastpage</a>";		
				}
				else{
					$pagination .= "<a href=\"$targetStart$pagestring1\">1</a>";
					$pagination .= "<a href=\"$targetStart$pagestring2\">2</a>";
					$pagination .= "...";
					for ($counter = $lastpage - (1 + ($adjacents * 3)); $counter <= $lastpage; $counter++){
						if ($counter == $page)
							$pagination .= "<span class=\"current\">$counter</span>";
						else
							$pagination .= "<a href=\"$targetStart$pagestring$counter\">$counter</a>";					
					}
				}
			}
			
			if ($page < $counter - 1) 
				$pagination .= "<a href=\"$targetStart$pagestring$next\">Siguiente&raquo;</a>";
			else
				$pagination .= "<span class=\"disabled\">Siguiente&raquo;</span>";
			$pagination .= "</div>\n";
		}
		return $pagination;	
	}
?>