<?php
	obtener_cabecera();
?>
		<div id="cuerpo">
			<?php obtener_lateral(); ?>
			<div id="contenido">
				<?php
					$seccion = $_GET['seccion'];
					switch($seccion){
						case 'pagina':
							include("pagina.php");
						break;
						case 'categoria':
							include("categoria.php");
						break;
						case 'zona':
							include("zona.php");
						break;
						default:
							include("inicio.php");
						break;
					}
				?>
			</div>
		</div>
<?php
	obtener_pie();
?>