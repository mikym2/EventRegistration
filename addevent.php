<?php
require_once 'controller\Controller.php';

session_start();
$c = new Controller();
try {
	$date = $_POST["event_date"];
	date('Y-m-d', strtotime($date));
	
	$start = $_POST["starttime"];
	date('H:i', strtotime($start));
	
	$end = $_POST["endtime"];
	date('H:i', strtotime($end));
	
	$c->createEvent($_POST["event_name"], $date, $start, $end);
	$_SESSION["errorEvent"] = "";
	$_SESSION["errorDate"]="";
	$_SESSION["endBeforeStart"];
} catch (Exception $e) {
	$_SESSION["errorEvent"] = $e->getMessage();
	$_SESSION["errorDate"]= $e->getMessage();
	$_SESSION["endBeforeStart"]= $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="refresh" content="0; url=/EventRegistration/" />
</head>
</html>