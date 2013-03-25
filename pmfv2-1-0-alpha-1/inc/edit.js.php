<?php
set_include_path('..');
include_once "modules/db/DAOFactory.php";
?>
var dateModifierExamples = new Array();
<?php
$i = 0;
foreach ($strDateExplain as $text) {
	echo 'dateModifierExamples['.$i.'] ="'.$text.'";';
	$i++;
}
?>

//This funcion changes the example search text displayed below the text 
//box. 
//id is the html element corresponding to the example that needs changing
//fieldValue is the field selection based on which the example text should change
function changeExample( id, fieldValue, searchExamples ) {

	var newExample = null;
	//get the example corresponding to the field name passed in
	newExample = searchExamples[fieldValue];
	
	//if there is no example for this field selection
	if( newExample == null ) 
	 return;

	// change the display example
	document.getElementById(id).innerHTML = newExample;
	
}

<?php
$config = Config::getInstance();

if ($config->dojo) {
?>
      dojo.require("dijit.form.ComboBox");
      dojo.require("dijit.form.FilteringSelect");
      dojo.require("dojox.data.QueryReadStore");

  dojo.addOnLoad(function() {
      dojo.provide("LocationStore");
      dojo.declare("LocationStore", dojox.data.QueryReadStore, {
			fetch:function(request) {
				request.serverQuery = {q:request.query.name, start:request.start, count:request.count};
				return this.inherited("fetch", arguments);
			}
      });
  });
<?php
}
?>
