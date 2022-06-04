<?php
/*************************************************************************************

  Parts of this script come from the original calendar mod:
  // Ionrock's Calendar MOD by Verve...
  // Coypright (C) 2004
  the script was almost entirely rewritten though an made a plugin mod for phpwcms.

  Copyright notice

  cmCalendar Module v1 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2009
  cmCalendar Module v1.2 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2012

  License: GNU General Public License version 2, or (at your option) any later version
  This script is a module for PHPWCMS.

   (c) 2002-2012 Oliver Georgi (oliver@phpwcms.de) // All rights reserved.

*************************************************************************************/

class cmCalendar {
	var $message;
  var $langInfo;
  var $firstdayofweek;
  var $articlellinkactive;
  var $activedayslink;
  var $activeday;
  var $teaseranchorlink;
  var $moduledir;
  var $leftbut;
  var $rightbut;
  var $numbercals;
  
  function activeDaysLink( $link ) {
  	$this->activedayslink = $link;
  }

  function teaserAnchorlinkActive( $foo ) {
  	$this->teaseranchorlink = $foo;
  }
  
  function activeDay( $val ) {
  	$this->activeday = $val;
  }
  
  function setFirstDOW( $dow ) {
    /*
    1 = monday
    2 = sunday
    */
  	$this->firstdayofweek = $dow;
  }
  
  function articlellinkActive( $activate ) {
  	$this->articlellinkactive = $activate;
  }

  function setModuleDir( $moddir ) {
  	$this->moduledir = $moddir;
  }

  function setLeftBut( $but ) {
  	$this->leftbut = $but;
  }
  
  function setRightBut( $but ) {
  	$this->rightbut = $but;
  }
  
  function setNumberCals( $anz ) {
  	$this->numbercals = $anz;
  }
  

	function getMessage() {
		return $this->message;
	}

	function getactivedays($month, $year, $id){
	$_entry['query'] = '';
  $_entry['cals_array'] = array();
  	foreach($id as $value) {
		$_entry['cals_array'][] = "cm_events_allcals LIKE '%|".intval($value)."|%'";
	}
	if(count($_entry['cals_array'])) {
		$_entry['query'] = ' AND ('.implode(' OR ', $_entry['cals_array']).')';
	} else {
    $_entry['query'] = " AND cm_events_allcals ='default'"; //never true
  }
		/* Select all events in the current month and year, taking
		into account events that span multiple months and/or years  - JDE */
		$sql = "SELECT cm_events_date,cm_events_span,cm_events_article,cm_events_dat_undef,cm_events_id FROM ".DB_PREPEND."phpwcms_cmcalendar_events WHERE cm_events_status=1" .
			   $_entry['query'] .
			   " AND " .
			   "(MONTH(cm_events_date) + (YEAR(cm_events_date) * 12) <= $month + ($year * 12)) AND " .
			   "(MONTH(DATE_ADD(cm_events_date, INTERVAL(cm_events_span - 1) DAY)) + " .
			   "(YEAR(DATE_ADD(cm_events_date, INTERVAL(cm_events_span - 1) DAY)) * 12) >= $month + ($year * 12)) " .
			   "ORDER BY cm_events_date ASC ";
		$result = mysql_query($sql)
			or die("Error: ".mysql_errno().": ".mysql_error()."<hr />" . $sql);

		$a_days=array();
		$a_link=array();
		$a_undef=array();
		$a_id=array();

		while ($row = mysql_fetch_row($result)) {
			$testdate=date("j", strtotime($row[0]));
			$testmonth=date("n", strtotime($row[0]));
			$testyear=date("Y", strtotime($row[0]));
			$monthlimit=date("t", strtotime($row[0]));
 
			for ($j=0; $j<$row[1]; $j++) {
				if ($testmonth == $month && !in_array($testdate, $a_days)) {
					array_push($a_days, $testdate);
					array_push($a_link, $row[2]);
					array_push($a_undef, $row[3]);
					array_push($a_id, $row[4]);
				}
			$testdate++;

				/* If we overflow a month, set date back to one.
				If we overflow a year, set month back to one.
				In either case, reset the month limit - JDE */
				if ($testdate > $monthlimit) {
					$testdate = 1;
					$testmonth++;
					if ($testmonth > 12) {
						$testmonth = 1;
						$testyear++;
					}
					$monthlimit=date("t", strtotime("{$testyear}-{$testmonth}-1"));
				}
			}
		}
		$activedays=array('activedays' => $a_days, 'activelinks' => $a_link, 'undef' => $a_undef, 'eventid' => $a_id);
		return $activedays;
	}

	function get_categories() {
		$sql = "SELECT * FROM ".DB_PREPEND."phpwcms_cmcalendar_categories ORDER BY cm_cat_name ASC";

		$result = mysql_query($sql)
			or die("Error: ".mysql_errno().": ".mysql_error()."<hr />" . $sql);

		$cat_array = array();
		while ($row = mysql_fetch_array($result)) {
			$cat_array[$row["cm_cat_id"]]=$row["cm_cat_name"];
		}

		return $cat_array;
	}

function setLanguageFrontend($langId) {
    $this->getLanguage($langId);
}
function getLanguage($lang) {
    $lang2 = '';
    if(strlen($lang) > 2) {
      $lang2 = substr($lang, 0, 2);
    }
    $sql  = 'SELECT COUNT(cm_lang_id) FROM '.DB_PREPEND.'phpwcms_cmcalendar_language WHERE cm_lang_status=1 AND ';
		$sql .= "cm_lang_loc = '". aporeplace($lang) ."'";
    $sql2  = 'SELECT COUNT(cm_lang_id) FROM '.DB_PREPEND.'phpwcms_cmcalendar_language WHERE cm_lang_status=1 AND ';
		$sql2 .= "cm_lang_loc = '". aporeplace($lang2) ."'";		
    if( _dbQuery($sql, 'COUNT') ) {
      $sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_cmcalendar_language WHERE cm_lang_status=1 AND ';
		  $sql .= "cm_lang_loc = '".aporeplace($lang) ."'" ;
		  $pluglang = _dbQuery($sql);
      $pluglang['lang']	= unserialize($pluglang[0]["cm_lang_lang"]);
		} else if($lang2 &&_dbQuery($sql2, 'COUNT') ) {
      $sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_cmcalendar_language WHERE cm_lang_status=1 AND ';
		  $sql .= "cm_lang_loc = '".aporeplace($lang2) ."'" ;
		  $pluglang = _dbQuery($sql);
      $pluglang['lang']	= unserialize($pluglang[0]["cm_lang_lang"]);   
    } else {
      $sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_cmcalendar_language WHERE cm_lang_status=1 AND ';
		  $sql .= "cm_lang_loc = 'en'" ;
		  $pluglang = _dbQuery($sql);
      $pluglang['lang']	= unserialize($pluglang[0]["cm_lang_lang"]);     
    }

	  $this->langInfo['cm_lang_langloc'] = ($lang2) ? strtoupper($lang2) : strtoupper($lang);
	  $this->langInfo['cm_lang_dateformat'] = $pluglang['lang']['cm_lang_dateformat'];
	  $this->langInfo['cm_lang_cale'] = $pluglang['lang']['cm_lang_cale'];
	  $this->langInfo['cm_lang_date'] = $pluglang['lang']['cm_lang_date'];
	  $this->langInfo['cm_lang_span'] = $pluglang['lang']['cm_lang_span'];
	  $this->langInfo['cm_lang_titl'] = $pluglang['lang']['cm_lang_titl'];
	  $this->langInfo['cm_lang_time'] = $pluglang['lang']['cm_lang_time'];
	  $this->langInfo['cm_lang_loca'] = $pluglang['lang']['cm_lang_loca'];
	  $this->langInfo['cm_lang_desc'] = $pluglang['lang']['cm_lang_desc'];
	  $this->langInfo['cm_lang_noen'] = $pluglang['lang']['cm_lang_noen'];
	  $this->langInfo['cm_lang_noca'] = $pluglang['lang']['cm_lang_noca'];
	  $this->langInfo['cm_lang_prnt'] = $pluglang['lang']['cm_lang_prnt'];
	  $this->langInfo['cm_lang_ical'] = $pluglang['lang']['cm_lang_ical'];
	  $this->langInfo['cm_lang_artl'] = $pluglang['lang']['cm_lang_artl'];
	  $this->langInfo['cm_lang_lbut'] = $pluglang['lang']['cm_lang_lbut'];
	  $this->langInfo['cm_lang_rbut'] = $pluglang['lang']['cm_lang_rbut'];
	  $this->langInfo['cm_lang_bckl'] = $pluglang['lang']['cm_lang_bckl'];
	  $this->langInfo['cm_lang_lstl'] = $pluglang['lang']['cm_lang_lstl'];
	  $this->langInfo['cm_lang_slct'] = $pluglang['lang']['cm_lang_slct'];
	  $this->langInfo['cm_lang_undf'] = $pluglang['lang']['cm_lang_undf'];
	  $this->langInfo['cm_lang_slct_all'] = $pluglang['lang']['cm_lang_slct_all'];
	  $this->langInfo['cm_lang_slct_am'] = $pluglang['lang']['cm_lang_slct_am'];
	  $this->langInfo['cm_lang_slct_ay'] = $pluglang['lang']['cm_lang_slct_ay'];
	  $this->langInfo['cm_lang_slct_nm'] = $pluglang['lang']['cm_lang_slct_nm'];
	  $this->langInfo['cm_lang_slct_ny'] = $pluglang['lang']['cm_lang_slct_ny'];
	  $this->langInfo['cm_lang_slct_lm'] = $pluglang['lang']['cm_lang_slct_lm'];
	  $this->langInfo['jan'] = $pluglang['lang']['cm_lang_jan'];
	  $this->langInfo['feb'] = $pluglang['lang']['cm_lang_feb'];
	  $this->langInfo['mar'] = $pluglang['lang']['cm_lang_mar'];
	  $this->langInfo['apr'] = $pluglang['lang']['cm_lang_apr'];
	  $this->langInfo['may'] = $pluglang['lang']['cm_lang_may'];
	  $this->langInfo['jun'] = $pluglang['lang']['cm_lang_jun'];
	  $this->langInfo['jul'] = $pluglang['lang']['cm_lang_jul'];
	  $this->langInfo['aug'] = $pluglang['lang']['cm_lang_aug'];
	  $this->langInfo['sep'] = $pluglang['lang']['cm_lang_sep'];
	  $this->langInfo['oct'] = $pluglang['lang']['cm_lang_oct'];
	  $this->langInfo['nov'] = $pluglang['lang']['cm_lang_nov'];
	  $this->langInfo['dec'] = $pluglang['lang']['cm_lang_dec'];

	  $this->langInfo['mon'] = $pluglang['lang']['cm_lang_mon'];
	  $this->langInfo['tue'] = $pluglang['lang']['cm_lang_tue'];
	  $this->langInfo['wed'] = $pluglang['lang']['cm_lang_wed'];
	  $this->langInfo['thu'] = $pluglang['lang']['cm_lang_thu'];
	  $this->langInfo['fri'] = $pluglang['lang']['cm_lang_fri'];
	  $this->langInfo['sat'] = $pluglang['lang']['cm_lang_sat'];
	  $this->langInfo['sun'] = $pluglang['lang']['cm_lang_sun'];

	  $this->langInfo['noCategory'] = $pluglang['lang']['cm_lang_noca'];
	  $this->langInfo['noEventNotice'] = $pluglang['lang']['cm_lang_noen'];
}
function setLanguageBackend() {
    $this->getLanguage($_SESSION['wcs_user_lang']);
}


function make_calendar($month, $year, $category=0, $alias=0) {
		$previousmonth = date("n", mktime(0,0,0,$month-1,1,$year));
		$previousyear  = date("Y", mktime(0,0,0,$month-1,1,$year));
		$nextmonth = date("n", mktime(0,0,0,$month+1,1,$year));
		$nextyear  = date("Y", mktime(0,0,0,$month+1,1,$year));
		// $monthname = date("F Y", mktime(0,0,0, $month, 1, $year));
		$thisYear =  date("Y", mktime(0,0,0, $month, 1, $year));
		$thisMonth = $this->langInfo[strtolower(date("M", mktime(0,0,0, $month, 1, $year)))];
		$daysinmonth = date("t", mktime(0,0,0,$month,1,$year));
		$startday = date("w", mktime(0,0,0,$month,1,$year));
		$activedays = $this->getactivedays($month, $year, $category);
    $j=0;
		$weeks = "";
$anchorlnk = "";
    switch ($this->firstdayofweek) {
      case 1: $weekbegin = 1;
		          $daysleft =  7-(($daysinmonth+$startday)%7);
              if ($daysleft==7) $daysleft=0;
              if ($startday==0) $startday=7; 
              $days = array("mon", "tue", "wed", "thu", "fri", "sat", "sun" );
              $weekend = 6;
    	break;
    	case 2: $weekbegin = 0;
              $days = array("sun", "mon", "tue", "wed", "thu", "fri", "sat" );
		          $daysleft =  7-(($daysinmonth+$startday)%7);
              $weekend = 7;
    	break;
      default:  $weekbegin = 0;
              $days = array("mon", "tue", "wed", "thu", "fri", "sat", "sun" );
		          $daysleft =  7-(($daysinmonth+$startday)%7);
              $weekend = 7;
    }
		
    
    for ($i=$weekbegin; $i < $startday; $i++) {
			if ($j%7==0)
				$weeks .= "<tr>\n";
			$weeks .= "<td width=\"14%\" class=\"cmCalendarOffsetday\">&nbsp;</td>\n";
			$j++;
			if ($j%7==0)
				$weeks .= "</tr>\n";
		}

		for ($i=1; $i <= $daysinmonth; $i++) {
		  //find sunday
		  if (date("w", mktime(0, 0, 0, $month, $i, $year)) == 0	) {
        $issunday = ' cmCalendarSunday';
      } else {
        $issunday = '';
      }
      //find saturday
		  if (date("w", mktime(0, 0, 0, $month, $i, $year)) == 6	) {
        $issaturday = ' cmCalendarSaturday';
      } else {
        $issaturday = '';
      }
      //find today
      if (	date("m") == $month	&& date("Y") == $year && date("d") == $i ) {
        $istoday = ' today';
      } else {
        $istoday = '';
      }
		  
		  
			if ($j%7==0)
				$weeks .= "<tr>\n";
      $actkeyis=array_keys($activedays['activedays'], $i);
			if (in_array($i, $activedays['activedays'])) {

				if ($activedays['undef'][$actkeyis[0]] == "1") {
					$weeks .= "<td width=\"14%\" class=\"cmCalendarDays".$issunday.$issaturday.$istoday."\">$i</td>\n";
				} elseif ( (!$activedays['activelinks'][$actkeyis[0]] == "0") && ($this->articlellinkactive) ) {
					$articleresult = mysql_query("SELECT * FROM ".DB_PREPEND."phpwcms_article WHERE article_id = " . $activedays['activelinks'][$actkeyis[0]] . " LIMIT 1")
         			or die("There was an error<br /> " . mysql_error());
         			while ($articlerow = mysql_fetch_array($articleresult, MYSQL_ASSOC)) {
            			$art_id=$articlerow["article_id"];
            			$art_cid=$articlerow["article_cid"];
         			}
         			mysql_free_result($articleresult);

         			$eventlink = "index.php?aid=".$art_id ;
		 			$weeks .= "<td width=\"14%\" class=\"".$issunday.$issaturday." cmCalendarActiveday cmCalendarArticlelink".$istoday."\"><a href=\"$eventlink\">$i</a></td>\n";
				} else if ( $this->activeday ) {
      	    // this just fowards to the main calendar page...
      	      	if ($this->teaseranchorlink == 1) $anchorlnk = '#jump-cal-'.$activedays['eventid'][$actkeyis[0]];
				    $weeks .= "<td width=\"14%\" class=\"".$issunday.$issaturday." cmCalendarActiveday".$istoday."\"><a href=\"index.php?aid=".$this->activedayslink.$anchorlnk."\">$i</a></td>\n";
        } else {
				    $weeks .= "<td width=\"14%\" class=\"cmCalendarDays cmActiveDaynoLink".$issunday.$issaturday.$istoday."\">$i</td>\n";
        }
			} else {
 				$weeks .= "<td width=\"14%\" class=\"cmCalendarDays".$issunday.$issaturday.$istoday."\">$i</td>\n";        
			}
			$j++;
			if ($j%7==0)
				$weeks .= "</tr>\n";
		}

		//$daysleft =  7-(($daysinmonth+$startday)%7);

		if ($daysleft<$weekend) {
			for ($i=0; $i < $daysleft+$weekbegin; $i++) {
				if ($j%7==0)
					$weeks .= "<tr>\n";
				$weeks .= "<td width=\"14%\" class=\"cmCalendarOffsetday\">&nbsp;</td>\n";
				$j++;
				if ($j%7==0)
					$weeks .= "</tr>\n";
			}
	 }
		$calendar = '
<div id="cmCalendarMainContainer" class="cmCalendarMainContainer">
<div id="cmCalendarContainer1" class="cmCalendarContainer1">
  <table width="100%" border="0" class="cmCalendar">
		<tr>
			<td colspan="7" align="left">
			<table width="100%" class="cmCalendarHead">
      <tr>
			  <td>
          <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
    				<input type="hidden" name="cmmonth" value="' . $previousmonth . '" />
    				<input type="hidden" name="cmyear" value="' . $previousyear . '" />';
          if ($this->leftbut != '0.gif') {
          $calendar .= '<input type="image" name="left_advance" src="'.$this->moduledir.'template/img/'.$this->leftbut.'" />';
          } else {
          $calendar .= '<input type="submit" name="left_advance" value="'.$this->langInfo['cm_lang_lbut'].'" class="cmCalendarLeftButton" />';
          }	
		$calendar .= '</form></td>
  			<td align="center" class="cmCalendarMonth"><div>
  			' . $thisMonth . ' ' .$thisYear . '</div>
  			</td>
  			<td align="right">
  			<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
  				<input type="hidden" name="cmmonth" value="' . $nextmonth . '" />
  				<input type="hidden" name="cmyear" value="' . $nextyear . '" />';
          if ($this->rightbut != '0.gif') {
          $calendar .= '<input type="image" name="right_advance" src="'.$this->moduledir.'template/img/'.$this->rightbut.'" />';
          } else {
          $calendar .= '<input type="submit" name="right_advance" value="'.$this->langInfo['cm_lang_rbut'].'" class="cmCalendarLeftButton" />';
          }	
		$calendar .= '</form></td>
  		</tr>
      </table>
  		</td>
  	</tr>
    ';

		$calendar .= "<tr>\n";
    for ($i=0; $i<7; $i++) {
			$calendar .= "<td class=\"cmCalendarDayname\">" . substr($this->langInfo[$days[$i]], 0, 2) . "</td>\n";
		}
		$calendar .= "</tr>\n";
		$calendar .= $weeks;
		$calendar .= "</table></div>"; //end cmCalendarContainer
		if (!isset($this->numbercals)) $this->numbercals = 1;
		for ($j=1; $j < $this->numbercals; $j++ ) {
		  $set_nextmonth = date("n", mktime(0,0,0,$month+$j,1,$year));
		  $set_nextyear  = date("Y", mktime(0,0,0,$month+$j,1,$year));
      $calendar .= $this->make_following_calendar($set_nextmonth, $set_nextyear, $category, $j);
    }
		$calendar .= "</div>\n"; //end cmCalendarMainContainer

		return $calendar;
}


function make_following_calendar($month, $year, $category=0, $number=0, $alias=0) {
		$previousmonth = date("n", mktime(0,0,0,$month-1,1,$year));
		$previousyear  = date("Y", mktime(0,0,0,$month-1,1,$year));
		$nextmonth = date("n", mktime(0,0,0,$month+1,1,$year));
		$nextyear  = date("Y", mktime(0,0,0,$month+1,1,$year));
		// $monthname = date("F Y", mktime(0,0,0, $month, 1, $year));
		$thisYear =  date("Y", mktime(0,0,0, $month, 1, $year));
		$thisMonth = $this->langInfo[strtolower(date("M", mktime(0,0,0, $month, 1, $year)))];
		$daysinmonth = date("t", mktime(0,0,0,$month,1,$year));
		$startday = date("w", mktime(0,0,0,$month,1,$year));
		$activedays = $this->getactivedays($month, $year, $category);
    $j=0;
		$weeks = "";
$anchorlnk = "";
    switch ($this->firstdayofweek) {
      case 1: $weekbegin = 1;
		          $daysleft =  7-(($daysinmonth+$startday)%7);
              if ($daysleft==7) $daysleft=0;
              if ($startday==0) $startday=7; 
              $days = array("mon", "tue", "wed", "thu", "fri", "sat", "sun" );
              $weekend = 6;
    	break;
    	case 2: $weekbegin = 0;
              $days = array("sun", "mon", "tue", "wed", "thu", "fri", "sat" );
		          $daysleft =  7-(($daysinmonth+$startday)%7);
              $weekend = 7;
    	break;
      default:  $weekbegin = 0;
              $days = array("mon", "tue", "wed", "thu", "fri", "sat", "sun" );
		          $daysleft =  7-(($daysinmonth+$startday)%7);
              $weekend = 7;
    }
		
    
    for ($i=$weekbegin; $i < $startday; $i++) {
			if ($j%7==0)
				$weeks .= "<tr>\n";
			$weeks .= "<td width=\"14%\" class=\"cmCalendarOffsetday\">&nbsp;</td>\n";
			$j++;
			if ($j%7==0)
				$weeks .= "</tr>\n";
		}

		for ($i=1; $i <= $daysinmonth; $i++) {
		  //find sunday
		  if (date("w", mktime(0, 0, 0, $month, $i, $year)) == 0	) {
        $issunday = ' cmCalendarSunday';
      } else {
        $issunday = '';
      }
      //find saturday
		  if (date("w", mktime(0, 0, 0, $month, $i, $year)) == 6	) {
        $issaturday = ' cmCalendarSaturday';
      } else {
        $issaturday = '';
      }
      //find today
      if (	date("m") == $month	&& date("Y") == $year && date("d") == $i ) {
        $istoday = ' today';
      } else {
        $istoday = '';
      }
		  

			if ($j%7==0)
				$weeks .= "<tr>\n";
      $actkeyis=array_keys($activedays['activedays'], $i);
			if (in_array($i, $activedays['activedays'])) {

				if ($activedays['undef'][$actkeyis[0]] == "1") {
					$weeks .= "<td width=\"14%\" class=\"cmCalendarDays".$issunday.$issaturday.$istoday."\">$i</td>\n";
				} elseif ( (!$activedays['activelinks'][$actkeyis[0]] == "0") && ($this->articlellinkactive) ) {
					$articleresult = mysql_query("SELECT * FROM ".DB_PREPEND."phpwcms_article WHERE article_id = " . $activedays['activelinks'][$actkeyis[0]] . " LIMIT 1")
         			or die("There was an error<br /> " . mysql_error());
         			while ($articlerow = mysql_fetch_array($articleresult, MYSQL_ASSOC)) {
            			$art_id=$articlerow["article_id"];
            			$art_cid=$articlerow["article_cid"];
         			}
         			mysql_free_result($articleresult);

         			$eventlink = "index.php?aid=".$art_id ;
		 			$weeks .= "<td width=\"14%\" class=\"".$issunday.$issaturday." cmCalendarActiveday cmCalendarArticlelink".$istoday."\"><a href=\"$eventlink\">$i</a></td>\n";
				} else if ( $this->activeday ) {
      	    // this just fowards to the main calendar page...
      	      	if ($this->teaseranchorlink == 1) $anchorlnk = '#jump-cal-'.$activedays['eventid'][$actkeyis[0]];
				    $weeks .= "<td width=\"14%\" class=\"".$issunday.$issaturday." cmCalendarActiveday".$istoday."\"><a href=\"index.php?aid=".$this->activedayslink.$anchorlnk."\">$i</a></td>\n";
        } else {
				    $weeks .= "<td width=\"14%\" class=\"cmCalendarDays cmActiveDaynoLink".$issunday.$issaturday.$istoday."\">$i</td>\n";
        }
			} else {
 				$weeks .= "<td width=\"14%\" class=\"cmCalendarDays".$issunday.$issaturday.$istoday."\">$i</td>\n";        
			}
			$j++;
			if ($j%7==0)
				$weeks .= "</tr>\n";
		}

		//$daysleft =  7-(($daysinmonth+$startday)%7);

		if ($daysleft<$weekend) {
			for ($i=0; $i < $daysleft+$weekbegin; $i++) {
				if ($j%7==0)
					$weeks .= "<tr>\n";
				$weeks .= "<td width=\"14%\" class=\"cmCalendarOffsetday\">&nbsp;</td>\n";
				$j++;
				if ($j%7==0)
					$weeks .= "</tr>\n";
			}
	 }
		$calendar = '
<div id="cmCalendarContainer'.intval($number+1).'" class="cmCalendarContainer'.intval($number+1).'">
  <table width="100%" border="0" class="cmCalendar">
		<tr>
			<td colspan="7" align="left">
			<table width="100%" class="cmCalendarHead">
      <tr>
			  <td></td>
  			<td align="center" class="cmCalendarMonth"><div>
  			' . $thisMonth . ' ' .$thisYear . '</div>
  			</td>
  			<td align="right"></td>
  		</tr>
      </table>
  		</td>
  	</tr>
    ';

		$calendar .= "<tr>\n";
    for ($i=0; $i<7; $i++) {
			$calendar .= "<td class=\"cmCalendarDayname\">" . substr($this->langInfo[$days[$i]], 0, 2) . "</td>\n";
		}
		$calendar .= "</tr>\n";
		$calendar .= $weeks;
		$calendar .= "</table></div>\n";

		return $calendar;
}

} //end class cmCalendar

function check_specialformat ($format, $lang, $date) {
  $values_notallowed = array('d','D','j','l','S','w');
  $allowed = true;
  foreach ($values_notallowed as $value) {
    if (strpos($format, $value) ) {
      $allowed = false;
    }
  }
  if ($allowed) {
    $output = render_date("{FORMAT_DATE:".$format." lang=".$lang."}", $date, "FORMAT_DATE");
  } else {
    $output = '';
  }
}

?>