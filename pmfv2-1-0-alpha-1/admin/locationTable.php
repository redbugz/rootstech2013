<?php

function createLocationTable() {
    global $tblprefix;
    
$q = "CREATE TABLE `".$tblprefix."locations` (".
  "`location_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,".
  "`name` VARCHAR( 60 ) NOT NULL ,".
  "`place` VARCHAR( 80 ) NOT NULL ,".
  "`lat` FLOAT( 6, 6 ) NULL ,".
  "`lng` FLOAT( 6, 6 ) NULL ,".
  "`centre` smallint(1) NOT NULL default 0,".
  "KEY `place_index` (`place`)".
") ENGINE=InnoDB;";
	mysql_query($q) or die(mysql_error().$q);
	echo "Locations table created<br/>\n";
}
createLocationTable();
?>