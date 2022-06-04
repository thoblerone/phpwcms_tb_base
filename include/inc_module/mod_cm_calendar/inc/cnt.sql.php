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


// cmCalendar module content part SQL UPDATE/INSERT 
// usage:
// SQL .= "acontent_field = '".aporeplace($value)."', ";

if(isset($content['cm_calendar']) && is_array($content['cm_calendar'])) {

	$SQL .= "acontent_form = '".aporeplace(serialize($content['cm_calendar']))."'";

}

?>
