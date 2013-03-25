<?php
function dateModifierSelect($name, $value) {
	global $strDateDescr, $strDateExplain;
	?><select name="<?php echo $name;?>" onChange="changeExample('<?php echo $name.'explain';?>',this.selectedIndex, dateModifierExamples)">
	<?php
	$i = 0;
	foreach ($strDateDescr as $dd) {
		echo '<option value="'.$i.'"';
		if ($value == $i) { echo ' selected="selected"';}
		echo ">".$dd."</option>";
		$i++;
	}
	?>
	</select><br/>
	<div id="<?php echo $name.'explain';?>"><?php echo $strDateExplain[$value];?></div>
	<?php
}

function showEventHeaderFields($type = 0) {
	global $strDate,$strCert,$strPlace,$strSource,$strReference,$strNotes;
	?>
		<?php if ($type != CENSUS_EVENT) {?>
		<th></th>
		<th class="tbl_odd"><?php echo $strDate; ?></th>
		<?php } //!= census event 
		?>
		<th class="tbl_odd"><?php echo $strPlace; ?></th>
		<th class="tbl_odd"><?php echo $strSource; ?></th>
		<th class="tbl_odd"><?php echo $strNotes; ?></th>
		<?php
}

function showEventEditCols($event, $type = 0, $prefix = '', $class = 'tbl_even') {
	global $strDateFmt;
	?>
	
	<td class="<?php echo $class;?>">
		<input type="hidden" name="<?php echo $prefix;?>event_id" value="<?php echo $event->event_id; ?>" />
		<input type="hidden" name="<?php echo $prefix;?>person_id" value="<?php echo $event->person->person_id; ?>" />
		<?php if ($type != CENSUS_EVENT) { 
	
		dateModifierSelect($prefix.'d1type',$event->date1_modifier);
		echo "</td><td class=\"".$class."\">";
			$bDate = '0000-00-00';
			if (isset($event->date1)) {
				$bDate = $event->date1;
			}
			?>
		
		<input type="text" name="<?php echo $prefix;?>date1" value="<?php echo $bDate; ?>" size="30" /><br/>
			<?php echo $strDateFmt; ?></td>
		<td class="<?php echo $class;?>">
		<?php } //!= census event 
		?>
		<?php selectPlace($prefix,$event->location);?>
		</td>
		<td class="<?php echo $class;?>"><?php
		$dao = getSourceDAO();
		$dao->getEventSources($event);
		$sp = "a";

		if ($event->numResults > 0) {
			foreach ($event->results as $source) {
				selectSource($sp."_".$prefix,$source, $event);
				$sp++;
			}
		} 
		//Always add a blank one
		$source = new Source();
		selectSource($sp."_".$prefix, $source, $event);
		?>
		</td>
		<td class="<?php echo $class;?>"><input type="text" name="<?php echo $prefix;?>notes" value="<?php echo $event->notes; ?>" size="30" /></td>
		<?php
}

function showEventCols($event, $type = 0, $prefix = '', $class = 'tbl_even') {
	global $strDateFmt;
	?>
	
	<td class="<?php echo $class;?>">
		<input type="hidden" name="<?php echo $prefix;?>event_id" value="<?php echo $event->event_id; ?>" />
		<input type="hidden" name="<?php echo $prefix;?>person_id" value="<?php echo $event->person->person_id; ?>" />
	<?php
		dateModifierSelect($prefix.'d1type',$event->date1_modifier);
		echo "</td><td class=\"".$class."\">";
			$bDate = '0000-00-00';
			if (isset($event->date1)) {
				$bDate = $event->date1;
			}
			?>
		
		<input type="text" name="<?php echo $prefix;?>date1" value="<?php echo $bDate; ?>" size="30" /><br/>
			<?php echo $strDateFmt; ?></td>
		<td class="<?php echo $class;?>">
		<?php selectPlace($prefix.'location',$event->location);?>
		</td>
		<td class="<?php echo $class;?>">
		<input type="checkbox" <?php if ($event->certified == "Y") { echo 'checked="checked"';}?> name="<?php echo $prefix;?>certified" value="Y" />
		</td>
		<td class="<?php echo $class;?>"><?php echo $event->source; ?></td>
		<td class="<?php echo $class;?>"><?php echo $event->reference; ?></td>
		<td class="<?php echo $class;?>"><?php echo $event->notes; ?></td>
		<?php
}

function attendeeEditTable($event, $type, $people) {
	?>
	<table><tr><?php showAttendeeHeaderFields($type); ?></tr><?php 
		$attendees = array();
		$prefix = 'a';
		foreach ($event->attendees as $a) {
			if ($a->person->isEditable()) {
				$attendees[] = $a->person->person_id;
				echo "<tr><td>".$a->person->getDisplayName()."&nbsp;".$a->person->getDates()."</td>";
				showAttendeeEditCols($a, $type, $prefix);
				$prefix++;
			}
		}

		foreach($people as $p) {
			if (!in_array($p->person_id,$attendees) && $p->isEditable()) {
				$a = new Attendee();
				$a->person = $p;
				echo "<tr><td>".$p->getDisplayName()."&nbsp;".$p->getDates()."</td>";
				showAttendeeEditCols($a, $type, $prefix);
				$prefix++;
				echo "</tr>";
			}
		}
	echo "</table>";
}

function showAttendeeHeaderFields($type) {
	global $strProfession,$strCert,$strPlace,$strAge,$strCondition,$strNotes;
	?>
	<?php if ($type != BIRTH_EVENT) { ?>	
	<th></th>
	<?php } ?>
		<th class="tbl_odd"><?php echo $strProfession; ?></th>
		<?php if ($type == MARRIAGE_EVENT || $type == CENSUS_EVENT) { ?>
		<th class="tbl_odd"><?php echo $strAge; ?></th>
		<th class="tbl_odd"><?php echo $strPlace; ?></th>
		<?php } ?>
		<?php if ($type == CENSUS_EVENT) {?>
		<th class="tbl_odd"><?php echo $strCondition; ?></th>
		<?php }
		if (0) { ?>
		<th class="tbl_odd"><?php echo $strCert; ?></th>
		<?php }?>
		<th class="tbl_odd"><?php echo $strNotes; ?></th>
		<?php
}

function showAttendeeEditCols($attendee, $type, $prefix = '', $class = "tbl_even") {
	global $strDateFmt, $tblprefix, $strMarried, $strUnmarried, $strWidowed;
	?>
	<td class="<?php echo $class;?>">
		<input type="hidden" name="<?php echo $prefix;?>event_id" value="<?php echo $attendee->event->event_id; ?>" />
		<input type="hidden" name="<?php echo $prefix;?>attendee_id" value="<?php echo $attendee->attendee_id; ?>" />
<?php		if (isset($attendee->person->person_id)) {?>
		<input type="hidden" name="<?php echo $prefix;?>person_id" value="<?php echo $attendee->person->person_id; ?>" />
		<?php } ?>
		<input type="text" name="<?php echo $prefix;?>profession" value="<?php echo $attendee->profession; ?>" size="30" />
	</td>
	<?php if ($type == MARRIAGE_EVENT || $type == CENSUS_EVENT) { ?>
	<td class="<?php echo $class;?>">
		<input type="text" name="<?php echo $prefix;?>age" value="<?php echo $attendee->age; ?>" size="5" />
	</td>
	<td class="<?php echo $class;?>">
		<?php selectPlace($prefix,$attendee->location);?>
	</td>
	<?php } ?>
	<?php if(0) {?>
	<td class="<?php echo $class;?>">
		<input type="text" name="<?php echo $prefix;?>loc_descrip" value="<?php echo $attendee->loc_descrip; ?>" size="10" />
	</td>
	<?php } ?>
	<?php if ($type == CENSUS_EVENT) {?>
		<td class="<?php echo $class;?>">
<select size="1" name="<?php echo $prefix;?>r_status">
<option <?php if ($attendee->condition == "") { echo ' selected="selected" ';} ?>value=""></option>
<option <?php if ($attendee->condition == "married") { echo ' selected="selected" ';} ?> value="married"><?php echo $strMarried;?></option>
<option <?php if ($attendee->condition == "unmarried") { echo ' selected="selected" ';} ?>value="unmarried"><?php echo $strUnmarried;?></option>
<option <?php if ($attendee->condition == "widowed") { echo ' selected="selected" ';} ?> value="widowed"><?php echo $strWidowed;?></option>
</select>

</td>
	<?php } 
		if (0) { ?>
	<td class="<?php echo $class;?>">
		<input type="checkbox" <?php if ($attendee->certified == "Y") { echo 'checked="checked"';}?> name="<?php echo $prefix;?>certified" value="Y" />
	</td>
	<?php }?>
	<td class="<?php echo $class;?>"><textarea cols="30" rows="3" name="<?php echo $prefix;?>notes"><?php echo $attendee->notes; ?></textarea></td>
	<?php
}
?>
