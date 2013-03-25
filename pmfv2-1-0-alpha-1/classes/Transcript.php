<?php
include_once "classes/Archive.php";

class Transcript extends Archive {
	
	var $transcript_id;
	
	function setFromRequest() {
		parent::setFromRequest();
		if (isset($_REQUEST["transcript"])) { $this->transcript_id = $_REQUEST["transcript"]; }
		//For compatibility
		if (isset($_REQUEST["docid"])) { $this->transcript_id = $_REQUEST["docid"]; }
	}
	
	function setFromPost() {
		parent::setFromPost();
		if (isset($_POST["transcript_id"])) { $this->transcript_id = $_POST["transcript_id"]; }
	}
	function getFileName() {
		$config = Config::getInstance();
		return($config->filedir.$this->transcript_id);
	}
}
?>