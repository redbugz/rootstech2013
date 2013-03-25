<?php
include_once "modules/db/DAOFactory.php";

$peep = new PersonDetail();
$peep->queryType = Q_IND;


$config = Config::getInstance();

$per = new PersonDetail();
$dao = getPeopleDAO();

$loc = "index.php";

if (isset($_REQUEST["func"]) && $_REQUEST["func"] == "delete") {
	$per->setFromRequest();
	$peep->setFromRequest();
	$dao->getPersonDetails($peep);
	$peep = $peep->results[0];
	if (!$peep->isEditable()) {
		die(include "inc/forbidden.inc.php");
	}
	// If Big Brother is watching
	// We need to call it here while we can!
	stamppeeps($per);
	
	$dao->deletePerson($per);
	
	// have to go to index, cos don't know where else to go
	$loc = "index.php";
} else {
	$peep->setFromPost();

	if (isset($peep->person_id)) {
		$peep->name = new Name();
		unset($peep->date_of_birth);
		unset($peep->gender);
		$peep->queryType = Q_IND;
		$dao->getPersonDetails($peep);
		$peep = $peep->results[0];
		if (!$peep->isEditable()) {
			die(include "inc/forbidden.inc.php");
		}
	}
	$per->setFromPost();
	$a = new Attendee();
	$a->setFromPost('');
	$attendee = false;
	if ($a->hasData()) {
		$attendee = true;
	}
	$per->events = array();

	for ($i = 0; $i < 4;$i++) {
		$e = new Event();
		$e->setFromPost($strEvent[$i]);
		$addEvent = false;
		if ($e->hasData()) {
			$addEvent = true;
		}
		if($e->type == BIRTH_EVENT && $attendee) {
			$addEvent = true;
			$e->attendees = array();
			if ($a->person->person_id == '') {
				$a->person->person_id = $per->father->person_id;
			}
			if ($a->person->person_id != '') {
				$e->attendees[] = $a;
			}
		}
		$prefix = 'a';
		
		$e->sources= array();
		while (isset($_POST[$prefix."_".$strEvent[$i]."title"])) {
			$s = new Source();
			$s->setFromPost($prefix."_".$strEvent[$i]);
			if ($s->hasData()) {
				$e->sources[] = $s;
			}
			$prefix++;
		}
		if ($addEvent) {
			$per->events[] = $e;
		}
	}
	
	if ($dao->savePersonDetails($per) > 0) {
		//Only stamp if changed
		stamppeeps($per);
	}
	$loc = "people.php?person=".$per->person_id;
	
}

header("Location: ".$loc);
?>
