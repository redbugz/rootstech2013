<?php

class GedcomDAO extends MyFamilyDAO {
	
	function insertReference($gedref, $db, $file, $uid) {
		global $tblprefix;

		$iquery = "INSERT INTO ".$tblprefix."gedcom (gedrefid, person_id, gedfile, uid) VALUES (".
				quote_smart($gedref).",".quote_smart($db).",".quote_smart($file).",".quote_smart($uid).")";
		$iresult = $this->runQuery($iquery, "failed to insert reference data");
		return ($iresult);
	}
	
	function getReferences($id) {
		global $tblprefix;
		
		$q = "SELECT gedrefid, gedfile FROM ".$tblprefix."gedcom WHERE person_id=".quote_smart($id);
		$result = $this->runQuery($q, "failed to read gedcom references");
		$rows = array();
		while($row = $this->getNextRow($result)) {
			$rows[] = $row;
		}
		return $rows;
	}
}
?>