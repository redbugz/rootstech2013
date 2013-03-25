<?php
include_once ("modules/people/PeopleDAO.php");
include_once ("classes/Relationship.php");
include_once("modules/db/MyFamilyDAO.php");

class RelationsDAO extends PeopleDAO {
	
	
	function getRelationshipDetails (&$search) {
		global $tblprefix, $err_spouse, $currentRequest;
		
		$partner = $search->relation->person_id;
		$res = array();
		$search->numResults = 0;
		if (!($search->person->person_id > 0)) {
			return;
		}
		$query = "SELECT ".
			PersonDetail::getFields().",".
			PersonDetail::getFields("sp","ns","bs","ds").
			", p.gender, DATE_ADD(b.date1, INTERVAL 40 YEAR) AS child_snatcher, ".
			" relation.event_id,".
			Event::getFields("e").",".
			Location::getFields("l").
			", relation.dissolve_date, relation.dissolve_reason,".
			" DATE_FORMAT(relation.dissolve_date, ".$currentRequest->datefmt.") AS DOD ".
			"FROM ".$tblprefix."people p ";
			
		$query .= " LEFT JOIN ".$tblprefix."spouses relation ON ";
		if ($search->event->event_id > 0) {
			$query .= " relation.event_id = ".$search->event->event_id;
		} else {
			$query .= "((relation.groom_id =  ".$search->person->person_id.
			") OR (relation.bride_id =  ".$search->person->person_id."))";
		}
		$query .= " LEFT JOIN ".$tblprefix."people sp ON (relation.groom_id = sp.person_id OR relation.bride_id = sp.person_id)".
			" AND sp.person_id <> p.person_id ".
			" LEFT JOIN ".$tblprefix."event e ON e.event_id = relation.event_id".
			" LEFT JOIN ".$tblprefix."locations l ON l.location_id = e.location_id ".
			PersonDetail::getJoins("LEFT").
		PersonDetail::getJoins("LEFT","sp","ns","bs","ds");
		$query .= " AND sp.person_id <> p.person_id";
		$query .= " WHERE p.person_id = ".$search->person->person_id;
		
		$query .= $this->addPersonRestriction(" AND ");
		$query .= $this->addPersonRestriction(" AND ", "bs","ds");
		
		$query .= " ORDER BY e.date1";
		
		$result = $this->runQuery($query, $err_spouse);
		$search->numResults = 0;
		while ($row = $this->getNextRow($result)) {
			$rel = new Relationship();
			$rel->person->loadFields($row,L_HEADER, "p_");
			$rel->person->name->loadFields($row, "n_");
			$rel->relation->loadFields($row,L_HEADER, "sp_");
			$rel->relation->name->loadFields($row, "ns_");
			$rel->loadFields($row);
			$rel->event = new Event();
			$rel->event->loadFields($row, "e_");
			$rel->event->location->loadFields($row, "l_");
			$rel->marriage_date = $rel->event->date1;
			$rel->dom = $rel->event->fdate1;
			$rel->marriage_place = $rel->event->location;
			$rel->restrictDate = $row["child_snatcher"];
			//Should sort out the SQL instead of this but for now...
			if ($rel->person->person_id != $rel->relation->person_id) {
				$search->numResults++;
				$res[] = $rel;
			}
		}
		$this->freeResultSet($result);
		$search->results = $res;
	}
	
	function getNearest(&$search) {
		return $this->getMarriages($search, 21);
	}
	function getMarriages(&$search, $limit = 0) {
		global $tblprefix, $err_marriage, $currentRequest;
		
		$res = array();

		$query = "SELECT DISTINCT CONCAT_WS('-', YEAR(NOW()), LPAD(MONTH(e.date1), 2, '0'), LPAD(DAYOFMONTH(e.date1), 2, '0')) AS fake_marriage, ".
		"DATE_FORMAT(e.date1, ".$currentRequest->datefmt.") AS DOM, e.date1, ".
		PersonDetail::getFields("groom","ng","bg","dg").",".
			PersonDetail::getFields("bride","nb","bb","db").
		", sp.dissolve_date, sp.dissolve_reason,".
		" DATE_FORMAT(sp.dissolve_date, ".$currentRequest->datefmt.") AS DOD, e.event_id ".
		" FROM ".$tblprefix."event e".
		" JOIN ".$tblprefix."spouses sp ON sp.event_id = e.event_id".
		" LEFT JOIN ".$tblprefix."people bride ON sp.bride_id = bride.person_id ".
		" LEFT JOIN ".$tblprefix."people groom ON sp.groom_id = groom.person_id ".
		PersonDetail::getJoins("LEFT","groom","ng","bg","dg").
		PersonDetail::getJoins("LEFT","bride","nb","bb","db");
		
		// if the user is not logged in, only show people pre $restrictdate
		$query .= $this->addPersonRestriction(" WHERE ", "bb","db");
		$query .= $this->addPersonRestriction(" AND ", "bg","dg");
		$query .= " AND (e.etype = ".BANNS_EVENT." OR e.etype = ".MARRIAGE_EVENT.") ";
		if ($limit > 0) { 
			$query .= " HAVING fake_marriage >= now() AND fake_marriage <= DATE_ADD(NOW(), INTERVAL $limit DAY) ORDER BY fake_marriage";
		}
		$this->addLimit($search, $query);
		
		$result = $this->runQuery($query, $err_marriage);

		$search->numResults = 0;
		while ($row = $this->getNextRow($result)) {
			$rel = new Relationship();
			$rel->person->loadFields($row,L_HEADER, "groom_");
			$rel->person->name->loadFields($row, "ng_");
			$rel->relation->loadFields($row,L_HEADER, "bride_");
			$rel->relation->name->loadFields($row, "nb_");
			$rel->loadFields($row);
			$rel->marriage_date = $row["date1"];
			$rel->dom = $row["DOM"];
			$search->numResults++;
			
			$res[] = $rel;
		}
		$this->freeResultSet($result);
		$search->results = $res;
	}
	
	function saveRelationshipDetails($rel) {
		global $tblprefix, $err_marriage_insert, $err_person_update;
		
		if ($rel->person->gender == "M") {
			$groomId = $rel->person->person_id;
			$brideId = $rel->relation->person_id;
			$currGroom = $groomId;
			$currBride = $rel->oldRelation;
		} else {
			$brideId = $rel->person->person_id;
			$groomId = $rel->relation->person_id;
			$currGroom = $rel->oldRelation;
			$currBride = $brideId;
		}
		
		$this->startTrans();
		$rowsChanged = 0;
		$insert = false;
		
		$dao = getEventDAO();

		$rowsChanged += $dao->saveEvent($rel->event);

		if ($rel->oldRelation) {
			$query = "UPDATE ".$tblprefix."spouses SET bride_id = ".quote_smart($brideId).", groom_id = ".quote_smart($groomId).
					", dissolve_date = ".quote_smart($rel->dissolve_date).", dissolve_reason = ".quote_smart($rel->dissolve_reason).
					" WHERE event_id = ".$rel->event->event_id;
			$msg = $err_person_update;
		} else {
			$query = "INSERT INTO ".$tblprefix."spouses (groom_id, bride_id, dissolve_date, dissolve_reason, event_id) ".
				"VALUES (".quote_smart($groomId).", ".quote_smart($brideId).",".
				quote_smart($rel->dissolve_date).", ".quote_smart($rel->dissolve_reason).",".$rel->event->event_id.")";
			$msg = $err_marriage_insert;
			$insert = true;
		}
		/*
		ob_start();
		print_r($rel);
		print_r($_POST);
		error_log(ob_get_flush());
		*/

		$ret = $this->runQuery($query, $msg);
		$rowsChanged += $this->rowsChanged($ret);
				
		$this->commitTrans();
		return ($rowsChanged);
	}
	
	function deleteRelationshipDetails($rel) {
		global $tblprefix, $err_marriage_delete;
		if ($rel->event->event_id == '') {
			return;
		}
		$this->startTrans();
		$dquery = "DELETE FROM ".$tblprefix."spouses WHERE event_id = ".$rel->event->event_id;
		$dresult = $this->runQuery($dquery, $err_marriage_delete);
		$dao = getEventDAO();
		$dao->deleteEvent($rel->event);
		$this->commitTrans();
	}
	
	//Should be called from within a transaction
	function deletePersonRelationshipDetails($per) {
		global $tblprefix, $err_marriage_delete;
		if ($per->person_id == '') {
			return;
		}
		$dquery = "DELETE FROM ".$tblprefix."spouses WHERE (groom_id = ".$per->person_id." OR bride_id =".$per->person_id.")";
		$dresult = $this->runQuery($dquery, $err_marriage_delete);
		$dao = getEventDAO();
		$dao->deletePersonEvents($per, MARRIAGE_EVENT);
	}
}

?>
