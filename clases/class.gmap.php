<?php
	class GMap{
		public $api_key;
		public $div = array('id', 'width', 'height');
		public $markers;
		public $center = array('lat','long');
		public $zoom;
		private $n_markers = 0;
		
		function GMap($api_key, $div){
			$this->api_key = $api_key;
			$this->div = $div;
		}
		function print_header(){
			echo '<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='.$this->api_key.'" type="text/javascript"></script>';
		}
		function center_map($address=NULL){
			return 'map.setCenter(new GLatLng('.$this->center['lat'].','.$this->center['long'].'), '.$this->zoom.');
			';
		}
		function add_marker($lat, $long, $icon, $title, $html=NULL, $draggable, $return_to=NULL){
			$this->markers[$this->n_markers]['lat'] = $lat;
			$this->markers[$this->n_markers]['long'] = $long;
			$this->markers[$this->n_markers]['icon'] = $icon;
			$this->markers[$this->n_markers]['title'] = $title;
			$this->markers[$this->n_markers]['content'] = $html;
			$this->markers[$this->n_markers]['draggable'] = $draggable;
			$this->markers[$this->n_markers]['return'] = $return_to;
			$this->n_markers++;
		}
		function print_markers(){
			if(sizeof($this->markers!="")){
				for($i=0;$i<sizeof($this->markers);$i++){
					if($this->markers[$i]['icon']!=""){
						$marcadores .= '
							var icon'.$i.' = new GIcon(G_DEFAULT_ICON);
							icon'.$i.'.image = "'.$this->markers[$i]['icon'].'";
							icon'.$i.'.iconSize = new GSize(16, 28);
						';
						$icon = 'icon: icon'.$i.', ';
					}
					if($this->markers[$i]['title']!=""){
						$title = 'title:"'.$this->markers[$i]['title'].'", ';
					}
					if($this->markers[$i]['content']!=""){
						$content = '
						GEvent.addListener(marker'.$i.', "click", function(){
							marker'.$i.'.openInfoWindow("'.$this->markers[$i]['content'].'");
						});';
					}
					if($this->markers[$i]['draggable']){
						$draggable = 'draggable: true, ';
					}
					else{
						$draggable = 'draggable: false, ';
					}
					if($this->markers[$i]['return']!=""){
						$return = '
						GEvent.addListener(marker'.$i.', "dragend", function(){
							document.getElementById("'.$this->markers[$i]['return'].'").value = marker'.$i.'.getLatLng();
						});
						';
					}
					$marcadores .= '
							var marker'.$i.' = new GMarker(new GLatLng('.$this->markers[$i]['lat'].','.$this->markers[$i]['long'].'), {'.$icon.$title.$draggable.'autoPan:false});
							'.$content.'
							'.$return.'
							map.addOverlay(marker'.$i.');';
				}
			}
			return $marcadores;
		}
		function print_map_geocoded($address){
			echo '
			<div id="'.$this->div['id'].'" style="width:'.$this->div['width'].';height:'.$this->div['height'].';"></div>
			<script type="text/javascript">
				function print_map(){
					if (GBrowserIsCompatible()) {
						var map = new GMap2(document.getElementById("'.$this->div['id'].'"));
						map.addControl(new GLargeMapControl());
						var geocoder = new GClientGeocoder();
						map.setCenter(geocoder.getLatLng("'.$address.'", function(point) {
						map.setCenter(point, '.$this->zoom.');
						var marker = new GMarker(point, {draggable: true});
						document.getElementById("zona_coordenadas").value = marker.getLatLng();
						GEvent.addListener(marker, "dragend", function(){
							document.getElementById("zona_coordenadas").value = marker.getLatLng();
						});
						map.addOverlay(marker);
						'.$this->print_markers().'
   						}), '.$this->zoom.');
					}
				}
				print_map();
			</script>
			';
		}
		function print_map(){
			echo '
			<div id="'.$this->div['id'].'" style="width:'.$this->div['width'].';height:'.$this->div['height'].';"></div>
			<script type="text/javascript">
				function print_map(){
					if (GBrowserIsCompatible()) {
						var map = new GMap2(document.getElementById("'.$this->div['id'].'"));
						map.addControl(new GLargeMapControl());
						'.$this->center_map().'
						'.$this->print_markers().'
					}
				}
				print_map();
			</script>
			';
		}
	}
?>