<?php
include_once "modules/db/DAOFactory.php";

$peep = new PersonDetail();
$peep->queryType = Q_IND;
$pdao = getPeopleDAO();

$dao = getImageDAO();

$img = new Image();

$imgFile = $img->getImageFile();
$tnFile = $img->getThumbnailFile();
$error = '';

if (isset($_REQUEST["func"]) && $_REQUEST["func"] == "delete") {
	$peep->setFromRequest();
	$pdao->getPersonDetails($peep);
	if ($peep->person_id > 0) {
		$pdao->getPersonDetails($peep);
		$peep = $peep->results[0];
		if (!$peep->isEditable()) {
			die(include "inc/forbidden.inc.php");
		}		
	} 

	$img->setFromRequest();
	if ((@unlink($tnFile) && @unlink($imgFile)) || !file_exists($tnFile) || !file_exists($imgFile)) {
		$chg = $dao->deleteImage($img);
	} 
} else {
	$peep->setFromPost();
	if ($peep->person_id > 0) {
		$pdao->getPersonDetails($peep);
		$peep = $peep->results[0];
		if (!$peep->isEditable()) {
			die(include "inc/forbidden.inc.php");
		}		
	} 
	$img->setFromPost();
	$e = new Event();
	$e->setFromPost();
	if (!isset($e->event_id)) {
		$e->type = IMAGE_EVENT;
		$img->event = $e;
		$img->event->sources = array();
	} else {
		$edao = getEventDAO();
		$edao->getEvents($e, Q_ALL);
		$img->event = $e->results[0];
		$sdao = getSourceDAO();
		$sdao->getEventSources($img->event);
		$img->event->sources = $img->event->results;
	}
	$e->person->person_id = $img->person->person_id;
	$s = new Source();
	$s->setFromPost();
	$sdao = getSourceDAO();

	$sdao->resolveSource($s);
	
	$img->source = $s;
	
	if ($s->source_id > 0) {
//		$e->person->person_id = 'null';
		if (!$s->isEditable()) {
			die(include "inc/forbidden.inc.php");
		}	
	} else {
		$s->source_id = 'null';
	}
		
	if (isset($img->image_id)) {
		$chg = $dao->updateImage($img);
	} else {
		$e->date1_modifier = 0;
		$chg = processimage($dao, $img);
		if (!$chg) {
			$error = "&error=image";
		}
	}
}

if ($chg) {
	stamppeeps($peep);
}

if (isset($_REQUEST["dest"]) && $_REQUEST["dest"] == "gallery") {
	header("Location: gallery.php");
} else {
	header("Location: people.php?person=".$img->person->person_id.$error);
}


	// function: imagecreate_wrapper
	// see if we have latest imagecreatetrucolor available
	function imagecreate_wrapper($xsize, $ysize) {

		// checking function exists doesn't work
		// function is there, even if it isn't

		// nasty work around
		// FIX ME
		$test = imagecreatetruecolor(1,1);

		if ($test)
			return imagecreatetruecolor($xsize, $ysize);
		else
			return imagecreate($xsize, $ysize);

	}	// end of imagecreate_wrapper()


	// function: processimage
	// process an uploaded image
	function processimage($dao, $img) {
		// define globals used within
		global $tblprefix;
		global $err_image_insert;
		$config = Config::getInstance();
		$img_max = $config->img_max;
		$img_min = $config->img_min;

		// image creation needs masses of memory
		// this is set too large! but needs to be to process a 1MB jpg!
		// if left as standard 8M, image creation fails and you get error messages and blank thumbnails
		//ini_set("memory_limit", "32M");

		// bit of error checking
		if ($img_max < $img_min) {
			$temp = $img_max;
			$img_max = $img_min;
			$img_min = $temp;
		}

		// get the dimensions of the uploaded file
		$size = getimagesize($img->tmp_file_name);
		// get the image resource from the uploaded file
		switch ($size[2]) {
			case 1:
				// it's a gif
				$incoming = @imagecreatefromgif($img->tmp_file_name);
				break;
			case 2:
				// it's a jpeg
				$incoming = @imagecreatefromjpeg($img->tmp_file_name);
				break;
			case 3:
				// it's a png
				$incoming = @imagecreatefrompng($img->tmp_file_name);
				break;
			default:
				error_log("Unknown image type - expect gif, jpeg or png");
				// don't know what it is so just bail-out
				return false;
				break;
		}
		
		if (!$incoming) {
			error_log("Failed to create image resource");
			return false;
		}
		
		// work out the ratio of width to height
		$ratio = $size[0] / $size[1];

		// create the thumbnail
		$thumbw = 100;
		$thumbh = 100;
		$thumb = imagecreate_wrapper($thumbw, $thumbh);
		if (!$thumb)
			return false;

		$background = imagecolorallocate($thumb, 147, 150, 147);
		imagefill($thumb, 0, 0, $background);

		// do different things depending on orientation of image
		if ($ratio < 1) {		// higher than wide
			if ($size[1] > $img_max) {
				// create a file with maximum height
				$file = imagecreate_wrapper($img_max * $ratio, $img_max);
				imagecopyresized($file, $incoming, 0, 0, 0, 0, ($img_max * $ratio), $img_max, $size[0], $size[1]);
			} elseif ($size[1] < $img_min) {
				// create a file with minimum height
				$file = imagecreate_wrapper($img_min * $ratio, $img_min);
				imagecopyresized($file, $incoming, 0, 0, 0, 0, ($img_min * $ratio), $img_min, $size[0], $size[1]);
			} else {
				// create a file the same size
				$file = imagecreate_wrapper($size[0], $size[1]);
				imagecopyresized($file, $incoming, 0, 0, 0, 0, $size[0], $size[1], $size[0], $size[1]);
			}

			// workout border for thumbnail
			$border = ($thumbw - $thumbw * $ratio) / 2;
			imagecopyresized($thumb, $incoming, $border, 0, 0, 0, ($thumbw * $ratio), $thumbh, $size[0], $size[1]);
		}
		else {					// wider than high
			if ($size[0] > $img_max) {
				// create a file with maximum width
				$file = imagecreate_wrapper($img_max, $img_max / $ratio);
				imagecopyresized($file, $incoming, 0, 0, 0, 0, $img_max, ($img_max / $ratio), $size[0], $size[1]);
			} elseif ($size[0] < $img_min) {
				// create a file with minimum width
				$file = imagecreate_wrapper($img_min, $img_min / $ratio);
				imagecopyresized($file, $incoming, 0, 0, 0, 0, $img_min, ($img_min / $ratio), $size[0], $size[1]);
			} else {
				// create a file the same size
				$file = imagecreate_wrapper($size[0], $size[1]);
				imagecopyresized($file, $incoming, 0, 0, 0, 0, $size[0], $size[1], $size[0], $size[1]);
			}

			// workout border for thumbnail
			$border = ($thumbh - $thumbh / $ratio) / 2;
			imagecopyresized($thumb, $incoming, 0, $border, 0, 0, $thumbw, ($thumbh / $ratio), $size[0], $size[1]);
		}

		if (!$file)
			return false;;

		$dao->createImage($img);
		$ret = true;
		// set as interlaced and save to paths

		$root = dirname($_SERVER["SCRIPT_FILENAME"])."/".$config->imagedir;
		$prefix = "";
		$path =	$root.$prefix.$img->image_id.".jpg";

		imageinterlace($file, 1);
		if(!imagejpeg($file, $path, 95)) {
			$ret = false;
		}		
		imagedestroy($file);
		
		$prefix = "tn_";
		$path =	$root.$prefix.$img->image_id.".jpg";

		imageinterlace($thumb, 1);
		if(!imagejpeg($thumb, $path, 100)) {
			$ret = false;
		}


		imagedestroy($thumb);
		if (!$ret) {
			error_log("failed to save image");
		}
		return $ret;
	}	// end of processimage();
?>
