<?php
include_once "modules/db/DAOFactory.php";

$s = new Source();

$dao = getSourceDAO();
	
if (isset($_REQUEST["func"]) && $_REQUEST["func"] == "delete") {
	$s->setFromRequest();	
	checkPermissions($dao, $s);
	$dao->deleteSource($s);

} else {
	$s->setFromPost('');
	checkPermissions($dao, $s);
	$dao->saveSource($s);
}

header("Location: index.php");

function checkPermissions($dao, $source) {
	$s = new Source();
	$s->source_id = $source->source_id;
	$dao->getSources($s);
	
	if ($s->numResults > 0) {
		$ret = $s->results[0];
	} else {
		$ret = $s;
	}
/*	
	if (!$ret->isEditable()) {
		die(include "inc/forbidden.inc.php");
	}
	*/
	return ($ret);
}
?>