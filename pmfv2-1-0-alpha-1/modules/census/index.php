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

	// include the configuration parameters and function

?>

<table width="100%">
		<tr>
			<td width="80%"><h4><?php echo $strCensusDetails; ?></h4></td>
			<td width="20%" valign="top" align="right"><?php
				if ($_SESSION["editable"] == "Y")
					echo "<a href=\"edit.php?func=add&amp;area=census&amp;person=".$_REQUEST["person"]."\">".$strInsert."</a> ".$strNewCensus; ?></td>
		</tr>
	</table>

<?php
		if ($restricted)
			echo $restrictmsg."\n";
		else {
			$cquery = "SELECT * FROM ".$tblprefix."census, ".$tblprefix."census_years WHERE person_id = ".quote_smart($_REQUEST["person"])." AND census = census_id ORDER BY year";
			$cresult = mysql_query($cquery) or die($err_census_ret);
			if (mysql_num_rows($cresult) == 0)
				echo $strNoInfo."\n";
			else {
?>
	<table width="100%">
		<tr>
			<td></td>
			<th><?php echo $strYear; ?></th>
			<th><?php echo $strSchedule; ?></th>
			<th><?php echo $strAddress; ?></th>
			<th><?php echo $strCondition; ?></th>
			<th><?php echo $strAge; ?></th>
			<th><?php echo $strProfession; ?></th>
			<th><?php echo $strBirthPlace; ?></th>
			<th><?php echo $strDetails; ?></th>
		</tr>
<?php
		$i = 0;
		while ($crow = mysql_fetch_array($cresult)) {
			if ($i == 0 || fmod($i, 2) == 0)
				$class = "tbl_odd";
			else
				$class = "tbl_even";
?>
		<tr>
			<td class="<?php echo $class; ?>"><?php
							if ($_SESSION["editable"] == "Y")
								echo "<a href=\"edit.php?func=edit&amp;area=census&amp;person=".$_REQUEST["person"]."&amp;census=".$crow["census_id"]."\">".$strEdit."</a>::<a href=\"JavaScript:confirm_delete('".$crow["year"]." (".$crow["country"].")', '".strtolower($strCensus)."', 'passthru.php?func=delete&amp;area=census&amp;person=".$_REQUEST["person"]."&amp;census=".$crow["census"]."')\" class=\"delete\">".$strDelete."</a>";
?></td>
			<td class="<?php echo $class; ?>"><?php echo $crow["year"]; ?> (<?php echo $crow["country"]; ?>)</td>
			<td class="<?php echo $class; ?>"><a href="census.php?census=<?php echo $crow["census_id"]; ?>&amp;ref=<?php echo $crow["schedule"]; ?>"><?php echo $crow["schedule"]; ?></a></td>
			<td class="<?php echo $class; ?>"><?php echo $crow["address"]; ?></td>
			<td class="<?php echo $class; ?>"><?php echo $crow["condition"]; ?></td>
			<td class="<?php echo $class; ?>"><?php echo $crow["age"]; ?></td>
			<td class="<?php echo $class; ?>"><?php echo $crow["profession"]; ?></td>
			<td class="<?php echo $class; ?>"><?php echo $crow["where_born"]; ?></td>
			<td class="<?php echo $class; ?>"><?php echo $crow["other_details"]; ?></td>
		</tr>
<?php
			$i++;
		}
		mysql_free_result($cresult);
?>
	</table>
<?php
			}
		}

		//EOF
?>
