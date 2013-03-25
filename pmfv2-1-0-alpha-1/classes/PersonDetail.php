<?php
include_once "classes/Base.php";
include_once "classes/Name.php";
include_once "classes/Event.php";

class PersonDetail extends Base {
	
	var $person_id;
	var $name;
	var $gender;
	var $date_of_birth;
	var $dob; //formatted date_of_birth since php doesn't work well for this
	var $birth_cert;
	var $birth_place;
	var $year_of_birth;
	var $date_of_death;
	var $year_of_death;
	var $dod;
	var $death_cert;
	var $death_reason;
	var $mother;
	var $father;
	var $narrative;
	var $child_id;
	
	var $children;
	var $siblings;
	
	var $events;
	
	function PersonDetail() {
		$this->name = new Name();
		$this->events = array();
		$this->children = array();
		$this->siblings = array();
	}
	
	function setFromRequest() {
		if (isset($_REQUEST["person"])) { $this->person_id = quote_smart($_REQUEST["person"]);}
	}
	
	function setFromPost() {
		global $strEvent;
		
		if (isset($_POST["person"])) { $this->person_id = quote_smart($_POST["person"]);}		
		if (isset($_POST["frmChild"])) { $this->child_id = quote_smart($_POST["frmChild"]);}
		if (isset($_POST["frmGender"])) { $this->gender = $_POST["frmGender"]; }
		//Ignore the rest if we don't need them
		if (!isset($_POST["frmSurname"])) {
			return;
		}
		@$frmBCert = $_POST["frmBCert"];
		if ($frmBCert == "") {
			$frmBCert = "N";
		}
		@$frmDCert = $_POST["frmDCert"];
		if ($frmDCert == "") {
			$frmDCert = "N";
		}
		$this->name = new Name();
		$this->name->setFromPost();
		$this->death_reason = htmlspecialchars($_POST["frmDeathReason"], ENT_QUOTES);
		$this->mother = new PersonDetail();
		@$this->mother->person_id = $_POST["frmMother"];
		$this->father = new PersonDetail();
		@$this->father->person_id = $_POST["frmFather"];
		$this->narrative = add_quotes($_POST["frmNarrative"]);
		
	}

	function hasRecord() {
		$ret = false;
		if (isset($this->person_id) && $this->person_id != "00000") {
			$ret = true;
		}
		return ($ret);
	}
	function setPermissions() {
		$config = Config::getInstance();
		if($_SESSION["editable"] == "Y") {
			$this->editable = true;
			$this->creatable = true;
			$this->deletable = true;
			$this->exportable = true;
		}
		
		if ($_SESSION["id"] == 0 && $this->date_of_birth > $config->restrictdate) {
			$this->viewable = false;
		} else {
			$this->viewable = true;
		}
	}
	
	
	function loadFields($edrow, $type, $prefix = '') {
		$this->person_id = $edrow[$prefix."person_id"];
		if(array_key_exists($prefix."gender", $edrow)) {
			$this->gender = $edrow[$prefix."gender"];
		}
		if(array_key_exists($prefix."date_of_birth", $edrow)) {
			$this->date_of_birth = $edrow[$prefix."date_of_birth"];
			$this->dob = $edrow[$prefix."DOB"];
		}
		if(array_key_exists($prefix."date_of_death", $edrow)) {
			$this->date_of_death = $edrow[$prefix."date_of_death"];
			$this->dod = $edrow[$prefix."DOD"];
		}
		$this->setPermissions();
		if ($type == L_HEADER) {
			return;
		}
		
		$this->year_of_birth = $edrow[$prefix."year_of_birth"];
		
		$this->birth_place = new Location();
		$this->birth_place->place = $edrow[$prefix."birth_place"];
		
		$this->death_reason = $edrow[$prefix."death_reason"];
		if (!isset($this->mother)) { $this->mother = new PersonDetail(); }
		$this->mother->person_id = $edrow[$prefix."mother_id"];
		if (!isset($this->father)) { $this->father = new PersonDetail(); }
		$this->father->person_id = $edrow[$prefix."father_id"];
		$this->narrative = $edrow[$prefix."narrative"];
	}
	
	//Minimum fields to display a person, and work out whether they should be 
	//shown
	static function getFields($tbl = 'p', $name = 'n', $birth = 'b', $death = 'd') {
		global $currentRequest;
		
		$fields = array("person_id","gender");
			
		$ret = Base::addFields($tbl, $fields);
		$prefix = "";
		$tbl_pref = "";
		if (strlen($tbl) > 0) {
			$prefix = $tbl."_";
			$tbl_pref = $tbl.".";
		} 
		$ret .= ", DATE_FORMAT(".$birth.".date1, ".$currentRequest->datefmt.") AS ".$prefix."DOB";
		$ret .= ", ".$birth.".date1 AS ".$prefix."date_of_birth"; 
		$ret .= ", DATE_FORMAT(".$death.".date1, ".$currentRequest->datefmt.") AS ".$prefix."DOD"; 
		$ret .= ", ".$death.".date1 AS ".$prefix."date_of_death";
		$ret .= ", ".Name::getFields($name);
		return ($ret);
	}
	
	static function getJoins($type = '', $tbl = 'p', $name = 'n', $birth = 'b', $death = 'd') {
		global $tblprefix;
		$config = Config::getInstance();
		$restrictdate = $config->restrictdate;
		
		$ret = $type." JOIN ".$tblprefix."names ".$name." ON ".$name.".person_id = ".$tbl.".person_id ";
		$ret .= "LEFT JOIN  ".$tblprefix."event ".$birth." ON ".$birth.".person_id = " .$tbl.".person_id AND ".$birth.".etype = ".BIRTH_EVENT;
		if ($_SESSION["id"] == 0) {
			$ret .= " AND ".$birth.".date1 < '".$restrictdate."'";
		}
		$ret .= " LEFT JOIN  ".$tblprefix."event ".$death." ON ".$death.".person_id = " .$tbl.".person_id AND ".$death.".etype = ".DEATH_EVENT." ";
		return ($ret);
	}
	
	function getDisplayName() {
		return ($this->name->getDisplayName());
	}

	function getDisplayGender() {
		$icona="";// MODIFICA 20120506
		if ($this->gender=="M"){ // MODIFICA 20120506
			$icona="<img border='0' src='images/male.gif' alt='M' height='20' /> ";  // MODIFICA 20120506
		}elseif ($this->gender=="F"){
			$icona="<img border='0' src='images/female.gif' alt='F' height='20' /> ";  // MODIFICA 20120506
		}
		return ($icona);
	}

	function getSelectName() {
		global $strUnknown, $strBornAbbrev;
		$year = $this->year_of_birth;
		if ($year == 0) {
			$year = $strUnknown;
		}
		return ($this->name->getReverseName()." (".$strBornAbbrev." ".$year.")");
	}

	function parseSelectName($str) {
		$names = $str;
		$pos = strrchr($str, "(");
		if ($pos) {
			$names = substr($str, 0, strlen($str) - strlen($pos));
			$date = $pos; //not used
		} 
		$this->name->parseReverseName($names);
	}
	
	function getURL() {
		$ret = "";
		if ($this->isViewable()) {
			$ret = "people.php?person=".$this->person_id;
		} 
		return ($ret);
	}
	
	function getLink($anchor = '') {
		global $strRestricted;
		$ret = "";
		if ($this->isViewable()) {
			$ret = "<a ".$anchor." href=\"".$this->getURL()."\">".$this->getDisplayName()."</a> ";
		} else {
			$ret = " (<font class=\"restrict\">".$strRestricted."</font>)";
		}
		return ($ret);
	}

	function getDates() {
		global $strBorn, $strDied, $strRestricted;
		$ret = "";
		if ($this->isViewable()) {
			if ($this->date_of_birth != "0000-00-00" && $this->date_of_death != "0000-00-00") {
				$ret = "(".$this->dob." - ".$this->dod.")";
			} elseif ($this->date_of_birth != "0000-00-00") {
				$ret = "(".$strBorn." ".$this->dob.")";
			} elseif ($this->date_of_death != "0000-00-00") {
				$ret = "(".$strDied." ".$this->dod.")";
			}
		} else {
			$ret = " (<font class=\"restrict\">".$strRestricted."</font>)";
		}
		return ($ret);
	}
	
	function getFullLink($anchor = '') {
		global $strRestricted;
		$ret = "";
		$ret = $this->getLink($anchor);
		if ($this->isViewable()) {
			$ret .= $this->getDates();
		}
		return ($ret);
	}
	
	function getBirthDetails() {
		$ret = "";
		
		if ($this->date_of_birth != "0000-00-00") {
			$ret = $this->dob;
		} 
		if (isset($this->birth_place)) {
			$ret .= $this->birth_place->getAtDisplayPlace();
		}
		return ($ret);
	}
	
	function getDeathDetails() {
		$ret = "";
		if ($this->date_of_death != "0000-00-00" && $this->death_reason != "")
			$ret = $this->dod." ".$strOf." ".$this->death_reason;
		elseif ($this->date_of_death != "0000-00-00")
			$ret = $this->dod;
		else
			$ret = $this->death_reason;
		return ($ret);

	}
}

?>