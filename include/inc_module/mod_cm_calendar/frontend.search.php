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


// Module/Plug-in cmCalendar - include in frontend search

// include search specific functions and class
require_once($phpwcms['modules'][$key]['path'].'inc/frontend.search.inc.php');
require_once($phpwcms['modules'][$key]['path'].'inc/cm.functions.inc.php');
// initialize shop module search class
$s_module = new ModuleCmCalendarSearch();
$s_module->cmcalendar_get_cals();
$s_module->cmcalendar_get_articles();

// set current search result counter
$s_module->search_result_entry		= $s_run;
$s_module->search_words				= $content["search_word"];
$s_module->search_highlight			= $content['search']['highlight_result'];
$s_module->search_highlight_words	= $content['highlight'];
$s_module->search_wordlimit			= $content['search']['wordlimit'];
$s_module->ellipse_sign				= $template_default['ellipse_sign'];
$s_module->search();

// add module search results
$s_list += $s_module->search_results;

// get back final search result counter
$s_run = $s_module->search_result_entry;
?>