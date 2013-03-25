<?php
include_once "modules/db/DAOFactory.php";
include_once("modules/location/show.php");
include_once("modules/event/show.php");
include_once("modules/source/show.php");

function setup_edit() {
	// get the person to edit
	$search = new CensusDetail();
	$search->setFromRequest();
	$search->queryType = Q_FAMILY;
	$dao = getCensusDAO();
	$dao->getCensusDetails($search);
	if ($search->numResults > 0) {
		$ret = $search->results[0];
		$ret->person = $search->person;
	} else {
		$pdao = getPeopleDAO();
		$ret = new CensusDetail();
		$ret->person->setFromRequest();
		$ret->person->queryType = Q_IND;
		$pdao->getPersonDetails($ret->person);
		$ret->event->person = $ret->person->results[0];
		$ret->person = $ret->person->results[0];	
	}
	
	return ($ret);
}

function get_edit_title($search) {
	return ($search->getEditTitle());
}

function get_edit_header($rel) {
	return (get_edit_title($rel));
}

	// function: list_censuses
	// Provide a list of censuses
	function list_censuses($name, $val) {
		global $tblprefix;
		global $err_list_census;

		$search = new CensusDetail();
		$dao = getCensusDAO();
		$cresult = $dao->getCensusYears('');
		$dates = '';
		$date[0] = '';
		$i = 0;
		// do the output
		echo "<select name=".$name." onChange=\"changeCensusDate(this.selectedIndex)\">\n";
		echo "<option value=\"0\"></option>";
		foreach($cresult as $crow) {
			echo "<option value=\"".$crow->census_id."\"";
			if ($val == $crow->census_id) { echo " selected=\"selected\" ";}
			echo ">".$crow->year." / ".$crow->country."</option>\n";
			$dates .= "censusDates[$i+1] = '".$crow->census_date."';\n";
			$i++;
		}
		echo "</select>\n";
		
		?>
<script language="javascript">
var censusDates = new Array();
<?php echo $dates;?>
function changeCensusDate(fieldValue) {

	var newDate = null;
	newDate = censusDates[fieldValue];
	
	if( newDate == null ) 
	 return;
//TODO
	// change the display example
	document.getElementById('date1').value = newDate;
	
}
changeCensusDate(<?php echo $val;?>);
</script>
		<?php
	}	// end of list_censuses()
	
	
function get_edit_form($search) {
	global $strYear, $strSource, $strSchedule;
	global $strSubmit, $strReset;
	
?>



<!--Fill out the form-->
<form method="post" action="passthru.php?area=census">

	<input type="hidden" name="person" value="<?php echo $search->event->person->person_id;?>"/>
	<input type="hidden" name="d1type" value="8" size="30" />
	<input type="hidden" name="date1" id="date1" value="<?php echo $search->event->date1; ?>" size="30" />
	<input type="hidden" name="etype" value="<?php echo CENSUS_EVENT;?>" />
	<table>
		<tr><td><table><tr><th></th><?php showEventHeaderFields(CENSUS_EVENT)?><th><?php echo $strSchedule;?></th></tr>
		<tr><td class="tbl_even"><?php list_censuses("frmYear",$search->census); ?></td>
		<?php
		showEventEditCols($search->event, CENSUS_EVENT);?>
		<td class="tbl_even"><input type="text" name="schedule" value="<?php echo $search->schedule;?>"/></td>
		</tr>
		</table>
		</td></tr>
		<tr>
		<td class="tbl_even">
		<?php 
			$sp = $search->event->person;
			$sp = $search->person;
			$people = array($sp);
			$rel = new Relationship();
			$rel->person = $sp;
			$dao = getRelationsDAO();
			$dao->getRelationshipDetails($rel);
			if ($rel->numResults > 0) {
				$spouses = $rel->results;
				foreach($spouses as $partner) {
					$relation = $partner->relation;
					if (isset($relation) && $relation->person_id > 0 && $relation->isEditable()){
						$people[] = $relation;
					}
				}
			}
			
			$dao = getPeopleDAO();
			$per = $sp;
			if($dao->getChildren($per) > 0) {
				foreach ($per->children AS $child) {
					if ($child->isEditable()) {
						$people[] = $child;
					}
				}
			}

			attendeeEditTable($search->event, CENSUS_EVENT, $people);
			?></table></td>
		</tr>
		<tr>
			<td class="tbl_even"><input type="submit" name="Submit1" value="<?php echo $strSubmit; ?>" /></td>
			<td class="tbl_even"><input type="reset" name="Reset1" value="<?php echo $strReset; ?>" /></td>
		</tr>
	</table>
</form>
<?php
}
?>
