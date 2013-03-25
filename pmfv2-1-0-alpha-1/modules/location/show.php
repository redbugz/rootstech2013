<?php

function get_location_title() {
	global $strAddress;
	return $strAddress;
}

function show_location_title() {
	global $strNotes;
	?>
	<table width="100%">
		<tr>
			<td width="95%"><h4><?php echo get_location_title(); ?></h4></td>
			<td width="5%"></td>
		</tr>
	</table>
	<?php
}

function get_location_header($places) {
	$config = Config::getInstance();
	if (!isset($config->gmapskey) || strlen($config->gmapskey) == 0 || isset($_REQUEST["nomap"])) {
		return "";
	}
$ret = "<script src=\"http://".$config->gmapshost."/maps?file=api&amp;v=2&key=".$config->gmapskey."\" type=\"text/javascript\"></script>
 	<script src=\"http://gmaps-utility-library.googlecode.com/svn/trunk/markermanager/release/src/markermanager.js\"></script>
    <script type=\"text/javascript\">
    var map = null;
    var geocoder = null;
    function initialize() {
      if (GBrowserIsCompatible()) {
        var point;
        var marker;
	var centre = null;
        map = new GMap2(document.getElementById(\"map_canvas\"));
	map.addControl(new GLargeMapControl());
     
	var batch = [];
 ";

	$placeCount = 0;
	$latTotal = 0;
	$lngTotal = 0;
	
	foreach ($places as $place) {
      
      $ret .= "point = new GLatLng(".$place->lat.",".$place->lng.");
		marker = new GMarker(point); // { icon: getIcon()});
		marker.bindInfoWindowHtml('".$place->text."');
		batch.push(marker);";
		if ($place->centre) {
			$ret .= "centre = point;\n";
		}
		$placeCount++;
		$latTotal += $place->lat;
		$lngTotal += $place->lng;
	}
	$ret .= "if (centre == null) { centre = point; }\n";
 	$ret .= "map.setCenter(centre,6);\n";
	
	$ret .= "var mgr = new MarkerManager(map);
	mgr.addMarkers(batch,1);
	mgr.refresh();
      }
    }
    </script>";
    return ($ret);
}

function show_location($p) {
	$places = array();
	
	$ret = "<table>".
		"<tr><td>";
	$config = Config::getInstance();
	if (!isset($config->gmapskey) || strlen($config->gmapskey) == 0 || isset($_REQUEST["nomap"])) {
		$places = array_merge($p->places, $p->notFound);
	} else {
      		$ret .= '<div id="map_canvas" style="width: 650px; height: 800px"></div>';
	      	$ret .= "</td><td>".
      			"<h2>Places not found</h2>";
		$places = $p->notFound;
  	}
	$ret .= "<table>";
   
      	ksort($places);
	foreach ($places as $place) {
		$ret .= "<tr><td>".$place->text."</td></tr>\n";
	}
	
	$ret .="</table>".
		"</td></tr>";
  
	$ret .= "</table>";
	return $ret;
}

function selectPlace($field, $location) {
	$config = Config::getInstance();
	if ($config->dojo) {
?>

<input searchAttr="name" id="<?php echo $field;?>name"
	value="<?php echo $location->place;?>"
	dojoType="dijit.form.ComboBox" 
	store="LocationStore"
	name="<?php echo $field;?>name" autoComplete="false"
	pageSize="10" 
	size="30"
	maxlength="80"
	onChange="dojo.byId('<?php echo $field."location_id";?>').value='';"></input>
<input type="hidden" name="<?php echo $field."location_id";?>" id="<?php echo $field."location_id";?>" value="<?php echo $location->location_id;?>" ></input>
<?php
	} else {
		echo '<input name="'.$field.'name" value="'.$location->place.'"></input>';
	}
}
?>