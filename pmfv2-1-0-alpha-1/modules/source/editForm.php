<?php
include_once("modules/source/show.php");
include_once("modules/image/show.php");
include_once("modules/transcript/show.php");

function setup_edit() {
	$l = new Source();
	$l->setFromRequest();
	$ret = $l;
	if ($l->source_id != '' && $l->source_id > 0) {
		$dao = getSourceDAO();
		$dao->getSources($l);
		if ($l->numResults > 0) {
			$ret = $l->results[0];
		}
	} 
	return ($ret);
}

function get_edit_title($l) {
	global $strEditing;
	if ($l->source_id > 0) {
		return($strEditing.": ".$l->title);
	} else {
		return ("");
	}
}

function get_edit_header($l) {
	return (get_edit_title($l));
}

function get_edit_form($s) {
	global $strNotes, $strTitle, $strReference, $strURL, $strCertified, $strDate, $strSubmit, $strReset;
	
	$config = Config::getInstance();
	if ($config->dojo) {
	?><script  type="text/javascript">
	dojo.addOnLoad(function() {
                        var widget = dijit.byId('notes');
                        widget.name = 'notes';
                        dojo.connect(widget, 'onChange', function(){
                        widget.endEditing();
                        var desc = widget.getValue();
                        var stext = dojo.byId('notes');
                        stext.value = desc;
                        });
                });
                
	</script><?php
	}	
?>
<!--Fill out form -->
<form method="post" action="passthru.php?area=source">
<input type="hidden" name="source_id" value="<?php echo $s->source_id; ?>" />

	<table>
		<tr>
		<td><?php echo $strTitle;?></td>
		<td><input type="text" name="title" value="<?php echo $s->title; ?>" size="30" maxlength="255" /></td>
		<td></td>
		</tr>
		<tr>
		<td><?php echo $strReference ;?></td>
		<td><input type="text" name="reference" value="<?php echo $s->reference; ?>" size="30" maxlength="255" /></td>
		<td></td>
		</tr>
		<tr>
		<td><?php echo $strURL ;?></td>
		<td><input type="text" name="url" value="<?php echo $s->url; ?>" size="30" maxlength="255" /></td>
		<td></td>
		</tr>
		<tr>
		<td><?php echo $strReference." ".$strDate;?></td>
		<td><input type="text" name="ref_date" value="<?php echo $s->ref_date; ?>" size="30" maxlength="10" /></td>
		<td></td>
		</tr>
		<tr>
		<td><?php echo $strCertified;?></td>
		<td><?php certaintySelect("certainty",$s->certainty); ?></td>
		<td></td>
		</tr>
		<tr>
		<td><?php echo $strNotes;?></td>
		<td><?php if ($config->dojo) { ?>
			<input type="hidden" name="notes" id="notes"/>
			<div id="notes" dojoType="dijit.Editor" minHeight="5em" 
			plugins="['undo', 'redo', 'cut', 'copy', 'paste', '|', 'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', '|', 'removeFormat', 'indent', 'outdent', 'justifyCenter', 'justifyFull', 'justifyLeft', 'justifyRight', 'delete', 'insertOrderedList', 'insertUnorderedList', 'createLink', 'foreColor','hiliteColor']">
			<?php echo $s->notes; ?></div>
			<?php } else {?>
			<textarea name="notes" id="notes" rows="10" cols="80"><?php echo $s->notes; ?></textarea>
			<?php }?></td>
		<td></td>
		</tr>
		<tr>
			<td class="tbl_even"><input type="submit" name="Submit1" value="<?php echo $strSubmit; ?>" /></td>
			<td colspan="2" class="tbl_even"><input type="reset" name="Reset1" value="<?php echo $strReset; ?>" /></td>
		</tr>
	</table>
	<?php
	if ($s->source_id > 0) {
		$src = new Source();
		$src->source_id = $s->source_id;
		$sdao = getSourceDAO();
		$sdao->getSourceEvents($src);
		if ($src->numResults > 0) {
			foreach ($src->results as $event) {
				echo $event->person->getLink();
				echo $event->getFullDisplay("");
			}
		}
	}
	?>
</form>

<?php
	if ($s->source_id > 0) {
		$per = new PersonDetail();
		$per->editable = $s->isEditable();
		$per->person_id = -1;
		echo "<div id=\"images\">";
		echo get_image_create_string($per, -1, $s->source_id);
		echo "<br/>";
		show_gallery($per, $dest = "people", -1, $s->source_id);
		echo "</div><div id=\"transcripts\">";
		echo get_transcript_create_string($per, -1, $s->source_id);
		echo "<br/>";
		show_transcript($per, -1, $s->source_id);
		echo "</div>";
	}
	
}
?>