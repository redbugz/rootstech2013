<?php

function createGedcomTable() {
    global $tblprefix;
    
$q = "CREATE TABLE `".$tblprefix."gedcom` (
  `gedcom_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `person_id` SMALLINT(5) UNSIGNED NULL DEFAULT NULL,
  `gedrefid` VARCHAR(255)  NULL DEFAULT NULL,
  `gedfile` VARCHAR(255)  NULL DEFAULT NULL,
  `uid` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`gedcom_id`),
  INDEX Index_1(`gedrefid`),
  INDEX Index_2(`person_id`)
)
ENGINE = InnoDB;
";
	mysql_query($q) or die(mysql_error().$q);
	echo "Gedcom references table created<br/>\n";

$tconfig = "ALTER TABLE `".$tblprefix."gedcom`
  ADD CONSTRAINT `".$tblprefix."FK_gedcom_1` FOREIGN KEY (`person_id`) REFERENCES `".$tblprefix."people` (`person_id`);";

if($rconfig = mysql_query($tconfig)) {
	echo "gedcom table foreign key<br>\n";
} else {
	echo mysql_error();
	echo $tconfig;
	die("phpmyfamily: Error creating gedcom table foreign key!!!");
}
}

createGedcomTable();
?>