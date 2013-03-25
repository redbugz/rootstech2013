<?php

function show_transcript($per, $eid = -1, $sid = -1) {
	$trans = new Transcript();
	$trans->setFromRequest();
	$dao = getTranscriptDAO();
	$dao->getTranscripts($trans, $eid, $sid);
	if ($trans->numResults > 0) {
		foreach ($trans->results as $t) {
			$t->person = $per;
		}
	}
	return(show_transcript_details($trans));
}

function get_transcript_create_string($per, $eid = -1, $sid = -1) {
	global $strUpload, $strNewTrans;
	$ret = "";
	if ($per->isEditable()) {
		$ret = "<a href=\"edit.php?func=add&amp;area=transcript&amp;person=".$per->person_id;
		if ($eid > 0) {
			$ret .= "&amp;event=".$eid;
		}
		if ($sid > 0) {
			$ret .= "&amp;source=".$sid;
		}
		
		$ret .= "\">".
		$strUpload."</a> ".
		$strNewTrans; 
	}
	return ($ret);
}

function get_transcript_title() {
	global $strDocTrans;
	return $strDocTrans;
}
function show_transcript_title($per) {
?>
<table width="100%">
		<tr>
			<td width="80%"><h4><?php echo get_transcript_title(); ?></h4></td>
			<td width="20%" valign="top" align="right"><?php
				echo get_transcript_create_string($per);
				?></td>	
		</tr>
	</table>
<?php
}
function show_transcript_details($trans) {
	global $strRestricted, $strNoInfo, $strTitle, $strDesc, $strDate, $strDelete, $strTranscript, $strRightClick, $strEdit ;
	
	$restricted = true;
	$editable = true;

	if ($trans->numResults == 0) {
?>
	<?php echo $strNoInfo; ?><br />
<?php
	} else {
?>
	<table>
		<tr>
			<th width="30%"><?php echo $strTitle; ?></th>
			<th width="60%"><?php echo $strDesc; ?></th>
			<th width="10%"></th>
		</tr>
<?php
		for ($i=0; $i < $trans->numResults; $i++) {
			$doc = $trans->results[$i];
			if ($i == 0 || fmod($i, 2) == 0) {
				$class = "tbl_odd";
			} else {
				$class = "tbl_even";
			}
			if (!($doc->person->isViewable() || $doc->source->isViewable())) {
				echo '<tr><td colspan="3" class="'.$class.'">'.$strRestricted."</td></tr>\n";
			} else {
?>
		<tr>
			<td class="<?php echo $class; ?>"><a href="document.php?docid=<?php echo $doc->transcript_id; ?>"><?php echo $doc->title; ?></a></td>
			<td class="<?php echo $class; ?>"><?php echo $doc->event->getFullDisplay($class); ?></td>
			<td class="<?php echo $class; ?>">
<?php
				if ($doc->person->isEditable() || $doc->source->isEditable()) {
					echo "(<a href=\"edit.php?func=add&amp;area=transcript&amp;person=".$trans->person->person_id."&amp;transcript=".$doc->transcript_id."\">".
					$strEdit."</a>) ";
?>
				(<a href="JavaScript:confirm_delete('<?php echo $doc->title; ?>', '<?php echo strtolower($strTranscript); ?>', 'passthru.php?func=delete&amp;area=transcript&amp;person=<?php echo $trans->person->person_id; ?>&amp;transcript=<?php echo $doc->transcript_id; ?>')" class="delete"><?php echo $strDelete; ?></a>)
<?php
				} 
			}
?>
			</td>
		</tr>
<?php
			}
			
?>
	</table>
<br /><?php echo $strRightClick; ?><br />
<?php
	}
	return ($trans->numResults);
}
?>