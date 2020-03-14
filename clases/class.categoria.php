<?php
	class Categoria extends DB{
		public $id;
		public $idPadre;
		public $titulo;
		public $nombre;
		
		function Categoria(){
		}
		function info($busqueda=NULL){
			if($busqueda==""){
				$consulta="";
			}
			else{
				$busqueda = explode("|", $busqueda);
				
				for($i=0;$i<sizeof($busqueda);$i++){
					if($busqueda[$i]=="")
						continue;
					$criterio = explode("=", $busqueda[$i]);
					$consulta .="categoria_".$criterio[0]."='".$criterio[1]."' AND ";
				}
				$consulta = " WHERE ".substr(trim($consulta), 0, strlen($consulta)-5);
			}
			$rs = $this->consultar("SELECT * FROM categorias".$consulta." ORDER BY categoria_titulo ASC");
			if(!$rs)
				die("Hubo un error en la consulta SQL:Categoria.");
			if(mysql_num_rows($rs)==0){
				return false;
			}
			elseif(mysql_num_rows($rs)==1){
				$datos_categoria = mysql_fetch_array($rs);
				$this->id = $datos_categoria['categoria_id'];
				$this->idPadre = $datos_categoria['categoria_idPadre'];
				$this->titulo = $datos_categoria['categoria_titulo'];
				$this->nombre = $datos_categoria['categoria_nombre'];
				return $this;
			}
			else{
				$i=0;
				while($datos_categoria = mysql_fetch_array($rs)){
					$categoria[$i]			=	new Categoria();
					$categoria[$i]->id		=	$datos_categoria['categoria_id'];
					$categoria[$i]->idPadre	=	$datos_categoria['categoria_idPadre'];
					$categoria[$i]->titulo	=	$datos_categoria['categoria_titulo'];
					$categoria[$i]->nombre	=	$datos_categoria['categoria_nombre'];
					$i++;
				}
				return $categoria;
			}
		}
		function agregar($idPadre, $titulo){
			$titulo = mysql_real_escape_string(htmlentities(trim($titulo), ENT_QUOTES, "utf-8"));
			$nombre = crear_nombre($titulo);
			$rs = $this->consultar("SELECT * FROM categorias WHERE categoria_nombre='$nombre'");
			if(mysql_num_rows($rs)==0)
				$nombre = crear_nombre($titulo);
			else
				$nombre = crear_nombre($titulo).'-'.mysql_num_rows($rs);

			$rs = $this->consultar("INSERT INTO categorias (categoria_idPadre, categoria_titulo, categoria_nombre) VALUES ($idPadre, '$titulo', '$nombre')");
			if(!$rs)
				return false;
			else
				return true;
		}
		function editar($idPadre, $titulo){
			$titulo = mysql_real_escape_string(htmlentities($titulo, ENT_QUOTES, "utf-8"));
			$rs = $this->consultar("UPDATE categorias SET categoria_idPadre=$idPadre, categoria_titulo='$titulo' WHERE categoria_id=".$this->id);
			if(!$rs)
				return false;
			else
				return true;
		}
		function eliminar(){
			if($dato_categoria->id==2)
				die("No puedes eliminar la categor&iacute;a por defecto.");
			$rs = $this->consultar("DELETE FROM categorias WHERE categoria_id=".$this->id);
			if(!$rs)
				die("Error al eliminar la categor&iacute;a.");
			$rs = $this->consultar("UPDATE locales SET categoria_id=2 WHERE categoria_id=".$this->id);
			if(!$rs)
				return false;
			else
				return true;
		}
		function n_locales(){
			$rs = $this->consultar("SELECT COUNT(*) AS n_locales FROM locales WHERE categoria_id=".$this->id);
			$n_locales = mysql_fetch_array($rs);
			return $n_locales['n_locales'];
		}
	}
?>