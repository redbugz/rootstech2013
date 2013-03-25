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

	$images = new Image();
	$images->setFromRequest();
	$dao = getImageDAO();
	$dao->getImages($images);
	$img = $images->results[0];
	
	// fill out the header
	do_headers($img->getTitle()." (".$img->person->getDisplayName().")");
?>

<table class="header" width="100%">
  <tbody>
    <tr>
      <td align="center"><h2><?php echo $img->getTitle(); ?></h2></td>
    </tr>
  </tbody>
</table>


<hr />

<a href="people.php?person=<?php echo $img->person->person_id; ?>">Return to <?php echo $img->person->getDisplayName(); ?></a>

<div align="center"><img src="<?php echo $img->getImageFile(); ?>" alt="<?php echo $img->getDescription(); ?>" /></div>

<div align="center">
	<?php if (!$img->person->isViewable())
		echo "<p>".$restrictmsg."</p>";
	else {
		echo "<p>".$img->getDescription()."</p>";
		echo "<p>".$img->event->getFullDisplay("event")."</p>";
		echo "<p>".$img->source->getFullDisplay("source")."</p>";

	}?>
</div>

<br /><br />
<?php

	include "inc/footer.inc.php";
	
	// eof
?>