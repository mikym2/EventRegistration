<?php
require_once 'controller\Controller.php';

session_start();



$c = new Controller();
try {
	
	$date = $_POST["event_date"];
	if(strtotime($date) == false){
		$date = NULL;
	}else{
	date('Y-m-d', strtotime($date));
	}
	
	$start = $_POST["starttime"];
	if(strtotime($start) == false){
		$start = NULL;
	}else{
		date('H:i', strtotime($start));
	}
	
	$end = $_POST["endtime"];
	if(strtotime($end) == false){
		$end = NULL;
	}else{
		date('H:i', strtotime($end));
	}
	
	
	$c->createEvent($_POST["event_name"], $date, $start, $end);
	
	$_SESSION["errorEvent"] ="";
	$_SESSION["errorDate"]="";
	$_SESSION["startTimeError"]="";
	$_SESSION["endTimeError"]="";
	$_SESSION["endBeforeStart"]="";
	
} catch (Exception $e) {
	
$errors = explode("@", $e->getMessage());
			foreach ($errors as $error) {
				if (substr($error, 0, 1) == "1") {
						$_SESSION["errorEvent"] = substr($error, 1);
					}
				if (substr($error, 0, 1) == "2") {
						$_SESSION["errorDate"] = substr($error, 1);
					}
				if (substr($error, 0, 1) == "3") {
						$_SESSION["startTimeError"] = substr($error, 1);
					}
				if (substr($error, 0, 1) == "4" && strcmp($error,"4Event end time must be specified correctly (HH:MM)!") ==0 ) { 
						$_SESSION["endTimeError"] = substr($error, 1);
					}
					
				if (substr($error, 0, 1) == "4" && strcmp($error,"4Event end time cannot be before event start time!")==0) { 
						$_SESSION["endBeforeStart"] = substr($error, 1);
					}
				
				}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="refresh" content="0; url=/EventRegistration/" />
</head>
</html>