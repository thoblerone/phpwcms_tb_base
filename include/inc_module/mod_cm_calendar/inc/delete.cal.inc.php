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
		$sql  = 'UPDATE '.DB_PREPEND.'phpwcms_cmcalendar_categories SET ';
		$sql .= "cm_cat_status=9 WHERE cm_cat_id=".$plugin['data']['cm_cat_del'];
		_dbQuery($sql, 'UPDATE');

    //delete category in events
    $sql  = 'SELECT cm_events_id, cm_events_allcals FROM '.DB_PREPEND.'phpwcms_cmcalendar_events';
    $data = _dbQuery($sql);
		foreach($data as $value){
      if ($value['cm_events_allcals']) {
        $value['cm_events_allcals'] = explode('|',trim($value['cm_events_allcals'], '|'));      
    		$calarray = array();
        foreach($value['cm_events_allcals'] as $val){
          if ($val != $plugin['data']['cm_cat_del']) {
            array_push($calarray, $val);
          }
        }
       if (count($calarray)>0) {
       $value['cm_events_allcals'] = '|'.implode('|', $calarray).'|';       
       } else {
       $value['cm_events_allcals'] = '';
       }
   
    	 $sql  = 'UPDATE '.DB_PREPEND.'phpwcms_cmcalendar_events SET ';
    	 $sql .= "cm_events_allcals='".$value['cm_events_allcals']."' WHERE cm_events_id=".$value['cm_events_id'];
    	 _dbQuery($sql, 'UPDATE');
      }
    }

	  headerRedirect( cm_map_url('controller=cal', '') );
?>