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
            <?php 
            require_once('configuration.php');
            echo '<a href="'.$baseLink.'/"><h1 class="brand-title">Mitfahren</h1></a>';
            ?>
            <h2 class="brand-tagline">Eine Platform für Autofahrer und das Klima</h2>
            </br>
        </div>
    </div>

    <div class="content pure-u-1 pure-u-md-3-4">
            <div style="  text-align: left;">

                <?php
                require_once("configuration.php");
                if(isset($_GET['changeCarId'])){
                $carId = $_GET['changeCarId'];
                $result1 = mysqli_query($db_link,"SELECT userId FROM cars WHERE id LIKE '$carId'"); 
                    if($result1){
                    $row1 = mysqli_fetch_assoc($result1);
                    $userId = json_decode($row1['userId']); 
                    }
                    else echo  "failed";
                }
                else if(isset($_GET['removeId'])){
                    $carId = $_GET['removeCarID'];
                    $userId = $_GET['removeId'];
                    $result1 = mysqli_query($db_link,"SELECT userId,names FROM cars WHERE id LIKE '$carId'"); 
                    if($result1){
                    $row1 = mysqli_fetch_assoc($result1);
                    $userIds = json_decode($row1['userId']);
                    $names = json_decode($row1['names']); 
                    }
                    else echo  "failed";
                    echo 'Alle diese Mitfahrer werden gelöscht
                                <table class="pure-table"><tbody>';
                                for($i=0;$i<count($names);$i++){
                                    if($userIds[$i]==$userId){
                                        echo '<tr class="pure-table-odd">
                                            <td>'.$names[$i].'</td>      
                                          </tr>';
                                    }
                                }      
                    echo '</tbody> </table>';
                    echo '<form class="pure-form pure-form-aligned" action="delCarSend.php?removeId='.$userId.'&removeCarID='.$carId.'" method="post">
                    <button type="submit" class="pure-button pure-button-primary"style="margin-top:30px;">Abmelden</button>
                    </form>';
                }
                ?>
                <!--<form class="pure-form pure-form-aligned" action="" method="post">
                    <button type="submit" class="pure-button pure-button-primary"style="margin-top:30px;">Abmelden</button>
                </form>-->
            
        </div>
    </div>
</div>

</body>
</html>
