<?php

include_once "classes/Image.php";

class ImageDAO extends MyFamilyDAO {
	
	function updateImage($img) {
		global $tblprefix, $err_image_insert;
		$this->startTrans();
		$iquery = "UPDATE ".$tblprefix."images SET title=".quote_smart($img->title).
			", source_id=".$img->source->source_id;
		$iquery .= " WHERE image_id = ".quote_smart($img->image_id);
		$iresult = $this->runQuery($iquery, $err_image_insert);
		
		$rowsChanged = $this->rowsChanged($iresult);
		
		$dao = getEventDAO();

		$rowsChanged += $dao->saveEvent($img->event);
		$this->commitTrans();
		return ($iresult);
	}
	
	function createImage(&$img) {
		global $tblprefix, $err_image_insert;
		$dao = getEventDAO();

		$this->startTrans();
		$rowsChanged = $dao->saveEvent($img->event);

		$sid = $img->source->source_id;
		if ($sid < 0) {
			$sid = 'null';
		}
		$iquery = "INSERT INTO ".$tblprefix."images (event_id, title, source_id) VALUES ".
			"('".$img->event->event_id."', ".quote_smart($img->title).",".$sid.")";;
		$iresult = $this->runQuery($iquery, $err_image_insert);
		$img->image_id = str_pad($this->getInsertId(), 5, 0, STR_PAD_LEFT);
		$this->commitTrans();
		
		return ($rowsChanged + 1);
	}
	
	function deleteImage($img) {
		global $tblprefix, $err_image_delete, $err_image_file;
		$dresult = false;
		
		$this->startTrans();
		$imgFile = $img->getImageFile();		
		$tnFile = $img->getThumbnailFile();

		if ((@unlink($tnFile) && @unlink($imgFile)) || 
			!file_exists($tnFile) || 
			!file_exists($imgFile)) {
			$dquery = "DELETE FROM ".$tblprefix."images WHERE image_id = ".quote_smart($img->image_id);
			$dresult = $this->runQuery($dquery, $err_image_delete);
		} else {
			die ($err_image_file);
		}
		$this->commitTrans();
		return ($dresult);
	}
	
	
	function getImages(&$img, $eid = -1, $sid = -1) {
		global $tblprefix, $err_images;
		
		$iquery = "SELECT image_id, i.title, p.person_id as p_person_id, i.event_id, ".
			Event::getFields("e").",".
			PersonDetail::getFields().",".
			Source::getFields("s").", s.source_id as s_source_id".
			" FROM ".$tblprefix."images i ".
			" LEFT JOIN ".$tblprefix."event e ON e.event_id = i.event_id ".
			" LEFT JOIN ".$tblprefix."people p ON p.person_id = e.person_id ".
			" LEFT JOIN ".$tblprefix."source s ON s.source_id = i.source_id ".
			PersonDetail::getJoins();
			
			switch ($img->queryType) {
			case Q_RANDOM:
				$iquery .= $this->addPersonRestriction(" WHERE ").
					$this->addRandom();
				
				break;
			default:
				if ($sid > 0) {
					$iquery .= " WHERE s.source_id = ".quote_smart($sid);
				} else if ($eid > 0) {
					$iquery .= " WHERE e.event_id = ".quote_smart($eid);
				} else if (isset($img->person->person_id)) {
					$iquery .= " WHERE ";
					$iquery .= "p.person_id = ".quote_smart($img->person->person_id);
					$iquery .= $this->addPersonRestriction(" AND ");
					if (isset($img->image_id)) {
						$iquery .= " AND image_id=".$img->image_id;
					}
					$iquery .= " ORDER BY e.date1";
				} else {
					$bool = " WHERE ";
					if (isset($img->image_id)) {
						$iquery .= " WHERE image_id=".$img->image_id;
						$bool = " AND ";
					}
					$iquery .= $this->addPersonRestriction($bool).
					" ORDER BY b.date1";
				}
				break;
			}
		$this->addLimit($img, $query);
		$iresult = $this->runQuery($iquery, $err_images);

		$res = array();

		$img->numResults = 0;
		while($row = $this->getNextRow($iresult)) {
			$image = new Image();
			$image->person = new PersonDetail();
			$image->person->loadFields($row, L_HEADER, "p_");
			$image->person->name->loadFields($row, "n_");
			$image->image_id = $row["image_id"];
			$image->title = $row["title"];
			$image->event = new Event();
			$image->event->loadFields($row, "e_");
			$image->source = new Source();
			$image->source->loadFields($row, "s_");
			$image->description = $image->event->descrip;
			$image->date = $image->event->date1;
			$res[] = $image;
			$img->numResults++;
		}
		$this->freeResultSet($iresult);
		
		$img->results = $res;
		
	}
}
?>
