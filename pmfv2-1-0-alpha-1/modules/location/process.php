<?php
include_once "modules/db/DAOFactory.php";

$loc = new Location();

$dao = getLocationDAO();
	
if (isset($_REQUEST["func"]) && $_REQUEST["func"] == "delete") {
	$loc->setFromRequest();	
	checkPermissions($dao, $loc);
	$dao->deleteLocation($loc);

} else {
	$loc->setFromPost('');
	checkPermissions($dao, $loc);
	$dao->saveLocation($loc);
}

header("Location: index.php");

function checkPermissions($dao, &$loc) {
	$dao->getLocations($loc, Q_MATCH);
	if ($loc->numResults > 0) {
		$ret = $loc->results[0];
	} else {
		$ret = $loc;
	}
	
	if (!$ret->isEditable()) {
		die(include "inc/forbidden.inc.php");
	}
	return ($ret);
}
?>

