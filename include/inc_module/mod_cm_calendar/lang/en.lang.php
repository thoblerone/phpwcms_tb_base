<?php
/*************************************************************************************

  Copyright notice

  cmCalendar Module v1 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2009
  cmCalendar Module v1.2 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2012

  License: GNU General Public License version 2, or (at your option) any later version
  This script is a module for PHPWCMS.

   (c) 2002-2012 Oliver Georgi (oliver@phpwcms.de) // All rights reserved.

*************************************************************************************/
//English

// first define main language vars
$BLM['backend_menu']		     	= 'cmCalendar';

//module section
$BLM['listing_title']			    = 'cmCalendar';
//tabs
$BLM['tab_cal']	              = 'Calendar';
$BLM['tab_events']	          = 'Events';
$BLM['tab_cp']	              = 'Overview';
$BLM['tab_lang']	            = 'Language';
$BLM['tab_about']	            = '?';

//cal

$BLM['delete_entry']          = 'delete';
$BLM['create_new_cal']        = 'add new calendar';


$BLM['cm_cal']                = 'calendar';
$BLM['cal_name']              = 'calendar';

//events

$BLM['delete_entry']          = 'delete';
$BLM['delete_entryset']       = 'delete set';
$BLM['create_new_events']     = 'add new event';
$BLM['show_olddates']         = 'old dates';

$BLM['cm_events']             = 'event';
$BLM['events_name']           = 'event';
$BLM['entry_date']            = 'date';
$BLM['entry_time']            = 'time';
$BLM['entry_span']            = 'span';
$BLM['entry_title']           = 'title';
$BLM['entry_location']        = 'location';
$BLM['entry_descr']           = 'description';
$BLM['entry_artlnk']          = 'link to article';
$BLM['entry_cal']             = 'calendar';
$BLM['entry_dateformat']      = 'd.m.Y';
$BLM['entry_opendate']        = 'date open';
$BLM['entry_opendate1']       = '(temporary date required! span only 1! display: e.g. \'in october\')';
$BLM['entry_multi']           ='CTRL + Click for multiple selection';
$BLM['entry_seedescr']        = 'description preview';
$BLM['entry_incal1']          = 'in';
$BLM['entry_incal2']          = 'calendars';
$BLM['sheduleOptions']        ='scheduling options';
$BLM['singleEvent']           = 'single event';
$BLM['singleEvent_instruct']  = 'does not repeat.';
$BLM['weekly']                = 'daily';
$BLM['weekly_instruct']       = 'every';
$BLM['weekly_instruct2']       = 'days (7 for 1 week) until';
$BLM['monthly']               = 'monthly';
$BLM['monthly_instructWeekday'] = 'by weekday until<br />(ie. "every 2nd tuesday")';
$BLM['monthly_instructDate']  = 'by date until<br />(ie. "every 5th of the month")';
$BLM['entry_set']             = 'set';
$BLM['teaser_txt']            = 'Teaser';
$BLM['entry_uid']             = 'Event Owner';

//cp
$BLM['cm_cp_update']          ='update';
$BLM['cm_cp_nofile']          ='no content part for plugin cmCalendar found';
$BLM['cm_cp_actcals']         ='active calendars:';
$BLM['cm_cp_nosel']           ='no selection';
$BLM['delete_entry']          ='delete_entry';
$BLM['cm_cp_rss']             ='show feed';
$BLM['cm_cp_title']           ='Overview for calendar content parts in the website';

//language
$BLM['create_new_lang']       = 'new frontend language';
$BLM['cm_lang_lang']          = 'language';
//edit
$BLM['lang_name']             = 'language';
$BLM['lang_sys']              = 'miles/km';
$BLM['lang_cale']             = 'calendar';
$BLM['lang_date']             = 'date';
$BLM['lang_span']             = 'daysspan';
$BLM['lang_span_exmpl']       = 'example: duration # days';
$BLM['lang_titl']             = 'title';
$BLM['lang_time']             = 'time';
$BLM['lang_loca']             = 'location';
$BLM['lang_desc']             = 'description';
$BLM['lang_noen']             = 'no entries found';
$BLM['lang_noca']             = 'no calendar found';
$BLM['lang_dateformat']       = 'date format';
$BLM['lang_prnt']             = 'print';
$BLM['lang_ical']             = 'iCalendar';
$BLM['lang_artl']             = 'article link';
$BLM['lang_slct']             = 'selection';
$BLM['lang_undf']             = 'undefined date';
$BLM['lang_undf_exmpl']       = 'example: in #(replaced by month)';

$BLM['lang_slct_all']         = 'all';
$BLM['lang_slct_am']          = 'actual month';
$BLM['lang_slct_ay']          = 'actual year';
$BLM['lang_slct_nm']          = 'next month';
$BLM['lang_slct_nm_exmpl']    = 'example: next # month';
$BLM['lang_slct_ny']          = 'next year';
$BLM['lang_slct_ny_exmpl']    = 'example: next # year';
$BLM['lang_slct_lm']          = 'last month';
$BLM['lang_slct_lm_exmpl']    = 'example: last # month';

// language pack titles
$BLM['lang_jan']               = "January";
$BLM['lang_feb']               = "February";
$BLM['lang_mar']               = "March";
$BLM['lang_apr']               = "April";
$BLM['lang_may']               = "May";
$BLM['lang_jun']               = "June";
$BLM['lang_jul']               = "July";
$BLM['lang_aug']               = "August";
$BLM['lang_sep']               = "September";
$BLM['lang_oct']               = "October";
$BLM['lang_nov']               = "November";
$BLM['lang_dec']               = "December";

$BLM['lang_mon']               = "Monday";
$BLM['lang_tue']               = "Tuesday";
$BLM['lang_wed']               = "Wednesday";
$BLM['lang_thu']               = "Thursday";
$BLM['lang_fri']               = "Friday";
$BLM['lang_sat']               = "Saturday";
$BLM['lang_sun']               = "Sunday";

$BLM['lang_exist']             = "Language already exists!";
$BLM['delete_lang']            = "Delete language: ";

//cp
$BLM['lang_calselect']         = 'select calendar...';
$BLM['template']               = 'template';
$BLM['tpl']                    = 'event listing';
$BLM['cm_selection']           = 'selection';
$BLM['cm_selection2']          = 'use [ALL][NEXT][ACTUAL][LAST][MONTH][YEAR][DEFAULT]<br />example:<br />[ALL][DEFAULT]<br />[ACTUAL][MONTH]<br />[NEXT][3][MONTH]<br />[LAST][2][MONTH]';
$BLM['cal_view']               = 'calendar view';
$BLM['cal_rt_1']               = 'replacement tag for the calendar view is {CM_CALENDAR}<br />You can use it in your template, but the current content part must be included in that page.';
$BLM['cal_rt_2']               = 'To use it anywhere in your templates place the current content part in a hidden structure and use replacement tag';
$BLM['cal_rt_3']               = 'Placing of more than one calendars can be handled with CSS';
$BLM['cal_rt_css']             = 'CSS file';
$BLM['cal_rt_opt']             = 'options';
$BLM['cm_calrt_artlnk']        = 'activate article links';
$BLM['cm_calrt_firstday']      = 'first day of week';
$BLM['cm_calrt_ajax']          = 'activate AJAX';
$BLM['eventlist_print']        = 'print listing';
$BLM['eventlist_print1']       = 'enable print link';
$BLM['eventlist_print_img']    = 'image';
$BLM['eventlist_ical']         = 'ICalendar';
$BLM['eventlist_ical1']        = 'enable ICal link';
$BLM['eventlist_ical_img']     = 'image';
$BLM['cm_calrt_actdays']       = 'active days link to';
$BLM['eventlist_sort']         = 'sort direction';
$BLM['eventlist_asc']          = 'ascending';
$BLM['eventlist_desc']         = 'descending';
$BLM['no_art']                 = 'no article';
$BLM['teaser']                 = 'teaser listing';
$BLM['teaser_lnk']             = 'teaser links to';
$BLM['teaser_anz1']            = 'next';
$BLM['teaser_anz2']            = 'events';
$BLM['teaser_rt']              = 'replacement tag';
$BLM['teaser_anchor']          = 'jump to anchor';
$BLM['cm_calrt_anchor']        = 'jump to anchor';
$BLM['eventlist_start']        = 'start with';
$BLM['eventlist_startdate1']   = 'actual month/year';
$BLM['eventlist_startdate2']   = 'actual day';
$BLM['cal_rt_img_leftbut']     = 'left button';
$BLM['cal_rt_img_rightbut']    = 'right button';
$BLM['disabled']               = 'disabled';
$BLM['page_mini_cal']          = 'only month view';
$BLM['page_mini_cal2']         = 'enable this option if only the actual month or the selected month in the mini calendar should be displayed, in case no selection according to the listing above is active';
$BLM['calrt_showmonth']        = 'show';
$BLM['calrt_numbermonth']      = 'month';

$BLM['cm_rss_activate'] = 'activate';
$BLM['cm_rss_feed'] = 'RSS Feed';
$BLM['cm_rss_todelete'] = 'go here to delete';
$BLM['cm_rss_title'] = 'title';
$BLM['cm_rss_descr'] = 'description';
$BLM['cm_rss_number'] = 'number of feeds';
$BLM['cm_rss_fileex'] = 'file does not exist (yet)';

/*-- start ajax  --*/
$BLM['cal_rt_images']          = 'links';
$BLM['cal_rt_img_backlink']    = 'back link';
$BLM['cal_rt_img_listinglink'] = 'link to listing';
$BLM['cm_calrt_ajax_expl']     = 'opens active days in a detailview within the mini calendar. Links to listing and articles are displayed in the detailview. The template for the detailview is ajax_day.tmpl in the template/cntpart directory.';
$BLM['cm_calrt_ajax_txt']      = 'use';
$BLM['cm_calrt_ajax_txt1']     = 'teaser text';
$BLM['cm_calrt_ajax_txt2']     = 'description text';
$BLM['cm_calrt_ajax_daydig']   = 'number of digits in daynames';
/*-- end ajax  --*/

//overall use
$BLM['filtered_list']          = 'filtered list';
$BLM['show_all']               = 'show all';
$BLM['delete_entry']           = 'delete calendar entry:';
$BLM['no_entry']               = 'no entries found';
$BLM['delete']                 = 'delete';

?>