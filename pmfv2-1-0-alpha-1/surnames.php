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

	// fill out the headers
	do_headers($strSurnameIndex);

?>

<table class="header" width="100%">
	<tbody>
		<tr>
			<td align="center" width="65%"><h2><?php echo $strSurnameIndex; ?></h2></td>
			<td width="35%" valign="top" align="right">
<?php user_opts(); ?>
			</td>
    </tr>
  </tbody>
</table>

<?php
	
	$search = new PersonDetail();
	$search->person_id = 0;
	$search->queryType = Q_TYPE;
	
	$dao = getPeopleDAO();
	
	$surnames = $dao->getSurnames(0);
	echo "<hr />\n<h4 align=\"center\">";
	foreach($surnames AS $per) {
		echo "<a href=\"surnames.php#".$per->name->surname."\">".$per->name->surname." (".$per->count.")</a> ";
	}
	echo "</h4>\n";
	
	$dao->getPersonDetails($search, 'printName');
	
	function printName($search, $per) {
		static $surname;
		
		if ($surname != $per->name->surname) {
			$surname = $per->name->surname;
			$familyname = " name=\"".$surname."\"";
		} else {
			$familyname = "";
		}
		echo $per->getFullLink($familyname);
		echo "<br/>\n";
	}
	
	include "inc/footer.inc.php";

	// eof
?>