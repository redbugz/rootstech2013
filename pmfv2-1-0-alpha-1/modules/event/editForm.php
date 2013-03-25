<?php
include_once("modules/event/show.php");
include_once("modules/location/show.php");
include_once("modules/source/show.php");
include_once("modules/image/show.php");

function setup_edit() {
	$dao = getEventDAO();
	$e = new Event();
	$e->setFromRequest();
	$dao->getEvents($e, Q_ALL, true);
	
	if ($e->numResults > 0) {
		$per = $e->results[0]->person;
	} else {
		$per = new PersonDetail();
		$per->setFromRequest();
		$e->results = array (new Event());
		$e->results[0]->type = -1;
	}
	
	$per->queryType = Q_IND;
	$dao = getPeopleDAO();
	$dao->getPersonDetails($per);
	if ($per->numResults > 0) {
		$ret = $per->results[0];
	} else {
		$ret = $per;
	}
		
	$ret->events = $e->results;
	return ($ret);
}

function get_edit_title($per) {
	global $strEditing, $strCreateFamily;
	if ($per->person_id) {
		return($strEditing.": ".$per->getDisplayName());
	} else {
		return ($strCreateFamily);
	}
}

function get_edit_header($per) {
	global $strEditing, $strCreatePerson;
	
	if ($per->person_id) {
		return($strEditing.": ".$per->getDisplayName());
	} else {
		return ($strCreatePerson);
	}
}

function get_edit_form($per) {
	global $strEvent, $strSubmit, $strReset,  $strDate,$strPlace,$strSource,$strReference,$strNotes, $strDateFmt;
	$config = Config::getInstance();
	$prefix = '';
	if ($config->dojo) {
	?><script  type="text/javascript">
	dojo.addOnLoad(function() {
                        var widget = dijit.byId('notes');
                        widget.name = '<?php echo $prefix;?>notes';
                        dojo.connect(widget, 'onChange', function(){
                        widget.endEditing();
                        var desc = widget.getValue();
                        var stext = dojo.byId('<?php echo $prefix;?>notes');
                        stext.value = desc;
                        });
                });
	</script><?php	
	}
	$event = $per->events[0];
?>
<form method="post" action="passthru.php?area=event&func=edit">
	<input type="hidden" name="<?php echo $prefix;?>event_id" value="<?php echo $event->event_id; ?>" />
	<input type="hidden" name="<?php echo $prefix;?>person" value="<?php echo $per->person_id; ?>" />
	<input type="hidden" name="<?php echo $prefix;?>etype" value="<?php if ($event->type < 0) echo OTHER_EVENT; else echo $event->type; ?>" />
	<table>
	<tr><td colspan="2">
		<table>
		
		<tr><td class="tbl_even"></td><td class="tbl_even">
		<?php
			echo $strEvent[$event->type];
		?></td><td class="tbl_even"><input type="text" name="<?php echo $prefix;?>descrip" value="<?php echo $event->descrip; ?>" size="45" maxlength="45"/></td></tr>
		<tr><td class="tbl_odd"><?php echo $strDate; ?></td><td style="white-space:nowrap;" class="tbl_odd">
		<?php dateModifierSelect($prefix.'d1type',$event->date1_modifier);$bDate = '0000-00-00';
			if (isset($event->date1)) {
				$bDate = $event->date1;
			}
			?></td><td class="tbl_odd">
		<input type="text" name="<?php echo $prefix;?>date1" value="<?php echo $bDate; ?>" size="10" /><br/>
			<?php echo $strDateFmt; ?></td>
		
		<tr><td class="tbl_even"><?php echo $strPlace; ?></td><td colspan="2"><?php selectPlace($prefix,$event->location);?></td></tr>
		
		<tr><td class="tbl_even"><?php echo $strSource; ?></td><td colspan="2"><?php
		$dao = getSourceDAO();
		$dao->getEventSources($event);
		$sp = "a";

		if ($event->numResults > 0) {
			foreach ($event->results as $source) {
				selectSource($sp."_".$prefix,$source);
				$sp++;
				echo "<br/>";
			}
		}
		
		$source = new Source();
		selectSource($sp."_".$prefix, $source, $event);
		?></td></tr>
		
		<tr><td class="tbl_even"><?php echo $strNotes; ?></td><td class="tbl_even" colspan="2"><?php if ($config->dojo) { ?>
			<input type="hidden" name="<?php echo $prefix;?>notes" id="<?php echo $prefix;?>notes"/>
			<div id="notes" dojoType="dijit.Editor" minHeight="5em" 
			plugins="['undo', 'redo', 'cut', 'copy', 'paste', '|', 'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', '|', 'removeFormat', 'indent', 'outdent', 'justifyCenter', 'justifyFull', 'justifyLeft', 'justifyRight', 'delete', 'insertOrderedList', 'insertUnorderedList', 'createLink', 'foreColor','hiliteColor']">
			<?php echo $event->notes; ?></div>
			<?php } else {?>
			<textarea name="<?php echo $prefix;?>notes" id="<?php echo $prefix;?>notes" rows="10" cols="80"><?php echo $event->notes; ?></textarea>
			<?php }?></td>
		</tr>
		<tr>
		<table><tr>
		<?php
		showAttendeeHeaderFields(MARRIAGE_EVENT);
		echo "</tr>";
		if ( count($event->attendees) == 0) {
			$event->attendees = array();
		}
		$event->attendees[] = new Attendee();
		$bDate = '0000-00-00';
		if (isset($e->date1)) {
			$bDate = $e->date1;
		}
		$prefix = 'a';
		foreach ($event->attendees as $a) {
			$show = false;
			if (isset($a->person->person_id) && $a->person->isEditable()) {
				echo "<tr><td>".$a->person->getDisplayName()."&nbsp;".$a->person->getDates()."</td>";
				$show = true;
			}
			if (!isset($a->person->person_id)) {
				echo "<tr><td>";
				selectPeople($prefix."person_id", 0, "A", 0, 0, $bDate);
				echo "</td>";
				$show = true;
			}
			if ($show) {
				showAttendeeEditCols($a, MARRIAGE_EVENT, $prefix);
				$prefix++;
			}
			echo "</tr>";
		}?>
		</tr>

		</table>
		</td>
		</tr>
		<tr>
			<td class="tbl_even" colspan="2"><input type="submit" name="Submit1" value="<?php echo $strSubmit; ?>" />
			<input type="RESET" name="Reset1" value="<?php echo $strReset; ?>" /></td>
		</tr>
	</table>
</form>
<?php
	$ret = "";
		
	echo get_image_create_string($per, $event->event_id);
	echo "<br/>";
	show_gallery($per, $dest = "people", $event->event_id);
}
?>
