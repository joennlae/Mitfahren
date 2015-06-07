<?php 
session_start(); 
?> 

<?php 

require_once ('verbindung.php');

$username = $_POST["username"]; 
$passwort = md5($_POST["password"]); 

$abfrage = "SELECT username, passwort FROM login WHERE username LIKE '$username' LIMIT 1"; 
$ergebnis = mysqli_query($verbindung,"SELECT username, password FROM login WHERE username LIKE '$username' LIMIT 1"); 
$row = mysqli_fetch_object($ergebnis); 
//echo $row;
if($row->password == $passwort) 
    { 
    $_SESSION["username"] = $username; 
    echo "Login erfolgreich. <br> <a href=\"geheim.php\">Geschützer Bereich</a>"; 
    } 
else 
    { 
    echo "Benutzername und/oder Passwort waren falsch. <a href=\"login.html\">Login</a>"; 
    } 

?>