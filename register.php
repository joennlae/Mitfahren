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
            <?php 
            require_once('configuration.php');
            echo '<a href="'.$baseLink.'/"><h1 class="brand-title">Mitfahren</h1></a>';
            ?>
            <h2 class="brand-tagline">Eine Platform für Autofahrer und das Klima</h2>
            </br>
        </div>
    </div>

    <div class="content pure-u-1 pure-u-md-3-4">
            <div style="  text-align: center;">
<?php

require_once ('configuration.php');

$username = $_POST["username"]; 
$passwort = $_POST["password"]; 
$passwort2 = $_POST["password2"];
$email = $_POST["email"]; 
$vorname = $_POST["vorname"];
$nachname = $_POST["nachname"];

if($passwort != $passwort2 OR $username == "" OR $passwort == "") 
    { 
    echo 'Eingabefehler. Bitte alle Felder korrekt ausfüllen. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/register.html">Neu versuchen</a>'; 
    exit; 
    } 


$result = mysqli_query($db_link,"SELECT id FROM login WHERE username LIKE '$username'"); 
$menge = mysqli_num_rows($result); 
$result2 = mysqli_query($db_link,"SELECT id FROM login WHERE email LIKE '$email'"); 
$menge2 = mysqli_num_rows($result2); 
if($menge == 0 && $menge2 == 0) 
    { 
    $eintrag = "INSERT INTO login (username, password, email, vorname, nachname) VALUES ('$username', '$passwort','$email','$vorname','$nachname')"; 
    $eintragen = mysqli_query($db_link,$eintrag); 

    if($eintragen == true) 
        { 
        echo 'Benutzername <b>'.$username.'</b> wurde erstellt. <br /> <br /><a class="pure-button button-new" href="'.$baseLink.'">Startseite</a>'; 
        } 
    else 
        { 
        echo 'Fehler beim Speichern des Benutzernames. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/register.html">Neu versuchen</a>'; 
        } 


    } 

else 
    { 
    echo 'Benutzername oder Email schon vorhanden. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/register.html">Neu versuchen</a>'; 
    } 
?>

        </div>
    </div>
</div>

</body>
</html>
