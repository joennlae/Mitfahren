<?php

// Datenbank-Verbindung herstellen

require_once ('configuration.php');

 

// MySQL-Befehl der Variablen $sql zuweisen

$sql = "
	CREATE TABLE `login` (
    `id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `username` VARCHAR( 150 ) NOT NULL ,
    `password` VARCHAR( 150 ) NOT NULL ,
	`email` VARCHAR( 150 ) NOT NULL ,
	`vorname` VARCHAR( 150 ) NOT NULL ,
	`nachname` VARCHAR( 150 ) NOT NULL 
    );
    ";
$sql2 = "
	CREATE TABLE `events` (
    `id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `name` VARCHAR( 150 ) NOT NULL ,
    `place` VARCHAR( 150 ) NOT NULL ,
	`coordX` DOUBLE( 20,18) ,
	`coordY` DOUBLE( 20,18) ,
	`description` TEXT ,
	`dateDay` TINYINT( 10 ),
	`dateMonth` TINYINT( 10 ),
	`dateYear` INT( 10 ),
	`specialTime` INT(10)
    );
    ";
$sql3 = "
	CREATE TABLE `cars` (
    `id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `eventId` TINYINT( 10 ) NOT NULL ,
    `space` TINYINT( 10 ) NOT NULL ,
    `driveWay` INT( 2 ) NOT NULL ,
	`creatorId` INT( 10 ) NOT NULL ,
	`userId` VARCHAR( 150 ) ,
	`names` VARCHAR( 255 ) ,
	`coordX` DOUBLE( 20,18 ) ,
	`coordY` DOUBLE( 20,18 ) ,
	`meettime` VARCHAR(255) ,
	`starttime` VARCHAR(255) ,
	`description` TEXT 
    );
    ";
/*	CREATE TABLE `login` (
    `id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `username` VARCHAR( 150 ) NOT NULL ,
    `password` VARCHAR( 150 ) NOT NULL ,
	`email` VARCHAR( 150 ) NOT NULL ,
	`vorname` VARCHAR( 150 ) NOT NULL ,
	`nachname` VARCHAR( 150 ) NOT NULL 
    );
	CREATE TABLE `events` (
    `id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `name` VARCHAR( 150 ) NOT NULL ,
    `place` VARCHAR( 150 ) NOT NULL ,
	`coordX` DOUBLE( 20,18) ,
	`coordY` DOUBLE( 20,18) ,
	`description` TEXT ,
	`date` VARCHAR(255) ,
	`specialTime` INT(10)
    );
	CREATE TABLE `cars` (
    `id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `eventId` TINYINT( 10 ) NOT NULL ,
    `driveWay` INT( 2 ) NOT NULL ,
	`creatorId` INT( 10 ) NOT NULL ,
	`userId` VARCHAR( 150 ) ,
	`coordX` DOUBLE( 20,18 ) ,
	`coordY` DOUBLE( 20,18 ) ,
	`meettime` VARCHAR(255) ,
	`starttime` VARCHAR(255) ,
	`description` TEXT 
    );*/
// MySQL-Anweisung ausführen lassen
$db_erg = mysqli_query($db_link, $sql) or die("Anfrage fehlgeschlagen: " . mysqli_error());
$db_erg2 = mysqli_query($db_link, $sql2) or die("Anfrage fehlgeschlagen: " . mysqli_error());
$db_erg3 = mysqli_query($db_link, $sql3) or die("Anfrage fehlgeschlagen: " . mysqli_error());

if ($db_erg && $db_erg2 && $db_erg3) echo 'Installation fertig';

?>