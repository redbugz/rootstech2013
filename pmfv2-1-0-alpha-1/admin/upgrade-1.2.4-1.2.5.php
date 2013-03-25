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
			if ($row["0"] == "".$tblprefix."census_years")
				die("phpmyfamily: Upgrade seems to already have been run - please check you installation");
		}
	}

	echo "<html>\n";
	echo "<head>\n";
	echo "<title>Upgrading phpmyfamily</title>\n";
	echo "</head>\n";
	echo "<body>\n";
	echo "<h2>Upgrading phpmyfamily database</h2>\n";

	// install ",$tblprefix."census_years
	$cyquery = "CREATE TABLE `".$tblprefix."census_years` (
  `census_id` mediumint(9) NOT NULL auto_increment,
  `country` varchar(20) NOT NULL default '',
  `year` smallint(4) NOT NULL default '0',
  `available` enum('Y','N') NOT NULL default 'Y',
  PRIMARY KEY  (`census_id`)
)";
	$cyresult = mysql_query($cyquery) or die("phpmyfamily: Error creating census years table!!!");
	echo "Census years table created<br>\n";

	// install ".$tblprefix."census_years values
	$cyvquery = "INSERT INTO ".$tblprefix."census_years (country, year) VALUES ('British Isles', '1841'), ('British Isles', '1851'), ('British Isles', '1861'), ('British Isles', '1871'), ('British Isles', '1881'), ('British Isles', '1891'), ('British Isles', '1901'), ('USA', '1790'), ('USA', '1800'), ('USA', '1810'), ('USA', '1820'), ('USA', '1830'), ('USA', '1840'), ('USA', '1850'), ('USA', '1860'), ('USA', '1870'), ('USA', '1880'), ('USA', '1890'), ('USA', '1900'), ('USA', '1910'), ('USA', '1920'), ('USA', '1930'), ('Canada', '1842'), ('Canada', '1848'), ('Canada', '1851'), ('Canada', '1861'), ('Canada', '1871'), ('Canada', '1881'), ('Canada', '1891'), ('Canada', '1901')";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values inserted<br>\n";

	// Add new census column to ".$tblprefix."census
	$ncquery = "ALTER TABLE ".$tblprefix."census ADD census MEDIUMINT(4) NOT NULL AFTER person_id";
	$ncresult = mysql_query($ncquery) or die("phpmyfamily: Error adding new column");
	echo "New census column created<br>\n";

	// add new details column to ".$tblprefix."census
	$ncdquery = "ALTER TABLE ".$tblprefix."census ADD other_details TEXT NOT NULL";
	$ncdresult = mysql_query($ncdquery) or die("phpmyfamily: Error adding new column");
	echo "New details column created<br>\n";

	// Update the new column
	$uquery = "UPDATE ".$tblprefix."census, ".$tblprefix."census_years SET ".$tblprefix."census.census = ".$tblprefix."census_years.census_id WHERE ".$tblprefix."census.year = CAST(".$tblprefix."census_years.year AS CHAR) AND ".$tblprefix."census_years.country = 'British Isles'";
	$uresult = mysql_query($uquery) or die("phpmyfamily: Error updating new column");
	echo "New column updated<br>\n";

	// dump the key....
	$dkquery = "ALTER TABLE ".$tblprefix."census DROP PRIMARY KEY";
	$dkresult = mysql_query($dkquery) or die("phpmyfamily: Error dropping old key");
	echo "Old key dropped<br>\n";

	// ...so we can drop the obsolete column...
	$dcquery = "ALTER TABLE ".$tblprefix."census DROP year";
	$dcresult = mysql_query($dcquery) or die("phpmyfamily: Error dropping old column");
	echo "Old column dropped<br>\n";

	// ...and add a new prmary key
	$nkquery = "ALTER TABLE ".$tblprefix."census ADD PRIMARY KEY (person_id, census)";
	$nkresult = mysql_query($nkquery) or die("phpmyfamily: Error creating new key");
	echo "New key created<br>\n";

	// give a link to continue
	echo "<h3>Finished!!</h3>\n";
	echo "Click <a href=\"../index.php\">here</a> to continue.\n";
	echo "</body>\n";
	echo "</html>\n";
	// eof
?>
