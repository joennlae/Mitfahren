<?php 
session_start(); 
//error_reporting(E_ALL);
//ini_set('display_errors', 'on');
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
if(isset($_SESSION["username"])){

if(isset($_GET['removeId'])){
                    $carId = $_GET['removeCarID'];
                    $userId = $_GET['removeId'];
                    $result1 = mysqli_query($db_link,"SELECT userId,names,space FROM cars WHERE id LIKE '$carId'"); 
                    if($result1){
                    $row1 = mysqli_fetch_assoc($result1);
                    $userIds = json_decode($row1['userId']);
                    $names = json_decode($row1['names']);
                    $space = $row1['space']; 
                    }
                    $newNames[0]= "";
                    $newUserId[0]= "";
                    $leCount = 0;
                    $spaceCount = 0;
                    for($i=0;$i<count($names);$i++){
                        if($userIds[$i]!=$userId){
                            $newNames[$leCount]=$names[$i];
                            $newUserId[$leCount]=$userIds[$i];
                            $leCount++;
                        }
                        else $spaceCount = $spaceCount + 1;
                    }

                    $space = $space + $spaceCount; 
                    $newNames = json_encode($newNames);
                    $newUserId = json_encode($newUserId);

                $eintrag = "UPDATE cars SET userId='$newUserId', names='$newNames', space='$space' WHERE id='$carId'"; 
                $eintragen = mysqli_query($db_link,$eintrag); 
                    if($eintragen == true) 
                        { 
                        echo 'Die Abmeldung wurde erfolgreich fertig gestellt. <br /> <br /><a class="pure-button button-new" href="'.$baseLink.'">Startseite</a>'; 
                        } 
                    else 
                        { 
                        echo 'Fehler beim Speichern der Anmeldung. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/delCar.php?removeId='.$userId.'&removeCarID='.$carId.'">Neu versuchen</a>'; 
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
