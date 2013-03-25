<?php
include_once ("modules/people/PeopleDAO.php");
include_once ("classes/CensusDetail.php");

class CensusDAO extends PeopleDAO {
	
	function getCensusDetails(&$input) {
		global $tblprefix, $err_census_ret;
		
		$res = array();
		$input->results = $res;
		
		$edquery = "SELECT cen.census_id, cen.census, schedule, year, census_date, cy.country, ".Event::getFields('e').
				",".PersonDetail::getFields().
				",".Attendee::getFields('a').
				",".Location::getFields('l').
				",".Location::getFields('al').
				" FROM ".$tblprefix."attendee a".
				" JOIN ".$tblprefix."event e ON a.event_id = e.event_id".
				" JOIN ".$tblprefix."census cen ON cen.event_id = e.event_id".
				" JOIN ".$tblprefix."people p ON a.person_id = p.person_id".
				" LEFT JOIN ".$tblprefix."locations l ON l.location_id = e.location_id".
				" LEFT JOIN ".$tblprefix."locations al ON al.location_id = a.location_id".
				" LEFT JOIN ".$tblprefix."census_years cy ON cen.census = cy.census_id".
				PersonDetail::getJoins();
		
		switch ($input->queryType) {
			case Q_TYPE:
				$where = "";
				if (isset($input->schedule)) {
					$where = " WHERE e.reference =".$input->schedule;
				}
				break;
			case Q_FAMILY:
				$where = " WHERE e.event_id = ".$input->event->event_id;
				if (!isset($input->event->event_id) || $input->event->event_id == '') {
					return;
				}
				break;
			default:
				$where = " WHERE p.person_id = ".$input->person->person_id;
				break;
		}
		
		$where .= $this->addPersonRestriction(" AND ");
		$orderby = " ORDER BY e.date1, b.date1";	

		$edquery .= $where.$orderby;
		if (($edresult = $this->runQuery($edquery, $err_census_ret))) {
		  $input->numResults = 0;
		  $events = array();
		 
		  while ($edrow = $this->getNextRow($edresult)) {
			$cen = new CensusDetail();
			$cen->loadFields($edrow);
			$e = new Event();
			$e->loadFields($edrow,"e_");
			$e->location->loadFields($edrow, "l_");
			$new = false;
			if (isset($events[$e->event_id])) {
				$event = $events[$e->event_id];
			} else {
				$new = true;
				$e->attendees = array();
				$events[$e->event_id] = $e;
				$event = $e;
			}
			$a = new Attendee();
			$a->person->loadFields($edrow, L_HEADER, "p_");
			$a->person->name->loadFields($edrow, "n_");
			if ($a->person->person_id == $event->person->person_id) {
				$event->person = $a->person;
			}
			$a->loadFields($edrow, "a_");
			$a->location->loadFields($edrow, "al_");
			$event->attendees[] = $a;
			//This is needed for php 4
			$events[$event->event_id] = $event;
			if ($new) {
				$cen->event = $event;
				$input->numResults++;
				$res[] = $cen;
			}
			//This is also needed for php 4
			for($i=0;$i<count($res);$i++) {
				if ($res[$i]->event->event_id == $event->event_id) {
					$c = $res[$i];
					$c->event = $event;
					$res[$i] = $c; 
				}
			}
		  }
		  $this->freeResultSet($edresult);
		}
		$input->results = $res;
	}
	
	function saveCensusDetails($cen) {
		global $tblprefix, $err_person_update, $err_census;
		$rowsChanged = 0;
		$this->startTrans();
		if (isset($cen->event->event_id) && $cen->event->event_id > 0) {
			$insert = false;
		} else {
			$insert = true;
		}
		$dao = getEventDAO();
		$rowsChanged += $dao->saveEvent($cen->event);
		
		if ($insert == false) {
			$msg = $err_census;
			$query = "UPDATE ".$tblprefix."census SET census = ".$cen->census.
			", schedule = ".quote_smart($cen->schedule).
			" WHERE event_id = ".$cen->event->event_id;
		} else {
			$query = "INSERT INTO ".$tblprefix."census (person_id, census, event_id, schedule) VALUES ".
					"(".$cen->event->person->person_id.", ".$cen->census.", ".$cen->event->event_id.",".quote_smart($cen->schedule).")";
			$msg = $err_person_update;
		}
		
		$ret = $this->runQuery($query, $msg);
		
		$rowsChanged += $this->rowsChanged($ret);
		$this->commitTrans();
		return ($rowsChanged);
	}
	
	function deleteCensusRecord($cen) {
		global $tblprefix, $err_census_delete;
		if ($cen->event->event_id == '') {
			return;
		}
		$this->startTrans();
		$dquery = "DELETE FROM ".$tblprefix."census WHERE event_id = ".$cen->event->event_id;
		
		$dresult = $this->runQuery($dquery, $err_census_delete);
		
		$dao = getEventDAO();
		$dao->deleteEvent($cen->event);
		
		$this->commitTrans();
		return ($dresult);
	}

	//Should be called from within a transaction
	//Does not delete associated events
	function deletePersonCensusRecord($per) {
		global $tblprefix, $err_census_delete;
		if ($per->person_id == '') {
			return;
		}
		$dquery = "DELETE FROM ".$tblprefix."census WHERE person_id = ".$per->person_id;
		
		$dresult = $this->runQuery($dquery, $err_census_delete);
		$dao = getEventDAO();
		$dao->deletePersonEvents($per, CENSUS_EVENT);
		return ($dresult);
	}
	
	function getCensusName(&$cen) {
		global $tblprefix;
		$tquery = "SELECT country, year FROM ".$tblprefix."census_years WHERE census_id = ".quote_smart($cen->census);
		$tresult = $this->runQuery($tquery, "");
		while ($trow = $this->getNextRow($tresult)) {
			$this->loadFields($cen, $trow, L_HEADER);
		}
		$this->freeResultSet($tresult);
	}

	function getCensusCountries($filter) {
		global $tblprefix;
		$tquery = "SELECT DISTINCT country FROM ".$tblprefix."census_years ".
		" WHERE available = 'Y'";
		if(isset($filter)) {
			$tquery .= " AND country=".quote_smart($filter);
		}
		$tresult = $this->runQuery($tquery, "");
		$ret = array();
		while ($trow = $this->getNextRow($tresult)) {
			$ret[] = $trow["country"];
		}
		$this->freeResultSet($tresult);
		return ($ret);
	}
	
	function getCensusYears($country) {
		global $tblprefix,$err_list_census;
		$tquery = "SELECT census_id, year, census_date, country FROM ".$tblprefix."census_years WHERE ";
		if (strlen($country) > 0) {
			$tquery .= "country =".quote_smart($country)." AND ";
		}
		$tquery .= " available = 'Y'";
		$tquery .= " ORDER BY country, year";
		$tresult = $this->runQuery($tquery, $err_list_census);
		$ret = array();
		while ($trow = $this->getNextRow($tresult)) {
			$c = new CensusDetail();
			$c->year = $trow["year"];
			$c->census_date = $trow["census_date"];
			$c->census_id = $trow["census_id"];
			$c->country = $trow["country"];
			$ret[] = $c;
		}
		$this->freeResultSet($tresult);
		return ($ret);
	}
	
	function getMissingRecords($cen) {
		global $tblprefix;
		
		$tquery = "SELECT DISTINCT ".PersonDetail::getFields().
			 " FROM ".$tblprefix."people p ".
			 " LEFT JOIN ".$tblprefix."attendee a ON p.person_id = a.person_id".
			 " LEFT JOIN ".$tblprefix."census c ON a.event_id = c.event_id AND census = ".$cen->census_id.
			 " JOIN ".$tblprefix."census_years cy ON cy.census_id = ".$cen->census_id.
			 PersonDetail::getJoins().
			 "WHERE c.event_id is null AND (b.date1 <= cy.census_date AND d.date1 >= cy.census_date)";
		$tquery .= $this->addPersonRestriction(" AND ", "p");
		$tquery .= " ORDER BY date_of_birth";
		
		//TODO error message
		$tresult = $this->runQuery($tquery, "");
		$ret = array();
		
		while ($trow = $this->getNextRow($tresult)) {
			$p = new PersonDetail();
			$p->loadFields($trow, L_HEADER, "p_");
			$p->name->loadFields($trow, "n_");
			$ret[] = $p;
		}
		$this->freeResultSet($tresult);
		return ($ret);
	}
}
?>
