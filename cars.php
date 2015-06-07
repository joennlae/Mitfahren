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
var id = {value: 0}
id.value= parseInt(<?php echo $_GET['id']; ?>);
var saver = {value: ''};
$.when(request().done(google.maps.event.addDomListener(window, 'load', initialize)));
function request(){
    return $.ajax({
        async: false,                                      
        url: 'fetch_coords.php?id='+id.value,                      
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
            if($_SESSION['err'] == true){
                echo "Benutzername und/oder Passwort falsch.\n";
                $_SESSION['err'] = false;
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
            
            <!-- A wrapper for all the blog posts -->
            <div class="posts">
				<?php 
                    require_once("configuration.php");
                    if(isset($_SESSION['username'])){
                    $carId = (int)$_GET['id'];
                    $sql="SELECT cars.space, cars.driveWay, cars.userId, cars.meettime, cars.starttime, cars.description, events.name, login.vorname, login.nachname, cars.names FROM cars JOIN events ON cars.eventId=events.id JOIN login ON cars.creatorId=login.id WHERE cars.id='$carId'";
                    $result = mysqli_query($db_link,$sql);
					if($result){
                        while ($row = mysqli_fetch_assoc($result)) {
                            $vorname = $row["vorname"];
                            $nachname = $row["nachname"];
                            $driveWay = $row["driveWay"];
                            $starttime = $row["starttime"];
                            $meettime = $row["meettime"];
                            $name = $row["name"];
                            $space = $row["space"];
                            $userId = $row["userId"];
                            $description = $row["description"];
                            $names = json_decode($row['names']);

                            if($driveWay==1) $driveWay="Hin";
                            else if($driveWay==2) $driveWay="Zurück";
                            else $driveWay="Hin und zurück";

                            $newstarttime = str_split($starttime,2);
                            $newmeettime = str_split($meettime,2);

                            $namesString= "";

                            for($i=0;$i<count($names);$i++){
                                $namesString = $namesString.','.$names[$i];
                            }
                            $namesString = substr($namesString,1);


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
                                            <td>Plätze Frei</td>
                                            <td>'.$space.'</td>        
                                          </tr>
                                          <tr>
                                            <td>Angemeldet</td>
                                            <td>'.$namesString.'</td>        
                                          </tr>
                                          <tr class="pure-table-odd">
                                            <td>Abfahrtsort</td>
                                            <td><div class="map" id="googleMap'.$carId.'" style="width:500px;height:300px;"></div></td>        
                                          </tr>
                                          <tr>
                                            <td>Zusätzliche Informationen</td>
                                            <td>'.$description.'</td>        
                                          </tr>
                                          </tbody>
                                        </table>';
                                if($space>0){
                                echo '<div style="text-align: left;">
                                        
                                            <form class="pure-form" action="registerCar.php" method="post">
                                            <fieldset>
                                            <input name="carId" type="hidden" value="'.$carId.'"></input>
                                            <input name="space" type="hidden" value="'.$space.'"></input>
                                                <div class="pure-controls">
                                                    <button type="submit" class="pure-button pure-button-primary">Anmelden</button>
                                                </div>
                                            </fieldset>
                                            </form>
                                            <a class="pure-button button-new" href="'.$baseLink.'">Zurück</a>

                                    </div>';

                                }
                                else echo'<p>Auto schon voll!</p><a class="pure-button button-new" href="'.$baseLink.'">Zurück</a>';
                        }
                    }
                    else echo "failed to load car data! email admin";
                }
                else echo 'Nicht eingeloggt. <br /> <br /><a class="pure-button button-new" href="'.$baseLink.'">Startseite</a>'; 
				
				?>
			</div>

        </div>
    </div>
</div>






</body>
</html>
