<?php

// Datenbank-Verbindung herstellen

require_once ('configuration.php');

 

// MySQL-Befehl der Variablen $sql zuweisen

$sql = "
    CREATE TABLE `login` (
    `id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `username` VARCHAR( 150 ) NOT NULL ,
    `password` VARCHAR( 150 ) NOT NULL ,
	`email` VARCHAR( 150 ) NOT NULL
    );
    ";


// MySQL-Anweisung ausführen lassen
$db_erg = mysqli_query($db_link, $sql) or die("Anfrage fehlgeschlagen: " . mysqli_error());

if ($db_erg) echo 'Installation fertig';

?>