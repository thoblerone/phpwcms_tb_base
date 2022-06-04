<?php
/*************************************************************************************

  Copyright notice

  cmCalendar Module v1 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2009
  cmCalendar Module v1.2 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2012

  License: GNU General Public License version 2, or (at your option) any later version
  This script is a module for PHPWCMS.

   (c) 2002-2012 Oliver Georgi (oliver@phpwcms.de) // All rights reserved.

*************************************************************************************/

// ----------------------------------------------------------------
// obligate check for phpwcms constants
if (!defined('PHPWCMS_ROOT')) {
   die("You Cannot Access This Script Directly, Have a Nice Day.");
}
// ----------------------------------------------------------------

// cmCalendar module content part frontend article rendering

// if you want to access module vars check that var
// $phpwcms['modules'][$crow["acontent_module"]]

include_once($phpwcms['modules'][$crow['acontent_module']]['path'].'inc/cm.functions.inc.php');

//initvars
$plugin = array();

//the browser language from loc_lang
//$plugin["loc_lang"] = cm_detect_lang(); //returns the local settings or default 'en-us'
$plugin["currlang"] = cm_detect_lang(); //more secure function in V1.2

//get data from phpwcms content part
$content['cm_calendar'] = array();
$content['cm_calendar'] = @unserialize($crow["acontent_form"]);
/*
$content['cm_calendar']
$content['cm_calendar']['cals']
$content['cm_calendar']['eventlist'] = 1;
$content['cm_calendar']['cm_calrt'] = 0;
$content['cm_calendar']['teaserlist'] = 0;

eventlisting values
$content['cm_calendar']['template'] = '';
$content['cm_calendar']['eventlist_css'] = 1;
$content['cm_calendar']['cm_selection'] = array();
$content['cm_calendar']['page_mini_cal'] = 0;
$content['cm_calendar']['eventlist_startdate'] = 1;
$content['cm_calendar']['eventlist_asc'] = 1;
$content['cm_calendar']['eventlist_print'] = 0;
$content['cm_calendar']['eventlist_print_img'] = '0.gif';
$content['cm_calendar']['eventlist_ical'] = 0;
$content['cm_calendar']['eventlist_ical_img'] = '0.gif';
$content['cm_calendar']['cm_rss_active']= 0;
$content['cm_calendar']['cm_rss_title'] = '';
$content['cm_calendar']['cm_rss_descr'] = '';
$content['cm_calendar']['cm_rss_number'] = '';

teaserlisting values
$content['cm_calendar']['teaser_anz'] = 3;
$content['cm_calendar']['teaser_tpl'] = '';
$content['cm_calendar']['teaser_css'] = '';
$content['cm_calendar']['teaser_asc'] = 1;
$content['cm_calendar']['teaser_lnk'] = 0;
$content['cm_calendar']['cm_teaser_article'] = 0;
$content['cm_calendar']['teaser_anchor'] = 0;

calendar view values
$content['cm_calendar']['calrt_number'] = 1;
$content['cm_calendar']['calrt_css'] = '';
$content['cm_calendar']['cm_calrt_artlnk'] = 0;
$content['cm_calendar']['cm_calrt_actdays'] = 0;
$content['cm_calendar']['cm_events_article'] = 0;
$content['cm_calendar']['cm_calrt_anchor'] = 0;
$content['cm_calendar']['cm_calrt_firstday'] = 1;
$content['cm_calendar']['cal_rt_img_leftbut'] = '0.gif';
$content['cm_calendar']['cal_rt_img_rightbut'] = '0.gif';

$content['cm_calendar']['cm_calrt_ajax'] = 0;
$content['cm_calendar']['cm_calrt_ajax_txt'] = 1;
$content['cm_calendar']['cm_calrt_ajax_daydig'] = 1;
$content['cm_calendar']['cal_rt_img_backlink'] = '0.gif';
$content['cm_calendar']['cal_rt_img_listinglink'] = '0.gif';
*/

//clear the values for selected frontend
switch ($content['cm_calendar']['eventlist']) {
  case 3 :
    $content['cm_calendar']['template'] = '';
    $content['cm_calendar']['eventlist_css'] = 1;
//    $content['cm_calendar']['cm_selection'] = array();
    $content['cm_calendar']['cm_selection'] = '';
    $content['cm_calendar']['page_mini_cal'] = 0;
    $content['cm_calendar']['eventlist_startdate'] = 1;
    $content['cm_calendar']['eventlist_asc'] = 1;
    $content['cm_calendar']['eventlist_print'] = 0;
    $content['cm_calendar']['eventlist_print_img'] = '0.gif';
    $content['cm_calendar']['eventlist_ical'] = 0;
    $content['cm_calendar']['eventlist_ical_img'] = '0.gif';
    $content['cm_calendar']['cm_rss_active']= 0;
    $content['cm_calendar']['cm_rss_title'] = '';
    $content['cm_calendar']['cm_rss_descr'] = '';
    $content['cm_calendar']['cm_rss_number'] = '';
    $content['cm_calendar']['teaser_anz'] = 3;
    $content['cm_calendar']['teaser_tpl'] = '';
    $content['cm_calendar']['teaser_css'] = '';
    $content['cm_calendar']['teaser_asc'] = 1;
    $content['cm_calendar']['teaser_lnk'] = 0;
    $content['cm_calendar']['cm_teaser_article'] = 0;
    $content['cm_calendar']['teaser_anchor'] = 0;
  	break;

  case 2 :
    $content['cm_calendar']['template'] = '';
    $content['cm_calendar']['eventlist_css'] = 1;
//    $content['cm_calendar']['cm_selection'] = array();
    $content['cm_calendar']['cm_selection'] = '';
    $content['cm_calendar']['page_mini_cal'] = 0;
    $content['cm_calendar']['eventlist_startdate'] = 1;
    $content['cm_calendar']['eventlist_asc'] = 1;
    $content['cm_calendar']['eventlist_print'] = 0;
    $content['cm_calendar']['eventlist_print_img'] = '0.gif';
    $content['cm_calendar']['eventlist_ical'] = 0;
    $content['cm_calendar']['eventlist_ical_img'] = '0.gif';
    $content['cm_calendar']['cm_rss_active']= 0;
    $content['cm_calendar']['cm_rss_title'] = '';
    $content['cm_calendar']['cm_rss_descr'] = '';
    $content['cm_calendar']['cm_rss_number'] = '';
    $content['cm_calendar']['calrt_number'] = 1;
    $content['cm_calendar']['calrt_css'] = '';
    $content['cm_calendar']['cm_calrt_artlnk'] = 0;
    $content['cm_calendar']['cm_calrt_actdays'] = 0;
    $content['cm_calendar']['cm_events_article'] = 0;
    $content['cm_calendar']['cm_calrt_anchor'] = 0;
    $content['cm_calendar']['cm_calrt_firstday'] = 1;
    $content['cm_calendar']['cal_rt_img_leftbut'] = '0.gif';
    $content['cm_calendar']['cal_rt_img_rightbut'] = '0.gif';
    $content['cm_calendar']['cm_calrt_ajax'] = 0;
    $content['cm_calendar']['cm_calrt_ajax_txt'] = 1;
    $content['cm_calendar']['cm_calrt_ajax_daydig'] = 1;
    $content['cm_calendar']['cal_rt_img_backlink'] = '0.gif';
    $content['cm_calendar']['cal_rt_img_listinglink'] = '0.gif';
  	break;

  default:
    $content['cm_calendar']['teaser_anz'] = 3;
    $content['cm_calendar']['teaser_tpl'] = '';
    $content['cm_calendar']['teaser_css'] = '';
    $content['cm_calendar']['teaser_asc'] = 1;
    $content['cm_calendar']['teaser_lnk'] = 0;
    $content['cm_calendar']['cm_teaser_article'] = 0;
    $content['cm_calendar']['teaser_anchor'] = 0;
    $content['cm_calendar']['calrt_number'] = 1;
    $content['cm_calendar']['calrt_css'] = '';
    $content['cm_calendar']['cm_calrt_artlnk'] = 0;
    $content['cm_calendar']['cm_calrt_actdays'] = 0;
    $content['cm_calendar']['cm_events_article'] = 0;
    $content['cm_calendar']['cm_calrt_anchor'] = 0;
    $content['cm_calendar']['cm_calrt_firstday'] = 1;
    $content['cm_calendar']['cal_rt_img_leftbut'] = '0.gif';
    $content['cm_calendar']['cal_rt_img_rightbut'] = '0.gif';
    $content['cm_calendar']['cm_calrt_ajax'] = 0;
    $content['cm_calendar']['cm_calrt_ajax_txt'] = 1;
    $content['cm_calendar']['cm_calrt_ajax_daydig'] = 1;
    $content['cm_calendar']['cal_rt_img_backlink'] = '0.gif';
    $content['cm_calendar']['cal_rt_img_listinglink'] = '0.gif';
  	break;
}


  include_once($phpwcms['modules'][$crow['acontent_module']]['path'].'inc/calendar.frontend.classes.php');
if ($content['cm_calendar']['cm_calrt_ajax']==1) {
  include_once($phpwcms['modules'][$crow['acontent_module']]['path'].'inc/calendar.frontend.ajax.classes.php');
  $cal = new cmCalendarAjax;
} else {

  $cal = new cmCalendar;
}

if ($content['cm_calendar']['cals'] == '') $content['cm_calendar']['cals'] = array();  //compatibilty to V1.0

if (!empty($content['cm_calendar']['cals'])) {



  //init obj
//  $cal = new cmCalendar;
  // set the language acc to browser language
  $cal->setLanguageFrontend($plugin["currlang"]);
  //set options
  $cal->setFirstDOW( $content['cm_calendar']['cm_calrt_firstday'] );
  $cal->articlellinkActive( $content['cm_calendar']['cm_calrt_artlnk'] );
  $cal->activeDaysLink( $content['cm_calendar']['cm_events_article'] );
  $cal->activeDay( $content['cm_calendar']['cm_calrt_actdays'] );
  $cal->setModuleDir( $phpwcms['modules'][$crow['acontent_module']]['dir'] );
  $cal->setLeftBut( $content['cm_calendar']['cal_rt_img_leftbut'] );
  $cal->setRightBut( $content['cm_calendar']['cal_rt_img_rightbut'] );


 //open reference to header block
  $plugin["head"] = & $GLOBALS['block']['custom_htmlhead'];


  $plugin["calendars"] = array();
  //deleted AND disabled calendars should not be shown - they might be in the acontent_form still
  $plugin["calendars"]["sql"] = "SELECT * FROM ".DB_PREPEND."phpwcms_cmcalendar_categories WHERE cm_cat_status=1";
  $plugin["calendars"]["data"] = _dbQuery($plugin["calendars"]["sql"]);
  $plugin["calendars"]["active"] = array();
   foreach($plugin["calendars"]["data"] as $value_cal) {
    if (in_array($value_cal['cm_cat_id'], $content['cm_calendar']['cals'])){
      array_push($plugin["calendars"]["active"], $value_cal['cm_cat_id']);
    }
   }


  //POST and GET and SESSION
  if (!isset($_POST["cmmonth"]) || !$_POST["cmmonth"]) {
    if 	(!isset($_GET['cmmonth']) || !$_GET['cmmonth']) {
      if 	(!isset($_SESSION['cm_calendar']['month'])) {
    		$plugin["postvars"]["month"] = date("n", mktime());
    		$plugin["postvars"]["date"] = "none";
      } else {
        $plugin["postvars"]["month"] = intval($_SESSION['cm_calendar']['month']);
    		$plugin["postvars"]["date"] = "none";
      }
    } else {
  		$plugin["postvars"]["month"] = intval($_GET['cmmonth']);
  		$plugin["postvars"]["date"] = intval(isset($_GET['cmdate'])? $_GET['cmdate']: 1);
      $_SESSION['cm_calendar']['month'] = intval($_GET['cmmonth']);
  	}
  } else {
  	$plugin["postvars"]["month"] = intval($_POST["cmmonth"]);
  	$plugin["postvars"]["date"] = "none"; // no specific date, list all for that month
    $_SESSION['cm_calendar']['month'] = intval($_POST["cmmonth"]);
  }

  if (!isset($_POST["cmyear"]) || !$_POST["cmyear"]) {
  	if(!isset($_GET["cmyear"]) || !$_GET["cmyear"]) {
      if 	(!isset($_SESSION['cm_calendar']['year'])) {
    		$plugin["postvars"]["year"] = date("Y", mktime());
      } else {
        $plugin["postvars"]["year"] = intval($_SESSION['cm_calendar']['year']);
      }
  	} else {
  		$plugin["postvars"]["year"] = intval($_GET['cmyear']);
      $_SESSION['cm_calendar']['year'] = intval($_GET['cmyear']);
  	}
  } else {
  	$plugin["postvars"]["year"] = intval($_POST['cmyear']);
    $_SESSION['cm_calendar']['year'] = intval($_POST['cmyear']);
  }


  //the current year
  $plugin["year"] = date("Y");


switch ($content['cm_calendar']['eventlist']) {
//evenlisting
case 1 :

  //session for selection dropdown (when calendar changes)
  // ^(all|actual|next|last)?-?\d*?-?(month|year)?$
  $plugin["postvars"]["cm_sortby"] = '';
  if ( isset($_SESSION['cm_calendar']['selection']) && !isset($_POST['cm_sortby']) ) {
    $plugin["postvars"]["cm_sortby"] = $_SESSION['cm_calendar']['selection'];
  } else if ( isset($_POST['cm_sortby']) ) {
    if (preg_match('/^(all|actual|next|last)?-?\d*?-?(month|year)?$/i',$_POST['cm_sortby'])) {
      $plugin["postvars"]["cm_sortby"] = clean_slweg($_POST["cm_sortby"]);
      $_SESSION['cm_calendar']['selection'] = $plugin["postvars"]["cm_sortby"];
    }
  }

  //include rss
  if($content['cm_calendar']['cm_rss_active']== 1 ){
    $plugin["head"]["cmCalendarFeed"] = '<link rel="alternate" type="application/rss+xml" title="Feed Calendar phpwcms" href="'.PHPWCMS_URL.'content/rss/feed-calendar-'.$crow["acontent_aid"].'-'.$crow['acontent_id'].'.xml" />';
  }


  //selection drop down
  $plugin["cm_selection"]["unserialized"] = array();
 //$plugin["cm_selection"]["unserialized"]	= @unserialize(clean_slweg($content['cm_calendar']['cm_selection']));
  if ($content['cm_calendar']['cm_selection'] != "") {
    $content['cm_calendar']['cm_selection'] = explode(LF, $content['cm_calendar']['cm_selection']);
    foreach ($content['cm_calendar']['cm_selection'] as $value){
      $value = trim($value);
/* TSF Mod by Thomas Blenkers TB START*/
//      if (preg_match('/^(\[all\]|\[actual\]|\[next\]|\[last\])?(\[\d*?\])?(\[month\]|\[year\])?(\[default\])?$/i',$value)) {
      if (preg_match('/^(\[all\]|\[actual\]|\[next\]|\[last\])?(\[\d*?\])?(\[day\]|\[month\]|\[year\])?(\[default\])?$/i',$value)) {
/* TSF Mod by Thomas Blenkers TB ENDE*/
        $plugin["cm_selection"]["unserialized"][] = $value;
      }
    }
  }
 

  $dowehaveselecction = false;
  $plugin["cm_selection"]["sql"] = "";
  if (count($plugin["cm_selection"]["unserialized"])){
    $plugin["cm_selection"]["opt_list"]  = '';
    foreach ($plugin["cm_selection"]["unserialized"] as $key=>$value) {

    //[ALL][NEXT][ACTUAL][MONTH][YEAR][DEFAULT]
      $actualvalue = "";
      if (!(strpos($value, '[ALL]') === false) ) {
          if ( (strpos($value, '[DEFAULT]') && ($plugin["postvars"]["cm_sortby"] == '')) || ($plugin["postvars"]["cm_sortby"]=='all') ) {
            $actualvalue = ' selected="selected"';
            if ($content['cm_calendar']['eventlist_startdate'] == 2) {
      				$plugin["cm_selection"]["sql"] = " AND (cm_events_date) >= (CURDATE())";
            } else {
              $plugin["cm_selection"]["sql"] = " AND ( (cm_events_date) >= (CURDATE()) OR ( (MONTH(cm_events_date)) >= (MONTH(CURDATE())) AND " .
    							"(YEAR(cm_events_date)) = (".$plugin['year'].") ) )";
            }
                  //"(YEAR(cm_events_date)) <= (".$plugin['year'].") AND " .
    							//"(YEAR(DATE_ADD(cm_events_date, INTERVAL(cm_events_span - 1) DAY))) >= (".$plugin['year'].") ";
          }
          $plugin["cm_selection"]["opt_list"]  .= '	<option value="all"';
          if ($actualvalue) {
            $plugin["cm_selection"]["opt_list"]  .= $actualvalue;
          }
    			$plugin["cm_selection"]["opt_list"] .= '>'.htmlspecialchars($cal->langInfo['cm_lang_slct_all']);
          $plugin["cm_selection"]["opt_list"] .= '</option>'.LF;

      continue;
      }

      if (!(strpos($value, '[ACTUAL]') === false) ) {
        if (!(strpos($value, '[MONTH]') === false) ) {
          if ( (strpos($value, '[DEFAULT]') && ($plugin["postvars"]["cm_sortby"] == '')) || ($plugin["postvars"]["cm_sortby"]=='actual-month') ) {
            $actualvalue = ' selected="selected"';
            $dowehaveselecction = true;
            if ($content['cm_calendar']['eventlist_startdate'] == 2) {
              $plugin["cm_selection"]["sql"] = " AND (cm_events_date) >= (CURDATE()) AND (MONTH(cm_events_date)) = (MONTH(CURDATE())) AND " .
    							"(YEAR(cm_events_date)) = (".$plugin['year'].")";
            } else {
              $plugin["cm_selection"]["sql"] = " AND (MONTH(cm_events_date)) = (MONTH(CURDATE())) AND " .
    							"(YEAR(cm_events_date)) = (".$plugin['year'].")";
            }
          }
          $plugin["cm_selection"]["opt_list"]  .= '	<option value="actual-month"';
          if ($actualvalue) {
            $plugin["cm_selection"]["opt_list"]  .= $actualvalue;
          }
    			$plugin["cm_selection"]["opt_list"] .= '>'.htmlspecialchars($cal->langInfo['cm_lang_slct_am']);
          $plugin["cm_selection"]["opt_list"] .= '</option>'.LF;

        } else if (!(strpos($value, '[YEAR]') === false) ) {
          if ( (strpos($value, '[DEFAULT]') && ($plugin["postvars"]["cm_sortby"] == '')) || ($plugin["postvars"]["cm_sortby"]=='actual-year') ) {
            $actualvalue = ' selected="selected"';
            $dowehaveselecction = true;
            if ($content['cm_calendar']['eventlist_startdate'] == 2) {
              $plugin["cm_selection"]["sql"] = " AND (cm_events_date) >= (CURDATE()) AND (YEAR(cm_events_date)) = (".$plugin['year'].")";
            } else {
    				  $plugin["cm_selection"]["sql"] = " AND (YEAR(cm_events_date)) = (".$plugin['year'].")";
            }
          }
          $plugin["cm_selection"]["opt_list"]  .= '	<option value="actual-year"';
          if ($actualvalue) {
            $plugin["cm_selection"]["opt_list"]  .= $actualvalue;
          }
    			$plugin["cm_selection"]["opt_list"] .= '>'.htmlspecialchars($cal->langInfo['cm_lang_slct_ay']);
          $plugin["cm_selection"]["opt_list"] .= '</option>'.LF;

        }
      continue;
      }

      if (!(strpos($value, '[LAST]') === false) ) {
        $zeichenkette = $value;
        $suchmuster = '/\[(\d{1,2})\]/';
        preg_match($suchmuster, $zeichenkette, $treffer);
        if ($treffer[1] < 1) $treffer[1] = 1;
        if (!(strpos($value, '[MONTH]') === false) ) {
          if ( (strpos($value, '[DEFAULT]') && ($plugin["postvars"]["cm_sortby"] == '')) || ($plugin["postvars"]["cm_sortby"]=='last-'.$treffer[1].'-month') ) {
            $actualvalue = ' selected="selected"';
            $dowehaveselecction = true;
            if ($content['cm_calendar']['eventlist_startdate'] == 2) {
      				$plugin["cm_selection"]["sql"] = " AND (cm_events_date) <= (CURDATE()) AND (cm_events_date) > (DATE_ADD(CURDATE(), INTERVAL -".$treffer[1]." MONTH))";
            } else {
              $plugin["cm_selection"]["sql"] = " AND ( ( (MONTH(cm_events_date)) = (MONTH(CURDATE())) AND (YEAR(cm_events_date)) = (".$plugin['year'].") ) OR " .
    							"( (cm_events_date) <= (CURDATE()) AND (cm_events_date) > (DATE_ADD(CURDATE(), INTERVAL -".$treffer[1]." MONTH)) ) )";
            }
          }
          $plugin["cm_selection"]["opt_list"]  .= '	<option value="last-'.$treffer[1].'-month"';
          if ($actualvalue) {
            $plugin["cm_selection"]["opt_list"]  .= $actualvalue;
          }
          $langstr = $cal->langInfo['cm_lang_slct_lm'];
          $langpattern = '/\#+?/';
          $langrepl = $treffer[1];
          $langstrrepl = preg_replace($langpattern, $langrepl, $langstr);
          $plugin["cm_selection"]["opt_list"] .= '>'.htmlspecialchars($langstrrepl);
          $plugin["cm_selection"]["opt_list"] .= '</option>'.LF;
        }
      continue;
      }

      if (!(strpos($value, '[NEXT]') === false) ) {
        $zeichenkette = $value;
        $suchmuster = '/\[(\d{1,2})\]/';
        preg_match($suchmuster, $zeichenkette, $treffer);
        if ($treffer[1] < 1) $treffer[1] = 1;
        if (!(strpos($value, '[MONTH]') === false) ) {
          if ( (strpos($value, '[DEFAULT]') && ($plugin["postvars"]["cm_sortby"] == '')) || ($plugin["postvars"]["cm_sortby"]=='next-'.$treffer[1].'-month') ) {
            $dowehaveselecction = true;
            $actualvalue = ' selected="selected"';
            if ($content['cm_calendar']['eventlist_startdate'] == 2) {
      				$plugin["cm_selection"]["sql"] = " AND (cm_events_date) >= (CURDATE()) AND " .
    							"(cm_events_date) < (DATE_ADD(CURDATE(), INTERVAL ".$treffer[1]." MONTH))";
            } else {
              $plugin["cm_selection"]["sql"] = " AND ( ( (MONTH(cm_events_date)) = (MONTH(CURDATE())) AND (YEAR(cm_events_date)) = (".$plugin['year'].") ) OR " .
    							"( (cm_events_date) >= (CURDATE()) AND (cm_events_date) < (DATE_ADD(CURDATE(), INTERVAL ".$treffer[1]." MONTH)) ) )";
            }
          }
          $plugin["cm_selection"]["opt_list"]  .= '	<option value="next-'.$treffer[1].'-month"';
          if ($actualvalue) {
            $plugin["cm_selection"]["opt_list"]  .= $actualvalue;
          }
          $langstr = $cal->langInfo['cm_lang_slct_nm'];
          $langpattern = '/\#+?/';
          $langrepl = $treffer[1];
          $langstrrepl = preg_replace($langpattern, $langrepl, $langstr);
          $plugin["cm_selection"]["opt_list"] .= '>'.htmlspecialchars($langstrrepl);
          $plugin["cm_selection"]["opt_list"] .= '</option>'.LF;
        } else if (!(strpos($value, '[YEAR]') === false) ) {
          if ( (strpos($value, '[DEFAULT]') && ($plugin["postvars"]["cm_sortby"] == '')) || ($plugin["postvars"]["cm_sortby"]=='next-'.$treffer[1].'-year') ) {
            $actualvalue = ' selected="selected"';
            $dowehaveselecction = true;
            if ($content['cm_calendar']['eventlist_startdate'] == 2) {
    				$plugin["cm_selection"]["sql"] = " AND (cm_events_date) >= (CURDATE()) AND " .
    							"(cm_events_date) < (DATE_ADD(CURDATE(), INTERVAL ".$treffer[1]." YEAR))";
            } else {
              $plugin["cm_selection"]["sql"] = " AND ( ( (MONTH(cm_events_date)) = (MONTH(CURDATE())) AND (YEAR(cm_events_date)) = (".$plugin['year'].") ) OR " .
    							"( (cm_events_date) >= (CURDATE()) AND (cm_events_date) < (DATE_ADD(CURDATE(), INTERVAL ".$treffer[1]." YEAR)) ) )";
            }
          }
          $plugin["cm_selection"]["opt_list"]  .= '	<option value="next-'.$treffer[1].'-year"';
          if ($actualvalue) {
            $plugin["cm_selection"]["opt_list"]  .= $actualvalue;
          }
          $langstr = $cal->langInfo['cm_lang_slct_ny'];
          $langpattern = '/\#+?/';
          $langrepl = $treffer[1];
          $langstrrepl = preg_replace($langpattern, $langrepl, $langstr);
    			$plugin["cm_selection"]["opt_list"] .= '>'.htmlspecialchars($langstrrepl);
          $plugin["cm_selection"]["opt_list"] .= '</option>'.LF;
        }
/* TSF Mod by Thomas Blenkers TB START*/
		else if (!(strpos($value, '[DAY]') === false) ) { // TB Day selection
		
          if ( (strpos($value, '[DEFAULT]') && ($plugin["postvars"]["cm_sortby"] == '')) || ($plugin["postvars"]["cm_sortby"]=='next-'.$treffer[1].'-day') ) {
            $actualvalue = ' selected="selected"';
            $dowehaveselecction = true;
            if ($content['cm_calendar']['eventlist_startdate'] == 2) {
    				$plugin["cm_selection"]["sql"] = " AND (cm_events_date) >= (CURDATE()) AND " .
    							"(cm_events_date) < (DATE_ADD(CURDATE(), INTERVAL ".$treffer[1]." DAY))";
            } else {
              $plugin["cm_selection"]["sql"] = " AND ( ( (MONTH(cm_events_date)) = (MONTH(CURDATE())) AND (YEAR(cm_events_date)) = ($year) ) OR " .
    							"( (cm_events_date) >= (CURDATE()) AND (cm_events_date) < (DATE_ADD(CURDATE(), INTERVAL ".$treffer[1]." DAY)) ) )";
            }
          }
          $plugin["cm_selection"]["opt_list"]  .= '	<option value="next-'.$treffer[1].'-day"';
          if ($actualvalue) {
            $plugin["cm_selection"]["opt_list"]  .= $actualvalue;
          }
          // TB $langstr = $cal->langInfo['cm_lang_slct_nd'];
          $langstr = "kommende # Tage"; 
          $langpattern = '/\#+?/';
          $langrepl = $treffer[1];
          $langstrrepl = preg_replace($langpattern, $langrepl, $langstr);
    			$plugin["cm_selection"]["opt_list"] .= '>'.htmlspecialchars($langstrrepl);
          $plugin["cm_selection"]["opt_list"] .= '</option>'.LF;
        }
/* TSF Mod by Thomas Blenkers TB ENDE*/
      continue;
      }
    }
    //write the select drop down
    $plugin["cm_selection"]["output"] = '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" name="ca">
    <select name="cm_sortby" id="cm_sortby" class="cmCalListingDropdown" onchange="this.form.submit();">'.$plugin["cm_selection"]["opt_list"].'</select>
    </form>';
    $plugin["cm_selection"]["translated_selection"] = $cal->langInfo['cm_lang_slct']; //selection expression
  } else {
    //no selection drop down
    if ($content['cm_calendar']['eventlist_startdate'] == 2) {
			$plugin["cm_selection"]["sql"] = " AND (cm_events_date) >= (CURDATE())";
    } else {
      $plugin["cm_selection"]["sql"] = " AND ( (cm_events_date) >= (CURDATE()) OR ( (MONTH(cm_events_date)) >= (MONTH(CURDATE())) AND " .
					"(YEAR(cm_events_date)) = (".$plugin['year'].") ) )";
    }
    $plugin["cm_selection"]["output"] = '';
    $plugin["cm_selection"]["translated_selection"] = ''; //selection expression
  }

  //css file listing
  if (is_file($phpwcms['modules'][$crow['acontent_module']]['dir'].'template/css/'.$content['cm_calendar']['eventlist_css'])) {
    $plugin["head"]['cm_calendar_listing_css'] = '<link href="'.$phpwcms['modules'][$crow['acontent_module']]['dir'].'template/css/'.$content['cm_calendar']['eventlist_css'].'" rel="stylesheet" type="text/css" />';
  }

  // read template listing
    if(empty($content['cm_calendar']['template']) && is_file($phpwcms['modules'][$crow['acontent_module']]['dir'].'template/cntpart/default.tmpl')) {
    	$content['cm_calendar']['template']	= @file_get_contents($phpwcms['modules'][$crow['acontent_module']]['dir'].'template/cntpart/default.tmpl');
    } elseif(is_file($phpwcms['modules'][$crow['acontent_module']]['dir'].'template/cntpart/'.$content['cm_calendar']['template'])) {
    	$content['cm_calendar']['template']	= @file_get_contents($phpwcms['modules'][$crow['acontent_module']]['dir'].'template/cntpart/'.$content['cm_calendar']["template"]);
    } else {

    $content['cm_calendar']['template']	= '
    <!--CALENDAR_LIST_ENTRY_START//-->

    	<div class="cmCalListingEntry">
        <div class="cmCalListingDate">
          <div style="position:absolute;font-size:40px;font-weight:bold;color:#969696;">{FORMAT_DATE:j}</div>
          <div style="position:absolute;bottom:5px;">{FORMAT_DATE:l}<br />[CALENDAR_DATE]{CALENDAR_DATE}[/CALENDAR_DATE]</div>
        </div>
      	<div class="cmCalListingDetail">
        	[CALENDAR_ICAL]<div class="cmCalListingiCal">{CALENDAR_ICAL}</div>[/CALENDAR_ICAL]
          [CALENDAR_TITLE]<h2>[LANG_TITLE]{LANG_TITLE}: [/LANG_TITLE]{CALENDAR_TITLE}</h2>[/CALENDAR_TITLE]
        	[CALENDAR_TIME]<br />[LANG_TIME]{LANG_TIME}: [/LANG_TIME]{CALENDAR_TIME}[/CALENDAR_TIME][CALENDAR_SPAN] - {CALENDAR_SPAN}[/CALENDAR_SPAN]
        	[CALENDAR_LOCATION]<br />[LANG_LOCATION]{LANG_LOCATION}: [/LANG_LOCATION]{CALENDAR_LOCATION}[/CALENDAR_LOCATION]
        	[CALENDAR_DESCRIPTION]<br />[LANG_DESCRIPTION]{LANG_DESCRIPTION}: [/LANG_DESCRIPTION]{CALENDAR_DESCRIPTION}[/CALENDAR_DESCRIPTION]
        		[IMAGE]
    		[ZOOM_ELSE]
    			[IMAGE_URL]<a href="{IMAGE_URL}"{IMAGE_URL_TARGET}>[/IMAGE_URL]
    				<img src="img/cmsimage.php/150x150x1/{IMAGE_ID}" alt="{IMAGE}" border="0" />
    			[IMAGE_URL]</a>[/IMAGE_URL]
    			[CAPTION]<p>{CAPTION}</p>[/CAPTION]
    		[/ZOOM_ELSE]
    		[ZOOM]
    			<a href="img/cmsimage.php/600x400/{IMAGE_ID}" target="_blank"{LIGHTBOX}[LIGHTBOX_CAPTION] title="{LIGHTBOX_CAPTION}"[/LIGHTBOX_CAPTION]>
    				<img src="img/cmsimage.php/100x100x1/{IMAGE_ID}" alt="{IMAGE}" border="0" />
    			</a>
    		[/ZOOM]
    	[/IMAGE]
          [CALENDAR_ARTICLELINK]<br>{CALENDAR_ARTICLELINK}[/CALENDAR_ARTICLELINK]
        </div>
    	</div>

    <!--CALENDAR_LIST_ENTRY_END//-->

    <!--CALENDAR_LIST_ENTRY_SPACE_START//-->

    	<!-- space between CALENDAR items -->
    	<div class="cmCalListingSpace"></div>

    <!--CALENDAR_LIST_ENTRY_SPACE_END//-->

    <!--CALENDAR_LIST_TOP_START//-->

      <div class="cmCalListing">
        <div class="cmCalListingHead">
          <div style="float:left;">{PRINT_LINK} {ICAL_LINK}</div>
          <div style="float:right;">  [LANG_SELECTION]{LANG_SELECTION}:[/LANG_SELECTION] {SELECTION_DROPDOWN}</div>
          <div style="clear:left;"></div>
        </div>
    [CALENDAR_ENTRIES]{CALENDAR_ENTRIES}[/CALENDAR_ENTRIES]

    <!--CALENDAR_LIST_TOP_END//-->

    <!--CALENDAR_LIST_BOTTOM_START//-->

      </div>
      <div style="clear:both;"></div>

    <!--CALENDAR_LIST_BOTTOM_END//-->
    ';
    }


  //should the mini calendar rule?
  if  (($content['cm_calendar']['page_mini_cal'] == 1) && ($dowehaveselecction == false)  ) {
    //overwrite auswahl - month/year from minicalendar active now
            if ($content['cm_calendar']['eventlist_startdate'] == 2) {
              $plugin["cm_selection"]["sql"] = " AND (cm_events_date) >= (CURDATE()) AND (MONTH(cm_events_date)) = (".$plugin['postvars']['month'].") AND " .
    							"(YEAR(cm_events_date)) = (".$plugin['postvars']['year'].")";
            } else {
              $plugin["cm_selection"]["sql"] = " AND (MONTH(cm_events_date)) = (".$plugin['postvars']['month'].") AND " .
    							"(YEAR(cm_events_date)) = (".$plugin['postvars']['year'].")";
            }
  }


  //render entries listing
    $plugin["eventlisting"] = array();
    $plugin["calsarray"] = array();
  //prepare sql for different calendars
    foreach($plugin["calendars"]["active"] as $value) {
  		$plugin["calsarray"][] = "cm_events_allcals LIKE '%|".intval($value)."|%'";
  	}

  		$plugin["wherequery"] = (count($plugin["calsarray"])) ? " AND (".implode(' OR ', $plugin["calsarray"]).")" : " AND cm_events_allcals = 'default'"; //or never true

  //get the values from db
    $plugin["eventlisting"]["sql"]  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_cmcalendar_events WHERE ';
  	$plugin["eventlisting"]["sql"] .= "cm_events_status = 1";
  	$plugin["eventlisting"]["sql"] .= $plugin["wherequery"].$plugin["cm_selection"]["sql"];
  	$plugin["eventlisting"]["sql"] .= " ORDER BY cm_events_date";
  	($content['cm_calendar']['eventlist_asc'] ==  2) ? $plugin["eventlisting"]["sql"] .= ' DESC' : $plugin["eventlisting"]["sql"] .= ' ASC';
    $plugin["eventlisting"]["sql"] .= ', cm_events_time ASC'; // +KH 120110  Innerhalb des Tages nach Zeit sortiert
  	$plugin["eventlisting"]["data"] = _dbQuery($plugin["eventlisting"]["sql"]);

  /*
  	$plugin["eventlisting"]["data"]['cm_events_image']['cm_events_image_name']
  	$plugin["eventlisting"]["data"]['cm_events_image']['cm_events_image_id']
  	$plugin["eventlisting"]["data"]['cm_events_image']['cm_events_image_link']
  	$plugin["eventlisting"]["data"]['cm_events_image']['cm_events_image_caption']
  	$plugin["eventlisting"]["data"]['cm_events_image']['cm_events_image_lightbox']
  	$plugin["eventlisting"]["data"]['cm_events_image']['cm_events_image_zoom']
  */

    //output
    $plugin["eventlisting"]["output"]		= '';
    $j = 0;
    $ids = '';
    //no entry
  	if( !isset($plugin["eventlisting"]["data"][0]) ) {
      $plugin["eventlisting"]["output"]		= $cal->langInfo['noEventNotice'];
    } else {  // entry
      foreach ($plugin["eventlisting"]["data"] as $value) {
  	    $value['cm_events_image'] = unserialize(	$value['cm_events_image']);
        $j++;
        $ids .= $value['cm_events_id'].',';

        //events section in template
        $plugin["eventlisting"]["output"] .= '<a name="jump-cal-'.$value['cm_events_id'].'"></a>';
        $plugin["eventlisting"]["output"] .= get_tmpl_section('CALENDAR_LIST_ENTRY', $content['cm_calendar']['template']);

        //title
        $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'LANG_TITLE', html_specialchars($cal->langInfo['cm_lang_titl']));
        $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'CALENDAR_TITLE', html_specialchars($value['cm_events_title']));

        //date time
        $plugin["eventlisting"]["formatdate"] = array();
        if ($value['cm_events_dat_undef']) {
    		  $plugin["eventlisting"]["formatdate"]["text"] = '{DATE:F lang='.$cal->langInfo['cm_lang_langloc'].'}';
          $plugin["eventlisting"]["formatdate"]["renderdate"] = render_date($plugin["eventlisting"]["formatdate"]["text"], strtotime($value['cm_events_date']), 'DATE');
          $plugin["eventlisting"]["formatdate"]["datestrrepl"] = preg_replace('/\#+?/', $plugin["eventlisting"]["formatdate"]["renderdate"], $cal->langInfo['cm_lang_undf']);
          $plugin["eventlisting"]["output"] = preg_replace('/\{FORMAT_DATE:(.*?)\}/e','check_specialformat ("$1","'.$cal->langInfo['cm_lang_langloc'].'","'.strtotime($value['cm_events_date']).'")', $plugin["eventlisting"]["output"]);
        } else {
    		  $plugin["eventlisting"]["formatdate"]["text"] = '{DATE:'.$cal->langInfo['cm_lang_dateformat'].' lang='.$cal->langInfo['cm_lang_langloc'].'}';
          $plugin["eventlisting"]["formatdate"]["datestrrepl"] = render_date($plugin["eventlisting"]["formatdate"]["text"], strtotime($value['cm_events_date']), 'DATE');
          $plugin["eventlisting"]["output"] = preg_replace('/\{FORMAT_DATE:(.*?)\}/e','render_date("{FORMAT_DATE:$1 lang='.$cal->langInfo['cm_lang_langloc'].'}", '.strtotime($value['cm_events_date']).', "FORMAT_DATE")', $plugin["eventlisting"]["output"]);
        }

        //special date formats
        $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'LANG_DATE', html_specialchars($cal->langInfo['cm_lang_date']));
        $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'CALENDAR_DATE', $plugin["eventlisting"]["formatdate"]["datestrrepl"]);
        $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'LANG_TIME', html_specialchars($cal->langInfo['cm_lang_time']));
        $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'CALENDAR_TIME', html_specialchars($value['cm_events_time']));
/* TSF Mod by Thomas Blenkers TB START*/
        $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'CALENDAR_ID', html_specialchars($value['cm_events_id']));
        $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'CALENDAR_USERID', html_specialchars($value['cm_events_userId']));
/* TSF Mod by Thomas Blenkers TB ENDE*/

        //span
        if ( $value['cm_events_span'] > 1 ) {
          $plugin["eventlisting"]["formatspan"] = preg_replace('/\#+?/', $value['cm_events_span'], $cal->langInfo['cm_lang_span']);
        } else {
          $plugin["eventlisting"]["formatspan"] = '';
        }
        $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'CALENDAR_SPAN', html_specialchars($plugin["eventlisting"]["formatspan"]));

        //location
        $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'LANG_LOCATION', html_specialchars($cal->langInfo['cm_lang_loca']));
        $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'CALENDAR_LOCATION', html_specialchars($value['cm_events_location']));

        //description
        $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'LANG_DESCRIPTION', html_specialchars($cal->langInfo['cm_lang_desc']));
        $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'CALENDAR_DESCRIPTION', $value['cm_events_description']);
        $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'LANG_TEASER', html_specialchars($cal->langInfo['cm_lang_desc']));
        $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'CALENDAR_TEASER', $value['cm_events_extrainfo']);


  		// Image
  		if(empty($value['cm_events_image']['cm_events_image_id'])) {
  			$plugin["eventlisting"]["output"]	= render_cnt_template($plugin["eventlisting"]["output"], 'IMAGE', '');
  			$plugin["eventlisting"]["output"]	= str_replace('{IMAGE_ID}', '', $plugin["eventlisting"]["output"]);
  		} else {
  			$plugin["eventlisting"]["output"]	= render_cnt_template($plugin["eventlisting"]["output"], 'IMAGE', html_specialchars($value['cm_events_image']['cm_events_image_name']));
  			$plugin["eventlisting"]["output"]	= str_replace('{IMAGE_ID}', $value['cm_events_image']['cm_events_image_id'], $plugin["eventlisting"]["output"]);
  		}

  		// Zoom Image
  		if(empty($value['cm_events_image']['cm_events_image_zoom'])) {
  			$plugin["eventlisting"]["output"]	= render_cnt_template($plugin["eventlisting"]["output"], 'ZOOM', '' );
  		} else {
  			$plugin["eventlisting"]["output"]	= render_cnt_template($plugin["eventlisting"]["output"], 'ZOOM', 'zoom' );
  		}
  		// Lightbox
  		if(empty($value['cm_events_image']['cm_events_image_lightbox'])) {
  			$plugin["eventlisting"]["output"]	= str_replace('{LIGHTBOX}', '', $plugin["eventlisting"]["output"]);
  		} else {
  			initializeLightbox();
  			$plugin["eventlisting"]["output"]	= str_replace('{LIGHTBOX}', ' rel="lightbox"', $plugin["eventlisting"]["output"]);
  		}
  		// Caption
  		if(empty($value['cm_events_image']['cm_events_image_caption'])) {
  			$plugin["eventlisting"]["output"]	= render_cnt_template($plugin["eventlisting"]["output"], 'CAPTION', '' );
  			$plugin["eventlisting"]["output"]	= render_cnt_template($plugin["eventlisting"]["output"], 'LIGHTBOX_CAPTION', '' );
  		} else {
  			$value['cnt_caption']	= getImageCaption($value['cm_events_image']['cm_events_image_caption'], '');
  			$plugin["eventlisting"]["output"]	= render_cnt_template($plugin["eventlisting"]["output"], 'CAPTION', html_specialchars($value['cnt_caption']['caption_text']) );
  			$plugin["eventlisting"]["output"]	= render_cnt_template($plugin["eventlisting"]["output"], 'LIGHTBOX_CAPTION', parseLightboxCaption($value['cnt_caption']['caption_text']) );
  		}

  		// Image URL
  		if(empty($value['cm_events_image']['cm_events_image_link'])) {
  			$plugin["eventlisting"]["output"]	= render_cnt_template($plugin["eventlisting"]["output"], 'IMAGE_URL', '');
  			$plugin["eventlisting"]["output"]	= str_replace('{IMAGE_URL_TARGET}', '', $plugin["eventlisting"]["output"]);

  		} else {
  			$value['image_url']		= get_redirect_link($value['cm_events_image']['cm_events_image_link'], ' ', '');
  			$plugin["eventlisting"]["output"]	= str_replace('{IMAGE_URL_TARGET}', $value['image_url']['target'], $plugin["eventlisting"]["output"]);
  			$plugin["eventlisting"]["output"]	= render_cnt_template($plugin["eventlisting"]["output"], 'IMAGE_URL', html_specialchars($value['image_url']['link']) );

  		}
  		// Check for Zoom
  		$plugin["eventlisting"]["output"]	= render_cnt_template($plugin["eventlisting"]["output"], 'ZOOM', empty($value['cm_events_image']['cm_events_image_zoom']) ? '' : 'zoom' );

        //icalendar (no print)
        if ($content['cm_calendar']['eventlist_ical']) {
          if ($content['cm_calendar']['eventlist_ical_img'] !='0.gif' && is_file($phpwcms['modules'][$crow['acontent_module']]['dir'].'template/img/'.$content['cm_calendar']['eventlist_ical_img'])) {
            $plugin["eventlisting"]["icalimage"] = '<img name="cal00'.$j.'" src="'.$phpwcms['modules'][$crow['acontent_module']]['dir'].'template/img/'.$content['cm_calendar']['eventlist_ical_img'].'" alt="iCalendar" title="iCalendar" border="0" />';
          } else {
            $plugin["eventlisting"]["icalimage"] = $cal->langInfo['cm_lang_ical'];
          }
          $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'CALENDAR_ICAL', '<a class="noprint" href="include/inc_module/mod_cm_calendar/outlook.php?id='.$value['cm_events_id'].'">'.$plugin["eventlisting"]["icalimage"].'</a>');
        } else {
          $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'CALENDAR_ICAL', '');
        }

        //articlelink (no print)

        // maybe link to news in future release
        //if ($value['cm_events_article']) $value['cm_events_article'] = '<a href="index.php?newslink=true&newsdetail='.$value['cm_events_article'].'">'.$cal->langInfo['cm_lang_artl'].'</a>';

        if ($value['cm_events_article']) $value['cm_events_article'] = '<a href="index.php?aid='.$value['cm_events_article'].'">'.$cal->langInfo['cm_lang_artl'].'</a>';
        $plugin["eventlisting"]["output"]  = render_cnt_template($plugin["eventlisting"]["output"], 'CALENDAR_ARTICLELINK', $value['cm_events_article']);
        if ($j < count($plugin["eventlisting"]["data"])) $plugin["eventlisting"]["output"] .= get_tmpl_section('CALENDAR_LIST_ENTRY_SPACE', $content['cm_calendar']['template']);

      } //end foreach
    }

    //ICalendar link (no print)
    $plugin["eventlisting"]["icalimage"] = '';
    if ($content['cm_calendar']['eventlist_ical']) {
      if ($content['cm_calendar']['eventlist_ical_img'] !='0.gif' && is_file($phpwcms['modules'][$crow['acontent_module']]['dir'].'template/img/'.$content['cm_calendar']['eventlist_ical_img'])) {
        $plugin["eventlisting"]["icalimage"] = '<a href="'.$phpwcms['modules'][$crow['acontent_module']]['dir'].'outlook.php?ids='.trim($ids, ',').'"><img src="'.$phpwcms['modules'][$crow['acontent_module']]['dir'].'template/img/'.$content['cm_calendar']['eventlist_ical_img'].'" border="0" alt="iCalendar" title="iCalendar" /></a>';
      } else { //textlink
        $plugin["eventlisting"]["icalimage"] = '<a href="'.$phpwcms['modules'][$crow['acontent_module']]['dir'].'outlook.php?ids='.trim($ids, ',').'">'.$cal->langInfo['cm_lang_ical'].'</a>';
      }
    }
    //print link
    $plugin["eventlisting"]["printlink_list"] = '';
    if ($content['cm_calendar']['eventlist_print']) {
      if ($content['cm_calendar']['eventlist_print_img'] !='0.gif' && is_file($phpwcms['modules'][$crow['acontent_module']]['dir'].'template/img/'.$content['cm_calendar']['eventlist_print_img'])) {
        $plugin["eventlisting"]["printlink_list"] = '<a href="'.$phpwcms['modules'][$crow['acontent_module']]['dir'].'frontend.listing.print.php?id='.trim($ids, ',').'&amp;lang='.$plugin["currlang"].'" target="_blank"><img src="'.$phpwcms['modules'][$crow['acontent_module']]['dir'].'template/img/'.$content['cm_calendar']['eventlist_print_img'].'" border="0" alt="print" /></a>';
      } else { //textlink
        $plugin["eventlisting"]["printlink_list"] = '<a href="'.$phpwcms['modules'][$crow['acontent_module']]['dir'].'frontend.listing.print.php?id='.trim($ids, ',').'&amp;lang='.$plugin["currlang"].'" target="_blank">'.$cal->langInfo['cm_lang_prnt'].'</a>';
      }
    }

    //container for listing
    $plugin["eventlisting"]["container"]		= '';
    $plugin["eventlisting"]["container"] .= get_tmpl_section('CALENDAR_LIST_TOP', $content['cm_calendar']['template']);
    //functions
    $plugin["eventlisting"]["container"]  = str_replace('{PRINT_LINK}', $plugin["eventlisting"]["printlink_list"], $plugin["eventlisting"]["container"]);
    $plugin["eventlisting"]["container"]  = str_replace('{ICAL_LINK}', $plugin["eventlisting"]["icalimage"], $plugin["eventlisting"]["container"]);
    $plugin["eventlisting"]["container"]  = str_replace('{SELECTION_DROPDOWN}', $plugin["cm_selection"]["output"], $plugin["eventlisting"]["container"]);
    //$plugin["eventlisting"]['container']  = str_replace('{LANG_SELECTION}', $plugin["cm_selection"]["translated_selection"], $plugin["eventlisting"]['container']);
    $plugin["eventlisting"]["container"]  = render_cnt_template($plugin["eventlisting"]["container"], 'LANG_SELECTION', $plugin["cm_selection"]["translated_selection"]);

    //enter the entries-listing
    $plugin["eventlisting"]["container"]  = render_cnt_template($plugin["eventlisting"]["container"], 'CALENDAR_ENTRIES', $plugin["eventlisting"]["output"]);

    $plugin["eventlisting"]["container"] .= get_tmpl_section('CALENDAR_LIST_BOTTOM', $content['cm_calendar']['template']);

  //return the rendered output to the main phpwcms content
    $CNT_TMP .= $plugin["eventlisting"]["container"];
//end render entries listing


	break; // end eventlisting

//teaserlisting
case 2 :

  //unset($_SESSION['cm_calendar']['selection']);

  //css file teaser
  if (is_file($phpwcms['modules'][$crow['acontent_module']]['dir'].'template/css/'.$content['cm_calendar']['teaser_css'])) {
    $plugin["head"]['cm_calendar_teaser_css'] = '<link href="'.$phpwcms['modules'][$crow['acontent_module']]['dir'].'template/css/'.$content['cm_calendar']['teaser_css'].'" rel="stylesheet" type="text/css" />';
  }

  // read template teaser
    if(empty($content['cm_calendar']['teaser_tpl']) && is_file($phpwcms['modules'][$crow['acontent_module']]['dir'].'template/cntpart/default.tmpl')) {
    	$content['cm_calendar']['teaser_tpl']	= @file_get_contents($phpwcms['modules'][$crow['acontent_module']]['dir'].'template/cntpart/default.tmpl');
    } elseif(is_file($phpwcms['modules'][$crow['acontent_module']]['dir'].'template/cntpart/'.$content['cm_calendar']['teaser_tpl'])) {
    	$content['cm_calendar']['teaser_tpl']	= @file_get_contents($phpwcms['modules'][$crow['acontent_module']]['dir'].'template/cntpart/'.$content['cm_calendar']["teaser_tpl"]);
    } else {

    $content['cm_calendar']['teaser_tpl']	= '
    <!--CALENDAR_LIST_ENTRY_START//-->

	<div class="cmCalTeaserEntry">
  	<div class="cmCalTeaserDetail">
         [CALENDAR_LINK]<a href="{CALENDAR_LINK}">[/CALENDAR_LINK]{FORMAT_DATE:l}<br />[CALENDAR_DATE]{CALENDAR_DATE}[/CALENDAR_DATE][CALENDAR_LINK]</a>[/CALENDAR_LINK]
      [CALENDAR_TITLE]<h2>[LANG_TITLE]{LANG_TITLE}: [/LANG_TITLE]{CALENDAR_TITLE}</h2>[/CALENDAR_TITLE]
    	[CALENDAR_TIME][LANG_TIME]{LANG_TIME}: [/LANG_TIME]{CALENDAR_TIME}[/CALENDAR_TIME][CALENDAR_SPAN] - {CALENDAR_SPAN}[/CALENDAR_SPAN]
    	[CALENDAR_LOCATION]<br />[LANG_LOCATION]{LANG_LOCATION}: [/LANG_LOCATION]{CALENDAR_LOCATION}[/CALENDAR_LOCATION]
    	[CALENDAR_TEASER]<br />[LANG_TEASER]{LANG_TEASER}: [/LANG_TEASER]{CALENDAR_TEASER}[/CALENDAR_TEASER]
    </div>
	</div>

    <!--CALENDAR_LIST_ENTRY_END//-->

    <!--CALENDAR_LIST_ENTRY_SPACE_START//-->

    	<!-- space between CALENDAR items -->
    	<div class="cmCalTeaserSpace"></div>

    <!--CALENDAR_LIST_ENTRY_SPACE_END//-->

    <!--CALENDAR_LIST_TOP_START//-->

  <div class="cmCalTeaser">
    [CALENDAR_ENTRIES]{CALENDAR_ENTRIES}[/CALENDAR_ENTRIES]

    <!--CALENDAR_LIST_TOP_END//-->

    <!--CALENDAR_LIST_BOTTOM_START//-->

      </div><div style="clear:both;"></div>

    <!--CALENDAR_LIST_BOTTOM_END//-->
    ';
    }


  //render teaser listing
    $plugin["teaserlisting"] = array();
    $plugin["calsarray"] = array();
  //prepare sql for different calendars
    foreach($plugin["calendars"]["active"] as $value) {
  		$plugin["calsarray"][] = "cm_events_allcals LIKE '%|".intval($value)."|%'";
  	}

  	$plugin["wherequery"] = (count($plugin["calsarray"])) ? " AND (".implode(' OR ', $plugin["calsarray"]).")" : " AND cm_events_allcals = 'default'";

  //get the values from db
    $plugin["teaserlisting"]["sql"]  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_cmcalendar_events WHERE ';
  	$plugin["teaserlisting"]["sql"] .= "cm_events_status = 1";
  	$plugin["teaserlisting"]["sql"] .= $plugin["wherequery"];
    $plugin["teaserlisting"]["sql"] .= " AND (cm_events_date) >= (CURDATE())";
  	$plugin["teaserlisting"]["sql"] .= " ORDER BY cm_events_date";
  	($content['cm_calendar']['teaser_asc'] ==  2) ? $plugin["teaserlisting"]["sql"] .= ' DESC' : $plugin["teaserlisting"]["sql"] .= ' ASC';
    if ($content['cm_calendar']['teaser_anz']) $plugin["teaserlisting"]["sql"] .= ' LIMIT '.$content['cm_calendar']['teaser_anz'];
  	$plugin["teaserlisting"]["data"] = _dbQuery($plugin["teaserlisting"]["sql"]);

    //output
    $plugin["teaserlisting"]["output"]		= '';
    $j = 0;
    $ids = '';
    //no entry
  	if( !isset($plugin["teaserlisting"]["data"][0]) ) {
      $plugin["teaserlisting"]["output"]		= $cal->langInfo['noEventNotice'];
    } else {  //single entry
      foreach ($plugin["teaserlisting"]["data"] as $value) {
        $j++;
        $plugin["teaserlisting"]["anchorlnk"] = "";
        $ids .= $value['cm_events_id'].',';

        //events section in template
        $plugin["teaserlisting"]["output"] .= get_tmpl_section('CALENDAR_LIST_ENTRY', $content['cm_calendar']['teaser_tpl']);

        //link to
        ($content['cm_calendar']['teaser_anchor'] == 1) ? $plugin["teaserlisting"]["anchorlnk"] = '&anchor=true#jump-cal-'.$value['cm_events_id'] : $plugin["teaserlisting"]["anchorlnk"] = '';
        if ($content['cm_calendar']['teaser_lnk'] && $content['cm_calendar']['cm_teaser_article'] ) {
          $value['cm_teaser_article'] = 'index.php?aid='.$content['cm_calendar']['cm_teaser_article'].$plugin["teaserlisting"]["anchorlnk"];
        } else {
          $value['cm_teaser_article'] = '';
        }
        $plugin["teaserlisting"]["output"]  = render_cnt_template($plugin["teaserlisting"]["output"], 'CALENDAR_LINK', html_specialchars($value['cm_teaser_article']));

        //title
        $plugin["teaserlisting"]["output"]  = render_cnt_template($plugin["teaserlisting"]["output"], 'LANG_TITLE', html_specialchars($cal->langInfo['cm_lang_titl']));
        $plugin["teaserlisting"]["output"]  = render_cnt_template($plugin["teaserlisting"]["output"], 'CALENDAR_TITLE', html_specialchars($value['cm_events_title']));

        //date time
        if ($value['cm_events_dat_undef']) {
    		  $plugin["teaserlisting"]["formatdate"]["text"] = '{DATE:F lang='.$cal->langInfo['cm_lang_langloc'].'}';
          $plugin["teaserlisting"]["formatdate"]["renderdate"] = render_date($plugin["teaserlisting"]["formatdate"]["text"], strtotime($value['cm_events_date']), 'DATE');
          $plugin["teaserlisting"]["formatdate"]["datestrrepl"] = preg_replace('/\#+?/', $plugin["teaserlisting"]["formatdate"]["renderdate"], $cal->langInfo['cm_lang_undf']);
          $plugin["teaserlisting"]["output"] = preg_replace('/\{FORMAT_DATE:(.*?)\}/e','check_specialformat ($1,'.$cal->langInfo['cm_lang_langloc'].','.strtotime($value['cm_events_date']).')', $plugin["teaserlisting"]["output"]);
        } else {
    		  $plugin["teaserlisting"]["formatdate"]["text"] = '{DATE:'.$cal->langInfo['cm_lang_dateformat'].' lang='.$cal->langInfo['cm_lang_langloc'].'}';
          $plugin["teaserlisting"]["formatdate"]["datestrrepl"] = render_date($plugin["teaserlisting"]["formatdate"]["text"], strtotime($value['cm_events_date']), 'DATE');
          $plugin["teaserlisting"]["output"] = preg_replace('/\{FORMAT_DATE:(.*?)\}/e','render_date("{FORMAT_DATE:$1 lang='.$cal->langInfo['cm_lang_langloc'].'}", '.strtotime($value['cm_events_date']).', "FORMAT_DATE")', $plugin["teaserlisting"]["output"]);
        }

        //special date formats
        //$plugin["teaserlisting"]["output"] = preg_replace('/\{FORMAT_DATE:(.*?)\}/e','render_date("{FORMAT_DATE:$1 lang='.$cal->langInfo['cm_lang_langloc'].'}", '.strtotime($value['cm_events_date']).', "FORMAT_DATE")', $plugin["teaserlisting"]["output"]);

        $plugin["teaserlisting"]["output"]  = render_cnt_template($plugin["teaserlisting"]["output"], 'LANG_DATE', html_specialchars($cal->langInfo['cm_lang_date']));
        $plugin["teaserlisting"]["output"]  = render_cnt_template($plugin["teaserlisting"]["output"], 'CALENDAR_DATE', $plugin["teaserlisting"]["formatdate"]["datestrrepl"]);
        $plugin["teaserlisting"]["output"]  = render_cnt_template($plugin["teaserlisting"]["output"], 'LANG_TIME', html_specialchars($cal->langInfo['cm_lang_time']));
        $plugin["teaserlisting"]["output"]  = render_cnt_template($plugin["teaserlisting"]["output"], 'CALENDAR_TIME', html_specialchars($value['cm_events_time']));

        //span
        if ( $value['cm_events_span'] > 1 ) {
          $plugin["teaserlisting"]["formatspan"] = preg_replace('/\#+?/', $value['cm_events_span'], $cal->langInfo['cm_lang_span']);
        } else {
          $plugin["teaserlisting"]["formatspan"] = '';
        }
        $plugin["teaserlisting"]["output"]  = render_cnt_template($plugin["teaserlisting"]["output"], 'CALENDAR_SPAN', html_specialchars($plugin["teaserlisting"]["formatspan"]));

        //location
        $plugin["teaserlisting"]["output"]  = render_cnt_template($plugin["teaserlisting"]["output"], 'LANG_LOCATION', html_specialchars($cal->langInfo['cm_lang_loca']));
        $plugin["teaserlisting"]["output"]  = render_cnt_template($plugin["teaserlisting"]["output"], 'CALENDAR_LOCATION', html_specialchars($value['cm_events_location']));

        //description
        $plugin["teaserlisting"]["output"]  = render_cnt_template($plugin["teaserlisting"]["output"], 'LANG_TEASER', html_specialchars($cal->langInfo['cm_lang_desc']));
        $plugin["teaserlisting"]["output"]  = render_cnt_template($plugin["teaserlisting"]["output"], 'CALENDAR_TEASER', $value['cm_events_extrainfo']);
        $plugin["teaserlisting"]["output"]  = render_cnt_template($plugin["teaserlisting"]["output"], 'LANG_DESCRIPTION', html_specialchars($cal->langInfo['cm_lang_desc']));
        $plugin["teaserlisting"]["output"]  = render_cnt_template($plugin["teaserlisting"]["output"], 'CALENDAR_DESCRIPTION', $value['cm_events_description']);


        //icalendar (no print)
        if ($content['cm_calendar']['eventlist_ical']) {
          if ($content['cm_calendar']['eventlist_ical_img'] !='0.gif' && is_file($phpwcms['modules'][$crow['acontent_module']]['dir'].'template/img/'.$content['cm_calendar']['eventlist_ical_img'])) {
            $plugin["teaserlisting"]["icalimage"] = '<img name="cal00'.$j.'" src="'.$phpwcms['modules'][$crow['acontent_module']]['dir'].'template/img/'.$content['cm_calendar']['eventlist_ical_img'].'" alt="iCalendar" title="iCalendar" border="0" />';
          } else {
            $plugin["teaserlisting"]["icalimage"] = $cal->langInfo['cm_lang_ical'];
          }
          $plugin["teaserlisting"]["output"]  = render_cnt_template($plugin["teaserlisting"]["output"], 'CALENDAR_ICAL', '<a class="noprint" href="include/inc_module/mod_cm_calendar/outlook.php?id='.$value['cm_events_id'].'">'.$plugin["teaserlisting"]["icalimage"].'</a>');
        } else {
          $plugin["teaserlisting"]["output"]  = render_cnt_template($plugin["teaserlisting"]["output"], 'CALENDAR_ICAL', '');
        }

        //articlelink (no print)
        if ($value['cm_events_article']) $value['cm_events_article'] = '<a href="index.php?aid='.$value['cm_events_article'].'">'.$cal->langInfo['cm_lang_artl'].'</a>';
        $plugin["teaserlisting"]["output"]  = render_cnt_template($plugin["teaserlisting"]["output"], 'CALENDAR_ARTICLELINK', $value['cm_events_article']);
        if ($j < count($plugin["teaserlisting"]["data"])) $plugin["teaserlisting"]["output"] .= get_tmpl_section('CALENDAR_LIST_ENTRY_SPACE', $content['cm_calendar']['template']);

      } //end foreach
    }

    //ICalendar link (no print)

    if ($content['cm_calendar']['eventlist_ical']) {
      if ($content['cm_calendar']['eventlist_ical_img'] !='0.gif' && is_file($phpwcms['modules'][$crow['acontent_module']]['dir'].'template/img/'.$content['cm_calendar']['eventlist_ical_img'])) {
        $plugin["teaserlisting"]["icalimage"] = '<a href="'.$phpwcms['modules'][$crow['acontent_module']]['dir'].'outlook.php?ids='.trim($ids, ',').'"><img src="'.$phpwcms['modules'][$crow['acontent_module']]['dir'].'template/img/'.$content['cm_calendar']['eventlist_ical_img'].'" border="0" alt="iCalendar" title="iCalendar" /></a>';
      } else { //textlink
        $plugin["teaserlisting"]["icalimage"] = '<a href="'.$phpwcms['modules'][$crow['acontent_module']]['dir'].'outlook.php?ids='.trim($ids, ',').'">'.$cal->langInfo['cm_lang_ical'].'</a>';
      }
    } else {
        $plugin["teaserlisting"]["icalimage"] = '';
    }

    //container for listing
    $plugin["teaserlisting"]["container"]		= '';
    $plugin["teaserlisting"]["container"] .= get_tmpl_section('CALENDAR_LIST_TOP', $content['cm_calendar']['teaser_tpl']);
    //functions
    $plugin["teaserlisting"]["container"]  = str_replace('{ICAL_LINK}', $plugin["teaserlisting"]["icalimage"], $plugin["teaserlisting"]["container"]);

    //enter the entries-listing
    $plugin["teaserlisting"]["container"]  = render_cnt_template($plugin["teaserlisting"]["container"], 'CALENDAR_ENTRIES', $plugin["teaserlisting"]["output"]);

    $plugin["teaserlisting"]["container"] .= get_tmpl_section('CALENDAR_LIST_BOTTOM', $content['cm_calendar']['teaser_tpl']);


  //return the rendered output to the main phpwcms content
    $CNT_TMP .= $plugin["teaserlisting"]["container"];
//end render teaser listing

	break; // end teaserlisting

//calendar view
case 3 :

  //unset($_SESSION['cm_calendar']['selection']);

  //output
  $plugin["calendarview"]["output"]		= '';

  //css file calendar
  if (is_file($phpwcms['modules'][$crow['acontent_module']]['dir'].'template/css/'.$content['cm_calendar']['calrt_css'])) {
    $plugin["head"]['cm_calendar_calrt_css'] = '<link href="'.$phpwcms['modules'][$crow['acontent_module']]['dir'].'template/css/'.$content['cm_calendar']['calrt_css'].'" rel="stylesheet" type="text/css" />';
  }

  $cal->teaserAnchorlinkActive( $content['cm_calendar']['cm_calrt_anchor'] );
  $cal->setNumberCals( $content['cm_calendar']['calrt_number'] ); //how many month to show

  //when ajax
  if ($content['cm_calendar']['cm_calrt_ajax']) {
    //js lib according template
    initJSLib();

    $cal->setLangLoc($plugin["currlang"]);
    $cal->setBackLink( $content['cm_calendar']['cal_rt_img_backlink'] );
    $cal->setListLink( $content['cm_calendar']['cal_rt_img_listinglink'] );
    $cal->setDayDigit( $content['cm_calendar']['cm_calrt_ajax_daydig'] );
    $cal->setTeaserTxt( $content['cm_calendar']['cm_calrt_ajax_txt'] );

    $plugin["calendarview"]["output"] = $cal->ajax_make_calendar($plugin["postvars"]["month"], $plugin["postvars"]["year"], $plugin["calendars"]["active"] );


    $plugin["head"]['cm_calendar_ajax'] = "<script language='javascript' type='text/javascript'>
<!--

  var ala = ".$cal->articlellinkactive.";
  var taa = ".$cal->teaseranchorlink.";
  var fdw = ".$cal->firstdayofweek.";
  var adl = ".$cal->activedayslink.";
  var ad = ".$cal->activeday.";
  var lb = '".$cal->leftbut."';
  var rb = '".$cal->rightbut."';
  var blnk = '".$cal->backlink."';
  var ll = '".$cal->listlink."';
  var dd = ".$cal->daydigit.";
  var tt = ".$cal->teasertxt.";
  var lng = '".$cal->langInfo['cm_lang_locale']."';
  var idstring = '".implode(',', $plugin["calendars"]["active"])."';
";

    if(substr($block['jslib'], 0, 6) == 'jquery') {
    //jquery
    $plugin["head"]['cm_calendar_ajax'] .= "
  var messageDelay = 300;
  function changeto(mode,month,year,day) {
    $.ajax({
      url: 'include/inc_module/mod_cm_calendar/genajax_frontend.php',
      type: 'post',
      data: 'mode='+mode+'&cal='+idstring+'&day='+day+'&lng='+lng+'&month='+month+'&yr='+year+'&ala='+ala+'&taa='+taa+'&fdw='+fdw+'&adl='+adl+'&ad='+ad+'&lb='+lb+'&rb='+rb+'&blnk='+blnk+'&ll='+ll+'&dd='+dd,
      success: submitFinished
    });
    return false;
  }
  function submitFinished( response ) {
    response = $.trim( response );
    $('#cmCalendarContainer').fadeOut(500, function(){
    $(this).html( response );
    $(this).fadeIn();
    });
  }";

    } else {
    //mootools
    $plugin["head"]['cm_calendar_ajax'] .= "
    var changeto = function(mode,month,year,day){
    var writehere = $('cmCalendarContainer');
    myChain = new Chain();
    var req = new Request({
          method: 'post',
          url: 'include/inc_module/mod_cm_calendar/genajax_frontend.php',
            onSuccess: function(htmlText)
            {
                writehere.set('tween',
                {
                    property: 'opacity',
                    duration: 300,
                    link : 'chain',
                    onComplete :
                    function()
                    {
                        myChain.callChain();
                    }
                });

                myChain.clearChain().chain
                (
                    function() { writehere.tween(0); },
                    function() { writehere.set('html', htmlText); this.callChain(); },
                    function() { writehere.tween(1); }
                ).callChain();
            }
        }).send('mode='+mode+'&cal='+idstring+'&day='+day+'&lng='+lng+'&month='+month+'&yr='+year+'&ala='+ala+'&taa='+taa+'&fdw='+fdw+'&adl='+adl+'&ad='+ad+'&lb='+lb+'&rb='+rb+'&blnk='+blnk+'&ll='+ll+'&dd='+dd);
    };
";

    }

    $plugin["head"]['cm_calendar_ajax'] .= "
//-->
</script>
";
  } else {
    //no ajax
    $plugin["calendarview"]["output"] = $cal->make_calendar($plugin["postvars"]["month"], $plugin["postvars"]["year"], $plugin["calendars"]["active"] );
  }

  // output for frontend render (frontend.render.php)
  //should not be unset!
  $content['cm_calendar_output_render'] = $plugin["calendarview"]["output"];

	break; // end calendar view

default:

  //do nothing

	break;
} //end switch


} else {
// when no calendar  selected echo message in frontend? better not
}

//clear variables content (in case this script is called several times, eventlisting and/or teaserlisting and/or calendar view)
unset($content['cm_calendar']);
unset($plugin);
?>