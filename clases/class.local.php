<?php
	class Local extends DB{
		public $id;
		public $titulo;
		public $nombre;
		public $descripcion;
		public $categoria;
		public $zona;
		public $tags;
		public $direccion;
		public $telefono;
		public $fotos;
		public $videos;
		public $url;
		public $autor;
		public $coordenadas;
		public $puntuacion;
		public $fecha;
		
		function Local(){
		}
		function info($criterios=NULL){
			if($criterios==""){
				$consulta="";
			}
			else{
				$busqueda = explode("|", $criterios);
				
				for($i=0;$i<sizeof($busqueda);$i++){
					if($busqueda[$i]=="")
						continue;
					$criterio = explode("=", $busqueda[$i]);
					if($criterio[0]!='categoria' && $criterio[0]!='zona' && $criterio[0]!='limites' && $criterio[0]!='tag' && $criterio[0]!='excluir' && $criterio[0]!='usuario' && $criterio[0]!='ordenar'){
						$consulta .= "local_".$criterio[0]."='".$criterio[1]."' AND ";
					}
					elseif($criterio[0]!='limites' && $criterio[0]!='tag' && $criterio[0]!='excluir' && $criterio[0]!='ordenar'){
						$consulta .= $criterio[0]."_id=".$criterio[1]." AND ";
					}
					elseif($criterio[0]=='tag'){
						$consulta .= " LEFT JOIN relaciones ON relaciones.local_id=locales.local_id WHERE relaciones.relacion_idElemento=".$criterio[1]." AND relaciones.relacion_tipo='tag' AND";
					}
					elseif($criterio[0]=='excluir'){
						$excluidos = explode(",", $criterio[1]);
						for($j=0;$j<sizeof($excluidos);$j++)
							$consulta .= "local_id!=".$excluidos[$j]." AND ";
					}
					elseif($criterio[0]=="ordenar"){
						switch($criterio[1]){
							case 'puntuacion':
								$ordenar_por = ' ORDER BY local_puntuacion DESC ';
							break;
							case 'fecha':
								$ordenar_por = ' ORDER BY local_fecha DESC ';
							break;
							case 'titulo':
								$ordenar_por = ' ORDER BY local_titulo DESC ';
							break;
							default:
								$ordenar_por = ' ORDER BY local_puntuacion DESC ';
							break;
						}
					}
					elseif($criterio[0]=='limites'){
						if($criterio[1]==""){
							$limites = " LIMIT 0, 10";
						}
						else{
							$limite = explode(",", $criterio[1]);
							$limites = " LIMIT ".$limite[0].", ".$limite[1];
						}
					}
				}
				$consulta = substr(trim($consulta), 0, strlen($consulta)-5);
				if(strstr($criterios, 'tag=')==""){
					if($consulta!="")
						$consulta = "WHERE ".$consulta;
					else
						$consulta = $consulta;
					$consulta = $consulta.$ordenar_por.$limites;
				}
				else
					$consulta = $consulta.$ordenar_por.$limites;
			}
			$rs = $this->consultar("SELECT * FROM locales ".$consulta);
			if(!$rs){
				die("Error en la consulta SQL. SELECT * FROM locales $consulta");
			}
			if(mysql_num_rows($rs)==0){
				return false;
			}
			elseif(mysql_num_rows($rs)==1){
				$datos_local = mysql_fetch_array($rs);
				$datos_categoria = new Categoria();
				$datos_categoria = $datos_categoria->info('id='.$datos_local['categoria_id']);
				$datos_zona = new Zona();
				$datos_zona = $datos_zona->info('id='.$datos_local['zona_id']);
				$datos_telefono = new Telefono();
				$datos_telefono = $datos_telefono->info('local='.$datos_local['local_id']);
				$datos_tags = new Tag();
				$datos_tags = $datos_tags->info($datos_local['local_id']);
				$datos_media = new Media();
				$datos_fotos = $datos_media->info('local='.$datos_local['local_id'].'|tipo=foto');
				$datos_videos = $datos_media->info('local='.$datos_local['local_id'].'|tipo=video');
				$datos_autor = new Usuario();
				$datos_autor = $datos_autor->info('id='.$datos_local['usuario_id']);
				
				$this->id = $datos_local['local_id'];
				$this->titulo = $datos_local['local_titulo'];
				$this->nombre = $datos_local['local_nombre'];
				$this->descripcion = $datos_local['local_descripcion'];
				$this->categoria = $datos_categoria;
				$this->zona = $datos_zona;
				$this->tags = $datos_tags;
				$this->direccion = $datos_local['local_direccion'];
				$this->telefono = $datos_telefono;
				$this->fotos = $datos_fotos;
				$this->videos = $datos_videos;
				$this->url = $datos_local['local_url'];
				$this->autor = $datos_autor;
				$this->puntuacion = $datos_local['local_puntuacion'];
				if($datos_local['local_coordenadas']!="")
					$coordenadas = explode(',', $datos_local['local_coordenadas']);
				else
					$coordenadas = "";
				$this->coordenadas[0] = trim($coordenadas[0]);
				$this->coordenadas[1] = trim($coordenadas[1]);
				$this->fecha = $datos_local['local_fecha'];
				return $this;
			}
			else{
				$i=0;
				while($datos_local = mysql_fetch_array($rs)){
					$local[$i] = new Local();
					$datos_categoria = new Categoria();
					$datos_categoria = $datos_categoria->info('id='.$datos_local['categoria_id']);
					$datos_zona = new Zona();
					$datos_zona = $datos_zona->info('id='.$datos_local['zona_id']);
					$datos_tags = new Tag();
					$datos_tags = $datos_tags->info($datos_local['local_id']);
					$datos_telefono = new Telefono();
					$datos_telefono = $datos_telefono->info('local='.$datos_local['local_id']);
					$datos_media = new Media();
					$datos_fotos = $datos_media->info('local='.$datos_local['local_id'].'|tipo=foto');
					$datos_videos = $datos_media->info('local='.$datos_local['local_id'].'|tipo=video');
					$datos_autor = new Usuario();
					$datos_autor = $datos_autor->info('id='.$datos_local['usuario_id']);
					
					$local[$i]->id = $datos_local['local_id'];
					$local[$i]->titulo = $datos_local['local_titulo'];
					$local[$i]->nombre = $datos_local['local_nombre'];
					$local[$i]->descripcion = $datos_local['local_descripcion'];
					$local[$i]->categoria = $datos_categoria;
					$local[$i]->zona = $datos_zona;
					$local[$i]->tags = $datos_tags;
					$local[$i]->direccion = $datos_local['local_direccion'];
					$local[$i]->telefono = $datos_telefono;
					$local[$i]->fotos = $datos_fotos;
					$local[$i]->videos = $datos_videos;
					$local[$i]->url = $datos_local['local_url'];
					$local[$i]->autor = $datos_autor;
					if($datos_local['local_coordenadas']!="")
						$coordenadas = explode(',', $datos_local['local_coordenadas']);
					else
						$coordenadas = "";
					$local[$i]->coordenadas[0] = trim($coordenadas[0]);
					$local[$i]->coordenadas[1] = trim($coordenadas[1]);
					$local[$i]->puntuacion = $datos_local['local_puntuacion'];
					$local[$i]->fecha = $datos_local['local_fecha'];
					$i++;
				}
				return $local;
			}
		}
		function localesRelacionados($n){
			$locales = new Local();
			$locales = $locales->info("categoria=".$this->categoria->id."|zona=".$this->zona->id."|excluir=".$this->id."|limites=0,$n");
			return $locales;
		}
		function agregar($titulo, $descripcion, $idCategoria, $idZona, $direccion, $coordenadas, $puntuacion=0, $tags=NULL, $telefonos=NULL, $media=NULL, $url=NULL){
			if(!estas_logueado())
				die('Necesitas estar logueado para poder agregar locales.');
			
			$usuario = new Usuario();
			$usuario = $usuario->info('nick='.$_COOKIE['nick']);
			
			$titulo = mysql_real_escape_string(htmlentities(stripslashes(trim($titulo)), ENT_QUOTES, "utf-8"));
			$descripcion = mysql_real_escape_string(stripslashes(trim($descripcion)));
			$direccion = mysql_real_escape_string(htmlentities(stripslashes(trim($direccion)), ENT_QUOTES, "utf-8"));
			$url = mysql_real_escape_string(htmlentities(trim($url), ENT_QUOTES, "utf-8"));
			
			$descripcion = str_replace('<p>&nbsp</p>', '', $descripcion);
			$descripcion = ereg_replace('<script(.*)>(.*)<\/script>', '', $descripcion);

			$nombre = crear_nombre($titulo);
			$rs = $this->consultar("SELECT * FROM locales WHERE local_nombre='$nombre'");
			if(mysql_num_rows($rs)==0)
				$nombre = crear_nombre($titulo);
			else
				$nombre = crear_nombre($titulo).'-'.(mysql_num_rows($rs)+1);
			
			if($puntuacion=="")
				$puntuacion=0;
			$coordenadas = ereg_replace("\((.*)\)","\\1", $coordenadas);
			if($url!="" && !ereg('^http://(.+)$', $url)){
				$url = 'http://'.$url;
			}
			$rs = $this->consultar("INSERT INTO locales (local_titulo, local_nombre, local_descripcion, categoria_id, zona_id, local_direccion, local_url, usuario_id, local_coordenadas, local_puntuacion, local_fecha) VALUES ('$titulo', '$nombre', '$descripcion', $idCategoria, $idZona, '$direccion', '$url', ".$usuario->id.", '$coordenadas', $puntuacion, ".time().")");
			if(!$rs){
				die("No se pudo agregar el local.");
			}
			else{
				$id_local = mysql_insert_id();
				$ctelefono = new Telefono();
				for($i=0;$i<sizeof($telefonos);$i++){
					if($telefonos[$i]['numero']=="")
						continue;
					$ctelefono->agregar($id_local, $telefonos[$i]['numero'], $telefonos[$i]['tipo']);
				}
				$cmedia = new Media();
				for($i=0;$i<sizeof($media);$i++){
					if($media[$i]['ruta']=="")
						continue;
					$cmedia->agregar($id_local, $media[$i]['tipo'], $media[$i]['ruta']);
				}
				if($tags!=""){
					$tags = explode(',', $tags);
					foreach($tags as $tag){
						$tag = mysql_real_escape_string(htmlentities(stripslashes(trim($tag)), ENT_QUOTES, "utf-8"));
						$nombre_tag = crear_nombre($tag);
						if(existe('tag', $nombre_tag)){
							$t = new Tag();
							$t = $t->infoTag('nombre='.$nombre_tag);
							$id_tag = $t->id;
							$rs = $this->consultar("INSERT INTO relaciones (local_id, relacion_idElemento, relacion_tipo) VALUES ($id_local, $id_tag, 'tag')");
							if(!$rs)
								die("No se pudieron agregar los tags.");
						}
						else{
							$rs = $this->consultar("INSERT INTO tags (tag_titulo, tag_nombre) VALUES ('$tag', '$nombre_tag')");
							if($rs){
								$id_tag = mysql_insert_id();
								$rs = $this->consultar("INSERT INTO relaciones (local_id, relacion_idElemento, relacion_tipo) VALUES ($id_local, $id_tag, 'tag')");
								if(!$rs)
									die("No se pudieron agregar los tags.");
							}
						}
					}
				}
				echo '
				<p class="centrado mensaje exito">Local agregado con &eacute;xito</p>
				<h4 class="centrado"><a href="'.url.'/local/'.$nombre.'/">Ver local &raquo;</a></h4>
				';
			}
		}
		function editar($titulo, $nombre, $descripcion, $idCategoria, $idZona, $direccion, $coordenadas, $tags=NULL, $telefonos=NULL, $media=NULL, $url=NULL){
			if($this->id=="")
				die("Debes elegir un local para poder editarlo.");
			if(!estas_logueado())
				die('Necesitas estar logueado para poder agregar locales.');
			
			$usuario = new Usuario();
			$usuario = $usuario->info('nick='.$_COOKIE['nick']);
			
			$titulo = mysql_real_escape_string(htmlentities(stripslashes(trim($titulo)), ENT_QUOTES, "utf-8"));
			$descripcion = mysql_real_escape_string(stripslashes(trim($descripcion)));
			$direccion = mysql_real_escape_string(htmlentities(stripslashes(trim($direccion)), ENT_QUOTES, "utf-8"));
			$url = mysql_real_escape_string(htmlentities(trim($url), ENT_QUOTES, "utf-8"));
			
			$descripcion = str_replace('<p>&nbsp</p>', '', $descripcion);
			$descripcion = ereg_replace('<script(.*)>(.*)<\/script>', '', $descripcion);
			
			$coordenadas = ereg_replace("\((.*)\)","\\1", $coordenadas);
			if($url!="" && !ereg('^http://(.+)$', $url)){
				$url = 'http://'.$url;
			}
			
			$rs = $this->consultar("UPDATE locales SET local_titulo='$titulo', local_descripcion='$descripcion', categoria_id=$idCategoria, zona_id=$idZona, local_direccion='$direccion', local_url='$url', usuario_id=".$usuario->id.", local_coordenadas='$coordenadas' WHERE local_id=".$this->id);
			if(!$rs){
				die('No se pudo editar el local.');
			}
			else{
				$ctelefono = new Telefono();
				if($this->consultar("DELETE FROM telefonos WHERE local_id=".$this->id)){
					for($i=0;$i<sizeof($telefonos);$i++){
						if($telefonos[$i]['numero']=="")
							continue;
						$ctelefono->agregar($this->id, $telefonos[$i]['numero'], $telefonos[$i]['tipo']);
					}
				}
				else{
					die("No se pudieron editar los telefonos.");
				}
				$cmedia = new Media();
				if($this->consultar("DELETE FROM media WHERE local_id=".$this->id)){
					for($i=0;$i<sizeof($media);$i++){
						if($media[$i]['ruta']=="")
							continue;
						$cmedia->agregar($this->id, $media[$i]['tipo'], $media[$i]['ruta']);
					}
				}
				if($tags!=""){
					if($this->consultar("DELETE FROM relaciones WHERE local_id=".$this->id." AND relacion_tipo='tag'")){
						$tags = explode(',', $tags);
						foreach($tags as $tag){
							$tag = mysql_real_escape_string(htmlentities(stripslashes(trim($tag)), ENT_QUOTES, "utf-8"));
							$nombre_tag = crear_nombre($tag);
							if(existe('tag', $nombre_tag)){
								$t = new Tag();
								$t = $t->infoTag('nombre='.$nombre_tag);
								$id_tag = $t->id;
								$rs = $this->consultar("INSERT INTO relaciones (local_id, relacion_idElemento, relacion_tipo) VALUES (".$this->id.", $id_tag, 'tag')");
								if(!$rs)
									die("No se pudieron agregar los tags.");
							}
							else{
								$rs = $this->consultar("INSERT INTO tags (tag_titulo, tag_nombre) VALUES ('$tag', '$nombre_tag')");
								if($rs){
									$id_tag = mysql_insert_id();
									$rs = $this->consultar("INSERT INTO relaciones (local_id, relacion_idElemento, relacion_tipo) VALUES (".$this->id.", $id_tag, 'tag')");
									if(!$rs)
										die("No se pudieron agregar los tags.");
								}
							}
						}
					}
					else{
						die("No se pudieron editar los tags.");
					}
				}
				echo '
				<p class="centrado mensaje exito">Local editado con &eacute;xito</p>
				<h4 class="centrado"><a href="'.url.'/local/'.$nombre.'/">Ver local &raquo;</a></h4>
				';
			}
		}
		function eliminar(){
			if(estas_logueado()){
				if($this->id=="")
					die("Debes elegir un local para poder eliminarlo.");
				if(!es_autor($this->autor->id)){
					return false;
				}
				else{
					if($this->consultar("DELETE FROM locales WHERE local_id=".$this->id))
						if($this->consultar("DELETE FROM telefonos WHERE local_id=".$this->id))
							if($this->consultar("DELETE FROM relaciones WHERE local_id=".$this->id))
								return true;
							else
								return false;
						else
							return false;
					else
						return false;
				}
			}
			else{
				return false;
			}
		}
		function marcar_favorito($usuario){
			$rs = $this->consultar("INSERT INTO favoritos (local_id, usuario_id) VALUES (".$this->id.", $usuario)");
			if($rs)
				echo '<li id="local_favorito"><a href="javascript:desmarcar_favorito(\''.$this->id.'\');"><img src="'.url.'/plantillas/imagenes/no_favorito.png" alt="Desmarcar favorito" />Desmarcar favorito.</a></li>';
			else
				echo 'Ops! Hubo un error al intentar marcar este local como favorito.';
		}
		function desmarcar_favorito($usuario){
			$rs = $this->consultar("DELETE FROM favoritos WHERE local_id=".$this->id." AND usuario_id=$usuario");
			if($rs)
				echo '<li id="local_favorito"><a href="javascript:marcar_favorito(\''.$this->id.'\');"><img src="'.url.'/plantillas/imagenes/favorito.png" alt="Marcar como favorito" />Marcar como favorito.</a></li>';
			else
				echo 'Ops! Hubo un error al intentar desmarcar este local como favorito.';
		}
		function es_favorito($usuario){
			if(estas_logueado()){
				$rs = $this->consultar("SELECT * FROM favoritos WHERE local_id=".$this->id." AND usuario_id=$usuario");
				if(mysql_num_rows($rs)==0)
					return false;
				else
					return true;
			}
			else{
				return false;
			}
		}
		function votar($voto){
			if(estas_logueado()){
				$usuario = new Usuario();
				$usuario = $usuario->info('nick='.$_COOKIE['nick']);
				if($voto==0){
					$nueva_puntuacion = $this->puntuacion;
				}
				else{
					$nueva_puntuacion = round(($this->puntuacion+$voto)/2, 1);
				}
				if($this->consultar("UPDATE locales SET local_puntuacion=".$nueva_puntuacion." WHERE local_id=".$this->id)){
					if($this->consultar("INSERT INTO votos (local_id, voto_autor, voto_puntaje) VALUES (".$this->id.", ".$usuario->id.", ".$voto.")")){
						return $nueva_puntuacion;
					}
					return false;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
	}
?>