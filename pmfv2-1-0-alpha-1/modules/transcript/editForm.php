<?php
include_once("modules/source/show.php");

function setup_edit() {
	$trans = new Transcript();
	$trans->setFromRequest();
	if (!isset($trans->transcript_id)) {
		if (isset($_REQUEST["person"]) && $trans->person->person_id > 0) {
			$trans->person->queryType = Q_IND;
			$dao = getPeopleDAO();
			$dao->getPersonDetails($trans->person);
			if($trans->person->numResults == 0) {
				$trans->person = $trans->person->results[0];
			
			} else {
				$trans->person = new PersonDetail();
				$trans->person->setFromRequest();
			}
		} else {
			$trans->person = new PersonDetail();
			$trans->person->setFromRequest();
		}
		$trans->source = new Source();
		$trans->source->setFromRequest();
		if ($trans->source->source_id > 0) {
			$sdao = getSourceDAO();
			$sdao->getSources($trans->source);
			if ($trans->source->numResults > 0) {
				$trans->source = $trans->source->results[0];
			}
		}
		$ret = $trans;
	} else {
		$dao = getTranscriptDAO();
		$dao->getTranscripts($trans);
		if($trans->numResults == 0) {
			if (isset($_REQUEST["event"])) {
				$dao = getEventDAO();
				$event = new Event();
				$event->setFromRequest();
				$dao->getEvents($event, Q_ALL);
				$trans->event = $event->results[0];
				$trans->person = $trans->event->person;
			} 
			if ($trans->person->person_id > 0) {
				$trans->person->queryType = Q_IND;
				$dao = getPeopleDAO();
				$dao->getPersonDetails($trans->person);
				$trans->person = $trans->person->results[0];
			} else {
				$trans->person = new PersonDetail();
			}
			$trans->source = new Source();
			$trans->source->setFromRequest();
			if ($trans->source->source_id > 0) {
				$sdao = getSourceDAO();
				$sdao->getSources($trans->source);
				if ($trans->source->numResults > 0) {
					$trans->source = $trans->source->results[0];
				}
			}
			$ret = $trans;

		} else {
			$ret = $trans->results[0];
		}
	}
	return($ret);
}

function get_edit_title($trans) {
	global $strNewTrans;
	$ret = "";
	if (isset($trans->transcript_id)) {
	} else {
		$ret .= ucwords($strNewTrans);
	}
	$ret .= ": ";
	$ret .= $trans->title;
	return ($ret);
}
function get_edit_header($trans) {
	return (get_edit_title($trans));
}

function get_edit_form($trans) {
	global $strFUpload, $strFTitle, $strDesc, $strSubmit, $strEdit, $strSource;
?>
<!--Fill out the form-->
<form enctype="multipart/form-data" method="post" action="passthru.php?func=insert&amp;area=transcript">
<input type="hidden" name="person" value="<?php echo $trans->person->person_id;?>" />
<?php if (isset($trans->transcript_id)) { ?>
<input type="hidden" name="transcript_id" value="<?php echo $trans->transcript_id;?>" />
<?php } ?>
	<table>
	<?php if (!isset($trans->transcript_id)) { 
		$tdate = "0000-00-00";
		?>
		<tr>
			<td class="tbl_odd"><?php echo $strFUpload; ?></td>
			<td class="tbl_even"><input type="file" name="userfile" /></td>
		</tr>
	<?php } else {
	}?>
		<tr>
			<td class="tbl_odd"><?php echo $strFTitle; ?></td>
			<td class="tbl_even"><input type="text" name="frmTitle" size="30" maxlength="30" value="<?php echo $trans->title;?>"/></td>
		</tr>
		<tr>
			<td class="tbl_odd"><?php echo $strSource; ?></td>
			<td class="tbl_even"><?php selectSource("", $trans->source, $trans->event);?></td>
		</tr>		
		<tr>
			<td class="tbl_even"><input type="submit" name="Submit1" value="<?php echo $strSubmit; ?>" /></td>
			<td class="tbl_even"></td>
		</tr>
	</table>
</form>
<?php
	if (isset($trans->transcript_id)) { 
		echo '<div id="trans"><a href="edit.php?func=edit&amp;area=event&amp;event='.$trans->event->event_id.'">'.$strEdit.' '.$strDesc.'</a></div>';
	}
}