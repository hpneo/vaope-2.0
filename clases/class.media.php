<?php
	class Media extends DB{
		public $id;
		public $tipo;
		public $ruta;
		public $fecha;
		
		function Media(){
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
						$consulta .= "media_".$criterio[0]."='".$criterio[1]."' AND ";
					}
					else{
						$consulta .= $criterio[0]."_id=".$criterio[1]." AND ";
					}
				}
				$consulta = " WHERE ".substr(trim($consulta), 0, strlen($consulta)-5);
			}
			$rs = $this->consultar("SELECT * FROM media".$consulta);
			if(!$rs)
				die("Hubo un error en la consulta SQL:Media.");
			if(mysql_num_rows($rs)==0){
				return false;
			}
			else{
				$i=0;
				while($datos_media = mysql_fetch_array($rs)){
					$media[$i] = new Media();
					$media[$i]->id = $datos_media['media_id'];
					$media[$i]->tipo = $datos_media['media_tipo'];
					$media[$i]->ruta = $datos_media['media_ruta'];
					$media[$i]->fecha = $datos_media['media_fecha'];
					$i++;
				}
				return $media;
			}
		}
		function agregar($idLocal, $tipo, $ruta){
			$rs = $this->consultar("INSERT INTO media (local_id, media_tipo, media_ruta, media_fecha) VALUES ($idLocal, '$tipo', '$ruta', ".time().")");
			if(!$rs){
				if($tipo=='foto')
					die('No se pudo agregar la foto.');
				elseif($tipo=='video')
					die('No se pudo agregar el video.');
			}
		}
	}
?>