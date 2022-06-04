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

	// delete
	
	if( $_GET['delete'] == 1 ) {
				$plugin['error']['cm_lang_del'] = 'Language english can not be deleted';
	      headerRedirect( cm_map_url('controller=lang', '') );
  }
	
		$sql  = 'DELETE FROM '.DB_PREPEND.'phpwcms_cmcalendar_language ';
		$sql .= "WHERE cm_lang_id=".intval($_GET['delete'])." LIMIT 1";
		_dbQuery($sql, 'DELETE');

	  headerRedirect(decode_entities(cm_map_url('controller=lang')));

?>