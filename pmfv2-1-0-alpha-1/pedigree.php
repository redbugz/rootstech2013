<?php
	//phpmyfamily - opensource genealogy webbuilder
	//Copyright (C) 2002 - 2005  Simon E Booth

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
	include_once "modules/pedigree/show.php";

	// check to see if we have a person
	if (!isset($_GET["person"])) $person = 1;

	$peep = new PersonDetail();
	$peep->setFromRequest();
	$peep->queryType = Q_IND;
	$dao = getPeopleDAO();
	$dao->getPersonDetails($peep);
	if ($peep->numResults != 1) {
		die("error");
	}
	$per = $peep->results[0];

	do_headers_dojo($strPedigreeOf." ".$per->getDisplayName());
?>	
<!--titles-->
	<table width="100%" class="header">
		<tr>
			<td width="65%" align="center" valign="top">
				<h2><?php 
				echo $strPedigreeOf." ".$per->getDisplayName()." ".$per->getDisplayGender(); // MODIFICA 20120506  
				?></h2>
				<h3><?php echo $per->getDates(); ?></td>
			<td width="35%" valign="top" align="right">
				<form method="get" action="pedigree.php">
				<?php selectPeople("person", 0, "A", $per->person_id); ?>
				</form>
<?php user_opts(); if ($_SESSION["id"] != 0) echo " | "; echo "<a href=\"".$per->getURL()."\">".strtolower($strBack)." ".$strToDetails."</a>\n"; ?>
			</td>
		</tr>
	</table>

<hr />

<?php
	show_pedigree($per);	
	include "inc/footer.inc.php";

	// eof
?>