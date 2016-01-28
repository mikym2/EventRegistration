<?php
require_once 'C:\Users\User\workspace2\EventRegistration\controller\InputValidator.php';
require_once 'C:\Users\User\workspace2\EventRegistration\persistence\PersistenceEventRegistration.php';
require_once 'C:\Users\User\workspace2\EventRegistration\model\RegistrationManager.php';
require_once 'C:\Users\User\workspace2\EventRegistration\model\Participant.php';
require_once 'C:\Users\User\workspace2\EventRegistration\model\Event.php';
require_once 'C:\Users\User\workspace2\EventRegistration\model\Registration.php';
class Controller{
	
	public function _construct()
	{
	}
	
	public function createParticipant($particicpant_name){
		// 1.Variable input
		$name = InputValidator::validate_input($particicpant_name);
		if($name ==null|| strlen($name)==0){
			throw new Exception("Participant name cannot be empty!");
		
			
		}else{
			//2. load all data
			$pm = new PersistenceEventRegistration();
			$rm = $pm->loadDataFromStore();
			
			// 3. Add the new particicpant 
			$particicpant = new Participant($name);
			$rm->addParticipant($particicpant);
			
			//4.Write all of the data
			$pm->writeDataToStore($rm);
		}
	}
	
	public function createEvent($event_name, $event_date, $startTime, $endTime){
		$eventName = InputValidator::validate_input($event_name);
		//$eventDate = InputValidator::validate_input($event_date);
		//$eventStartTime = InputValidator::validate_input($startTime);
		//$eventEndTime = InputValidator::validate_input($endTime);
		
		if($eventName==null){ 
			throw new Exception("Event name cannot be empty!");
		}
		
		//TODO: need to be able to handle when the event_date input is not in the proper format
		if($event_date ==null ){
			throw new Exception("Event date must be specified correctly (YYYY-MM-DD)!");
		}
		
		//TODO: need to be able to handle when the start and endtime input are not in the proper format
		if($startTime>=$endTime){
			throw new Exception("Event end time cannot be before event start time!");
		}
		
		 else {
			
			//2. load all data
			$pm = new PersistenceEventRegistration();
			$rm = $pm->loadDataFromStore();
			
			//3 Add event
			$event = new Event($eventName, $event_date, $startTime, $endTime);
			$rm->addEvent($event);
			
			//4 Write all of the data
			$pm->writeDataToStore($rm);
		}
		
		
	}
	
	public function register($aParticipant, $aEvent){
		//1.Load all of the data 
		$pm = new PersistenceEventRegistration();
		$rm = $pm->loadDataFromStore();
		
		//2.find the participant
		$myparticipant = Null;
		foreach ($rm->getParticipants() as $participant){
			if(strcmp($participant->getName(),$aParticipant)==0){
				$myparticipant=$participant;
				break;
			}
		}
		
		//3.find the event
		$myevent = NULL;
		foreach ($rm->getEvents() as $event){
			if(strcmp($event->getName(), $aEvent)==0){
				$myevent=$event;
				break;
			}
		}
		
		//4.Register for event
		$error= "";
		if($myparticipant!= NULL && $myevent !=NULL){
		   $myregistration = new Registration($myparticipant, $myevent);
		   $rm-> addRegistration($myregistration);
		   $pm->writeDataToStore($rm);
		} else{
			if($myparticipant==NULL){
				$error .="@1Participant ";
				if($aParticipant != NULL){
					$error .= $aParticipant;
				}
				$error .= " not found! ";
			}
			if($myevent == NULL){
				$error .="@2Event ";
				if($aEvent!= NULL){
					$error .=$aEvent;
				}
				$error .= " not found!";
			}
				throw new Exception(trim($error));
		}
		
		
	}
}
	