<?php

class AdminDAO extends MyFamilyDAO {
	function getConfig(&$c) {
		global $tblprefix, $version,$pdo;
		$query = "SELECT version FROM ".$tblprefix."config";
		$result = $pdo->query($query);
		if ($result === FALSE) {
			//2.0 -> 2.1.0 upgrade
			$pdo->exec("ALTER TABLE `".$tblprefix."config` ADD COLUMN `version` VARCHAR(15), ADD COLUMN `analytics_key` VARCHAR(45) NULL;");
			$pdo->exec("UPDATE `".$tblprefix."config` SET version='$version'");
		} else {
			$row = $result->fetch();
			if ($row["version"] != $version) {
			$pdo->exec("UPDATE `".$tblprefix."config` SET version='$version'");
			}
		}
		$query = "SELECT ";
		$query .= "email,mailto,`desc`,styledir,imagedir,filedir,defaultstyle,lang,timing,gedcom,restricttype,".
			"restrictyears,restrictdate,tracking,trackemail,absurl,bbtracking,".
			"layout, gmapskey, gmapshost, img_max,img_min,".
			"smtp_user,smtp_password,smtp_host,recaptcha_private,recaptcha_public, version, analytics_key";
		$query .= " FROM ".$tblprefix."config ";
		//TODO - add a proper error message
		$result = $this->runQuery($query, "Error retrieving config");
		
		while($row = $this->getNextRow($result)) {
			$c->loadFields($row);
		}
	}
	
	function updateConfig($c) {
		global $tblprefix;
		
		$q = "UPDATE ".$tblprefix."config SET `email` = ".quote_smart($c->email).",".
		"`mailto` = ".($c->mailto?1:0).",".
			"`desc` = ".quote_smart($c->desc).",".
			"`styledir` = ".quote_smart($c->styledir).",".
			"`imagedir` = ".quote_smart($c->imagedir).",".
			"`filedir` = ".quote_smart($c->filedir).",".
			"`defaultstyle` = ".quote_smart($c->defaultstyle).",".
			"`lang` = ".quote_smart($c->lang).",".
			"`timing` = ".($c->timing?1:0).",".
			"`gedcom` = ".($c->gedcom?1:0).",".
			"`restricttype` = ".$c->restricttype.",".
			"`restrictyears` = ".$c->restrictyears.",".
			"`restrictdate` = ".quote_smart($c->restrictdate).",".
			"`tracking` = ".($c->tracking?1:0).",".
			"`trackemail` = ".quote_smart($c->trackemail).",".
			"`absurl` = ".quote_smart($c->absurl).",".
			"`bbtracking` = ".($c->bbtracking?1:0).",".
			"`img_max` = ".$c->img_max.",".
			"`img_min` = ".$c->img_min.",".
			"`layout` = ".$c->layout.",".
			"`gmapshost` = ".quote_smart($c->gmapshost).",".
			"`gmapskey` = ".quote_smart($c->gmapskey).",".
			"`smtp_host` = ".quote_smart($c->smtp_host).",".
			"`smtp_user` = ".quote_smart($c->smtp_user).",".
			"`smtp_password` = ".quote_smart($c->smtp_password).",".
			"`recaptcha_public` = ".quote_smart($c->recaptcha_public).",".
			"`recaptcha_private` = ".quote_smart($c->recaptcha_private).",".
			"`analytics_key` = ".quote_smart($c->analytics_key);
			//TODO - add a proper error message
		$ret = $this->runQuery($q, "Error updating config");
		
		return ($ret);
	}
}
?>
