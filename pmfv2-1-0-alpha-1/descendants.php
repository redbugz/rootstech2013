<?php
	//phpmyfamily - opensource genealogy webbuilder
	//Copyright (C) 2002 - 2005  Simon E Booth (simon.booth@giric.com)

	//This program is free software; you can redistribute it and/or
	//modify it under the terms of the GNU General Public License
	//as published by the Free Software Foundation; either version 2
	//of the License, or (at your option) any later version.

	//This program is distributed in the hope that it will be useful,
	//but WITHOUT ANY WARRANTY; without even the implied warranty of
	//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	//GNU General Public License for more details.

	//You should have received a copy of the GNU General Public License
	//along with this program; if not, write to the Free Software
	//Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

    // Author of this module: Kees Dommisse
    // Copyright (C) 2002 - 2005 Kees Dommisse (dommisse@gmx.net)
    // inspired by tree.php by Paolo Biagini - Some functions were used and/or adapted
    // Some functions of people.php are used and/or adapted
    // History:
    // Created on 30 July 2005 by Kees Dommisse
    // 31 july 2005 fixed: asking for person 0 is forbidden
    // 31 july 2005 fixed: removed link on dead persons born after the restrictdate
    // 2 aug 2005 simplified the timelines and compressed the timegrid to get printable results
    // 2 aug 2005 fixed bug $base set global in children query.
  
    // You must upgrade each file in lang folder < DO THIS FIRST! <--------------------
	//  $strDescendants     = "Decendants";     // EN-UK
    //  $strDescendants     = "Afstammelingen"; // NL
	//  $strDescendants     = "Afstammelingen"; // NL-BE
	//  $strDescendants     = "Decendants";     // FR
	//  $strDescendants     = "Abk&#246;mlingen";    // DE

	//  $strLivingPerson    = "Living person";    // EN-UK
    //  $strLivingPerson    = "Levend persoon";   // NL
	//  $strLivingPerson    = "Levend persoon";   // NL-BE
	//  $strLivingPerson    = "Personne vivante"; // FR
	//  $strLivingPerson    = "Lebende Person";    // DE

$strDeceasedPerson  = "Overleden Persoon";

  
  // ATTENTION: Correct path to the inc directory
  include_once "modules/db/DAOFactory.php";
  include_once "inc/header.inc.php";
if ( false === function_exists('lcfirst') ):
    function lcfirst( $str )
    { return (string)(strtolower(substr($str,0,1)).substr($str,1));}
endif; 

    // --------------------------------------------------------------------
    // to make the grid and to place persons on the right place in the timeline:
  function a2p($a)
  {
     global $level;
     $grid = 30;   // scale
     $r = $a;
     if( $r < 0 ) return 8; // 8 is a margin
     return $r*$grid+8;
  }

    // --------------------------------------------------------------------
    // create the string for the spouse
  function get_spouse_string($per)
  {
  	global $tblprefix, $datefmt, $strBorn, $strDied, $restrictdate, $strLivingPerson, $strDeceasedPerson;

  	$rel = new Relationship();
	$rel->person = $per;
	$dao = getRelationsDAO();
	$dao->getRelationshipDetails($rel);
	$ret = "";
	foreach($rel->results AS $marriage) {
		if (!isset($marriage->relation->person_id)) {
				continue;
		}
		$ret .= " X";
		if ($marriage->isViewable()){
			$ret .= $marriage->dom;
		}
		$ret .= "X ";
		$ret .= "{".$marriage->relation->getFullLink()."}";
            }
    return $ret;
  }
    // End spouse string ---------------------------------------------------------------------------

    // Create the descendants tree
    // Search the kids recursively
    function make_Descendants($per)
    {
    global $tblprefix, $strBorn, $strDied, $strLivingPerson, $strDeceasedPerson, $grid, $level;
        $level += 1;
        $grid[$level] = 1;
        $lines=0;
	
	$per->queryType = Q_IND;
	$dao = getPeopleDAO();
	$dao->getChildren($per);
	
	foreach($per->children AS $child) {
            echo "<br>\n";

// textposition
	        echo "<div style=\"position: absolute; left: ".a2p($level)."px;\">";
                echo "($level) ";
		$icona="";// MODIFICA 20120506
		if ($child->gender == "M") {
			$icona="&#923;&nbsp;";
		} else {
			$icona="&#916;&nbsp;";
		}
                
		echo $icona.$child->getFullLink();
		echo get_spouse_string($child)."</div>\n";
                  
// gridline
           for( $y=1; $y<$level; $y += 1)
           {
// gridsurpression
             if ($grid[$y] != -1) {
             echo "<img alt=\"\" src=\"images/point.gif\" height=\"16\" width=\"1\" style=\"position: absolute; left: " . (a2p($y)-25) ."px;\" border=\"0\">\n";
             } }
// Arrows:
        $totalrows = count($per->children);
        $lines += 1;
// if not last in array T-arrow:
            If ($totalrows != $lines) {
             echo "<img alt=\"\" src=\"images/point-d.gif\" height=\"16\" width=\"21\" style=\"position: absolute; left: " . (a2p($level)-25) ."px;\" border=\"0\">\n";
          } else {
// Final L-arrow if last in array
          echo "<img alt=\"\" src=\"images/point-l.gif\" height=\"16\" width=\"21\" style=\"position: absolute; left: " . (a2p($level)-25) ."px;\" border=\"0\">\n";
        $grid[$level] = -1;
         }
		
        make_Descendants($child) ;
        $level -= 1;
	    }	
        }
// END function make_Descendants ---------------------------------------------------------


    // Get the details of the first person
	// check we have a person
	if(!isset($_REQUEST["person"])) die(include "inc/forbidden.inc.php");
	@$person = $_REQUEST["person"];
$peep = new PersonDetail();
	$peep->setFromRequest();
	$peep->queryType = Q_IND;
	$dao = getPeopleDAO();
	$dao->getPersonDetails($peep);
	if ($peep->numResults != 1) {
		 die(include "inc/forbidden.inc.php");
	}
	$per = $peep->results[0];
	
	
// Security ------------------
		// set security for living people (born after 01/01/1910)
           if (!$per->isViewable())
// ATTENTION: Correct path to the inc directory
//		   die(include $our_path."inc/forbidden.inc.php");
  	     die(include "inc/forbidden.inc.php");

// ------------------------------------------
		// Fill out the HTML-headers
		$headername = $strDescendants." - ".$per->getDisplayName();
		do_headers($headername);
        $base = floor ($per->dob/50) * 50
?>

<!-- Create the page header -->

<table class="header" width="100%">
 <tbody>
  <tr>
    <td align="center" width="65%"><h2>
	<?php echo $headername; ?>
	</h2></td>
    <td width="35%" valign="top" align="right">
    <?php user_opts(); 
// -- Menu: trees
    Echo "\n";
	echo " | <a href=\"ancestors.php?person=";
     if (isset($per->person_id)) {
    echo $per->person_id;
	} else {
	echo "00000";
	}
    echo "\" class=\"hd_link\">".$strAncestors."</a>";
    echo " | <a href=\"pedigree.php?person=".$per->person_id."\">".$strPedigree."</a>";
	echo " | <a href=\"descendants.php?person=";
     if (isset($per->person_id)) {
    echo $per->person_id;
	} else {
	echo "00000";
	}
	echo "\" class=\"hd_link\">".$strDescendants."</a>";

echo " | <a href=\"tpdf.php?person=";
if (isset($per->person_id)) {
	echo $per->person_id;
} else {
	echo "00000";
}
echo "\" class=\"hd_link\">".$strPDF."</a>";

	echo " | <a href=\"people.php?person=".$per->person_id."\">".strtolower($strBack)." ".$strToDetails."</a>\n";
// Menu ends here
    ?>
    </td>
    </tr>
  </tbody>
</table>

<!-- create workspace -->

<table  style="width: <?php echo a2p(13)+900; ?>px;" border="0" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td style="vertical-align: top;">
      <font size="-1">
      <?php
echo "<div style=\"position: absolute; left: " . a2p(4) ."px ;\">".$strMsgDescendants."</div><br><br>\n"; // MODIFICA 20120507 
echo "<div style=\"position: absolute; left: " . a2p(4) ."px ;\">"."&#923;&nbsp;=&nbsp;".$strGender." ".lcfirst($strMale)."&nbsp;&nbsp;&#916;&nbsp;=&nbsp;".$strGender." ".lcfirst($strFemale)."</div><br><br>\n"; // MODIFICA 20120507


        // position
                $level=0; // first generation         
					echo "<div style=\"position: absolute; left: ".a2p($level)."px;\">";
        // person name, 
                    echo "($level)&nbsp;";
$icona="";// MODIFICA 20120506

if ($per->gender == "M") {
	$icona="&#923;&nbsp;";
	// $icona="<img border='0' src='images/smale.gif' alt='M' height='20' /> ";  // MODIFICA 20120506				
} else {
	$icona="&#916;&nbsp;";
	// $icona="<img border='0' src='images/sfemale.gif' alt='F' height='20' /> ";  // MODIFICA 20120506				
}
echo $icona.$per->getFullLink();
	    //add spouse
					echo "\n".get_spouse_string($per)."</div>\n";

    // --------------------------------------------------
//        echo "<br>\n";
        make_Descendants($per);
      ?>
      <br>
     </td>
    </tr>
  </tbody>
</table>
<br><br>
<?php
 
// ATTENTION: Correct path to the inc directory
  include "inc/footer.inc.php";
//  include $our_path."inc/footer.inc.php";

?>

