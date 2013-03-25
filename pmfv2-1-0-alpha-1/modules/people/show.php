<?php
function displayPersonOption($param, $per) {

	echo "<option value=\"".$per->person_id."\"";
		if ($per->person_id == $param->person_id)
			echo " selected=\"selected\"";
	if ($per->father_id == "00000" && $per->gender == "M") // MODIFICA 20120508
	        echo "style='background-color:#FF0000;'";
		echo ">".$per->getSelectName()."</option>\n";
}

// function: listpeeps
// list all people in database that current request has access to
function selectPeople($form, $omit = 0, $gender = "A", $default = 0, $auto = 1, $date = 0, $type = 0) {
	global $strOnFile, $strSelect, $strInvalidPerson;
/**
<!-- assumes
    <style type="text/css">
        @import "http://o.aolcdn.com/dojo/1.0.2/dijit/themes/tundra/tundra.css";
        @import "http://o.aolcdn.com/dojo/1.0.2/dojo/dojo.css"
    </style>
    <script type="text/javascript" src="http://o.aolcdn.com/dojo/1.0.2/dojo/dojo.xd.js"
            djConfig="parseOnLoad: true"></script>
    <body class="tundra">
-->*/

	$search = new PersonDetail();
	$search->queryType = Q_COUNT;
	$search->person_id = $omit;
	$search->gender = $gender;
	if ($date <> 0) { $search->date_of_birth = $date; }
	
	$dao = getPeopleDAO();
	
	$callback = '';
	
	$config = Config::getInstance();
	$dojo = false;
	
	if ($config->dojo) {
		$dojo = true;
	}
		
	if (!$dojo) {
		$callback = "displayPersonOption";
		echo "<select name=\"".$form."\" size=\"1\"";
		//if needed, set form to auto submit
		if ($auto == 1) {
			echo " onchange=\"this.form.submit()\"";
		}
		echo ">\n";
		
		if ($default <= 0) {
			echo "<option value=\"0\">".$strSelect."</option>\n";
		}
	
		$search->queryType = Q_TYPE;
		$search->person_id = $default;
		$dao->getPersonDetails($search, $callback);
	
		echo "</select>\n";
	} else {
		$search->queryType = Q_COUNT;
		$dao->getPersonDetails($search);
	

		$store = $form."_peopleStore";
?>
    <script type="text/javascript">

require([
    "dojo/ready", "dojo/store/JsonRest", "dijit/form/FilteringSelect", "dojo/on"
], function(ready, JsonRest, FilteringSelect, on){
	if (!peopleStore) {
		var peopleStore = new Array();
	}
   	peopleStore["<?php echo $form;?>"] = new JsonRest({ target:"services/peopleService/person/", idProperty: "personid"});
    ready(function(){
        var filteringSelect = new FilteringSelect({
            id: "<?php echo $form;?>",
            name: "<?php echo $form;?>",
	    style: "width: 400px;",
	    query: { gender:'<?php echo $gender;?>', 
			date:'<?php echo $date;?>', 
			omit:'<?php echo $omit;?>'
		   },
	<?php if ($default > 0) { echo " value:\"".$default."\","; } ?>
            store: peopleStore["<?php echo $form;?>"],
            searchAttr: "name",
	    autoComplete: false
        }, <?php echo $form;?>);
/* Unfortunately onchange uses the new value instead of the event */
	<?php if ($auto == 1) { ?>
	on(filteringSelect, "change", function(val) {
		if (val != "") {
			require(["dojo/dom"], function (dom) {
			dom.byId("<?php echo $form;?>").form.submit();
			});
		}
	});
	<?php } ?>
    });
});
</script>

<input id="<?php echo $form;?>" style="width: 400px;">

<?php
	}
	echo "<br/>";
	// show the number of people in the list
	if ($gender == "A" && $omit == 0) {
		echo $search->numResults." ".$strOnFile;
	}
	if ($gender == "A" && $omit <> 0) {
		echo ($search->numResults + 1)." ".$strOnFile;
	}
}	// end of selectPeople()
?>
