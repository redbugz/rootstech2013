<?php
include_once "classes/Archive.php";

class Image extends Archive {

	var $image_id;
	function setFromRequest() {
		parent::setFromRequest();
		if (isset($_REQUEST["image"])) { $this->image_id = $_REQUEST["image"]; }
	}
	
	function getImageFile() {
		$config = Config::getInstance();
		return ("output.php?image=".$this->image_id);
	}
	
	function getThumbnailFile() {
		$config = Config::getInstance();
		return ($this->getImageFile()."&amp;thumb=true");
	}
	
	function getLink() {
		return ("<a href=\"image.php?image=".$this->image_id."\">".
			"<img src=\"".$this->getThumbnailFile()."\" width=\"100\" height=\"100\" border=\"0\" title=\"".$this->getDescription()."\" alt=\"".$this->getDescription()."\" /></a>");
	}

	function getTitleLink() {
		return ("<a href=\"image.php?image=".$this->image_id."\">".$this->getTitle()."</a>");
	}
}
?>