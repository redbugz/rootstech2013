<?php
include_once "classes/Source.php";

class SourceDAO extends MyFamilyDAO {

	function getSources(&$source, $type = Q_LIKE) {
		global $tblprefix, $err_locations;
		$res = array();
		$squery = "SELECT source_id as s_source_id,".Source::getFields("s").
			" FROM ".$tblprefix."source s ";

		if (isset($source->source_id) && $source->source_id <> '') {
			$squery .= "WHERE source_id = ".quote_smart($source->source_id);
		} else if (isset($source->title) && $source->title <> '%') {
			if ($type == Q_LIKE) {
				$squery .= "WHERE title LIKE ".quote_smart($source->title);
			} else {
				$squery .= "WHERE title = ".quote_smart($source->title);
			}
		}
		$squery .= " ORDER BY title";
		$this->addLimit($source, $squery);
		//TODO - error message
		$result = $this->runQuery($squery, '');

		$source->numResults = 0;
		while ($row = $this->getNextRow($result)) {
			$s = new Source();
			$s->loadFields($row, "s_");
			$s->setPermissions();
			$source->numResults++;
			$res[] = $s;
		}
		$this->freeResultSet($result);
		$source->results = $res;
	}

	//Looks up a source based on title and creates one
	//if it does not exist
	function resolveSource(&$source) {
		$rowsChanged = 0;
		if ($source->title <> '') {
			if($source->source_id == '') {
				$this->getSources($source, Q_MATCH);
				if ($source->numResults > 0) {
					$source = $source->results[0];
				} else {
					$rowsChanged += $this->saveSource($source);
				}
			}
		} else {
			$source->source_id = -1;
		}

		return($rowsChanged);
	}

	
	function getEventSources(&$event) {
		global $tblprefix, $restrictdate, $strEvent, $datefmt;

		$event->numResults = 0;
		
		$pquery = "SELECT s.source_id as s_source_id, ".Source::getFields("s").
			" FROM ".$tblprefix."source s".
			" JOIN ".$tblprefix."source_event se ON s.source_id=se.source_id";
			
		if ($event->event_id > 0) {
			$pquery .= " AND se.event_id = ".$event->event_id;
		} else {
			return;
		}

		$presult = $this->runQuery($pquery, "");

		while ($row = $this->getNextRow($presult)) {
			$s = new Source();
			$s->source_id = $row["s_source_id"];
			$s->loadFields($row, "s_");
			$event->results[] = $s;
			$event->numResults++;
		}
		$this->freeResultSet($presult);
	}

	function getSourceEvents(&$source) {
		global $tblprefix, $restrictdate, $strEvent, $datefmt;

		$pquery = "SELECT s.source_id, ".Source::getFields("s").",".
			Event::getFields("e").",".
			PersonDetail::getFields('p').
			" FROM ".$tblprefix."source s".
			" JOIN ".$tblprefix."source_event se ON s.source_id=se.source_id".
			" JOIN ".$tblprefix."event e ON se.event_id=e.event_id".
			" JOIN ".$tblprefix."people p ON e.person_id = p.person_id".
			PersonDetail::getJoins();
			
		if ($source->source_id > 0) {
			$pquery .= " WHERE s.source_id = ".$source->source_id;
		}

		$presult = $this->runQuery($pquery, "");
		$source->numResults = 0;
		while ($row = $this->getNextRow($presult)) {
			$e = new Event();
			$e->loadFields($row, "e_");
			$e->person->loadFields($row, L_HEADER, "p_");
			$e->person->name->loadFields($row, "n_");
			$e->person->setPermissions();
			$source->results[] = $e;
			$source->numResults++;
		}
		$this->freeResultSet($presult);
	}

	function saveSourceEvent($source, $event) {
		global $tblprefix;
		$rowsChanged = 0;
		if ($source->source_id > 0 && $event->event_id > 0) {
			$query = sprintf("INSERT INTO ".$tblprefix."source_event (source_id, event_id) VALUES (%d, %d);",
				$source->source_id, $event->event_id);
			$update_result = $this->runQuery($query, "");
			$rowsChanged = $this->rowsChanged($update_result);
		}
		
		return($rowsChanged);
	}
	
	function saveSource(&$source) {
		global $tblprefix;

		$rowsChanged = 0;
	  			
		if (isset($source->source_id) && $source->source_id > 0) {
			$query = sprintf("UPDATE ".$tblprefix."source" .
			" SET title=%s, reference=%s, url=%s, ref_date=%s, notes = %s, certainty = %d WHERE source_id =".$source->source_id,
			quote_smart($source->title),
			quote_smart($source->reference),
			quote_smart($source->url),
			quote_smart($source->ref_date),
			quote_smart($source->notes),
			$source->certainty);
			$update_result = $this->runQuery($query, "");
			$rowsChanged += $this->rowsChanged($update_result);
		} else {
			$this->lockTable($tblprefix."source");
			$query = sprintf("INSERT INTO ".$tblprefix."source" .
			" (title, reference, url, ref_date, notes, certainty) VALUES (%s,%s,%s, %s, %s, %d) ;",
			quote_smart($source->title),
			quote_smart($source->reference),
			quote_smart($source->url),
			quote_smart($source->ref_date),
			quote_smart($source->notes),
			$source->certainty);
			$update_result = $this->runQuery($query, "");
			$rowsChanged += $this->rowsChanged($update_result);
			$source->source_id = $this->getInsertId();
			$this->unlockTable($tblprefix."source");
		}
		return ($rowsChanged);
	}

	function deleteSourceEvent($source, $event) {
		global $tblprefix;

		//TODO error messages
		$dquery = "DELETE FROM ".$tblprefix."source_event WHERE ";
		$a = "";
		$run = false;
		if ($source != null && isset($source->source_id)) {
			$dquery .= " source_id = ".$source->source_id;
			$a = " AND ";
			$run = true;
		}
		if ($event != null && isset($event->event_id)) {
			$dquery .= $a." event_id=".$event->event_id;
			$run = true;
		}
		if ($run) {
			$dresult = $this->runQuery($dquery, '');
		}
		return($dresult);
	}
	
	function deleteSource($source) {
		global $tblprefix;
		$this->startTrans();
		//TODO error messages
		$dquery = "DELETE FROM ".$tblprefix."source_event WHERE source_id = ".$source->source_id;
		$dresult = $this->runQuery($dquery, '');

		$dquery = "DELETE FROM ".$tblprefix."source WHERE location_id = ".$source->source_id;
		$dresult = $this->runQuery($dquery, '');
		$this->commitTrans();
	}
}
?>
