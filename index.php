<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Event Registration</title>
		<style>
		.error {color: #FF0000;}
		</style>
	</head>
	<body>
	<?php 
	require_once 'model\RegistrationManager.php';
	require_once 'model\Participant.php';
	require_once 'model\Event.php';
	require_once 'persistence\PersistenceEventRegistration.php';
	
	require_once 'model/Participant.php';
	session_start();
	
	//Retrieve the data from the model
	$pm = new PersistenceEventRegistration();
	$rm = $pm->loadDataFromStore();
	
	echo "<form action='register.php' method='post'>";
	
	echo "<p>Name? <select name='participantspinner'>";
	foreach ($rm->getParticipants() as $participant){
		echo "<option>" . $participant->getName() . "</option>";
	}
	echo "</select><span class='error'>";
	if(isset($_SESSION['errorRegisterParticipant']) && !empty($_SESSION['errorRegisterParticipant'])){
		echo " * " . $_SESSION["errorRegisterParticipant"];
	}
	echo "</span></p>";
	
	echo "<p>Event? <select name='eventspinner'>";
	foreach ($rm->getEvents() as $event){
		echo "<option>" . $event->getName() . "</option>";
	}
	echo "</select><span class='error'>";
	if(isset($_SESSION['errorRegisterEvent']) && !empty($_SESSION['errorRegisterEvent'])){
		echo " * " . $_SESSION["errorRegisterEvent"];
	}
	echo "</span></p>";
	
	echo "<p><input type='submit' value='Register' /</p>";
	echo "</form>";
	
	?>
	<form action="addparticipant.php" method="post">
		<p>Name? <input type="text" name="participant_name" />
		<span class="error">
		<?php 
		if(isset($_SESSION['errorParticipantName']) && !empty($_SESSION['errorParticipantName'])){
			echo " * " . $_SESSION["errorParticipantName"];
		}
		?>
		</span></p>
		<p><input type="submit" value="Add Participant"/></p> 
	</form>


<form action="addEvent.php" method="post">
	
	<p>Name? <input type="text" name="event_name" />
		<span class="error">
		<?php 
		if(isset($_SESSION['errorEvent']) && !empty($_SESSION['errorEvent']) && strcmp($_SESSION['errorEvent'],"Event name cannot be empty!")==0){
			echo " * " . $_SESSION["errorEvent"];
		}
		?>
		</span></p>


	<p>Date? <input type="date" name="event_date"  
	 value="<?php echo date('Y-m-d');
	 ?>"/>  
	 
	<?php
    if(isset($_SESSION['errorDate']) && !empty($_SESSION['errorDate']) && strcmp($_SESSION['errorDate'],"Event date must be specified correctly (YYYY-MM-DD)!")==0 ){
			echo " * " . $_SESSION["errorDate"];
		}
	?>
	
	<p>Start time?<input type="time" name="starttime" 
	 value="<?php echo date('H:i'); ?>" />
	 
	 <p>End time?<input type="time" name="endtime" 
	 value="<?php echo date('H:i'); ?>" />
	 
	 <?php
    if(isset($_SESSION['endBeforeStart']) && !empty($_SESSION['endBeforeStart']) && strcmp($_SESSION['endBeforeStart'],"Event end time cannot be before event start time!")==0 ){
			echo " * " . $_SESSION["endBeforeStart"];
		}
	?>
	 

<p><input type="submit" value="Add Event"/></p> 
</form>
</body>
</html>