<?php
	//phpmyfamily - opensource genealogy webbuilder
	//Copyright (C) 2002 - 2005  Simon E Booth (simon.booth@giric.com)

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
	require_once "inc/database.inc.php";
	// connect to database
	if ($usepconnect) {
		$mysql_connect = mysql_pconnect($dbhost, $dbuser, $dbpwd) or die("phpmyfamily cannot access the database server (".$dbhost.")");
	} else {
		$mysql_connect = mysql_connect($dbhost, $dbuser, $dbpwd) or die("phpmyfamily cannot access the database server (".$dbhost.")");
	}
	
	$database_select = mysql_select_db($dbname);

	include_once "admin/configTable.php";
	
	// Check and duck out if tables already exist
	$dbcheck = mysql_list_tables($dbname);
	if (mysql_num_rows($dbcheck) <> 0) {
		while ($row = mysql_fetch_array($dbcheck)) {
			if ($row["0"] == "".$tblprefix."users" || $row["0"] == "".$tblprefix."people" || $row["0"] == "".$tblprefix."census" || $row["0"] == "".$tblprefix."spouses" || $row["0"] == "".$tblprefix."documents" || $row["0"] == "".$tblprefix."images" || $row["0"] == "".$tblprefix."tracking")
				die("phpmyfamily: Tables appear to already exist - please check you installation");
		}
	}

	echo "<html>\n";
	echo "<head>\n";
	echo "<title>Installing phpmyfamily</title>\n";
	echo "</head>\n";
	echo "<body>\n";
	echo "<h2>Installing phpmyfamily database</h2>\n";

	// install ".$tblprefix."users
	$fusers = "CREATE TABLE `".$tblprefix."users` (
  `id` smallint(6) NOT NULL auto_increment,
  `username` varchar(10) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `email` varchar(128) NOT NULL default '',
  `admin` enum('Y','N') NOT NULL default 'N',
  `edit` enum('Y','N') NOT NULL default 'N',
  `restrictdate` date NOT NULL default '0000-00-00',
  `style` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`)
) Engine = InnoDB";

	$rusers = mysql_query($fusers) or die("phpmyfamily: Error creating user table!!!");
	echo "User table created<br>\n";
	$fadmin = "INSERT INTO ".$tblprefix."users VALUES('43', 'admin', '21232f297a57a5a743894a0e4a801fc3','', 'Y', 'Y', '1910-01-01', 'default.css.php')";
	$radmin = mysql_query($fadmin) or die("phpmyfamily: Error creating default user!!!");
	echo "Default user created<br>\n";

	// install ".$tblprefix."people
	$fpeople = "CREATE TABLE `".$tblprefix."people` (
  `person_id` smallint(5) unsigned zerofill NOT NULL auto_increment,
  `death_reason` varchar(50) NOT NULL default '',
  `gender` enum('M','F') NOT NULL default 'M',
  `mother_id` smallint(5) unsigned zerofill NOT NULL default '00000',
  `father_id` smallint(5) unsigned zerofill NOT NULL default '00000',
  `narrative` longtext NOT NULL,
  `updated` timestamp NOT NULL,
  `creator_id` SMALLINT NULL ,
  `created` DATETIME NOT NULL ,
  `editor_id` SMALLINT NULL,
   INDEX `creator` ( `creator_id` ),
   INDEX `editor` ( `editor_id` ),
   FOREIGN KEY ( `creator_id` ) REFERENCES `".$tblprefix."users` (`id`),
   FOREIGN KEY ( `editor_id` ) REFERENCES `".$tblprefix."users` (`id`),
   PRIMARY KEY  (`person_id`),
   KEY `gender` (`gender`),
   KEY `idx_list_peeps1` USING BTREE (`person_id`),
   KEY `idx_list_peeps2` USING BTREE (`gender`,`person_id`),
   KEY `idx_children` USING BTREE (`mother_id`,`father_id`,`person_id`)
) Engine = InnoDB";

	$rpeople = mysql_query($fpeople) or die("phpmyfamily: Error creating people table!!!");
	echo "People table created<br>\n";
	include_once "admin/nameTable.php";
	
	$fpeeps = "INSERT INTO ".$tblprefix."people(person_id, narrative, created) VALUES ('1', '', NOW())";
	$rpeeps = mysql_query($fpeeps) or die("phpmyfamily: Error creating alpha male!!!");
	$fpeeps = "INSERT INTO ".$tblprefix."names(person_id, forenames, surname) VALUES ('1', 'Alpha Male', 'Male')";
	$rpeeps = mysql_query($fpeeps) or die("phpmyfamily: Error creating alpha male!!!");
	echo "Alpha Male created<br>\n";

	// install ".$tblprefix."spouses
	$fspouses = "CREATE TABLE `".$tblprefix."spouses` (
  `groom_id` smallint(5) unsigned zerofill NOT NULL default '00000',
  `bride_id` smallint(5) unsigned zerofill NOT NULL default '00000',
  `dissolve_date` date NOT NULL default '0000-00-00',
  `dissolve_reason` char(1) NOT NULL default '',
  `event_id` int(10) unsigned default NULL,
  `marriage_id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  USING BTREE (`marriage_id`)
) Engine = InnoDB";
	$rspouses = mysql_query($fspouses) or die("phpmyfamily: Error creating spouses table!!!");
	echo "Spouses table created<br>\n";

	// install ".$tblprefix."census
	$fcensus = "CREATE TABLE `".$tblprefix."census` (
  `person_id` smallint(5) unsigned zerofill NOT NULL default '00000',
  `census` mediumint(4) NOT NULL default '0',
  `schedule` varchar(20) NOT NULL default '',
  `census_id` int(10) unsigned NOT NULL auto_increment,
  `event_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`census_id`),
  KEY `FK_family_census_1` (`person_id`),
  KEY `FK_family_census_2` (`event_id`)
) Engine = InnoDB";
	$rcensus = mysql_query($fcensus) or die("phpmyfamily: Error creating census table!!!");
	echo "Census table created<br>\n";

	// install ",$tblprefix."census_years
	$cyquery = "CREATE TABLE `".$tblprefix."census_years` (
  `census_id` mediumint(4) NOT NULL auto_increment,
  `country` varchar(20) NOT NULL default '',
  `year` smallint(4) NOT NULL default '0',
  `census_date` DATE NOT NULL,
  `available` enum('Y','N') NOT NULL default 'Y',
  PRIMARY KEY  (`census_id`),
  KEY `available` (`available`)
) Engine = InnoDB";
	$cyresult = mysql_query($cyquery) or die("phpmyfamily: Error creating census years table!!!");
	echo "Census years table created<br>\n";

	// install ".$tblprefix."census_years values
	$cyvquery = "INSERT INTO ".$tblprefix."census_years (country, year, census_date) VALUES ('British Isles', '1841', '1841-06-06'), ('British Isles', '1851', '1851-03-30'), ('British Isles', '1861', '1861-04-07'), ('British Isles', '1871', '1871-04-02'), ('British Isles', '1881', '1881-04-03'), ('British Isles', '1891', '1891-04-05'), ('British Isles', '1901', '1901-03-31'), ('British Isles', 1911, '1911-04-02'),
		('USA', '1790', '1790-08-02'), ('USA', '1800', '1800-08-04'), ('USA', '1810', '1810-08-06'), ('USA', '1820', '1820-08-07'), ('USA', '1830', '1830-06-01'), ('USA', '1840', '1840-06-01'), ('USA', '1850', '1850-06-01'), ('USA', '1860', '1860-06-01'), ('USA', '1870', '1870-06-01'), ('USA', '1880', '1880-06-01'), ('USA', '1890', '1890-06-02'), ('USA', '1900', '1900-06-01'),
		('USA', '1910', '1910-04-15'), ('USA', '1920', '1920-01-01'), ('USA', '1930', '1930-04-01'),
		('Canada', '1842', '1842-02-01'), ('Canada', '1848', '1848-01-01'), ('Canada', '1851', '1851-01-12'), ('Canada', '1861', '1861-01-14'), ('Canada', '1871', '1871-04-02'), ('Canada', '1881', '1881-04-04'), ('Canada', '1891', '1891-04-06'), ('Canada', '1901', '1901-03-31')";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";

	// install ".$tblprefix."images
	$fimages = "CREATE TABLE `".$tblprefix."images` (
  `image_id` smallint(5) unsigned zerofill NOT NULL auto_increment,
  `title` varchar(30) NOT NULL default '',
  `event_id` INTEGER UNSIGNED DEFAULT NULL,
  `source_id` INTEGER UNSIGNED DEFAULT NULL,
  PRIMARY KEY  (`image_id`)
) Engine = InnoDB";
	$rimages = mysql_query($fimages) or die("phpmyfamily: Error creating images table!!!");
	echo "Images table created<br>\n";
	$fimg = "INSERT INTO ".$tblprefix."images (image_id) VALUES ('10000')";
	$rimg = mysql_query($fimg) or die("phpmyfamily: Error creating default image");
	echo "Default image created<br>";

	// install ".$tblprefix."documents
	$fdocs = "CREATE TABLE `".$tblprefix."documents` (
  `id` smallint(5) unsigned zerofill NOT NULL auto_increment,
  `doc_title` varchar(30) NOT NULL default '',
  `file_name` varchar(128) NOT NULL default '',
  `event_id` INTEGER UNSIGNED DEFAULT NULL,
  `source_id` INTEGER UNSIGNED DEFAULT NULL,
  PRIMARY KEY  (`id`)
) Engine = InnoDB";
	$rdocs = mysql_query($fdocs) or die("phpmyfamily: Error creating documents table!!!");
	echo "Documents table created<br>\n";

	// install tracking
	$tquery = "CREATE TABLE `".$tblprefix."tracking` (
  `person_id` smallint(5) unsigned zerofill NOT NULL default '00000',
  `email` varchar(128) NOT NULL default '',
  `key` varchar(32) NOT NULL default '',
  `action` enum('sub','unsub') NOT NULL default 'sub',
  `expires` datetime default NULL,
  UNIQUE KEY `person_id` (`person_id`,`email`)
) Engine = InnoDB";
	$tresult = mysql_query($tquery) or die("phpmyfamily: Error creating tracking table!!!");
	echo "tracking table created<br>\n";
//Create the location table
include_once "admin/locationTable.php";
include_once "admin/eventTable.php";
include_once "admin/attendeeTable.php";

$q = "ALTER TABLE `".$tblprefix."spouses` 
 ADD CONSTRAINT `FK_".$tblprefix."spouses_1` FOREIGN KEY `FK_".$tblprefix."spouses_1` (`event_id`)
    REFERENCES `".$tblprefix."event` (`event_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    ENGINE = InnoDB;";
    
if(!mysql_query($q)) {
	mysql_error();
	echo $q;
	die("phpmyfamily: Error changing spouses table");
} else {
	echo "Changed spouses table<br/>";
}

$q = "ALTER TABLE `".$tblprefix."census` 
  ADD CONSTRAINT `FK_".$tblprefix."census_1` FOREIGN KEY (`person_id`) REFERENCES `".$tblprefix."people` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_".$tblprefix."census_2` FOREIGN KEY `FK_".$tblprefix."census_2` (`event_id`)
    REFERENCES `".$tblprefix."event` (`event_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
, ENGINE = InnoDB;";
    
if(!mysql_query($q)) {
	mysql_error();
	echo $q;
	die("phpmyfamily: Error changing census table");
} else {
	echo "changed census table<br/>";
}

$q = "ALTER TABLE `".$tblprefix."documents` ADD INDEX `sourceidx` ( `source_id` ),ADD INDEX `eventidx` ( `event_id` )";
if(!mysql_query($q)) {
	mysql_error();
	echo $q;
	die("phpmyfamily: Error changing documents table");
} else {
	echo "Added indexes to documents table<br/>";
}  

include_once("sourceTable.php");
$q = "ALTER TABLE `".$tblprefix."documents` 
 ADD CONSTRAINT `FK_".$tblprefix."documents_1` FOREIGN KEY `FK_".$tblprefix."documents_1` (`event_id`)
    REFERENCES `".$tblprefix."event` (`event_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    ADD CONSTRAINT `FK_".$tblprefix."documents_2` FOREIGN KEY `FK_".$tblprefix."documents_2` (`source_id`)
    REFERENCES `".$tblprefix."source` (`source_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    ENGINE = InnoDB;";
    
if(!mysql_query($q)) {
	mysql_error();
	echo $q;
	die("phpmyfamily: Error changing documents table");
} else {
	echo "Changed documents table<br/>";
}

$q = "ALTER TABLE `".$tblprefix."images` 
 ADD CONSTRAINT `FK_".$tblprefix."images_1` FOREIGN KEY `FK_".$tblprefix."images_1` (`event_id`)
    REFERENCES `".$tblprefix."event` (`event_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    ADD CONSTRAINT `FK_".$tblprefix."images_2` FOREIGN KEY `FK_".$tblprefix."images_2` (`source_id`)
    REFERENCES `".$tblprefix."source` (`source_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    ENGINE = InnoDB;";
    
if(!mysql_query($q)) {
	mysql_error();
	echo $q;
	die("phpmyfamily: Error changing images table");
} else {
	echo "Changed images table<br/>";
}

include_once("gedcomTable.php");

	// give a link to continue
	echo "<h3>Finished!!</h3>\n";
	echo "Click <a href=\"../index.php\">here</a> to continue.  Login as (admin/admin)\n";
	echo "</body>\n";
	echo "</html>\n";
	// eof
?>