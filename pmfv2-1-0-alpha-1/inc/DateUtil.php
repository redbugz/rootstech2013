<?php
require_once("classes/MiniEvent.php");

class DateUtil {
	static function make_date($incoming, &$event, $date2 = false) {
		// define the months
		$months = array(1 => "JAN",
						2 => "FEB",
						3 => "MAR",
						4 => "APR",
						5 => "MAY",
						6 => "JUN",
						7 => "JUL",
						8 => "AUG",
						9 => "SEP",
						10 => "OCT",
						11 => "NOV",
						12 => "DEC");
		// how long is the date string
		$length = strlen($incoming);
		$work = explode(" ", $incoming);

		// if the first part is not numeric, then we don't really know what to do!...
		if ($work && count($work) > 0 && !is_numeric($work[0])) {
			$retval = "0000-00-00";
			// ...if it isn't, check it's not a month
			if (in_array($work[0], $months)) {
				$retval = $work[1]."-".str_pad(array_search(strtoupper($work[0]), $months), 2, "0", STR_PAD_LEFT)."-00";
				if (count($work) > 2) {
					unset($work[0]);
					unset($work[1]);
					$temp = implode(" ",array_values($work));
					DateUtil::make_date($temp, $event, $date2);
				}
			} else if (count($work) > 1) {
				switch($work[0]) {
					case "BEF":
					if ($date2) {
						$event->date2_modifier = DATE_BEFORE;
					} else {
						$event->date1_modifier = DATE_BEFORE;
					}
					break;
					case "AFT":
					if ($date2) {
						$event->date2_modifier = DATE_AFTER;
					} else {
						$event->date1_modifier = DATE_AFTER;
					}
					break;
					case "ABT":
					if ($date2) {
						$event->date2_modifier = DATE_ABOUT;
					} else {
						$event->date1_modifier = DATE_ABOUT;
					}
					break;
					case "EST":
					if ($date2) {
						$event->date2_modifier = DATE_EST;
					} else {
						$event->date1_modifier = DATE_EST;
					}
					break;
					case "CAL":
					if ($date2) {
						$event->date2_modifier = DATE_CALC;
					} else {
						$event->date1_modifier = DATE_CALC;
					}
					break;
					case "BET":
						$event->date1_modifier = DATE_BET;
					break;
					case "FROM":
					if ($date2) {
						$event->date2_modifier = DATE_FROM;
					} else {
						$event->date1_modifier = DATE_FROM;
					}
					break;
					case "TO":
					if ($date2) {
						$event->date2_modifier = DATE_TO;
					} else {
						$event->date1_modifier = DATE_TO;
					}
					break;
					case "AND":
						$date2 = true;
					break;
				}
				unset($work[0]);
				//unset($work[1]);
				$temp = implode(" ",array_values($work));
				$retval = DateUtil::make_date($temp, $event, $date2);
			}
		} else {
			if (count($work) === 1) {
				$retval = $work[0]."-00-00";
			} else {
				$done = 0;
				if (in_array($work[1], $months)) {
					$retval = $work[2]."-".str_pad(array_search(strtoupper($work[1]), $months), 2, "0", STR_PAD_LEFT)."-".str_pad($work[0], 2, "0", STR_PAD_LEFT);
					if (count($work) > 2) {
						$done = 2;
					}
				} else {
					$retval = $work[0]."-00-00";
					$done = 1;
				}
				if (count($work) > 3) {
					$done = 3;
				}
				if ($done > 0 && !$date2) {
					for ($i = 0; $i < $done;$i++) {
						unset($work[$i]);
					}
					$temp = implode(" ",array_values($work));
					DateUtil::make_date($temp, $event, true);
				}
			} 
		}

		// check that the returning string isn't going to break the database
		// must be 0000-00-00
		if (!preg_match("#([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})#", $retval))
			$retval = "0000-00-00";

		if (($event->date1_modifier == 0) and ($event->date1 != "0000-00-00")) {
			$event->date1_modifier = 8 ;	// on
		}
		
		// return the string
		if($date2) {
			$event->date2 = $retval;
		} else {
			$event->date1 = $retval;
		}
		
		return $retval;
	}
	
	//Try and work out which date format is used and convert accordingly
	static function resolveDate($date) {
		global $currentRequest;
		
		$retval = "0000-00-00";
		if (preg_match("#([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})#", $date)) {
			$retval = $date;
		} else if (preg_match("#([0-9]{1,2}) ([a-zA-Z]{3}) ([0-9]{4})#", $date)) {
			$event = new MiniEvent();
			$upper = strtoupper($date);
			$retval = DateUtil::make_date($upper, $event);
		} else {
			$query = 'SELECT STR_TO_DATE('.quote_smart($date).','.$currentRequest->datefmt.');';
			if (!($result = mysql_query($query))) {
				error_log($query);
				error_log(mysql_error());
			} else {
				$row = mysql_fetch_row($result);
				$retval = $row[0];
				mysql_free_result($result);
			}
		}
		return $retval;
			
	}
	
	static function full_ged_date1($event) {
		$date = "";
		if ($event->date1 <> "0000-00-00") {
			$date = "2 DATE ";
			$mod = "";
			switch($event->date1_modifier) {
        		case 9:		//	"In"
        		case 1:		//  "About"
				$mod = "ABT ";
            		break;
        		case 2:		// "Circa"
	        	case 3:		// "Estimated
			case 4:		// "Roughly"
				$mod = "EST ";
        	    	break;
	            	case 5:		// Calculated
                		$mod = "CAL ";
        	     	break;
	             	case 6:		// "Before"
                		$mod = "BEF ";
        	     	break;
	             	case 7:		// "After"
        	        	$mod = "AFT ";
	             	break;
			}
			$date .= $mod;
			$date .= DateUtil::ged_date($event->date1);
			$date .= "\n";
		}
		return($date);
	}
	
	//convert date from yyyy-mm-dd database format to dd MMM yyyy gedcom format
	static function ged_date($incoming) {
		// define the months
		$months = array ("00" => "00", "01" => "JAN", "02" => "FEB", "03" => "MAR", "04" => "APR", "05" => "MAY", "06" => "JUN", "07" => "JUL", "08" => "AUG", "09" => "SEP", "10" => "OCT", "11" => "NOV", "12" => "DEC");
		// explode date
		$work = explode("-", $incoming);
		$retval = "";
		if (count($work) > 1) {
		// if  month or day unknown, just return year
			if ($work[1] == "00" OR $work[2] == "00") {
				$retval = "$work[0]";
			} elseif ($work[1] != "00" AND $work[2] == "00") {
        	    // year and month are known
				$replacemonth = strtr($work[1], $months);
				$retval = "$replacemonth $work[0]";
			} else {
				// reformat whole date to dd MMM yyyy
				$replacemonth = strtr($work[1], $months);
				$retval = "$work[2] $replacemonth $work[0]";
			}
		}
		// return the string for gedcom DATE
		return $retval;
	}
}
?>
