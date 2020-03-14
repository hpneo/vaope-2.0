<?php
	header('Content-Type: text/html; charset=utf-8');
	include_once("config.php");
	include_once("funciones.php");
	include_once("clases/class.feedrss.php");
	include_once("clases/class.db.php");
	include_once("clases/class.usuario.php");
	include_once("clases/class.categoria.php");
	include_once("clases/class.zona.php");
	include_once("clases/class.tag.php");
	include_once("clases/class.media.php");
	include_once("clases/class.local.php");
	include_once("clases/class.telefono.php");
	include_once("plantillas.php");
	
	$db = new DB();
	$feed = new FeedRSS();
	$feed->setLanguage('es');
	$feed->setAtomLink(url.$_SERVER['REQUEST_URI']);
	
	if($resultado = estas_en('feed')){
		$feed->setTitle('Vao Pe! » Últimos locales agregados en');
		$feed->setDescription('Lista de los últimos locales agregados en Vao Pe!');
		$feed->setLink(url);
		$feed->setAtomLink(url.'/feed/');
		
		$locales = new Local();
		$locales = $locales->info('ordenar=fecha');
	}
	if($resultado = estas_en('categoria_feed')){
		$categoria = new Categoria();
		$categoria = $categoria->info('nombre='.$resultado);
		
		if(!$categoria){
			$locales = null;
		}
		else{
			$locales = new Local();
			$locales = $locales->info('categoria='.$categoria->id.'|ordenar=fecha');
		}
		$feed->setTitle(nombre.' » Locales en la categoría '.html_entity_decode($categoria->titulo, ENT_QUOTES, 'utf-8'));
		$feed->setLink(url.'/categoria/'.$categoria->nombre);
		$feed->setDescription('Lista de los últimos locales agregados en la categoría '.html_entity_decode($categoria->titulo, ENT_QUOTES, 'utf-8'));
	}
	if($resultado = estas_en('zona_feed')){
		$zona = new Zona();
		$zona = $zona->info('nombre='.$resultado);
		
		if(!$zona){
			$locales = null;
		}
		else{
			$locales = new Local();
			$locales = $locales->info('zona='.$zona->id.'|ordenar=fecha');
		}
		$feed->setTitle(nombre.' » Locales en '.html_entity_decode($zona->titulo, ENT_QUOTES, 'utf-8'));
		$feed->setLink(url.'/zona/'.$zona->nombre);
		$feed->setDescription('Lista de los últimos locales agregados en '.html_entity_decode($zona->titulo, ENT_QUOTES, 'utf-8'));
	}
	if($resultado = estas_en('locales_feed')){
		$categoria = new Categoria();
		$categoria = $categoria->info('nombre='.$resultado[2]);
		
		$zona = new Zona();
		$zona = $zona->info('nombre='.$resultado[1]);
		
		if(!$zona || !$categoria){
			$locales = null;
		}
		else{
			$locales = new Local();
			$locales = $locales->info('zona='.$zona->id.'|categoria='.$categoria->id.'|ordenar=fecha');
		}
		
		$feed->setTitle(nombre.' » '.html_entity_decode($categoria->titulo, ENT_QUOTES, 'utf-8')).' en '.html_entity_decode($zona->titulo, ENT_QUOTES, 'utf-8');
		$feed->setLink(url.'/locales/'.$zona->nombre.'/categoria/'.$categoria->nombre);
		$feed->setDescription('Lista de los últimos locales agregados en '.html_entity_decode($zona->titulo, ENT_QUOTES, 'utf-8').' en la categoría '.html_entity_decode($categoria->titulo, ENT_QUOTES, 'utf-8'));
	}
	if($resultado = estas_en('tag_feed')){
		$tag = new Tag();
		$tag = $tag->infoTag('nombre='.$resultado);
		
		if(!$tag){
			$locales = null;
		}else{
			$locales = new Local();
			$locales = $locales->info('tag='.$tag->id.'|ordenar=fecha');
		}
		$feed->setTitle(nombre.' » Locales con el tag "'.html_entity_decode($tag->titulo, ENT_QUOTES, 'utf-8').'"');
		$feed->setLink(url.'/tag/'.$tag->nombre);
		$feed->setDescription('Lista de los últimos locales agregados con el tag "'.html_entity_decode($tag->titulo, ENT_QUOTES, 'utf-8')).'"';
	}
	//-------------------------------
	$feed->setImage($feed->title, url.'/plantillas/imagenes/logo_feed.png', $feed->link);
	if(is_null($locales)){
	}
	elseif(!is_array($locales)){
		$local = $locales;
		$descripcion = '
		<h2>Direcci&oacute;n: </h2>
		'.$local->direccion.', '.$local->zona->titulo.'
		<h2>Descripci&oacute;n: </h2>
		'.html_entity_decode($local->descripcion, ENT_QUOTES, 'utf-8');
		if($local->coordenadas[0]!="" && $local->coordenadas[1]!="")
		$descripcion .= '
		<h2>Mapa</h2>
		<img id="local_mapa" src="http://maps.google.com/staticmap?key='.gmaps_api_key.'&amp;center='.$local->coordenadas[0].','.$local->coordenadas[1].'&amp;zoom=16&amp;size=600x300&amp;markers='.$local->coordenadas[0].','.$local->coordenadas[1].'" />
		';
		$item = $feed->createNewItem();
		$item->setTitle(html_entity_decode($local->titulo, ENT_QUOTES, 'utf-8'));
		$item->setLink(url.'/local/'.$local->nombre);
		$item->setPubDate($local->fecha);
		$item->setDescription($descripcion);
		$item->setComments(url.'/local/'.$local->nombre.'#comentarios');
		$item->setCreator($local->autor->nick);
		$item->setCategory(html_entity_decode($local->categoria->titulo, ENT_QUOTES, 'utf-8'));
		
		$feed->addItem($item);
	}
	else{
		foreach($locales as $local){
			$descripcion = '
			<h2>Direcci&oacute;n: </h2>
			'.$local->direccion.', '.$local->zona->titulo.'
			<h2>Descripci&oacute;n: </h2>
			'.html_entity_decode($local->descripcion, ENT_QUOTES, 'utf-8');
			if($local->coordenadas[0]!="" && $local->coordenadas[1]!="")
			$descripcion .= '
			<h2>Mapa</h2>
			<img id="local_mapa" src="http://maps.google.com/staticmap?key='.gmaps_api_key.'&amp;center='.$local->coordenadas[0].','.$local->coordenadas[1].'&amp;zoom=16&amp;size=600x300&amp;markers='.$local->coordenadas[0].','.$local->coordenadas[1].'" />
			';
			$item = $feed->createNewItem();
			$item->setTitle(html_entity_decode($local->titulo, ENT_QUOTES, 'utf-8'));
			$item->setLink(url.'/local/'.$local->nombre);
			$item->setPubDate($local->fecha);
			$item->setDescription($descripcion);
			$item->setComments(url.'/local/'.$local->nombre.'#comentarios');
			$item->setCreator($local->autor->nick);
			$item->setCategory(html_entity_decode($local->categoria->titulo, ENT_QUOTES, 'utf-8'));
			
			$feed->addItem($item);
		}
	}
	$feed->generateFeed();
?>