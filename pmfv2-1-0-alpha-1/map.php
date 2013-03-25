<?php
	include_once "modules/db/DAOFactory.php";
	include_once "modules/location/show.php";
	include_once "inc/header.inc.php";
	$config = Config::getInstance();
	$ldao = getLocationDAO(); 
	$p = new Locations();
	$ldao->getPlaces($p);
	$places = $p->places;
	
	$extra = get_location_header($places); 
	do_headers_dojo($config->desc,$extra);
?>

  <body<?php
  if ($config->gmapskey != '') {
  echo ' onload="initialize()" onunload="GUnload()"';
  }
   ?>>
<?php include_once("inc/analyticstracking.php"); ?>
 <?php
     echo show_location($p);
  ?>  
  </body>
</html>
