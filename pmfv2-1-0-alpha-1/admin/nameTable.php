<?php


$tconfig = "CREATE TABLE `".$tblprefix."names` (
  `person_id` smallint(5) unsigned zerofill NOT NULL,
  `type` smallint(2) NOT NULL default '0',
  `title` varchar(20) NOT NULL default '',
  `forenames` varchar(50) NOT NULL default '',
  `link` varchar(10) NOT NULL default '',
  `surname` varchar(20) NOT NULL default '',
  `suffix` varchar(20) NOT NULL default '',
  `knownas` varchar(20) NOT NULL default '',
  PRIMARY KEY  USING BTREE (`person_id`,`type`),
  KEY `Index_2` (`surname`),
  KEY `Index_3` (`forenames`)
  ) ENGINE=InnoDB;";
	
if($rconfig = mysql_query($tconfig)) {
	echo "Name table created<br>\n";
} else {
	echo mysql_error();
	die("phpmyfamily: Error creating name table!!!");
}

$tconfig = "ALTER TABLE `".$tblprefix."names`
  ADD CONSTRAINT `".$tblprefix."names_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `".$tblprefix."people` (`person_id`);";

if($rconfig = mysql_query($tconfig)) {
	echo "Name table foreign key<br>\n";
} else {
	echo mysql_error();
	die("phpmyfamily: Error creating name table!!!");
}

?>