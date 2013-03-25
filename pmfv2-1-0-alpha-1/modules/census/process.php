<?php
include_once "modules/db/DAOFactory.php";

$peep = new PersonDetail();
$peep->queryType = Q_IND;
$pdao = getPeopleDAO();

$cen = new CensusDetail();
$dao = getCensusDAO();

if (isset($_REQUEST["func"]) && $_REQUEST["func"] == "delete") {
	$peep->setFromRequest();
	$pdao->getPersonDetails($peep);
	$peep = $peep->results[0];

	if (!$peep->isEditable()) {
		die(include "inc/forbidden.inc.php");
	}
	
	$cen->setFromRequest();
	$dao->deleteCensusRecord($cen);
	stamppeeps($peep);

} else {
	$peep->setFromPost();
	$pdao->getPersonDetails($peep);
	$peep = $peep->results[0];

	if (!$peep->isEditable()) {
		die(include "inc/forbidden.inc.php");
	}
	$cen->setFromPost();
	
	$e = new Event();
	$e->setFromPost();

	$prefix = 'a';
	$e->sources= array();
	while (isset($_POST[$prefix."_title"])) {
		$s = new Source();
		$s->setFromPost($prefix."_");
		if ($s->hasData()) {
			$e->sources[] = $s;
		}
		$prefix++;
	}
	
	$prefix = 'a';
	$e->attendees = array();
	while (isset($_POST[$prefix."person_id"])) {
		$a = new Attendee();
		$a->setFromPost($prefix);
		$l = new Location();
		$l->setFromPost($prefix);
		$a->location = $l;
		if ($a->hasData() || $a->person->person_id == $e->person->person_id) {
			$e->attendees[] = $a;
		}
		$prefix++;
	}
	$cen->event = $e;

	$dao->saveCensusDetails($cen);
	$edao = getEventDAO();
	$edao->stampAttendees($cen->event);
}



header("Location: people.php?person=".$cen->person->person_id);
?>