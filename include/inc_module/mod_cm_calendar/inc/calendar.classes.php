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

// some functions the class uses that don't really fit...

function fix($string){
  $html_str = htmlentities($string);
  return $html_str;
}

class cmCalendar {
	var $message;
        var $langInfo;

	function getMessage() {
		return $this->message;
	}

	function getactivedays($month, $year, $id){
		if ($id > 0) {
			//$cat_sql = "category=$id AND ";
			$cat_sql = "cm_events_allcals LIKE '%|".intval($id)."|%' AND ";
		} else {
			$cat_sql = "";
		}
		/* Select all events in the current month and year, taking
		into account events that span multiple months and/or years  - JDE */
		$sql = "SELECT cm_events_date,cm_events_span,cm_events_article,cm_events_dat_undef,cm_events_id FROM ".DB_PREPEND."phpwcms_cmcalendar_events WHERE " .
//		$sql = "SELECT date,span FROM " . $GLOBALS['tables']['cal_events'] . " WHERE " .
			   $cat_sql .
			   "cm_events_status!=9 AND " .
			   "(MONTH(cm_events_date) + (YEAR(cm_events_date) * 12) <= $month + ($year * 12)) AND " .
			   "(MONTH(DATE_ADD(cm_events_date, INTERVAL(cm_events_span - 1) DAY)) + " .
			   "(YEAR(DATE_ADD(cm_events_date, INTERVAL(cm_events_span - 1) DAY)) * 12) >= $month + ($year * 12)) " .
			   "ORDER BY cm_events_date ASC ";
		// echo $sql;
		// $result = mysql_query($sql)
		$result = _dbQuery($sql)
			or die("Error: ".mysql_errno().": ".mysql_error()."<hr />" . $sql);

	//	$activedays=array();
		$a_days=array();
		$a_link=array();
		$a_undef=array();
		$a_id=array();
	//	$activelink=array();
	
		if(!empty($result)) 
		{
			foreach($result as $row) {	
	//		while ($row = mysql_fetch_row($result)) {
				$testdate=date("j", strtotime($row[0]));
				$testmonth=date("n", strtotime($row[0]));
				$testyear=date("Y", strtotime($row[0]));
				$monthlimit=date("t", strtotime($row[0]));
	/*			for ($j=0; $j<$row[1]; $j++) {
					if ($testmonth == $month && !in_array($testdate, $activedays)) {
						array_push($activedays, $testdate);
						//array_push($activelink, $row[2]);
					}*/
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

function setLanguageBackend($lang) {
      $sql  = 'SELECT COUNT(cm_lang_id) FROM '.DB_PREPEND.'phpwcms_cmcalendar_language WHERE ';
			$sql .= "cm_lang_loc LIKE '". aporeplace($_SESSION['wcs_user_lang']) ."'";
			
      if( _dbQuery($sql, 'COUNT') ) {
        $sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_cmcalendar_language WHERE ';
  		  $sql .= "cm_lang_loc = '".aporeplace($_SESSION['wcs_user_lang']) ."'" ;
  		  $pluglang = _dbQuery($sql);
        $pluglang['lang']	= unserialize($pluglang[0]["cm_lang_lang"]);
			} else {
        $sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_cmcalendar_language WHERE ';
  		  $sql .= "cm_lang_loc = 'en'" ;
  		  $pluglang = _dbQuery($sql);
        $pluglang['lang']	= unserialize($pluglang[0]["cm_lang_lang"]);     
      }

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
		if ($startday==0) $startday=7;
		for ($i=1; $i < $startday; $i++) {
			if ($j%7==0)
				$weeks .= "<tr>\n";
			$weeks .= "<td width=\"14%\" class=\"offsetday\">&nbsp;</td>\n";
			$j++;
			if ($j%7==0)
				$weeks .= "</tr>\n";
		}



		for ($i=1; $i <= $daysinmonth; $i++) {
			if ($j%7==0)
				$weeks .= "<tr>\n";
      
        //find today
      if (	date("m") == $month	&& date("Y") == $year && date("d") == $i ) {
        $istoday = ' today';
      } else {
        $istoday = '';
      }    
      
      
      $actkeyis=array_keys($activedays['activedays'], $i);
			if (in_array($i, $activedays['activedays'])) {

				if ($activedays['undef'][$actkeyis[0]] == "1") {
					$weeks .= "<td width=\"14%\" class=\"days".$istoday."\">$i</td>\n";
				} elseif (!$activedays['activelinks'][$actkeyis[0]] == "0") {
//days with active events in calendar in backend are now used as filter for the listing - not edit the event
//		 			$weeks .= "<td width=\"14%\" class=\"activeday".$istoday."\"><a href=\"" . cm_map_url(array('controller=events', 'edit='.$activedays['eventid'][$actkeyis[0]].''), '') . "\"\">$i</a></td>\n";
		 			$weeks .= "<td width=\"14%\" class=\"activeday".$istoday."\"><a href=\"" . cm_map_url(array('controller=events', 'calday='.$i.'&calmonth='.$month.'&calyear='.$year.''), '') . "\" onclick=\"highlight();\">$i</a></td>\n";
				} else {
				// this just fowards to the main calendar page...
//				  $weeks .= "<td width=\"14%\" class=\"activeday".$istoday."\"><a href=\"" . cm_map_url(array('controller=events', 'edit='.$activedays['eventid'][$actkeyis[0]].''), '') . "\">$i</a></td>\n";
		 			$weeks .= "<td width=\"14%\" class=\"activeday".$istoday."\"><a href=\"" . cm_map_url(array('controller=events', 'calday='.$i.'&calmonth='.$month.'&calyear='.$year.''), '') . "\" onclick=\"highlight();\">$i</a></td>\n";
        }
			} else {
		//if (	date("m") == $month	&& date("Y") == $year && $i == date("d") ) {
 				$weeks .= "<td width=\"14%\" class=\"days".$istoday."\">$i</td>\n";        
			}
			$j++;
			if ($j%7==0)
				$weeks .= "</tr>\n";
		}
		$daysleft =  7-(($daysinmonth+$startday)%7);

		if ($daysleft<7) {
			for ($i=0; $i < $daysleft+1; $i++) {
				if ($j%7==0)
					$weeks .= "<tr>\n";
				$weeks .= "<td width=\"14%\" class=\"offsetday\">&nbsp;</td>\n";
				$j++;
				if ($j%7==0)
					$weeks .= "</tr>\n";
			}
		}

		$calendar = '

  <table width="100%" border="0" cellspacing="2">
		<tr>
			<td colspan="7" align="left">
			<table width="100%" id="cmCalendarHead">
      <tr>
			  <td class="cmCalendarLeftButton" onclick="changeCalendar.changeto(\'curr\','.$previousmonth.','.$previousyear.')">&lt;</td>
  			<td align="center" class="cmCalendarMonth"><div onclick="changeCalendar.changeto(\'mt\','.$month.','.$year.')">
  			' . $thisMonth . ' ' .$thisYear . '</div>
  			</td>
  			<td align="right" class="cmCalendarRightButton" onclick="changeCalendar.changeto(\'curr\','.$nextmonth.','.$nextyear.')">&gt;</td>
  		</tr>
      </table>
  		</td>
  	</tr>
		';
		
		$days = array("mon", "tue", "wed", "thu", "fri", "sat", "sun" );
		$calendar .= "<tr>\n";
    for ($i=0; $i<7; $i++) {
			$calendar .= "<td class=\"dayname\">" . substr($this->langInfo[$days[$i]], 0, 1) . "</td>\n";
		}
		$calendar .= "</tr>\n";
		$calendar .= $weeks;
		$calendar .= "</table>\n";

		return $calendar;
	}

}


// Module/Plug-in cmCalendar cp class
class ModuleCmCalendarCp {

  var $plugin_cmcalendar = array();
  var $plugin_cmcalendar_active = array();  //[artid][array active cals in this article]
  var $plugin_cmcalendar_cals = array(); //all calendars
  var $plugin_articlelist = array();
  var $plugin_cplist = array();
  var $plugin_cals = array(); //all calendars

  //get the calendars
	function cmcalendar_get_cals() {
    $sql = "SELECT * FROM ".DB_PREPEND."phpwcms_cmcalendar_categories";
    $plugin_calsresult =  _dbQuery($sql);
    $this->plugin_cmcalendar_cals = $plugin_calsresult;
      foreach($plugin_calsresult as $row) {
        $this->plugin_cals[$row['cm_cat_id']] = $row;
      }
  }

  //get the cals(ID) of calendars selected in any contentparts in any articles only when eventlisting
  //and set the $plugin_cmcalendar_active
  //it's not super perfect cause more or less the same thing is done in the standard search yet
	function cmcalendar_get_articles() {

 		$sql  = "SELECT article_id, article_cid, article_uid, article_title, article_username, ";
		$sql .= "article_aktiv, article_public, UNIX_TIMESTAMP(article_tstamp) AS article_date, ac.acat_id, ac.acat_name, ac.acat_aktiv, ac.acat_public, ac.acat_hidden, ac.acat_regonly  ";
		$sql .= "FROM ".DB_PREPEND."phpwcms_article ar ";
		$sql .= "LEFT JOIN ".DB_PREPEND."phpwcms_articlecat ac ON ";
		$sql .= "(ar.article_cid = ac.acat_id OR ar.article_cid = 0)";
		$sql .= " WHERE ";
		//limit to special structure IDs if not all
//		if(count($content["search"]["start_at"])) {
//			$sql .= 'ar.article_cid IN ('.implode(',', $content["search"]["start_at"]).')';
//		} else {
//			$sql .= "IF(ar.article_cid = 0, " . (empty($GLOBALS['indexpage']['acat_nosearch']) ? 1 : 0) .", 1)";
//		}
//		$sql .= "ac.acat_aktiv=1 AND ac.acat_public=1 AND ";
//		if(!FEUSER_LOGIN_STATUS) {
//			$sql .= "ac.acat_regonly=0 AND ";
//		}
//		$sql .= "ar.article_public=1 AND ar.article_aktiv=1 AND ar.article_deleted=0 AND ar.article_nosearch!=1 AND ";
		$sql .= "ar.article_deleted=0 AND ";
		// enhanced IF statement by kh 2008/12/03
		$sql .= "IF((ar.article_begin < NOW() AND ar.article_end > NOW()) OR (ar.article_archive_status=1 AND ac.acat_archive=1), 1, 0) ";
		$sql .= "GROUP BY ar.article_id";
  	$plugin_sresult = _dbQuery($sql);
    $this->plugin_articlelist = $plugin_sresult;
      foreach($plugin_sresult as $row) {
				// read article content for update
//			$cm_art_sql  = "SELECT acontent_id, acontent_aid, acontent_title, acontent_type, acontent_form, acontent_tstamp, acontent_visible FROM ";
				$cm_art_sql  = "SELECT * FROM ";
				$cm_art_sql .= DB_PREPEND."phpwcms_articlecontent WHERE acontent_aid=".$row["article_id"]." ";
				$cm_art_sql .= "AND acontent_module='br_cm_calendar' ";
//				$cm_art_sql .= "AND acontent_visible=1 AND acontent_trash=0 AND ";
				$cm_art_sql .= "AND acontent_trash=0 AND ";
//				if( !FEUSER_LOGIN_STATUS ) {
//					$cm_art_sql .= 'acontent_granted=0 AND ';
//				}
				$cm_art_sql .= "acontent_type = 30";
  	    $plugin_cplist = _dbQuery($cm_art_sql);

          foreach ($plugin_cplist as $artrow) {
            $artrow["artdata"] = $row;
            $artrow['acontent_form'] = @unserialize($artrow['acontent_form']);
            $this->plugin_cplist[$artrow['acontent_id']] = $artrow;
if ($artrow['acontent_form']['cals'] == '') $artrow['acontent_form']['cals'] = array();  //compatibilty to V1.0
              $plugin_cmcalendar_art = array();
                 foreach($this->plugin_cmcalendar_cals as $value_cal) {
                  if (in_array($value_cal['cm_cat_id'], $artrow['acontent_form']['cals'])){
                    array_push($plugin_cmcalendar_art, $value_cal['cm_cat_id']);
                  }
                 }
              $this->plugin_cmcalendar_active[$artrow['acontent_aid']] =  $plugin_cmcalendar_art;
          }
      }
  }

}
?>