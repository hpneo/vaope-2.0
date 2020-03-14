<?php
	obtener_cabecera();
?>
		<div id="cuerpo">
			<?php
				if(!estas_logueado()){
					echo '<h4 class="centrado">Necesitas estar logueado para poder acceder al panel de usuario.</h4>';
				}
				else{
			?>
			<div id="barra" class="panel">
				<h4>Locales</h4>
				<ul class="lista">
					<li><a href="<?php home(); ?>/panel/agregar" title="Agregar local"><img src="<?php home(); ?>/plantillas/imagenes/agregar.png" alt="Agregar" />Agregar</a></li>
					<li><a href="<?php home(); ?>/panel/editar" title="Editar local"><img src="<?php home(); ?>/plantillas/imagenes/editar.png" alt="Editar" />Editar</a></li>
				</ul>
				<h4>Datos personales</h4>
				<ul class="lista">
					<li><a href="<?php home(); ?>/panel/editar-datos" title="Editar datos"><img src="<?php home(); ?>/plantillas/imagenes/editar_usuario.png" alt="Editar datos" />Editar datos</a></li>
					<li><a href="<?php home(); ?>/panel/cambiar-clave" title="Cambiar clave"><img src="<?php home(); ?>/plantillas/imagenes/clave.png" alt="Cambiar clave" />Cambiar clave</a></li>
				</ul>
			</div>
			<div id="contenido">
				<?php
					switch(estas_en('panel')){
						case 'agregar':
				?>
				<h4 class="centrado">Agregar local</h4>
				<?php
					if(!$_POST){
				?>
				<form action="<?php home(); ?>/panel/agregar" method="post" id="agregar_local">
					<p>
						<label for="local_titulo">*Nombre:</label>
						<input type="text" name="local_titulo" id="local_titulo" size="40" class="required" />
					</p>
					<p>
						<label for="local_categoria">*Categor&iacute;a:</label>
						<?php listar_categorias_combo(); ?>
					</p>
					<p>
						<label for="local_zona">*Zona:</label>
						<?php listar_zonas_combo(); ?>
					</p>
					<p>
						<label for="local_descripcion">*Descripci&oacute;n:</label>
						<script type="text/javascript">
								tinyMCE.init({
									mode : "exact",
									elements : "local_descripcion",
									theme : "advanced",
									width:"560",
									height:"300",
									theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,image,|,code",
									theme_advanced_buttons2 : "",
									theme_advanced_toolbar_location : "top",
									theme_advanced_toolbar_align : "left",
									theme_advanced_statusbar_location : "none",
									theme_advanced_resizing : false,
									theme_advanced_containers_default_class : "validate['required','alphanum'] text-input",
								});
						</script>
						<textarea name="local_descripcion" id="local_descripcion"></textarea>
					</p>
					<p>
						<label for="local_direccion">*Direcci&oacute;n:</label>
						<input type="text" name="local_direccion" id="local_direccion" size="35" class="validate['required','alphanum'] text-input" />
					</p>
					<p>
					<label><a id="agregar_telefono" href="#"><img src="<?php echo url.'/plantillas/imagenes/agregar.png'; ?>" /></a>Tel&eacute;fono(s):</label>
					<ul class="lista" id="lista_telefono">
						<li class="telefonos">
							<ul class="lineal">
								<li><input type="text" name="local_telefono[]" /></li>
								<li>
									<select name="local_tipo_telefono[]">
										<option value="">Elige un tipo</option>
										<option value="delivery">Delivery</option>
										<option value="reservaciones">Reservaciones</option>
									</select>
								</li>
							</ul>
						</li>
					</ul>
					</p>
					<p>
					<label><a id="agregar_media" href="#"><img src="<?php echo url.'/plantillas/imagenes/agregar.png'; ?>" /></a>Fotos y videos:</label>
					<ul class="lista" id="lista_media">
						<li class="media">
							<ul class="lineal">
								<li><input type="text" name="local_media[]" /></li>
								<li><select name="local_tipo_media[]"><option value="foto">Foto</option><option value="video">Video</option></select></li>
							</ul>
						</li>
					</ul>
					</p>
					<p class="mensaje">
						Puedes poner la direcci&oacute;n de una foto en Flickr (por ejemplo: <a href="http://www.flickr.com/photos/hpneo/2636342177/">http://www.flickr.com/photos/hpneo/2636342177/</a>), o de un video en YouTube (por ejemplo: <a href="http://www.youtube.com/watch?v=tRzTfgds0UI">http://www.youtube.com/watch?v=tRzTfgds0UI</a>) o Vimeo (por ejemplo: <a href="http://vimeo.com/2720354">http://vimeo.com/2720354</a>). Tienes esta informaci&oacute;n m&aacute;s detallada en <a href="<?php echo url; ?>/agregar-locales/" title="Una peque&ntilde;a gu&iacute;a de c&oacute;mo agregar locales">'&iquest;C&oacute;mo agregar locales?'</a>.
					</p>
					<p>
						<label for="local_url">Sitio web:</label>
						<input type="text" name="local_url" id="local_url" size="25" />
					</p>
					<p>
						<label for="local_tags">Etiquetas:</label>
						<input type="text" name="local_tags" id="local_tags" size="40" />
						
					</p>
					<p class="mensaje">Separa las etiquetas con comas.</p>
					<p>
						<label for="local_puntuacion">Puntuaci&oacute;n:</label>
						<select name="local_puntuacion" id="local_puntuacion">
							<option value="0" title="Sin estrellas">Sin estrellas</option>
							<option value="1" title="1 estrella">1 estrella</option>
							<option value="2" title="2 estrellas">2 estrellas</option>
							<option value="3" title="3 estrellas">3 estrellas</option>
							<option value="4" title="4 estrellas">4 estrellas</option>
							<option value="5" title="5 estrellas">5 estrellas</option>
						</select>
					</p>
					<p>
						<label for="local_cmapa">Poner mapa</label><input type="checkbox" name="local_cmapa" id="local_cmapa" value="si" />
					</p>
					<div id="mapa" style="margin-left:100px;"></div>
					<p class="mensaje">Debes arrastrar el marcador hacia el lugar donde se encuentre el local.</p>
					<p class="mensaje">Los datos marcados con asterisco (*) son obligatorios.</p>
					<p>
						<input type="hidden" name="local_coordenadas" id="local_coordenadas" value="" />
						<input type="submit" value="Agregar" class="boton" />
					</p>
				</form>
				<?php
					}
					else{
						$local = new Local();
						$telefono = $_POST['local_telefono'];
						$tipo_telefono = $_POST['local_tipo_telefono'];
						
						for($i=0;$i<sizeof($telefono);$i++){
							$telefonos[$i]['numero'] = $telefono[$i];
							$telefonos[$i]['tipo'] = $tipo_telefono[$i];
						}
						
						$ruta_media = $_POST['local_media'];
						$tipo_media = $_POST['local_tipo_media'];
						
						for($i=0;$i<sizeof($ruta_media);$i++){
							$media[$i]['ruta'] = $ruta_media[$i];
							$media[$i]['tipo'] = $tipo_media[$i];
						}
						
						$local->agregar($_POST['local_titulo'], $_POST['local_descripcion'], $_POST['local_categoria'], $_POST['local_zona'], $_POST['local_direccion'], $_POST['local_coordenadas'], $_POST['local_puntuacion'], $_POST['local_tags'], $telefonos, $media, $_POST['local_url']);
					}
				?>
				<?php
						break;
						case 'editar':
				?>
				<h4 class="centrado">Editar local</h4>
                <?php
					$id = trim($_GET['id']);
					$usuario_actual = new Usuario();
					$usuario_actual = $usuario_actual->info('nick='.$_COOKIE['nick']);
					if($id==""){
						$usuario_actual->listar_locales(true);
					}
					else{
						$local = new Local();
						$local = $local->info('id='.$id);
						if(!$_POST){
                ?>
                <form action="<?php home(); ?>/panel/editar/?id=<?php echo $id; ?>" method="post" id="agregar_local">
                	<p>
                    	<label for="local_titulo">*Nombre:</label>
                        <input type="text" name="local_titulo" id="local_titulo" size="40" value="<?php echo $local->titulo; ?>" />
                    </p>
                    <p>
						<label for="local_categoria">*Categor&iacute;a:</label>
						<?php listar_categorias_combo($local->categoria->id); ?>
					</p>
					<p>
						<label for="local_zona">*Zona:</label>
						<?php listar_zonas_combo($local->zona->id); ?>
					</p>
                    <p>
						<label for="local_descripcion">*Descripci&oacute;n:</label>
						<script type="text/javascript">
								tinyMCE.init({
									mode : "exact",
									elements : "local_descripcion",
									theme : "advanced",
									width:"560",
									height:"300",
									theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,image,|,code",
									theme_advanced_buttons2 : "",
									theme_advanced_toolbar_location : "top",
									theme_advanced_toolbar_align : "left",
									theme_advanced_statusbar_location : "none",
									theme_advanced_resizing : false,
									theme_advanced_containers_default_class : "validate['required','alphanum'] text-input",
								});
						</script>
						<textarea name="local_descripcion" id="local_descripcion"><?php echo $local->descripcion; ?></textarea>
					</p>
					<p>
						<label for="local_direccion">*Direcci&oacute;n:</label>
						<input type="text" name="local_direccion" id="local_direccion" size="35" value="<?php echo $local->direccion; ?>" />
					</p>
                    <p>
						<label><a id="agregar_telefono" href="#"><img src="<?php home(); ?>/plantillas/imagenes/agregar.png" /></a>Tel&eacute;fono(s):</label>
						<ul class="lista" id="lista_telefono">
							<?php
                            	if(!$local->telefono){
									echo '
									<li class="telefonos">
										<ul class="lineal">
											<li><input type="text" name="local_telefono[]" value="" /></li>
											<li>
												<select name="local_tipo_telefono[]">
													<option value="">Elige un tipo</option>
													<option value="delivery">Delivery</option>
													<option value="reservaciones">Reservaciones</option>
												</select>
											</li>
										</ul>
									</li>
									';
								}
								else{
									foreach($local->telefono as $telefono){
										echo '
										<li class="telefonos">
											<ul class="lineal">
												<li><input type="text" name="local_telefono[]" value="'.$telefono->numero.'" /></li>
												<li>
													<select name="local_tipo_telefono[]">
														<option value="">Elige un tipo</option>
										';
										if($telefono->tipo=="delivery"){
											echo '<option value="delivery" selected="selected">Delivery</option>';
										}
										else{
											echo '<option value="delivery">Delivery</option>';
										}
										if($tipo=="reservaciones"){
											echo '<option value="reservaciones" selected="selected">Reservaciones</option>';
										}
										else{
											echo '<option value="reservaciones">Reservaciones</option>';
										}
										echo '
													</select>
												</li>
											</ul>
										</li>
										';
									}
								}
							?>
						</ul>
					</p>
					<p>
						<label><a id="agregar_media" href="#"><img src="<?php echo url.'/plantillas/imagenes/agregar.png'; ?>" /></a>Fotos y videos:</label>
						<ul class="lista" id="lista_media">
							<?php
                            	if(!$local->fotos && !$local->videos){
									echo '
									<li class="media">
										<ul class="lineal">
											<li><input type="text" name="local_media[]" /></li>
											<li>
												<select name="local_tipo_media[]">
													<option value="foto">Foto</option>
													<option value="video">Video</option>
												</select>
											</li>
										</ul>
									</li>
									';
								}
								else{
									if(is_array($local->fotos)){
										foreach($local->fotos as $foto){
											echo '
											<li class="media">
												<ul class="lineal">
													<li><input type="text" name="local_media[]" value="'.$foto->ruta.'" /></li>
													<li>
														<select name="local_tipo_media[]">
															<option value="foto" selected="selected">Foto</option>
															<option value="video">Video</option>
														</select>
													</li>
												</ul>
											</li>
											';
										}
									}
									else{
										$foto = $fotos;
										echo '
										<li class="media">
											<ul class="lineal">
												<li><input type="text" name="local_media[]" value="'.$foto->ruta.'" /></li>
												<li>
													<select name="local_tipo_media[]">
														<option value="foto" selected="selected">Foto</option>
														<option value="video">Video</option>
													</select>
												</li>
											</ul>
										</li>
										';
									}
									if(is_array($local->videos)){
										foreach($local->videos as $video){
											echo '
											<li class="media">
												<ul class="lineal">
													<li><input type="text" name="local_media[]" value="'.$video->ruta.'" /></li>
													<li>
														<select name="local_tipo_media[]">
															<option value="foto">Foto</option>
															<option value="video" selected="selected">Video</option>
														</select>
													</li>
												</ul>
											</li>
											';
										}
									}
									else{
										$video = $videos;
										echo '
										<li class="media">
											<ul class="lineal">
												<li><input type="text" name="local_media[]" value="'.$video->ruta.'" /></li>
												<li>
													<select name="local_tipo_media[]">
														<option value="foto">Foto</option>
														<option value="video" selected="selected">Video</option>
													</select>
												</li>
											</ul>
										</li>
										';
									}
								}
							?>
						</ul>
					</p>
					<p class="mensaje">
						Puedes poner la direcci&oacute;n de una foto en Flickr (por ejemplo: <a href="http://www.flickr.com/photos/hpneo/2636342177/">http://www.flickr.com/photos/hpneo/2636342177/</a>), o de un video en YouTube (por ejemplo: <a href="http://www.youtube.com/watch?v=tRzTfgds0UI">http://www.youtube.com/watch?v=tRzTfgds0UI</a>) o Vimeo (por ejemplo: <a href="http://vimeo.com/2720354">http://vimeo.com/2720354</a>). Tienes esta informaci&oacute;n m&aacute;s detallada en <a href="<?php echo url; ?>/agregar-locales/" title="Una peque&ntilde;a gu&iacute;a de c&oacute;mo agregar locales">'&iquest;C&oacute;mo agregar locales?'</a>.
					</p>
                    <p>
						<label for="local_url">Sitio web:</label>
						<input type="text" name="local_url" id="local_url" size="25" value="<?php echo $local->url; ?>" />
					</p>
					<p>
						<label for="local_tags">Etiquetas:</label>
                        <?php
							if($local-tags!=""){
								for($i=0;$i<sizeof($local->tags);$i++){
									$tag[$i] = $local->tags[$i]->titulo;
								}
								$tags = implode(', ', $tag);
							}
                        ?>
						<input type="text" name="local_tags" id="local_tags" size="40" value="<?php echo $tags; ?>"/>
						
					</p>
					<p class="mensaje">Separa las etiquetas con comas.</p>
                    <p>
						<label for="local_cmapa">Poner mapa</label><input type="checkbox" name="local_cmapa" id="local_cmapa" value="si" <?php if($local->coordenadas[0]!="" && $local->coordenadas[1]!=""){ ?>checked="checked" <?php } ?> />
					</p>
					<div id="mapa" style="margin-left:100px;">
                    <?php
						if($local->coordenadas[0]!="" && $local->coordenadas[1]!=""){
							$div['id'] = 'map';
							$div['width'] = '560px';
							$div['height'] = '360px';
							$mapa = new GMap('ABQIAAAASib4jDklIBHvXXkIvtLLOxQlYFiABaELWVY2toQCZOdbA8emxxQl3PYjyqRQWEw6fEzqIUO5biHI4w', $div);
							$mapa->zoom = 15;
							$mapa->center['lat'] = $local->coordenadas[0];
							$mapa->center['long'] = $local->coordenadas[1];
							$mapa->add_marker($local->coordenadas[0], $local->coordenadas[1], "", "", "", true, "local_coordenadas");
							$mapa->print_map();
						}
					?>
                    </div>
					<p class="mensaje">Debes arrastrar el marcador hacia el lugar donde se encuentre el local.</p>
					<p class="mensaje">Los datos marcados con asterisco (*) son obligatorios.</p>
					<p>
						<input type="hidden" name="local_coordenadas" id="local_coordenadas" value="<?php if($local->coordenadas[0]!="" && $local->coordenadas[1]!=""){ echo $local->coordenadas[0].','.$local->coordenadas[1];} ?>" />
						<input type="submit" value="Editar" class="boton" />
					</p>
                </form>
				<?php
						}
						else{
							$telefono = $_POST['local_telefono'];
							$tipo_telefono = $_POST['local_tipo_telefono'];
							for($i=0;$i<sizeof($telefono);$i++){
								$telefonos[$i]['numero'] = $telefono[$i];
								$telefonos[$i]['tipo'] = $tipo_telefono[$i];
							}
							
							$ruta_media = $_POST['local_media'];
							$tipo_media = $_POST['local_tipo_media'];
							
							for($i=0;$i<sizeof($ruta_media);$i++){
								$media[$i]['ruta'] = $ruta_media[$i];
								$media[$i]['tipo'] = $tipo_media[$i];
							}
							$local->editar($_POST['local_titulo'], $local->nombre, $_POST['local_descripcion'], $_POST['local_categoria'], $_POST['local_zona'], $_POST['local_direccion'], $_POST['local_coordenadas'], $_POST['local_tags'], $telefonos, $media, $_POST['local_url']);
						}
					}
						break;
						case 'editar-datos':
							$usuario = new Usuario();
							$usuario = $usuario->info("nick=".$_COOKIE['nick']);
				?>
				<h4 class="centrado">Editar datos</h4>
				<?php
					if($_POST){
						$email = $_POST['usuario_email'];
						$descripcion = $_POST['usuario_descripcion'];
						$url = $_POST['usuario_website'];
						if($_POST['usuario_mostrar_email']=="")
							$mostrar_email = "no";
						else
							$mostrar_email = "si";
						
						if($usuario->editar("id=".$usuario->id, $descripcion, $mostrar_email, $email, $url))
							echo '
							<div class="mensaje exito">
								<p>Tus datos han sido editados con &eacute;xito.</p>
							</div>';
						else
							echo '
							<div class="mensaje error">
								<p>Hubo un error al tratar de editar tus datos.</p>
							</div>';
						$usuario = new Usuario();
						$usuario = $usuario->info("nick=".$_COOKIE['nick']);
					}
				?>
				<form method="post" action="<?php home(); ?>/panel/editar-datos/">
					<p>
						<label for="usuario_email">E-mail: </label>
						<input type="text" name="usuario_email" id="usuario_email" size="30" maxlength="30" value="<?php echo $usuario->email; ?>" />
					</p>
					<p>
						<label for="usuario_mostrar_email">&iquest; Mostrar E-mail? </label>
						<?php if($usuario->mostrar_email=="no"): ?>
						<input type="checkbox" name="usuario_mostrar_email" id="usuario_mostrar_email" value="si" />
						<?php else: ?>
						<input type="checkbox" name="usuario_mostrar_email" id="usuario_mostrar_email" checked="checked" value="si" />
						<?php endif; ?>
					</p>
					<p>
						<label for="usuario_descripcion">Descripci&oacute;n: </label>
						<textarea name="usuario_descripcion" id="usuario_descripcion"><?php echo $usuario->descripcion; ?></textarea>
					</p>
					<p>
						<label for="usuario_website">Sitio web: </label>
						<input type="text" name="usuario_website" id="usuario_website" value="<?php echo $usuario->url; ?>" size="30" />
					</p>
					<p>
						<input type="submit" value="Editar datos" class="boton" />
					</p>
				</form>
				<?php
						break;
						case 'cambiar-clave':
							$usuario = new Usuario();
							$usuario = $usuario->info("nick=".$_COOKIE['nick']);
				?>
				<h4 class="centrado">Cambiar clave</h4>
				<?php
					if($_POST){
						$clave_antigua = trim($_POST['clave_antigua']);
						$clave_nueva = trim($_POST['clave_nueva']);
						$clave_nueva2 = trim($_POST['clave_nueva2']);
						if($usuario->clave!=md5($clave_antigua))
							die('
							<div class="mensaje error">
								<p>Has escrito incorrectamente tu clave anterior.</p>
							</div>
							');
						if(md5($clave_nueva)!=md5($clave_nueva2))
							die('
							<div class="mensaje error">
								<p>Tu nueva clave no concuerda con su repetici&oacute;n.</p>
							</div>
							');
						if($usuario->cambiar_clave($clave_nueva))
							echo '
							<div class="mensaje exito">
								<p>Tu clave ha sido editada con &eacute;xito.</p>
								<p>Te recomendamos cerrar sesi&oacute;n y volver a ingresar.</p>
							</div>';
						else
							echo '
							<div class="mensaje error">
								<p>Hubo un error al tratar de cambiar tu clave.</p>
							</div>';
					}
				?>
				<form method="post" action="<?php home(); ?>/panel/cambiar-clave/">
					<p>
						<label for="clave_antigua">Clave anterior: </label>
						<input type="password" name="clave_antigua" id="clave_antigua" />
					</p>
					<p>
						<label for="clave_nueva">Nueva clave: </label>
						<input type="password" name="clave_nueva" id="clave_nueva" />
					</p>
					<p>
						<label for="clave_nueva2">Repite tu nueva clave: </label>
						<input type="password" name="clave_nueva2" id="clave_nueva2" />
					</p>
					<p>
						<input type="submit" value="Cambiar clave" class="boton" />
					</p>
				</form>
				<?php
						break;
						default:
				?>
				<h4 class="centrado">Panel de Control</h4>
				<ul class="paneles">
					<li>
						<h5>Tus &uacute;ltimos locales agregados</h5>
						<?php
							$usuario_actual = new Usuario();
							$usuario_actual = $usuario_actual->info('nick='.$_COOKIE['nick']);
							$usuario_actual->listar_locales(true);
						?>
					</li>
				</ul>
				<?php
						break;
					}
				?>
			</div>
			<?php } ?>
		</div>
<?php
	obtener_pie();
?>