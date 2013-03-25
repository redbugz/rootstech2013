<?php

/**
The aim is that this class will eventually support both places and addresses
*/
class Location extends Base {
	
	var $location_id;
	var $name;
	var $place;
	
	var $lat;
	var $lng;
	var $text;
	var $birth = false;
	var $marriage = false;
	var $census = false;
	var $centre = false; //Use to indicate the central point on the map
	
	function setFromRequest() {
		@$this->location_id = $_REQUEST["location"];
	}
	
	function setFromPost($prefix) {
		$this->loadFields($_POST,$prefix);
		$this->name = htmlspecialchars($this->name, ENT_QUOTES);
		$this->place = $this->name;
	}
	
	function getDisplayPlace() {
		$ret = $this->place;
		return ($ret);
	}
	
	function getEditLink() {
		$ret = $this->getDisplayPlace();
		if ($this->isEditable()) {
			$ret = '<a href="edit.php?func=edit&amp;area=location&amp;location='.$this->location_id.'">'.$ret.'</a>';
		}
		return ($ret);
	}
	
	function getAtDisplayPlace() {
		global $strAt;
		$ret = "";
		if ($this->place != "") {
			$ret = " ".$strAt." ";
		}
		$ret .= $this->getDisplayPlace();
		return ($ret);
	}
	
	static function getFields($tbl) {		
		$fields = array("location_id", "name", "place", "lat", "lng", "centre");
			
		$ret = Base::addFields($tbl, $fields);
		return ($ret);
	}
	
	function loadFields($row, $prefix) {
		@$this->location_id = $row[$prefix."location_id"];
		@$this->name = $row[$prefix."name"];
		@$this->place = $row[$prefix."place"];
		@$this->lat = $row[$prefix."lat"];
		@$this->lng = $row[$prefix."lng"];
		@$this->centre = $row[$prefix."centre"];
	}
	
	function hasData() {
		if ($this->location_id > 0 || $this->name <> '') {
			return(true);
		}
		return (false);
	}
	function setPermissions() {
		$config = Config::getInstance();
		if($_SESSION["editable"] == "Y") {
			$this->editable = true;
			$this->creatable = true;
			$this->deletable = true;
			$this->exportable = true;
		}
	}
}
?>