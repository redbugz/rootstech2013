<?php

class Archive extends Base {

	var $title;
	var $file_name;
	var $event;
	var $source;

	function setFromRequest() {
		$this->person = new PersonDetail();
		$this->person->setFromRequest();
	}
	
	function setFromPost() {
		$this->person = new PersonDetail();
		$this->person->setFromPost();
		$this->title = htmlspecialchars($_POST["frmTitle"], ENT_QUOTES);
		if (isset($_REQUEST["image_id"])) { $this->image_id = $_REQUEST["image_id"]; }
		@$this->file_name = $_FILES["userfile"]["name"];
		@$this->tmp_file_name = $_FILES["userfile"]["tmp_name"];
	}
	
	function getTitle() {
		return (htmlentities($this->title,ENT_QUOTES));
	}
	
	function getDescription() {
		return (htmlentities($this->description,ENT_QUOTES));
	}
}
?>