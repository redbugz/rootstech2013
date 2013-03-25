<?php
set_include_path('..');
include_once('modules/db/DAOFactory.php');

$view = "CREATE OR REPLACE VIEW `".$tblprefix."person_detail` AS 
		select ".PersonDetail::getFields().
			 " FROM ".$tblprefix."people p ".
			 PersonDetail::getJoins();

if($rconfig = mysql_query($view)) {
	echo "person_detail view created<br>\n";
} else {
	echo mysql_error();
	die("phpmyfamily: Error creating person_detail view!!!");
}
?>
