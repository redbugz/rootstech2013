<?php
	include_once "modules/db/DAOFactory.php";
	include_once "inc/header.inc.php";

	// fill out the headers
	do_headers($strReport);

?>
<body class="tundra">
<?php include_once("inc/analyticstracking.php"); ?>
<table class="header" width="100%">
	<tbody>
		<tr>
			<td align="center" width="65%"><h2><?php echo $strReport; ?></h2></td>
			<td width="35%" valign="top" align="right">
<?php user_opts(); ?>
			</td>
    </tr>
  </tbody>
</table>

<?php
if(isset($_REQUEST["area"])) {
	include_once("modules/".$_REQUEST["area"]."/report.php");
} else {
	echo "<h2>".$strMissing." ".$strDetails."</h2>";
	echo "<ul>\n";
	echo "<li><a href=\"report.php?area=people&type=1\">".$strMissing." ".$strDOB."</a></li>";
	echo "<li><a href=\"report.php?area=people&type=2\">".$strMissing." ".$strDOD."</a></li>";
	echo "<li><a href=\"report.php?area=people&type=3\">".$strMissing." ".$strMother."</a></li>";
	echo "<li><a href=\"report.php?area=people&type=4\">".$strMissing." ".$strFather."</a></li>";
	echo "</ul>\n";
	
	$dao = getCensusDAO();
	$countries = $dao->getCensusCountries(null);
	echo "<h2>".$strMissing." ".$strCensusRecs."</h2>";
	
	echo "<ul>\n";
	foreach ($countries AS $c) {
		echo "<li><a href=\"report.php?area=census&filter=$c\">".$c."</a></li>";
	}
	echo "</ul>\n";
}
	include "inc/footer.inc.php";
?>
