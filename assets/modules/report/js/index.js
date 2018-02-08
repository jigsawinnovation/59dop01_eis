function openNav() {
    document.getElementById("mySidenav").style.width = "350px";
    document.getElementById("menu-navbar").style.marginLeft = "350px";
    document.getElementById("page-content").style.marginLeft = "350px";
}

function closeNav() {
    document.getElementById("menu-navbar").style.marginLeft = "0";
    document.getElementById("page-content").style.marginLeft= "0";
    document.getElementById("mySidenav").style.width = "0";

}

$('#summary').click(function(){
    $('#summary').addClass( "tab-active" );
    $('#table').removeClass("tab-active");
    $('#map').removeClass("tab-active");
});
$('#table').click(function(){
    $('#table').addClass( "tab-active" );
    $('#summary').removeClass("tab-active");
    $('#map').removeClass("tab-active");
});
$('#map').click(function(){
    $('#map').addClass( "tab-active" );
    $('#summary').removeClass("tab-active");
    $('#table').removeClass("tab-active");
});

function getDataArea(url){
  $.ajax({
    method: "GET",
    url: url,
    data: {}
  }).done(function( data ) {
      $('#loader_data_area').html(data);
  });
}

function getData(url){
      $('#mapTitle').hide();
      $('#report_data').html('');
      $.ajax({
        method: "GET",
        url: url,
        data: {}
      }).done(function( data ) {
          $('#report_data').html(data);
      });

}

function getMap(url){
      var body = document.body,
      html = document.documentElement;

      var height = Math.max( body.offsetHeight, html.clientHeight, html.offsetHeight );
      $('#report_data').html('');
      $("#report_data").append('<div id="show_map" style="height:'+height+'px; width:100%;"></div>');
      initialize();
      $('#mapTitle').show();
}

var map;
var all_markers = [];
var all_polygons = [];
var all_polygonMap = [];
var xml = [];
function initialize() {
      var myLatlng = new google.maps.LatLng(13.0934384,101.4286521);
      var myOptions = {
                    zoom: 6,
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
      }
      map = new google.maps.Map(document.getElementById("show_map"), myOptions);
      var obj_map_province = document.getElementsByName("map_province");
      for(i=0;i<obj_map_province.length;i++){
          map_id = obj_map_province[i].id;
          addlayerXML(document.getElementById(map_id));
      }

}

function addlayerXML(obj){
 var url = obj.value;
  if(!xml[url]){
      downloadUrl(url, function(data) {
        xml[url] = data;
        all_markers[url] = [];
        all_polygons[url] = Array();
        all_polygonMap[url] = Array();
          var markers = data.documentElement.getElementsByTagName("marker");

        for (var i = 0; i < markers.length; i++) {
          var latlng = new google.maps.LatLng(parseFloat(markers[i].getAttribute("lat")),
                      parseFloat(markers[i].getAttribute("lng")));
          var identify = markers[i].getAttribute("identify");
          all_markers[url][i] = createMarker(markers[i].getAttribute("name"), markers[i].getAttribute("identify"), markers[i].getAttribute("icon"), latlng,250,200);
          if(markers[i].getAttribute("shape")){
              var plarr = markers[i].getAttribute("shape").split(" ");
              //alert(plarr);
              for(var is=0;is<plarr.length;is++){
                var pll = plarr[is].split(',');
                //alert(pll);
                all_polygons[url][is] = new google.maps.LatLng(parseFloat(pll[1]), parseFloat(pll[0]));
              }
              //alert(markers[i].getAttribute("shape_color"));
              all_polygonMap[url] = new google.maps.Polygon({
                paths: all_polygons[url],
                strokeColor: '#DF780A',
                strokeOpacity: 0.8,
                strokeWeight: 0.7,
                fillColor: markers[i].getAttribute("shape_color"),
                fillOpacity: markers[i].getAttribute("shape_opacity")
              });

              //addpolygon(all_polygonMap[obj.name]);
              all_polygonMap[url].setMap(map);
              google.maps.event.addListener(all_polygonMap[url], 'click', function(event) {
                  if (infowindow) infowindow.close();
                  var str_html = '<div  id="show_info"/></div>';
                  infowindow = new google.maps.InfoWindow({content: str_html, position: latlng});
                  infowindow.open(map, all_polygonMap[url]);
                  var str_url = identify;
                  $.ajax({
                    method: "GET",
                    url: str_url,
                    data: {}
                  }).done(function( data ) {
                      $('#show_info').html(data);
                  });
              });
          }
         }
       });

        //markerClusterer = new MarkerClusterer(map, all_markers[url]);
  }else{
    if(obj.checked){
        addpoint(all_markers[url]);
        if(all_polygons[url].length>0){
          addpolygon(all_polygonMap[url]);
        }
        //all_polygonMap[obj.name].setMap(map);
    }else{
        removepoint(all_markers[url]);
        if(all_polygons[url].length>0){
          removepolygon(all_polygonMap[url]);
        }

    }
  }
}
