<?php
include_once "modules/db/DAOFactory.php";

$peep = new PersonDetail();
$peep->queryType = Q_IND;
$pdao = getPeopleDAO();

$ev = new Event();
$dao = getEventDAO();

if (isset($_REQUEST["func"]) && $_REQUEST["func"] == "delete") {
	$peep->setFromRequest();
	$pdao->getPersonDetails($peep);
	$peep = $peep->results[0];

	if (!$peep->isEditable()) {
		die(include "inc/forbidden.inc.php");
	}
	
	$ev->setFromRequest();
	$dao->deleteEvent($ev);
	stamppeeps($peep);

} else {
	$peep->setFromPost();

	$pdao->getPersonDetails($peep);

	$peep = $peep->results[0];

	if (!$peep->isEditable()) {
		die(include "inc/forbidden.inc.php");
	}
	
	$e = new Event();
	$e->setFromPost();
	$e->person->person_id = $peep->person_id;
	$prefix = 'a';
	$e->attendees = array();
	while (isset($_POST[$prefix."person_id"])) {
		$a = new Attendee();
		$a->setFromPost($prefix);
		$l = new Location();
		$l->setFromPost($prefix);
		$a->location = $l;
		if ($a->hasData()) {
			$e->attendees[] = $a;
		}
		$prefix++;
	}

	$edao = getEventDAO();
	$edao->saveEvent($e);
	$edao->stampAttendees($e);
}



header("Location: people.php?person=".$peep->person_id);
?>