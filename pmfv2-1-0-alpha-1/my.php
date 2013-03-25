<?php
	//phpmyfamily - opensource genealogy webbuilder
	//Copyright (C) 2002 - 2005  Simon E Booth (simon.booth@giric.com)

	//This program is free software; you can redistribute it and/or
	//modify it under the terms of the GNU General Public License
	//as published by the Free Software Foundation; either version 2
	//of the License, or (at your option) any later version.

	//This program is distributed in the hope that it will be useful,
	//but WITHOUT ANY WARRANTY; without even the implied warranty of
	//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	//GNU General Public License for more details.

	//You should have received a copy of the GNU General Public License
	//along with this program; if not, write to the Free Software
	//Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

	// include the configuration parameters and functions
	include_once "modules/db/DAOFactory.php";
	include_once "inc/header.inc.php";
	include_once "modules/people/show.php";
	include_once "inc/functions.inc.php"; //for send_password and liststyles
	
	// wortk out if we have to do anything
	@$work = $_REQUEST["func"];
	$dao = getUserDAO();
	switch ($work) {
		case "style":
			$dao->updateStyle($_POST["pwdStyle"]);
			break;
		case "email":
			// update the users table
			$dao->updateEmail($_POST["pwdEmail"]);
			break;
	}

	$config = Config::getInstance();
	
	// do different things for those not logged in
	if ($_SESSION["id"] != 0) {
		do_headers_dojo($strMyLoggedIn);
		
?>
<body class="tundra">
<?php include_once("inc/analyticstracking.php"); ?>
<table width="100%" class="header">
	<tr>
		<td width="65%" align="center">
			<h1><?php echo $strPhpMyFamily; ?></h1>
			<h3><?php echo $config->desc; ?></h3>
		</td>
		<td width="35%" valign="top" align="right">
			<form method="get" action="people.php">
				<?php selectPeople("person"); ?>
			</form>
<?php user_opts(); ?>
		</td>
	</tr>
</table>
<hr />
<br /><br />
<?php
	if ($_SESSION["admin"] == 1) {
		echo $strAdminUser."<br>\n";
	}
?>
<table width="100%">
	<tr>
		<td width="50%" valign="top"><?php include "inc/passwdform.inc.php"; ?></td>
		<td width="50%" align="right" valign="top">
<?php
	$dao = getPeopleDAO();
	$tracked = $dao->getTrackedPeople();
?>		
			<table width="70%">
				<tr>
					<th colspan="2"><?php echo $strMonitoring; ?></th>
				</tr>
				<tr>
					<th><?php echo $strPerson; ?></th>
					<th><?php echo $strUpdated; ?></th>
				</tr>
<?php
		$i = 0;
		foreach ($tracked as $t) {
			if ($i == 0 || fmod($i, 2) == 0)
				$class = "tbl_odd";
			else
				$class = "tbl_even";
			echo "<tr><td class=\"".$class."\"><a href=\"people.php?person=".$t->person_id."\">".$t->getDisplayName()."</a></td><td class=\"".$class."\">".$t->dupdated."</td></tr>\n";
			$i++;
		}
?>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<form method="post" action="my.php?func=style">
			<table>
				<tr>
					<td><h4><?php echo $strChangeStyle; ?></h4></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $strStyle; ?></td>
					<td><?php liststyles("pwdStyle", $_SESSION["style"]); ?></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="submit2" value="<?php echo $strChange; ?>" /></td>
				</tr>
			</table>
			</form>
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			<form method="post" action="my.php?func=email">
			<table>
				<tr>
					<td><h4><?php echo $strChangeEmail; ?></h4></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $strEmail; ?></td>
					<td><input type="input" name="pwdEmail" value="<?php echo $_SESSION["email"]; ?>" size="40" maxlength="128" /></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="submit2" value="<?php echo $strChange; ?>" /></td>
				</tr>
			</table>
			</form>
		</td>
		<td></td>
	</tr>
</table>
<?php
	} else {
		do_headers_dojo($strLogin);

?>
<body class="tundra">
<?php include_once("inc/analyticstracking.php"); ?>
<table width="100%" class="header">
	<tr>
		<td width="65%" align="center">
			<h1><?php 
			echo $strPhpMyFamily; // MODIFICA 20120506 
			?></h1>			
			<h3><?php echo $config->desc; ?></h3>
		</td>
		<td width="35%" valign="top" align="right">
			<form method="get" action="people.php">
				<?php selectPeople("person"); ?>
			</form>
<?php user_opts(); ?>
		</td>
	</tr>
</table>
<hr />
<?php

		//find out the state
		@$state = $_REQUEST["state"];

		switch ($state) {
			case "lost":
				echo $strLost."<br>\n";
				include "inc/lostpasswdform.inc.php";
				break;
			case "sent":
				send_password($_REQUEST["pwdEmail"]);
				echo $strSent;
			default:
				include "inc/loginform.inc.php";
		}
	}

	include "inc/footer.inc.php";

	// eof
?>
