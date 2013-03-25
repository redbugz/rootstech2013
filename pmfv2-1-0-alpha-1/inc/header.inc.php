<?php

	function do_headers_dojo($title, $extra = '') {
		
		$config = Config::getInstance();
		if ($config->dojo) {
		$ext = "<link rel='stylesheet' href='http://ajax.googleapis.com/ajax/libs/dojo/1.8.1/dijit/themes/tundra/tundra.css'>
<link rel='stylesheet' href='http://ajax.googleapis.com/ajax/libs/dojo/1.8.1/dojo/resources/dojo.css'>
<script>dojoConfig = {parseOnLoad: true}</script>
<script src=\"//ajax.googleapis.com/ajax/libs/dojo/1.8.1/dojo/dojo.js\"></script>
    <script language=\"JavaScript\" type=\"text/javascript\">
		require([\"dojo/parser\"]);
    </script>";
		} else {
			$ext = "";
		}
		$ext .= $extra;
		do_headers($title, $ext);
	}
	// function: do_headers
	// Standardize the html headers
	function do_headers($title, $extra = '') {
		global $clang;
		global $dir;
		global $charset;
		$config = Config::getInstance();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $clang; ?>" lang="<?php echo $clang; ?>" dir="<?php echo $dir; ?>">
<head>
<?php echo $extra;?>
<link href="css/bootstrap.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/bootstrap-responsive.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $config->styledir; ?>default.css.php" type="text/css" />
<link rel="stylesheet" href="<?php echo $config->styledir.$_SESSION["style"]; ?>" type="text/css" />
<link rel="shortcut icon" href="images/favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $config->desc; ?>" />
<meta name="page-topic" content="Genealogy" />
<meta name="audience" content="All" />
<meta name="robots" content="INDEX,FOLLOW" />
<meta name="keywords" content="Genealogy phpmyfamily<?php
	$dao = getPeopleDAO();
	$surnames = $dao->getSurnames();
	foreach($surnames AS $per) {
		echo " ".$per->name->surname;
	}
?>" />
<title><?php echo $title; ?></title>
</head><?php
		// make titles available for later,
		$GLOBALS["title"] = $title;
	}	// end of do_headers()
	
		// function: user_opts
	// display option to users in banner
	function user_opts($person = 0) {
		global $strTrack, $strTracking, $strThisPerson, $tblprefix;
		global $strLoggedIn, $strHome, $strLogout, $strPreferences;
		global $strAdd, $strNewPerson, $strLogin, $strRecoverPwd, $strStop;
		global $strLoggedOut, $strReport, $currentRequest, $strCompleteGedcom;

echo '<div id="useroptions"><ul>';
		if ($currentRequest->id != 0) {
			echo "<li>".$strLoggedIn."'".$currentRequest->name."'</li>";
			echo "<li><a href=\"index.php\" class=\"hd_link\">".$strHome."</a></li>";
			echo "<li><a href=\"passthru.php?func=logout\" class=\"hd_link\">".$strLogout."</a></li>";
			echo "<li><a href=\"my.php\" class=\"hd_link\">".$strPreferences."</a></li>";
			if ($_SESSION["editable"] == "Y") {
				echo "<li><a href=\"report.php\" class=\"hd_link\">".$strReport."</a></li>";
				echo "<li><a href=\"edit.php?func=add&amp;area=people\" class=\"hd_link\">".$strAdd." ".$strNewPerson."</a></li>";
				echo "<li><a href=\"gedcom.php\" class=\"hd_link\">".$strCompleteGedcom."</a></li>";
			}
			if ($person != 0) {
				$tdao = getTrackingDAO();
				
				if ($tdao->isTracked($currentRequest->email, $person)) {
					echo "<li><a href=\"passthru.php?func=track&amp;action=dont&amp;person=".$person."\" class=\"hd_link\">".$strStop." ".strtolower($strTracking)." ".$strThisPerson."</a></li>";
				} else {
					echo "<li><a href=\"passthru.php?func=track&amp;action=do&amp;person=".$person."\" class=\"hd_link\">".$strTrack." ".$strThisPerson."</a></li>";
				}
			}
		} else {
			echo "<li>".$strLoggedOut."</li>";
			echo "<li><a href=\"index.php\" class=\"hd_link\">".$strHome."</a></li>";
			echo "<li><a href=\"my.php\" class=\"hd_link\">".$strLogin."</a></li>";
			echo "<li><a href=\"my.php?state=lost\" class=\"hd_link\">".$strRecoverPwd."</a></li>";
			if ($person != 0) {
				echo "<li><a href=\"track.php?person=".$person."\" class=\"hd_link\">".$strTrack." ".$strThisPerson." </a></li>";
			}
		}
		echo "</ul></div>";
	}	// end of user_opts()
?>
