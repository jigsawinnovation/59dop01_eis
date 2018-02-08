var xml = [];
var infowindow;

function addpoint(parr){
		for (var i = 0; i < parr.length; i++) {
			 parr[i].setMap(map);
		}
 }

 function addpolygon(poly){
		poly.setMap(map);
		//Add the click listener
		console.log("poly");
		google.maps.event.addListener(poly, 'click', function(event) {
          console.log(event);
    });
 }

 function removepoint(parr){
		for (var i = 0; i < parr.length; i++) {
			parr[i].setMap(null);
		}
 }

 function removepolygon(poly){
		poly.setMap(null);
 }

 function createMarker(name, identify, icon, latlng, width, height) {
	 	var width = (width)?width:250;
	 	var height = (height)?height:200;
    var marker = new google.maps.Marker({position: latlng, icon:icon, title:name, map: map});
		var str_html = '<div  id="show_info"/></div>';
    google.maps.event.addListener(marker, "click", function() {
      if (infowindow) infowindow.close();
      infowindow = new google.maps.InfoWindow({content: str_html});
      infowindow.open(map, marker);
			$.ajax({
        method: "GET",
        url: identify,
        data: {}
      }).done(function( data ) {
          $('#show_info').html(data);
      });

    });
    return marker;
  }
