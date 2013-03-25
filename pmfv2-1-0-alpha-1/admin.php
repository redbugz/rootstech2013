<?php
	//phpmyfamily - opensource genealogy webbuilder
	//Copyright (C) 2002 - 2005  Simon E Booth (simon.booth@giric.com)
	//Parts (C) 2004 Ken Joyce (ken@poweringon.com)

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
	include_once "inc/functions.inc.php"; //for liststyles
	// die if user not autorized
	if ($_SESSION["id"] == 0 || $_SESSION["admin"] == 0)
		die(include "inc/forbidden.inc.php");

	// get the request without generating error message
	@$func = $_REQUEST["func"];
	// error message to be passed
	$err = "";

	// we need a long execution time here
	if ($func == "ged")
		ini_set("max_execution_time", 360);

	// process the request
	switch ($func) {
		// add a new user
		case "add":
			// Get how the editable flag was passed
			@$pwdEdit = $_POST["pwdEdit"];
			if ($pwdEdit == "")
				$pwdEdit = "N";
			else
				$pwdEdit = "Y";
			// carry out some simple checks to see if user already exists and if passwords match
			if ($_POST["pwdPwd1"] == $_POST["pwdPwd2"]) {
				$dao = getUserDAO();
				$ret = $dao->addUser($_POST["pwdUser"],$_POST["pwdPwd1"], $_POST["pwdEmail"], $pwdEdit, $_POST["pwdStyle"]);
				if ($ret == 1) {
					$err = $err_user_exist;
				}
			} else {
				$err = $err_pwd_match;
			}
			break;
		// delete an existing user
		case "delete":
			$query = "DELETE FROM ".$tblprefix."users WHERE id = '".$_REQUEST["id"]."'";
			$result = mysql_query($query) or die($err_delete_user);
			break;
		// bail out if we don't know what else to do
		default:
			break;
	}

	// fill out the header
	do_headers("phpmyfamily Admin");

	if ($func <> "ged") {
?>
<table class="header" width="100%">
  <tbody>
    <tr>
      <td><h3><?php echo $strAdminFuncs; ?></h3>  </td>
<?php
	$fp = @fopen("http://www.phpmyfamily.net/pmf_version.php", "r");
	if ($fp) {
		$buffer = "";
		while (!feof($fp)) {
    		$buffer = fgets($fp, 1024);
		}
		fclose($fp);

		$current = explode(".", $version);
		$latest = explode(".", $buffer);

		if (count($current) > 1) {
		$str = "<td>A newer version of <em>phpmyfamily</em> is available.  Click <a href=\"http://sourceforge.net/project/showfiles.php?group_id=110402&package_id=119221&release_id=".$latest[3]."\">here</a> for information</td>\n";
		if ($latest[0] > $current[0]) {
			echo $str;
		} elseif ($latest[1] > $current[1] && $latest[0] == $current[0]) {
			echo $str;
		} elseif ($latest[2] > $current[2] && $latest[1] == $current[1] && $latest[0] == $current[0]) {
			echo $str;
		}
		}
	}
?>
    </tr>
  </tbody>
</table>

<hr />

	  	<table width="80%">
			<tr>
				<th><?php echo $strAction; ?></th>
				<th><?php echo $strUsername; ?></th>
				<th><?php echo $strEmail; ?></th>
				<th><?php echo ucwords($strAdmin); ?></th>
				<th><?php echo $strEdit; ?></th>
				<th><?php echo $strRestricted." ".$strDate; ?></th>
				<th><?php echo $strStyle; ?></th>
			</tr>
<?php
		$query = "SELECT * FROM ".$tblprefix."users WHERE id <> '".$_SESSION["id"]."' ORDER BY username";
		$result = mysql_query($query) or die($err_users);
		$i = 0;
		while ($row = mysql_fetch_array($result)) {
			if ($i == 0 || fmod($i, 2) == 0)
				$class = "tbl_odd";
			else
				$class = "tbl_even";
?>
			<tr>
				<td class="<?php echo $class; ?>"><a href="admin.php?func=delete&amp;id=<?php echo $row["id"]; ?>"><?php echo $strDelete; ?></a></td>
				<td class="<?php echo $class; ?>"><?php echo $row["username"]; ?></td>
				<td class="<?php echo $class; ?>"><?php echo $row["email"]; ?></td>
				<td class="<?php echo $class; ?>"><?php echo $row["admin"]; ?></td>
				<td class="<?php echo $class; ?>"><?php echo $row["edit"]; ?></td>
				<td class="<?php echo $class; ?>"><?php echo $row["restrictdate"]; ?></td>
				<td class="<?php echo $class; ?>"><?php echo $row["style"]; ?></td>
			</tr>
<?php
		$i++;
		}
?>
		</table>

      <?php $config = Config::getInstance();?>
			<table>
				<tr><h4><?php echo $strUserCreate; ?></h4></tr>
				<form method="POST" action="admin.php?func=add">
					<tr><td><?php echo $strUsername; ?></td><td><input type="text" name="pwdUser" size="30" maxlength="20" /></td></tr>
					<tr><td><?php echo $strEmail; ?></td><td><input type="text" name="pwdEmail" size="30" maxlength="128" /></td></tr>
					<tr><td><?php echo $strPassword; ?></td><td><input type="password" name="pwdPwd1" size="30" maxlength="30" /></td></tr>
					<tr><td><?php echo $strRePassword; ?></td><td><input type="password" name="pwdPwd2" size="30" maxlength="30" /></td></tr>
					<tr><td><?php echo ucwords($strEdit); ?></td><td><input type="checkbox" name="pwdEdit" checked="true" /></td></tr>
					<tr><td><?php echo $strRestricted." ".$strDate; ?></td><td><input type="text" name="pwdRestricted" size="30" maxlength="20" value="<?php echo $restrictdate; ?>" /></td></tr>
					<tr><td><?php echo $strStyle; ?></td><td><?php liststyles("pwdStyle", $config->defaultstyle); ?></td></tr>
					<tr><td></td><td><input type="submit" name="<?php echo $strCreate; ?>" /></td></tr>
					<tr><td><font color="red"><?php echo $err; ?></font></td></tr>
				</form>
			</table>

    <?php
    include_once "modules/admin/editForm.php";
  
    echo get_options_edit();
    ?>
  
	<!--Gedcom table-->

			<form action="admin.php?func=ged" method="POST" enctype="multipart/form-data" >
				<table>
					<tbody>
						<tr>
							<th colspan="2"> Upload Gedcom File</th>
						</tr>
						<tr>
							<td class="tbl_odd">File to upload  </td>
							<td class="tbl_even"><input type="file" name="gedfile" size="30" />  </td>
						</tr>
						<tr>
							<td class="tbl_even"><input type="submit" name="Submit1" value="<?php echo $strSubmit; ?>" /></td>
							<td>  </td>
						</tr>
						<tr>
							<td colspan="2" class="tbl_even">Warning - Highly experimental - Only tested on Version 5.5 - Use ANSI format</td>
						</tr>
					</tbody>
				</table>
			</form>
	

<hr />
<a href="index.php"><?php echo $strBack; ?></a> <?php echo $strToHome; ?>

<?php
	} else {
		include "inc/gedcom.inc.php";
	}
?>
</body>
</html>

<?php
	// eof
?>
