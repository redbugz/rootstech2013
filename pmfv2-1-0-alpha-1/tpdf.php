<?php

// ATTENTION: Correct path to the inc directory
include_once "modules/db/DAOFactory.php";
include_once "inc/header.inc.php";
include_once 'fpdf/fpdf.php';
if ( false === function_exists('lcfirst') ):
function lcfirst( $str )
{ return (string)(strtolower(substr($str,0,1)).substr($str,1));}
endif;

class PDF extends FPDF
{
	var $Title;

	// Page footer
	function Footer()
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Page number
		$this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}('.$this->Title.')',0,0,'C');
	}
}


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
		$ret .= "{".$marriage->relation->getDisplayName()."}";
	}
	return $ret;
}
// End spouse string ---------------------------------------------------------------------------

// Create the descendants tree
// Search the kids recursively
function make_Descendants($per,$linee=false)
{
	global $tblprefix, $strBorn, $strDied, $strLivingPerson, $strDeceasedPerson, $grid, $level;
	$level += 1;
	$grid[$level] = 1;
	$lines=0;

	$per->queryType = Q_IND;
	$dao = getPeopleDAO();
	$dao->getChildren($per);
	/*
	 // $linee[]=$per->person_id;
	 $arr = array();
	 // while ($segment = array_pop($path)) {
	 $tmp = array($per->person_id => $per->getDisplayName());
	 //}
	 $arr = $tmp;
	 print_r($arr);
	 // viewarray($arr);
	 exit;
	 */
	if(isset($per->children)) {


		foreach($per->children AS $child) {
			/*
			 $arr = array();
			 $tmp = array($per->person_id => $per->getDisplayName());
			 $arr = $tmp;
			 */
			$ln="";

			// gridline
			for( $y=1; $y<$level; $y += 1)
			{
				// gridsurpression
				if ($grid[$y] != -1) {
					$ln.="I"; // "|"; // &#9474;";
						
				}else{
					$ln.="S"; // ".";
				}
					
			}

			// Arrows:
			$totalrows = count($per->children);
			$lines += 1;

			// if not last in array T-arrow:
			If ($totalrows != $lines) {
				$ln.="T"; // "-"; //&#9500;";

			} else {
				// Final L-arrow if last in array
				$ln.="L"; // "_"; // &#9492;";
				$grid[$level] = -1;
					
			}
				
			// textposition
			//$ln.=a2p($level);
			$ln.="($level) ";
			$icona="";// MODIFICA 20120506
			if ($child->gender == "M") {
				$icona="* ";//&#923;&nbsp;";
			} else {
				$icona="o "; //&#916;&nbsp;";
			}
			$ln.=$icona.$child->getDisplayName();
			$ln.=get_spouse_string($child);

				
			$linee[]=$ln;
			/*
			 $tmp = array($child->person_id => $ln);
			 $arr[]=$tmp;
			 // viewarray($arr);
			 exit;
			 */
			// viewarray($linee);

			$linee = make_Descendants($child,$linee);
			$level -= 1;
				
		}

		return $linee; // completato

	} else {
		return $linee;
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
$base = floor ($per->dob/50) * 50;

// echo a2p(13)+900;

//$capo="&#923;&nbsp;=&nbsp;".$strGender." ".lcfirst($strMale)."&nbsp;&nbsp;&#916;&nbsp;=&nbsp;".$strGender." ".lcfirst($strFemale)."\n"; // MODIFICA 20120507
$capo="* = ".$strGender." ".lcfirst($strMale)."  o = ".$strGender." ".lcfirst($strFemale)."\n"; // MODIFICA 20120507

// position
$level=0; // first generation
// person name,
$ln="(".$level.") ";
if ($per->gender == "M") {
	$ln.="* ";//&#923; ";
} else {
	$ln.="o ";//&#916; ";
}

$ln.=$per->getDisplayName();
//add spouse
$ln.=get_spouse_string($per);
// --------------------------------------------------
//        echo "<br>\n";
//$albero=$ln;

$albero = make_Descendants($per);

// viewarray($albero);
// echo $albero[131];
// exit;

set_time_limit(0);


$pdf=new PDF();
$pdf->Open();
$pdf->Title=$strDescendants." $strOf ".$per->getDisplayName();

$pdf->aliasNbPages();
$pdf->SetAutoPageBreak('true','10');
$pdf->AddPage();
$pdf->SetFont('Arial','B',15);
// Move to the right
$pdf->Cell(80);
// Title
$pdf->Cell(30,10,$pdf->Title,0,0,'C');
// Line break
$pdf->Ln(2);

$pdf->SetY(10+$pdf->tMargin);
$pdf->SetX($pdf->lMargin);
//	$pdf->SetY($pdf->tMargin);
//	$pdf->SetX($pdf->lMargin);
$pdf->SetFont('Arial', '', 10);
$vspacing=1;
if (is_array($albero)) {
	array_unshift($albero, $capo,$ln);
	foreach($albero AS $linea) {
		// $pdf->Cell(0,6,$albero[0],0,0,'L');
		// $righe = count($albero)-1;
		//for( $y=0; $y<=$righe; $y++){
		//	$linea=$albero[$y];
		$pdf->Ln(1);
		// $str=utf8_decode($linea);
		$str = iconv('UTF-8', 'windows-1252', $linea);
		// $str=html_entity_decode($linea,"ENT_HTML5", "UTF-8");
		$prev = strpos($str,'(');
		$indent=substr($str, 0, $prev);     // [X]
		$str=substr($str, $prev);     // [X]
		$y1=$pdf->GetY();
		$x1=$pdf->GetX()+$pdf->lMargin;
		$y2=$y1+4;
		$x2=$pdf->lMargin-2;
		while ($indent !="") {
			// $y1=$y1+$vspacing;
			$x1=$pdf->GetX();
			// $y2=$y1+6;
			$x2=$x1+1;
			$ind=substr($indent, 0, 1);
			$indent=substr($indent, 1);
			switch ($ind) {
				case "I":
					$pdf->line($x1,$y1+$vspacing,$x1,$y2+$vspacing);
					$pdf->SetXY($x2,$y1+1+$vspacing);
					break;
				case "T":
					// T
					$pdf->line($x1,$y1+$vspacing,$x1,$y2+$vspacing); // "|"
					$pdf->line($x1,$y2-1+$vspacing,$x2,$y2-1+$vspacing); // "-"
					$pdf->SetXY($x2,$y2+$vspacing);
					break;
					 
				case "L":
					// L
					$pdf->line($x1,$y1+$vspacing,$x1,$y2-1+$vspacing); // |
					$pdf->line($x1,$y2-1+$vspacing,$x2,$y2-1+$vspacing); // -
					$pdf->SetXY($x2,$y2+$vspacing);
					break;
				case "S":
					// Spazio
					$pdf->SetXY($x2,$y2-1+$vspacing);
					//$pdf->Cell(0,6," ",0,0,'L');
					break;
			}
			// $pdf->Cell(0,6,$ind,0,1,'L');
		}
		// $pdf->SetXY($x2,$y2);
		// $pdf->SetXY($pdf->GetX(),$pdf->GetY());
		$pdf->SetXY($x2,$y2-1);
		$p=$pdf->GetY();
		$pdf->SetXY($x2,$y2-3);
		// $str=$str." ".$pdf->GetX()." ".$pdf->GetY();
		$pdf->Cell(0,6,$str,0,0,'L');
		if ($p>280){
			$pdf->AddPage();
			$p=$pdf->tMargin;
		}
		$pdf->SetY($p);

		// echo $linea."<br>";
	}
}
$pdf->Output();



function viewArray($arr,$codice='')
{
	$n=0;
	if (!$codice==''){
		echo $codice."<br>";
		// error_log($codice."<br>", 3, "http://localhost/_pubblicati/changamano/gazie510/modules/donazioni/errori.php");
	}
	echo '<table cellpadding="0" cellspacing="0" border="1">';
	foreach ($arr as $key1 => $elem1) {
		echo '<tr>';
		// error_log("<tr>", 3, "http://localhost/_pubblicati/changamano/gazie510/modules/donazioni/errori.php");
		$n++;
		echo '<td>'.$key1.'&nbsp;</td>';
		// error_log('<td>'.$key1.'&nbsp;</td>', 3, "http://localhost/_pubblicati/changamano/gazie510/modules/donazioni/errori.php");
		if (is_array($elem1)) { extArray($elem1); }
		else {
			echo '<td>'.$elem1.'&nbsp;</td>';
			// error_log('<td>'.$elem1.'&nbsp;</td>', 3, "http://localhost/_pubblicati/changamano/gazie510/modules/donazioni/errori.php");
		}
		echo '</tr>';
		// error_log("</tr>", 3, "http://localhost/_pubblicati/changamano/gazie510/modules/donazioni/errori.php");
	}
	echo '</table>';
	// error_log("</table>", 3, "http://localhost/_pubblicati/changamano/gazie510/modules/donazioni/errori.php");
}
function extArray($arr)
{
	echo '<td>';
	// error_log("<td>", 3, "http://localhost/_pubblicati/changamano/gazie510/modules/donazioni/errori.php");
	$n=0;
	echo '<table cellpadding="0" cellspacing="0" border="1">';
	// error_log('<table cellpadding="0" cellspacing="0" border="1">', 3, "http://localhost/_pubblicati/changamano/gazie510/modules/donazioni/errori.php");
	foreach ($arr as $key => $elem) {
		echo '<tr>';
		// error_log("<tr>", 3, "http://localhost/_pubblicati/changamano/gazie510/modules/donazioni/errori.php");
		$n++;
		echo '<td>'.$key.'&nbsp;</td>';
		// error_log('<td>'.$key.'&nbsp;</td>', 3, "http://localhost/_pubblicati/changamano/gazie510/modules/donazioni/errori.php");
		if (is_array($elem)) { extArray($elem); }
		else {
			echo '<td>'.htmlspecialchars($elem).'&nbsp;</td>';
			// error_log('<td>'.htmlspecialchars($elem).'&nbsp;</td>', 3, "http://localhost/_pubblicati/changamano/gazie510/modules/donazioni/errori.php");
		}
		echo '</tr>';
		// error_log("</tr>", 3, "http://localhost/_pubblicati/changamano/gazie510/modules/donazioni/errori.php");
	}
	echo '</table>';
	// error_log("</table>", 3, "http://localhost/_pubblicati/changamano/gazie510/modules/donazioni/errori.php");
	echo '</td>';
	// error_log("</td>", 3, "http://localhost/_pubblicati/changamano/gazie510/modules/donazioni/errori.php");
}

?>
