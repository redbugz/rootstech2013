<?php
include_once ("modules/source/show.php");

function setup_edit() {
	$img = new Image();
	$img->image_id = -1;
	$img->setFromRequest();
	$dao = getImageDAO();
	$dao->getImages($img);
	if($img->numResults == 0) {
		if (isset($_REQUEST["event"])) {
			$dao = getEventDAO();
			$event = new Event();
			$event->setFromRequest();
			$dao->getEvents($event, Q_ALL);
			$img->event = $event->results[0];
			$img->person = $img->event->person;
		} else {
			$img->event = new Event();
		}
		if ($img->person->person_id > 0) {
			$img->person->queryType = Q_IND;
			$dao = getPeopleDAO();
			$dao->getPersonDetails($img->person);
			$img->person = $img->person->results[0];
		}
		$img->source = new Source();
		$img->source->setFromRequest();
		if ($img->source->source_id > 0) {
			$sdao = getSourceDAO();
			$sdao->getSources($img->source);
			if ($img->source->numResults > 0) {
				$img->source = $img->source->results[0];
			}
		}
		$ret = $img;

	} else {
		$ret = $img->results[0];
	}
	return($ret);
}

function get_edit_title($img) {
	global $strNewImage;
	return ucwords($strNewImage).": ".$img->person->getDisplayName();
}
function get_edit_header($img) {
	return (get_edit_title($img));
}

function get_edit_form($img) {
	global $strIUpload, $strITitle, $strISize, $strSubmit,  $strEdit, $strDesc, $strSource;
?>
<!--Fill out the form-->
<form enctype="multipart/form-data" method="post" action="passthru.php?func=insert&amp;area=image">
<input type="hidden" name="person" value="<?php echo $img->person->person_id;?>" />
<?php if (isset($img->image_id) && $img->image_id > 0) { 
	$existing = true;
} else {
	$existing = false;
}
if ($existing) {?>
<input type="hidden" name="image_id" value="<?php echo $img->image_id;?>" />
<input type="hidden" name="event_id" value="<?php echo $img->event->event_id;?>" />
<?php } ?>
<input type="hidden" name="MAX_FILE_SIZE" value="1048576">
	<table>
	<?php if (!$existing) {
		?>
		<tr>
			<td class="tbl_odd"><?php echo $strIUpload; ?></td>
			<td class="tbl_even"><input type="file" name="userfile" /></td>
			<td><?php echo $strISize; ?></td>
		</tr>
	<?php }?>
		<tr>
			<td class="tbl_odd"><?php echo $strSource; ?></td>
			<td class="tbl_even"><?php selectSource("", $img->source,$img->event);?></td>
		</tr>
		<tr>
			<td class="tbl_odd"><?php echo $strITitle; ?></td>
			<td class="tbl_even"><input type="text" name="frmTitle" size="30" maxlength="30" value="<?php echo $img->title;?>" /></td>
		</tr>
		<tr>
			<td class="tbl_even"><input type="submit" name="Submit1" value="<?php echo $strSubmit; ?>" /></td>
			<td class="tbl_even"></td>
		<tr>
	</table>
</form>
<?php
	if ($existing) {
		echo '<div id="image"><a href="edit.php?func=edit&amp;area=event&amp;event='.$img->event->event_id.'">'.$strEdit.' '.$strDesc.'</a></div>';
	}
}
?>