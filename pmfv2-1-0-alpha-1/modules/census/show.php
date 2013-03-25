<?php
include_once "modules/db/DAOFactory.php";

define('SHOW_CENSUS',0);
define('LIST_CENSUS',1);
	function printCensusHeader($type, $editable) {
		global $strName, $strYear, $strSchedule, $strAddress, $strCondition, $strAge, $strProfession, $strBirthPlace, $strDetails; 
		if ($type == SHOW_CENSUS) {
?>
			<th><?php echo $strName; ?></th>
		<?php } else { ?>
			<?php if ($editable) { ?>
				<th></th>
			<?php }?>
			<th><?php echo $strYear; ?></th>
			<th><?php echo $strSchedule; ?></th>
<?php		} ?>
			
			<th><?php echo $strAddress; ?></th>
			<th><?php echo $strCondition; ?></th>
			<th><?php echo $strAge; ?></th>
			<th><?php echo $strProfession; ?></th>
			<th><?php echo $strBirthPlace; ?></th>
			<th><?php echo $strDetails; ?></th>
<?php
	}
	function printCensusRow($cen, $attendee, $type, $per, $class) {
		global $strEdit, $strDelete, $strCensus;

		if ($type == SHOW_CENSUS) {
?>
			<td class="<?php echo $class; ?>">
			<?php echo $attendee->person->getLink();?>
			</td>
<?php
		} else {
			if ($per->isEditable()) {
					echo "<td class=\"".$class."\">";
					echo "<a href=\"edit.php?person=".$per->person_id."&amp;area=census&amp;event=".$cen->event->event_id."\">".$strEdit."</a>".
						"::".
						"<a href=\"JavaScript:confirm_delete('".$cen->year." (".$cen->country.")', '".strtolower($strCensus)."', 'passthru.php?func=delete&amp;person=".$cen->event->person->person_id."&amp;area=census&amp;event=".$cen->event->event_id."')\" class=\"delete\">".
						$strDelete.
	"</a>";
					echo "</td>";
				}
?>
			<td class="<?php echo $class; ?>"><?php echo $cen->year." (".$cen->country.")"; ?></td>
			<td class="<?php echo $class; ?>">
				<a href="census.php?event=<?php echo $cen->event->event_id;?>">full details</a><?php 
				$sdao = getSourceDAO();
				$sdao->getEventSources($cen->event);
				if (is_array($cen->event->results) && count($cen->event->results) > 0) {
			foreach ($cen->event->results as $src) {
				echo $src->getFullDisplay();
			}
		}
		?>
			</td>
<?php	
		}

		
		
?>
			<td class="<?php echo $class; ?>"><?php echo $cen->event->location->getDisplayPlace(); ?></td>
			<td class="<?php echo $class; ?>"><?php echo $attendee->condition; ?></td>
			<td class="<?php echo $class; ?>"><?php echo $attendee->age; ?></td>
			<td class="<?php echo $class; ?>"><?php echo $attendee->profession; ?></td>
			<td class="<?php echo $class; ?>"><?php echo $attendee->location->getDisplayPlace(); ?></td>
			<td class="<?php echo $class; ?>"><?php echo $attendee->notes; ?></td>
<?php
	}
	
	function get_census_create_string($per) {
	global $strInsert, $strNewCensus;
	$ret = "";
	if ($per->isEditable()) {
		$ret = "<a href=\"edit.php?area=census&amp;person=".$per->person_id."\">".
		$strInsert."</a> ".
		$strNewCensus; 
	}
	return ($ret);
}

function get_census_title() {
	global $strCensusDetails;
	return $strCensusDetails;
}
	function show_census_title($per) {
		?>
		<table width="100%">
		<tr>
			<td width="80%"><h4><?php echo get_census_title(); ?></h4></td>
			<td width="20%" valign="top" align="right">
<?php
			echo get_census_create_string($per);
?>
			</td>
		</tr>
		</table>
<?php

	}
	
	function show_census($per) {
		global $strNoInfo, $restrictmsg;
		$search = new CensusDetail();
		$search->setFromRequest();
		
		if (!$per->isViewable()) {
			echo $restrictmsg."\n";
			return (0);
		} else {
			$dao = getCensusDAO();
			$dao->getCensusDetails($search);
			if (count($search->results) < 1)
				echo $strNoInfo."\n";
			else {
?>
	<table width="100%">
		<tr>
<?php		printCensusHeader(LIST_CENSUS, $per->isEditable()); ?>
		</tr>
<?php
	
		for($i=0; $i < $search->numResults; $i++) {
			if ($i == 0 || fmod($i, 2) == 0) {
				$class = "tbl_odd";
			} else {
				$class = "tbl_even";
			}
			$cen = $search->results[$i];
?>
		<tr>
<?php
foreach ($cen->event->attendees as $attendee) {
		printCensusRow($cen, $attendee, LIST_CENSUS, $per, $class);
}
?>
		</tr>
<?php
		}
		echo "</table>";
			}
		}
		return ($search->numResults);
	}
?>