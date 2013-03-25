<?php

function show_gedcom($per) {
	$dao = getGedcomDAO();
	$rows = $dao->getReferences($per->person_id);
	$ret = 0;
	foreach ($rows as $row) {
		echo "GEDCOM:".$row["gedfile"]." ".$row["gedrefid"];
		$ret++;
	}
	return ($ret);
}

function get_gedcom_create_string($per) {
	return ("");
}

function get_gedcom_title() {
	return "";
}

function show_gedcom_title($per) {
	return "";
}

?>