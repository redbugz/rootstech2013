<?php

$tconfig = "CREATE TABLE `".$tblprefix."attendee` (
  `attendee_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` INTEGER UNSIGNED NOT NULL,
  `person_id` SMALLINT(5) UNSIGNED NOT NULL,
  `age` VARCHAR(10)  NULL DEFAULT NULL,
  `profession` VARCHAR(45)  NULL DEFAULT NULL,
  `r_status` enum('','married','unmarried','widowed') NOT NULL default 'unmarried',
  `location_id` INT NULL DEFAULT NULL,
  `loc_descrip` VARCHAR(45)  NULL DEFAULT NULL,
  `certified` ENUM('Y','N')  NULL DEFAULT NULL,
  `notes` LONGTEXT  NULL DEFAULT NULL,
  PRIMARY KEY (`attendee_id`)
)
ENGINE = InnoDB;
";
	
if($rconfig = mysql_query($tconfig)) {
	echo "attendee table created<br>\n";
} else {
	echo mysql_error();
	die("phpmyfamily: Error creating attendee table!!!");
}

$tconfig = "ALTER TABLE `".$tblprefix."attendee`
  ADD CONSTRAINT `".$tblprefix."FK_attendee_1` FOREIGN KEY (`person_id`) REFERENCES `".$tblprefix."people` (`person_id`),
  ADD CONSTRAINT `".$tblprefix."FK_attendee_2` FOREIGN KEY (`location_id`) REFERENCES `".$tblprefix."locations` (`location_id`),
  ADD CONSTRAINT `".$tblprefix."FK_attendee_3` FOREIGN KEY (`event_id`) REFERENCES `".$tblprefix."event` (`event_id`);";

if($rconfig = mysql_query($tconfig)) {
	echo "attendee table foreign key<br>\n";
} else {
	echo mysql_error();
	echo $tconfig;
	die("phpmyfamily: Error creating attendee table foreign key!!!");
}
?>