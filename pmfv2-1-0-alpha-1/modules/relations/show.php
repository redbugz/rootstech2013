<?php
include_once "modules/db/DAOFactory.php";

function insertChildrenLink($pid, $spid, $gender, $editable) {
		global $strInsert, $strChildren;		
                $icona="";		
		if ($gender == "M") {
			$mid = $spid;
			$fid = $pid;
			$icona="<img border='0' src='images/smale.gif' alt='M' height='20' /> M";  // MODIFICA 20120506				
		} else {
			$fid = $spid;
			$mid = $pid;
			$icona="<img border='0' src='images/sfemale.gif' alt='F' height='20' /> F";  // MODIFICA 20120506			
		}
		if ($editable) {
?>
 (<a href="edit.php?func=add&area=people&mid=<?php
 	 echo $mid;
 	 ?>&fid=<?php echo $fid;?>"><?php echo $strInsert." ".$strChildren;?></a>) <?php 
		}
	}
	
function get_relations_create_string($per) {
	global $strInsert, $strNewMarriage;
	$ret = "";
	if ($per->isEditable()) {
		$ret = "<a href=\"edit.php?func=add&amp;person=".$per->person_id."&amp;area=marriage\">".
		$strInsert."</a> ".
		$strNewMarriage;
	} 
	return ($ret);
}

function get_relations_title() {
	global $strMarried;
	return $strMarried;
}

function show_relations_title($per) {
	?>
<table width="100%">
		<tr>
			<td width="80%"><h4><?php echo get_relations_title(); ?></h4></td>
			<td align="right"><?php
			echo get_relations_create_string($per);
?></td>
		</tr>
	</table>
<?php
}
function show_relations($per) {
	global $strMarriage, $strRestricted, $strOn, $strAt, $strCertified, 
			$strEdit, $strDelete;
	$editable = $per->isEditable();

	$search = new Relationship();
	$search->setFromRequest();
	$dao = getRelationsDAO();
	$dao->getRelationshipDetails($search);
	$count = 0;
		for($i=0; $i < $search->numResults; $i++) {
			$rel = $search->results[$i];
			if (!isset($rel->relation->person_id)) {
				continue;
			}
			if ($i > 0) { echo "<hr/>"; }
			$count++;
			echo $rel->relation->getLink();
			if ($rel->isViewable()) {
				if ($rel->marriage_date != "0000-00-00") {
					echo " ".$strOn." ".$rel->dom;
				}
				echo $rel->marriage_place->getAtDisplayPlace();
			}
			if ($rel->marriage_cert == "Y") {
				echo " ($strCertified)";
			}
			if ($rel->isEditable()) {
				echo " (<a href=\"edit.php?func=edit&amp;area=relations&amp;person=".$rel->person->person_id."&amp;event=".$rel->event->event_id."\">".$strEdit."</a>)";
				echo " (<a href=\"JavaScript:confirm_delete('".$rel->relation->getDisplayName()."', '".strtolower($strMarriage)."', 'passthru.php?func=delete&amp;area=marriage&amp;person=".$rel->person->person_id."&amp;event=".$rel->event->event_id."')\" class=\"delete\">".$strDelete."</a>)";
			}

			insertChildrenLink($rel->person->person_id, $rel->relation->person_id, $rel->person->gender, $rel->isEditable());
		}
	return ($count);
}

?>
