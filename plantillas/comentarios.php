				<h5 id="comentarios">Comentarios</h5>
				<ul id="lista_comentarios">
					<?php
						$comentarios = new Comentario();
						$local_nombre = estas_en('local');
						$local = new Local();
						$local = $local->info('nombre='.$local_nombre[1]);
						$comentarios = $comentarios->listar($local->id);
						if(!$comentarios){
					?>
					<li>No hay comentarios</li>
					<?php
						}
						else{
							$i=0;
							foreach($comentarios as $comentario){
								if($i%2==0)
									$clase = ' class="alt"';
					?>
					<li<?php echo $clase; ?> id="comentario-<?php echo $comentario->fecha; ?>">
						<?php if($comentario->autor->url!=""){ echo '<a href="'.$comentario->autor->url.'" rel="external nofollow">'.$comentario->autor->nick.'</a>'; }else{ echo $comentario->autor->nick; } ?> coment&oacute; el <a href="#comentario-<?php echo $comentario->fecha; ?>"><?php fecha('j \d\e F', $comentario->fecha);?></a>:
						<?php echo $comentario->contenido; ?>
					</li>
					<?php
								$i++;
							}
						}
					?>
				</ul>
				<?php
					if(!estas_logueado()){
						echo '<p class="mensaje">Necesitas loguearte para poder comentar.</p>';
					}
					else{
						$usuario = new Usuario();
						$usuario = $usuario->info('nick='.$_COOKIE['nick']);
						echo '
						<h5>No seas t&iacute;mido. Comenta:</h5>
						<form action="'.url.'/comentar.php" method="post" id="formulario_comentario">
							<script type="text/javascript">
								tinyMCE.init({
									mode : "exact",
									elements : "cuerpo_comentario",
									theme : "advanced",
									width:"650",
									height:"200",
									theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist",
									theme_advanced_buttons2 : "",
									theme_advanced_toolbar_location : "top",
									theme_advanced_toolbar_align : "left",
									theme_advanced_statusbar_location : "none",
									theme_advanced_resizing : false,
								});
							</script>
							<textarea id="cuerpo_comentario" name="cuerpo_comentario"></textarea>
							<input type="hidden" name="local_comentario" value="'.$local->id.'" />
							<input type="hidden" name="autor_comentario" value="'.$usuario->id.'" />
							<input type="submit" value="Comentar" class="boton" />
						</form>
						';
					}
				?>