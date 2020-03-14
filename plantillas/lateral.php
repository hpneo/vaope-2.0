		<div id="barra">
		<?php
			if($resultado = estas_en('categoria')){
				$categoria = new Categoria();
				$categoria = $categoria->info('nombre='.$resultado[1]);
				if($categoria){
					echo '<h2 id="titulo-zonas-1">Locales de la categor&iacute;a '.$categoria->titulo.' en...</h2>';
					listar_zonas("lista-zonas-1", "", $resultado[1]);
				}
			}
			elseif($resultado = estas_en('zona')){
				$zona = new Zona();
				$zona = $zona->info('nombre='.$resultado[1]);
				if($zona){
					echo '<h2 id="titulo-categorias-1">Locales en '.$zona->titulo.' de la categor&iacute;a...</h2>';
					listar_categorias("lista-categorias-1", "", $resultado[1]);
				}
			}
			elseif($resultado = estas_en('locales')){
				$categoria = new Categoria();
				$categoria = $categoria->info('nombre='.$resultado[2]);
				if($categoria){
					echo '<h2 id="titulo-zonas-1">Locales de la categor&iacute;a '.$categoria->titulo.' en...</h2>';
					listar_zonas("lista-zonas-1", "", $resultado[2]);
				}
				$zona = new Zona();
				$zona = $zona->info('nombre='.$resultado[1]);
				if($zona){
					echo '<h2 id="titulo-categorias-1">Locales en '.$zona->titulo.' de la categor&iacute;a...</h2>';
					listar_categorias("lista-categorias-1", "", $resultado[1]);
				}
			}
		?>
		</div>