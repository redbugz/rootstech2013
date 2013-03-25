<?php

define('CR_NAME', "cr_name");

class CurrentRequest {
	
	var $starttime;
	var $datefmt;
	var $nulldate;
	var $dispdate;
	
	var $id;
	var $name;
	var $admin;
	var $editable;
	var $style;
	var $email;
	var $lang;
	
	
//=====================================================================================================================
// Session routines
//====================================================================================================================

	function init() {
		// call to start a new session or resume if exists
		if (!session_id()) { 
		//	ini_set("session.use_trans_sid", false);	// be nice to search engines
		//	ini_set("arg_separator.output", "&amp;");	// keep w3c compiance
			session_start(); 
		}
		//=====================================================================================================================
		// Get the current time for tracking execution
		//=====================================================================================================================

		$this->starttime = array_sum(explode(' ',microtime()));

		$config = Config::getInstance();
		// set default variables
		if (!isset($_SESSION["id"])) $_SESSION["id"] = 0;			// non zero if logged in
		if ($_SESSION["id"] == 0)
			$this->check_cookies();
		
		$this->id = $_SESSION["id"];
		if (!isset($_SESSION[CR_NAME])) $_SESSION[CR_NAME] = "nobody";		// actual login name
		$this->name = $_SESSION[CR_NAME];
		if (!isset($_SESSION["admin"])) $_SESSION["admin"] = 0;			// admin flag
		$this->admin = $_SESSION["admin"];
		if (!isset($_SESSION["lang"])) {
			$_SESSION["lang"] = $config->lang;				// default language file
		}
		$this->lang = $_SESSION["lang"];
		if (!isset($_SESSION["editable"])) $_SESSION["editable"] = "N";		// Edit permission flag
		$this->editable = $_SESSION["editable"];
		if (!isset($_SESSION["style"])) {	
			$_SESSION["style"] = $config->defaultstyle;			// set the default style sheet
		}
		$this->style = $_SESSION["style"];
		if (!isset($_SESSION["email"])) $_SESSION["email"] = "";		// set default email for user
		$this->email = $_SESSION["email"];
	}	

	function login($username, $password) {
		global $tblprefix, $pdo;
		
		$sth = $pdo->prepare('SELECT id, username, admin, edit, style, email, restrictdate FROM '.$tblprefix.'users WHERE username = ? and password = ?');
		$sth->bindParam(1, $username, PDO::PARAM_STR, 10);
		$sth->bindParam(2, $password, PDO::PARAM_STR, 32);
		$sth->execute();
		$result = $sth->fetchAll();
		if (count($result) != 1) {
			return (false);
		}
		$row = $result[0];
		// if we're in here then the user/passwd in good
		$_SESSION["id"] = $row["id"];
		$_SESSION[CR_NAME] = $row["username"];
		if ($row["admin"] == "Y")
			$_SESSION["admin"] = 1;
		else
			$_SESSION["admin"] = 0;
		$_SESSION["editable"] = $row["edit"];
		$_SESSION["style"] = $row["style"];
		$_SESSION["email"] = $row["email"];
		$ret = true;
				
		$sth->closeCursor();
		return ($ret);
	}
	
	function logout() {
		$config = Config::getInstance();
		$_SESSION["id"] = 0;
		$_SESSION[CR_NAME] = "nobody";
		$_SESSION["admin"] = 0;
		$_SESSION["editable"] = "N";
		$_SESSION["style"] = $config->defaultstyle;
		$_SESSION["email"] = "";
		setcookie("fam_name", "", time() - 36000);
		setcookie("fam_passwd", "", time() - 36000);
	}
	
	// function: check_cookies
	// see if we have a valid cookie
	function check_cookies() {

		if (isset($_COOKIE["fam_name"]) && isset($_COOKIE["fam_passwd"])) {
			$ret = $this->login($_COOKIE["fam_name"], $_COOKIE["fam_passwd"]);
			if ($ret) {
				setcookie("fam_name", $_COOKIE["fam_name"], time() + 2592000);
				setcookie("fam_passwd", $_COOKIE["fam_passwd"], time() + 2592000);
			} else {
				setcookie("fam_name", "", time() - 3600);
				setcookie("fam_passwd", "", time() - 3600);
			}
		}
	}	// end of check_cookies()
	
	function setDateFormat($df) {
		$config = Config::getInstance();
		$this->datefmt = $df;
		$dquery = "SELECT DATE_FORMAT('0000-00-00', ".$df." ) , DATE_FORMAT( '".$config->restrictdate."', ".$df." )";
		$dresult = mysql_query($dquery) or die("OOOOOppppps");
		while ($row = mysql_fetch_array($dresult)) {
			$this->nulldate = $row[0];
			$this->dispdate = $row[1];
		}
		mysql_free_result($dresult);
	}
}

$currentRequest = new CurrentRequest();
$currentRequest->init();

?>
