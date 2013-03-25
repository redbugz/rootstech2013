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

	$trans = new Transcript();
	$trans->setFromRequest();
	$dao = getTranscriptDAO();
	$dao->getTranscripts($trans);
	
	foreach ($trans->results AS $doc) {
		if(!$doc->person->isViewable()) {
			continue;
		}
		// see if we have mime capabilities
		if (function_exists("mime_content_type"))
			$type = mime_content_type($doc->getFileName());
		else
			$type = "application/unknown";

		// fire off a few headers
		header("Content-Location: ".$doc->getFileName());
		header("Content-Type: ".$type);
		header("Content-Length: ".filesize($doc->getFileName()));
		header("Content-Disposition: attachment; filename=\"".$doc->file_name."\"");
		readfile($doc->getFileName());

	}
	// eof
?>
