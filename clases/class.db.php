<?php
	global $db;
	class DB{
		function DB(){
			$db = mysql_connect(servidor_db, usuario_db, clave_db);
			mysql_select_db(nombre_db, $db);
			return $db;
		}
		function consultar($sSQL){
			$rs = mysql_query($sSQL);
			return $rs;
		}
	}
?>