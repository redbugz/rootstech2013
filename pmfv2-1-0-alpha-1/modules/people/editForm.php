<?php
include_once("modules/event/show.php");
include_once("modules/location/show.php");
include_once("modules/source/show.php");

function setup_edit() {
	$per = new PersonDetail();
	$per->father = new PersonDetail();
	$per->mother = new PersonDetail();
	$per->birth_place = new Location();
	$per->setFromRequest();
	$per->queryType = Q_IND;
	$dao = getPeopleDAO();
	$dao->getPersonDetails($per);
	if ($per->numResults > 0) {
		$ret = $per->results[0];
	} else {
		$ret = $per;
	}
	$dao = getEventDAO();
	$e = new Event();
	$e->person->person_id = $per->person_id;
	$dao->getEvents($e, Q_BD, true);
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
	global $strNewMsg, $strTitle, $strName, $strFirstNames, $strLinkNames, $strLastName, $strAKA,$strSuffix, 
	$strEvent, $strCauseDeath, $strGender, $strFaB,
	$strMale, $strFemale, $strMother, $strFather, $strNotes, $strSubmit, $strReset;
	$config = Config::getInstance();
	if ($config->dojo) {
	?><script  type="text/javascript">
	dojo.addOnLoad(function() {
                        var widget = dijit.byId('notes');
                        widget.name = 'frmNarrative';
                        dojo.connect(widget, 'onChange', function(){
                        widget.endEditing();
                        var desc = widget.getValue();
                        var stext = dojo.byId('frmNarrative');
                        stext.value = desc;
                        });
                });
	</script><?php
	}	
$mid = 0;
$fid = 0;
$gender = "M";
if (isset($_REQUEST["fid"])) { $fid = $_REQUEST["fid"]; } else { $fid = $per->father->person_id; }
if (isset($_REQUEST["mid"])) { $mid = $_REQUEST["mid"]; } else { $mid = $per->mother->person_id; }
if (isset($_REQUEST["gender"])) { $gender = $_REQUEST["gender"]; } else { $gender = $per->gender; }
if (!isset($per->person_id)) {
	?>
<b><?php echo $strNewMsg; ?></b><br />
<?php } ?>

<form method="post" action="passthru.php?area=people&func=edit">
<?php if (isset($per->person_id)) { ?> 
<input type="hidden" name="person" value="<?php echo $per->person_id; ?>" />
<?php 	}
	if (isset($_REQUEST["cid"])) { 
		$cid = $_REQUEST["cid"];?>
		<input type="hidden" name="frmChild" value="<?php echo $cid;?>" />
<?php
	} 
?>
	<table>
		<tr>
			<td class="tbl_odd"><?php echo $strName; ?></td>
			<td class="tbl_even">
			<table><tr><th><?php echo $strTitle; ?></th>
			<th><?php echo $strFirstNames; ?></th>
			<th><?php echo $strLinkNames; ?></th>
			<th><?php echo $strLastName; ?></th>
			<th><?php echo $strSuffix; ?></th></tr>
			<tr>
			<td><input type="text" name="frmTitle" value="<?php echo $per->name->title; ?>" size="5" maxlength="20" /></td>
			<td><input type="text" name="frmForenames" value="<?php echo $per->name->forenames; ?>" size="30" maxlength="50" /></td>
			<td><input type="text" name="frmLink" value="<?php echo $per->name->link; ?>" size="5" maxlength="10" /></td>
			<td><input type="text" name="frmSurname" value="<?php echo $per->name->surname; ?>" size="20" maxlength="20" /></td>
			<td><input type="text" name="frmSuffix" value="<?php echo $per->name->suffix; ?>" size="10" maxlength="20" /></td>
			</tr></table>
			</td>
			
		</tr>
		<tr>
			<td class="tbl_odd"><?php echo $strAKA; ?></td>
			<td class="tbl_even"><input type="text" name="frmAKA" value="<?php echo $per->name->knownas; ?>" size="30" maxlength="10" /></td>
		</tr>
		<tr>
			<td class="tbl_odd"><?php echo $strCauseDeath; ?></td>
			<td class="tbl_even" colspan="2"><input type="text" name="frmDeathReason" value="<?php echo $per->death_reason; ?>" size="30" maxlength="50" /></td>
		</tr>
		<tr>
			<td class="tbl_odd"><?php echo $strGender; ?></td>
			<td class="tbl_even" colspan="2"><input type="radio" name="frmGender" value="M" <?php if ($gender != "F") { echo 'checked="checked" ';}?> /><?php echo $strMale; ?><input type="radio" name="frmGender" value="F" <?php if ($gender == "F") { echo 'checked="checked" ';}?>/><?php echo $strFemale; ?></td>
		</tr>
		<?php
				$bDate = '0000-00-00';
				if (isset($per->date_of_birth)) {
					$bDate = $per->date_of_birth;
				}
			?>
		<tr>
			<td class="tbl_odd"><?php echo $strMother; ?></td>
			<td class="tbl_even" colspan="2"><?php selectPeople("frmMother", $per->person_id, "F", $mid, 0, $bDate); ?></td>
		</tr>
		<tr>
			<td class="tbl_odd"><?php echo $strFather; ?></td>
			<td class="tbl_even" colspan="2"><?php selectPeople("frmFather", $per->person_id, "M", $fid, 0, $bDate); ?></td>
		</tr>
		<tr>
			<td class="tbl_odd"><?php echo $strFaB;?></td>
			<td class="tbl_even" colspan="2">
			<table><tr><?php showAttendeeHeaderFields(BIRTH_EVENT); ?></tr><tr><?php 
			$birthEvent = null;
			if ($per->events) {
				foreach ($per->events AS $e) {
					if ($e->type == BIRTH_EVENT) {
						$birthEvent = $e;
					}
				}
			}
			if ($birthEvent != null) {
				if ( count($birthEvent->attendees) == 0) {
					$birthEvent->attendees = array();
					$birthEvent->attendees[] = new Attendee();
					$birthEvent->attendees[0]->person->person_id = $fid;
				}
				foreach ($birthEvent->attendees as $a) {
					if ($a->person->person_id == $fid) {
						showAttendeeEditCols($a, BIRTH_EVENT);
					}
				}
			} else {
				$a = new Attendee();
				showAttendeeEditCols($a, BIRTH_EVENT);
			}
			
			?></tr></table></td>
		</tr>
		<tr>
			<td class="tbl_odd" valign="top"><?php echo $strNotes; ?></td>
			<td colspan="2" class="tbl_even"><?php if ($config->dojo) { ?>
			<input type="hidden" name="frmNarrative" id="frmNarrative"/>
			<div id="notes" dojoType="dijit.Editor" minHeight="5em" 
			plugins="['undo', 'redo', 'cut', 'copy', 'paste', '|', 'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', '|', 'removeFormat', 'indent', 'outdent', 'justifyCenter', 'justifyFull', 'justifyLeft', 'justifyRight', 'delete', 'insertOrderedList', 'insertUnorderedList', 'createLink', 'foreColor','hiliteColor']">
			<?php echo $per->narrative; ?></div>
			<?php } else {?>
			<textarea name="frmNarrative" id="frmNarrative" rows="10" cols="80"><?php echo $per->narrative; ?></textarea>
			<?php }?></td>
		</tr>
		<tr>
		<td colspan="3">
		<table>
		<tr><th></th><?php showEventHeaderFields()?></tr>
		<?php
		$events = array($birthEvent,null,null,null);
		if ($per->events) {
			foreach ($per->events AS $e) {
				$events[$e->type] = $e;
				echo "<tr><td>".$strEvent[$e->type]."</td>";
				?><input type="hidden" name="<?php echo $strEvent[$e->type];?>etype" value="<?php echo $e->type; ?>" /></td><?php
				showEventEditCols($e, $e->type, $strEvent[$e->type]);
				echo "</tr>";
			}
		}
		for ($i = 0; $i < 4;$i++) {
			if (!isset($events[$i]) && $events[$i] == null) {
				$e = new Event();
				$e->type = $i;
				$e->person->person_id = $per->person_id;
				echo "<tr><td>".$strEvent[$e->type];
				?><input type="hidden" name="<?php echo $strEvent[$e->type];?>etype" value="<?php echo $e->type; ?>" /></td><?php
				showEventEditCols($e, $e->type, $strEvent[$e->type]);
				echo "</tr>";
			}
		}
		?>
		</table>
		</td>
		</tr>
		<tr>
			<td class="tbl_even"><input type="submit" name="Submit1" value="<?php echo $strSubmit; ?>" /></td>
			<td class="tbl_even"><input type="RESET" name="Reset1" value="<?php echo $strReset; ?>" /></td>
		</tr>
	</table>
</form>
<?php
}
?>