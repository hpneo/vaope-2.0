<?php
	class Comentario extends DB{
		public $contenido;
		public $autor;
		public $fecha;
		
		function Comentario(){
		}
		function listar($idLocal){
			$rs = $this->consultar("SELECT * FROM comentarios WHERE local_id=$idLocal ORDER BY comentario_fecha ASC");
			if(mysql_num_rows($rs)==0){
				return false;
			}
			else{
				$i=0;
				while($datos_comentario = mysql_fetch_array($rs)){
					$datos_autor = new Usuario();
					$datos_autor = $datos_autor->info('id='.$datos_comentario['usuario_id']);
					$comentario[$i] = new Comentario();
					$comentario[$i]->contenido = $datos_comentario['comentario_contenido'];
					$comentario[$i]->fecha = $datos_comentario['comentario_fecha'];
					$comentario[$i]->autor = $datos_autor;
					$i++;
				}
				return $comentario;
			}
		}
		function comentar($idAutor, $idLocal, $contenido){
			$contenido = trim($contenido);
			if($idLocal==""){
				die("No has seleccionado el local.");
			}
			if($contenido==""){
				die("Debes escribir un comentario.");
			}
			if(!estas_logueado()){
				die("Debes estar logueado.");
			}
			$time = time();
			$rs = $this->consultar("INSERT INTO comentarios (local_id, usuario_id, comentario_contenido, comentario_fecha) VALUES ($idLocal, $idAutor, '$contenido', ".$time.")");
			if(!$rs)
				die("Hubo un error al momento de guardar el comentario.");
			else{
				if(strstr($_SERVER['REQUEST_URI'], "comentar.php")!="")
					header('Location: '.$_SERVER['HTTP_REFERER'].'#comentario-'.$time);
				else
					header('Location: '.url);
			}
		}
	}
?>