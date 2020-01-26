function initMap() {
	if($('#map_canvas').length){
		var mapCenter = $('#map_canvas').data('center').split(', ');

	    var map = new google.maps.Map(document.getElementById('map_canvas'), {
	      zoom: 8,
	      minZoom: 5,
	      maxZoom: 15,
	      mapTypeId: 'roadmap',
	      center: {
	      	lat: parseFloat(mapCenter[0]),
	      	lng: parseFloat(mapCenter[1])
	      },
	      // disableDefaultUI: true
	    });




	 	var mainMarker = new google.maps.Marker({
	      position: {
	      	lat: parseFloat(mapCenter[0]),
	      	lng: parseFloat(mapCenter[1])
	      },
	      map: map
	    });
	}
};