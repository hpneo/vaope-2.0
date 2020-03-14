<?php
	class Usuario extends DB{
		public $id;
		public $nick;
		public $clave;
		public $descripcion;
		public $email;
		public $mostrar_email;
		public $url;
		public $rango;
		public $n_favoritos = 0;
		
		function Usuario(){
		}
		function info($busqueda){
			if($busqueda==""){
				$consulta="";
			}
			else{
				$busqueda = explode("|", $busqueda);
				
				for($i=0;$i<sizeof($busqueda);$i++){
					$criterio = explode("=", $busqueda[$i]);
					$consulta .="usuario_".$criterio[0]."='".$criterio[1]."' AND ";
				}
				$consulta = " WHERE ".substr(trim($consulta), 0, strlen($consulta)-5);
			}
			$rs = $this->consultar("SELECT * FROM usuarios".$consulta);
			if(!$rs)
				die("Hubo un error en la consulta SQL:Usuario.");
			if(mysql_num_rows($rs)==0){
				return false;
			}
			elseif(mysql_num_rows($rs)==1){
				$datos_usuario = mysql_fetch_array($rs);
				$this->id = $datos_usuario['usuario_id'];
				$this->nick = $datos_usuario['usuario_nick'];
				$this->clave = $datos_usuario['usuario_clave'];
				$this->descripcion = $datos_usuario['usuario_descripcion'];
				$this->email = $datos_usuario['usuario_email'];
				$this->mostrar_email = $datos_usuario['usuario_mostrarEmail'];
				$this->url = $datos_usuario['usuario_url'];
				$this->rango = $datos_usuario['usuario_rango'];
				$this->n_favoritos = $this->n_favoritos();
				return $this;
			}
		}
		function agregar($nick, $clave, $descripcion=NULL, $mostrar_email, $email, $url, $rango=NULL){
			if(is_null($rango) || $rango=="")
				$rango=0;
			$nick = mysql_real_escape_string(htmlentities(trim($nick), ENT_QUOTES, "utf-8"));
			$clave = md5(mysql_real_escape_string(trim($clave)));
			$descripcion = mysql_real_escape_string(htmlentities(trim($descripcion), ENT_QUOTES, "utf-8"));
			$usuario = new Usuario();
			$usuario = $usuario->info("nick=$nick");
			if($usuario)
				die("<div class=\"mensaje error\">El usuario $nick ya existe.</div>");
			$usuario = new Usuario();
			$usuario = $usuario->info("email=$email");
			if($usuario)
				die("<div class=\"mensaje error\">El usuario con el e-mail $email ya existe.</div>");
			$rs = $this->consultar("INSERT INTO usuarios (usuario_nick, usuario_clave, usuario_descripcion, usuario_mostrarEmail, usuario_email, usuario_url, usuario_rango, usuario_fecha) VALUES ('$nick', '$clave', '$descripcion', '$mostrar_email', '$email', '$url', $rango, ".time().")");
			if(!$rs)
				return false;
			else
				return true;
		}
		function editar($busqueda, $descripcion=NULL, $mostrar_email, $email, $url){
			if($_COOKIE['nick']=="")
				die("Debes estar logueado para acceder a esta feature.");
			if($this->nick!=$_COOKIE['nick'])
				die("No puedes editar la informaci&oacute;n de otro usuario.");
			$descripcion = mysql_real_escape_string(htmlentities($descripcion, ENT_QUOTES, "utf-8"));
			$url = mysql_real_escape_string($url);
			$email = mysql_real_escape_string($email);
			$rs = $this->consultar("UPDATE usuarios SET usuario_descripcion='$descripcion', usuario_mostrarEmail='$mostrar_email', usuario_email='$email', usuario_url='$url' WHERE usuario_id=".$this->id);
			if(!$rs)
				return false;
			else
				return true;
		}
		function cambiar_clave($clave_nueva){
			if($_COOKIE['nick']=="")
				die("Debes estar logueado para acceder a esta feature.");
			if($this->nick!=$_COOKIE['nick'])
				die("No puedes editar la informaci&oacute;n de otro usuario.");
			
			$clave_nueva = md5(mysql_real_escape_string(trim($clave_nueva)));
			$rs = $this->consultar("UPDATE usuarios SET usuario_clave='$clave_nueva' WHERE usuario_id=".$this->id);
			if(!$rs)
				return false;
			else
				return true;
		}
		function eliminar($busqueda){
			if($_COOKIE['nick']=="")
				die("Debes estar logueado para acceder a esta feature.");
			if($this->nick!=$_COOKIE['nick'])
				die("No puedes editar la informaci&oacute;n de otro usuario.");
			$rs = $this->consultar("DELETE FROM usuarios WHERE usuario_id=".$this->id);
			if(!$rs){
				return false;
			}
			else{
				$rs = $this->consultar("UPDATE locales SET usuario_id=1 WHERE usuario_id=".$this->id);
				if(!$rs)
					return false;
				else
					return true;
			}
		}
		function listar_locales($es_admin=false){
			$local = new Local();
			$locales = $local->info('usuario='.$this->id.'|ordenar=fecha');
			if($locales){
				echo '
					<table summary="Lista de locales de '.$this->nick.'">
					';
				if($es_admin){
					echo'
						<tr>
							<th>Nombre</th>
							<th>Categor&iacute;a</th>
							<th>Zona</th>
							<th colspan="2"></th>
						</tr>
					';
				}
				else{
					echo'
						<tr>
							<th>Nombre</th>
							<th>Categor&iacute;a</th>
							<th>Zona</th>
						</tr>
					';
				}
				if(gettype($locales)=="array"){
					foreach($locales as $local){
						echo'
							<tr id="fila-'.$local->id.'">
								<td><a href="'.url.'/local/'.$local->nombre.'/" title="Ir al local">'.$local->titulo.'</a></td>
								<td class="centrado"><a href="'.url.'/categoria/'.$local->categoria->nombre.'/" title="Ir a categor&iacute;a">'.$local->categoria->titulo.'</a></td>
								<td class="centrado"><a href="'.url.'/zona/'.$local->zona->nombre.'/" title="Ir a zona">'.$local->zona->titulo.'</a></td>
						';
						if($es_admin){
							echo'
								<td class="centrado"><a href="'.url.'/panel/editar/?id='.$local->id.'" title="Editar local"><img src="'.url.'/plantillas/imagenes/editar.png" alt="Editar" /></a></td>
								<td class="centrado"><a href="'.url.'/panel/eliminar/?id='.$local->id.'" class="eliminar_local" id="local-'.$local->id.'" title="Eliminar local"><img src="'.url.'/plantillas/imagenes/eliminar.png" alt="Eliminar" /></a></td>
							';
						}
						echo '
							</tr>
						';
					}
				}
				else{
					$local = $locales;
					echo'
						<tr id="fila-'.$local->id.'">
							<td><a href="'.url.'/local/'.$local->nombre.'/" title="Ir al local">'.$local->titulo.'</a></td>
							<td class="centrado"><a href="'.url.'/categoria/'.$local->categoria->nombre.'/" title="Ir a categor&iacute;a">'.$local->categoria->titulo.'</a></td>
							<td class="centrado"><a href="'.url.'/zona/'.$local->zona->nombre.'/" title="Ir a zona">'.$local->zona->titulo.'</a></td>
					';
					if($es_admin){
						echo'
							<td class="centrado"><a href="'.url.'/panel/editar/?id='.$local->id.'" title="Editar local"><img src="'.url.'/plantillas/imagenes/editar.png" alt="Editar" /></a></td>
							<td class="centrado"><a href="'.url.'/panel/eliminar/?id='.$local->id.'" class="eliminar_local" id="local-'.$local->id.'" title="Eliminar local"><img src="'.url.'/plantillas/imagenes/eliminar.png" alt="Eliminar" /></a></td>
						';
					}
					echo '
						</tr>
					';
				}
				echo '
					</table>
				';
			}
			else{
				if($es_admin){
					echo '
						<div class="mensaje">
							<p>A&uacute;n no tienes locales agregados. Puedes <a href="'.url.'/panel/agregar/" title="Agregar un local">empezar ahora</a>.</p>
						</div>
					';	
				}
				else{
					echo '
						<div class="mensaje">
							<p>A&uacute;n no tiene locales agregados.</p>
						</div>
					';
				}
			}
		}
		function listar_favoritos(){
			if($this->id=="")
				die("El usuario no existe.");
			$rs = $this->consultar("SELECT * FROM favoritos WHERE usuario_id=".$this->id);
			if(mysql_num_rows($rs)==0){
				return false;
			}
			else{
				$i=0;
				while($favorito = mysql_fetch_array($rs)){
					$local[$i] = new Local();
					$local[$i] = $local[$i]->info('id='.$favorito['local_id']);
					$i++;
				}
				return $local;
			}
		}
		function n_favoritos(){
			if($this->id=="")
				die("El usuario no existe.");
			$rs = $this->consultar("SELECT favorito_id FROM favoritos WHERE usuario_id=".$this->id);
			return mysql_num_rows($rs);
		}
	}
?>