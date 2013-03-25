<?php
set_include_path("..");
include_once("modules/db/DAOFactory.php");

//header("Content-Type", "application/json");

?>
{}&&{identifier:"sourceid",
items: [
<?php

	$sdao = getSourceDAO(); 
	$s = new Source();
	if (isset($_POST["name"])) { 
		$name = str_replace("*", "%", $_POST["name"]);
		$s->title= $name;
	}
	if (isset($_POST["count"])) {
		if ($_POST["count"] == "Infinity") {
			$s->count = 10;
		} else {
			$s->count = $_POST["count"];
		}
		
	}
	if (isset($_POST["start"])) {
		$s->start = $_POST["start"];
	}
	$sdao->getSources($s);
	$sources= $s->results;
	$i = 0;
	foreach($sources as $source) {
		$i++;
?>{name:"<?php echo $source->getDisplaySource();?>", label:"<?php echo $source->getDisplaySource();?>",sourceid:"<?php echo $source->source_id;?>"}<?php
		if ($i < $s->numResults) { echo ","; }
	}

?>]}