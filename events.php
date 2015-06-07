<?php 
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 'on');
?> 

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="A layout example that shows off a blog page with a list of posts.">

    <title>OLG Basel &ndash; Autoapp</title>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 <script src="http://maps.googleapis.com/maps/api/js?libraries=places">
</script>  
<style>
#map{
    display: inline-block;
    width: 400px;
    height: 300px;
    top: 0;
    bottom: 0;
}
</style>
<script id="source" language="javascript" type="text/javascript">
function getUrlVars() {
var vars = {};
var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
vars[key] = value;
});
return vars;
}
var saver = {value: ''};
var rest = {value: 0};
var events = getUrlVars()["id"];
var addStr = "";
if(events!==undefined){
if(events>0){
    addStr='?event='+events;
    $.when(request().done(google.maps.event.addDomListener(window, 'load', initialize)));
}
}

function request(){
    return $.ajax({
        async: false,                                      
        url: 'fetch_coords.php'+addStr,                      
        data: "",                                                   
        dataType: 'json',                     
        success: function(data)          
            {
                saver.value = data;
                console.log('ausgeführt le save');
                console.log(saver.value);
            } 
    }); 
}
var coords = {lat: 0, lng: 0};
function initialize() {

  var markers = [];
  var map = new google.maps.Map(document.getElementById('map'), {
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    center : new google.maps.LatLng(saver.value[0][0],saver.value[0][1]),
    zoom:12
  });

  var marker = new google.maps.Marker({
        map: map,
        position: new google.maps.LatLng(saver.value[0][0],saver.value[0][1])
      });
  /*var defaultBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng((saver.value[0][0]+0.05), (saver.value[0][1]+0.05),
      new google.maps.LatLng((saver.value[0][0]-0.05), (saver.value[0][1]-0.05)));
  map.fitBounds(defaultBounds);*/

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
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
  
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-min.css">
  
<link rel="stylesheet" href="css/layouts/blog.css">
</head>
<body>

<div id="layout" class="pure-g">
    <div class="sidebar pure-u-1 pure-u-md-1-4">
        <div class="header">
            <?php 
            require_once('configuration.php');
            echo '<a href="'.$baseLink.'/"><h1 class="brand-title">Mitfahren</h1></a>';
            ?>
            <!--<a href="/olgbasel/"><h1 class="brand-title">Mitfahren?</h1></a>-->
            <h2 class="brand-tagline">Eine Platform für Autofahrer und das Klima</h2>

            <nav class="nav">
                <ul class="nav-list">
                    <!--<li class="nav-item">
                        <a class="pure-button" href="/login">Anmelden</a>
                    </li>-->
                    <?php
                    require_once("configuration.php");
                    if(!isset($_SESSION['username'])){
                    echo <<<END
                    <li class="nav-item">
                        <a class="pure-button" href="register.html">Registrieren</a>
                    </li>
END;
                    }
                    else{
                        echo "<br /><br /><li class='nav-item'><a class='pure-button' href='".$baseLink."'>Dashboard</a></li>";
                        echo '<br /><li class="nav-item"><a class="pure-button" href="'.$baseLink.'/index.php?view=1">Meine Übersicht</a></li>';
                        if($_SESSION['admin']===1){
                            echo '<br /><li class="nav-item"><a class="pure-button" href="'.$baseLink.'/events.php">Wettkämpfe</a></li>'; 
                        }
                        echo "<br /><br />Eingeloggt als: ".$_SESSION["username"];
                    }
                    ?>
                </ul>
            </nav>
			</br>
            <?php 
            if(isset($_POST["auth_submit"])){
                $username = $_POST["username"]; 
                $password = $_POST["password"]; 
                require_once ('configuration.php');

                $ergebnis = mysqli_query($db_link,"SELECT username, password FROM login WHERE username LIKE '$username' LIMIT 1"); 
                $row=mysqli_fetch_assoc($ergebnis); 
                if($row['password'] == $password) 
                    { 
                    $_SESSION['username'] = $username;
                    $_SESSION['admin'] = 0;
                    for($i = 0; $i <count($admins); $i++){
                        if($username===$admins[$i]) $_SESSION["admin"] = 1;
                    }
                    $_SESSION['err'] = false;
                    header('Location:'.$_SERVER['PHP_SELF']);
                    die;
                    } 
                else 
                    {  
                    header('Location:'.$_SERVER['PHP_SELF']);
                    $_SESSION['err'] = true;
                    die;
                    } 
            }
            else if(!isset($_SESSION["username"])){
            if(isset($_SESSION['err'])){    
            if($_SESSION['err'] == true){
                echo "Benutzername und/oder Passwort falsch.\n";
                $_SESSION['err'] = false;
            }
            }
            echo <<<END
			<form class="pure-form pure-form-stacked" style="display: inline-block; color: black;" action="index.php" method="post">
					<label for="name"></label>
					<input id="name" type="text" placeholder="Username" name="username">

					<label for="password"></label>
					<input id="password" type="password" placeholder="Password" name="password">

					<button type="submit" class="pure-button pure-button-primary" name="auth_submit">Sign in</button>
			</form>
END;

            }
            else if(isset($_POST["log_out"])){
                $_SESSION = array();
                session_destroy();
                header('Location:'.$_SERVER['PHP_SELF']);
                die;
            }
            else{
            echo <<<END
            <form class="pure-form pure-form-stacked" style="display: inline-block; color: black;" action="index.php" method="post">
                    <button type="submit" class="pure-button pure-button-primary" name="log_out">Log out</button>
            </form>
END;
            }
?>
			
        </div>
    </div>

    <div class="content pure-u-1 pure-u-md-3-4">
        <div style="text-align: left;">
            <?php
                    if(isset($_GET['id'])){
                        echo '<div class="posts" style="float:left;">';
                        $dateNow = date("m/d/Y");
                    $dateNew = explode("/",$dateNow);
                    $dateDay = (int)$dateNew[1];
                    $dateMonth = (int)$dateNew[0];
                    $dateYear = (int)$dateNew[2];
                    $id = $_GET['id'];
                    echo '<h1 class="content-subhead">Wettkampf Bearbeiten</h1>';
                    $sql="SELECT * FROM events WHERE (events.dateYear>'$dateYear' OR (events.dateYear = '$dateYear' AND events.dateMonth > '$dateMonth') OR (events.dateYear = '$dateYear' AND events.dateMonth = '$dateMonth' AND events.dateDay >= '$dateDay')) AND ( id='$id') ORDER BY events.dateYear ASC, events.dateMonth ASC, events.dateDay ASC";
                    $result = mysqli_query($db_link,$sql);
                    if($result){
                        while ($row = mysqli_fetch_assoc($result)) {
                            $place= $row["place"];
                            $dateDay = $row["dateDay"];
                            $dateMonth= $row["dateMonth"];
                            $dateYear = $row["dateYear"];
                            $description = $row["description"];
                            $name = $row["name"];
                            $date = $dateMonth."/".$dateDay."/".$dateYear;

                            echo '
                                        <form class="pure-form pure-form-aligned" action="eventAdjustedSend.php" method="post">
                                        <fieldset>
                                            <div class="pure-control-group">
                                            <label for="name">Name</label>
                                            <input id="name" type="text" placeholder="Wettkampfname" name="name" value="'.$name.'">
                                            </div>

                                            <div class="pure-control-group">
                                                <label for="name">Ort</label>
                                                <input id="name" type="text" placeholder="Ort" name="place" value="'.$place.'">
                                            </div>

                                            <div class="pure-control-group">
                                                <label for="state">Datum</label>
                                                <input type="text" id="datepicker" name="date" value="'.$date.'">
                                            </div>

                                            <div class="pure-control-group">
                                                <label for="name">Beschreibung</label>
                                                <input class="pure-input-1-2" id="description" placeholder="Zusätzliche Infos z.B.:Ausschreibungs-Link usw." name="description" value="'.$description.'"></input>
                                            </div>
                                            <div class="pure-control-group">
                                                <label for="name">Wettkampfort</label>
                                                <input id="pac-input" class="controls" type="text" placeholder="Suechää">
                                                <div id="map"></div>
                                            </div>
                                            
                                            <input id="coordX" name="coordX" type="hidden" value=""></input>
                                            <input id="coordY" name="coordY" type="hidden" value=""></input>
                                            <input id="id" name="id" type="hidden" value="'.$id.'"></input>
                                            <div class="pure-controls">
                                                <button type="submit" class="pure-button pure-button-primary">Ändern</button>
                                            </div>
                                            </fieldset>
                                            </form>';
                                            echo '<a class="pure-button button-new" style="margin:10px;"href="'.$baseLink.'/eventAdjustedSend.php?id='.$id.'&del=1">Löschen</a>';
                                  

                        }
                    }
                    else echo "failed to load car data! email admin";
                    }

				    else{
                    require_once('configuration.php');
                    if(isset($_SESSION["username"]) && $_SESSION["admin"]==1){
                    
                    echo '<div class="posts">';
                    echo '<h1 class="content-subhead"></h1>';
                    echo '<table class="pure-table">
                                        <tbody>';
                    $dateNow = date("m/d/Y");
                    $dateNew = explode("/",$dateNow);
                    $dateDay = (int)$dateNew[1];
                    $dateMonth = (int)$dateNew[0];
                    $dateYear = (int)$dateNew[2];
                    $sql="SELECT * FROM events WHERE events.dateYear>'$dateYear' OR (events.dateYear = '$dateYear' AND events.dateMonth > '$dateMonth') OR (events.dateYear = '$dateYear' AND events.dateMonth = '$dateMonth' AND events.dateDay >= '$dateDay') ORDER BY events.dateYear ASC, events.dateMonth ASC, events.dateDay ASC";
                    $result = mysqli_query($db_link,$sql);
                    if($result){
                        while ($row = mysqli_fetch_assoc($result)) {
                            $place= $row["place"];
                            $dateDay = $row["dateDay"];
                            $id = $row["id"];
                            $dateMonth= $row["dateMonth"];
                            $dateYear = $row["dateYear"];
                            $description = $row["description"];
                            $name = $row["name"];

                            $date = $dateDay.".".$dateMonth.".".$dateYear;
                            $description = str_split($description,50);
                            $description[0]=$description[0]."...";
                                    echo '
                                        <tr class="pure-table-odd">
                                            <td>'.$name.'</td>
                                            <td>'.$place.'</td>
                                            <td>'.$description[0].'</td>  
                                            <td>'.$date.'</td>  
                                            <td><a class="pure-button button-new" style="margin:1px;"href="'.$baseLink.'/events.php?id='.$id.'">Bearbeiten/Löschen</a></td>        
                                          </tr>';
                                 
                            }
                        }
                        echo'         </tbody>
                                        </table>';
                    }
                    else echo "Keine Rechte";
                    }
				?>
			</div>
                
        </div>
    </div>
</div>






</body>
</html>
