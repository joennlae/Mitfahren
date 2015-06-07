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
  
<link rel="stylesheet" href="css/layouts/blog.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
            <a href="/olgbasel/"><h1 class="brand-title">Mitfahren?</h1></a>
            <h2 class="brand-tagline">Eine Platform für Autofahrer und das Klima</h2>
            </br>
        </div>
    </div>

    <div class="content pure-u-1 pure-u-md-3-4">
            <div style="  text-align: center;">
<?php

require_once ('configuration.php');
if(isset($_SESSION["username"])){

$eventId = $_POST["eventId"]; 
$driveWay = $_POST["driveWay"]; 
$meettimeHour = $_POST["meettimeHour"];
$meettimeMinute = $_POST["meettimeMinute"]; 
$description = $_POST["description"];
$starttimeHour = $_POST["starttimeHour"];
$starttimeMinute = $_POST["starttimeMinute"];
$coordX = $_POST["coordX"];
$coordY = $_POST["coordY"];
$space = $_POST["space"];
//echo "$eventId + $driveWay + $meettimeHour + $meettimeMinute + $description + $starttimeHour + $starttimeMinute + $coordX + $coordY";
if($meettimeHour==0 &&$meettimeMinute==0) 
    { 
    echo 'Abfahrtszeit um Mitternacht. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/newcar.php">Neu versuchen</a>'; 
    exit; 
    }
if($starttimeHour==0 &&$starttimeMinute==0) 
    { 
    echo 'Startzeit um Mitternacht. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/newcar.php">Neu versuchen</a>'; 
    exit; 
    }
if($coordX==null) 
    { 
    echo 'Besammlungsort vergessen. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/newcar.php">Neu versuchen</a>'; 
    exit; 
    }
if($space==null) 
    { 
    echo 'Sitzplätze vergessen. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/newcar.php">Neu versuchen</a>'; 
    exit; 
    } 
$username = $_SESSION['username'];

$result = mysqli_query($db_link,"SELECT id FROM login WHERE username LIKE '$username'"); 
if($result){
$row = mysqli_fetch_assoc($result);
$creatorId = $row['id']; 
}
else echo  "failed";
$meettime = $meettimeHour . $meettimeMinute;
$starttime = $starttimeHour . $starttimeMinute;
$eintrag = "INSERT INTO cars (eventId, driveWay, creatorId, coordX, coordY, meettime, starttime, description, space) VALUES ('$eventId', '$driveWay','$creatorId','$coordX','$coordY','$meettime','$starttime','$description','$space')"; 
$eintragen = mysqli_query($db_link,$eintrag); 
    if($eintragen == true) 
        { 
        echo 'Das Auto wurde erstellt. <br /> <br /><a class="pure-button button-new" href="'.$baseLink.'">Startseite</a>'; 
        } 
    else 
        { 
        echo 'Fehler beim Speichern des Autos. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/newcar.php">Neu versuchen</a>'; 
        } 
}
else echo 'Nicht eingeloggt. <br /> <br /><a class="pure-button button-new" href="'.$baseLink.'">Startseite</a>';
?>

        </div>
    </div>
</div>

</body>
</html>
