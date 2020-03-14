<?php
	include("config.php");
	include("clases/class.db.php");
	if(usuario_db=="" || nombre_db=="" || url=="")
		die("Debes rellenar los datos del archivo config.php");
	$db = new DB();
	$sql = file_get_contents("sql.txt");
	$sql = explode(";", $sql);
	$i = 0;
	while($sql[$i]!=""){
		if($sql[$i]=="")
			continue;
		if(!$db->consultar($sql[$i]))
			die("ERROR");
		$i++;
	}
	if(!$db->consultar("INSERT INTO usuarios (usuario_nick, usuario_clave, usuario_mostrarEmail, usuario_email, usuario_url, usuario_rango, usuario_fecha) VALUES ('Admin', '".md5('clave')."', 'si', 'admin@vaope.com', 'http://vaope.com/', 1, '".time()."')"))
		die("No se pudo crear la cuenta de administrador.");
	if(!$db->consultar("INSERT INTO categorias (categoria_idPadre, categoria_titulo, categoria_nombre) VALUES (0, 'General', 'general')"))
		die("No se pudo crear la categor&iacute;a General.");
	if(!$db->consultar("INSERT INTO categorias (categoria_idPadre, categoria_titulo, categoria_nombre) VALUES (1, 'Otros', 'otros')"))
		die("No se pudo crear la subcategor&iacute;a Otros.");
	if(!$db->consultar("INSERT INTO zonas (zona_idPadre, zona_titulo, zona_nombre, zona_prefijoTel, zona_coordenadas) VALUES (0, 'General', 'general', 0, '0,0')"))
		die("No se pudo crear la zona General.");
	if(!$db->consultar("INSERT INTO zonas (zona_idPadre, zona_titulo, zona_nombre, zona_prefijoTel, zona_coordenadas) VALUES (1, 'Otros', 'otros', 0, '0,0')"))
		die("No se pudo crear la subzona Otros.");
?>