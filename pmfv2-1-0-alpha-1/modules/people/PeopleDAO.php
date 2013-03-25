<?php
include_once("classes/PersonDetail.php");

class PeopleDAO extends MyFamilyDAO {
	
	
	function getPersonDetails(&$search, $callback = '') {
		global $tblprefix, $err_listpeeps, $currentRequest;
		
		if($search->queryType == Q_IND && !isset($search->person_id)) {
			return;
		}
		
		$use_callback = false;
		$numargs = func_num_args();
		if ($numargs > 1) {
			$use_callback = true;
		}
		$res = array();

		// create the query based on the parameters
		$query = "SELECT DISTINCT ";

		switch ($search->queryType) {
		case Q_COUNT:
			$fields = "COUNT(p.person_id) AS count ";
			break;
		default:
			$flds = array("death_reason", "mother_id", "father_id", "narrative", "updated");
			$fields = PersonDetail::getFields().
				", bl.place AS p_birth_place".
				", YEAR(b.date1) AS p_year_of_birth".
				", ".Base::addFields("p",$flds).", DATE_FORMAT(updated, ".$currentRequest->datefmt.") AS ddate";
			break;
		}
		$from = " FROM ".$tblprefix."people p ";
		$from .= PersonDetail::getJoins();
		$from .= " LEFT JOIN ".$tblprefix."locations bl ON bl.location_id = b.location_id";
		
		switch ($search->queryType) {
		case Q_TYPE:
		case Q_COUNT:
			$where = " WHERE p.person_id <> -1";//.$search->person_id;
			break;
		default:
			$where = " WHERE p.person_id = ".$search->person_id;
			break;
		}
		

		// if the user is not logged in, only show people pre $restrictdate
		$where .= $this->addPersonRestriction(" AND ");

		// need the gender if listing for mother or father selection
		if (isset($search->gender)) {
			if ($search->gender != 'A') {
				$where .= " AND gender = '".$search->gender."'";
			}
		}

		if (isset($search->date_of_birth) && $search->date_of_birth != '') {
			$where .= " AND b.date1 <= '".$search->date_of_birth."'";
		}

		
		
		if (isset($search->name->surname)) {
			$where .= " AND (";
			$op = " OR ";
			if (isset($search->name->forenames)) {
				$firstname = $search->name->forenames;
				$op = " AND ";
			} else {
				$firstname = $search->name->surname;
			}
			$lastname = $search->name->surname;
			$where .= " n.forenames LIKE ".quote_smart($firstname).
				$op." n.surname LIKE ".quote_smart($lastname);
			
			$where .= ")";
		}
		
		if (isset($search->filter)) {
			$where .= " AND (".$search->filter.")";
		}
		$query .= $fields.$from.$where;
		// and sort the query
		if (!$use_callback) {
			if (!isset($search->count)) {
				$search->count = 10;
			}
		}

		if ($search->queryType != Q_COUNT) {
			if (isset($search->order)) {
				$query .= " ORDER BY ".$search->order;
			} else {
				$query .= " ORDER BY n.surname, n.forenames, b.date1";
			}
			$this->addLimit($search, $query);
		}

		$result = $this->runQuery($query, $err_listpeeps);

		$search->numResults = 0;
		while ($row = $this->getNextRow($result)) {
			switch ($search->queryType) {
			case Q_COUNT:
				$search->numResults = $row["count"];
				break;
			default:
				$search->numResults++;
				$per = new PersonDetail();
				$per->loadFields($row, L_ALL, "p_");
				$per->name->loadFields($row, "n_");
				$per->name->person_id = $per->person_id;
				$per->updated = $row["p_updated"];
				$per->dupdated = $row["ddate"];
				if ($use_callback) {
					call_user_func($callback, $search, $per);
				} else {
					$res[] = $per;
				}
				break;
			}
		}
		$this->freeResultSet($result);
		$search->results = $res;
	}
	
	function getNearest(&$search) {
		global $tblprefix, $err_person,$currentRequest;
		
		$datefield = "fake_".$search->order;
		$res = array();

		// create the query based on the parameters
		$query = "SELECT ";
//TODO
		$fields = PersonDetail::getFields().
				", YEAR(b.date1) AS year_of_birth, ".
				"YEAR(d.date1) AS year_of_death".
				", death_reason, ".
				"mother_id, father_id, narrative, updated, DATE_FORMAT(updated, ".$currentRequest->datefmt.") AS ddate";
		//Create a fake birthday this year
		$fields .= ", CONCAT_WS('-', YEAR(NOW()), LPAD(MONTH(b.date1), 2, '0'), LPAD(DAYOFMONTH(b.date1), 2, '0')) AS fake_birth";
		//Create a fake death day this year
		$fields .= ", CONCAT_WS('-', YEAR(NOW()), LPAD(MONTH(d.date1), 2, '0'), LPAD(DAYOFMONTH(d.date1), 2, '0')) AS fake_death";
		
		$from = " FROM ".$tblprefix."people p ";
		$from .= PersonDetail::getJoins();
		
		// if the user is not logged in, only show people pre $restrictdate
		$where = $this->addPersonRestriction(" WHERE ");

		$where .= " HAVING ".$datefield." >= NOW() AND ".
			$datefield." <= date_add(NOW(), INTERVAL 41 DAY) ";
		
		$query .= $fields.$from.$where;
		// and sort the query

		$query .= " ORDER BY ".$datefield;
		$this->addLimit($search, $query);
		
		$result = $this->runQuery($query, $err_person);

		$search->numResults = 0;
		while ($row = $this->getNextRow($result)) {
			$search->numResults++;
			$per = new PersonDetail();
			$per->loadFields($row, L_HEADER, "p_");
			$per->name->loadFields($row,"n_");
			$per->year_of_birth = $row["year_of_birth"];
			$per->year_of_death = $row["year_of_death"];
			$res[] = $per;
		}
		$this->freeResultSet($result);
		$search->results = $res;
	}
	
	function getSurnames($order = 0) {
		global $tblprefix, $err_person;
		// provide a list of surnames
		$nquery = "SELECT p.person_id, n.surname, count(p.person_id) as number FROM ".$tblprefix."people p ";
		$nquery .= PersonDetail::getJoins();
		$nquery .= $this->addPersonRestriction(" WHERE ");
		$nquery .= " GROUP BY n.surname";
		if ($order == 1) {
			$nquery .= " ORDER BY number DESC";
			$search = new Base();
		//	$search->count = 10;
		//	$this->addLimit($search, $nquery);
		} else {
			$nquery .= " ORDER BY n.surname";
		}
		$result = $this->runQuery($nquery, $err_person);
		$ret = array();
		
		while ($row = $this->getNextRow($result)) {
			$per = new PersonDetail();
			$per->loadFields($row, L_HEADER);
			$per->name->surname = $row["surname"];
			$per->count = $row["number"];
			$ret[] = $per;
		}
		$this->freeResultSet($result);
		return ($ret);
	}
	
	function getParents(&$per) {
		global $tblprefix, $err_father;
		
		if (!isset($per->person_id)) {
			return;
		}
		
		$q = "SELECT ";
		$q .= PersonDetail::getFields("mum","nmum","bmum","dmum").",".
			PersonDetail::getFields("dad","ndad","bdad","ddad");
		$q .= " FROM ".$tblprefix."people p".
		" LEFT JOIN ".$tblprefix."people mum ON mum.person_id = p.mother_id ".
		PersonDetail::getJoins("LEFT","mum","nmum","bmum","dmum").
		" LEFT JOIN ".$tblprefix."people dad ON dad.person_id = p.father_id ".
		PersonDetail::getJoins("LEFT","dad","ndad","bdad","ddad");
		$q .= " WHERE p.person_id=".$per->person_id;
		
		$result = $this->runQuery($q, $err_father);
		while ($row = $this->getNextRow($result)) {
		
			$dad = new PersonDetail();
			$dad->loadFields($row, L_HEADER, "dad_");
			$dad->name->loadFields($row, "ndad_");
			$per->father = $dad;
			$mum = new PersonDetail();
			$mum->loadFields($row, L_HEADER, "mum_");
			$mum->name->loadFields($row, "nmum_");
			$per->mother = $mum;
		}
		$this->freeResultSet($result);
	}
	
	function getChildren(&$per) {
		global $tblprefix, $err_children;
		
		if (!isset($per->person_id)) {
			return(0);
		}
		
		$query = "SELECT ".PersonDetail::getFields().
		" FROM ".$tblprefix."people p ".
		PersonDetail::getJoins("LEFT").
		" WHERE ";
		if ($per->gender == "M") {
			$query .= " father_id = ".quote_smart($per->person_id);
		} else if ($per->gender == "F") {
			$query .= " mother_id = ".quote_smart($per->person_id);
		} else {
			$query .= "(father_id = ".quote_smart($per->person_id)." OR mother_id = ".quote_smart($per->person_id).")";
		}
		$query .= $this->addPersonRestriction(" AND ");
		$query .= " ORDER BY b.date1";
		
		$result = $this->runQuery($query, $err_children);
		
		$cnt = 0;
		while($row = $this->getNextRow($result)) {
			$cnt++;
			$child = new PersonDetail();
			$child->loadFields($row, L_HEADER, "p_");
			$child->name->loadFields($row, "n_");
			$per->children[] = $child;
		}
		$this->freeResultSet($result);
		
		return ($cnt);
	}
	
	function getSiblings(&$per) {
		global $tblprefix, $err_siblings;
		
		$parent = 0;
		
		$query = "SELECT p.person_id as p_person_id,";
		$query .= PersonDetail::getFields("p");
		$query .= " FROM ".$tblprefix."people p ";
		$query .= PersonDetail::getJoins("LEFT");
		$query .= "WHERE ";
		$query .= "(";
		$b = "";
		if (isset($per->mother->person_id) && $per->mother->person_id != "00000") {
			$parent++;
			$query .= " p.mother_id = '".$per->mother->person_id."'";
			$b = " OR ";
		}
		if (isset($per->father->person_id) && $per->father->person_id != "00000") {
			$parent++;
			$query .= $b." p.father_id = '".$per->father->person_id."'";
		}
		$query .= ") AND p.person_id != ".quote_smart($per->person_id);
		$query .= $this->addPersonRestriction(" AND ");
		$query .= " ORDER BY b.date1";
		
		if ($parent == 0){
			$per->siblings = array();
			return;
		}
		
		$result = $this->runQuery($query, $err_siblings);
		$res = array();
		
		$cnt = 0;
		while($row = $this->getNextRow($result)) {
			$cnt++;
			$child = new PersonDetail();
			$child->loadFields($row, L_HEADER, "p_");
			$child->name->loadFields($row, "n_");
			$res[] = $child;
		}
		$this->freeResultSet($result);
		
		$per->siblings = $res;
		return ($cnt);
	}
	
	function getTrackedPeople() {
		global $tblprefix, $currentRequest, $err_listpeeps;
		
		
		$query = "SELECT p.person_id as p_person_id,".
			PersonDetail::getFields().
			",updated, DATE_FORMAT(updated, ".$currentRequest->datefmt.") AS ddate".
			" FROM ".$tblprefix."people p ".
			PersonDetail::getJoins().
			" JOIN ".$tblprefix."tracking t ON p.person_id = t.person_id".
			" WHERE ".
			 "t.email = ".quote_smart($_SESSION["email"]);
		
		$result = $this->runQuery($query, $err_listpeeps);
		$res = array();
		
		
		while ($row = $this->getNextRow($result)) {
			$per = new PersonDetail();
			$per->loadFields($row, L_HEADER, "p_");
			$per->name->loadFields($row, "n_");
			$per->name->person_id = $per->person_id;
			$per->updated = $row["updated"];
			$per->dupdated = $row["ddate"];
		
			$res[] = $per;
		}
		return ($res);
	}
	
	function savePersonDetails(&$per) {
		global $tblprefix, $err_person_update, $err_detail, $currentRequest, $err_child_update;
		
		$rowsChanged = 0;
		
		$this->startTrans();
		
		$insert = false;
		
		if (isset($per->person_id) && $per->person_id > 0) {
			$query = "UPDATE ".$tblprefix."people SET death_reason = ".quote_smart($per->death_reason).", ".
					"gender = ".quote_smart($per->gender).", mother_id = ".quote_smart($per->mother->person_id).", father_id = ".quote_smart($per->father->person_id).", ".
					"narrative = ".quote_smart($per->narrative)." WHERE person_id = ".quote_smart($per->person_id)."";
			$msg = $err_person_update;
		} else {
			$this->lockTable($tblprefix."people");
			$query = "INSERT INTO ".$tblprefix."people (death_reason, gender, mother_id, father_id, narrative, updated, creator_id, created) VALUES (".
			quote_smart($per->death_reason).", ".quote_smart($per->gender).", ".quote_smart($per->mother->person_id).", ".quote_smart($per->father->person_id).", ".quote_smart($per->narrative).", NOW(), ".$currentRequest->id.", NOW())";
			$msg = $err_detail;
			$insert = true;
		}
		
		$ret = $this->runQuery($query, $msg);
		
		$rowsChanged += $this->rowsChanged($ret);
		
		if ($insert) {
			$per->person_id = $this->getInsertId();
			$this->unlockTable($tblprefix."people");
			$query = "INSERT INTO ".$tblprefix."names (person_id, title, forenames, link, surname, suffix, knownas) VALUES (".
				quote_smart($per->person_id).",".quote_smart($per->name->title).", ".quote_smart($per->name->forenames).", ".quote_smart($per->name->link).", ".quote_smart($per->name->surname).", ".quote_smart($per->name->suffix).", ".quote_smart($per->name->knownas).")";
			$ret = $this->runQuery($query, $msg);
		} else {
			$query = "UPDATE ".$tblprefix."names SET title = ".quote_smart($per->name->title).", forenames = ".quote_smart($per->name->forenames).
					", link = ".quote_smart($per->name->link).
					", surname = ".quote_smart($per->name->surname).", suffix = ".quote_smart($per->name->suffix).
					", knownas = ".quote_smart($per->name->knownas).
					" WHERE person_id = ".quote_smart($per->person_id)."";
			$ret = $this->runQuery($query, $msg);
		}
		
		$rowsChanged += $this->rowsChanged($ret);
		
		if (isset($per->child_id)) {
			if ($per->gender == "M") {
				$ucquery = "UPDATE ".$tblprefix."people SET father_id = '".$per->person_id.
					"' WHERE person_id = ".quote_smart($per->child_id);
			} else {
				$ucquery = "UPDATE ".$tblprefix."people SET mother_id = '".$per->person_id.
					"' WHERE person_id = ".quote_smart($per->child_id);
			}
			$ucresult = $this->runQuery($ucquery, $err_child_update);
		}
		
		$dao = getEventDAO();
		foreach ($per->events AS $e) {
			$e->person->person_id = $per->person_id;
			$rowsChanged += $dao->saveEvent($e);
		}
		
		$this->commitTrans();
		return ($rowsChanged);
	}
	
	function deletePerson($per) {
		global $tblprefix,$err_child_update,$err_person_delete;
		// there's a lot to do here
				
		$this->startTrans();
		
		$dao = getEventDAO();
		$dao->deletePersonEvents($per, BIRTH_EVENT);
		
		// delete transcripts
		$trans = new Transcript();
		$trans->person = $per;
		$tdao = getTranscriptDAO();
		$tdao->getTranscripts($trans);
		for ($i = 0; $i < $trans->numResults; $i++) {
			$tdao->deleteTranscript($trans->results[$i]);
		}

		// delete censuses
		$cdao = getCensusDAO();
		$cdao->deletePersonCensusRecord($per);
		
		// delete images
		$img = new Image();
		$img->person = $per;
		$idao = getImageDAO();
		$idao->getImages($img);
		for ($i = 0; $i < $img->numResults; $i++) {
			$idao->deleteImage($img->results[$i]);
		}
		
		// delete marriages
		$rdao = getRelationsDAO();
		$rdao->deletePersonRelationshipDetails($per);
		
		// delete tracking
		$dtquery = "DELETE FROM ".$tblprefix."tracking WHERE person_id = '".$per->person_id."'";
		$dtresult = $this->runQuery($dtquery, $err_person_delete);

		// update children to point to the right person
		$ucquery = "UPDATE ".$tblprefix."people SET mother_id = '0' WHERE mother_id = '".$per->person_id."'";
		$ucresult = $this->runQuery($ucquery, $err_child_update);
		$ucquery = "UPDATE ".$tblprefix."people SET father_id = '0' WHERE father_id = '".$per->person_id."'";
		$ucresult = $this->runQuery($ucquery, $err_child_update);

		// names
		$dpquery = "DELETE FROM ".$tblprefix."names WHERE person_id = '".$per->person_id."'";
		$dpresult = $this->runQuery($dpquery, $err_person_delete);
		
		// finally, the person
		$dpquery = "DELETE FROM ".$tblprefix."people WHERE person_id = '".$per->person_id."'";
		$dpresult = $this->runQuery($dpquery, $err_person_delete);

		$this->commitTrans();
	}
}
?>
