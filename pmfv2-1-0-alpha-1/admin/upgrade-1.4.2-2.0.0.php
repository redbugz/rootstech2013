<?php
set_include_path('..');
require_once "inc/database.inc.php";

class tmp {
function setDateFormat() {
}
}
$currentRequest = new tmp();

function check_cookies() {
}
function mysql_connect_wrapper() {
	global $usepconnect, $dbhost, $dbuser, $dbpwd, $dbname;
		// connect to database
	if ($usepconnect) {
		if (!($mysql_connect = mysql_pconnect($dbhost, $dbuser, $dbpwd))) {
			error_log(mysql_error());
			die("phpmyfamily cannot access the database server (".$dbhost.")");
		}
	} else {
		if (!($mysql_connect = mysql_connect($dbhost, $dbuser, $dbpwd))) {
			error_log(mysql_error());
			die("phpmyfamily cannot access the database server (".$dbhost.")");
		}
	}
	
	$database_select = mysql_select_db($dbname);

	return ($database_select);
}

include_once "inc/config.inc.php";

//Create the config table
include_once "admin/configTable.php";

if(!$usepconnect) {
	mysql_close();
}

include_once "modules/db/DAOFactory.php";

list($dir,$file) = explode('/',$lang);
list($locale,$a,$b) = explode('.',$file);

$q = "UPDATE ".$tblprefix."config SET `email` = '$email',
`mailto` = '$mailto',
`desc` = '$desc',
`styledir` = '$styledir',
`defaultstyle` = '$defaultstyle',
`lang` = '$locale',
`timing` = ".($timing?1:0).",
`gedcom` = ".($gedcom?1:0).",
`restricttype` = ".($dynamicrestrict?1:0).",
`restrictyears` = $restrictyears,
`tracking` = ".($tracking?1:0).",
`trackemail` = '$trackemail',
`absurl` = '$absurl',
`bbtracking` = ".($bbtracking?1:0).",
`img_max` = $img_max,
`img_min` = $img_min";

if(!mysql_query($q)) {
	echo mysql_error();
	die("phpmyfamily: Error saving current config");
} else {
	echo "Old config values stored in database<br/>";
}

$q = 'ALTER TABLE `'.$tblprefix.'people` ENGINE = InnoDB';

if(!mysql_query($q)) {
	echo $q;
	echo mysql_error();
	echo "Can't change people table to InnoDB";
}

include_once "admin/nameTable.php";

$q = "INSERT INTO `".$tblprefix."names` (person_id, forenames, surname, suffix) ".
    "SELECT person_id, TRIM(TRAILING surname FROM name) AS forenames, surname, suffix ".
    "FROM `".$tblprefix."people`";
    
if(!mysql_query($q)) {
	echo mysql_error();
	die("phpmyfamily: Error migrating names");
} else {
	echo "Names migrated<br/>";
}

//Create the location table
include_once "admin/locationTable.php";
include_once "admin/eventTable.php";
include_once "admin/attendeeTable.php";

$q = "INSERT INTO `".$tblprefix."locations` (place, name) ".
    "SELECT DISTINCT birth_place,birth_place ".
    "FROM ".$tblprefix."people p LEFT JOIN ".$tblprefix."locations l ON p.birth_place = l.place".
    " WHERE location_id IS NULL AND birth_place <> ''";
    
if(!mysql_query($q)) {
	echo mysql_error();
	echo $q;
	die("phpmyfamily: Error migrating birth places");
} else {
	echo "birth places migrated<br/>";
}

$q = "INSERT INTO `".$tblprefix."event` (person_id, etype, date1, d1type, location_id, certified) ".
    " SELECT person_id, ".BIRTH_EVENT.", date_of_birth, 0, location_id, birth_cert ".
    " FROM ".$tblprefix."people p".
    " LEFT JOIN ".$tblprefix."locations l ON p.birth_place = l.place";
    
if(!mysql_query($q)) {
	echo mysql_error();
	echo $q;
	die("phpmyfamily: Error migrating birth dates");
} else {
	echo "birth dates migrated<br/>";
}


$q = "INSERT INTO `".$tblprefix."event` (person_id, etype, date1, d1type, certified) ".
    " SELECT person_id, ".DEATH_EVENT.", date_of_death, 0, death_cert ".
    " FROM ".$tblprefix."people p";
    
if(!mysql_query($q)) {
	echo mysql_error();
	die("phpmyfamily: Error migrating death dates");
} else {
	echo "death dates migrated<br/>";
}

$q = "ALTER TABLE `".$tblprefix."spouses` ADD COLUMN `event_id` INTEGER UNSIGNED DEFAULT NULL,
 ADD CONSTRAINT `FK_".$tblprefix."spouses_1` FOREIGN KEY `FK_".$tblprefix."spouses_1` (`event_id`)
    REFERENCES `".$tblprefix."event` (`event_id`),
    ADD COLUMN `marriage_id` INTEGER UNSIGNED NOT NULL DEFAULT NULL AUTO_INCREMENT,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`marriage_id`),
    ENGINE = InnoDB;";
    
if(!mysql_query($q)) {
	echo mysql_error();
	echo $q;
	die("phpmyfamily: Error changing spouses table");
} else {
	echo "Changed spouses table<br/>";
}


$q = "ALTER TABLE `".$tblprefix."event` ADD COLUMN `marriage_id` INTEGER UNSIGNED DEFAULT NULL";
    
if(!mysql_query($q)) {
	echo mysql_error();
	die("phpmyfamily: Error adding marriage_id column to event");
} else {
	echo "added marriage_id column to event<br/>";
}
 
$q = "INSERT INTO `".$tblprefix."locations` (place, name) ".
    "SELECT DISTINCT marriage_place, marriage_place ".
    "FROM ".$tblprefix."spouses sp LEFT JOIN ".$tblprefix."locations l ON sp.marriage_place = l.place".
    " WHERE location_id IS NULL  AND marriage_place <> ''";
    
if(!mysql_query($q)) {
	echo mysql_error();
	echo $q;
	die("phpmyfamily: Error migrating marriage places");
} else {
	echo "marriage places migrated<br/>";
}

$q = "INSERT INTO `".$tblprefix."event` (etype, date1, d1type, location_id, certified, marriage_id) ".
    " SELECT ".MARRIAGE_EVENT.", marriage_date, 0, location_id, marriage_cert, marriage_id ".
    " FROM ".$tblprefix."spouses sp".
    " LEFT JOIN ".$tblprefix."locations l ON sp.marriage_place = l.place";
    
if(!mysql_query($q)) {
	echo $q;
	echo mysql_error();
	die("phpmyfamily: Error migrating weddings");
} else {
	echo "weddings migrated<br/>";
}

$q = "UPDATE ".$tblprefix."spouses,".$tblprefix."event SET ".$tblprefix."spouses.event_id=".$tblprefix."event.event_id WHERE ".$tblprefix."event.marriage_id = ".$tblprefix."spouses.marriage_id";
    
if(!mysql_query($q)) {
	echo mysql_error();
	echo $q;
	die("phpmyfamily: Error moving marriage event ids");
} else {
	echo "moved marriage event ids<br/>";
}

$q = "ALTER TABLE `".$tblprefix."event` DROP COLUMN `marriage_id`";
    
if(!mysql_query($q)) {
	echo mysql_error();
	die("phpmyfamily: Error removing marriage_id column to event");
} else {
	echo "removed marriage_id column to event<br/>";
}

$q = "ALTER TABLE `".$tblprefix."census` ADD COLUMN `census_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
 ADD COLUMN `event_id` INTEGER UNSIGNED NOT NULL,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY (`census_id`),
 ADD CONSTRAINT `FK_".$tblprefix."census_1` FOREIGN KEY `FK_".$tblprefix."census_1` (`person_id`)
    REFERENCES `".$tblprefix."people` (`person_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  ENGINE = InnoDB;";
    
if(!mysql_query($q)) {
	echo mysql_error();
	echo $q;
	die("phpmyfamily: Error changing census table");
} else {
	echo "changed census table<br/>";
}

$q = "ALTER TABLE `".$tblprefix."event` ADD COLUMN `census_id` INTEGER UNSIGNED DEFAULT NULL";
    
if(!mysql_query($q)) {
	echo mysql_error();
	die("phpmyfamily: Error adding census_id column to event");
} else {
	echo "added census_id column to event<br/>";
}

$q = "INSERT INTO `".$tblprefix."locations` (place, name) ".
    "SELECT DISTINCT address, address ".
    "FROM ".$tblprefix."census cen LEFT JOIN ".$tblprefix."locations l ON cen.address = l.place".
    " WHERE location_id IS NULL  AND address <> ''";
    
if(!mysql_query($q)) {
	echo mysql_error();
	echo $q;
	die("phpmyfamily: Error migrating census places");
} else {
	echo "census places migrated<br/>";
}


$q = "ALTER TABLE `".$tblprefix."census_years` ADD COLUMN `census_date` DATE NOT NULL";
if(!mysql_query($q)) {
	echo mysql_error();
	echo $q;
	die("phpmyfamily: Error changing census years table");
} else {
	echo "changed census years table<br/>";
}  
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1841-06-06' WHERE country='British Isles'  AND year = '1841'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1851-03-30' WHERE country='British Isles'  AND year = '1851'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1861-04-07' WHERE country='British Isles'  AND year = '1861'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1871-04-02' WHERE country='British Isles'  AND year = '1871'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1881-04-03' WHERE country='British Isles'  AND year = '1881'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1891-04-05' WHERE country='British Isles'  AND year = '1891'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1901-03-31' WHERE country='British Isles'  AND year = '1901'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1790-08-02' WHERE country='USA'  AND year = '1790'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1800-08-04' WHERE country='USA'  AND year = '1800'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1810-08-06' WHERE country='USA'  AND year = '1810'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1820-08-07' WHERE country='USA'  AND year = '1820'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1830-06-01' WHERE country='USA'  AND year = '1830'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1840-06-01' WHERE country='USA'  AND year = '1840'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1850-06-01' WHERE country='USA'  AND year = '1850'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1860-06-01' WHERE country='USA'  AND year = '1860'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1870-06-01' WHERE country='USA'  AND year = '1870'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1880-06-01' WHERE country='USA'  AND year = '1880'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1890-06-02' WHERE country='USA'  AND year = '1890'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1900-06-01' WHERE country='USA'  AND year = '1900'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1910-04-15' WHERE country='USA'  AND year = '1910'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1920-01-01' WHERE country='USA'  AND year = '1920'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1930-04-01' WHERE country='USA'  AND year = '1930'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1842-02-01' WHERE country='Canada'  AND year = '1842'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1848-01-01' WHERE country='Canada'  AND year = '1848'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1851-01-12' WHERE country='Canada'  AND year = '1851'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1861-01-14' WHERE country='Canada'  AND year = '1861'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1871-04-02' WHERE country='Canada'  AND year = '1871'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1881-04-04' WHERE country='Canada'  AND year = '1881'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1891-04-06' WHERE country='Canada'  AND year = '1891'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";
  $cyvquery = "UPDATE ".$tblprefix."census_years SET census_date='1901-03-31' WHERE country='Canada'  AND year = '1901'";
	$cyvresult = mysql_query($cyvquery) or die("phpmyfamily: Error creating census years values!!!");
	echo "Census years values created<br>\n";

$q = "INSERT INTO `".$tblprefix."event` (etype, person_id, date1, d1type, location_id, census_id) ".
    " SELECT ".CENSUS_EVENT.", person_id, census_date, 0, location_id, c.census_id ".
    " FROM ".$tblprefix."census c".
    " JOIN ".$tblprefix."census_years cy ON cy.census_id = c.census".
    " LEFT JOIN ".$tblprefix."locations l ON c.address = l.place";
    
if(!mysql_query($q)) {
	echo $q;
	echo mysql_error();
	die("phpmyfamily: Error migrating census");
} else {
	echo "census migrated<br/>";
}

$q = "UPDATE ".$tblprefix."census,".$tblprefix."event SET ".$tblprefix."census.event_id=".$tblprefix."event.event_id WHERE ".$tblprefix."event.census_id = ".$tblprefix."census.census_id";
    
if(!mysql_query($q)) {
	echo mysql_error();
	echo $q;
	die("phpmyfamily: Error moving census event ids");
} else {
	echo "moved census event ids<br/>";
}

$q = "ALTER TABLE `".$tblprefix."event` DROP COLUMN `census_id`";
    
if(!mysql_query($q)) {
	echo mysql_error();
	die("phpmyfamily: Error removing census_id column from event");
} else {
	echo "removed census_id column from event<br/>";
}

$q = "ALTER TABLE `".$tblprefix."census` 
 ADD CONSTRAINT `FK_".$tblprefix."census_2` FOREIGN KEY `FK_".$tblprefix."census_2` (`event_id`)
    REFERENCES `".$tblprefix."event` (`event_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
, ENGINE = InnoDB;";
    
if(!mysql_query($q)) {
	echo mysql_error();
	echo $q;
	die("phpmyfamily: Error changing census table");
} else {
	echo "changed census table<br/>";
}

$q = "INSERT INTO `".$tblprefix."locations` (place, name) ".
    "SELECT DISTINCT where_born, where_born ".
    "FROM ".$tblprefix."census cen LEFT JOIN ".$tblprefix."locations l ON cen.where_born = l.place".
    " WHERE location_id IS NULL  AND where_born <> ''";
    
if(!mysql_query($q)) {
	echo mysql_error();
	echo $q;
	die("phpmyfamily: Error migrating census birth places");
} else {
	echo "census birth places migrated<br/>";
}

$q = "INSERT INTO `".$tblprefix."attendee` (event_id,person_id, age,profession,r_status, location_id, notes) ".
    " SELECT event_id, person_id, age, profession, `condition`, l.location_id, other_details ".
    " FROM ".$tblprefix."census c".
    " LEFT JOIN ".$tblprefix."locations l ON c.where_born = l.place";
    
if(!mysql_query($q)) {
	echo $q;
	echo mysql_error();
	die("phpmyfamily: Error migrating people");
} else {
	echo "census people migrated<br/>";
}

$q = "SELECT f.attendee_id,f.event_id, e.reference, e.location_id, e.date1 FROM ".$tblprefix."attendee f
JOIN ".$tblprefix."census c ON f.event_id = c.event_id
JOIN ".$tblprefix."event e ON f.event_id = e.event_id
LEFT JOIN ".$tblprefix."event b ON b.person_id = f.person_id AND b.etype = 0
where e.reference <> '' OR e.location_id is not null
order by e.reference, e.location_id, e.date1, b.date1";

if($result = mysql_query($q)) {
	$ref = '';
	$oldref = '';
	$oldloc = '';
	$oldref = '';
	while($row = mysql_fetch_array($result)) {
		//if reference and location id are equal
		$ref = $row["reference"];
		$loc = $row["location_id"];
		$event = $row["event_id"];
		if ($ref == $oldref && $loc == $oldloc && $ref <> '') {
			mysql_query("UPDATE ".$tblprefix."attendee SET event_id = ".$oldevent." WHERE event_id = ".$event);
			mysql_query("DELETE FROM ".$tblprefix."event WHERE event_id = ".$event);
		} else {
			$oldref = $ref;
			$oldloc = $loc;
			$oldevent = $event;
		}
	} 
}

?>