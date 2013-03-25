<?php
set_include_path('..');
require_once "inc/database.inc.php";
require_once "classes/Base.php";
require_once "classes/Event.php";
if (!($mysql_connect = mysql_connect($dbhost, $dbuser, $dbpwd))) {
	error_log(mysql_error());
	die("phpmyfamily cannot access the database server (".$dbhost.")");
}

$database_select = mysql_select_db($dbname);

$q = " ALTER TABLE `".$tblprefix."users`  ENGINE = InnoDB ";
if(!mysql_query($q)) {
	mysql_error();
	echo $q;
	die("phpmyfamily: Error changing users table");
} else {
	echo "Users table modified<br/>";
}

$q = "ALTER TABLE `".$tblprefix."people` ADD `creator_id` SMALLINT NULL ,
ADD `created` DATETIME NOT NULL ,
ADD `editor_id` SMALLINT NULL;";
$q1 = "ALTER TABLE `".$tblprefix."people` 
ADD INDEX `creator` ( `creator_id` ),
ADD INDEX `editor` ( `editor_id` ),
ADD FOREIGN KEY ( `creator_id` ) REFERENCES `".$tblprefix."users` (`id`),
ADD FOREIGN KEY ( `editor_id` ) REFERENCES `".$tblprefix."users` (`id`);";

if(!mysql_query($q)) {
	mysql_error();
	echo $q;
	die("phpmyfamily: Error modifying people table");
} else {
	echo "People table modified<br/>";
}


//date, title,description
$q = "ALTER TABLE `".$tblprefix."images` ADD COLUMN `event_id` INTEGER UNSIGNED DEFAULT NULL,
ADD COLUMN `source_id` INTEGER UNSIGNED DEFAULT NULL;";
    
if(!mysql_query($q)) {
	echo mysql_error();;
	die("phpmyfamily: Error adding event_id column to images");
} else {
	echo "added event_id column to images<br/>";
}

$q = "ALTER TABLE `".$tblprefix."event` ADD COLUMN `image_id` INTEGER UNSIGNED DEFAULT NULL";
    
if(!mysql_query($q)) {
	echo mysql_error();;
	die("phpmyfamily: Error adding image_id column to event");
} else {
	echo "added image_id column to event<br/>";
}

$q = "INSERT INTO `".$tblprefix."event` (person_id, etype, date1, d1type, descrip, certified, image_id) ".
    " SELECT person_id,".IMAGE_EVENT.", date, 0, description, 'N', image_id ".
    " FROM ".$tblprefix."images where person_id > 0";
    
if(!mysql_query($q)) {
	echo $q;
	echo mysql_error();;
	die("phpmyfamily: Error migrating images");
} else {
	echo "images migrated<br/>";
}

$q = "UPDATE ".$tblprefix."images,".$tblprefix."event SET ".$tblprefix."images.event_id=".$tblprefix."event.event_id WHERE ".$tblprefix."event.image_id = ".$tblprefix."images.image_id";
    
if(!mysql_query($q)) {
	echo mysql_error();;
	echo $q;
	die("phpmyfamily: Error moving image event ids");
} else {
	echo "moved image event ids<br/>";
}

$q = "ALTER TABLE `".$tblprefix."event` DROP COLUMN `image_id`";
    
if(!mysql_query($q)) {
	echo mysql_error();;
	die("phpmyfamily: Error removing image_id column from event");
} else {
	echo "removed image_id column from event<br/>";
}

$q = "ALTER TABLE `".$tblprefix."images` DROP COLUMN `person_id`,
 DROP COLUMN `date`,
 DROP COLUMN `description`;";
    
if(!mysql_query($q)) {
	echo mysql_error();;
	echo $q;
	die("phpmyfamily: Error removing columns from images");
} else {
	echo "removed columns from images<br/>";
}

//date, title,description
$q = "ALTER TABLE `".$tblprefix."documents` ADD COLUMN `event_id` INTEGER UNSIGNED DEFAULT NULL,
ADD COLUMN `source_id` INTEGER UNSIGNED DEFAULT NULL;";
    
if(!mysql_query($q)) {
	echo mysql_error();;
	die("phpmyfamily: Error adding event_id column to documents");
} else {
	echo "added event_id column to documents<br/>";
}

$q = "ALTER TABLE `".$tblprefix."event` ADD COLUMN `doc_id` INTEGER UNSIGNED DEFAULT NULL";
    
if(!mysql_query($q)) {
	echo mysql_error();;
	die("phpmyfamily: Error adding doc_id column to event");
} else {
	echo "added image_id column to event<br/>";
}

$q = "INSERT INTO `".$tblprefix."event` (person_id, etype, date1, d1type, descrip, certified, doc_id) ".
    " SELECT person_id,".DOC_EVENT.", doc_date, 0, doc_description, 'N', id ".
    " FROM ".$tblprefix."documents";
    
if(!mysql_query($q)) {
	echo $q;
	echo mysql_error();;
	die("phpmyfamily: Error migrating documents");
} else {
	echo "documents migrated<br/>";
}

$q = "UPDATE ".$tblprefix."documents,".$tblprefix."event SET ".$tblprefix."documents.event_id=".$tblprefix."event.event_id WHERE ".$tblprefix."event.doc_id = ".$tblprefix."documents.id";
    
if(!mysql_query($q)) {
	echo mysql_error();;
	echo $q;
	die("phpmyfamily: Error moving doc event ids");
} else {
	echo "moved doc event ids<br/>";
}

$q = "ALTER TABLE `".$tblprefix."event` DROP COLUMN `doc_id`";
    
if(!mysql_query($q)) {
	echo mysql_error();;
	die("phpmyfamily: Error removing doc_id column from event");
} else {
	echo "removed doc_id column from event<br/>";
}

$q = "ALTER TABLE `".$tblprefix."documents` DROP COLUMN `person_id`,
 DROP COLUMN `doc_date`,
 DROP COLUMN `doc_description`;";
    
if(!mysql_query($q)) {
	echo mysql_error();;
	echo $q;
	die("phpmyfamily: Error removing columns from documents");
} else {
	echo "removed columns from documents<br/>";
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
$q = "ALTER TABLE `".$tblprefix."names` ADD FOREIGN KEY ( `person_id` ) REFERENCES `".$tblprefix."people` (
`person_id`
);";
if(!mysql_query($q)) {
	mysql_error();
	echo $q;
	die("phpmyfamily: Error adding fk to names table");
} else {
	echo "Added FK to names table<br/>";
}

include_once("gedcomTable.php");
mysql_close();
?>