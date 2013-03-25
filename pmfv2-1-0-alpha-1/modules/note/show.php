<?php

function get_note_title() {
	global $strNotes;
	return $strNotes;
}

function show_note_title($per) {
	global $strNotes;
	?>
	<table width="100%">
		<tr>
			<td width="80%"><h4><?php echo get_note_title(); ?></h4></td>
			<td align="right"><?php
			echo get_note_create_string($per);
?></td>
		</tr>
	</table>
	<?php
}

function get_note_create_string($per) {
	global $strInsert, $strNotes;
	$ret = "";
	if ($per->isEditable()) {
		$ret = "<a href=\"edit.php?func=add&amp;person=".$per->person_id."&amp;area=event\">".
		$strInsert."</a> ".
		strtolower($strNotes)."</td>";
	} 
	return ($ret);
}

function show_note($per) {
	global $restrictmsg, $strEdit;
	$ret = 0;
	if (!$per->isViewable()) {
		echo $restrictmsg."\n";
	} else {
		echo $per->narrative."\n";
		if (strlen($per->narrative) > 0) {
			$ret = 1;
		}
			$edao = getEventDAO();
			$e = new Event();
			$e->person->person_id = $per->person_id;
			$edao->getEvents($e, Q_OTHER, true);
			$per->events = $e->results;
			foreach ($e->results as $event) {
				echo "<hr/>";
				echo '<div id="note'.$ret.'"><a href="edit.php?func=edit&amp;area=event&amp;event='.$event->event_id.'">'.$strEdit.'</a></div>';
				echo $event->getFullDisplay("note".$ret);
				$ret++;
			}
	}
	return ($ret);
}
?>