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
require_once("inc/DateUtil.php");
require_once("classes/MiniEvent.php");

error_reporting(E_ALL ^ E_NOTICE);
#Sends errors to the screen instead of the log file
//ini_set('display_errors', false);


	$gedname = $_FILES["gedfile"]["name"];
	$gedfile = $_FILES["gedfile"]["tmp_name"];
	$gedarray = array();
	$people = array();
	$indi = array();
	$family = array();
	$marriage = array();
	$text = array();
	$desc = array();
	$pref = array();
	$blocks = 0;
	$limit = 1000;

	// pick up the next auto value from table
	$query = "SHOW TABLE STATUS LIKE '".$tblprefix."people'";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result))
		$autoval = $row["Auto_increment"];
	//This is used as a guess but the actual insert id is picked up into the idmap array
	
	ini_set("auto_detect_line_endings", TRUE);


?>

<table class="header" width="100%">
  <tbody>
    <tr>
      <td><h3>Importing GedCom file: <?php echo $gedname; ?></h3>  </td>
    </tr>
  </tbody>
</table>

<br>

<!--Check we have a valid file-->
Checking uploaded file is valid:
<?php
	if (!empty($gedfile) && file_exists($gedfile)) {
		echo " OK<br>\n";
	} else {
		echo " NO!<br>\n";
		die("Error with gedcom file");
	}
	flush();
?>

<!--Read the file into an array-->
Reading in file:<br>
<?php
	$handle = fopen ($gedfile, "r");
	while (!feof ($handle)) {
    	$buffer = fgets($handle, 4096);
		// need to trim the annoying newline
		// from end of buffer
		if (substr($buffer, 0, 1) == "0")
			$blocks++;
		$gedarray[$blocks][] = rtrim($buffer);
	}
	fclose ($handle);
	echo ".....read ".($blocks - 1)." blocks<br>\n";

	$heads = 0;
	$indis = 0;
	$notes = 0;
	$fams  = 0;
	$trlrs = 0;
	$subns = 0;
	$subms = 0;
	$sours = 0;
	$repos = 0;
	$objes = 0;
	$unkno = 0;
	for ($i = 0; $i < $blocks; $i++) {
		switch (substr($gedarray[$i][0], -4)) {
			case "HEAD":
				$heads++;
				break;
			case "INDI":
				$people[$indis++] = $gedarray[$i];
				break;
			case "NOTE":
				$text[$notes++] = $gedarray[$i];
				break;
			case " FAM":
				$family[$fams++] = $gedarray[$i];
				break;
			case "TRLR":
				$trlrs++;
				break;
			case "SUBN":
				$subns++;
				break;
			case "SUBM":
				$subms++;
				break;
			case "SOUR":
				$sours++;
				break;
			case "REPO":
				$repos++;
				break;
			case "OBJE":
				$objes++;
				break;
			case "":
				break;
			default:
				$unkno++;
				break;
		}
	}

	echo ".....read ".$heads." HEADS<br>\n";
	echo ".....read ".$indis." INDIS<br>\n";
	echo ".....read ".$fams." FAMS<br>\n";
	echo ".....read ".$notes." NOTES<br>\n";
	echo ".....read ".$subns." SUBNS<br>\n";
	echo ".....read ".$subms." SUBMS<br>\n";
	echo ".....read ".$sours." SOURS<br>\n";
	echo ".....read ".$objes." OBJES<br>\n";
	echo ".....read ".$repos." REPOS<br>\n";
	echo ".....read ".$trlrs." TRLRS<br>\n";
	if ($unkno > 0) echo ".....read ".$unkno." UNKNOWS<br>\n";
	flush();
?>

<!--parse the array-->
Verifying GedCom data:
<?php
	if (in_array("1 GEDC", $gedarray[1]) && in_array("2 VERS 5.5", $gedarray[1]))
		echo " OK - correct version header found<br>\n";
	else {
		print_r($gedarray[1]);
		die ("Doesn't seem to be a valid GedCom file!");
	}
	flush();
?>

<!--parse the notes first-->
Parsing notes data:
<?php

	// process each notes block in turn
	for ($i = 0; $i < $notes; $i++) {
		$count = count($text[$i]);

		// process each line ine the block
		for ($c = 0; $c < $count; $c++) {

			if ($c == 0)
				$temp = substr($text[$i][$c], 3, strlen($text[$i][$c]) - 9);

			switch (substr($text[$i][$c], 0, 6)) {
				case "1 CONC":
				case "1 CONT":
					if (array_key_exists($temp, $desc))
						$desc[$temp] = $desc[$temp]."\n".substr($text[$i][$c], 6, strlen($text[$i][$c]) - 6);
					else
						$desc[$temp] = substr($text[$i][$c], 6, strlen($text[$i][$c]) - 6);
					break;
				default:
					break;
			}
		}
	}
	echo " OK<br>\n";
	flush();
?>

<!--parse the individual arrays-->
Parsing individual data:
<?php

	// process each individual in turn
	for ($i = 0; $i < $indis; $i++) {
		$count = count($people[$i]);

		$indi[$i]["person_id"] = ($autoval + $i - 1);
		$previous = "";
		// process each record in turn
		for ($c = 0; $c < $count; $c++) {

			if ($c == 0) {
				$temp = substr($people[$i][$c], 3, strlen($people[$i][$c]) - 9);
				$indi[$i]["ged_person_ref"] = $temp;
				$pref[$temp] = ($autoval + $i -1);
			}
			switch (substr($people[$i][$c], 0, 6)) {
				case "1 NAME":
					$indi[$i]["name"] = substr($people[$i][$c], 6, strlen($people[$i][$c]) - 6);
					break;
				case "1 SEX ":
					$indi[$i]["gender"] = substr($people[$i][$c], 6, strlen($people[$i][$c]) - 6);
					break;
				case "2 DATE":
					if ($e != null) {
						DateUtil::make_date(substr($people[$i][$c], 6, strlen($people[$i][$c]) - 6),$e);
					}
					break;
				case "2 PLAC":
					if ($e != null) {
						$e->location->place = trim(htmlentities(substr($people[$i][$c], 6, strlen($people[$i][$c]) - 6), ENT_QUOTES));
					}
					break;
				case "1 NOTE":
					if (substr($people[$i][$c], 7, 1) == "@") {
						$temp = substr($people[$i][$c], 8, strlen($people[$i][$c]) - 9);
						$indi[$i]["note"] = $desc[$temp];
					}
					else
						$indi[$i]["note"] = substr($people[$i][$c], 6, strlen($people[$i][$c]) - 6);
					break;
				case "1 FAMC":
					$indi[$i]["ged_famc"] = substr($people[$i][$c], 8, strlen($people[$i][$c]) - 9);
					break;
				case "1 FAMS":
					$indi[$i]["ged_fams"] = substr($people[$i][$c], 8, strlen($people[$i][$c]) - 9);
					break;
                                case "1 AFN": //permanent record file number of an individual record stored in Ancestral File
				case "1 _UID":
					$indi[$i]["uid"] = substr($people[$i][$c], 6, strlen($people[$i][$c]) - 6);
				default:
					break;
			}

			if (substr($people[$i][$c], 0, 1) == "1") {
				$previous = substr($people[$i][$c], 0, 6);
				$e = null;				
				switch ($previous) {
					case "1 BIRT":
						$e = new MiniEvent();
						$e->type = BIRTH_EVENT;
					break;
					case "1 DEAT":
						$e = new MiniEvent();
						$e->type = DEATH_EVENT;
					break;
                                        case "1 CONF": //Confirmation
                                        case "1 CHR": //Christening
					case "1 BAPL": //LDS BAPM
					case "1 BAPM":
						$e = new MiniEvent();
						$e->type = BAPTISM_EVENT;
						$e->descrip = substr($previous, 2);
					break;
					case "1 CREM":
					case "1 BURI":
						$e = new MiniEvent();
						$e->type = BURIAL_EVENT;
						$e->descrip = substr($previous, 2);
					break;
                                        case "1 CENS":
                                        case "1 EDUC":
                                        case "1 EMIG":
                                        case "1 EVEN":
                                        case "1 OCCU":
                                        case "1 EVEN":
						$e = new Event();
						$e->type = OTHER_EVENT;
						$e->descrip = substr($previous, 2);
					break;
				}
				if ($e != null) {
					$indi[$i]["events"][] = $e;
				}
			}
		}
	}

	echo " OK<br>\n";
	flush();
?>

<!--Parsing family data-->
Parsing marriage data:
<?php

	// process each family in turn
	for ($i = 0; $i < $fams; $i++) {
		$count = count($family[$i]);

		// process each row in turn
		$previous = "";
		for ($c = 0; $c < $count; $c++) {
			if ($c == 0)
				$marriage[$i]["ged_fam_ref"] = substr($family[$i][$c], 3, strlen($family[$i][$c]) - 8);
			switch (substr($family[$i][$c], 0, 6)) {
				case "1 HUSB":
					$temp = substr($family[$i][$c], 8, strlen($family[$i][$c]) - 9);
					$marriage[$i]["groom_id"] = $pref[$temp];
					$marriage[$i]["ged_husb_ref"] = $temp;
					break;
				case "1 WIFE":
					$temp = substr($family[$i][$c], 8, strlen($family[$i][$c]) - 9);
					$marriage[$i]["bride_id"] = $pref[$temp];
					$marriage[$i]["ged_wife_ref"] = $temp;
					break;
				case "2 DATE":
					if ($previous == "1 MARR")
						DateUtil::make_date(substr($family[$i][$c], 6, strlen($family[$i][$c]) - 6), $e);
					break;
				case "2 PLAC":
					if ($previous == "1 MARR")
						$e->location->place = trim(substr($family[$i][$c], 6, strlen($family[$i][$c]) - 6));
					break;
				default:
					break;
			}
			if (substr($family[$i][$c], 0, 1) == "1") {
				$previous = substr($family[$i][$c], 0, 6);
				$e = new MiniEvent();
				$marriage[$i]["event"] = $e;
			}
		}
		$parents[$marriage[$i]["ged_fam_ref"]] = $marriage[$i];
	}

	echo " OK<br>\n";
	flush();
?>

<!--Sort and insert person data-->
Inserting person data:
<?php
	$dao = getPeopleDAO();
	$t = 0;
	$idmap["0"] = "0";
	$break = 0;
	
while ($indis > 0) {
	for ($i = 0; $i < $indis; $i++) {
		$person = $indi[$i];
		// do some sanity checking
		if (!array_key_exists("name", $person))
			$person["name"] = "";
		if (!array_key_exists("gender", $person))
			$person["gender"] = "";
		if (!array_key_exists("note", $person))
			$person["note"] = "";
		if (!array_key_exists("father_id", $person))
			$person["father_id"] = "0";
		if (!array_key_exists("mother_id", $person))
			$person["mother_id"] = "0";
		
		$per = new PersonDetail();
		if (isset($person["events"])) {
			$per->events = $person["events"];
		} else {
			$per->events = array();
		}
	
		$per->gender = $person["gender"];
		$per->narrative = htmlspecialchars($person["note"], ENT_QUOTES);
		list($per->name->forenames,$per->name->surname,$per->name->suffix) = explode("/", htmlentities($person["name"],ENT_QUOTES));
		$per->name->forenames = trim($per->name->forenames);
		$per->name->surname = trim($per->name->surname);
		$per->name->suffix = trim($per->name->suffix);
		$per->mother->person_id = $person["mother_id"] ;
		$per->father->person_id = $person["father_id"] ;
		if (isset($person["ged_famc"])) {
			$fam = $parents[$person["ged_famc"]];
			$mid = $fam["ged_wife_ref"];
			$fid = $fam["ged_husb_ref"];
			$missingParents = false;
			if ((isset($fam["ged_wife_ref"]) && !isset($idmap[$mid])) ||
				(isset($fam["ged_husb_ref"]) && !isset($idmap[$fid]))) {
				if ($break < 2) {
					continue;
				} else {
					$missingParents = true;
				}
			}
			@$per->mother->person_id = $idmap[$mid];
			@$per->father->person_id = $idmap[$fid];
		}
		$resave = false;
		if (isset($idmap[$person["ged_person_ref"]])) {
			$per->person_id = $idmap[$person["ged_person_ref"]];
			$resave = true;
		}
//		print_r($per);
		if ($dao->savePersonDetails($per)) {
			$idmap[$person["ged_person_ref"]] = $per->person_id;
			@$uid[$person["ged_person_ref"]] = $indi[$i]["uid"];
			if (!$missingParents) {
				unset($indi[$i]);
			}
			$t++;
		} else {
			if (!$resave) {
				echo "Failed to save";
				print_r($per);
			}
		}
	}
	$x = array_values($indi);
	$indi = $x;
	$x = null;
	$oldindis = $indis;
	$indis = count($indi);

	if ($oldindis == $indis) {
		if ($break <= 1) {
			$x = array_reverse($indi);
			$indi = $x;
		}
		if ($break > 3) {
			break;
		}
		$break++;
	} else {
		$break = 0;
	}
}
	echo "$t people inserted OK<br>\n";
	if ($indis > 0) {
		echo "$indis people failed to insert OK<br>\n";
		print_r($indis);
	}
	flush();
?>

<!--sort and insert marriages-->
Inserting marriage data:
<?php
	$t = 0;

	for ($i = 0; $i < $fams; $i++) {
		if (!array_key_exists("groom_id", $marriage[$i])) {
			print_r($marriage[$i]);
			continue;
		}
		if (!array_key_exists("bride_id", $marriage[$i])) {
			print_r($marriage[$i]);
			continue;
		}
		if (!array_key_exists("dom", $marriage[$i]))
			$marriage[$i]["dom"] = "0000-00-00";
		if (!array_key_exists("place", $marriage[$i]))
			$marriage[$i]["place"] = "";
		if (!isset($idmap[$marriage[$i]["ged_husb_ref"]]) || !isset($idmap[$marriage[$i]["ged_wife_ref"]])) {
			echo "Missing spouse data for:";
			print_r($marriage[$i]);
			continue;
		}
		$rel = new Relationship();
		$rel->person->gender = "M";
		$rel->person->person_id = $idmap[$marriage[$i]["ged_husb_ref"]];
		$rel->relation->person_id = $idmap[$marriage[$i]["ged_wife_ref"]];
		$e = new Event();
		$e->type = MARRIAGE_EVENT;
		$e->person = $rel->person;
		$e->date1 = $marriage[$i]["dom"];
		$e->location->place = htmlspecialchars($marriage[$i]["place"], ENT_QUOTES);
		$rel->event = $e;
		if ($rel->dissolve_date == "") $rel->dissolve_date = "0000-00-00" ;
		$dao = getRelationsDAO();
		$dao->saveRelationshipDetails($rel);
		// inc the counter
		$t++;
	}

	echo " OK<br>\n";
	echo " $t marriages inserted<br>\n";
	
	include_once "modules/gedcom/GedcomDAO.php";
	$gdao = new GedcomDAO();
	
	foreach ($idmap as $ged => $db) {
		if ($db > 0) {
			$gdao->insertReference($ged, $idmap[$ged], $gedname, $uid[$ged]);
		}
	}
?>

Done!!!!!!(Phew)<br>
<br>
Click <a href="index.php">here</a> to return to the homepage.<br>