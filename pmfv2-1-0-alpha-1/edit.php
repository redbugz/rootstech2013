<?php
include_once "modules/db/DAOFactory.php";
include_once "inc/header.inc.php";
include_once "modules/people/show.php";

if ($_SESSION["id"] == 0 || $_SESSION["editable"] == "N") {
	die(include "inc/forbidden.inc.php");
}

$area = $_REQUEST["area"];

if ($area == "marriage") { $area = "relations"; }

include_once "modules/".$area."/editForm.php";

$data = setup_edit();
$config = Config::getInstance();

$extra = '<script type="text/javascript" src="inc/edit.js.php"></script>';
if ($config->dojo) {
$extra .= '<script type="text/javascript">
		dojo.require("dijit.Editor");
		dojo.require("dijit._editor.plugins.TextColor");
		dojo.require("dijit._editor.plugins.LinkDialog");
		dojo.require("dojo.parser");	// scan page for widgets and instantiate them

		function setEditorValue(id, args){
			if (args[0] != \'\') {
				dojo.byId(id).value=args[0];
			} 
		}
</script>';
}

do_headers_dojo(get_edit_title($data), $extra);

	
	if ($config->dojo) {		
?>
<body class="tundra">
<?php include_once("inc/analyticstracking.php"); ?>
<div dojoType="dojox.data.QueryReadStore" jsId="LocationStore"
			url="services/LocationQueryReadStore.php" requestMethod="post"></div>
<div dojoType="dojox.data.QueryReadStore" jsId="SourceStore"
			url="services/SourceQueryReadStore.php" requestMethod="post"></div>
	<?php }?>
<table class="header" width="100%">
  <tbody>
    <tr>
      <td><h2><?php echo get_edit_header($data); ?></h2>  </td>
    </tr>
  </tbody>
</table>

<hr />
<?php
	get_edit_form($data);
?>
<?php
include "inc/footer.inc.php";
?>
