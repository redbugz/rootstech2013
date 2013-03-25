<?php
	//phpmyfamily - opensource genealogy webbuilder
	//Copyright (C) 2002 - 2004  Simon E Booth (simon.booth@giric.com)

	//This program is free software; you can redistribute it and/or
	//modify it under the terms of the GNU General Public License
	//as published by the Free Software Foundation; either version 2
	//of the License, or (at your option) any later version.

	//This program is distributed in the hope that it will be useful,
	//but WITHOUT ANY WARRANTY; without even the implied warranty of
	//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	//GNU General Public License for more details.

	//You should have received a copy of the GNU General Public License
	//along with this program; if not, write to the Free Software
	//Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

	set_include_path('..');
	include "inc/config.inc.php";

	// Check and duck out if tables already exist
	$dbcheck = mysql_list_tables($dbname);
	if (mysql_num_rows($dbcheck) <> 0) {
		while ($row = mysql_fetch_array($dbcheck)) {
			if ($row["0"] == "".$tblprefix."tracking")
				die("phpmyfamily: Upgrade seems to already have been run - please check you installation");
		}
	}

	echo "<html>\n";
	echo "<head>\n";
	echo "<title>Upgrading phpmyfamily</title>\n";
	echo "</head>\n";
	echo "<body>\n";
	echo "<h2>Upgrading phpmyfamily database</h2>\n";

	// install tracking
	$tquery = "CREATE TABLE `".$tblprefix."tracking` (
  `person_id` smallint(5) unsigned zerofill NOT NULL default '00000',
  `email` varchar(128) NOT NULL default '',
  `key` varchar(32) NOT NULL default '',
  `action` enum('sub','unsub') NOT NULL default 'sub',
  `expires` datetime default NULL,
  UNIQUE KEY `person_id` (`person_id`,`email`)
)";
	$tresult = mysql_query($tquery) or die("phpmyfamily: Error creating tracking table!!!");
	echo "tracking table created<br>\n";

	// alter the documents table
	$aquery = "ALTER TABLE `".$tblprefix."documents` ADD `id` SMALLINT UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
	$aresult = mysql_query($aquery) or die("phpmyfamily: Error altering documents table!!!");
	echo "documents table altered<br>\n";

	// rename all the files
	$fquery = "SELECT * FROM ".$tblprefix."documents";
	$fresult = mysql_query($fquery) or die("phpmyfamily: Error reading documents table!!!");
	while ($frow = mysql_fetch_array($fresult)) {
		if (!rename("../".$frow["file_name"], "../docs/".$frow["id"]))
			die("phpmyfamily: Error renaming files");
	}
	echo "all files renamed<br>\n";

	// alter the names in the database
	$dquery = "UPDATE ".$tblprefix."documents SET file_name = SUBSTRING_INDEX(file_name, 'docs/', -1 )";
	$dresult = mysql_query($dquery) or die("phpmyfamily: Error updating documents table");
	echo "documents table updated<br>\n";

	// Add new column
	$pquery = "ALTER TABLE `".$tblprefix."people` ADD `surname` VARCHAR( 20 ) NOT NULL AFTER `name`";
	$presult = mysql_query($pquery) or die("phpmyfamily: error adding surname column");
	echo "surname column added<br>\n";

	// update column
	$uquery = "UPDATE ".$tblprefix."people SET surname = SUBSTRING_INDEX( name, ' ', -1 )";
	$uresult = mysql_query($uquery) or die("phpmyfamily: error updating surname column");
	echo "surname column updated<br>\n";

	// add indices
	$iquery = "ALTER TABLE `".$tblprefix."people` DROP INDEX `name`";
	$iresult = mysql_query($iquery) or die("phpmyfamily: error dropping name index");
	echo "name index dropped<br>\n";

	$iquery = "ALTER TABLE `".$tblprefix."people` ADD INDEX `idx_list_peeps1` (`surname`,`name`,`date_of_birth`,`person_id`)";
	$iresult = mysql_query($iquery) or die("phpmyfamily: error creating idx_list_peeps1 index");
	echo "idx_list_peeps1 index created<br>\n";

	$iquery = "ALTER TABLE `".$tblprefix."people` ADD INDEX `idx_list_peeps2` (`gender`,`surname`,`name`,`date_of_birth`,`person_id`)";
	$iresult = mysql_query($iquery) or die("phpmyfamily: error creating idx_list_peeps2 index");
	echo "idx_list_peeps2 index created<br>\n";

	$iquery = "ALTER TABLE `".$tblprefix."people` ADD INDEX `idx_children` (`date_of_birth`,`mother_id`,`father_id`,`person_id`,`name`,`date_of_death`)";
	$iresult = mysql_query($iquery) or die("phpmyfamily: error creating idx_children index");
	echo "idx_children index created<br>\n";

	$iquery = "ALTER TABLE `".$tblprefix."spouses` DROP INDEX `groom_id`";
	$iresult = mysql_query($iquery) or die("phpmyfamily: error dropping groom_id index");
	echo "groom_id index dropped<br>\n";

	$iquery = "ALTER TABLE `".$tblprefix."spouses` ADD PRIMARY KEY (`marriage_date`,`groom_id`,`bride_id`)";
	$iresult = mysql_query($iquery) or die("phpmyfamily: error creating spouse primary key");
	echo "spouses primary key created<br>\n";

	$iquery = "ALTER TABLE `".$tblprefix."census_years` ADD INDEX `available` (`available`)";
	$iresult = mysql_query($iquery) or die("phpmyfamily: error creating census_years index");
	echo "census_years index created<br>\n";

	$iquery = "ALTER TABLE `".$tblprefix."images` DROP INDEX `person_id`";
	$iresult = mysql_query($iquery) or die("phpmyfamily: error dropping person_id index");
	echo "person_id index dropped<br>\n";

	$iquery = "ALTER TABLE `".$tblprefix."images` ADD INDEX `idx_show_gallery` (`person_id`,`date`)";
	$iresult = mysql_query($iquery) or die("phpmyfamily: error creating idx_show_gallery index");
	echo "idx_show_gallery index created<br>\n";

	// give a link to continue
	echo "<h3>Finished!!</h3>\n";
	echo "Click <a href=\"../index.php\">here</a> to continue.\n";
	echo "</body>\n";
	echo "</html>\n";
	// eof
?>
