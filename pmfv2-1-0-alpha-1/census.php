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

	// include the configuration parameters and function
	include "modules/db/DAOFactory.php";
	include "modules/census/show.php";
	include "inc/header.inc.php";
	
	
	$search = new CensusDetail();
	$search->event->setFromRequest();
	$search->queryType = Q_FAMILY;
	
	$dao = getCensusDAO();
	$dao->getCensusDetails($search);
	
	$cnt = $search->numResults;
	
	// Fill out the headers
	do_headers($strCensusDetails.": ".$search->schedule);

	if(isset($_SERVER["HTTP_REFERER"]))
		$referer = $_SERVER["HTTP_REFERER"];
	else
		$referer = "index.php";

	$caption = "";
	if ($cnt > 0) {
		$cap = $search->results[0]; 
	} else {
		$dao->getCensusName($search);
		$cap = $search;
	}
	
	$caption = $cap->country." (".$cap->year.")";
?>

<table class="header" width="100%">
	<tbody>
		<tr>
			<td align="center" width="65%"><h2><?php echo $strCensusDetails.": ".$search->schedule; ?></h2></td>
			<td width="35%" valign="top" align="right"><?php user_opts(); ?></td>
    </tr>
  </tbody>
</table>

<hr />

<table width="100%">
	<tbody>
		<tr>
			<th colspan="7"><?php echo $caption; ?></th>
		</tr>
		<tr>
			<?php printCensusHeader(SHOW_CENSUS, false);?>
		</tr>

<?php
	$cnt = count($cap->event->attendees);
	
	for($i=0; $i < $cnt; $i++) {
		if ($i == 0 || fmod($i, 2) == 0) {
			$class = "tbl_odd";
		} else {
			$class = "tbl_even";
		}
?>
		<tr>
<?php
		printCensusRow($cap, $cap->event->attendees[$i], SHOW_CENSUS, null, $class);
?>
		</tr>
<?php
	}
?>

	</tbody>
</table>

<?php

	echo "<p><a href=\"".$referer."\">".$strBack."</a> ".$strToHome."</p>\n";
 
	include "inc/footer.inc.php";

	// eof
?>