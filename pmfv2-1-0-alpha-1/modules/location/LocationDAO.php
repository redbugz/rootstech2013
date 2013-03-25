<?php
include_once "classes/Locations.php";

class LocationDAO extends MyFamilyDAO {

	function getLocations(&$location, $type = Q_LIKE) {
		global $tblprefix, $err_locations;
		$res = array();
		$squery = "SELECT ".Location::getFields("l").
			" FROM ".$tblprefix."locations l ";

		if (isset($location->location_id) && $location->location_id <> '') {
			$squery .= "WHERE location_id = ".quote_smart($location->location_id);
		} else if (isset($location->place) && $location->place <> '%') {
			if ($type == Q_LIKE) {
				$squery .= "WHERE place LIKE ".quote_smart($location->place);
			} else {
				$squery .= "WHERE place = ".quote_smart($location->place);
			}
		}
		$squery .= " ORDER BY place";
		$this->addLimit($location, $squery);
		//TODO - error message
		$result = $this->runQuery($squery, '');

		$location->numResults = 0;
		while ($row = $this->getNextRow($result)) {
			$l = new Location();
			$l->loadFields($row, "l_");
			$l->setPermissions();
			$location->numResults++;
			$res[] = $l;
		}
		$this->freeResultSet($result);
		$location->results = $res;
	}

	//Looks up a location based on place and creates one
	//if it does not exist
	function resolveLocation(&$location) {
		$rowsChanged = 0;
		if ($location->place <> '') {
			if($location->location_id == '') {
				$location->place = trim($location->place);
				$this->getLocations($location);
				if ($location->numResults > 0) {
					$location = $location->results[0];
				} else {
					$rowsChanged += $this->saveLocation($location);
				}
			}
		} else {
			$location->location_id = 'null';
		}

		return($rowsChanged);
	}

	function createPlace(&$locations, $location, $descrip) {
		$p = null;
		$new = false;
		$place = $location->place;
		if (strlen($place) > 0) {
			if (array_key_exists($place,$locations->places)) {
				$p = $locations->places[$place];
				$p->text .= '<br/>';
			} else if (array_key_exists($place,$locations->notFound)) {
				$p = $locations->notFound[$place];
				$p->text .= '<br/>';
			} else {
				$location->text = $location->getEditLink().'<br/>';
				$new = true;
				$p = $location;
			}
			$p->text .= $descrip;
			$found = true;
			if ($p->lat == '') {
				if ($new) {
					$found = $this->lookupLocation($p);
					if ($found) {
						if ($p->lat <> '') {
							$this->saveLocation($p);
						}
					}
				} else {
					$found = false;
				}
			}
				
			if ($found) {
				$locations->places[$place] = $p;
			} else {
				$locations->notFound[$place] = $p;
			}
				
		}
		return ($p);
	}

	function lookupLocation(&$location) {

		$config = Config::getInstance();

		if (!isset($config->gmapskey) || strlen($config->gmapskey) == 0) {
			$location->lat = '';
			$location->lng = '';
			return false;
		}

		// Initialize delay in geocode speed
		$delay = 0;
		$found = false;
		$base_url = "http://" . $config->gmapshost . "/maps/geo?output=xml&key=" . $config->gmapskey;

		// Iterate through the rows, geocoding each address

		$geocode_pending = true;

		while ($geocode_pending) {

			$request_url = $base_url . "&q=" . urlencode($location->place);
			if(ini_get("allow_url_fopen") && ini_get("allow_url_include")) {
				$xml = simplexml_load_file($request_url);
			} else if (extension_loaded("curl")) {
	 		$ch = curl_init($request_url);
	 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 		$response = curl_exec($ch);
	 		curl_close($ch);
	 		libxml_use_internal_errors(true);
	 		$xml = simplexml_load_string($response);
	 		
			if (!$xml) {
			    echo "Failed loading XML\n";
			    echo $request_url;
			    foreach(libxml_get_errors() as $error) {
			        echo "\t", $error->message;
			    }
			}
			} else {
				//Security prevents lookup
				return false;
			}
			$status = $xml->Response->Status->code;
			if (strcmp($status, "200") == 0) {
				// Successful geocode
				$geocode_pending = false;
				$coordinates = $xml->Response->Placemark->Point->coordinates;
				$coordinatesSplit = split(",", $coordinates);
				// Format: Longitude, Latitude, Altitude
				$lat = $coordinatesSplit[1];
				$lng = $coordinatesSplit[0];
				$location->lat = $lat;
				$location->lng = $lng;

			} else if (strcmp($status, "620") == 0) {
				// sent geocodes too fast
				$delay += 100000;
			} else {
				// failure to geocode
				$geocode_pending = false;
			}
			usleep($delay);





		}
		return($found);
	}

	function getPlaces(&$locations, $person = null) {
		$this->getEventPlaces($locations, $person);
		$this->getMarriagePlaces($locations, $person);
		$this->getAttendeePlaces($locations, $person);
	}

	function getEventPlaces(&$locations, $person = null) {
		global $tblprefix, $restrictdate, $strEvent, $datefmt;

		$pquery = "SELECT DISTINCT ".Event::getFields("e").
			",".PersonDetail::getFields("p").
			",".Location::getFields("l").
			" FROM ".$tblprefix."event e".
			" JOIN ".$tblprefix."people p ON p.person_id=e.person_id".
			" JOIN ".$tblprefix."locations l ON e.location_id=l.location_id ".
		PersonDetail::getJoins().
			" WHERE (e.etype < 4 OR e.etype =".OTHER_EVENT.") AND e.location_id is not null"; 
		$pquery .= $this->addPersonRestriction(" AND ");

		if ($locations->location_id > 0) {
			$pquery .= " AND l.location_id = ".$locations->location_id;
		}

		$presult = $this->runQuery($pquery, "");
		while ($row = $this->getNextRow($presult)) {
			$per = new PersonDetail();
			$per->loadFields($row, L_HEADER, "p_");
			$per->name->loadFields($row, "n_");
			$per->setPermissions();
			$text = $per->getLink().' '.$strEvent[$row["e_etype"]];
			$e = new Event();
			$e->loadFields($row, "e_");
			$e->location->loadFields($row, "l_");
			$e->location->setPermissions();
			$text .= ' '.$e->getDate1();
			if ($per->isViewable()) {
				$p = $this->createPlace($locations, $e->location, $text);
				if ($p != null) {
					$p->birth = true;
				}
			}
		}
		$this->freeResultSet($presult);
	}

	function getMarriagePlaces(&$locations, $person = null) {
		global $tblprefix, $strEvent, $currentRequest;

		$pquery = "select relation.event_id,"
		.PersonDetail::getFields("groom","ng","bg","dg").
			",".PersonDetail::getFields("bride","nb","bb","db").
			",".Event::getFields("e").
			", relation.dissolve_date, relation.dissolve_reason,".
			" DATE_FORMAT(relation.dissolve_date, ".$currentRequest->datefmt.") AS DOD ".
			",".Location::getFields("l").
			" FROM ".$tblprefix."event e".
			" JOIN ".$tblprefix."spouses relation ON relation.event_id=e.event_id".
			" JOIN ".$tblprefix."locations l ON e.location_id=l.location_id ".
			" LEFT JOIN ".$tblprefix."people bride ON relation.bride_id = bride.person_id ".
			" LEFT JOIN ".$tblprefix."people groom ON relation.groom_id = groom.person_id ".
		PersonDetail::getJoins("LEFT","groom","ng","bg","dg").
		PersonDetail::getJoins("LEFT","bride","nb","bb","db").
			" WHERE (e.etype = ".BANNS_EVENT." OR e.etype=".MARRIAGE_EVENT.") AND e.location_id is not null";

		$pquery .= $this->addPersonRestriction(" AND ","bg","dg");
		$pquery .= $this->addPersonRestriction(" AND ","bb","db");

		if ($locations->location_id > 0) {
			$pquery .= " AND l.location_id = ".$locations->location_id;
		}

		$presult = $this->runQuery($pquery, "");

		while ($row = $this->getNextRow($presult)) {
			$rel = new Relationship();
			$rel->person->loadFields($row,L_HEADER, "groom_");
			$rel->person->name->loadFields($row, "ng_");
			$rel->person->setPermissions();
			$rel->relation->loadFields($row,L_HEADER, "bride_");
			$rel->relation->name->loadFields($row, "nb_");
			$rel->relation->setPermissions();
			$rel->loadFields($row);
			$rel->event = new Event();
			$rel->event->loadFields($row, "e_");
			$rel->event->location->loadFields($row, "l_");
			$rel->event->location->setPermissions();
			$text = $rel->person->getLink().' '.$strEvent[$row["e_etype"]].' '.$rel->relation->getLink().' '.$rel->event->getDate1();
			if ($rel->isViewable()) {
				$p = $this->createPlace($locations, $rel->event->location, $text);
				if ($p != null) {
					$p->marriage = true;
				}
			}
		}
		$this->freeResultSet($presult);
	}

	function getAttendeePlaces(&$locations, $person = null) {
		global $tblprefix, $strEvent, $datefmt;
		global $strBirthPlace, $strAddress;

		$query = "SELECT ".Attendee::getFields('a').",".PersonDetail::getFields('p').", ".
		Event::getFields("e").
			",".Location::getFields("l").
			",".Location::getFields("el").
			" FROM ".$tblprefix."attendee a".
			" JOIN ".$tblprefix."people p ON a.person_id = p.person_id".
			" JOIN ".$tblprefix."event e ON a.event_id = e.event_id".
			" LEFT JOIN ".$tblprefix."locations el ON el.location_id = e.location_id".
			" LEFT JOIN ".$tblprefix."locations l ON l.location_id = a.location_id".
		PersonDetail::getJoins().
			" WHERE (a.location_id is not null OR e.location_id is not null)".
			" AND (NOT (e.etype = ".BANNS_EVENT." OR e.etype=".MARRIAGE_EVENT."))";
			
		$query .= $this->addPersonRestriction(" AND ");

		if ($locations->location_id > 0) {
			$query .= " AND (a.location_id = ".$locations->location_id." OR e.location_id = ".$locations->location_id.")";
		}

		$presult = $this->runQuery($query, "");
		while ($prow = $this->getNextRow($presult)) {
			$per = new PersonDetail();
			$per->loadFields($prow, L_HEADER, 'p_');
			$per->name->loadFields($prow, 'n_');
			$per->setPermissions();
			$e = new Event();
			$e->loadFields($prow, "e_");
			$loc = new Location();
			$loc->loadFields($prow,"l_");
			$loc->setPermissions();
			if ($per->isViewable() && $loc->hasData()) {
				$text = $per->getLink().' ';
				switch($e->type) {
					case CENSUS_EVENT:
						$text .= $strEvent[$e->type]." ".$strBirthPlace;
						break;
					default:
						$text .= $strAddress;
						break;
				}
				$text .= ' '.$e->getDate1();
				if (($locations->location_id > 0 && $loc->location_id == $locations->location_id) ||
				$locations->location_id <= 0) {
					$p = $this->createPlace($locations, $loc, $text);
				}
			}
				
			$e->location->loadFields($prow,"el_");
			$e->location->setPermissions();
			if ($per->isViewable() && $e->location->hasData()) {
				$text = $per->getLink().' '.$strEvent[$e->type].' '.$e->getDate1();
				if (($locations->location_id > 0 && $e->location->location_id == $locations->location_id) ||
				$locations->location_id <= 0) {
					$p = $this->createPlace($locations, $e->location, $text);
				}
			}
		}
		$this->freeResultSet($presult);
	}

	function getLocationCount() {
		global $tblprefix;

		$squery = "SELECT count(location_id) as number ".
			" FROM ".$tblprefix."locations l ";

		$result = $this->runQuery($squery, '');

		while ($row = $this->getNextRow($result)) {
			$ret = $row["number"];
		}
		$this->freeResultSet($result);
		return ($ret);
	}

	function saveLocation(&$location) {
		global $tblprefix;
	  
		$rowsChanged = 0;
	  
		$place = quote_smart($location->place);
		if (isset($location->location_id) && $location->location_id > 0) {
			$query = sprintf("UPDATE ".$tblprefix."locations " .
			" SET name=%s, place=%s, lat=%s, lng=%s, centre = %d WHERE location_id =".$location->location_id,
			$place,
			$place,
			(strlen($location->lat) > 0)?quote_smart($location->lat):'null',
			(strlen($location->lng) > 0)?quote_smart($location->lng):'null',
			$location->centre);
			$update_result = $this->runQuery($query, "");
			$rowsChanged += $this->rowsChanged($update_result);
		} else {
			$this->lockTable($tblprefix."locations");
			$query = sprintf("INSERT INTO ".$tblprefix."locations " .
			" (name, place, lat, lng, centre) VALUES (%s,%s,%s, %s, %d) ;",
			$place,
			$place,
			(strlen($location->lat) > 0)?quote_smart($location->lat):'null',
			(strlen($location->lng) > 0)?quote_smart($location->lng):'null',
			$location->centre);
			$update_result = $this->runQuery($query, "");
			$rowsChanged += $this->rowsChanged($update_result);
			$location->location_id = $this->getInsertId();
			$this->unlockTable($tblprefix."locations");
		}
		return ($rowsChanged);
	}

	function deleteLocation($loc) {
		global $tblprefix;
		$this->startTrans();
		//TODO error messages
		$dquery = "UPDATE ".$tblprefix."event SET location_id = NULL WHERE location_id = ".$loc->location_id;
		$dresult = $this->runQuery($dquery, '');

		$dquery = "UPDATE ".$tblprefix."attendee SET location_id = NULL WHERE location_id = ".$loc->location_id;
		$dresult = $this->runQuery($dquery, '');

		$dquery = "DELETE FROM ".$tblprefix."locations WHERE location_id = ".$loc->location_id;
		$dresult = $this->runQuery($dquery, '');
		$this->commitTrans();
	}
}
?>
