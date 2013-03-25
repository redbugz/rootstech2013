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

	// include the configuration parameters and function
	include_once "modules/db/DAOFactory.php";
	include_once "inc/header.inc.php";
	include_once "modules/people/show.php";
	include_once "modules/event/show.php";
	include_once "modules/location/show.php";
		
	// check we have a person
	if(!isset($_REQUEST["person"])) $person = 1;
	@$person = $_REQUEST["person"];

	$peep = new PersonDetail();
	$peep->setFromRequest();
	$peep->queryType = Q_IND;
	$dao = getPeopleDAO();
	$dao->getPersonDetails($peep);
	if ($peep->numResults != 1) {
		//die("error");
	}
	$per = $peep->results[0];
	
	$dao->getParents($per);
	$dao->getChildren($per);
	$dao->getSiblings($per);
	
	// if trying to access a restriced person
	if (!$per->isViewable()) {
		die(include "inc/forbidden.inc.php");
	}
		
	$config = Config::getInstance();
	do_headers_dojo($per->getDisplayName());
?>
<body class="tundra">
<?php include_once("inc/analyticstracking.php"); ?>
<script language="JavaScript" type="text/javascript">
 <!--
 function confirm_delete(year, section, url) {
 	input_box = confirm(<?php echo $strConfirmDelete; ?>);
 	if (input_box == true) {
 		window.location = url;
 	}
 }
 if (parent.addPerson) {
	<?php
	if ($per->date_of_birth != "0000-00-00") {
		$dob = "(".$strBorn." ".$per->dob.")";
	} else {
		$dob = '';
	} ?>
	parent.addPerson(<?php echo $per->person_id;?>, '<?php echo $per->getDisplayName();?>', '<?php echo $dob;?>');
 }

 <?php
 $sectionType = "";
 $containerType = "";
	switch ($config->layout) {
case 2:
$containerType = " dojotype=\"dijit.layout.TabContainer\" style=\"height:600px\"";
$sectionType = " dojotype=\"dijit.layout.ContentPane\"";
?>
        dojo.require("dijit.layout.ContentPane");
        dojo.require("dijit.layout.TabContainer");
<?php
break;
case 3:
$containerType = "";
$sectionType = " dojotype=\"dijit.TitlePane\"";
?>

 dojo.require("dijit.TitlePane");

<?php
break;
}
?>
 -->
</script>

<!--titles-->
<?php user_opts($per->person_id); ?>
				<form method="get" action="people.php">
				<?php selectPeople("person", 0, "A", $per->person_id); ?>
				</form>


<hr />
<div id="options">
<ul>
<?php
				if ($per->isEditable()) {
?>
<li><a href="edit.php?func=edit&amp;area=people&amp;person=<?php echo $per->person_id; ?>"><?php echo $strEdit; ?></a></li>
<?php
				}
				if ($per->isDeletable()) {
?>
<li><a href="JavaScript:confirm_delete('<?php echo $per->getDisplayName(); ?>', '<?php echo strtolower($strPerson); ?>', 'passthru.php?func=delete&amp;area=people&amp;person=<?php echo $per->person_id; ?>')" class="delete"><?php echo $strDelete; ?></a></li>
<?php
				}
					?>
<li><a href="descendants.php?person=<?php echo $per->person_id;?>" class="hd_link"><?php echo $strDescendants;?></a></li>
<li><a href="pedigree.php?person=<?php echo $per->person_id; ?>"><?php echo $strPedigree; ?></a></li>
<li><a href="ancestors.php?person=<?php echo $per->person_id;?>" class="hd_link"><?php echo $strAncestors;?></a></li>
<?php
				if ($config->gedcom == true && $per->isExportable()) {
						echo "<li><a href=\"gedcom.php?person=".$per->person_id."\">".$strGedCom."</a></li>";
				}
				?>
</ul>
</div>
<div id="name">
<h2><?php 
echo $per->getDisplayGender(); // MODIFICA 20120506 
echo $per->getDisplayName(); 
?></h2>
			
</div>

<!--BDM-->
<?php
	$edao = getEventDAO();
	$e = new Event();
	$e->person->person_id = $per->person_id;
	$edao->getEvents($e, Q_BD, true);
	$per->events = $e->results;
	?>
	<div id="bd">
	<?php
		$sdao = getSourceDAO();
		$classes = array("birth","baptism","death","burial");
		foreach ($per->events AS $e) {
			if ($e->hasData()) {
				$events[$e->type] = $e;
				$sdao->getEventSources($e);
				echo $e->getFullDisplay($classes[$e->type]);				
			}
		}
			?>
	</div>
	<div id="parents">
	<?php 
	if ($per->gender == "M") {
		echo $strSon;
	} else {
		echo $strDaughter;
	}
	echo ' '.$strOf.' ';

		// the query for father
		if ($per->father->hasRecord()) {
			echo $per->father->getFullLink();
		} else {
			if ($per->isCreatable()) {?>
<a href="edit.php?func=add&area=people&gender=M&cid=<?php echo $per->person_id;?>"><?php echo $strInsert." ".$strFather;?></a>
			<?php } else { echo $strUnknown;}
		}
		echo " ".$strAnd." ";
		// the query for mother
		if ($per->mother->hasRecord()) {
			echo $per->mother->getFullLink();
		} else {
			if ($per->isCreatable()) {?>
<a href="edit.php?func=add&area=people&gender=F&cid=<?php echo $per->person_id;?>"><?php echo $strInsert." ".$strMother;?></a>
<?php } else { echo $strUnknown; }
		}
?>
	</div>
	<?php if (count($per->children) > 0) { ?>
<?php
	$i = 0;
	$lastchild = $per;
foreach ($per->children AS $child) {
	$dao->getParents($child);
	if (!($lastchild->mother == $child->mother && $lastchild->father == $child->father)) {
		if ($i > 0) { echo "</div>"; }
		echo '<div class="children"><div class="label">'.$strChildren." ".$strWith." </div>";
		if ($per->gender == "M") {
			echo $child->mother->getFullLink();
		} else {
			echo $child->father->getFullLink();
		}
	}
                $icona="";
		if ($child->gender == "M") {
			$icona="<img border='0' src='images/smale.gif' alt='M' height='20' /> ";  // MODIFICA 20120506
		} else {
			$icona="<img border='0' src='images/sfemale.gif' alt='F' height='20' /> ";  // MODIFICA 20120506
		}

	echo '<div class="child">'.$icona.$child->getFullLink().'</div>';
	$lastchild = $child;
	$i++;
}
?>
	</div>
	<?php }
	if (count($per->siblings) > 0) { ?>
	<div id="siblings">
		<?php echo '<div class="label">'.$strSiblings; ?>:</div>
<?php
foreach ($per->siblings AS $sibling) {
	$icona="";// MODIFICA 20120506
	if ($sibling->gender == "M") {
		$icona="<img border='0' src='images/smale.gif' alt='M' height='20' /> ";  // MODIFICA 20120506
	} else {
		$icona="<img border='0' src='images/sfemale.gif' alt='F' height='20' /> ";  // MODIFICA 20120506
	}
			
	echo '<div class="sibling">'.$icona.$sibling->getFullLink().'</div>';
}
?>
	</div>
<?php }?>
	<div <?php echo $containerType;?>>
<?php 
 $config = Config::getInstance();
 $modules = $config->getActiveModules();
 foreach ($modules as $mod) {
	 include_once "modules/".$mod."/show.php";
	 
	 ob_start();
	 if ($config->layout < 2) {
		 echo "<hr />";
		 call_user_func("show_".$mod."_title", $per);
	 } else {
		 if ($per->isEditable()) {
			 echo "<div class=\"insert\">".call_user_func("get_".$mod."_create_string", $per)."</div>\n";
		 }
	 }
	 $numrecs = call_user_func("show_".$mod, $per);
	 
	 $contents = ob_get_contents();
	 ob_end_clean();
	 if ($numrecs > 0 || $per->isEditable()) {
		 echo "<div id=\"".$mod."\" ".$sectionType." title=\"".call_user_func("get_".$mod."_title").'"';
		 if ($numrecs == 0) { echo ' open="false" ';}
		 echo ">\n";
		 echo $contents;
		 echo "</div>\n";
	 }
 }

?>
</div>
<br /><br />
<?php
	include "inc/footer.inc.php";

	// eof
?>
