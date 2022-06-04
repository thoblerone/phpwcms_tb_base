<?php
/*************************************************************************************
  Copyright notice
  
  cmCalendar Module v1 by breitsch - webrealisierung gmbh (mail@casa-loca.com) 2009
  
  Parts of this script come from the original calendar mod:
  // Ionrock's Calendar MOD by Verve...
  // Coypright (C) 2004
  the script was almost entirely rewritten though an made a plugin mod for phpwcms.
  
  License: GNU General Public License version 2, or (at your option) any later version
  This script is a module for PHPWCMS. 
  
  PHPWCMS (c) 2002-2008 Oliver Georgi (oliver@phpwcms.de) // All rights reserved.
 
*************************************************************************************

  Copyright notice

  cmCalendar Module v1 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2009
  cmCalendar Module v1.2 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2012

  License: GNU General Public License version 2, or (at your option) any later version
  This script is a module for PHPWCMS.

   (c) 2002-2012 Oliver Georgi (oliver@phpwcms.de) // All rights reserved.

*************************************************************************************/
$path = dirname(dirname(dirname(realpath(dirname(__FILE__)))));
$phpwcms = array();
require_once ($path."/config/phpwcms/conf.inc.php");
require_once $path.'/include/inc_lib/default.inc.php';
require_once $path.'/include/inc_lib/dbcon.inc.php';
require_once $path.'/include/inc_lib/general.inc.php';
include ($path.'/include/inc_module/mod_cm_calendar/inc/calendar.classes.php');
require_once( $path."/include/inc_module/mod_cm_calendar/inc/iCalcreator.class.php" );
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $sql = "SELECT * FROM " .DB_PREPEND."phpwcms_cmcalendar_events WHERE cm_events_id=" . mysql_real_escape_string($id);
}
if ( isset($_GET["ids"]) ) {
  $outlook_plugin["ids"] = clean_slweg($_GET["ids"]);
  $outlook_plugin["ids_array"] = explode(",", $outlook_plugin["ids"]);
  $outlook_plugin["ids_array"] = array_map("intval", $outlook_plugin["ids_array"]);
  $outlook_plugin["ids"] = implode(",", $outlook_plugin["ids_array"]);
  $sql = "SELECT * FROM " .DB_PREPEND."phpwcms_cmcalendar_events WHERE cm_events_id IN(".mysql_real_escape_string($outlook_plugin["ids"]).")";
}
$result = mysql_query($sql)
	or die("An error ocurred. Transaction not possible.<hr />");
	//or die("Error: ".mysql_errno().": ".mysql_error()."<hr />" . $sql);

$v = new vcalendar(); // create a new calendar instance
$v->setConfig( 'unique_id', str_replace(array('www.', 'WWW.', '/'), '', $_SERVER["HTTP_HOST"]) ); // set Your unique id
$v->setConfig( "allowEmpty", FALSE );
$v->setConfig( "directory", "../../../content/tmp" );
$v->setConfig( "filename", str_replace(array('www.', 'WWW.', '/'), '', $_SERVER["HTTP_HOST"]).".ics" ); 
$v->setProperty( 'method', 'PUBLISH' ); // required of some calendar software
	$i=0;
		while ($row = mysql_fetch_array($result)) {
      $i++;
      $vevent = new vevent(); // create an event calendar component
      //$row['days']
      //date("H", strtotime($row["time"]))
      //$row['time']
      $ersetzen = array(",", ".", ":", ";", "-", "/");
      $row['time'] = str_replace($ersetzen, ":", $row['cm_events_time']);
      $zeit = explode(":", $row['cm_events_time']);
      //$aktyear=date("d", strtotime($row["date"]));
      $vevent->setProperty( 'dtstart', array( 'year'=>date("Y", strtotime($row["cm_events_date"])), 'month'=>date("m", strtotime($row["cm_events_date"])), 'day'=>date("d", strtotime($row["cm_events_date"])), 'hour'=>$zeit[0], 'min'=>$zeit[1],  'sec'=>0 ));
      if ($row['cm_events_span'] > 1) {
      		$span = $row['cm_events_span']-1;
      		$start_time= strtotime($row["cm_events_date"]);
      		$end_time = strtotime("+".$span." days", $start_time);
      		$end_month = date("n", $end_time);
      		$end_day = date("j", $end_time);
          $vevent->setProperty( 'dtend',  array( 'year'=>date("Y", strtotime($row["cm_events_date"])), 'month'=>$end_month, 'day'=>$end_day, 'hour'=>$zeit[0], 'min'=>$zeit[1], 'sec'=>0 ));
      }
      $vevent->setProperty( 'LOCATION', $row['cm_events_location'] ); // property name - case independent
      $vevent->setProperty( 'summary', $row['cm_events_title'] );
      $vevent->setProperty( 'description', strip_tags($row['cm_events_description']) );
      $vevent->setProperty( 'comment', strip_tags($row['cm_events_description']) );
      //$vevent->setProperty( 'attendee', 'attendee1@icaldomain.net' );
      $v->setComponent ( $vevent ); // add event to calendar
		}

$v->returnCalendar(); // redirect calendar file to browser
?>
