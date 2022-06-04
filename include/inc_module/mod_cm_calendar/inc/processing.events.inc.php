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
	headerRedirect( cm_map_url('controller=events', '') );
}
// check for edit
if(isset($_GET['edit'])) {
	$cm['cm_events_id']		= intval($_GET['edit']);
} else {
	$cm['cm_events_id']		= 0; //edit = 0 => new event
}
// check for edit set
if(isset($_GET['editset'])) {
	$cm['cm_events_setid']		= intval($_GET['editset']);
} else {
	$cm['cm_events_setid']		= 0; //edit = 0 => new event
}


// cm_events_title = required field therefore used to check if we have a valid form sent 
if(isset($_POST['cm_events_title']) && $action == 'edit') {

	if(!strtotime($_POST['cm_events_date'])) {
		$plugin['error']['cm_events_date'] = 1;
	}

  $plugin['data'] = array(
      'cm_events_id' => intval($_POST['cm_events_id']),
    	'cm_events_changed'	=> date('Y-m-d H:i:s'),
      'cm_events_date' => $_POST['cm_events_date'], //date NOT NULL default '0000-00-00',
      'cm_events_span' => intval($_POST['cm_events_span']), //int(11) NOT NULL default '1',
      'cm_events_time' => clean_slweg($_POST['cm_events_time']), //varchar(100) NOT NULL default '',
      'cm_events_title' => clean_slweg($_POST['cm_events_title']), //varchar(150) NOT NULL default '',
      //'cm_events_category' => intval($_POST['cm_events_category']), //int(11) NOT NULL default '0', --not used--
      //'cm_events_image' => clean_slweg($_POST['cm_events_image']), //text NOT NULL default '',
      'cm_events_location' => clean_slweg($_POST['cm_events_location']), //varchar(100) NOT NULL default '',
      'cm_events_description' => slweg($_POST['cm_events_description']), //text NOT NULL,
      'cm_events_extrainfo' => clean_slweg($_POST['cm_events_extrainfo']), //text NOT NULL,
      //'cm_events_approved' => intval($_POST['cm_events_approved']), //tinyint(1) NOT NULL default '0', --not used--
      'cm_events_setid' => intval($_POST['cm_events_setid']), //int(11) NOT NULL default '0',
      'cm_events_userId' => intval($_POST['cm_events_userId']), //int(11) NOT NULL default '0', --used by TB mod—
      'cm_events_article' => intval($_POST['cm_events_article']), //int(11) NOT NULL default '0',  
      'cm_events_dat_undef' => empty($_POST['cm_events_dat_undef']) ? 0 : 1, //tinyint(4) NOT NULL default '0',  
      'cm_events_allcals' => empty($_POST['cm_events_allcals']) ?  "" : "|". implode('|', array_map("intval", $_POST['cm_events_allcals'])) ."|",
  	  'cm_events_status' => empty($_POST['cm_events_status']) ? 0 : 1,
  	  'daily_until'		=> empty($_POST['daily_until']) ? "" : clean_slweg($_POST['daily_until']),
  	  'monthlya_until'		=> empty($_POST['monthlya_until']) ? "" : clean_slweg($_POST['monthlya_until']),
  	  'monthlyb_until'		=> empty($_POST['monthlyb_until']) ? "" : clean_slweg($_POST['monthlyb_until']),
  	  'daily_every'		=> empty($_POST['daily_every']) ? 7 : intval($_POST['daily_every']),
  	  'schedule_type'		=> empty($_POST['schedule_type']) ? "" : clean_slweg($_POST['schedule_type'])
	);

  $plugin['data']['cm_events_image']['cm_events_image_name']	= clean_slweg($_POST['cm_events_image_name']);
  $plugin['data']['cm_events_image']['cm_events_image_id'] = intval($_POST['cm_events_image_id']);
  $plugin['data']['cm_events_image']['cm_events_image_link']	= clean_slweg($_POST['cm_events_image_link']);
  $plugin['data']['cm_events_image']['cm_events_image_caption'] = clean_slweg($_POST['cm_events_image_caption']);
  $plugin['data']['cm_events_image']['cm_events_image_lightbox'] = empty($_POST['cm_events_image_lightbox']) ? 0 : 1;
  $plugin['data']['cm_events_image']['cm_events_image_zoom'] = empty($_POST['cm_events_image_zoom']) ? 0 : 1;

// required fields	
	if(empty($plugin['data']['cm_events_title'])) {
		$plugin['error']['cm_events_title'] = 1;
		$plugin['data']['cm_events_allcals'] = empty($_POST['cm_events_allcals']) ?  array() : $_POST['cm_events_allcals'];
	}
	if(empty($plugin['data']['cm_events_date'])) {
		$plugin['error']['cm_events_date'] = 1;
		$plugin['data']['cm_events_allcals'] = empty($_POST['cm_events_allcals']) ?  array() : $_POST['cm_events_allcals'];
	}

  if ( ($plugin['data']['schedule_type']=="daily") && empty($_POST["daily_until"]) ) {
    $plugin['error']['cm_daily_until'] = 1;
		$plugin['data']['cm_events_allcals'] = empty($_POST['cm_events_allcals']) ?  array() : $_POST['cm_events_allcals'];
  }
  if ( ($plugin['data']['schedule_type']=="monthlya") && empty($_POST["monthlya_until"]) ) {
    $plugin['error']['cm_monthlya_until'] = 1;
		$plugin['data']['cm_events_allcals'] = empty($_POST['cm_events_allcals']) ?  array() : $_POST['cm_events_allcals'];
  }
  if ( ($plugin['data']['schedule_type']=="monthlyb") && empty($_POST["monthlyb_until"]) ) {
    $plugin['error']['cm_monthlyb_until'] = 1;
		$plugin['data']['cm_events_allcals'] = empty($_POST['cm_events_allcals']) ?  array() : $_POST['cm_events_allcals'];
  }

// if no errors then do db action	
	if( empty($plugin['error'] )) {
		
			// Update when cm_events_id exists (>0)
			if( $plugin['data']['cm_events_id'] ) {
				$sql  = 'UPDATE '.DB_PREPEND.'phpwcms_cmcalendar_events SET ';
				$sql .= "cm_events_changed = '".aporeplace( $plugin['data']['cm_events_changed'])."', ";
				$sql .= "cm_events_date = '".$plugin['data']['cm_events_date']."', ";
				$sql .= "cm_events_span = '".$plugin['data']['cm_events_span']."', ";
				$sql .= "cm_events_time = '".aporeplace( $plugin['data']['cm_events_time'])."', ";
				$sql .= "cm_events_title = '".aporeplace( $plugin['data']['cm_events_title'])."', ";
				//$sql .= "cm_events_category = '".$plugin['data']['cm_events_category'].", ";
				$sql .= "cm_events_image = '".aporeplace( serialize($plugin['data']['cm_events_image']))."', ";
				$sql .= "cm_events_location = '".aporeplace( $plugin['data']['cm_events_location'])."', ";
				$sql .= "cm_events_description = '".aporeplace( $plugin['data']['cm_events_description'])."', ";
				$sql .= "cm_events_extrainfo = '".aporeplace( $plugin['data']['cm_events_extrainfo'])."', ";
				//$sql .= "cm_events_approved = '".$plugin['data']['cm_events_approved'].", ";
				$sql .= "cm_events_setid = '".$plugin['data']['cm_events_setid']."', ";
				$sql .= "cm_events_userId = '".$plugin['data']['cm_events_userId']."', ";
				$sql .= "cm_events_article = '".$plugin['data']['cm_events_article']."', ";
				$sql .= "cm_events_dat_undef = '".$plugin['data']['cm_events_dat_undef']."', ";
				$sql .= "cm_events_allcals = '".$plugin['data']['cm_events_allcals']."', ";
				$sql .= "cm_events_status = '".$plugin['data']['cm_events_status']."' ";
				$sql .= "WHERE cm_events_id = " . $plugin['data']['cm_events_id'];				
				_dbQuery($sql, 'UPDATE')or die("error: file ".__FILE__." line ".__LINE__.mysql_error() . "<hr />" . $sql);
			
			// INSERT
			} else {

    		$dates = array();
    		switch ($plugin['data']['schedule_type']) {
    			case ("once"):
    				array_push($dates, $plugin['data']['cm_events_date']);
    			break;
    
    			case ("daily"):
            $dates = schedule_daily($plugin['data']['cm_events_date'], $plugin['data']["daily_until"], $plugin['data']["daily_every"]);
            $plugin['data']["cm_events_setid"] = get_next_setid();    			
          break;
    
    			case ("monthlya"):
    				$dates = schedule_monthlybydate($plugin['data']["cm_events_date"], $plugin['data']["monthlya_until"]);
            $plugin['data']["cm_events_setid"] = get_next_setid();
          break;
    
    			case ("monthlyb"):
    				$dates = schedule_monthlybyweekday($plugin['data']["cm_events_date"], $plugin['data']["monthlyb_until"]);
            $plugin['data']["cm_events_setid"] = get_next_setid();
          break;
    
    			//case ("yearly"):
    			//	$dates = schedule_yearly($plugin['data']["cm_events_date"], $plugin['data']["yearly_until"], $plugin['data']["yearly_every"]);
    			//break;
    
    			//case ("custom"):
    			//	$dates = $this->schedule_custom($values["date"], $values["custom_every"]);
    			//break;
    		}
    		$event_count = count($dates);
    		while ($plugin['data']['cm_events_date'] = array_pop($dates)) {

  				$sql  = 'INSERT INTO '.DB_PREPEND.'phpwcms_cmcalendar_events (';
  				$sql .= 'cm_events_created,cm_events_changed,cm_events_date,cm_events_span,cm_events_time,cm_events_title,cm_events_image,cm_events_location,cm_events_description,cm_events_extrainfo,cm_events_setid,cm_events_userId,cm_events_article,cm_events_dat_undef,cm_events_allcals,cm_events_status';
  				$sql .= ') VALUES (';
  				$sql .= "'".aporeplace( $plugin['data']['cm_events_changed'] )."', ";			
  				$sql .= "'".aporeplace( $plugin['data']['cm_events_changed'] )."', ";
  				$sql .= "'".$plugin['data']['cm_events_date']."', ";
  				$sql .= $plugin['data']['cm_events_span'].", ";
  				$sql .= "'".aporeplace( $plugin['data']['cm_events_time'])."', ";
  				$sql .= "'".aporeplace( $plugin['data']['cm_events_title'])."', ";
  				//$sql .= "'".$plugin['data']['cm_events_category'].", ";
  				$sql .= "'".aporeplace( serialize($plugin['data']['cm_events_image']))."', ";
  				$sql .= "'".aporeplace( $plugin['data']['cm_events_location'])."', ";
  				$sql .= "'".aporeplace( $plugin['data']['cm_events_description'])."', ";
  				$sql .= "'".aporeplace( $plugin['data']['cm_events_extrainfo'])."', ";
  				//$sql .= "'".$plugin['data']['cm_events_approved'].", ";
  				$sql .= $plugin['data']['cm_events_setid'].", ";
  				$sql .= "'".$plugin['data']['cm_events_userId']."', ";
  				$sql .= $plugin['data']['cm_events_article'].", ";
  				$sql .= $plugin['data']['cm_events_dat_undef'].", ";
  				$sql .= "'".$plugin['data']['cm_events_allcals']."', ";
  				$sql .= $plugin['data']['cm_events_status']." ";
  				$sql .= ')';
  				$result = _dbQuery($sql, 'INSERT');
  				
  				if( !empty($result['INSERT_ID']) ) {
  					$plugin['data']['cm_events_id']	= $result['INSERT_ID'];
  				}
    		}
			}

			// save and back to listing mode
			if( isset($_POST['save']) ) {
				headerRedirect( cm_map_url('controller=events', '') );
			} else {
				headerRedirect( cm_map_url( array('controller=events', 'edit='.$plugin['data']['cm_events_id']), '') );
			}	

		}
} else if(isset($_POST['cm_events_title']) && $action == 'editset') {

  $plugin['data'] = array(
      'cm_events_id' => intval($_POST['cm_events_id']),
    	'cm_events_changed'	=> date('Y-m-d H:i:s'),
      //'cm_events_date' => $_POST['cm_events_date'], //$_POST['cm_events_date'], //date NOT NULL default '0000-00-00',
      //'cm_events_span' => intval($_POST['cm_events_span']), //int(11) NOT NULL default '1',
      'cm_events_time' => clean_slweg($_POST['cm_events_time']), //varchar(100) NOT NULL default '',
      'cm_events_title' => clean_slweg($_POST['cm_events_title']), //varchar(150) NOT NULL default '',
      //'cm_events_category' => intval($_POST['cm_events_category']), //int(11) NOT NULL default '0', --not used--
      //'cm_events_price' => clean_slweg($_POST['cm_events_price']), //varchar(60) NOT NULL default '', --not used--
      'cm_events_location' => clean_slweg($_POST['cm_events_location']), //varchar(100) NOT NULL default '',
      'cm_events_description' => slweg($_POST['cm_events_description']), //text NOT NULL,
      'cm_events_extrainfo' => clean_slweg($_POST['cm_events_extrainfo']), //text NOT NULL,
      //'cm_events_approved' => intval($_POST['cm_events_approved']), //tinyint(1) NOT NULL default '0', --not used--
      'cm_events_setid' => intval($_POST['cm_events_setid']), //int(11) NOT NULL default '0',
      'cm_events_userId' => intval($_POST['cm_events_userId']), //int(11) NOT NULL default '0', --used by TB mod--
      'cm_events_article' => intval($_POST['cm_events_article']), //int(11) NOT NULL default '0',  
      //'cm_events_dat_undef' => empty($_POST['cm_events_dat_undef']) ? 0 : 1, //tinyint(4) NOT NULL default '0',  
      //'cm_events_allcals' => clean_slweg($_POST['cm_events_allcals']), // varchar(56) NOT NULL default '',
      'cm_events_allcals' => empty($_POST['cm_events_allcals']) ?  "" : "|". implode('|', array_map("intval", $_POST['cm_events_allcals'])) ."|",
  	  'cm_events_status' => empty($_POST['cm_events_status']) ? 0 : 1
  	  //'daily_until'		=> clean_slweg($_POST['daily_until']),
  	  //'monthlya_until'		=> clean_slweg($_POST['monthlya_until']),
  	  //'monthlyb_until'		=> clean_slweg($_POST['monthlyb_until']),
  	  //'daily_every'		=> empty($_POST['daily_every']) ? 0 : 7,
  	  //'schedule_type'		=> clean_slweg($_POST['schedule_type'])
	);

  $plugin['data']['cm_events_image']['cm_events_image_name']	= clean_slweg($_POST['cm_events_image_name']);
  $plugin['data']['cm_events_image']['cm_events_image_id'] = intval($_POST['cm_events_image_id']);
  $plugin['data']['cm_events_image']['cm_events_image_link']	= clean_slweg($_POST['cm_events_image_link']);
  $plugin['data']['cm_events_image']['cm_events_image_caption'] = clean_slweg($_POST['cm_events_image_caption']);
  $plugin['data']['cm_events_image']['cm_events_image_lightbox'] = empty($_POST['cm_events_image_lightbox']) ? 0 : 1;
  $plugin['data']['cm_events_image']['cm_events_image_zoom'] = empty($_POST['cm_events_image_zoom']) ? 0 : 1;

// required fields	
	if(empty($plugin['data']['cm_events_title'])) {
		$plugin['error']['cm_events_title'] = 1;
		$plugin['data']['cm_events_allcals'] = empty($_POST['cm_events_allcals']) ?  array() : $_POST['cm_events_allcals'];
	}


// if no errors then do db action	
	if( empty($plugin['error'] )) {
		
			// Update when cm_events_setid exists (>0)
			if( $plugin['data']['cm_events_setid'] ) {
				$sql  = 'UPDATE '.DB_PREPEND.'phpwcms_cmcalendar_events SET ';
				$sql .= "cm_events_changed = '".aporeplace( $plugin['data']['cm_events_changed'])."', ";
				//$sql .= "cm_events_date = '".$plugin['data']['cm_events_date']."', ";
				//$sql .= "cm_events_span = '".$plugin['data']['cm_events_span']."', ";
				$sql .= "cm_events_time = '".aporeplace( $plugin['data']['cm_events_time'])."', ";
				$sql .= "cm_events_title = '".aporeplace( $plugin['data']['cm_events_title'])."', ";
				//$sql .= "cm_events_category = '".$plugin['data']['cm_events_category'].", ";
				$sql .= "cm_events_image = '".aporeplace( serialize($plugin['data']['cm_events_image']))."', ";
				$sql .= "cm_events_location = '".aporeplace( $plugin['data']['cm_events_location'])."', ";
				$sql .= "cm_events_description = '".aporeplace( $plugin['data']['cm_events_description'])."', ";
				$sql .= "cm_events_extrainfo = '".aporeplace( $plugin['data']['cm_events_extrainfo'])."', ";
				//$sql .= "cm_events_approved = '".$plugin['data']['cm_events_approved'].", ";
				//$sql .= "cm_events_setid = '".$plugin['data']['cm_events_setid']."', ";
				$sql .= "cm_events_userId = '".$plugin['data']['cm_events_userId']."', ";
				$sql .= "cm_events_article = '".$plugin['data']['cm_events_article']."', ";
				//$sql .= "cm_events_dat_undef = '".$plugin['data']['cm_events_dat_undef']."', ";
				$sql .= "cm_events_allcals = '".$plugin['data']['cm_events_allcals']."', ";
				$sql .= "cm_events_status = '".$plugin['data']['cm_events_status']."' ";
				$sql .= "WHERE cm_events_setid = " . $plugin['data']['cm_events_setid'];				
				_dbQuery($sql, 'UPDATE')or die("error: file ".__FILE__." line ".__LINE__.mysql_error() . "<hr />" . $sql);
			
			
			} 
// no INSERT
			// save and back to listing mode
			if( isset($_POST['save']) ) {
				headerRedirect( cm_map_url('controller=events', '') );
			} else {
				headerRedirect( cm_map_url( array('controller=events', 'editset='.$plugin['data']['cm_events_setid']), '') );
			}	

		}

}
	
// try to read entry from database
if($cm['cm_events_id'] && !isset($plugin['error'])) {

		$sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_cmcalendar_events WHERE ';
		$sql .= "cm_events_id = " . $cm['cm_events_id'] . ' LIMIT 1';
		$plugin['data'] = _dbQuery($sql);
		
		if( isset($plugin['data'][0]) ) {
			$plugin['data'] = $plugin['data'][0];
			$plugin['data']['cm_events_changed'] = strtotime($plugin['data']['cm_events_changed']);
			$plugin['data']['cm_events_allcals'] = explode('|',trim($plugin['data']['cm_events_allcals'], '|'));
      $plugin['data']['cm_events_image']	= unserialize($plugin['data']["cm_events_image"]);
		} else {
			headerRedirect( cm_map_url('controller=events', '') );
		}

}

// try to read entry set from database
if($cm['cm_events_setid'] && !isset($plugin['error'])) {

		$sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_cmcalendar_events WHERE ';
		$sql .= "cm_events_setid = " . $cm['cm_events_setid'] . ' LIMIT 1';
		$plugin['data'] = _dbQuery($sql);
		
		if( isset($plugin['data'][0]) ) {
			$plugin['data'] = $plugin['data'][0];
			$plugin['data']['cm_events_changed'] = strtotime($plugin['data']['cm_events_changed']);
			$plugin['data']['cm_events_allcals'] = explode('|',trim($plugin['data']['cm_events_allcals'], '|'));
      $plugin['data']['cm_events_image']	= unserialize($plugin['data']["cm_events_image"]);
		} else {
			headerRedirect( cm_map_url('controller=events', '') );
		}

}

if($action == 'status') {
  $plugin['data'] = array();
	list($plugin['data']['cm_events_id'], $plugin['data']['cm_events_status']) = explode( '-', $_GET['verify'] );
	$plugin['data']['cm_events_id']		= intval($plugin['data']['cm_events_id']);
	$plugin['data']['cm_events_status']	= empty($plugin['data']['cm_events_status']) ? 1 : 0;
}
if($action == 'statusset') {
  $plugin['data'] = array();
	list($plugin['data']['cm_events_setid'], $plugin['data']['cm_events_status']) = explode( '-', $_GET['verifyset'] );
	$plugin['data']['cm_events_setid']		= intval($plugin['data']['cm_events_setid']);
	$plugin['data']['cm_events_status']	= empty($plugin['data']['cm_events_status']) ? 1 : 0;
}

if($action == 'delete') {
  $plugin['data'] = array();
	$plugin['data']['cm_events_del'] = intval($_GET['delete']);
}
if($action == 'deleteset') {
  $plugin['data'] = array();
	$plugin['data']['cm_events_del'] = intval($_GET['deleteset']);
}


// default values
if(empty($plugin['data'])) {

	$plugin['data'] = array(
      'cm_events_id' => 0,
      'cm_events_created'	=> '',
      'cm_events_changed'	=> date('Y-m-d H:i:s'),
      'cm_events_date' => '',
      'cm_events_span' => 1,
      'cm_events_time' => '',
      'cm_events_title' => '',
      'cm_events_category' => 0,
		  'cm_events_image' => array(
        'cm_events_image_name'	=> '',
        'cm_events_image_id'	=> '',
        'cm_events_image_link'	=> '',
        'cm_events_image_caption'	=> '',
        'cm_events_image_lightbox'	=> 0,
        'cm_events_image_zoom'	=> 0,
      ),
      'cm_events_location' => '',
      'cm_events_description' => '',
      'cm_events_extrainfo' => '',
      'cm_events_approved' => 0,
      'cm_events_setid' => 0,
      'cm_events_userId' => 0,
      'cm_events_article' => 0,
      'cm_events_dat_undef' => 0,
      'cm_events_allcals' => array(),
  	  'cm_events_status'		=> 0,
  	  'daily_until'		=> '',
  	  'monthlya_until'		=> '',
  	  'monthlyb_until'		=> '',
  	  'schedule_type'		=> 'once'
	);
}

?>