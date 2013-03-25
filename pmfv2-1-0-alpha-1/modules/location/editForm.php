<?php
include_once("modules/event/show.php");
include_once("modules/location/show.php");

function setup_edit() {
	$l = new Location();
	$l->setFromRequest();
	$dao = getLocationDAO();
	$dao->getLocations($l, Q_MATCH);
	if ($l->numResults > 0) {
		$ret = $l->results[0];
	} else {
		$ret = $l;
	}
	return ($ret);
}

function get_edit_title($l) {
	global $strEditing;
	if ($l->location_id > 0) {
		return($strEditing.": ".$l->place);
	} else {
		return ("");
	}
}

function get_edit_header($l) {
	return (get_edit_title($l));
}

function get_edit_form($l) {
	global $strName, $strPlace, $strLatitude, $strLongitude, $strCentre, $strSubmit, $strReset;
	
	$config = Config::getInstance();
	$gmaps = false;
	if (isset($config->gmapskey) && strlen($config->gmapskey) > 0) {
		$gmaps = true;
?>
    <script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=<?php echo $config->gmapskey;?>" 
            type="text/javascript"></script>
    <script type="text/javascript">

	var geocoder;
	var map;
   
      geocoder = new GClientGeocoder();


    // addAddressToMap() is called when the geocoder returns an
    // answer.  It adds a marker to the map with an open info window
    // showing the nicely formatted version of the address and the country code.
    function addAddressToMap(response) {
      if (!response || response.Status.code != 200) {
        alert("Sorry, we were unable to geocode that address");
      } else {
        var place = response.Placemark[0];
        var addrForm = document.forms.details;
        if (place.AddressDetails.Accuracy > 3) {
	        addrForm.place.value = place.address;
		addrForm.lat.value = place.Point.coordinates[1];
	        addrForm.lng.value = place.Point.coordinates[0];
                place.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName;
                place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.SubAdministrativeAreaName;
                place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName;
                if (place.AddressDetails.Accuracy > 5) {
                place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.PostalCode.PostalCodeNumber;   
                
                place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.Thoroughfare.ThoroughfareName;
                }
        	place.AddressDetails.Country.CountryNameCode;
        	
        	//The Terms of use requires the point to be displayed
	       	point = new GLatLng(place.Point.coordinates[1],
        		               place.Point.coordinates[0]);
		marker = new GMarker(point);
		map.addOverlay(marker);
		marker.openInfoWindowHtml(place.address + '<br>' + 
		      '<b>Country code:</b> ' + place.AddressDetails.Country.CountryNameCode);
	      map.setCenter(point, 10);

        } else {
        	alert("Sorry, could not resolve this to a detailed address");
        }
      }
    }

    // showLocation() is called when you click on the Search button
    // in the form.  It geocodes the address entered into the form
    // and adds a marker to the map at that location.
    function showLocation() {
      var address = document.forms.details.name.value;
    
      geocoder.getLocations(address, addAddressToMap);
    }

    function showLatLng() {
	var addrForm = document.forms.details;
	var coord = new GLatLng(addrForm.lat.value, addrForm.lng.value);
	geocoder.getLocations(coord, addAddressToMap);
    }
    </script>
<?php
	} //gmaps key
?>
<!--Fill out form -->
<form method="post" name="details" action="passthru.php?area=location">
<input type="hidden" name="location_id" value="<?php echo $l->location_id; ?>" />

	<table>
		<tr>
		<td><?php echo $strName;?></td>
		<td><input type="text" name="name" value="<?php echo $l->name; ?>" size="30" maxlength="60" /></td>
		<td><?php if ($gmaps) { ?><input type="button" name="find" value="Search" onclick="showLocation();return false;"/><?php }?></td>
		</tr>
		<tr>
		<td><?php echo $strPlace;?></td>
		<td><input type="text" name="place" value="<?php echo $l->place; ?>" size="30" maxlength="80" /></td>
		<td></td>
		</tr>
		<tr>
		<td><?php echo $strLatitude;?></td>
		<td><input type="text" name="lat" value="<?php echo $l->lat; ?>" size="15" maxlength="11" /></td>
		<td><?php if ($gmaps) { ?><input type="button" name="find" value="Search" onclick="showLatLng();return false;"/><?php }?></td>
		</tr>
		<tr>
		<td><?php echo $strLongitude;?></td>
		<td><input type="text" name="lng" value="<?php echo $l->lng; ?>" size="15" maxlength="11" /></td>
		<td></td>
		</tr>
		<tr>
		<td><?php echo $strCentre;?></td>
		<td><input type="checkbox" name="centre" <?php if ($l->centre > 0) { echo 'checked="checked"';}?> value="1" /></td>
		<td></td>
		</tr>
		<tr>
			<td class="tbl_even"><input type="submit" name="Submit1" value="<?php echo $strSubmit; ?>" /></td>
			<td colspan="2" class="tbl_even"><input type="reset" name="Reset1" value="<?php echo $strReset; ?>" /></td>
		</tr>
	</table>
	<?php
	if ($l->location_id > 0) {
		$p = new Locations();
		$p->location_id = $l->location_id;
		$ldao = getLocationDAO();
		$ldao->getPlaces($p);
		foreach ($p->places as $loc) {
			echo $loc->text;
		}
		foreach ($p->notFound as $loc) {
			echo $loc->text;
		}
	}
	?>
</form>
<?php if ($gmaps) {?>
<div id="map_canvas" style="width: 500px; height: 300px"></div>
    <script type="text/javascript">
      	map = new GMap2(document.getElementById("map_canvas"));
      	<?php if (isset($l->lat) && isset($l->lng)) { ?>
      	map.setCenter(new GLatLng(<?php echo $l->lat; ?>, <?php echo $l->lng; ?>), 4);
      	<?php }?>
    </script>
<?php } ?>
<?php
}
?>