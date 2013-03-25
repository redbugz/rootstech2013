<?php

	// function: list_enums
	// Produce a select list of an enum column
	function list_enums($table, $col, $name, $value = 0) {
		global $err_list_enums;

		// get an array of the values in the column
		$query = "SHOW COLUMNS FROM ".$table." LIKE '".$col."'";
		$result = mysql_query($query) or die($err_list_enums);

		// do some processing ?
		while ($row = mysql_fetch_array($result)) {
			$enum        = str_replace('enum(', '', $row['Type']);
			$enum        = ereg_replace('\\)$', '', $enum);
			$enum        = explode('\',\'', substr($enum, 1, -1));
			$enum_cnt    = count($enum);
			$default	 = $row["Default"];
		}

		// decide if we want column default, or a value passed as arg
		if (func_num_args() == 4)
			$select = $value;			// we've been given a value to select
		else
			$select = $default;			// just select the column default value

		// do the output
		echo "<select name=".$name." size=1>";
		for ($j = 0; $j < $enum_cnt; $j++) {
			$enum_atom = str_replace('\'\'', '\'', str_replace('\\\\', '\\', $enum[$j]));
			echo '<option value="' . urlencode($enum_atom) . '"';
			if ($enum_atom == $select)
					echo ' selected="selected"';
			echo '>' . htmlspecialchars($enum_atom) . '</option>' . "\n";
		}
		echo "</select>";

		// clean up
		mysql_free_result($result);
	}	// end of list_enums()


?>
