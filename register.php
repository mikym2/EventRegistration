<?php
require_once 'controller\Controller.php';
session_start();
$_SESSION["errorRegisterParticipant"] = "";
$_SESSION["errorRegisterEvent"] = "";
$c = new Controller();
try {
$participant = NULL;
if (isset($_POST['participantspinner'])) {
$participant = $_POST['participantspinner'];
}
$event = NULL;
if (isset($_POST['eventspinner'])) {
$event = $_POST['eventspinner'];
}
$c->register($participant, $event);
} catch (Exception $e) {
$errors = explode("@", $e->getMessage());
foreach ($errors as $error) {
if (substr($error, 0, 1) == "1") {
$_SESSION["errorRegisterParticipant"] = substr($error, 1);
}
if (substr($error, 0, 1) == "2") {
$_SESSION["errorRegisterEvent"] = substr($error, 1);
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