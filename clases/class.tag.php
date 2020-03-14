<?php
	class Tag extends DB{
		public $id;
		public $titulo;
		public $nombre;
		function info($idLocal){
			$SQL = "SELECT tags.* FROM tags LEFT JOIN relaciones ON tags.tag_id=relaciones.relacion_idElemento WHERE relaciones.local_id=".$idLocal." AND relaciones.relacion_tipo='tag'";
			$rs = $this->consultar($SQL);
			if(!$rs){
				die("Hubo un error en la consulta SQL:Tag.");
			}
			if(mysql_num_rows($rs)==0){
				return false;
			}
			else{
				$i=0;
				while($datos_tag = mysql_fetch_array($rs)){
					$tag[$i] = new Tag();
					$tag[$i]->id = $datos_tag['tag_id'];
					$tag[$i]->titulo = $datos_tag['tag_titulo'];
					$tag[$i]->nombre = $datos_tag['tag_nombre'];
					$i++;
				}
				return $tag;
			}
		}
		function infoTag($busqueda=NULL){
			if($busqueda==""){
				$consulta="";
			}
			else{
				$busqueda = explode("|", $busqueda);
				
				for($i=0;$i<sizeof($busqueda);$i++){
					$criterio = explode("=", $busqueda[$i]);
					$consulta .= "tag_".$criterio[0]."='".$criterio[1]."' AND ";
				}
				$consulta = " WHERE ".substr(trim($consulta), 0, strlen($consulta)-5).$limites;
				$rs = $this->consultar("SELECT * FROM tags".$consulta);
				if(!$rs)
					die("Hubo un error en la consulta SQL:Local.");
				if(mysql_num_rows($rs)==0){
					return false;
				}
				elseif(mysql_num_rows($rs)==1){
					$datos_tag = mysql_fetch_array($rs);
					$this->id = $datos_tag['tag_id'];
					$this->titulo = $datos_tag['tag_titulo'];
					$this->nombre = $datos_tag['tag_nombre'];
					
					return $this;
				}
				else{
					$i=0;
					while($datos_tag = mysql_fetch_array($rs)){
						$tag[$i] = new Tag();
						$tag[$i]->id = $datos_tag['tag_id'];
						$tag[$i]->titulo = $datos_tag['tag_titulo'];
						$tag[$i]->nombre = $datos_tag['tag_nombre'];
						$i++;
					}
					return $tag;
				}
			}
		}
	}
?>