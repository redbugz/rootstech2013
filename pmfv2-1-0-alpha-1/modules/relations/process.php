<?php
include_once "classes/Relationship.php";
include_once "modules/db/DAOFactory.php";

$peep = new Relationship();

$rel = new Relationship();
$rel->setFromRequest();
$dao = getRelationsDAO();

if (isset($_REQUEST["func"]) && $_REQUEST["func"] == "delete") {
	$peep->setFromRequest();
	$dao->getRelationshipDetails($peep);
	$peep = $peep->results[0];
	if (!$peep->isEditable()) {
		die(include "inc/forbidden.inc.php");
	}	

	$rel->setFromRequest();
	$dao->deleteRelationshipDetails($rel);

} else {
	$peep->setFromPost();
	$dao->getRelationshipDetails($peep);
	$peep = $peep->results[0];
	if (!$peep->isEditable()) {
		die(include "inc/forbidden.inc.php");
	}
	if(isset($rel->oldRelation) && $rel->oldRelation != $peep->relation->person_id){
		$old = new PersonDetail();
		$old->queryType = Q_IND;
		$pdao = getPeopleDAO();
		$old->person_id = $rel->oldRelation;
		$pdao->getPersonDetails($old);
		$old = $old->results[0];
		if (!$old->isEditable()) {
			die(include "inc/forbidden.inc.php");
		} else {
			stamppeeps($old);
		}
	}
	$rel->setFromPost();
	$e = new Event();
	$e->setFromPost();
	
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
	$e->person = $rel->person;
	$rel->event = $e;
	$dao->saveRelationshipDetails($rel);
	$edao = getEventDAO();
	$edao->stampAttendees($rel->event);
}

header("Location: people.php?person=".$rel->person->person_id);
?>