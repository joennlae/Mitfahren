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

<script src="http://maps.googleapis.com/maps/api/js">
</script>  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
var view = getUrlVars()["view"];
var events = getUrlVars()["events"];
var addStr = "";
if(view==1){
    addStr="?myview";
}
if(events>0){
    addStr='?events='+events;
}
$.when(request().done(google.maps.event.addDomListener(window, 'load', initialize)));
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
            } 
    }); 
}

function initialize()
{ 
    if(saver.value!=="no events"){
          for(i=0; i<saver.value.length;i++){
            eval("var mapProp" + saver.value[i][2]+" = {center: new google.maps.LatLng("+saver.value[i][0]+","+saver.value[i][1]+"),zoom:14,mapTypeId: google.maps.MapTypeId.ROADMAP,disableDefaultUI: true};");
            eval("var map"+saver.value[i][2]+" = new google.maps.Map(document.getElementById('googleMap"+saver.value[i][2]+"'),mapProp"+saver.value[i][2]+");");
            eval("var marker" + saver.value[i][2]+" = new google.maps.Marker({position: new google.maps.LatLng("+saver.value[i][0]+","+saver.value[i][1]+"),map: map"+saver.value[i][2]+",title: 'Besammlungsort #SWAG'});");
          }
    }
    else console.log("no cars to load");
  /*var mapProp = {
    center: new google.maps.LatLng(51.508742,-0.120850),
    zoom:15,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    disableDefaultUI: true
  };
  
  var map0 = new google.maps.Map(document.getElementById("googleMap0"),mapProp);
  var map1 = new google.maps.Map(document.getElementById("googleMap1"),mapProp2);
  var map2 = new google.maps.Map(document.getElementById("googleMap2"),mapProp3);
  var map3 = new google.maps.Map(document.getElementById("googleMap3"),mapProp4);*/
  console.log(saver.value);
  window_size = $(window).height();
  //alert(window_size);
  document.getElementById("layout").style.minHeight = window_size+'px';
}

//google.maps.event.addDomListener(window, 'load', initialize);
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
        <div style="text-align: right;">
            <?php
                    if(isset($_GET['view'])){
                        echo '<div class="posts">';
                        $dateNow = date("m/d/Y");
                    $dateNew = explode("/",$dateNow);
                    $dateDay = (int)$dateNew[1];
                    $dateMonth = (int)$dateNew[0];
                    $dateYear = (int)$dateNew[2];
                    $username = $_SESSION['username'];

                    $result = mysqli_query($db_link,"SELECT id FROM login WHERE username LIKE '$username'"); 
                    if($result){
                    $row = mysqli_fetch_assoc($result);
                    $creatorId = $row['id']; 
                    }
                    else echo  "failed";
                    $sql="SELECT login.vorname,login.nachname,cars.id,cars.driveWay,cars.starttime,cars.meettime,events.name,cars.space,cars.creatorId,cars.userId, cars.description, cars.names FROM cars JOIN login ON login.id=cars.creatorID JOIN events ON events.id=cars.eventId WHERE (events.dateYear>'$dateYear' OR (events.dateYear = '$dateYear' AND events.dateMonth > '$dateMonth') OR (events.dateYear = '$dateYear' AND events.dateMonth = '$dateMonth' AND events.dateDay >= '$dateDay')) AND (cars.creatorId = '$creatorId' OR cars.userId LIKE '%$creatorId%' ) ORDER BY events.dateYear ASC, events.dateMonth ASC, events.dateDay ASC";
                    $result = mysqli_query($db_link,$sql);
                    if($result){
                        while ($row = mysqli_fetch_assoc($result)) {
                            $vorname = $row["vorname"];
                            $nachname = $row["nachname"];
                            $id = $row["id"];
                            $driveWay = $row["driveWay"];
                            $starttime = $row["starttime"];
                            $meettime = $row["meettime"];
                            $name = $row["name"];
                            $space = $row["space"];
                            $description = $row["description"];
                            $creatorIdNew = $row["creatorId"];
                            $names = json_decode($row['names']);

                            if($driveWay==1) $driveWay="Hin";
                            else if($driveWay==2) $driveWay="Zurück";
                            else $driveWay="Hin und zurück";

                            $newstarttime = str_split($starttime,2);
                            $newmeettime = str_split($meettime,2);
                            $returnString ="";
                            if($creatorIdNew==$creatorId) $returnString = "Ich fahre";
                            else $returnString = "Ich fahre mit";
                            $namesString= "";

                            for($i=0;$i<count($names);$i++){
                                $namesString = $namesString.','.$names[$i];
                            }
                            $namesString = substr($namesString,1);


                                echo '<h1 class="content-subhead">'.$returnString.'</h1>';

                                echo '<table class="pure-table">
                                        <tbody>
                                          <tr class="pure-table-odd">
                                            <td>Fahrer</td>
                                            <td>'.$vorname.' '.$nachname.'</td>      
                                          </tr>
                                          <tr>
                                            <td>Fahrtrichtung</td>
                                            <td>'.$driveWay.'</td>        
                                          </tr>
                                          <tr class="pure-table-odd">
                                            <td>Abfahrszeit</td>
                                            <td>'.$newmeettime[0].':'.$newmeettime[1].'</td>        
                                          </tr>
                                          <tr>
                                            <td>Frühste Startzeit der im Auto mitfahrenden</td>
                                            <td>'.$newstarttime[0].':'.$newstarttime[1].'</td>        
                                          </tr>
                                          <tr class="pure-table-odd">
                                            <td>Plätze frei</td>
                                            <td>'.$space.'</td>        
                                          </tr>
                                          <tr>
                                            <td>Angemeldet</td>
                                            <td>'.$namesString.'</td>       
                                          </tr>
                                          <tr class="pure-table-odd">
                                            <td>Abfahrtsort</td>
                                            <td><div class="map" id="googleMap'.$id.'" style="width:500px;height:300px;"></div></td>        
                                          </tr>
                                          <tr>
                                            <td>Zusätzliche Infos</td>
                                            <td>'.$description.'</td>        
                                          </tr>
                                          </tbody>
                                        </table>';
                                        if($creatorIdNew==$creatorId){
                                        echo '<a class="pure-button button-new" style="margin:10px;"href="'.$baseLink.'/delCar.php?changeCarId='.$id.'">Ändern</a>';
                                        }
                                        else echo '<a class="pure-button button-new" style="margin:10px;"href="'.$baseLink.'/delCar.php?removeId='.$creatorId.'&removeCarID='.$id.'">Abmelden</a>';

                        }
                    }
                    else echo "failed to load car data! email admin";
                    }

                    else if(isset($_GET['events'])){
                    require_once('configuration.php');
                    $eventID = $_GET['events'];
                    $sql1="SELECT name FROM events WHERE id='$eventID'";
                    $result1 = mysqli_query($db_link,$sql1);
                    $row1=mysqli_fetch_assoc($result1); 

                    echo '<p style="float:left; font-style: italic;">Es werden nur Autos zum '.$row1["name"].' angezeigt.</p><a class="pure-button button-new" style="float:left;margin-left:5px;"href="'.$baseLink.'">Alle anzeigen</a>';
                    if(isset($_SESSION["username"]) && $_SESSION["admin"]==1){
                    echo '<a class="pure-button button-new" style="margin-right:10px;"href="'.$baseLink.'/newevent.php">Neuer Event Hinzufügen</a>';
                    }
                    if(isset($_SESSION["username"])){
                    echo '<a class="pure-button button-new" href="'.$baseLink.'/newcar.php">Neues Auto hinzufügen</a>';
                    }
                    
                    echo '<div class="posts">';
                
                    $dateNow = date("m/d/Y");
                    $dateNew = explode("/",$dateNow);
                    $dateDay = (int)$dateNew[1];
                    $dateMonth = (int)$dateNew[0];
                    $dateYear = (int)$dateNew[2];
                    
                    $sql="SELECT login.vorname,login.nachname,cars.id,cars.driveWay,cars.starttime,cars.meettime,events.name,cars.space FROM cars JOIN login ON login.id=cars.creatorID JOIN events ON events.id=cars.eventId WHERE (events.dateYear>'$dateYear' OR (events.dateYear = '$dateYear' AND events.dateMonth > '$dateMonth') OR (events.dateYear = '$dateYear' AND events.dateMonth = '$dateMonth' AND events.dateDay >= '$dateDay')) AND cars.eventId='$eventID' ORDER BY events.dateYear ASC, events.dateMonth ASC, events.dateDay ASC, cars.space DESC";
                    $result = mysqli_query($db_link,$sql);
                    if($result){
                        while ($row = mysqli_fetch_assoc($result)) {
                            $vorname = $row["vorname"];
                            $nachname = $row["nachname"];
                            $id = $row["id"];
                            $driveWay = $row["driveWay"];
                            $starttime = $row["starttime"];
                            $meettime = $row["meettime"];
                            $name = $row["name"];
                            $space = $row["space"];

                            if($driveWay==1) $driveWay="Hin";
                            else if($driveWay==2) $driveWay="Zurück";
                            else $driveWay="Hin und zurück";

                            $newstarttime = str_split($starttime,2);
                            $newmeettime = str_split($meettime,2);
                            $spaceButton= "";
                            if($space==="0") $spaceButton="button-space-red";
                            else $spaceButton="button-space";

                                echo '<h1 class="content-subhead"></h1>

                                <section class="post">
                                    <header class="post-header">
                                        <h2 class="post-title" href="'.$baseLink.'/cars.php?id='.$id.'">'.$vorname.' '.$nachname.'</h2>
                                        <div>
                                        <p class="post-meta">
                                        <a href="#" class="post-author"></a><a class="post-category post-category-design" href="#">'.$name.'</a> <a class="post-category post-category-pure"  >'.$driveWay.'</a>
                                        </p>
                                        </div>
                                    </header>

                                <div class="post-description">
                                        <div class="buttons">
                                        <a class="pure-button '.$spaceButton.'" href="'.$baseLink.'/cars.php?id='.$id.'">'.$space.' Plätze Frei</a>
                                        <a class="pure-button button-space" href="'.$baseLink.'/cars.php?id='.$id.'">'.$newstarttime[0].':'.$newstarttime[1].' Frühste Startzeit</a>
                                        <a class="pure-button button-space" href="'.$baseLink.'/cars.php?id='.$id.'">'.$newmeettime[0].':'.$newmeettime[1].' Besammlungszeit</a>
                                        </div>
                                        <div class="map" id="googleMap'.$id.'" style="width:300px;height:150px;"></div>
                                    </div>
                                </section>';
                        }
                    }
                    else echo "failed to load car data! email admin";
                    }
				    else{
                    require_once('configuration.php');
                    if(isset($_SESSION["username"]) && $_SESSION["admin"]==1){
                    echo '<a class="pure-button button-new" style="margin-right:10px;"href="'.$baseLink.'/newevent.php">Neuer Event Hinzufügen</a>';
                    }
                    if(isset($_SESSION["username"])){
                    echo '<a class="pure-button button-new" href="'.$baseLink.'/newcar.php">Neues Auto hinzufügen</a>';
                    }
                    
                    echo '<div class="posts">';
                
                    $dateNow = date("m/d/Y");
                    $dateNew = explode("/",$dateNow);
                    $dateDay = (int)$dateNew[1];
                    $dateMonth = (int)$dateNew[0];
                    $dateYear = (int)$dateNew[2];
                    $sql="SELECT login.vorname,login.nachname,cars.id,cars.driveWay,cars.starttime,cars.meettime,events.name,cars.space,cars.eventId FROM cars JOIN login ON login.id=cars.creatorID JOIN events ON events.id=cars.eventId WHERE events.dateYear>'$dateYear' OR (events.dateYear = '$dateYear' AND events.dateMonth > '$dateMonth') OR (events.dateYear = '$dateYear' AND events.dateMonth = '$dateMonth' AND events.dateDay >= '$dateDay') ORDER BY events.dateYear ASC, events.dateMonth ASC, events.dateDay ASC, cars.space DESC";
                    $result = mysqli_query($db_link,$sql);
                    if($result){
                        while ($row = mysqli_fetch_assoc($result)) {
                            $vorname = $row["vorname"];
                            $nachname = $row["nachname"];
                            $id = $row["id"];
                            $driveWay = $row["driveWay"];
                            $starttime = $row["starttime"];
                            $meettime = $row["meettime"];
                            $name = $row["name"];
                            $space = $row["space"];
                            $eventId = $row['eventId'];

                            if($driveWay==1) $driveWay="Hin";
                            else if($driveWay==2) $driveWay="Zurück";
                            else $driveWay="Hin und zurück";

                            $newstarttime = str_split($starttime,2);
                            $newmeettime = str_split($meettime,2);
                            if($space==="0") $spaceButton="button-space-red";
                            else $spaceButton="button-space";

                                echo '<h1 class="content-subhead"></h1>

                                <section class="post">
                                    <header class="post-header">
                                        <h2 class="post-title" href="'.$baseLink.'/cars.php?id='.$id.'">'.$vorname.' '.$nachname.'</h2>
                                        <div>
                                        <p class="post-meta">
                                        <a href="#" class="post-author"></a><a class="post-category post-category-design" href="'.$baseLink.'/index.php?events='.$eventId.'">'.$name.'</a> <a class="post-category post-category-pure"  >'.$driveWay.'</a>
                                        </p>
                                        </div>
                                    </header>

                                <div class="post-description">
                                        <div class="buttons">
                                        <a class="pure-button '.$spaceButton.'" href="'.$baseLink.'/cars.php?id='.$id.'">'.$space.' Plätze Frei</a>
                                        <a class="pure-button button-space" href="'.$baseLink.'/cars.php?id='.$id.'">'.$newstarttime[0].':'.$newstarttime[1].' Frühste Startzeit</a>
                                        <a class="pure-button button-space" href="'.$baseLink.'/cars.php?id='.$id.'">'.$newmeettime[0].':'.$newmeettime[1].' Besammlungszeit</a>
                                        </div>
                                        <div class="map" id="googleMap'.$id.'" style="width:300px;height:150px;"></div>
                                    </div>
                                </section>';
                        }
                    }
                    else echo "failed to load car data! email admin";
                    }
				?>
			</div>
                
        </div>
    </div>
</div>






</body>
</html>
