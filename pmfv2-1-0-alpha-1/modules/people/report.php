<?php
	$search = new PersonDetail();
	$search->queryType = Q_TYPE;
	$search->person_id = 0;
	$search->gender = 'A';
	$search->count = 1000;
	
	$search->order = "b.date1, d.date1";
	$type = "";
	switch ($_REQUEST["type"]) {
		case 1:
			$type = $strDOB;
			$search->filter = "MONTH(b.date1) = 0";
		break;
		case 2:
			$type = $strDOD;
			$search->filter = "MONTH(d.date1) = 0";
		break;
		case 3:
			$type = $strMother;
			$search->filter = "mother_id = 0";
		break;
		case 4:
			$type = $strFather;
			$search->filter = "father_id = 0";
		break;
	}
	
	$dao = getPeopleDAO();
	$dao->getPersonDetails($search);
	
	
	echo "<h1>".$strMissing." ".$type."</h1>";
	
	echo "<ul>";
	foreach ($search->results AS $p) {
		echo "<li>".$p->getFullLink()."</li>";
	}
	echo "</ul>";
?>
