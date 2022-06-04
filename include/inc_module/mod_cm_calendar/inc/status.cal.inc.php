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
	list($plugin['data']['cm_cat_id'], $plugin['data']['cm_cat_status']) = explode( '-', $_GET['verify'] );
	$plugin['data']['cm_cat_id']		= intval($plugin['data']['cm_cat_id']);
	$plugin['data']['cm_cat_status']	= empty($plugin['data']['cm_cat_status']) ? 1 : 0;

	$sql  = 'UPDATE '.DB_PREPEND.'phpwcms_cmcalendar_categories SET ';
	$sql .= "cm_cat_status = ".$plugin['data']['cm_cat_status']." ";
	$sql .= "WHERE cm_cat_id = " . $plugin['data']['cm_cat_id'];
	
	_dbQuery($sql, 'UPDATE');

	headerRedirect( cm_map_url('controller=cal', '') );

?>
