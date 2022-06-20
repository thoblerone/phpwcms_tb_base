<?php
/*************************************************************************************

  Copyright notice

  cmCalendar Module v1 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2009
  cmCalendar Module v1.2 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2012

  License: GNU General Public License version 2, or (at your option) any later version
  This script is a module for PHPWCMS.

   (c) 2002-2012 Oliver Georgi (oliver@phpwcms.de) // All rights reserved.

*************************************************************************************/

  function cm_map_url($get='', $type='htmlentities') {
  	$base = MODULE_HREF;
  	if(is_array($get) && count($get)) {
  		$get = implode('&', $get);
  	} elseif(empty($get)) {
  		$get = '';
  	}
  	if($get) $get = '&'.$get;
  	if(empty($type) || $type != 'htmlentities') {
  		$base = str_replace('&amp;', '&', MODULE_HREF);
  	} else {
  		$get = htmlentities($get);
  	}
  	return $base.$get;
  }

	/**/
	function cm_detect_lang() {
    preg_match_all('/([a-z]{1,2}(-[a-z]{1,2})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);
    if (count($lang_parse[1])) {
      $detected_lang = $lang_parse[1][0];
    } else {
      $detected_lang = 'en-us';
    }
    return $detected_lang;
  }

function cm_roundAll($a) {
	$a = floatval($a);
	return round($a, 2);
}


if(!function_exists("bcdiv")){
  function bcdiv($first, $second, $accuracy=2){
    $res = $first/$second;
    return round($res, $accuracy);
  }
}

function _cmerror($msg, $title='NOTICE'){
		$errorMsg = "<div><strong>{$title}: </strong>{$msg}</div>";
	return $errorMsg;
}

function showSpan($val) {
	$value = "<select name=\"cm_events_span\">\n";
	for ($i=1; $i<=31; $i++) {
		$value .= "<option value=\"$i\"";
		if ($i == $val) 
			$value .= "selected";		
		$value .= ">$i</option>\n";
	}
	$value .= "</select>\n";
	return $value;
}

function cmShowArticles($loc_art, $name, $noart, $width=200) {
   $result = _dbQuery("SELECT * FROM ".DB_PREPEND."phpwcms_article, ".DB_PREPEND."phpwcms_articlecat WHERE article_public = 1 AND article_deleted = 0 AND article_cid = acat_id ORDER BY acat_name")
      or die("There was an error<br /> " . mysql_error() . "<hr />");
   $value_loc = '<select name="'.$name.'" style="width:'.$width.'px;">'."\n";;
   $value_loc .= "<option ";
   if ($loc_art == "0") {
         $value_loc .= " selected='selected'";
      }
   $value_loc .= " value=\"0\">".$noart."</option>\n";
   foreach($result as $row) {
      $value_loc .= "<option ";
      if ($row['article_id'] == $loc_art) {
         $value_loc .= " selected='selected'";
      }
      $value_loc .= ' value="'.$row['article_id'].'">'.$row['acat_name'].' - '.$row['article_title'].'</option>'.LF;
   }
   $value_loc .= "</select>\n";
   return $value_loc;
}

if(!function_exists("render_date")){
  function render_date($text='', $date, $rt='DATE') {	// TB: Funktion müsste überflüssig sein, da stets in 
	// \include\inc_front\front.func.inc.php definiert
  	// render date by replacing placeholder tags by value
  	$rt = preg_quote($rt);
  	$text = preg_replace('/\{'.$rt.':(.*?) lang=(..)\}/e', 'international_date_format("$2","$1","'.$date.'")', $text);
  	$text = preg_replace('/\{'.$rt.':(.*?)\}/e', 'date("$1",'.$date.')', $text);
  	return $text;
  }
}

function get_next_setid() {
		$sql = "SELECT MAX(cm_events_setid) as maxsetid FROM ".DB_PREPEND."phpwcms_cmcalendar_events";
		$result = _dbQuery($sql);

		$setid = $result[0]["maxsetid"];

		return ++$setid;
}

function schedule_daily($start, $end, $every) {
			$newtimeofentry=strtotime($start);
			$endtime = strtotime($end);

			$event_array = array();
			while ($newtimeofentry<=$endtime) {
					$event = date("Y-m-d", $newtimeofentry);
					array_push($event_array, $event);
					$currentarray=explode("-", $event);

					$newtimeofentry=mktime(0,0,0,$currentarray[1], $currentarray[2]+$every, $currentarray[0]);
			}
			return $event_array;
}

function schedule_monthlybydate($start, $end) {
			$newtimeofentry=strtotime($start);
			$endtime = strtotime($end);

			$event_array = array();
			while ($newtimeofentry<=$endtime) {
					$event = date("Y-m-d", $newtimeofentry);
					array_push($event_array, $event);
					$currentarray=explode("-", $event);

					$newtimeofentry=mktime(0,0,0,$currentarray[1]+1, $currentarray[2], $currentarray[0]);
			}
			return $event_array;
}


function schedule_monthlybyweekday($start, $end) {
			$starttime = strtotime($start);
			$endtime = strtotime($end);

			$weekday = date("w", $starttime);
			$startdate = explode("-", $start);
			$newtimeofentry = mktime(0,0,0,$startdate[1], 1, $startdate[0]);
			$start_weekday = date("w", $newtimeofentry);

			$nth_weekday = 1;
			for ($i=1; $i<date("d", $starttime); $i++) {
			   if (date("w", mktime(0,0,0, $startdate[1], $i, $startdate[0]))==$weekday) {
				  $nth_weekday++;
			   }
			}

			$event_array = array();
			while ($newtimeofentry<=$endtime) {
					$event = date("Y-m-d", get_ordinal_day($weekday, $nth_weekday, $newtimeofentry));
					array_push($event_array, $event);
					$currentarray=explode("-", $event);

					$newtimeofentry=mktime(0,0,0,$currentarray[1]+1, 1, $currentarray[0]);
			}
			return $event_array;
}


function schedule_yearly($start, $end, $every) {
			$newtimeofentry=strtotime($start);
			$endtime = strtotime($end);

			$event_array = array();
			while ($newtimeofentry<=$endtime) {
					$event = date("Y-m-d", $newtimeofentry);
					array_push($event_array, $event);
					$currentarray=explode("-", $event);

					$newtimeofentry=mktime(0,0,0,$currentarray[1], $currentarray[2], $currentarray[0]+$every);
			}
			return $event_array;
}


function schedule_custom($start, $datelist) {
			$event_array = explode("\n", trim($datelist));
			array_push($event_array, $start);
			array_map("trim", $event_array);

			return $event_array;
}

// schedule functions
function get_ordinal_day($ord, $nthday, $evtime) {
			$currenttime=$evtime;
			$i=0;

			while ($i<$nthday) {
					if ($ord==date("w", $currenttime)) $i++;
					if ($i<$nthday) {
					   $currentarray=explode("-", date("Y-m-d", $currenttime));
					   $currenttime=mktime(0,0,0,$currentarray[1], $currentarray[2]+1, $currentarray[0]);
					}
			}
			return $currenttime;
}

?>
