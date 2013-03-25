<?php

class Relationship extends Base {
	var $person;
	var $relation;
	var $oldRelation;
	var $marriage_date;
	var $dom; //formatted date as php doesn't work well for this
	var $marriage_cert;
	var $marriage_place;
	var $dissolve_date;
	var $dod;
	var $dissolve_reason;
	var $event;
	
	function Relationship() {
		$this->person = new PersonDetail();
		$this->relation = new PersonDetail();
		$this->marriage_place = new Location();
		$this->event = new Event();
	}
	
	function setFromRequest() {
		$this->person->setFromRequest();
		$this->event->setFromRequest();
		if (isset($_REQUEST["spouse"])) { $this->relation->person_id = quote_smart($_REQUEST["spouse"]); }
	}
	
	function setFromPost() {
		$this->person->setFromPost();
		
		$this->relation->person_id = $_POST["frmSpouse"];
		$this->oldRelation = $_POST["oldSpouse"];
		$this->dissolve_date = $_POST["frmDissolveDate"];
		$this->dissolve_reason = $_POST["frmDissolveReason"];
	}
	
	function loadFields($edrow) {
		$this->dissolve_date = $edrow["dissolve_date"];
		$this->dod = $edrow["DOD"];
		$this->dissolve_reason = $edrow["dissolve_reason"];
		$this->event->event_id = $edrow["event_id"];
	}
	function isEditable() {
		return $this->person->isEditable() && $this->relation->isEditable();
	}
	
	function isDeletable() {
		return $this->person->isDeletable() && $this->relation->isDeletable();
	}
	
	function isCreatable() {
		return $this->person->isCreatable() && $this->relation->isCreatable();
	}
	
	function isViewable() {
		return $this->person->isViewable() && $this->relation->isViewable();
	}
	
	function isExportable() {
		return $this->person->isExportable() && $this->relation->isExportable();
	}
}
?>
