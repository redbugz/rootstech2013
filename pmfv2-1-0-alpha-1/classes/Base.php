<?php
define('Q_INSERT', 0);
define('Q_UPDATE', 1);

define('Q_IND', 2);
define('Q_FAMILY', 3);
define('Q_TYPE', 4);
define('Q_COUNT', 5);
define('Q_RANDOM', 6);

define('Q_LIKE', 7);
define('Q_MATCH', 8);

class Base {
	
	var $person;
	var $updated;
	var $dupdated; //The display form of updated
	var $changed = false;
	
	var $results;
	var $matchResult;
	var $queryType;
	var $numResults;
	var $count;
	var $start;
	var $order;
	var $filter;
	
	var $editable = false;
	var $creatable = false;
	var $viewable = false;
	var $deletable = false;
	var $exportable = false;
	
	function isEditable() {
		return $this->editable;
	}
	
	function isDeletable() {
		return $this->deletable;
	}
	
	function isCreatable() {
		return $this->creatable;
	}
	
	function isViewable() {
		return $this->viewable;
	}
	
	function isExportable() {
		return $this->exportable;
	}
	
	static function addFields($tbl, $fields) {
			
		$addComma = false;
		$prefix = "";
		$tbl_pref = "";
		if (strlen($tbl) > 0) {
			$prefix = $tbl."_";
			$tbl_pref = $tbl.".";
		} 
		$ret = "";
		foreach($fields as $f) {
			if ($addComma) { $ret .= ","; }
			$ret .= $tbl_pref.$f." AS ".$prefix.$f;
			$addComma = true;
		}
		
		return ($ret);
	}
}

// function: add_quotes
	// detect if magic_quotes is off, and quote a string if needed
	function add_quotes($str) {

		// chck to see if quotes are on
		if (get_magic_quotes_gpc())
			return $str;
		// and add slashes if not
		else
			return addslashes($str);
	}	// end of add_quotes()
	
	// function formatdate
	// allows unknown to be displayed when no details kknown
	function formatdate($origdate) {
		global $strUnknown;
		global $currentRequest;

		// if there are any non-zero numbers, then display as is
		if ($origdate == $currentRequest->nulldate)
			return $strUnknown;
		// else return unknown
		else
			return $origdate;
	} // end of formatdate()
?>