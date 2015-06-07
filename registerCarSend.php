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

$name1 = $_POST["name1"]; 
$name2 = $_POST["name2"]; 
$name3 = $_POST["name3"];
$name4 = $_POST["name4"];
$name5 = $_POST["name5"]; 
$name6 = $_POST["name6"]; 
$name7 = $_POST["name7"];
$name8 = $_POST["name8"];
$name9 = $_POST["name9"];
$starttimeHour = $_POST["starttimeHour"];
$starttimeMinute = $_POST["starttimeMinute"];
$space = (int)$_POST['space'];
$carId = $_POST['carId'];
if($starttimeHour==0 &&$starttimeMinute==0) 
    { 
    echo 'Startzeit um Mitternacht. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/cars.php?id='.$carId.'">Neu versuchen</a>'; 
    exit; 
    }
if($name1=="") 
    { 
    echo 'Name/n vergessen. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/cars.php?id='.$carId.'">Neu versuchen</a>'; 
    exit; 
    } 

$result = mysqli_query($db_link,"SELECT starttime,space FROM cars WHERE id = '$carId'"); 
if($result){
$row = mysqli_fetch_assoc($result);
$starttimeInDB = $row['starttime']; 
$spaceInDb = $row['space'];
}
else echo  "failed";
$length = 0;
for($i=1; $i<10; $i++){
    $a = "name".$i;
    if($$a==null) {
        $length = $i;
        break;
    }
}
$result2 = mysqli_query($db_link,"SELECT names FROM cars WHERE id = '$carId'"); 
if($result2){
$row = mysqli_fetch_assoc($result2);
$names = json_decode($row['names']);
}
if($names[0]==""){
$names = array();
$names[0] = "";
$leCount = 0;
}
else $leCount=count($names);

//echo $leCount;
for($i=0; $i<$length-1;$i++){
    $a = "name".($i+1);
    $names[$leCount+$i] = $$a;
}
$names = json_encode($names,JSON_UNESCAPED_UNICODE);
//echo $names;
$starttime = $starttimeHour . $starttimeMinute;
if((int)$starttime>(int)$starttimeInDB) $starttime = $starttimeInDB; //update $starttime for sql
$space = $space - ($length -1);

$username = $_SESSION['username'];

$result = mysqli_query($db_link,"SELECT id FROM login WHERE username LIKE '$username'"); 
if($result){
$row = mysqli_fetch_assoc($result);
$registerId = $row['id']; 
}
else echo  "failed";
$result1 = mysqli_query($db_link,"SELECT userId FROM cars WHERE id LIKE '$carId'"); 
if($result1){
$row1 = mysqli_fetch_assoc($result1);
$userId = json_decode($row1['userId']); 
}
else echo  "failed";

for($i=0;$i<$length-1;$i++){
$userId[$leCount+$i] = $registerId;
}
$userId = json_encode($userId);

$eintrag = "UPDATE cars SET userId='$userId', names='$names', starttime='$starttime', space='$space' WHERE id='$carId'"; 
$eintragen = mysqli_query($db_link,$eintrag); 
    if($eintragen == true) 
        { 
        echo 'Die Anmeldung wurde erfolgreich fertig gestellt. <br /> <br /><a class="pure-button button-new" href="'.$baseLink.'">Startseite</a>'; 
        } 
    else 
        { 
        echo 'Fehler beim Speichern der Anmeldung. <br /> <br /> <a class="pure-button button-new" href="'.$baseLink.'/cars.php?id='.$_POST['carId'].'">Neu versuchen</a>'; 
        } 
}
else echo 'Nicht eingeloggt. <br /> <br /><a class="pure-button button-new" href="'.$baseLink.'">Startseite</a>';
?>

        </div>
    </div>
</div>

</body>
</html>
