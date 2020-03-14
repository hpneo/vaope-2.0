<?php
	obtener_cabecera();
?>
<?php
	$local_nombre = estas_en('local');
	$local = new Local();
	$local = $local->info('nombre='.$local_nombre[1]);
?>
	<div id="cuerpo">
		<?php if(existe('local', $local_nombre[1])){ ?>
		<div id="contenido">
			<div class="local" id="local">
				<h4><a href="<?php echo url.'/local/'.$local->nombre; ?>/"><?php echo $local->titulo; ?></a></h4>
				<p class="local_direccion">Queda en <strong><?php echo $local->direccion; ?></strong>, <strong><?php echo $local->zona->titulo; ?></strong></p>
				<div class="local_descripcion">
					<h5>Descripci&oacute;n:</h5>
					<?php echo $local->descripcion; ?>
				</div>
				<?php telefonos($local->telefono); ?>
				<?php if($local->coordenadas[0]!="" && $local->coordenadas[1]!=""): ?>
				<h5>Mapa:</h5>
				<?php mapa_estatico($local->coordenadas); ?>
				<?php endif; ?>
				<?php fotos($local->fotos); ?>
				<?php videos($local->videos); ?>
				<h5>Locales relacionados:</h5>
				<?php
					$locales_relacionados  = $local->localesRelacionados(10);
					echo '<ul class="lista">';
					if(!$locales_relacionados){
						echo '<li>No hay locales relacionados.</li>';
					}
					else{
						if(sizeof($locales_relacionados)==1){
							echo '<li><a href="'.url.'/local/'.$locales_relacionados->nombre.'" title="'.$locales_relacionados->titulo.'">'.$locales_relacionados->titulo.'</a></li>';
						}
						else{
							foreach($locales_relacionados as $local_relacionado){
								echo '<li><a href="'.url.'/local/'.$local_relacionado->nombre.'" title="'.$local_relacionado->titulo.'">'.$local_relacionado->titulo.'</a></li>';
							}
						}
					}
					echo '</ul>';
				?>
				<?php obtener_comentarios(); ?>
			</div>
			<script type="text/javascript"><!--
				google_ad_client = "pub-2550222885214512";
				/* 468x60, creado 31/12/08 */
				google_ad_slot = "1534392822";
				google_ad_width = 468;
				google_ad_height = 60;
				//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
		</div>
		<div id="barra">
			<ul class="lista">
				<li>Agregado por <a href="<?php echo url.'/usuario/'.$local->autor->nick; ?>"><strong><?php echo $local->autor->nick; ?></strong></a>, el <?php fecha('j \d\e F', $local->fecha); ?>.</li>
				<li><strong>Categor&iacute;a:</strong> <a href="<?php echo url.'/categoria/'.$local->categoria->nombre; ?>/"><?php echo $local->categoria->titulo; ?></a></li>
				<li><strong>Zona:</strong> <a href="<?php echo url.'/zona/'.$local->zona->nombre; ?>/"><?php echo $local->zona->titulo; ?></a></li>
				<li><strong>Tags:</strong> <?php mostrar_tags($local->tags); ?></li>
				<?php if($local->url!=""): ?>
				<li><strong>Sitio Web:</strong> <a href="<?php echo $local->url; ?>"><?php echo $local->url; ?></a></li>
				<?php endif; ?>
				<?php if(estas_logueado() && !es_autor($local->autor->id)){ ?>
				<?php if(!esta_votado($local->id)): ?>
				<li>
					<div id="votar" class="<?php echo $local->id; ?>">
						<label for="rating">Puntuaci&oacute;n:</label>
						<div class="statVal">
							<span class="ui-rater">
								<span class="ui-rater-starsOff" style="width:90px;"><span class="ui-rater-starsOn" style="width:<?php echo (80*$local->puntuacion)/5; ?>px"></span></span>
							</span>
				        </div>
				    </div>
				</li>
				<?php else: ?>
				<li style="overflow:hidden;"><strong style="display:block;float:left;">Puntuaci&oacute;n:</strong> <?php echo mostrar_puntuacion($local->puntuacion); ?></li>
				<?php endif;}else{?>
				<li style="overflow:hidden;"><strong style="display:block;float:left;">Puntuaci&oacute;n:</strong> <?php echo mostrar_puntuacion($local->puntuacion); ?></li>
				<?php } ?>
				<?php
				if(estas_logueado()){
	                if(!es_favorito($local->id)):
				?>
				<li class="resaltado" id="local_favorito"><a href="javascript:marcar_favorito('<?php echo $local->id; ?>');"><img src="<?php home(); ?>/plantillas/imagenes/favorito.png" alt="Marcar como favorito" />Marcar como favorito.</a></li>
				<?php else: ?>
				<li class="resaltado" id="local_favorito"><a href="javascript:desmarcar_favorito('<?php echo $local->id; ?>');"><img src="<?php home(); ?>/plantillas/imagenes/no_favorito.png" alt="Desmarcar favorito" />Desmarcar favorito.</a></li>
				<?php
                	endif;
				}
				?>
				<?php if(es_autor($local->autor->id)): ?>
				<li class="resaltado"><a href="<?php home(); ?>/panel/editar/?id=<?php echo $local->id; ?>" title="Edita este local" ><img src="<?php home(); ?>/plantillas/imagenes/editar.png" alt="Edita este local" />Edita este local.</a></li>
				<?php endif;?>
			</ul>
			<script type="text/javascript"><!--
				google_ad_client = "pub-2550222885214512";
				/* 200x200, creado 31/12/08 */
				google_ad_slot = "3862186892";
				google_ad_width = 200;
				google_ad_height = 200;
				//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
		</div>
		<?php
			}
			else{
		?>
		<h4 class="centrado mensaje error">El local que est&aacute;s intentando ver no existe.</h4>
		<?php
			}
		?>

	</div>
<?php
	obtener_pie();
?>