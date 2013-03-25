<?php
  /*
  ** Config 
  */
class Config {
  
	var $email;
	var $mailto;
	var $desc;
	var $styledir;
	var $imagedir;
	var $filedir;
	var $defaultstyle;
	var $lang;
	var $timing;
	var $gedcom;
	var $restricttype;
	var $restrictyears;
	var $restrictdate = '1900-01-01';
	var $tracking;
	var $trackemail;
	var $absurl;
	var $bbtracking;
	var $img_max;
	var $img_min;
	var $layout;
	var $gmapskey;
	var $gmapshost;
	var $dojo;
	var $smtp_host;
	var $smtp_user;
	var $smtp_password;
	var $recaptcha_public;
	var $recaptcha_private;
	var $version;
	var $analytics_key;

	function setupConfig() {
		date_default_timezone_set("Europe/London");
		$dao = getAdminDAO();
		$dao->getConfig($this);
		switch($this->restricttype) {
		case 1:
		$this->restrictdate = date("Y")-$this->restrictyears.date("-n-j");
		break;
		}
	}
	
	//Singleton pattern which should always be used to access
	//config variables
	static function getInstance() {
	   static $instance;
	   
	   if(!isset($instance)) {
		   $instance = new Config();
		   $instance->setupConfig();
	   }
	   return $instance;
	}

	function getActiveModules() {
	   $ret = array ("relations", "census", "note", "image", "transcript", "gedcom");
	   return ($ret);
	}
   
	function setFromPost() {
	   	$this->loadFields($_POST);
		$this->defaultstyle = $this->defaultstyle.".css.php";
		if (!isset($_POST["mailto"]) || $_POST["mailto"] != "on" ) {
			$this->mailto = false;
		} else {
			$this->mailto = true;
		}
		if (!isset($_POST["timing"]) || $_POST["timing"] != "on" ) {
			$this->timing = false;
		} else {
			$this->timing = true;
		}
		if (!isset($_POST["gedcom"]) || $_POST["gedcom"] != "on" ) {
			$this->gedcom = false;
		} else {
			$this->gedcom = true;
		}
		if (!isset($_POST["dynamicrestict"]) || $_POST["dynamicrestict"] != "on" ) {
			$this->dynamicrestict = false;
		} else {
			$this->dynamicrestict = true;
		}
		if (!isset($_POST["bbtracking"]) || $_POST["bbtracking"] != "on" ) {
			$this->bbtracking = false;
		} else {
			$this->bbtracking = true;
		}
		if (!isset($_POST["tracking"]) || $_POST["tracking"] != "on" ) {
			$this->tracking = false;
		} else {
			$this->tracking = true;
		}
		
	}
   
	function loadFields($row) {
	   	$this->email = $row["email"];
		if (isset($row["mailto"])) $this->mailto = $row["mailto"];
	   	$this->desc = $row["desc"];
		$this->styledir = $row["styledir"];
		$this->imagedir = $row["imagedir"];
		$this->filedir = $row["filedir"];
		$this->defaultstyle = $row["defaultstyle"];
		$this->lang = $row["lang"];
		if (isset($row["timing"])) $this->timing = $row["timing"];
		if (isset($row["gedcom"])) $this->gedcom = $row["gedcom"];
		if (isset($row["restricttype"])) $this->restricttype = $row["restricttype"];
		$this->restrictyears = $row["restrictyears"];
		$this->restrictdate = $row["restrictdate"];
		if (isset($row["tracking"])) $this->tracking = $row["tracking"];
		$this->trackemail = $row["trackemail"];
		$this->absurl = $row["absurl"];
		if (isset($row["bbtracking"])) $this->bbtracking = $row["bbtracking"];
		$this->img_max = $row["img_max"];
		$this->img_min = $row["img_min"];
		$this->layout = $row["layout"];
		if ($this->layout == 2 || $this->layout == 3) {
			$this->dojo = true;
		} else {
			$this->dojo = false;
		}
		$this->gmapskey = $row["gmapskey"];
		$this->gmapshost = $row["gmapshost"];
		$this->smtp_host = $row["smtp_host"];
		$this->smtp_user = $row["smtp_user"];
		$this->smtp_password = $row["smtp_password"];
		$this->recaptcha_public = $row["recaptcha_public"];
		$this->recaptcha_private = $row["recaptcha_private"];
		$this->version = $row["version"];
		$this->analytics_key = $row["analytics_key"];
	}
}

#
#error_reporting(E_ALL^E_STRICT);
error_reporting(E_ALL);
#Sends errors to the screen instead of the log file
#ini_set('display_errors', true);

include_once("inc/version.php");
include_once("classes/CurrentRequest.php");
//=====================================================================================================================
// Language routines
//=====================================================================================================================
// include the language file
$config = Config::getInstance();
$restrictdate = $config->restrictdate;
include_once("lang/en-uk.inc.php");
@include "lang/".$_SESSION["lang"].".inc.php";


?>
