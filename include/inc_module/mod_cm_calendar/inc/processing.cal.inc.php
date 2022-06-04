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

// check if form should be closed only -> and back to listing mode
if( isset($_POST['close']) ) {
	headerRedirect( cm_map_url('controller=cal', '') );
}
if(isset($_GET['edit'])) {
	$cm['cm_cat_id']		= intval($_GET['edit']);
} else {
	$cm['cm_cat_id']		= 0;
}

if(isset($_POST['cm_cat_name'])) {

  $plugin['data'] = array(
  	'cm_cat_id' => intval($_POST['cm_cat_id']),
  	'cm_cat_changed'	=> date('Y-m-d H:i:s'),
  	'cm_cat_name'		=> clean_slweg($_POST['cm_cat_name']),
  	'cm_cat_status'		=> empty($_POST['cm_cat_status']) ? 0 : 1
	);
	
	if(empty($plugin['data']['cm_cat_name'])) {
		$plugin['error']['cm_cat_name'] = 1;
	}
		
		if( empty($plugin['error'] )) {
		
			// Update
			if( $plugin['data']['cm_cat_id'] ) {
				$sql  = 'UPDATE '.DB_PREPEND.'phpwcms_cmcalendar_categories SET ';
				$sql .= "cm_cat_changed = '".aporeplace( $plugin['data']['cm_cat_changed'])."', ";
				$sql .= "cm_cat_name = '".aporeplace($plugin['data']['cm_cat_name'])."', ";
				$sql .= "cm_cat_status = ".$plugin['data']['cm_cat_status']." ";
				$sql .= "WHERE cm_cat_id = " . $plugin['data']['cm_cat_id'];				
				_dbQuery($sql, 'UPDATE');
			
			// INSERT
			} else {
				$sql  = 'INSERT INTO '.DB_PREPEND.'phpwcms_cmcalendar_categories (';
				$sql .= 'cm_cat_created,cm_cat_changed,cm_cat_status,cm_cat_name';
				$sql .= ') VALUES (';
				$sql .= "'".aporeplace( $plugin['data']['cm_cat_changed'] )."', ";			
				$sql .= "'".aporeplace( $plugin['data']['cm_cat_changed'] )."', ";
				$sql .= $plugin['data']['cm_cat_status'].", ";
				$sql .= "'".aporeplace($plugin['data']['cm_cat_name'])."' ";
				$sql .= ')';
				$result = _dbQuery($sql, 'INSERT');
				
				if( !empty($result['INSERT_ID']) ) {
					$plugin['data']['cm_cat_id']	= $result['INSERT_ID'];
				}

			}

			// save and back to listing mode
			if( isset($_POST['save']) ) {
				headerRedirect( cm_map_url('controller=cal', '') );
			} else {
				headerRedirect( cm_map_url( array('controller=cal', 'edit='.$plugin['data']['cm_cat_id']), '') );
			}	

		}
}
	
// try to read entry from database
if($cm['cm_cat_id'] && !isset($plugin['error'])) {

		$sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_cmcalendar_categories WHERE ';
		$sql .= "cm_cat_id = " . $cm['cm_cat_id'] . ' LIMIT 1';
		$plugin['data'] = _dbQuery($sql);
		
		if( isset($plugin['data'][0]) ) {
			$plugin['data'] = $plugin['data'][0];
			$plugin['data']['cm_cat_changed'] = strtotime($plugin['data']['cm_cat_changed']);
		} else {
			headerRedirect( cm_map_url('controller=cal', '') );
		}

}

if($action == 'status') {
  $plugin['data'] = array();
	list($plugin['data']['cm_cat_id'], $plugin['data']['cm_cat_status']) = explode( '-', $_GET['verify'] );
	$plugin['data']['cm_cat_id']		= intval($plugin['data']['cm_cat_id']);
	$plugin['data']['cm_cat_status']	= empty($plugin['data']['cm_cat_status']) ? 1 : 0;
}

if($action == 'delete') {
  $plugin['data'] = array();
	$plugin['data']['cm_cat_del'] = intval($_GET['delete']);
}


// default values
if(empty($plugin['data'])) {

	$plugin['data'] = array(
	  'cm_cat_id' => 0,
    'cm_cat_created'	=> '',
    'cm_cat_changed'	=> date('Y-m-d H:i:s'),
  	'cm_cat_name'		=> '',
  	'cm_cat_status'		=> 0
	);
}



?>