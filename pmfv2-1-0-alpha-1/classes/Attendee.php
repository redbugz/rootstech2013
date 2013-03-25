<?php

class Attendee extends Base {
	var $attendee_id;
  	var $event;
  	var $person;
  	var $age;
  	var $profession;
  	var $condition;
  	var $location;
  	var $loc_descrip;
  	var $certified;
  	var $notes;
	
	function Attendee() {
		$this->person = new PersonDetail();
		$this->event = new Event();
		$this->location = new Location();
	}
	
	static function getFields($prefix) {
		
		$fields = array("attendee_id", "event_id", "person_id", "age", "location_id", "profession",
			"r_status", "loc_descrip", "certified", "notes");
			
		$ret = Base::addFields($prefix, $fields);
		
		return ($ret);
	}
	
	function setFromPost($prefix = '') {
		$this->loadFields($_POST, $prefix);
		$this->age = htmlspecialchars($this->age, ENT_QUOTES);
		$this->profession = htmlspecialchars($this->profession, ENT_QUOTES);
		$this->loc_descrip = htmlspecialchars($this->loc_descrip, ENT_QUOTES);
		$this->notes = htmlspecialchars($this->notes, ENT_QUOTES);
	}
	function loadFields($row, $prefix='') {
		$this->attendee_id = $row[$prefix."attendee_id"];
  		$this->event->event_id = $row[$prefix."event_id"];
  		@$this->person->person_id = $row[$prefix."person_id"];
  		@$this->age = $row[$prefix."age"];
  		$this->profession = $row[$prefix."profession"];
  		@$this->condition = $row[$prefix."r_status"];
  		@$this->location->location_id = $row[$prefix."location_id"];
  		@$this->loc_descrip = $row[$prefix."loc_descrip"];
  		@$this->certified = $row[$prefix."certified"];
		if ($this->certified == '') {
			$this->certified = 'N';
		}
  		$this->notes = $row[$prefix."notes"];
	}
	
	function hasData() {
		if (isset($this->attendee_id) && $this->attendee_id > 0) {
			return (true);
		}
		if ($this->location->place == '' && $this->profession == '' &&
			$this->notes == '' && $this->age == '') {
			return (false);
		}
		return (true);
	}
}
?>