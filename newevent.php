<?php 
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 'on');

?> 
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
<title>OLG Basel &ndash; Autoapp</title>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
  
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 <script src="http://maps.googleapis.com/maps/api/js?libraries=places">
</script>  
<link rel="stylesheet" href="css/layouts/blog.css">
<style>
#map{
    display: inline-block;
    width: 400px;
    height: 300px;
    top: 0;
    bottom: 0;
}
</style>
<script>
/*function initialize(){
var myOptions = {
    zoom: 11,
    center: new google.maps.LatLng(36.236797,-112.956333),
    zoomControl: true,
    zoomControlOptions: {
      style: google.maps.ZoomControlStyle.MEDIUM
    },
    mapTypeId: 'terrain',
    draggableCursor:'crosshair',
    draggingCursor: 'move'
}
var map = new google.maps.Map(document.getElementById("map"),myOptions);

var marker;

function placeMarker(location) {
  if ( marker ) {
    marker.setPosition(location);
  } else {
    marker = new google.maps.Marker({
      position: location,
      map: map
    });
  }
}

google.maps.event.addListener(map, 'click', function(event) {
  placeMarker(event.latLng);
});
}*/
var coords = {lat: 0, lng: 0};
function initialize() {

  var markers = [];
  var map = new google.maps.Map(document.getElementById('map'), {
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    zoom:7
  });

  var defaultBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(47.524156, 7.527695),
      new google.maps.LatLng(47.586021, 7.680473));
  map.fitBounds(defaultBounds);

  // Create the search box and link it to the UI element.
  var input = /** @type {HTMLInputElement} */(
      document.getElementById('pac-input'));
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  var searchBox = new google.maps.places.SearchBox(
    /** @type {HTMLInputElement} */(input));

  // [START region_getplaces]
  // Listen for the event fired when the user selects an item from the
  // pick list. Retrieve the matching places for that item.
  google.maps.event.addListener(searchBox, 'places_changed', function() {
    var places = searchBox.getPlaces();
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0, place; place = places[i]; i++) {
    	//bounds.extend(place.geometry.location);
    	boundsAusgelsenLaT=place.geometry.location["A"];
    	boundsAusgelsenLng=place.geometry.location["F"];
    	bounds.extend(new google.maps.LatLng(boundsAusgelsenLaT+0.005, boundsAusgelsenLng+0.005));
    	bounds.extend(new google.maps.LatLng(boundsAusgelsenLaT-0.005, boundsAusgelsenLng-0.005));
    	console.log(place.geometry.location);
    	console.log(bounds);
    }
    map.fitBounds(bounds);
    /*if (places.length == 0) {
      return;
    }
    for (var i = 0, marker; marker = markers[i]; i++) {
      marker.setMap(null);
    }

    // For each place, get the icon, place name, and location.
    markers = [];
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0, place; place = places[i]; i++) {
      var image = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      var marker = new google.maps.Marker({
        map: map,
        icon: image,
        title: place.name,
        position: place.geometry.location
      });

      markers.push(marker);

      bounds.extend(place.geometry.location);
    }

    map.fitBounds(bounds);*/
  });
  // [END region_getplaces]

  // Bias the SearchBox results towards places that are within the bounds of the
  // current map's viewport.
  google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();
    searchBox.setBounds(bounds);
  });
  var marker;

function placeMarker(location) {
  if ( marker ) {
    marker.setPosition(location);
  } else {
    marker = new google.maps.Marker({
      position: location,
      map: map
    });
  }
}

google.maps.event.addListener(map, 'click', function(event) {
  placeMarker(event.latLng);
    coords.lat = marker.getPosition().lat();
	coords.lng = marker.getPosition().lng();
	console.log(coords.lat);
	console.log(coords.lng);
	updateContent();
});
  function setHeight(){
    window_size = $(window).height();
  //alert(window_size);
    document.getElementById("layout").style.minHeight = window_size+'px';
  }
  setHeight();
}

google.maps.event.addDomListener(window, 'load', initialize);

function updateContent(){
	document.getElementById("coordX").value = coords.lat;
	document.getElementById("coordY").value = coords.lng;
}

</script>
 <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });


</script>
</head>
<body>

<div id="layout" class="pure-g">
    <div class="sidebar pure-u-1 pure-u-md-1-4">
        <div class="header">
            <a href="/olgbasel"><h1 class="brand-title">Mitfahren</h1></a>
            <h2 class="brand-tagline">Eine Platform für Autofahrer und das Klima</h2>
			</br>
        </div>
    </div>

    <div class="content pure-u-1 pure-u-md-3-4">
			<div style="  text-align: left;">
				<form class="pure-form pure-form-aligned" action="neweventSend.php" method="post">
		<fieldset>
			<div class="pure-control-group">
			<label for="name">Name</label>
			<input id="name" type="text" placeholder="Wettkampfname" name="name">
		    </div>

			<div class="pure-control-group">
				<label for="name">Ort</label>
				<input id="name" type="text" placeholder="Ort" name="place">
			</div>

			<div class="pure-control-group">
				<label for="state">Datum</label>
				<input type="text" id="datepicker" name="date">
			</div>

			<div class="pure-control-group">
				<label for="name">Beschreibung</label>
				<textarea class="pure-input-1-2" id="description" placeholder="Zusätzliche Infos z.B.:Ausschreibungs-Link usw." name="description"></textarea>
			</div>
			<div class="pure-control-group">
				<label for="name">Wettkampfort</label>
				<input id="pac-input" class="controls" type="text" placeholder="Suechää">
				<div id="map"></div>
			</div>
			
			<!--<div class="pure-control-group">
				<div class="pure-control-group">
				<label for="state">Startzeit</label>

			</div>
			</div>-->
			<input id="coordX" name="coordX" type="hidden" value=""></input>
			<input id="coordY" name="coordY" type="hidden" value=""></input>
			<div class="pure-controls">
				<button type="submit" class="pure-button pure-button-primary">Submit</button>
			</div>
			</fieldset>
			</form>
			
        </div>
    </div>
</div>

</body>
</html>
