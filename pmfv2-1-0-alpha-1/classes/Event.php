<?php
include_once("inc/DateUtil.php");
define('BIRTH_EVENT', 0);
define('BAPTISM_EVENT', 1);
define('DEATH_EVENT', 2);
define('BURIAL_EVENT', 3);
define('BANNS_EVENT', 4);
define('MARRIAGE_EVENT', 5);
define('CENSUS_EVENT', 6);
define('OTHER_EVENT', 7);
define('IMAGE_EVENT', 8);
define('DOC_EVENT', 9);

define('DATE_DEFAULT', 0);
define('DATE_ABOUT', 1);
define('DATE_CIRCA', 2);
define('DATE_EST', 3);
define('DATE_APPROX', 4);
define('DATE_CALC', 5);
define('DATE_BEFORE', 6);
define('DATE_AFTER', 7);
define('DATE_ON', 8);
define('DATE_IN', 9);
define('DATE_PROB', 10);
define('DATE_FROM', 11);
define('DATE_TO', 12);
define('DATE_BETWEEN', 13);

class Event extends Base {
	var $event_id;
	var $type;
	var $descrip; //To describe other events
	var $person;
	var $location;
	var $date1;
	var $date1_modifier = 0;
	var $fdate1;
	var $date2 = '0000-00-00';
	var $date2_modifier = 0;
	var $fdate2;
	var $notes;
	
	var $attendees;
	var $sources;
	
	function Event() {
		$this->person = new PersonDetail();
		$this->location = new Location();
		$this->attendees = array();
	}
	
	function setFromRequest() {
		@$this->event_id = $_REQUEST["event"];
	}
	
	static function getFields($prefix) {
		global $currentRequest;
		
		$fields = array("event_id", "etype", "descrip", "person_id", "location_id", "d1type", "date1", "d2type", "date2", "notes");
			
		$ret = Base::addFields($prefix, $fields);
		$ret .= ", DATE_FORMAT(".$prefix.".date1, ".$currentRequest->datefmt.") AS ".$prefix."_fdate1";
		//$ret .= ", DATE_FORMAT(".$prefix.".date2, ".$currentRequest->datefmt.") AS ".$prefix."_fdate2";
		return ($ret);
	}
	
	function setFromPost($prefix = '') {
		$this->loadFields($_POST, $prefix);
		$this->descrip = htmlspecialchars($this->descrip, ENT_QUOTES);
		$this->notes = htmlspecialchars($this->notes, ENT_QUOTES);
		//Required in addition to the processing in loadFields
		$this->location->setFromPost($prefix);
		$this->date1 = DateUtil::resolveDate($this->date1);
		$this->date2 = DateUtil::resolveDate($this->date2);
		
	}
	function loadFields($row, $prefix) {
		@$this->event_id = $row[$prefix."event_id"];
		@$this->type = $row[$prefix."etype"];
		@$this->descrip = $row[$prefix."descrip"];
		@$this->person->person_id = $row[$prefix."person_id"];
		@$this->date1 = $row[$prefix."date1"];
		if (isset($row[$prefix."d1type"])) { $this->date1_modifier = $row[$prefix."d1type"]; }
		@$this->fdate1 =  $row[$prefix."fdate1"];
		//Not used at present
		//@$this->date2 = $row[$prefix."date2"];
		//@$this->date2_modifier = $row[$prefix."d2type"];
		//@$this->fdate2 =  $row[$prefix."fdate2"];
		@$this->notes = $row[$prefix."notes"];
		$this->location->loadFields($row, $prefix);
	}
	
	function hasData() {
		$ret = true;
		if ((isset($this->event_id) && $this->event_id > 0) || $this->location->hasData()) {
			$ret = true;
		}
		if ($this->location->hasData() == false && $this->date1 == '0000-00-00' && $this->notes == '') {
			$ret = false;
		}
		return ($ret);
	}
	
	function getDate1() {
		$ret = formatdate($this->fdate1);
		return ($ret);
	}
	
	function getFullDisplay($class) {
		global $strEventVerb, $strDateDescr, $strNotes, $strOn;

		$ret = '<div class="'.$class.'">';
		$ret .= $strEventVerb[$this->type]. " ".$this->descrip;
		if ($this->getDate1() != '0000-00-00') {
			if ($strDateDescr[$this->date1_modifier] == '') {
				$ret .= " ".$strOn;
			}
			$ret .= " ";
			$ret .= $strDateDescr[$this->date1_modifier]." ";
			$ret .= $this->getDate1();
		}
		
		$ret .= $this->location->getAtDisplayPlace();
		if ( $this->notes != "") { $ret .= '<div id="notes"><div class="label">'.$strNotes.":</div> ".$this->notes."</div>"; }
		if (is_array($this->results) && count($this->results) > 0) {
			foreach ($this->results as $src) {
				$ret .= $src->getFullDisplay();
			}
		}
		$ret .= "</div>";
		
		return ($ret);
	}
}
?>