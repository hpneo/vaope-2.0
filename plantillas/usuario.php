<?php
	obtener_cabecera();
	$nick = estas_en('usuario');
	$usuario = new Usuario();
	$usuario = $usuario->info('nick='.urldecode($nick[1]));
	switch($usuario->n_favoritos){
		case '0':
			$n_favoritos = 'No tiene locales favoritos.';
		break;
		case '1':
			$n_favoritos = 'Tiene un local favorito.';
		break;
		default:
			$n_favoritos = 'Tiene '.$usuario->n_favoritos.' locales favoritos.';
		break;
	}
?>
		<div id="cuerpo">
			<div id="barra">
            	<h3 class="centrado"><?php echo $usuario->nick; ?></h3>
            	<p class="centrado"><?php avatar($usuario->email, 80); ?></p>
                <ul class="lista">
					<li><em><?php echo $usuario->descripcion; ?></em></li>
					<?php if($usuario->url!=""): ?>
                    <li><strong>Sitio web:</strong> <?php echo '<a href="'.$usuario->url.'" title="Sitio web de '.$usuario->nick.'">'.$usuario->url.'</a>'; ?></li>
					<?php endif; ?>
                    <li><strong>Locales favoritos:</strong> <?php echo '<a href="'.url.'/usuario/'.$usuario->nick.'/favoritos/">'.$n_favoritos.'</a>'; ?></li>
                </ul>
            </div>
            <div id="contenido">
            	<?php
				$seccion = estas_en('usuario');
				if($seccion[2]!="favoritos"):
				?>
            	<h3 class="centrado">&Uacute;ltimos locales agregados por <?php echo $usuario->nick; ?></h3>
            	<?php
					if(es_autor($usuario->id))
	                	$usuario->listar_locales(true);
					else
						$usuario->listar_locales();
				?>
				<?php else: ?>
				<h3 class="centrado">Locales favoritos de <?php echo $usuario->nick; ?></h3>
				<?php
					$favoritos = $usuario->listar_favoritos();
					if($favoritos){
						echo '<ul class="lista locales">';
						$i=0;
						foreach($favoritos as $favorito){
							if($i%2==0)
								$clase="alt";
							echo '
							<li class="local '.$clase.'">
								<h4><a href="'.url.'/local/'.$favorito->nombre.'/">'.$favorito->titulo.'</a></h4>
								<p>Queda en <strong>'.$favorito->direccion.'</strong>, <strong><a href="'.url.'/zona/'.$favorito->zona->nombre.'/" title="'.$favorito->zona->titulo.'">'.$favorito->zona->titulo.'</a></strong></p>
							</li>';
							$i++;
						}
						echo '</ul>';
					}
				?>
				<?php endif; ?>
            </div>
		</div>
<?php
	obtener_pie();
?>