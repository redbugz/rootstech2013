<?php
set_include_path("..");
include_once("modules/db/DAOFactory.php");

//header("Content-Type", "text/json");

?>
{}&&{identifier:"locationid",
items: [
<?php

	$ldao = getLocationDAO(); 
	$p = new Locations();
	if (isset($_POST["name"])) { 
		$name = str_replace("*", "%", $_POST["name"]);
		$p->place = $name;
	}
	if (isset($_POST["count"])) {
		if ($_POST["count"] == "Infinity") {
			$p->count = 10;
		} else {
			$p->count = $_POST["count"];
		}
		
	}
	if (isset($_POST["start"])) {
		$p->start = $_POST["start"];
	}
	$ldao->getLocations($p);
	$places = $p->results;
	$i = 0;
	foreach($places as $place) {
		$i++;
?>{name:"<?php echo $place->getDisplayPlace();?>", label:"<?php echo $place->getDisplayPlace();?>",locationid:"<?php echo $place->location_id;?>"}<?php
		if ($i < $p->numResults) { echo ","; }
	}

?>]}