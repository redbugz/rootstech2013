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

?>

	<!-- Form proper -->
	<form method="post" action="my.php?state=sent">
		<table width="50%">
			<tr>
				<td><?php echo $strEmail; ?></td>
				<td><input type="input" name="pwdEmail" size="30" maxlength="128" /></td>
			</tr>
			<tr>
				<td width="182"></td>
				<td width="145"><input type="submit" name="Submit1" value="<?php echo $strSubmit; ?>" /></td>
			</tr>
		</table>
	</form>

<?php
	//eof
?>
