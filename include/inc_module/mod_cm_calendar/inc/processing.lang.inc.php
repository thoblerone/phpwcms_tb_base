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
			headerRedirect( cm_map_url('controller=lang', '') );
		}
		
if($action == 'edit') {

	$plugin['data']['cm_lang_id']	= intval($_GET['edit']);

	if( isset($_POST['save']) || isset($_POST['submit2'])) {
		$plugin['data']['cm_lang_changedate']	= time();
		$plugin['data']['cm_lang_name']			= clean_slweg($_POST['cm_lang_name']);
		$plugin['data']['cm_lang_loc']			= clean_slweg($_POST['cm_llocs']);
		$plugin['data']['cm_lang_status']		= empty($_POST['cm_lang_status']) ? 0 : 1;
		$plugin['data']['cm_lang_sys']			= intval($_POST['cm_lang_sys']);
		$plugin['data']['lang']['cm_lang_cale']			= clean_slweg($_POST['cm_lang_cale']);		
		$plugin['data']['lang']['cm_lang_date']			= clean_slweg($_POST['cm_lang_date']);
		$plugin['data']['lang']['cm_lang_span']			= clean_slweg($_POST['cm_lang_span']);
		$plugin['data']['lang']['cm_lang_titl']			= clean_slweg($_POST['cm_lang_titl']);
		$plugin['data']['lang']['cm_lang_time']			= clean_slweg($_POST['cm_lang_time']);
		$plugin['data']['lang']['cm_lang_loca']			= clean_slweg($_POST['cm_lang_loca']);
		$plugin['data']['lang']['cm_lang_desc']			= clean_slweg($_POST['cm_lang_desc']);
		$plugin['data']['lang']['cm_lang_noen']			= clean_slweg($_POST['cm_lang_noen']);
		$plugin['data']['lang']['cm_lang_noca']			= clean_slweg($_POST['cm_lang_noca']);
		$plugin['data']['lang']['cm_lang_dateformat']			= clean_slweg($_POST['cm_lang_dateformat']);
		$plugin['data']['lang']['cm_lang_prnt']			= clean_slweg($_POST['cm_lang_prnt']);
		$plugin['data']['lang']['cm_lang_ical']			= clean_slweg($_POST['cm_lang_ical']);
		$plugin['data']['lang']['cm_lang_artl']			= clean_slweg($_POST['cm_lang_artl']);
		$plugin['data']['lang']['cm_lang_lbut']			= slweg($_POST['cm_lang_lbut']);
		$plugin['data']['lang']['cm_lang_rbut']			= slweg($_POST['cm_lang_rbut']);
		$plugin['data']['lang']['cm_lang_bckl']			= clean_slweg($_POST['cm_lang_bckl']);
		$plugin['data']['lang']['cm_lang_lstl']			= clean_slweg($_POST['cm_lang_lstl']);
		$plugin['data']['lang']['cm_lang_slct']			= clean_slweg($_POST['cm_lang_slct']);
		$plugin['data']['lang']['cm_lang_undf']			= clean_slweg($_POST['cm_lang_undf']);
		$plugin['data']['lang']['cm_lang_slct_all']			= clean_slweg($_POST['cm_lang_slct_all']);
		$plugin['data']['lang']['cm_lang_slct_am']			= clean_slweg($_POST['cm_lang_slct_am']);
		$plugin['data']['lang']['cm_lang_slct_ay']			= clean_slweg($_POST['cm_lang_slct_ay']);
		$plugin['data']['lang']['cm_lang_slct_nm']			= clean_slweg($_POST['cm_lang_slct_nm']);
		$plugin['data']['lang']['cm_lang_slct_ny']			= clean_slweg($_POST['cm_lang_slct_ny']);
		$plugin['data']['lang']['cm_lang_slct_lm']			= clean_slweg($_POST['cm_lang_slct_lm']);
		
		$plugin['data']['lang']['cm_lang_jan']			= clean_slweg($_POST['cm_lang_jan']);
		$plugin['data']['lang']['cm_lang_feb']			= clean_slweg($_POST['cm_lang_feb']);
		$plugin['data']['lang']['cm_lang_mar']			= clean_slweg($_POST['cm_lang_mar']);
		$plugin['data']['lang']['cm_lang_apr']			= clean_slweg($_POST['cm_lang_apr']);
		$plugin['data']['lang']['cm_lang_may']			= clean_slweg($_POST['cm_lang_may']);
		$plugin['data']['lang']['cm_lang_jun']			= clean_slweg($_POST['cm_lang_jun']);
		$plugin['data']['lang']['cm_lang_jul']			= clean_slweg($_POST['cm_lang_jul']);
		$plugin['data']['lang']['cm_lang_aug']			= clean_slweg($_POST['cm_lang_aug']);
    $plugin['data']['lang']['cm_lang_sep']			= clean_slweg($_POST['cm_lang_sep']);
		$plugin['data']['lang']['cm_lang_oct']			= clean_slweg($_POST['cm_lang_oct']);
    $plugin['data']['lang']['cm_lang_nov']			= clean_slweg($_POST['cm_lang_nov']);
    $plugin['data']['lang']['cm_lang_dec']			= clean_slweg($_POST['cm_lang_dec']);
    $plugin['data']['lang']['cm_lang_mon']			= clean_slweg($_POST['cm_lang_mon']);
    $plugin['data']['lang']['cm_lang_tue']			= clean_slweg($_POST['cm_lang_tue']);
    $plugin['data']['lang']['cm_lang_wed']			= clean_slweg($_POST['cm_lang_wed']);
    $plugin['data']['lang']['cm_lang_thu']			= clean_slweg($_POST['cm_lang_thu']);
    $plugin['data']['lang']['cm_lang_fri']			= clean_slweg($_POST['cm_lang_fri']);
    $plugin['data']['lang']['cm_lang_sat']			= clean_slweg($_POST['cm_lang_sat']);
    $plugin['data']['lang']['cm_lang_sun']			= clean_slweg($_POST['cm_lang_sun']);
    		
		if($plugin['data']['cm_lang_loc'] == '0') {
			$plugin['error']['cm_lang_loc'] = 'No selection';
		}
		
		if( empty($plugin['error'] )) {
		
			// Update
			if( $plugin['data']['cm_lang_id'] ) {
				$sql  = 'UPDATE '.DB_PREPEND.'phpwcms_cmcalendar_language SET ';
				$sql .= "cm_lang_changedate = '".aporeplace( date('Y-m-d H:i:s', $plugin['data']['cm_lang_changedate']) )."', ";
				//$sql .= "cm_lang_loc = '".$plugin['data']['cm_lang_loc']."', ";
				$sql .= "cm_lang_status = ".$plugin['data']['cm_lang_status'].", ";
				//$sql .= "cm_lang_name = '".aporeplace($plugin['data']['cm_lang_name'])."', ";
				$sql .= "cm_lang_sys = ".$plugin['data']['cm_lang_sys'].", ";
				$sql .= "cm_lang_lang = '".aporeplace(serialize($plugin['data']['lang']))."' ";
				$sql .= "WHERE cm_lang_id = " . $plugin['data']['cm_lang_id'];				
				_dbQuery($sql, 'UPDATE');
			
			// INSERT
			} else {
				$sql  = 'INSERT INTO '.DB_PREPEND.'phpwcms_cmcalendar_language (';
				$sql .= 'cm_lang_loc,cm_lang_createdate,cm_lang_changedate,cm_lang_status,cm_lang_name,cm_lang_sys,cm_lang_lang';
				$sql .= ') VALUES (';
				$sql .= "'".$plugin['data']['cm_lang_loc']."', ";
				$sql .= "'".aporeplace( date('Y-m-d H:i:s', $plugin['data']['cm_lang_changedate']) )."', ";			
				$sql .= "'".aporeplace( date('Y-m-d H:i:s', $plugin['data']['cm_lang_changedate']) )."', ";
				$sql .= $plugin['data']['cm_lang_status'].", ";
				$sql .= "'".aporeplace($plugin['data']['cm_lang_name'])."', ";
				$sql .= $plugin['data']['cm_lang_sys'].", ";
				$sql .= "'".aporeplace(serialize($plugin['data']['lang']))."'";
				$sql .= ')';
				$result = _dbQuery($sql, 'INSERT');
				
				if( !empty($result['INSERT_ID']) ) {
					$plugin['data']['cm_lang_id']	= $result['INSERT_ID'];
				}

			}

			// save and back to listing mode
			if( isset($_POST['save']) ) {
				headerRedirect( cm_map_url('controller=lang', '') );
			} else {
				headerRedirect( cm_map_url( array('controller=lang', 'edit='.$plugin['data']['cm_lang_id']), '') );
			}	

		}

	} elseif( $plugin['data']['cm_lang_id'] == 0 ) {
	
    if(isset($_POST['cm_llocs'])) {
    
      $sql  = 'SELECT COUNT(cm_lang_id) FROM '.DB_PREPEND.'phpwcms_cmcalendar_language WHERE ';
			$sql .= "cm_lang_loc LIKE '". aporeplace($_POST['cm_llocs']) ."'";
			
      if( _dbQuery($sql, 'COUNT') ) {
				$plugin['error']['cm_lang_loc'] = $BLM['lang_exist'];
			}
    
      $sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_cmcalendar_language WHERE ';
		  $sql .= "cm_lang_loc = 'en'" ;

		  $plugin['data'] = _dbQuery($sql);
	
		  if( isset($plugin['data'][0]) )  $plugin['data'] = $plugin['data'][0];
      $plugin['data']['lang']	= unserialize($plugin['data']["cm_lang_lang"]);
	    $plugin['data']['cm_lang_id']			= 0;
      $plugin['data']['cm_lang_loc']			= clean_slweg($_POST['cm_llocs']);
      $plugin['data']['cm_lang_changedate']	= time();
      $plugin['data']['cm_lang_createdate']	= '';
		  $plugin['data']['cm_lang_name']			= '';
		  $plugin['data']['cm_lang_status']		= 1;	
       
     } else {

	$plugin['data'] = array(
		'cm_lang_id'			=> 0,
    'cm_lang_changedate'	=> date('Y-m-d H:i:s'),
	  'cm_lang_createdate'	=> '',
    'cm_lang_name'			=> '',
		'cm_lang_loc'			=> '',
		'cm_lang_status'		=> 0,
		'cm_lang_sys'			=> 1,
		'lang' => array(
      'cm_lang_cale'	=> '',	
  		'cm_lang_date'	=> '',
  		'cm_lang_dateformat'	=> '',
  		'cm_lang_span'	=> '',
  		'cm_lang_titl'	=> '',
  		'cm_lang_time'	=> '',
  		'cm_lang_loca'	=> '',	
  		'cm_lang_desc'	=> '',
  		'cm_lang_noen'	=> '',
  		'cm_lang_noca'	=> '',
  		'cm_lang_prnt'	=> '',
  		'cm_lang_ical'	=> '',
  		'cm_lang_artl'	=> '',
  		'cm_lang_lbut'	=> '',
  		'cm_lang_rbut'	=> '',
  		'cm_lang_bckl'	=> '',
  		'cm_lang_lstl'	=> '',
  		'cm_lang_slct'	=> '',
  		'cm_lang_undf'	=> '',
  		'cm_lang_slct_all'	=> '',
  		'cm_lang_slct_am'	=> '',
  		'cm_lang_slct_ay'	=> '',
  		'cm_lang_slct_nm'	=> '',
  		'cm_lang_slct_ny'	=> '',
  		'cm_lang_slct_lm'	=> '',
  		'cm_lang_jan'		=> '',
  		'cm_lang_feb'		=> '',
  		'cm_lang_mar'		=> '',
  		'cm_lang_apr'		=> '',
  		'cm_lang_may'		=> '',	
  		'cm_lang_jun'		=> '',
  		'cm_lang_jul'		=> '',
  		'cm_lang_aug'		=> '',
      'cm_lang_sep'		=> '',
  		'cm_lang_oct'		=> '',
      'cm_lang_nov'		=> '',
      'cm_lang_dec'		=> '',
      'cm_lang_mon'		=> '',
      'cm_lang_tue'		=> '',
      'cm_lang_wed'		=> '',
      'cm_lang_thu'		=> '',
      'cm_lang_fri'		=> '',
      'cm_lang_sat'		=> '',
      'cm_lang_sun'		=> ''
    )
	);
     
     }
		
	} else {

		$sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_cmcalendar_language WHERE ';
		$sql .= "cm_lang_id = " . $plugin['data']['cm_lang_id'] . ' LIMIT 1';
		$plugin['data'] = _dbQuery($sql);
		
		if( isset($plugin['data'][0]) ) {
			$plugin['data'] = $plugin['data'][0];
      $plugin['data']['lang']	= unserialize($plugin['data']["cm_lang_lang"]);
			$plugin['data']['cm_lang_changedate'] = strtotime($plugin['data']['cm_lang_changedate']);
		} else {
			headerRedirect( cm_map_url('controller=lang', '') );
		}

	}

} elseif($action == 'status') {

	list($plugin['data']['cm_lang_id'], $plugin['data']['cm_lang_status']) = explode( '-', $_GET['verify'] );
	$plugin['data']['cm_lang_id']		= intval($plugin['data']['cm_lang_id']);
	$plugin['data']['cm_lang_status']	= empty($plugin['data']['cm_lang_status']) ? 1 : 0;

	$sql  = 'UPDATE '.DB_PREPEND.'phpwcms_cmcalendar_language SET ';
	$sql .= "cm_lang_status = ".$plugin['data']['cm_lang_status']." ";
	$sql .= "WHERE cm_lang_id = " . $plugin['data']['cm_lang_id'];
	
	_dbQuery($sql, 'UPDATE');

	headerRedirect( cm_map_url('controller=lang', '') );

}




?>