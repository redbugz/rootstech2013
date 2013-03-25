<?php

class Source extends Base {
	var $source_id;
	var $title;
	var $reference;
	var $url;
	var $ref_date;
	var $certainty;
	var $notes;
	
	function Source() {
	}
	
	function setFromRequest() {
		@$this->source_id = $_REQUEST["source"];
	}
	
	static function getFields($prefix) {
		global $currentRequest;
		
		$fields = array("title", "reference", "url", "ref_date", "notes", "certainty");
			
		$ret = Base::addFields($prefix, $fields);

		return ($ret);
	}
	
	function setPermissions() {
		$config = Config::getInstance();
		if($_SESSION["editable"] == "Y") {
			$this->editable = true;
			$this->creatable = true;
			$this->deletable = true;
			$this->exportable = true;
			$this->viewable = true;
		}
	}
	
	function setFromPost($prefix = '') {
		$this->loadFields($_POST, $prefix);
		$this->title = htmlspecialchars($this->title, ENT_QUOTES);
		$this->url = htmlspecialchars($this->url, ENT_QUOTES);
		$this->reference = htmlspecialchars($this->reference, ENT_QUOTES);
		$this->notes = htmlspecialchars($this->notes, ENT_QUOTES);
		$this->ref_date = htmlspecialchars($this->ref_date, ENT_QUOTES);
		
	}
	function loadFields($row, $prefix) {
		@$this->source_id = $row[$prefix."source_id"];
		@$this->title = $row[$prefix."title"];
		@$this->reference = $row[$prefix."reference"];
		@$this->url = $row[$prefix."url"];		
		@$this->ref_date =  $row[$prefix."ref_date"];		
		@$this->certainty = $row[$prefix."certainty"];
		@$this->notes = $row[$prefix."notes"];
		$this->setPermissions();
	}
	
	function hasData() {
		if ((isset($this->source_id) && $this->source_id > 0)) {
			return (true);
		}
		if ($this->title == '' && $this->ref_date == '0000-00-00' && $this->notes == '' &&
			$this->url == '' && $this->reference == '') {
			return (false);
		}
		return (true);
	}
	
	function getDisplaySource() {
		return ($this->title);
	}
	
	function getFullDisplay($class = '') {
		global $strEventVerb, $strDateDescr, $strCertified, $strSource, $strReference, $strNotes, $strOn;

		$ret = '<div class="'.$class.'">';
		if ($this->url != "") { $ret .= '<a href="'.$this->url.'">'; }
		if ( $this->title != "") { $ret .= '<div id="source"><div class="label">'.$strSource.":</div> ".$this->title."</div>"; }
		if ( $this->reference != "") { $ret .= '<div id="ref"><div class="label">'.$strReference.":</div> ".$this->reference."</div>"; }
		if ( $this->notes != "") { $ret .= '<div id="notes"><div class="label">'.$strNotes.":</div> ".$this->notes."</div>"; }
		if ($this->certainty > 0) { $ret .= '('.$strCertified.')'; }
		if ($this->url != "") { $ret .= '</a>'; }
		$ret .= "</div>";
		
		return ($ret);
	}
}
?>