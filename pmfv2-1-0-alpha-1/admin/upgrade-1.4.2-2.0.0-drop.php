<?php
set_include_path('..');
include_once('modules/db/DAOFactory.php');

$query = "ALTER TABLE `".$tblprefix."spouses` DROP COLUMN `marriage_date`,
 DROP COLUMN `marriage_cert`,
 DROP COLUMN `marriage_place`;";

 $result = mysql_query($query) or die("phpmyfamily: Error dropping spouses columns");
	echo "Old spouses columns dropped<br>\n";
 
 $query = "ALTER TABLE `".$tblprefix."people` DROP COLUMN `name`,
 DROP COLUMN `surname`,
 DROP COLUMN `suffix`,
 DROP COLUMN `date_of_birth`,
 DROP COLUMN `birth_cert`,
 DROP COLUMN `birth_place`,
 DROP COLUMN `date_of_death`,
 DROP COLUMN `death_cert`,
 DROP INDEX `idx_list_peeps1`,
 ADD INDEX idx_list_peeps1 USING BTREE(`person_id`),
 DROP INDEX `idx_list_peeps2`,
 ADD INDEX idx_list_peeps2 USING BTREE(`gender`, `person_id`),
 DROP INDEX `idx_children`,
 ADD INDEX idx_children USING BTREE(`mother_id`, `father_id`, `person_id`);";

 $result = mysql_query($query) or die("phpmyfamily: Error dropping people columns");
	echo "Old people columns dropped<br>\n";
	
 $query = "ALTER TABLE `".$tblprefix."census`
 DROP COLUMN `address`,
 DROP COLUMN `condition`,
 DROP COLUMN `age`,
 DROP COLUMN `profession`,
 DROP COLUMN `where_born`,
 DROP COLUMN `other_details`;";
 
 $result = mysql_query($query) or die("phpmyfamily: Error dropping census columns");
	echo "Old census columns dropped<br>\n";
	
?>