<?php
define('NAME_SEP',"\t");

class Name extends Base {
	
	var $type;
	var $title;
	var $forenames;
	var $link;
	var $suffix;
	var $surname;
	var $knownas;

	function setFromPost() {
		if (isset($_POST["person"])) { $this->person_id = quote_smart($_POST["person"]);}		
		
		$this->title = trim(htmlspecialchars($_POST["frmTitle"], ENT_QUOTES));
		$this->forenames = trim(htmlspecialchars($_POST["frmForenames"], ENT_QUOTES));
		$this->link = trim(htmlspecialchars($_POST["frmLink"], ENT_QUOTES));
		$this->surname = trim(htmlspecialchars($_POST["frmSurname"], ENT_QUOTES));
		$this->knownas = trim(htmlspecialchars($_POST["frmAKA"], ENT_QUOTES));
		$this->suffix = trim(htmlspecialchars($_POST["frmSuffix"]));
	}

	
	function loadFields($edrow, $prefix = '') {
		$this->title = $edrow[$prefix."title"];
		$this->forenames = $edrow[$prefix."forenames"];
		$this->link = $edrow[$prefix."link"];
		$this->surname = $edrow[$prefix."surname"];
		$this->suffix = $edrow[$prefix."suffix"];
		$this->knownas = $edrow[$prefix."knownas"];
	}
	
	//Minimum fields to display a person, and work out whether they should be 
	//shown
	static function getFields($tbl) {
		global $currentRequest;
		
		$fields = array("title", "forenames", "link", "surname", "suffix", "knownas");
			
		return (Base::addFields($tbl, $fields));
	}
	
	function getDisplayName() {
		$ret = $this->title;
		if (strlen($ret) > 0) {
			$ret .= " ";
		}
		$ret .= $this->forenames." ";
		if (strlen($this->link)) {
			$ret .= $this->link." ";
		}
		$ret .= $this->surname;
		if (strlen($this->suffix)) {
			$ret .= " ".$this->suffix;
		}
		return($ret);
	}
	
	function getReverseName() {
		$ret = $this->surname;
		if (strlen($this->suffix)) {
			$ret .= NAME_SEP.$this->suffix;
		}
		$ret .=",";
		if (strlen($this->title)) {
			$ret .= NAME_SEP.$this->title.NAME_SEP;
		} else {
			$ret .= " ";
		}
		$ret .= $this->forenames;
		if (strlen($this->link)) {
			$ret .= NAME_SEP.$this->link;
		}
		return ($ret);
	}

	function parseReverseName($name) {
		$names = explode(',', $name);
		$lastname = $names[0];
		
		//Assume that there are no spaces in a valid last name
		$lnames = explode(NAME_SEP, $lastname);
		if (count($lnames) > 1) {
			$lastname = $lnames[0];
			$this->suffix = trim($lnames[1]);
		}
		
		if (count($names) > 1) {
		
			$fnames = explode(NAME_SEP, $names[1]);
			if (count($fnames) > 2) {
			//tricky to parse - title and forenames can contain the same values e.g. Earl
				$this->forenames = trim($fnames[2]);
				$this->title = trim($fnames[1]);
				if (count($fnames) > 3) {
					$this->link = trim($fnames[3]);
				}
			} else if (count($fnames) > 0) {
				$this->forenames = trim($fnames[0]);
				@$this->link = trim($fnames[1]);
			} else {
				$this->forenames = trim($fnames[0]);
			}
		}		
		$this->surname = trim($lastname);
	}

}

?>