<?php
/*************************************************************************************

  Copyright notice

  cmCalendar Module v1 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2009
  cmCalendar Module v1.2 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2012

  License: GNU General Public License version 2, or (at your option) any later version
  This script is a module for PHPWCMS.

   (c) 2002-2012 Oliver Georgi (oliver@phpwcms.de) // All rights reserved.

*************************************************************************************/

// load general configuration
$path = dirname(dirname(dirname(realpath(dirname(__FILE__)))));
$phpwcms = array();
require_once ($path.'/include/config/conf.inc.php');
require_once ($path.'/include/inc_lib/default.inc.php');
require_once ($path.'/include/inc_lib/general.inc.php');
require_once ($path.'/include/inc_lib/dbcon.inc.php');
include ($path.'/include/inc_module/mod_cm_calendar/inc/calendar.classes.php');
define('MODULE_HREF', 'phpwcms.php?do=modules&amp;module=br_cm_calendar');
include ($path.'/include/inc_module/mod_cm_calendar/inc/cm.functions.inc.php');

// Get parameters from URL
$mode = isset($_POST["mode"]) ? clean_slweg($_POST["mode"]) : 'curr';
$category = isset($_POST["cal"]) ? intval($_POST["cal"]) : 0;
$radius = isset($_POST["name"]) ? intval($_POST["name"]) : 0;
$month = isset($_POST["month"]) ? intval($_POST["month"]) : 1;
$year = isset($_POST["yr"]) ? intval($_POST["yr"]) : 2010;
$currlang = isset($_POST["lng"]) ? clean_slweg($_POST["lng"]) : 'en';

  //init obj
  $cal = new cmCalendar;
  // set the language acc to browser language
  $cal->setLanguageBackend($currlang);

switch ($mode) {
  default:
  $html = $cal->make_calendar($month, $year, $category );	//it's always just 1 category in backend or 0
	break;
	
	case 'curr':
  $html = $cal->make_calendar($month, $year, $category );
  break;
	case 'mt':
    $html ='';
    $html .= '<table width="100%" id="cmMiniCalMonthTable">
     <tr>
      <td colspan="4" class="cmMiniCalMonthTitle" onclick="changeCalendar.changeto(\'yr\','.$month.','.$year.')">'.$year.'</td>
     </tr>
     <tr>
      <td width="25%" class="cmMiniCalMonth'; if ($month==1) $html .= ' cmMiniCalMonthActual'; $html .= '" onclick="changeCalendar.changeto(\'curr\',1,'.$year.')">'.substr($cal->langInfo['jan'], 0, 3).'</td>
      <td width="25%" class="cmMiniCalMonth'; if ($month==2) $html .= ' cmMiniCalMonthActual'; $html .= '" onclick="changeCalendar.changeto(\'curr\',2,'.$year.')">'.substr($cal->langInfo['feb'], 0, 3).'</td>
      <td width="25%" class="cmMiniCalMonth'; if ($month==3) $html .= ' cmMiniCalMonthActual'; $html .= '" onclick="changeCalendar.changeto(\'curr\',3,'.$year.')">'.substr($cal->langInfo['mar'], 0, 3).'</td>
      <td width="25%" class="cmMiniCalMonth'; if ($month==4) $html .= ' cmMiniCalMonthActual'; $html .= '" onclick="changeCalendar.changeto(\'curr\',4,'.$year.')">'.substr($cal->langInfo['apr'], 0, 3).'</td>
     </tr>
      <tr>
      <td width="25%" class="cmMiniCalMonth'; if ($month==5) $html .= ' cmMiniCalMonthActual'; $html .= '" onclick="changeCalendar.changeto(\'curr\',5,'.$year.')">'.substr($cal->langInfo['may'], 0, 3).'</td>
      <td width="25%" class="cmMiniCalMonth'; if ($month==6) $html .= ' cmMiniCalMonthActual'; $html .= '" onclick="changeCalendar.changeto(\'curr\',6,'.$year.')">'.substr($cal->langInfo['jun'], 0, 3).'</td>
      <td width="25%" class="cmMiniCalMonth'; if ($month==7) $html .= ' cmMiniCalMonthActual'; $html .= '" onclick="changeCalendar.changeto(\'curr\',7,'.$year.')">'.substr($cal->langInfo['jul'], 0, 3).'</td>
      <td width="25%" class="cmMiniCalMonth'; if ($month==8) $html .= ' cmMiniCalMonthActual'; $html .= '" onclick="changeCalendar.changeto(\'curr\',8,'.$year.')">'.substr($cal->langInfo['aug'], 0, 3).'</td>
     </tr>
      <tr>
      <td width="25%" class="cmMiniCalMonth'; if ($month==9) $html .= ' cmMiniCalMonthActual'; $html .= '" onclick="changeCalendar.changeto(\'curr\',9,'.$year.')">'.substr($cal->langInfo['sep'], 0, 3).'</td>
      <td width="25%" class="cmMiniCalMonth'; if ($month==10) $html .= ' cmMiniCalMonthActual'; $html .= '" onclick="changeCalendar.changeto(\'curr\',10,'.$year.')">'.substr($cal->langInfo['oct'], 0, 3).'</td>
      <td width="25%" class="cmMiniCalMonth'; if ($month==11) $html .= ' cmMiniCalMonthActual'; $html .= '" onclick="changeCalendar.changeto(\'curr\',11,'.$year.')">'.substr($cal->langInfo['nov'], 0, 3).'</td>
      <td width="25%" class="cmMiniCalMonth'; if ($month==12) $html .= ' cmMiniCalMonthActual'; $html .= '" onclick="changeCalendar.changeto(\'curr\',12,'.$year.')">'.substr($cal->langInfo['dec'], 0, 3).'</td>
     </tr>
    </table>
    '; 	
  break;
	case 'yr':
    $html ='';
    $html .= '<table width="100%" id="cmMiniCalYearTable">
     <tr>
      <td colspan="4" class="cmMiniCalYearTitle">'.intval($year-5).' - '.intval($year+6).'</td>
     </tr>
     <tr>
      <td width="25%" class="cmMiniCalYear" onclick="changeCalendar.changeto(\'mt\','.$month.','.intval($year-5).')">'.intval($year-5).'</td>
      <td width="25%" class="cmMiniCalYear" onclick="changeCalendar.changeto(\'mt\','.$month.','.intval($year-4).')">'.intval($year-4).'</td>
      <td width="25%" class="cmMiniCalYear" onclick="changeCalendar.changeto(\'mt\','.$month.','.intval($year-3).')">'.intval($year-3).'</td>
      <td width="25%" class="cmMiniCalYear" onclick="changeCalendar.changeto(\'mt\','.$month.','.intval($year-2).')">'.intval($year-2).'</td>
     </tr>
      <tr>
      <td width="25%" class="cmMiniCalYear" onclick="changeCalendar.changeto(\'mt\','.$month.','.intval($year-1).')">'.intval($year-1).'</td>
      <td width="25%" class="cmMiniCalYear cmMiniCalMonthActual" onclick="changeCalendar.changeto(\'mt\','.$month.','.$year.')">'.$year.'</td>
      <td width="25%" class="cmMiniCalYear" onclick="changeCalendar.changeto(\'mt\','.$month.','.intval($year+1).')">'.intval($year+1).'</td>
      <td width="25%" class="cmMiniCalYear" onclick="changeCalendar.changeto(\'mt\','.$month.','.intval($year+2).')">'.intval($year+2).'</td>
     </tr>
      <tr>
      <td width="25%" class="cmMiniCalYear" onclick="changeCalendar.changeto(\'mt\','.$month.','.intval($year+3).')">'.intval($year+3).'</td>
      <td width="25%" class="cmMiniCalYear" onclick="changeCalendar.changeto(\'mt\','.$month.','.intval($year+4).')">'.intval($year+4).'</td>
      <td width="25%" class="cmMiniCalYear" onclick="changeCalendar.changeto(\'mt\','.$month.','.intval($year+5).')">'.intval($year+5).'</td>
      <td width="25%" class="cmMiniCalYear" onclick="changeCalendar.changeto(\'mt\','.$month.','.intval($year+6).')">'.intval($year+6).'</td>
     </tr>
    </table> 
    '; 	
  break;
}

echo $html;
?>