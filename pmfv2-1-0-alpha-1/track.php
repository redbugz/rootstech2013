<?php
	//phpmyfamily - opensource genealogy webbuilder
	//Copyright (C) 2002 - 2007  Simon E Booth (simon.booth@giric.com)

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
	include_once "inc/functions.inc.php";
	include_once "inc/header.inc.php";

	// pick up the passed variables
	@$email = $_REQUEST["email"];
	@$person = $_REQUEST["person"];
	@$action = $_REQUEST["action"];
	@$key = $_REQUEST["key"];

	$config = Config::getInstance();

	// bail out if we don't allow anonymous tracking
	if (!$config->tracking)
		die(include "inc/forbidden.inc.php");

	$dao = getTrackingDAO();

	// Fill out the headers
	do_headers($strTracking);

?>

<script language="JavaScript" type="text/javascript">
 <!--
 function check_email() {
 	if (document.trackform.email.value == '') {
		alert(<?php echo $strNoEmail; ?>);
		return false
 	}
 }
 -->
</script>

<table class="header" width="100%">
	<tbody>
		<tr>
			<td align="center" width="65%"><h2><?php echo $strTracking; ?></h2></td>
			<td width="35%" valign="top" align="right"><?php user_opts(); ?></td>
    </tr>
  </tbody>
</table>

<?php

	// if we have a person and no email
	// then show subscribe form
	if (isset($person) && !isset($email)) {

		$peep = new PersonDetail();
        	$peep->setFromRequest();
        	$peep->queryType = Q_IND;
        	$pdao = getPeopleDAO();
        	$pdao->getPersonDetails($peep);
        	if ($peep->numResults != 1) {
               	 die(include "inc/forbidden.inc.php");
                //die("error");
      		}
        	$per = $peep->results[0];

        // if trying to access a restriced person
        	if (!$per->isViewable()) {
               	 die(include "inc/forbidden.inc.php");
        	}

			echo "<hr />\n";
			echo "<h3>".$per->getDisplayName()."</h3>\n";
			echo $strTrackSpeel."<br /><br />\n";
?>
	<form action="track.php" method="post" name="trackform" onsubmit="return check_email();">
		<input type="hidden" name="person" value="<?php echo $person; ?>" />
		<input type="hidden" name="name" value="<?php echo $per->getDisplayName(); ?>" />
		<table>
			<tbody>
				<tr>
					<td class="tbl_odd"><?php echo $strEmail; ?>  </td>
					<td class="tbl_even"><input type="text" name="email" size="30" maxlength="128" />  </td>
				</tr>
				<tr>
					<td class="tbl_odd">  </td>
					<td class="tbl_even"><input type="radio" name="action" value="sub" checked="checked"  /><?php echo $strSubscribe; ?><input type="radio" name="action" value="unsub" /><?php echo $strUnSubscribe; ?></td>
				</tr>
				<tr>
					<td class="tbl_odd"><input type="submit" name="submit" value="<?php echo $strSubmit; ?>" />  </td>
					<td class="tbl_odd">  </td>
				</tr>
			</tbody>
		</table>
	</form>
<?php
	}

	// we have a key then process
	elseif (isset($key)) {
		// Housekeeping
		$dao->delete_expired();
		echo "<hr />\n";

		$ret = $dao->processTrackingAction($key, $action);

		if ($ret == -1) {
			echo $strMonError."\n";
		} elseif ($ret == 1) {
			// You are now monitoring this person
			echo $strMonAccept."\n";
		} elseif ($ret == 2) {
			// You are now not monitoring this person
			echo $strMonCease."\n";
		}
	}

	// we have a person & email & action so send subscribe message
	elseif (isset($person) && isset($email) && isset($action)) {
		// we want to subscribe
		$dao->delete_expired();
		echo "<hr />\n";
		echo "<h3>".htmlspecialchars($_REQUEST["name"])."</h3>\n";
		// produce a new key (md5 hash of email and person requested)
		$newkey = md5(str_rand(20));

		if ($action == "sub") {
			$ret = $dao->trackByUnregistered($person, $_REQUEST["name"], $newkey, $email);

			// if we get this error then already tracking
			if ($ret == 1) {
				echo $strAlreadyMon."\n";
			} else if ($ret == 0){
				echo $strMonRequest."\n";
			}
		}
		// we want to unsubscribe
		elseif ($action == "unsub") {
			$ret = $dao->untrackByUnregistered($person, $_REQUEST["name"], $newkey, $email);
			if ($ret == 0) {
				echo $strCeaseRequest."\n";
			} else {
				// cos if not, we are not subscribed
				echo $strNotMon."\n";
			}
		}
	}

	// Otherwise, I don't really know what to do
	else {
		echo $strDragons;
	}

	if(isset($person))
		$link = "people.php?person=".$person;
	else
		$link = "index.php";

	echo "<p><a href=\"".$link."\">".$strBack."</a> ".$strToHome."</p>\n";
	include "inc/footer.inc.php";

	// eof
?>
