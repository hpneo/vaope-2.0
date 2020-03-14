<?php
	class Zona extends DB{
		public $id;
		public $idPadre;
		public $titulo;
		public $nombre;
		public $prefijoTel;
		public $coordenadas;

		function Zona(){
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
					$consulta .="zona_".$criterio[0]."='".$criterio[1]."' AND ";
				}
				$consulta = " WHERE ".substr(trim($consulta), 0, strlen($consulta)-5);
			}
			$rs = $this->consultar("SELECT * FROM zonas".$consulta." ORDER BY zona_titulo ASC");
			if(!$rs)
				die("Hubo un error en la consulta SQL:Zona.");
			if(mysql_num_rows($rs)==0){
				return false;
			}
			elseif(mysql_num_rows($rs)==1){
				$datos_zona = mysql_fetch_array($rs);
				$this->id = $datos_zona['zona_id'];
				$this->idPadre = $datos_zona['zona_idPadre'];
				$this->titulo = $datos_zona['zona_titulo'];
				$this->nombre = $datos_zona['zona_nombre'];
				$this->prefijoTel = $datos_zona['zona_prefijoTel'];
				if($datos_zona['zona_coordenadas']!="")
						$coordenadas = explode(',', $datos_zona['zona_coordenadas']);
					else
						$coordenadas = "";
				$this->coordenadas[0] = trim($coordenadas[0]);
				$this->coordenadas[1] = trim($coordenadas[1]);
				return $this;
			}
			else{
				$i=0;
				while($datos_zona = mysql_fetch_array($rs)){
					$zona[$i] = new Zona();
					$zona[$i]->id = $datos_zona['zona_id'];
					$zona[$i]->idPadre = $datos_zona['zona_idPadre'];
					$zona[$i]->titulo = $datos_zona['zona_titulo'];
					$zona[$i]->nombre = $datos_zona['zona_nombre'];
					$zona[$i]->prefijoTel = $datos_zona['zona_prefijoTel'];
					if($datos_zona['zona_coordenadas']!="")
						$coordenadas = explode(',', $datos_zona['zona_coordenadas']);
					else
						$coordenadas = "";
					$zona[$i]->coordenadas[0] = trim($coordenadas[0]);
					$zona[$i]->coordenadas[1] = trim($coordenadas[1]);
					$i++;
				}
				return $zona;
			}
		}
		function agregar($idPadre, $titulo, $prefijoTel, $coordenadas){
			$titulo = mysql_real_escape_string(htmlentities($titulo, ENT_QUOTES, "utf-8"));
			$prefijoTel = trim($prefijoTel);
			$nombre = crear_nombre($titulo);
			$rs = $this->consultar("SELECT * FROM zonas WHERE zona_nombre='$nombre'");
			if(mysql_num_rows($rs)==0)
				$nombre = crear_nombre($titulo);
			else
				$nombre = crear_nombre($titulo).'-'.mysql_num_rows($rs);
			
			$coordenadas = ereg_replace("\((.*)\)","\\1", $coordenadas);
			
			$rs = $this->consultar("INSERT INTO zonas (zona_idPadre, zona_titulo, zona_nombre, zona_prefijoTel, zona_coordenadas) VALUES ($idPadre, '$titulo', '$nombre', $prefijoTel, '$coordenadas')");
			if(!$rs)
				return false;
			else
				return true;
		}
		function editar($idPadre, $titulo, $prefijoTel){
			$titulo = mysql_real_escape_string(htmlentities($titulo, ENT_QUOTES, "utf-8"));
			$prefijoTel = trim($prefijoTel);
			$rs = $this->consultar("UPDATE zonas SET zona_idPadre=$idPadre, zona_titulo='$titulo', zona_prefijoTel=$prefijoTel WHERE zona_id=".$this->id);
			if(!$rs)
				return false;
			else
				return true;
		}
		function eliminar($busqueda){
			$dato_zona = new Zona();
			$dato_zona = $this->info($busqueda);
			if($dato_zona['id']==0)
				die("No puedes eliminar la zona por defecto.");
			$rs = $this->consultar("DELETE FROM zonas WHERE zona_id=".$dato_zona->id);
			if(!$rs)
				die("Error al eliminar la zona.");
			$rs = $this->consultar("UPDATE locales SET zona_id=2 WHERE zona_id=".$dato_zona->id);
			if(!$rs)
				return false;
			else
				return true;
		}
		function n_locales(){
			$rs = $this->consultar("SELECT COUNT(*) AS n_locales FROM locales WHERE zona_id=".$this->id);
			$n_locales = mysql_fetch_array($rs);
			return $n_locales['n_locales'];
		}
	}
?>