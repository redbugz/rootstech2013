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
//	$dbcheck = mysql_list_tables($dbname);
//	if (mysql_num_rows($dbcheck) <> 0) {
//		while ($row = mysql_fetch_array($dbcheck)) {
//			if ($row["0"] == "".$tblprefix."tracking")
//				die("phpmyfamily: Upgrade seems to already have been run - please check you installation");
//		}
//	}

	echo "<html>\n";
	echo "<head>\n";
	echo "<title>Upgrading phpmyfamily</title>\n";
	echo "</head>\n";
	echo "<body>\n";
	echo "<h2>Upgrading phpmyfamily database</h2>\n";

	// alter the users table
	$uquery = "ALTER TABLE `".$tblprefix."users` ADD `email` VARCHAR(128) NOT NULL AFTER `password`, ADD `edit` ENUM('Y','N') DEFAULT 'N' NOT NULL, ADD `restrictdate` DATE NOT NULL, ADD `style` VARCHAR(40) NOT NULL";
	$uresult = mysql_query($uquery) or die("phpmyfamily: Error altering users table!!!");
	$uquery = "UPDATE ".$tblprefix."users SET style = 'default.css.php', edit = 'Y'";
	$uresult = mysql_query($uquery) or die("phpmyfamily: Error altering users table!!!");
	echo "users table altered<br>\n";

	// alter person table
	$pquery = "ALTER TABLE `".$tblprefix."people` ADD `suffix` VARCHAR( 10 ) NOT NULL AFTER `surname`";
	$presult = mysql_query($pquery) or die(mysql_error());
	echo "Person table altered";

	// give a link to continue
	echo "<h3>Finished!!</h3>\n";
	echo "Click <a href=\"../index.php\">here</a> to continue.\n";
	echo "</body>\n";
	echo "</html>\n";
	// eof
?>
