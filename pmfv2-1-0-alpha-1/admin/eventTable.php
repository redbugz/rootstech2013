<?php


$tconfig = "CREATE TABLE `".$tblprefix."event` (
  `event_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `etype` SMALLINT UNSIGNED NOT NULL,
  `descrip` VARCHAR(45) NULL,
  `person_id` SMALLINT(5) UNSIGNED NULL DEFAULT NULL,
  `date1` DATE NOT NULL,
  `d1type` SMALLINT UNSIGNED NOT NULL,
  `date2` DATE DEFAULT NULL,
  `d2type` SMALLINT UNSIGNED NULL DEFAULT NULL,
  `location_id` INT NULL DEFAULT NULL,
  `source` VARCHAR(255)  NULL DEFAULT NULL,
  `reference` VARCHAR(255)  NULL DEFAULT NULL,
  `certified` ENUM('Y','N')  NULL DEFAULT NULL,
  `notes` LONGTEXT  NULL DEFAULT NULL,
  PRIMARY KEY (`event_id`),
  INDEX Index_1(`date1`)
)
ENGINE = InnoDB;
";
	
if($rconfig = mysql_query($tconfig)) {
	echo "Event table created<br>\n";
} else {
	echo mysql_error();
	die("phpmyfamily: Error creating event table!!!");
}

$tconfig = "ALTER TABLE `".$tblprefix."event`
  ADD CONSTRAINT `".$tblprefix."FK_event_1` FOREIGN KEY (`location_id`) REFERENCES `".$tblprefix."locations` (`location_id`),
  ADD CONSTRAINT `".$tblprefix."FK_event_2` FOREIGN KEY (`person_id`) REFERENCES `".$tblprefix."people` (`person_id`);";

if($rconfig = mysql_query($tconfig)) {
	echo "Event table foreign key<br>\n";
} else {
	echo mysql_error();
	echo $tconfig;
	die("phpmyfamily: Error creating event table foreign key!!!");
}
?>