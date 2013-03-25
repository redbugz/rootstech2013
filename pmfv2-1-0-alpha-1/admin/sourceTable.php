<?php

function createSourceTable() {
    global $tblprefix;
    
$q = "CREATE TABLE `".$tblprefix."source` (
  `source_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NULL DEFAULT NULL,
  `reference` VARCHAR(255) NULL DEFAULT NULL,
  `url` VARCHAR(255) NULL DEFAULT NULL,
  `ref_date` date NOT NULL default '0000-00-00',
  `notes` longtext NULL DEFAULT NULL,
  `certainty` INTEGER NULL DEFAULT NULL,
  PRIMARY KEY (`source_id`),
  INDEX source_1(`title`)
)
ENGINE = InnoDB;
";

	mysql_query($q) or die(mysql_error().$q);
	echo "Sources table created<br/>\n";

$q = "CREATE TABLE `".$tblprefix."source_event` (
  `source_id` INTEGER UNSIGNED NOT NULL,
  `event_id` INTEGER UNSIGNED NOT NULL
)
ENGINE = InnoDB;
";

	mysql_query($q) or die(mysql_error().$q);
	echo "Sources Event table created<br/>\n";

$tconfig = "ALTER TABLE `".$tblprefix."source_event`
  ADD CONSTRAINT `".$tblprefix."FK_se_1` FOREIGN KEY (`source_id`) REFERENCES `".$tblprefix."source` (`source_id`),
  ADD CONSTRAINT `".$tblprefix."FK_se_2` FOREIGN KEY (`event_id`) REFERENCES `".$tblprefix."event` (`event_id`);";

if($rconfig = mysql_query($tconfig)) {
	echo "sources event table foreign key<br>\n";
} else {
	echo mysql_error();
	echo $tconfig;
	die("phpmyfamily: Error creating sources event table foreign key!!!");
}
}

createSourceTable();
?>