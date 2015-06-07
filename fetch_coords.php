<?php
session_start();
require_once("configuration.php");
if(isset($_GET['myview'])){
	$dateNow = date("m/d/Y");
	$dateNew = explode("/",$dateNow);
	$dateDay = (int)$dateNew[1];
	$dateMonth = (int)$dateNew[0];
	$dateYear = (int)$dateNew[2];
	$return = array();
	$return[0][0]=0;
	$username = $_SESSION['username'];

    $result = mysqli_query($db_link,"SELECT id FROM login WHERE username LIKE '$username'"); 
    if($result){
    $row = mysqli_fetch_assoc($result);
    $creatorId = $row['id']; 
    }
	$res = mysqli_query($db_link,"SELECT cars.coordx,cars.coordy,cars.id FROM cars JOIN events ON events.id=cars.eventId WHERE (events.dateYear>'$dateYear' OR (events.dateYear = '$dateYear' AND events.dateMonth > '$dateMonth') OR (events.dateYear = '$dateYear' AND events.dateMonth = '$dateMonth' AND events.dateDay >= '$dateDay')) AND (cars.creatorId = '$creatorId' OR cars.userId LIKE '%$creatorId%')");
	$count = 0;
	while ($row = mysqli_fetch_assoc($res)) {
		$return[$count][0]=$row['coordx'];
		$return[$count][1]=$row['coordy'];
		$return[$count][2]=$row['id'];
		$count++;
	}
	if($count>0){
	echo json_encode($return);
	}
	else echo json_encode('no events');
}
else if(isset($_GET['id'])){
	$carId = $_GET['id'];
	$return = array();
	$return[0][0]=0;
	$res = mysqli_query($db_link,"SELECT cars.coordx,cars.coordy,cars.id FROM cars WHERE cars.id = '$carId'");
	$count = 0;
	while ($row = mysqli_fetch_assoc($res)) {
		$return[$count][0]=$row['coordx'];
		$return[$count][1]=$row['coordy'];
		$return[$count][2]=$row['id'];
		$count++;
	}
	if($count>0){
	echo json_encode($return);
	}
	else echo json_encode('no events');
}
else if(isset($_GET['events'])){
	$eventId = $_GET['events'];
	$return = array();
	$return[0][0]=0;
	$res = mysqli_query($db_link,"SELECT events.coordx,events.coordy,events.id FROM events WHERE events.eventId = '$eventId'");
	$count = 0;
	while ($row = mysqli_fetch_assoc($res)) {
		$return[$count][0]=$row['coordx'];
		$return[$count][1]=$row['coordy'];
		$return[$count][2]=$row['id'];
		$count++;
	}
	if($count>0){
	echo json_encode($return);
	}
	else echo json_encode('no events');
}
else if(isset($_GET['event'])){
	$eventId = $_GET['event'];
	$return = array();
	$return[0][0]=0;
	$res = mysqli_query($db_link,"SELECT coordX,coordY,id FROM events WHERE id = '$eventId'");
	$count = 0;
	while ($row = mysqli_fetch_assoc($res)) {
		$return[$count][0]=$row['coordX'];
		$return[$count][1]=$row['coordY'];
		$return[$count][2]=$row['id'];
		$count++;
	}
	if($count>0){
	echo json_encode($return);
	}
	else echo json_encode('no events');
}
else {
	$dateNow = date("m/d/Y");
	$dateNew = explode("/",$dateNow);
	$dateDay = (int)$dateNew[1];
	$dateMonth = (int)$dateNew[0];
	$dateYear = (int)$dateNew[2];
	$return = array();
	$return[0][0]=0;
	$res = mysqli_query($db_link,"SELECT cars.coordx,cars.coordy,cars.id FROM cars JOIN events ON events.id=cars.eventId WHERE events.dateYear>'$dateYear' OR (events.dateYear = '$dateYear' AND events.dateMonth > '$dateMonth') OR (events.dateYear = '$dateYear' AND events.dateMonth = '$dateMonth' AND events.dateDay >= '$dateDay')");
	$count = 0;
	while ($row = mysqli_fetch_assoc($res)) {
		$return[$count][0]=$row['coordx'];
		$return[$count][1]=$row['coordy'];
		$return[$count][2]=$row['id'];
		$count++;
	}
	if($count>0){
	echo json_encode($return);
	}
	else echo json_encode('no events');
}

?>