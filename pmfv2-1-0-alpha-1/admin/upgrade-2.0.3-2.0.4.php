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

$q = " ALTER TABLE `".$tblprefix."config` ADD `smtp_host` VARCHAR( 32 ) NOT NULL ,
ADD `smtp_user` VARCHAR( 32 ) NOT NULL ,
ADD `smtp_password` VARCHAR( 32 ) NOT NULL ,
ADD `recaptcha_public` VARCHAR( 50 ) NOT NULL ,
ADD `recaptcha_private` VARCHAR( 50 ) NOT NULL ";
if(!mysql_query($q)) {
	mysql_error();
	echo $q;
	die("phpmyfamily: Error changing config table");
} else {
	echo "Config table modified<br/>";
}


mysql_close();
?>