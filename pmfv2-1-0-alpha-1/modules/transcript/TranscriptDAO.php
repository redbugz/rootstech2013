<?php
include_once "classes/Transcript.php";

class TranscriptDAO extends MyFamilyDAO {
	
	function updateTranscript($trans) {
		global $tblprefix, $err_transcript;
		$this->startTrans();
		$iquery = "UPDATE ".$tblprefix."documents SET doc_title=".quote_smart($trans->title).
			", source_id = ".$trans->source->source_id.
			", file_name = ".quote_smart($trans->file_name).
			" WHERE id = ".quote_smart($trans->transcript_id);
		$iresult = $this->runQuery($iquery, $err_transcript);

		$dao = getEventDAO();

		$rowsChanged += $dao->saveEvent($trans->event);
		$this->commitTrans();
		
		return ($iresult);
	}
	
	function createTranscript(&$trans) {
		global $tblprefix, $err_transcript;
		
		$dao = getEventDAO();
		$this->startTrans();
		
		$rowsChanged = $dao->saveEvent($trans->event);

		$iquery = "INSERT INTO ".$tblprefix."documents (doc_title, file_name, event_id, source_id) VALUES ".
				"(".quote_smart($trans->title).", ".quote_smart($trans->file_name).",".$trans->event->event_id.",".$trans->source->source_id.")";
		$iresult = $this->runQuery($iquery, $err_transcript);
		$trans->transcript_id = str_pad($this->getInsertId(), 5, 0, STR_PAD_LEFT);
		$this->commitTrans();
		return ($iresult);
	}
		
	function getTranscripts(&$trans, $eid = -1, $sid = -1) {
		global $tblprefix, $err_trans, $currentRequest;
		$res = array();
		$squery = "SELECT p.person_id, id, doc_title, file_name, e.event_id, e.descrip, e.date1,".
			Event::getFields("e").",".
			Source::getFields("s").", s.source_id as s_source_id,".
			PersonDetail::getFields().
			" FROM ".$tblprefix."documents doc".
			" LEFT JOIN ".$tblprefix."event e ON e.event_id = doc.event_id ".
			" LEFT JOIN ".$tblprefix."people p ON p.person_id = e.person_id ".
			" LEFT JOIN ".$tblprefix."source s ON s.source_id = doc.source_id ".
			PersonDetail::getJoins("LEFT");
		
		if ($sid > 0) {
			$squery .= " WHERE s.source_id = ".quote_smart($sid);
		} else if ($eid > 0) {
			$squery .= " WHERE e.event_id = ".quote_smart($eid);
		} else if (isset($trans->person->person_id) && $trans->person->person_id > 0) {
			$squery .= " WHERE ";
			$squery .= "p.person_id = ".quote_smart($trans->person->person_id);
			$squery .= $this->addPersonRestriction(" AND ");
			if (isset($trans->transcript_id)) {
				$squery .= " AND id=".$trans->transcript_id;
			}
			$squery .= " ORDER BY e.date1";
		} else {
			$bool = " WHERE ";
			if (isset($trans->transcript_id)) {
				$squery .= " WHERE id=".$trans->transcript_id;
				$bool = " AND ";
			}
			$squery .= $this->addPersonRestriction($bool).
			" ORDER BY b.date1";
		}
	
		$result = $this->runQuery($squery, $err_trans);
		$trans->numResults = 0;
		while ($row = $this->getNextRow($result)) {
			$t = new Transcript();
			$t->person = new PersonDetail();
			$t->person->loadFields($row, L_HEADER, "p_");
			$t->person->name->loadFields($row, "n_");
			$t->person->person_id = $row["person_id"];
			$t->transcript_id = $row["id"];
			$t->event = new Event();
			$t->event->loadFields($row, "e_");
			$t->event->event_id = $row["event_id"];
			$t->source = new Source();
			$t->source->loadFields($row, "s_");
			$t->description = $t->event->descrip;
			$t->date = $t->event->date1;

			$t->title = $row["doc_title"];

			$t->file_name = $row["file_name"];
			$trans->numResults++;
			$res[] = $t;
		}
		$this->freeResultSet($result);
		$trans->results = $res;
	}
	
	function deleteTranscript($trans) {
		global $tblprefix, $err_trans_delete, $err_trans_file;
		$dresult = false;
		if (@unlink($trans->getFileName()) || !file_exists($trans->getFileName())) {
			$dquery = "DELETE FROM ".$tblprefix."documents WHERE id = '".$trans->transcript_id."'";
			$dresult = $this->runQuery($dquery, $err_trans_delete);
		} else {
			die($err_trans_file);
		}
		return ($dresult);
	}
	
}
?>