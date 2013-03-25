<?php
include_once("classes/Location.php");

class MiniEvent {
	public $type;
	public $date1;
	public $date1_modifier = 0;
	public $date2_modifier = 0;
	public $date2 = '0000-00-00';
	public $location;
	function MiniEvent() {
		$this->location = new Location();
	}
}

?>