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
	include_once "modules/image/show.php";
	
	// fill out the headers
	do_headers($strGallery);
	
	$images = new Image();
	$dao = getImageDAO();
	$dao->getImages($images);

?>

<script language="JavaScript" type="text/javascript">
 <!--
 function confirm_delete(year, section, url) {
 	input_box = confirm(<?php echo $strConfirmDelete; ?>);
 	if (input_box == true) {
		window.location = url;
 	}
 }
 -->
</script>

<table class="header" width="100%">
	<tbody>
		<tr>
			<td align="center" width="65%"><h2><?php echo $strGallery; ?></h2></td>
			<td width="35%" valign="top" align="right"><?php user_opts(); ?></td>
    </tr>
  </tbody>
</table>

<?php
$lastperson = new PersonDetail();
$lastperson->person_id = 0;
for($i=0;$i<$images->numResults;$i++) {
	$img = $images->results[$i];
	if ($lastperson->person_id != $img->person->person_id) {
		if ($lastperson->person_id != 0) {
			$ip = new Image();
			$ip->results = $res;
			$ip->numResults = $cnt;
			show_gallery_images($ip, $img->person->isEditable(), "gallery");
		}
		$lastperson = $img->person;
		$res = array();
		$cnt = 0;
		echo "<hr />";
		echo "<h4>".$img->person->getFullLink()."</h4>";
	}
	$res[] = $img;
	$cnt++;
}

if ($lastperson->person_id != 0) {
	$ip = new Image();
	$ip->results = $res;
	$ip->numResults = $cnt;
	show_gallery_images($ip, $lastperson->isEditable(), "gallery");
}

include "inc/footer.inc.php";

	// eof
?>
