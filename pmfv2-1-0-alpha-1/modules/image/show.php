<?php

function show_image($per) {
	return(show_gallery($per->isEditable()));
}

function show_gallery($editable, $dest = "people", $eid = -1, $sid = -1) {
	$img = new Image();
	$img->setFromRequest();
	$dao = getImageDAO();
	$dao->getImages($img, $eid, $sid);
	return(show_gallery_images($img, $editable, $dest));
}

function get_image_create_string($per, $eid = -1, $sid = -1) {
	global $strUpload, $strNewImage;
	$ret = "";

	if ($per->isEditable()) {
		$ret = "<a href=\"edit.php?func=add&amp;area=image&amp;person=".$per->person_id;
		if ($eid > 0) {
			$ret .= "&amp;event=".$eid;
		}
		if ($sid > 0) {
			$ret .= "&amp;source=".$sid;
		}
		$ret .= "\">".$strUpload."</a> ".$strNewImage;
	}
	return ($ret);
}

function get_image_title() {
	global $strGallery;
	return $strGallery;
}

function show_image_title($per) {
	?>
<table width="100%">
		<tr>
			<td width="80%"><h4><?php echo get_image_title(); ?></h4></td>
			<td align="right"><?php
			echo get_image_create_string($per);
?></td>
		</tr>
	</table>
<?php
}

// function: show_gallery
// show the image gallery for a person
function show_gallery_images($images, $editable = false, $dest = "people") {
	global $tblprefix;
	global $strEdit, $strDelete;
	global $strImage;
	global $strNoImages;

	if ($images->numResults == 0) {
		echo "\t".$strNoImages;
	} else {
?>
	<table>
<?php
		$rows = ceil($images->numResults / 5);
		$current = 0;
		$currentrow = 1;
		for ($current = 0; $current < $images->numResults; $current++) {
			$img = $images->results[$current];
			// start a new row every 5 images
			if ($current == 0 || fmod($current, 5) == 0) {
?>
		<tr>
<?php
			}
						// alternate background colours
			if ($current == 0 || fmod($current, 2) == 0)
				$class = "tbl_odd";
			else
			$class = "tbl_even";
			// display image thumbnail
?>
			<td width="20%" class="<?php echo $class; ?>" align="center" valign="top"><?php echo $img->getLink();?><br />
			<?php echo $img->getTitleLink(); 
			if($img->person->isEditable()) { 
				echo "<br />\n".
				"<a href=\"edit.php?func=add&amp;area=image&amp;person=".$img->person->person_id."&amp;image=".$img->image_id."\">".
			$strEdit."</a> :: <a href=\"JavaScript:confirm_delete('".$img->getTitle()."', '".
			strtolower($strImage)."', 'passthru.php?func=delete&amp;area=image&amp;person=".$img->person->person_id.
			"&amp;image=".$img->image_id."&amp;dest=".$dest."')\" class=\"delete\">".$strDelete."</a>";
			} ?>
			</td>
<?php
			// close each row every 5 images
			if ($current <> 0 && fmod($current + 1, 5) == 0) {
				$currentrow++;
?>
		</tr>
<?php
			}
		}
				
		// make sure that rows and tables are padded and closed properly
		while ($currentrow <= $rows) {
?>
			<td width="20%"></td>
<?php
			if ($current <> 0 && fmod($current + 1, 5) == 0) {
				$currentrow++;
?>
		</tr>
<?php
			}
			$current++;
		}
?>
	</table>
<?php
	}

	return ($images->numResults);
}	// end of show_gallery()
?>