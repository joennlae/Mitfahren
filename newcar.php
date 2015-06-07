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
}

google.maps.event.addDomListener(window, 'load', initialize);

function updateContent(){
	document.getElementById("coordX").value = coords.lat;
	document.getElementById("coordY").value = coords.lng;
}
</script>
<script>
$('document').ready(function(){
    window_size = $(window).height();
  //alert(window_size);
    document.getElementById("layout").style.minHeight = window_size+'px';
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
				<form class="pure-form pure-form-aligned" action="newcarSend.php" method="post">
		<fieldset>
			<div class="pure-control-group">
			<label for="state">Wettkampf</label>
		        
		        	<?php
		        	require_once("configuration.php");
		        	$dateNow = date("m/d/Y");
		        	$dateNew = explode("/",$dateNow);
					$dateDay = (int)$dateNew[1];
					$dateMonth = (int)$dateNew[0];
					$dateYear = (int)$dateNew[2];
		        	$sql="SELECT name,id FROM events WHERE dateYear>'$dateYear' OR (dateYear = '$dateYear' AND dateMonth > '$dateMonth') OR (dateYear = '$dateYear' AND dateMonth = '$dateMonth' AND dateDay >= '$dateDay') ORDER BY dateYear ASC, dateMonth ASC, dateDay ASC";
		        	$result = mysqli_query($db_link,$sql);
		        	if($result){
		        		echo '<select id="state" name="eventId">';
		        		while ($row = mysqli_fetch_assoc($result)) {
		        			$id = $row['id'];
		        			$name = $row['name'];
		        			echo '<option value="'.$id.'">'.$name.'</option>';
		        		}
		        		echo '</select>';
		        	}
		        	else echo "failed to load event data! email admin";
		        	/*<select id="state" name="eventId">
		            <option value="1">4. Nationaler</option>
		            <option value="2">SOM</option>
		            <option value="3">5. Staffel</option>
		            </select>*/
		            ?>
		        
		    </div>

			<div class="pure-control-group">
				<label for="state">Fahrrichtung</label>
		        <select id="state" name="driveWay">
		            <option value="1">Hin</option>
		            <option value="2">Zurück</option>
		            <option value="3">Hin und Zurück</option>
		        </select>
			</div>

			<div class="pure-control-group">
				<label for="state">Plätze</label>
		        <select id="state" name="space">
		            <option value="1">1</option>
		            <option value="2">2</option>
		            <option value="3">3</option>
		            <option value="4">4</option>
		            <option value="5">5</option>
		            <option value="6">6</option>
		            <option value="7">7</option>
		            <option value="8">8</option>
		            <option value="9">9</option>
		        </select>
			</div>

			<div class="pure-control-group">
				<label for="state">Abfahrtszeit</label>
		        <select id="state" name="meettimeHour">
		            <option value="00">00</option>
		            <option value="01">01</option>
		            <option value="02">02</option>
		            <option value="03">03</option>
		            <option value="04">04</option>
		            <option value="05">05</option>
		            <option value="06">06</option>
		            <option value="07">07</option>
		            <option value="08">08</option>
		            <option value="09">09</option>
		            <option value="10">10</option>
		            <option value="11">11</option>
		            <option value="12">12</option>
		            <option value="13">13</option>
		            <option value="14">14</option>
		            <option value="15">15</option>
		            <option value="16">16</option>
		            <option value="17">17</option>
		            <option value="18">18</option>
		            <option value="19">19</option>
		            <option value="20">20</option>
		            <option value="21">21</option>
		            <option value="22">22</option>
		            <option value="23">23</option>
		        </select>
		        <select id="state" name="meettimeMinute">
		            <option value="00">00</option>
		            <option value="05">05</option>
		            <option value="10">10</option>
		            <option value="15">15</option>
		            <option value="20">20</option>
		            <option value="25">25</option>
		            <option value="30">30</option>
		            <option value="35">35</option>
		            <option value="40">40</option>
		            <option value="45">45</option>
		            <option value="50">50</option>
		            <option value="55">55</option>
		        </select>
			</div>

			<div class="pure-control-group">
				<label for="name">Beschreibung</label>
				<textarea class="pure-input-1-2" id="description" placeholder="Zusätzliche Infos" name="description"></textarea>
			</div>
			<div class="pure-control-group">
				<label for="name">Besammlungsort</label>
				<input id="pac-input" class="controls" type="text" placeholder="Suechää">
				<div id="map"></div>
			</div>
			
			<div class="pure-control-group">
				<div class="pure-control-group">
				<label for="state">Startzeit</label>
		        <select id="state" name="starttimeHour">
		            <option value="00">00</option>
		            <option value="01">01</option>
		            <option value="02">02</option>
		            <option value="03">03</option>
		            <option value="04">04</option>
		            <option value="05">05</option>
		            <option value="06">06</option>
		            <option value="07">07</option>
		            <option value="08">08</option>
		            <option value="09">09</option>
		            <option value="10">10</option>
		            <option value="11">11</option>
		            <option value="12">12</option>
		            <option value="13">13</option>
		            <option value="14">14</option>
		            <option value="15">15</option>
		            <option value="16">16</option>
		            <option value="17">17</option>
		            <option value="18">18</option>
		            <option value="19">19</option>
		            <option value="20">20</option>
		            <option value="21">21</option>
		            <option value="22">22</option>
		            <option value="23">23</option>
		        </select>
		        <select id="state" name="starttimeMinute">
		            <option value="00">00</option>
		            <option value="01">01</option>
		            <option value="02">02</option>
		            <option value="03">03</option>
		            <option value="04">04</option>
		            <option value="05">05</option>
		            <option value="06">06</option>
		            <option value="07">07</option>
		            <option value="08">08</option>
		            <option value="09">09</option>
		            <option value="10">10</option>
		            <option value="11">11</option>
		            <option value="12">12</option>
		            <option value="13">13</option>
		            <option value="14">14</option>
		            <option value="15">15</option>
		            <option value="16">16</option>
		            <option value="17">17</option>
		            <option value="18">18</option>
		            <option value="19">19</option>
		            <option value="20">20</option>
		            <option value="21">21</option>
		            <option value="22">22</option>
		            <option value="23">23</option>
		            <option value="24">24</option>
		            <option value="25">25</option>
		            <option value="26">26</option>
		            <option value="27">27</option>
		            <option value="28">28</option>
		            <option value="29">29</option>
		            <option value="30">30</option>
		            <option value="31">31</option>
		            <option value="32">32</option>
		            <option value="33">33</option>
		            <option value="34">34</option>
		            <option value="35">35</option>
		            <option value="36">36</option>
		            <option value="37">37</option>
		            <option value="38">38</option>
		            <option value="39">39</option>
		            <option value="40">40</option>
		            <option value="41">41</option>
		            <option value="42">42</option>
		            <option value="43">43</option>
		            <option value="44">44</option>
		            <option value="45">45</option>
		            <option value="46">46</option>
		            <option value="47">47</option>
		            <option value="48">48</option>
		            <option value="49">49</option>
		            <option value="50">50</option>
		            <option value="51">55</option>
		            <option value="52">52</option>
		            <option value="53">53</option>
		            <option value="54">54</option>
		            <option value="55">55</option>
		            <option value="56">56</option>
		            <option value="57">57</option>
		            <option value="58">58</option>
		            <option value="59">59</option>
		        </select>
			</div>
			</div>
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
