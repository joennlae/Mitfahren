<?php
define ( 'MYSQL_HOST',      'mysql.hostinger.de' );

define ( 'MYSQL_BENUTZER',  'u903036974_drive' );

define ( 'MYSQL_KENNWORT',  'olgbasel' );

define ( 'MYSQL_DATENBANK', 'u903036974_drive' );

$verbindung = mysqli_connect (MYSQL_HOST, 

                           MYSQL_BENUTZER, 

                           MYSQL_KENNWORT, 

                           MYSQL_DATENBANK); 

?>