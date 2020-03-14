<?php
	obtener_cabecera();
?>
		<div id="cuerpo">
			<div id="contenido">
			<?php
				if($resultado = estas_en('categoria')){
					if(existe('categoria', $resultado[1])){
						echo '<h4 class="centrado">'.str_replace(nombre." &raquo; ", "", titulo()).'</h4>';
						mostrar_locales("categoria=".$resultado[1], 10);
					}
					else{
						echo '
							<h4 class="centrado">ERROR: La categor&iacute;a a la que est&aacute;s intentando acceder no existe.</h4>
							<p class="centrado">
								<img src="'.url.'/plantillas/imagenes/doh.png" alt="D\'oh!" />
							</p>
						';
					}
				}
				elseif($resultado = estas_en('zona')){
					if(existe('zona', $resultado[1])){
						echo '<h4 class="centrado">'.str_replace(nombre." &raquo; ", "", titulo()).'</h4>
						';
						if(hay_locales("zona=".$resultado[1])){
							echo'<p class="derecha" style="display:block;overflow:hidden;margin:0px 4px;"><a href="'.url.'/plantillas/mapa.php?zona='.$resultado[1].'" id="ver-mapa" title="Mapa: '.str_replace(nombre." &raquo; ", "", titulo()).'" class="boton"><img src="'.url.'/plantillas/imagenes/mapa.png" />Mapa</a></p>
							<div id="mapa-locales"></div>
							';
						}
						mostrar_locales("zona=".$resultado[1], 10);
					}
					else{
						echo '
							<h4 class="centrado">ERROR: La zona a la que est&aacute;s intentando acceder no existe.</h4>
							<p class="centrado">
								<img src="'.url.'/plantillas/imagenes/doh.png" alt="D\'oh!" />
							</p>
						';
					}
				}
				elseif($resultado = estas_en('locales')){
					if(existe('zona', $resultado[1]) && existe('categoria', $resultado[2])){
						echo '<h4 class="centrado">'.str_replace(nombre." &raquo; ", "", titulo()).'</h4>
						';
						if(hay_locales("zona=".$resultado[1]."|categoria=".$resultado[2])){
							echo'<p class="derecha" style="display:block;overflow:hidden;margin:0px 4px;"><a href="'.url.'/plantillas/mapa.php?zona='.$resultado[1].'&amp;categoria='.$resultado[2].'" id="ver-mapa" title="Mapa: '.str_replace(nombre." &raquo; ", "", titulo()).'" class="boton"><img src="'.url.'/plantillas/imagenes/mapa.png" />Mapa</a></p>
							<div id="mapa-locales"></div>
							';
						}
						mostrar_locales("zona=".$resultado[1]."|categoria=".$resultado[2], 10);
					}
					else{
						echo '
							<h4 class="centrado">ERROR: La categor&iacute;a o la zona a la que has intentado acceder no existe.</h4>
							<p class="centrado">
								<img src="'.url.'/plantillas/imagenes/doh.png" alt="D\'oh!" />
							</p>
						';
					}
				}
				elseif($resultado = estas_en('tag')){
					if(existe('tag', $resultado[1]))
						mostrar_locales("tag=".$resultado[1], 10);
					else
						echo '
							<h4 class="centrado">Esta etiqueta no existe.</h4>
							<p class="centrado">
								<img src="'.url.'/plantillas/imagenes/doh.png" alt="D\'oh!" />
							</p>
							';
				}
			?>
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
			<?php
				obtener_lateral();
			?>
		</div>
<?php
	obtener_pie();
?>