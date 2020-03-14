<?php
	class Pagina extends DB{
		public $id;
		public $titulo;
		public $nombre;
		public $contenido;
		
		function Pagina(){
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
					$consulta .="pagina_".$criterio[0]."='".$criterio[1]."' AND ";
				}
				$consulta = " WHERE ".substr(trim($consulta), 0, strlen($consulta)-5);
			}	
			$rs = $this->consultar("SELECT * FROM paginas".$consulta." ORDER BY pagina_titulo ASC");
			if(!$rs)
				die("Hubo un error en la consulta SQL:Pagina.");
			if(mysql_num_rows($rs)==0){
				return false;
			}
			elseif(mysql_num_rows($rs)==1){
				$datos_pagina= mysql_fetch_array($rs);
				$this->id = $datos_pagina['pagina_id'];
				$this->titulo = $datos_pagina['pagina_titulo'];
				$this->nombre = $datos_pagina['pagina_nombre'];
				$this->contenido = $datos_pagina['pagina_contenido'];
				
				return $this;
			}
			else{
				$i=0;
				while($datos_pagina= mysql_fetch_array($rs)){
					$pagina[$i] = new Pagina();
					$pagina[$i]->id = $datos_pagina['pagina_id'];
					$pagina[$i]->titulo = $datos_pagina['pagina_titulo'];
					$pagina[$i]->nombre = $datos_pagina['pagina_nombre'];
					$pagina[$i]->contenido = $datos_pagina['pagina_contenido'];
					$i++;
				}
				return $pagina;
			}
		}
		function agregar($titulo, $contenido){
			if(!estas_logueado())
				die('Necesitas estar logueado para poder agregar p&aacute;ginas.');
			$titulo = mysql_real_escape_string(htmlentities(stripslashes(trim($titulo)), ENT_QUOTES, "utf-8"));
			$nombre = crear_nombre($titulo);
			$rs = $this->consultar("SELECT * FROM paginas WHERE pagina_nombre='$nombre'");
			if(mysql_num_rows($rs)==0)
				$nombre = crear_nombre($titulo);
			else
				$nombre = crear_nombre($titulo).'-'.mysql_num_rows($rs);
			
			$contenido = mysql_real_escape_string(stripslashes(trim($contenido)));
			
			$rs = $this->consultar("INSERT INTO paginas (pagina_titulo, pagina_nombre, pagina_contenido) VALUES ('".$titulo."', '".$nombre."', '".$contenido."')");
			if($rs)
				return true;
			else
				return false;
		}
		function editar($titulo, $contenido){
			if($this->id=="")
				die("Debes elegir una p&aacute;gina para poder editarlo.");
			if(!estas_logueado())
				die('Necesitas estar logueado para poder editar p&aacute;ginas.');
			$titulo = mysql_real_escape_string(htmlentities(stripslashes(trim($titulo)), ENT_QUOTES, "utf-8"));
			$contenido = mysql_real_escape_string(stripslashes(trim($contenido)));
			
			$rs = $this->consultar("UPDATE paginas SET pagina_titulo='".$titulo."', pagina_contenido='".$contenido."' WHERE pagina_id=".$this->id);
			if($rs)
				return true;
			else
				return false;
		}
		function eliminar(){
			if(estas_logueado()){
				if($this->id=="")
					die("Debes elegir una p&aacute;gna para poder eliminarla.");
				if($this->consultar("DELETE FROM paginas WHERE pagina_id=".$this->id))
					return true;
				else
					return false;
			}
			else{
				return false;
			}
		}
	}
?>