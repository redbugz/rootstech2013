<?php

function get_source_title() {
	global $strSource;
	return $strSource;
}

function show_source_title() {
	?>
	<table width="100%">
		<tr>
			<td width="95%"><h4><?php echo get_source_title(); ?></h4></td>
			<td width="5%"></td>
		</tr>
	</table>
	<?php
}

function selectSource($field, $source, $event) {
	global $strEdit;
	$config = Config::getInstance();
	if ($config->dojo) {
	?>
	
<input searchAttr="name" id="<?php echo $field;?>title"
	value="<?php echo $source->title;?>"
	dojoType="dijit.form.ComboBox" 
	store="SourceStore"
	name="<?php echo $field;?>title" autoComplete="false"
	pageSize="10" 
	size="30"
	maxlength="80"
	onChange="dojo.byId('<?php echo $field;?>source_id').value='';"></input>
<input type="hidden" name="<?php echo $field."source_id";?>" id="<?php echo $field."source_id";?>" value="<?php echo $source->source_id;?>" ></input>
<input type="button" onclick="window.open('edit.php?func=edit&area=source&event=<?php echo $event->event_id;?>&source='+dojo.byId('<?php echo $field;?>source_id').value,'','');" value="<?php echo $strEdit;?>"></input>
<?php
	} else {
		echo '<input name="'.$field.'title" value="'.$source->title.'"></input>';
	}
}

function certaintySelect($name, $value) {
	global $strCertainty;
	?><select name="<?php echo $name;?>" >
	<?php
	$i = 0;
	foreach ($strCertainty as $dd) {
		echo '<option value="'.$i.'"';
		if ($value == $i) { echo ' selected="selected"';}
		echo ">".$dd."</option>";
		$i++;
	}
	?>
	</select>
	<?php
}
?>