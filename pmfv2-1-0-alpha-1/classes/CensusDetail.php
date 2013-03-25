<?php
include_once "Base.php";
include_once "Location.php";
include_once "PersonDetail.php";

class CensusDetail extends Base {
	
	var $census;
	var $censusId;
	var $year;
	var $country;
	var $event;
	var $schedule;
	
	function CensusDetail() {
		$this->person = new PersonDetail();
		$this->place = new Location();
		$this->event = new Event();
	}
	function setFromRequest() {
		$this->person->setFromRequest();
		$this->event->setFromRequest();
		if (isset($_REQUEST["census"])) {
			$this->census = quote_smart($_REQUEST["census"]);
		}
		if (isset($_REQUEST["ref"])) {
			$this->schedule = quote_smart($_REQUEST["ref"]);
		}
	}
	
	function setFromPost() {
		$this->person->setFromPost();
	
		$this->census = $_POST["frmYear"];
		$this->schedule = htmlspecialchars($_POST["schedule"], ENT_QUOTES);
		
	}
	
	function loadFields($row) {
		$this->year = $row["year"];
		$this->country = $row["country"];
		$this->census = $row["census"];
		$this->schedule= $row["schedule"];
	}
	
	function getEditTitle() {
		global $strNewCensus, $strEditing, $strCensus;
		$ret = '';
		if (isset($this->census)) {
			$ret = $strEditing." ".$strCensus.": ".$this->event->person->getDisplayName()."(".$this->year.")";
		} else {
			$ret = ucwords($strNewCensus).": ".$this->event->person->getDisplayName();
		}
		return ($ret);
	}
}