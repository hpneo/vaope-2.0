<?php
	obtener_cabecera();
	
	$busqueda = $_GET['s'];
	$criterio = $_GET['por'];
	
	$locales = buscar($criterio, $busqueda, 10);
?>
		<div id="cuerpo">
			<?php
				if($locales){
					echo '<h3 class="centrado">Resultados de la b&uacute;squeda: \''.$busqueda.'\'</h3>';
					$i=0;
					echo '<ul class="lista locales">';
					foreach($locales as $local){
						if($i%2==0)
							$alt = ' alt';
						echo '<li class="local'.$alt.'">
							<h4><a href="'.url.'/local/'.$local->nombre.'/">'.$local->titulo.'</a></h4>
							<p>Agregado por <a href="'.url.'/usuario/'.$local->autor->nick.'/">'.$local->autor->nick.'</a> en la categor&iacute;a <a href="'.url.'/categoria/'.$local->categoria->nombre.'/">'.$local->categoria->titulo.'</a></p>
							<div class="local_descripcion">
								'.$local->descripcion.'
							</div>
							<p><strong>Direcci&oacute;n: </strong>'.$local->direccion.', <a href="'.url.'/zona/'.$local->zona->nombre.'/">'.$local->zona->titulo.'</a></p>
						</li>';
						$i++;
					}
					echo '</ul>';
					echo getPaginationString("", count($locales), $_GET['p'], $limit = 10, $adjacents = 1, $pagestring = url."/buscar/?por=$criterio&s=$busqueda&p=");
				}
				else{
					echo '<h3 class="centrado">No existen locales con este criterio.</h3>';
				}
			?>
		</div>
<?php
	obtener_pie();
?>