<?php
include_once "classes/Event.php";
include_once "classes/Attendee.php";

define('Q_BD', 7);
define('Q_REL', 8);
define('Q_CEN', 9);
define('Q_ALL', 10);
define('Q_OTHER', 11);

class EventDAO extends MyFamilyDAO {
	
	function getEvents(&$events,$type, $attendees = false) {
		global $tblprefix;
		
		$events->numResults = 0;
		
		$query = "SELECT ".Event::getFields('e').",".Location::getFields('l')." FROM ".$tblprefix."event e".
			" LEFT JOIN ".$tblprefix."locations l ON l.location_id = e.location_id";
		
		
		switch($type) {
		case Q_BD:
			$query .= " WHERE etype < 4";
			$query .= " AND e.person_id = ".$events->person->person_id;
			//birth and death events only
			if (!isset($events->person) || $events->person->person_id == '') {
				return;
			}
			break;
		case Q_REL:
			$query .= " WHERE (etype = ".BANNS_EVENT." OR etype = ".MARRIAGE_EVENT.")";
			$query .= " AND e.event_id = ".$events->event_id;
			if (!isset($events->event_id) || $events->event_id == '') {
				return;
			}
			break;
		case Q_CEN:
			$query .= " WHERE etype = ".CENSUS_EVENT;
			$query .= " AND e.person_id = ".$events->person->person_id;
			if (!isset($events->person) || $events->person->person_id == '') {
				return;
			}
			break;
		case Q_OTHER:
			$query .= " WHERE etype = ".OTHER_EVENT;
			$query .= " AND e.person_id = ".$events->person->person_id;
			if (!isset($events->person) || $events->person->person_id == '') {
				return;
			}
			break;
		case Q_ALL:
			$query .= " WHERE e.event_id = ".$events->event_id;
			if (!isset($events->event_id) || $events->event_id == '') {
				return;
			}
		}
		
		//TODO error message
		$result = $this->runQuery($query, '');
		
		$res = array();
		while ($row = $this->getNextRow($result)) {
			$e = new Event();
			$e->loadFields($row, "e_");
			$e->location->loadFields($row, "l_");
			if ($attendees) {
				$this->getAttendees($e);
			}
			$events->numResults++;
			$res[] = $e;
		}
		$this->freeResultSet($result);
		$events->results = $res;
	}
	
	function getAttendees(&$event) {
		global $tblprefix;
		
		$query = "SELECT ".Attendee::getFields('a').",".
			PersonDetail::getFields('p').",".
			Location::getFields('l').
			" FROM ".$tblprefix."attendee a".
			" JOIN ".$tblprefix."people p ON a.person_id = p.person_id".
			" LEFT JOIN ".$tblprefix."locations l ON l.location_id = a.location_id".
			PersonDetail::getJoins();
		
		$query .= " WHERE a.event_id = ".$event->event_id;
		$query .= $this->addPersonRestriction(" AND ");
		
		//TODO error message
		$result = $this->runQuery($query, '');
		
		$res = array();
		while ($row = $this->getNextRow($result)) {
			$e = new Attendee();
			$e->loadFields($row, "a_");
			$per = new PersonDetail();
			$per->loadFields($row, L_HEADER, "p_");
			$per->name->loadFields($row, "n_");
			$per->name->person_id = $per->person_id;
			$e->person = $per;
			$e->location->loadFields($row, "l_");
			$res[] = $e;
		}
		$this->freeResultSet($result);
		$event->attendees = $res;
	}
	//Needs to be called from within a transaction
	function saveEvent(&$event) {
		global $tblprefix, $err_person_update, $err_detail;
		
		$rowsChanged = 0;
		$insert = false;
		
		$dao = getLocationDAO();
		$dao->resolveLocation($event->location);
		
		if (isset($event->event_id) && $event->event_id > 0) {
			$query = "UPDATE ".$tblprefix."event SET etype = ".$event->type.", descrip = ".quote_smart($event->descrip).", person_id = ".$event->person->person_id.
			", location_id = ".$event->location->location_id.", d1type = ".$event->date1_modifier.", date1 = ".quote_smart($event->date1).", d2type = ".$event->date2_modifier.", date2 = ".quote_smart($event->date2).
			", notes = ".quote_smart($event->notes).
			" WHERE event_id = ".quote_smart($event->event_id);
			$msg = $err_person_update;
		} else {
			$this->lockTable($tblprefix."event");
			$query = "INSERT INTO ".$tblprefix."event (etype, descrip, person_id, location_id, d1type, date1, d2type, date2, notes) VALUES (".
			$event->type.", ".quote_smart($event->descrip).", ".$event->person->person_id.", ".$event->location->location_id.", ".$event->date1_modifier.", ".quote_smart($event->date1).
			", ".$event->date2_modifier.", ".quote_smart($event->date2).", ".
			quote_smart($event->notes).")";
			$msg = $err_detail;
			$insert = true;
		}

		$ret = $this->runQuery($query, $msg);
		
		$rowsChanged += $this->rowsChanged($ret);
		
		if ($insert) {
			$event->event_id = $this->getInsertId();
			$this->unlockTable($tblprefix."event");
		}
		
		if(count($event->attendees) > 0) {
			foreach ($event->attendees AS $a) {
				$a->event->event_id = $event->event_id;
				$rowsChanged += $this->saveAttendee($a);
			}
		}

		if(count($event->sources) > 0) {
			$sdao = getSourceDAO();
			$sdao->deleteSourceEvent(null, $event);
			foreach ($event->sources AS $s) {
				$rowsChanged += $sdao->resolveSource($s);
				$sdao->saveSourceEvent($s, $event);
			}
		}
		return ($rowsChanged);
	}

	//Needs to be called from within a transaction
	function saveAttendee(&$attendee) {
		global $tblprefix, $err_person_update, $err_detail;
		
		$rowsChanged = 0;
		$insert = false;
		$dao = getLocationDAO();
		$dao->resolveLocation($attendee->location);
		
		if (isset($attendee->attendee_id) && $attendee->attendee_id > 0) {
			$query = "UPDATE ".$tblprefix."attendee SET ".
			" event_id = ".$attendee->event->event_id.",person_id = ".quote_smart($attendee->person->person_id).
			",age = '".$attendee->age."',profession = ".quote_smart($attendee->profession).",r_status = ".quote_smart($attendee->condition).
			",location_id = ".$attendee->location->location_id." ,loc_descrip = ".quote_smart($attendee->loc_descrip).
			",certified = ".quote_smart($attendee->certified).",notes = ".quote_smart($attendee->notes).
			" WHERE attendee_id = ".quote_smart($attendee->attendee_id);
			$msg = $err_person_update;
		} else {
			$this->lockTable($tblprefix."attendee");
			
			$query = "INSERT INTO ".$tblprefix."attendee ".
			"(event_id, person_id, age, profession, `r_status`, location_id, loc_descrip, certified, notes) VALUES (".
			$attendee->event->event_id.",".$attendee->person->person_id.",'".$attendee->age."',".
			quote_smart($attendee->profession).",".
			quote_smart($attendee->condition).",".$attendee->location->location_id.",".quote_smart($attendee->loc_descrip).",".
			quote_smart($attendee->certified).",".quote_smart($attendee->notes).")";
			$msg = $err_detail;
			$insert = true;
		}
		
		$ret = $this->runQuery($query, $msg);

		$rowsChanged += $this->rowsChanged($ret);
		
		if ($insert) {
			$attendee->attendee_id = $this->getInsertId();
			$this->unlockTable($tblprefix."attendee");
		}
		if ($rowsChanged > 0) {
			$attendee->changed = true;
		} else {
			$attendee->changed = false;
		}
		return ($rowsChanged);
	}
	
	//Needs to be called from within a transaction
	function deleteEvent($event) {
		global $tblprefix;
		
		$dquery = "DELETE FROM ".$tblprefix."attendee WHERE event_id = ".$event->event_id;
		//TODO error message
		$dresult = $this->runQuery($dquery, '');
		
		$dquery = "DELETE FROM ".$tblprefix."event WHERE event_id = ".$event->event_id;
		//TODO error message
		$dresult = $this->runQuery($dquery, '');
		
		return ($dresult);

	}
	
	//Needs to be called from within a transaction
	function deletePersonEvents($person, $type) {
		global $tblprefix;
		
		$dquery = "DELETE FROM ".$tblprefix."attendee WHERE person_id = ".$person->person_id;
		//TODO error message
		$dresult = $this->runQuery($dquery, '');
		
		$dquery = "DELETE ".$tblprefix."attendee FROM ".$tblprefix."attendee".
			" JOIN ".$tblprefix."event ON ".$tblprefix."event.event_id = ".$tblprefix."attendee.event_id".
			" where ".$tblprefix."event.person_id = ".$person->person_id;
		//TODO error message
		$dresult = $this->runQuery($dquery, '');
		
		$dquery = "DELETE ".$tblprefix."source_event FROM ".$tblprefix."source_event".
			" JOIN ".$tblprefix."event ON ".$tblprefix."event.event_id = ".$tblprefix."source_event.event_id".
			" where ".$tblprefix."event.person_id = ".$person->person_id;
		//TODO error message
		$dresult = $this->runQuery($dquery, '');
		
		$dquery = "DELETE FROM ".$tblprefix."event WHERE person_id = ".$person->person_id;
		
		switch ($type) {
		case BIRTH_EVENT:
			$dquery .= " AND etype < 4 OR etype = ".OTHER_EVENT;
			break;
		default:
			$dquery .= " AND etype = ".$type;
			break;
		}
		//TODO error message
		$dresult = $this->runQuery($dquery, '');
		
		return ($dresult);

	}
	
	function stampAttendees($e) {
		
		$pdao = getPeopleDAO();
		
		foreach($e->attendees as $a) {
			if ($a->changed == false) {
				continue;
			}
			$peep = $a->person;
			$peep->queryType = Q_IND;
			$pdao->getPersonDetails($peep);
			$peep = $peep->results[0];
			if (!$peep->isEditable()) {
				die(include "inc/forbidden.inc.php");
			}
			stamppeeps($peep);
		}
	}
}
?>
