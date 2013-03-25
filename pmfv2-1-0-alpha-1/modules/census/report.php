<?php
	
	
	$dao = getCensusDAO();
	$filter = 0;
	if (isset($_REQUEST["filter"])) { $filter = $_REQUEST["filter"]; } 
	$countries = $dao->getCensusCountries($filter);
	echo "<h1>".$strMissing." ".$strCensusRecs."</h1>";
	foreach ($countries AS $c) {
		echo "<h2>".$c."</h2>";
		$years = $dao->getCensusYears($c);
		$cen = new CensusDetail();
		foreach ($years AS $y) {
			echo '<h3>'.$y->year."</h3>\n";
			$peeps = $dao->getMissingRecords($y);
			echo "<ul>";
			foreach ($peeps AS $p) {
				echo "<li>".$p->getLink()."</li>";
			}
			echo "</ul>";
		}
		echo "<hr/>";
	}
?>