<?php
	obtener_cabecera();
	$pagina = estas_en('pagina');
	if($pagina->nombre!="contacto"){
?>
		<div id="cuerpo">
			<h4 class="centrado"><?php echo $pagina->titulo; ?></h4>
			<div id="sin_columnas">
				<?php echo $pagina->contenido; ?>
			</div>
		</div>
<?php
	}
	else{
?>
		<div id="cuerpo">
			<h4 class="centrado"><?php echo $pagina->titulo; ?></h4>
			<div id="sin_columnas">
				<?php
					if($_POST){
						$nombre = trim(htmlentities($_POST['nombre'], ENT_QUOTES, "utf-8"));
						$email = trim($_POST['email']);
						$mensaje = trim(htmlentities($_POST['mensaje'], ENT_QUOTES, "utf-8"));
						if($nombre=="")
							die('
							<div class="mensaje error">
								<p>
									Debes escribir tu nombre
								</p>
							</div>
							');
						if($email=="")
							die('
							<div class="mensaje error">
								<p>
									Debes escribir tu e-mail
								</p>
							</div>
							');
						if($mensaje=="")
							die('
							<div class="mensaje error">
								<p>
									Debes escribir tu mensaje
								</p>
							</div>
							');
						$mensaje = '
						<p>
							'.$nombre.'('.$email.') ha enviado un mensaje desde el formulario de contacto:
							'.$mensaje.'
						</p>
						';
						$mail = new Mail('contacto@vaope.com', 'Mensaje de contacto de '.$nombre, $mensaje);
						if(!$mail->enviar()){
							echo '
								<div class="mensaje error">
								<p>
									Tu mensaje no se pudo enviar.
								</p>
							</div>
							';
						}
						else{
							echo '
								<div class="mensaje exito">
								<p>
									Tu mensaje se envi&oacute; correctamente. En unos minutos, horas, o d&iacute;as estaremos respondi&eacute;ndote ;)
								</p>
							</div>
							';
						}
					}
				?>
				<form id="contacto" action="<?php home(); ?>/contacto" method="post">
					<p>
						<label for="nombre">Nombre: </label>
						<input type="text" name="nombre" id="nombre" size="20" />
					</p>
					<p>
						<label for="email">E-mail: </label>
						<input type="text" name="email" id="email" size="30" />
					</p>
					<p>
						<label for="asunto">Asunto: </label>
						<select name="asunto" id="asunto">
							<option value="contacto">Quiero contactar con el equipo de Vao Pe!</option>
							<option value="feedback">Tengo ideas para Vao Pe! / Hay problemas con Vao Pe!</option>
						</select>
					</p>
					<p>
						<label for="mensaje">Mensaje: </label>
						<textarea name="mensaje" id="mensaje"></textarea>
					</p>
					<p>
						<input type="submit" value="Enviar mensaje" class="boton" />
					</p>
				</form>
			</div>
		</div>
<?php
	}
	obtener_pie();
?>