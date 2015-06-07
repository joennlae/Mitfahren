<?php

error_reporting(E_ALL);

// Zum Aufbau der Verbindung zur Datenbank

define ( 'MYSQL_HOST',      'localhost' );

define ( 'MYSQL_BENUTZER',  'root' );

define ( 'MYSQL_KENNWORT',  'sinnaj' );

define ( 'MYSQL_DATENBANK', 'driveapplication' );

$db_link = mysqli_connect (MYSQL_HOST, 

                           MYSQL_BENUTZER, 

                           MYSQL_KENNWORT, 

                           MYSQL_DATENBANK); 

mysqli_set_charset($db_link, 'utf8');

/*if ( $db_link )

{

    echo 'Verbindung erfolgreich: ';

	print_r( $db_link);

}

else

{

    // hier sollte dann später dem Programmierer eine

    // E-Mail mit dem Problem zukommen gelassen werden
	print_r($db_link);

    die('keine Verbindung möglich: ' . mysqli_error());

}*/
$baseLink="/olgbasel";
$admins = array (
	1 => "admin",
	2 => "joennlae",
	);
?>