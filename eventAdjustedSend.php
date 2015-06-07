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
if(isset($_SESSION["username"]) && $_SESSION["admin"]==1){
    if(isset($_GET['del'])){
        $id = $_GET['id'];
        $eintrag = "DELETE FROM events WHERE id='$id'"; 
        $delete2 = "DELETE FROM cars WHERE eventId='$id'";
        $eintragen = mysqli_query($db_link,$eintrag); 
        $deleted2 = mysqli_query($db_link,$delete2);
            if($eintragen == true && $deleted2 == true) 
                { 
                echo 'Der Wettkampf wurde gelöscht und alle Autos zu diesem Wettkampf. <br /> <br /><a class="pure-button button-new" href="'.$baseLink.'">Startseite</a>'; 
                } 
            else 
                { 
                echo 'Fehler beim Löschen des Wettkampfes. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/events.php?id='.$id.'">Neu versuchen</a>'; 
                } 
    }
    else{
        $id = $_POST['id'];
        $name = $_POST["name"]; 
        $place = $_POST["place"]; 
        $description = $_POST["description"];
        $date = $_POST["date"];
        $coordX = $_POST["coordX"];
        $coordY = $_POST["coordY"];
        //echo "$name + $place + $description + $date + $coordX + $coordY";
        if($name==null) 
            { 
            echo 'Name vergessen. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/events.php?id='.$id.'">Neu versuchen</a>'; 
            exit; 
            }
        if($place==null) 
            { 
            echo 'Ort vergessen. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/events.php?id='.$id.'">Neu versuchen</a>'; 
            exit; 
            }
        if($coordX==null) 
            { 
            echo 'Wettkampfort vergessen. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/events.php?id='.$id.'">Neu versuchen</a>'; 
            exit; 
            }
        if($date==null) 
            { 
            echo 'Datum vergessen. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/events.php?id='.$id.'">Neu versuchen</a>'; 
            exit; 
            } 
        $dateNew = explode("/",$date);
        $dateDay = (int)$dateNew[1];
        $dateMonth = (int)$dateNew[0];
        $dateYear = (int)$dateNew[2];

        $dateNow = date("m/d/Y");
        $dateNewNow = explode("/",$dateNow);
        $dateDayNow = (int)$dateNewNow[1];
        $dateMonthNow = (int)$dateNewNow[0];
        $dateYearNow = (int)$dateNewNow[2];

        if($dateYearNow >= $dateYear && $dateMonthNow>= $dateMonth && $dateDayNow>= $dateDay)
            {
                if($dateDayNow > $dateDay){
                    echo 'Datum in der Vergangenheit. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/events.php?id='.$id.'">Neu versuchen</a>'; 
                }
                else echo 'Datum ist Heute. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/events.php?id='.$id.'">Neu versuchen</a>'; 
            exit; 
            } 

        $eintrag = "UPDATE events SET name='$name', place='$place', coordX='$coordX', coordY='$coordY', description='$description', dateDay='$dateDay', dateMonth='$dateMonth', dateYear='$dateYear' WHERE id='$id'"; 
        $eintragen = mysqli_query($db_link,$eintrag); 
            if($eintragen == true) 
                { 
                echo 'Der Wettkampf wurde bearbeitet. <br /> <br /><a class="pure-button button-new" href="'.$baseLink.'">Startseite</a>'; 
                } 
            else 
                { 
                echo 'Fehler beim Bearbeiten des Wettkampfes. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/events.php?id='.$id.'">Neu versuchen</a>'; 
                } 
        }
    }
else echo 'Nicht eingeloggt. <br /> <br /><a class="pure-button button-new" href="'.$baseLink.'">Startseite</a>';
?>

        </div>
    </div>
</div>

</body>
</html>
