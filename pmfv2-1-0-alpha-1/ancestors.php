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
    // Copyright (C) 2005 Kees Dommisse (dommisse@gmx.net)
    // inspired by tree.php by Paolo Biagini - Some functions/parts were used and/or adapted.
    // Some functions/parts of people.php are used and/or adapted.
    // History:
    // Created on 5 aug 2005 by Kees Dommisse.
    // 6 aug 2005 finished, debugged.
    // 30/31 aug 2005 rewritten the whole module in order to produce a tree-form.
    
  
    // You must upgrade each file in lang folder < DO THIS FIRST! <--------------------
	//  $strDescendants     = "Decendants";     // EN-UK
    //  $strDescendants     = "Afstammelingen"; // NL
	//  $strDescendants     = "Afstammelingen"; // NL-BE
	//  $strDescendants     = "Decendants";     // FR
	//  $strDescendants     = "Abkömlingen";    // DE

	//  $strLivingPerson    = "Living person";     // EN-UK
    //  $strLivingPerson    = "Levend persoon";    // NL
	//  $strLivingPerson    = "Levend persoon";    // NL-BE
	//  $strLivingPerson    = "Personne vivante";  // FR
	//  $strLivingPerson    = "Lebende Person";    // DE
  
    //  $strAncestors   =   "Ancesters";   // EN-UK
    //  $strAncestors   =   "Ancêstres";   // FR
    //  $strAncestors   =   "Vorfahren";   // DE
    //  $strAncestors   =   "Voorouders";  // NL-BE
    //  $strAncestors   =   "Voorouders";  // NL

    //  $strDeceasedPerson  = "Deceased Person";    // EN-UK
    //  $strDeceasedPerson  = "Overleden Persoon";  // NL
    //  $strDeceasedPerson  = "Overleden Persoon";  // NL-BE
    //  $strDeceasedPerson  = "Gestorbebe Person";  // DE
    //  $strDeceasedPerson  = "Personne décédé";    // FR


  // ATTENTION: Correct path to the inc directory
  include_once "modules/db/DAOFactory.php";
  include_once "inc/header.inc.php";


    // --------------------------------------------------------------------
    // to make the grid and to place persons on the right place in the timeline:
 
     // set margin
     $base=0;
     // set the grid scale
     $gridsize = "40";   
 
  function a2p($a)
  {
     global $base, $gridsize;
     $r = $a + $base;
     if( $r < 0 ) return 20; 
     return $r*$gridsize+20;
  }
    // --------------------------------------------------------------------

    // ---------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Get the details of the first person
	// check we have a person
	$peep = new PersonDetail();
	$peep->setFromRequest();
	$peep->queryType = Q_IND;
	$dao = getPeopleDAO();
	$dao->getPersonDetails($peep);
	if ($peep->numResults != 1) {
		die("Could not find person");
	}
	$per = $peep->results[0];

	// the query for the database
	
// Security ------------------
		// set security for living people (born after 01/01/1910)
		if(!$per->isViewable()) {
// ATTENTION: Correct path to the inc directory
//		   die(include $our_path."inc/forbidden.inc.php");
  	     die(include "inc/forbidden.inc.php");
		}

// ------------------------------------------
		// Fill out the HTML-headers
		$headername = $strAncestors." - ".$per->getDisplayName();
		do_headers($headername);
		// pickout father and mother for use in queries
		// set to -1 to avoid too many siblings!!! :-)
		$father = $per->father->person_id;
		if ($father == 0) $father = -1;
		$mother = $per->mother->person_id;
		if ($mother == 0) $mother = -1;
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
	echo " | <a href=\"people.php?person=".$per->person_id."\">".strtolower($strBack)." ".$strToDetails."</a>\n";
// Menu ends here
    ?>
    </td>
    </tr>
  </tbody>
</table>

<!-- create workspace -->

<table  style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td style="vertical-align: top;">
      <font size="-1"><div style="position: absolute; left: 200px">
      This module is EXPERIMENTAL Please report bugs and/or requests in the FORUM</div>
      <br>
      <br>
      <br>
      <?php
	
    // end page head --------------------------------------------------
      
        $grid = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        $countlines = 0;
        $level = -1;

// get parent -----------------------------------

 function get_parent($parent) {
     global $datefmt, $tblprefix, $strBorn, $strDied, $restrictdate, $level, $err_father, $err_mother, $grid, $strLivingPerson, $countlines, $outputstring, $htmlstring, $gridsize;


    $peep = new PersonDetail();
	$peep->person_id = $parent;
	$peep->queryType = Q_IND;
	$dao = getPeopleDAO();
	$dao->getPersonDetails($peep);
// check if there is a parent
	if ($peep->numResults != 1) {
		return;
	} else {
	        $per = $peep->results[0];
        }

    $level +=1;
// ---- position father
            $fhtmlstring = "<div style=\"position: absolute; left: ".a2p($level)."px;\">";
            $fhtmlstring .= "(".$level.") ";
		
    	      $nextfather = $per->father->person_id;
	      $nextmother = $per->mother->person_id;
	      if ($nextfather != 0) { 
	          get_parent ($nextfather);
	      }
	      $fhtmlstring .= $per->getFullLink();
	     
	      $fhtmlstring.= "</div> \n";
// ---- grid lines
            if ($level > 0) {
           for( $y=1; $y<=($level-1); $y += 1)
           {             
            if ($grid[$y] != 0) {
             $fhtmlstring.= "<img alt=\"\" src=\"images/point.gif\" height=\"16\" width=\"1\" style=\"position: absolute; left: ".(a2p($y-1)+7)."px;\" border=\"0\">\n";
           } }
           $fhtmlstring.= "<img alt=\"\" src=\"images/point-";
           if ($per->gender == "M") {
           $fhtmlstring.= "m";
           $grid[($level)] = 1;
           }
           else  {
           $fhtmlstring.= "f";
           $grid[$level] = 0;
           }
           $fhtmlstring.= ".gif\" height=\"16\" width=\"".($gridsize - 9)."\" style=\"position: absolute; left: ".(a2p($y-1)+7)."px;\" border=\"0\">\n";
           }
// ---- end grid lines

	          $fhtmlstring.= "<br> \n";
	          $outputstring[]= $fhtmlstring;
              $countlines += 1;
	          if ($nextmother != 0) {
              $grid[$level + 1] = 1;
	          get_parent ($nextmother) ;
              } else {
              $grid[$level + 1] = 0;              
              }

        $level -=1;
        
        // end get parents
        }


// --- End function get parents

    get_parent ($per->person_id);
    $i = 0;
    while ($i < $countlines){
    echo $outputstring[$i];
    $i += 1;
    }
?>
<br><br>
     </td>
    </tr>
  </tbody>
</table>
<br><br>
<?php
 
// ATTENTION: Correct path to the inc directory
//  include $our_path."inc/footer.inc.php";
  include "inc/footer.inc.php";
?>
