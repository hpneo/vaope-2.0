<?php
	class Telefono extends DB{
		public $numero;
		public $tipo;
		function Telefono(){
		}
		function info($busqueda){
			if($busqueda==""){
				$consulta="";
			}
			else{
				$busqueda = explode("|", $busqueda);
				for($i=0;$i<sizeof($busqueda);$i++){
					$criterio = explode("=", $busqueda[$i]);
					if($criterio[0]!='local'){
						$consulta .= "telefono_".$criterio[0]."='".$criterio[1]."' AND ";
					}
					else{
						$consulta .= $criterio[0]."_id=".$criterio[1]." AND ";
					}
				}
				$consulta = " WHERE ".substr(trim($consulta), 0, strlen($consulta)-5);
			}
			$rs = $this->consultar("SELECT * FROM telefonos".$consulta);
			if(!$rs)
				die("Hubo un error en la consulta SQL:Telefono.");
			if(mysql_num_rows($rs)==0){
				return false;
			}
			/*elseif(mysql_num_rows($rs)==1){
				$datos_telefono = mysql_fetch_array($rs);
				$this->numero = $datos_telefono['telefono_numero'];
				return $this;
			}*/
			else{
				$i=0;
				while($datos_telefono = mysql_fetch_array($rs)){
					$telefono[$i] = new Telefono();
					$telefono[$i]->numero = $datos_telefono['telefono_numero'];
					$telefono[$i]->tipo = $datos_telefono['telefono_tipo'];
					$i++;
				}
				return $telefono;
			}
		}
		function agregar($idLocal, $numero, $tipo){
			$rs = $this->consultar("INSERT INTO telefonos (local_id, telefono_numero, telefono_tipo) VALUES ($idLocal, '$numero', '$tipo')");
			if(!$rs)
				die("Ops! El tel&eacute;fono no se pudo agregar.");
		}
	}
?>