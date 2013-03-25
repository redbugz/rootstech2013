<?php
include_once "modules/db/DAOFactory.php";

$peep = new PersonDetail();
$peep->queryType = Q_IND;
$pdao = getPeopleDAO();

$trans = new Transcript();
$trans->setFromRequest();

$dao = getTranscriptDAO();

if (isset($_REQUEST["func"]) && $_REQUEST["func"] == "delete") {
	$peep->setFromRequest();
	if ($peep->person_id > 0) {
		$pdao->getPersonDetails($peep);
		$peep = $peep->results[0];
		if (!$peep->isEditable()) {
			die(include "inc/forbidden.inc.php");
		}		
	} 

	$docFile = $trans->getFileName();
	if (@unlink($docFile) || !file_exists($docFile)) {
		$dao->deleteTranscript($trans);
	}
} else {
	$peep->setFromPost();
	if ($peep->person_id > 0) {
		$pdao->getPersonDetails($peep);
		$peep = $peep->results[0];
		if (!$peep->isEditable()) {
			die(include "inc/forbidden.inc.php");
		}		
	} 
	
	$trans->setFromPost();
	$e = new Event();
	$e->setFromPost();
	if (!isset($e->event_id)) {
		$e->type = DOC_EVENT;
		$trans->event = $e;
	} else {
		$edao = getEventDAO();
		$edao->getEvents($e, Q_ALL);
		$trans->event = $e->results[0];
	}
	$e->person->person_id = $trans->person->person_id;
	$s = new Source();
	$s->setFromPost();
	$sdao = getSourceDAO();

	$sdao->resolveSource($s);

	if ($s->source_id > 0) {
		$e->person->person_id = 'null';
		if (!$s->isEditable()) {
			die(include "inc/forbidden.inc.php");
		}	
	} else {
		$s->source_id = 'null';
	}
	$trans->source = $s;
	
	if ($e->person->person_id <= 0) {
		$e->person->person_id = 'null';
	}	
	if(isset($trans->transcript_id)) {
		$dao->updateTranscript($trans);
	} else {
		$dao->createTranscript($trans);
		if (!move_uploaded_file($trans->tmp_file_name, $trans->getFileName())) {
			if (!is_writable($trans->getFilename())) {
				error_log(getcwd().$trans->getFileName()." is not writable");
			} else {
				error_log("Unable to move file to:".getcwd()."/".$trans->getFileName());
			}
		}
	}
}

stamppeeps($peep);

header("Location: people.php?person=".$trans->person->person_id);
?>