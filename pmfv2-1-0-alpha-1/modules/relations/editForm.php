<?php
include_once("modules/event/show.php");
include_once("modules/location/show.php");
include_once("modules/source/show.php");

function setup_edit() {
	$rel = new Relationship();
	$rel->setFromRequest();
	if (!$rel->relation->person_id) {
		$rel->relation->person_id = -1;
	}
	
	$pdao = getPeopleDAO();
	if ($rel->person->person_id > 0) {
		$dao = getRelationsDAO();
		$dao->getRelationshipDetails($rel);
		if ($rel->numResults > 0) {
			$ret = $rel->results[0];
			$pdao->getParents($ret->relation);
		} 
	} else {
		$ret = $rel;
	}
	
	$pdao->getParents($ret->person);
		
			
	$dao = getEventDAO();
	$e = new Event();
	$e->event_id = $ret->event->event_id;
	$dao->getEvents($e,Q_REL, true);
	
	if ($e->numResults == 0) {
		$e = new Event();
		$e->type = MARRIAGE_EVENT;
		$ret->event = $e;
	} else {
		$ret->event = $e->results[0];
	}
	$ret->event->person->person_id = 'null';
	return ($ret);
}

function get_edit_title($rel) {
	global $strEditing, $strMarriage, $strNewMarriage;
	if ($rel->relation->person_id > 0) {
		return($strEditing." ".$strMarriage.": ".$rel->person->name->getDisplayName()." &amp; ".$rel->relation->getDisplayName());
	} else {
		return (ucwords($strNewMarriage).": ".$rel->person->name->getDisplayName());
	}
}

function get_edit_header($rel) {
	global $strMarriage, $strNewMarriage;
	
	if ($rel->relation->person_id > 0) {
		return ($strMarriage.": ".$rel->person->name->getDisplayName()." &amp; ".$rel->relation->name->getDisplayName());
	} else {
		return ($strNewMarriage.": ".$rel->person->name->getDisplayName());
	}
}

function get_edit_form($rel) {
	global $strSpouse, $strMarriageCert, $strSubmit, $strReset, $strDateFmt;
	global $strDivorce, $strDate, $strEvent, $strEdit, $strDesc;
	
?>
<!--Fill out form -->
<form method="post" action="passthru.php?area=relations">
<input type="hidden" name="person" value="<?php echo $rel->person->person_id; ?>" />
<input type="hidden" name="oldSpouse" value="<?php echo $rel->relation->person_id ?>" />
<input type="hidden" name="frmGender" value="<?php echo $rel->person->gender; ?>" />
	<table>
		<tr>
			<td class="tbl_odd"><?php echo $strSpouse; ?></td>
			<td colspan="2" class="tbl_even"><?php
			if ($rel->person->gender == "M") {
				$gen = "F";
			} else {
				$gen = "M";
			}
			selectPeople("frmSpouse", $rel->person->person_id, $gen, $rel->relation->person_id, 0, $rel->marriage_date);
			
?></td>
		</tr>
		<tr>
			<td class="tbl_odd"><?php echo $strDivorce." ".$strDate; ?></td>
			<?php
				$mDate = '0000-00-00';
				if (isset($rel->dissolve_date)) {
					$mDate = $rel->dissolve_date;
				}
			?>
			<td class="tbl_even"><input type="text" name="frmDissolveDate" value="<?php echo $mDate; ?>" size="15" maxlength="10" />
			<input type="hidden" name="frmDissolveReason" value="0" />
			</td>
			<td><?php echo $strDateFmt; ?></td>
		</tr>
		<tr>
		<td colspan="3">
		<table>
		<tr><th></th><?php showEventHeaderFields()?></tr>
		<tr><td>
		<select name="etype">
		<option value="<?php echo BANNS_EVENT;?>" <?php if ($rel->event->type == BANNS_EVENT) { echo ' selected="selected"';}?>><?php echo $strEvent[BANNS_EVENT];?></option>
		<option value="<?php echo MARRIAGE_EVENT;?>" <?php if ($rel->event->type == MARRIAGE_EVENT) { echo ' selected="selected"';}?>><?php echo $strEvent[MARRIAGE_EVENT];?></option>
		</select>
		
		</td><?php
		showEventEditCols($rel->event, '');?>
		</tr></table></td>
		</tr>
		<tr>
			<td class="tbl_even" colspan="3">
			<?php
			$people = array($rel->person);
			if ($rel->relation->person_id > 0) {
				$people[] = $rel->relation;
			}
			for ($i = 0;$i<2;$i++) {
				$p = $people[$i];
				if (isset($people[$i])) {
					if (isset($p->father->person_id) && $p->father->person_id > 0 && $p->father->isEditable()) {
						$people[] = $p->father;
					}
					if (isset($p->mother->person_id) && $p->mother->person_id > 0 && $p->father->isEditable()) {
						$people[] = $p->mother;
					}
				}
			}
			attendeeEditTable($rel->event, MARRIAGE_EVENT, $people);
			?></td>
		</tr>
		<tr>
			<td class="tbl_even"><input type="submit" name="Submit1" value="<?php echo $strSubmit; ?>" /></td>
			<td colspan="2" class="tbl_even"><input type="reset" name="Reset1" value="<?php echo $strReset; ?>" /></td>
		</tr>
	</table>
</form>
<?php
echo '<div id="image"><a href="edit.php?func=edit&amp;area=event&amp;event='.$rel->event->event_id.'">'.$strEdit.' '.$strDesc.'</a></div>';
}
?>