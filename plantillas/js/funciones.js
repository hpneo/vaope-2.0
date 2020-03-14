/**
 * @author HPNeo
**/
function crear_marcador(punto){
	var marker = new GMarker(punto, {draggable: false});
	GEvent.addListener(marker, "click", function(){
		//marker.openInfoWindow(contenido+marker.getLatLng());
	});
	return marker;
}