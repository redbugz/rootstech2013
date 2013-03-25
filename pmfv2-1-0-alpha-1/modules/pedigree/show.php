<?php

function show_pedigree($per) {	
	global $ids;
	// if trying to access a restriced person
	if (!$per->isViewable())
		die(include "inc/forbidden.inc.php");

	$dao = getPeopleDAO();
	$dao->getParents($per);
	// Use an array to get people references
	$ids = array_fill(1, 15, 0);
	$ids[1] = $per;
	$ids[2] = $per->father;
	$ids[3] = $per->mother;

	for ($i = 2; $i < 8; $i++) {
		if(isset($ids[$i])) {
			$p = $ids[$i];
			$dao->getParents($p);
			$ids[($i * 2)] 	   = $p->father;
			$ids[($i * 2 + 1)] = $p->mother;
		}
	}

	

?>

<!--Main body-->

<table width="100%" cellspacing="0">
  <tbody>
    <tr> <!--row 1-->
      <td width="22%">  </td>
      <td width="4%">  </td>
      <td width="22%">  </td>
      <td width="4%">  </td>
      <td width="22%">  </td>
<?php
	person_disp($ids, 8, "tr", 4);
?>
    </tr>
    <tr> <!--row 2-->
      <td>  </td>
      <td>  </td>
      <td>  </td>
<?php
	person_disp($ids, 4, "tr");
?>
      <td>  </td>
    </tr>
    <tr> <!--row 3-->
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td<?php if(isset($ids[4]->person_id)) echo " class=\"vert\""; ?>>  </td>
      <td>  </td>
<?php
	person_disp($ids, 9, "br");
?>
    </tr>
    <tr> <!--row 4-->
      <td>  </td>
<?php
	person_disp($ids, 2, "tr");
?>
      <td>  </td>
      <td>  </td>
      <td>  </td>
    </tr>
    <tr> <!--row 5-->
      <td>  </td>
      <td<?php if(isset($ids[2]->person_id)) echo " class=\"vert\""; ?>></td>
      <td>  </td>
      <td<?php if(isset($ids[5]->person_id)) echo " class=\"vert\""; ?>>  </td>
      <td>  </td>
<?php
	person_disp($ids, 10, "tr");
?>
    </tr>
    <tr> <!--row 6-->
      <td>  </td>
      <td<?php if(isset($ids[2]->person_id)) echo " class=\"vert\""; ?>></td>
      <td>  </td>
<?php
	person_disp($ids, 5, "br");
?>
      <td>  </td>
    </tr>
    <tr> <!--row 7-->
      <td>  </td>
      <td<?php if(isset($ids[2]->person_id)) echo " class=\"vert\""; ?>></td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
<?php
	person_disp($ids, 11, "br");
?>
    </tr>
    <tr> <!--row 8-->
<?php 
      person_disp($ids, 1);
?>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
    </tr>
    <tr> <!--row 9-->
      <td>  </td>
      <td<?php if(isset($ids[3]->person_id)) echo " class=\"vert\""; ?>> </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
<?php
	person_disp($ids, 12, "tr");
?>
    </tr>
    <tr> <!--row 10-->
      <td>  </td>
      <td<?php if(isset($ids[3]->person_id)) echo " class=\"vert\""; ?>></td>
      <td>  </td>
<?php
	person_disp($ids, 6, "tr");
?>
      <td>  </td>
    </tr>
    <tr> <!--row 11-->
      <td>  </td>
      <td<?php if(isset($ids[3]->person_id)) echo " class=\"vert\""; ?>></td>
      <td>  </td>
      <td<?php if(isset($ids[6]->person_id)) echo " class=\"vert\""; ?>>  </td>
      <td>  </td>
<?php
	person_disp($ids, 13, "br");
?>
    </tr>
    <tr> <!--row 12-->
      <td>  </td>
<?php
	person_disp($ids, 3, "br");
?>
      <td>  </td>
      <td>  </td>
      <td>  </td>
    </tr>
    <tr> <!--row 13-->
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td<?php if(isset($ids[7]->person_id)) echo " class=\"vert\""; ?>>  </td>
      <td>  </td>
<?php
	person_disp($ids, 14, "tr");
?>
    </tr>
    <tr> <!--row 14-->
      <td>  </td>
      <td>  </td>
      <td>  </td>
<?php
	person_disp($ids, 7, "br");
?>
      <td>  </td>
    </tr>
    <tr> <!--row 15-->
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
<?php
	person_disp($ids, 15, "br");
?>
    </tr>
  </tbody>
</table>

<!--End of main body-->
<?php
	} //End of show pedigree
	
	function person_disp($idxs, $id, $previous = "", $width = 0) {
		global $ids;
		$per = $ids[$id];
		
		if (!isset($per->person_id)) {
			echo "\t<td></td>\n";
			if ($previous != "") {
				echo "<td></td>";
			}
		} else {
			if ($previous != "") {
				echo '<td class="'.$previous.'"';
				if ($width > 0) {
					echo ' width="'.$width.'%"';
				}
				echo "></td>";
			}

			$icona="";// MODIFICA 20120506
			if ($per->gender == "M") {
				$class = "tbl_odd";
				$icona="<img border='0' src='images/smale.gif' alt='M' height='20' /> ";  // MODIFICA 20120506				
			} else {
				$class = "tbl_even";
				$icona="<img border='0' src='images/sfemale.gif' alt='F' height='20' /> ";  // MODIFICA 20120506				
			}
			
			echo "<td bgcolor=\"#FFFFFF\" width=\"22%\" class=\"".$class."\">";
			echo $icona." ";
			echo $per->getLink();
			echo "<br />";
			echo $per->getBirthDetails();
			echo "<br/>\n";
			echo $per->getDeathDetails();
			echo "<br/>\n";
			echo "</td>\n";
		}
		if ($id < 8) {
			echo "<td ";
			if (isset($per->father->person_id) && isset($per->mother->person_id)) {
				echo " class=\"outer\"";
			} elseif (isset($per->father->person_id)) {
				echo " class=\"rt\"";
			} elseif (isset($per->mother->person_id)) {
				echo " class=\"rb\"";
			}
			echo "></td>";
		}
	}
?>
