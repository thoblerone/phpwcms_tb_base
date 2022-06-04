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

// active/inactive

	$sql  = 'UPDATE '.DB_PREPEND.'phpwcms_cmcalendar_events SET ';
	$sql .= "cm_events_status = ".$plugin['data']['cm_events_status']." ";
	$sql .= "WHERE cm_events_setid = " . $plugin['data']['cm_events_setid'];
	
	_dbQuery($sql, 'UPDATE');

	headerRedirect( cm_map_url('controller=events', '') );

?>
