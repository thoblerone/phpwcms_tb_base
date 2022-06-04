<?php
/*************************************************************************************

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
require_once ($path.'/include/inc_lib/default.inc.php');
require_once (PHPWCMS_ROOT.'/include/inc_lib/dbcon.inc.php');
require_once (PHPWCMS_ROOT.'/include/inc_lib/general.inc.php');
require_once (PHPWCMS_ROOT.'/include/inc_front/front.func.inc.php');
include (PHPWCMS_ROOT.'/include/inc_module/mod_cm_calendar/inc/calendar.frontend.classes.php');
include_once(PHPWCMS_ROOT.'/include/inc_module/mod_cm_calendar/inc/cm.functions.inc.php');
include_once(PHPWCMS_ROOT.'/include/inc_module/mod_cm_calendar/inc/calendar.frontend.classes.php');

$print_plugin = array();

if (isset($_GET["lang"]) && preg_match('/^[a-z]{1,2}(-[a-z]{1,2})?$/i',$_GET["lang"])) {
  $print_plugin["language"] = clean_slweg($_GET["lang"]);
} else {
  $print_plugin["language"] = 'en';
}

if ( isset($_GET["id"]) ) {
  $print_plugin["ids"] = clean_slweg($_GET["id"]);
  $print_plugin["ids_array"] = explode(",", $print_plugin["ids"]);
  $print_plugin["ids_array"] = array_map("intval", $print_plugin["ids_array"]);
  $print_plugin["ids"] = implode(",", $print_plugin["ids_array"]);

  //init obj
  $cal = new cmCalendar;
  // set the language acc to browser language
  $cal->setLanguageFrontend($print_plugin["language"]);
	
//get the values from db
  $print_plugin["sql"]  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_cmcalendar_events WHERE ';
	$print_plugin["sql"] .= "cm_events_status = 1";
  $print_plugin["sql"] .= " AND cm_events_id IN(".trim(mysql_real_escape_string($print_plugin["ids"]),',').")";
	$print_plugin["sql"] .= " ORDER BY cm_events_date ASC";
	$print_plugin['data'] = _dbQuery($print_plugin["sql"]);

  // read print template
  if(is_file($path.'/include/inc_module/mod_cm_calendar/template/print/frontend_listing_print.tmpl')) {
  	$print_plugin['print_template']	= @file_get_contents($path.'/include/inc_module/mod_cm_calendar/template/print/frontend_listing_print.tmpl');
  }

  //output
  $print_plugin['output']		= '';
  $j=0;
  $ids = '';
  //no entry
	if( !isset($print_plugin['data'][0]) ) {
    $print_plugin['output']		= $cal->langInfo['noEventNotice'];
  } else {  //single entry
    foreach ($print_plugin['data'] as $value) {
	    $value['cm_events_image'] = unserialize(	$value['cm_events_image']);
      $j++;
      $ids .= $value['cm_events_id'].',';
      
      //events section in template
      $print_plugin['output'] .= get_tmpl_section('CALENDAR_LIST_ENTRY', $print_plugin['print_template']);

      //title
      $print_plugin['output']  = render_cnt_template($print_plugin['output'], 'LANG_TITLE', htmlspecialchars($cal->langInfo['cm_lang_titl']));
      $print_plugin['output']  = render_cnt_template($print_plugin['output'], 'CALENDAR_TITLE', htmlspecialchars($value['cm_events_title']));

      //date time
		  $print_plugin["datetimestr"] = '{DATE:'.$cal->langInfo['cm_lang_dateformat'].' lang='.$cal->langInfo['cm_lang_langloc'].'}';
      $print_plugin["renderdate"] = render_date($print_plugin["datetimestr"], strtotime($value['cm_events_date']), 'DATE');
      //special date formats
      $print_plugin['output'] = preg_replace('/\{FORMAT_DATE:(.*?)\}/e','render_date("{FORMAT_DATE:$1 lang='.$cal->langInfo['cm_lang_langloc'].'}", '.strtotime($value['cm_events_date']).', "FORMAT_DATE")', $print_plugin['output']);
      $print_plugin['output']  = render_cnt_template($print_plugin['output'], 'LANG_DATE', htmlspecialchars($cal->langInfo['cm_lang_date']));
      $print_plugin['output']  = render_cnt_template($print_plugin['output'], 'CALENDAR_DATE', $print_plugin["renderdate"]);
      $print_plugin['output']  = render_cnt_template($print_plugin['output'], 'LANG_TIME', htmlspecialchars($cal->langInfo['cm_lang_time']));
      $print_plugin['output']  = render_cnt_template($print_plugin['output'], 'CALENDAR_TIME', htmlspecialchars($value['cm_events_time']));

      //span
      if ( $value['cm_events_span'] > 1 ) {
        $print_plugin["langstrrepl"] = preg_replace('/\#+?/', $value['cm_events_span'], $cal->langInfo['cm_lang_span']);
      } else {
        $print_plugin["langstrrepl"] = '';
      }
      $print_plugin['output']  = render_cnt_template($print_plugin['output'], 'CALENDAR_SPAN', htmlspecialchars($print_plugin["langstrrepl"]));

      //location
      $print_plugin['output']  = render_cnt_template($print_plugin['output'], 'LANG_LOCATION', htmlspecialchars($cal->langInfo['cm_lang_loca']));
      $print_plugin['output']  = render_cnt_template($print_plugin['output'], 'CALENDAR_LOCATION', htmlspecialchars($value['cm_events_location']));

      //description
      $value['cm_events_description']=preg_replace('#(src)="\/?([^:"]*)("|(?:(?:%20|\s|\+)[^"]*"))#','$1="'.$phpwcms["site"].$phpwcms["root"] .'$2$3',$value['cm_events_description']);
      $print_plugin['output']  = render_cnt_template($print_plugin['output'], 'LANG_DESCRIPTION', htmlspecialchars($cal->langInfo['cm_lang_desc']));
      $print_plugin['output']  = render_cnt_template($print_plugin['output'], 'CALENDAR_DESCRIPTION', $value['cm_events_description']);

		// Image
		if(empty($value['cm_events_image']['cm_events_image_id'])) {
			$print_plugin['output']	= render_cnt_template($print_plugin['output'], 'IMAGE', '');
			$print_plugin['output']	= str_replace('{IMAGE_ID}', '', $print_plugin['output']);
		} else {
			$print_plugin['output']	= render_cnt_template($print_plugin['output'], 'IMAGE', htmlspecialchars($value['cm_events_image']['cm_events_image_name']));
			$print_plugin['output']	= str_replace('{IMAGE_ID}', $value['cm_events_image']['cm_events_image_id'], $print_plugin['output']);
		}
		
		// Zoom Image
		if(empty($value['cm_events_image']['cm_events_image_zoom'])) {
			$print_plugin['output']	= render_cnt_template($print_plugin['output'], 'ZOOM', '' );
		} else {
      //o zoom for print
			//$print_plugin['output']	= render_cnt_template($print_plugin['output'], 'ZOOM', 'zoom' );
			$print_plugin['output']	= render_cnt_template($print_plugin['output'], 'ZOOM', '' );
		}
		// Lightbox
		if(empty($value['cm_events_image']['cm_events_image_lightbox'])) {
			$print_plugin['output']	= str_replace('{LIGHTBOX}', '', $print_plugin['output']);
		} else {
      //no lightbox needed for print
			//initializeLightbox();
			$print_plugin['output']	= str_replace('{LIGHTBOX}', '', $print_plugin['output']);
		}
		// Caption
		if(empty($value['cm_events_image']['cm_events_image_caption'])) {
			$print_plugin['output']	= render_cnt_template($print_plugin['output'], 'CAPTION', '' );
			$print_plugin['output']	= render_cnt_template($print_plugin['output'], 'LIGHTBOX_CAPTION', '' );
		} else {
			$value['cnt_caption']	= getImageCaption($value['cm_events_image']['cm_events_image_caption'], '');
			$print_plugin['output']	= render_cnt_template($print_plugin['output'], 'CAPTION', htmlspecialchars($value['cnt_caption']['caption_text']) );
			$print_plugin['output']	= render_cnt_template($print_plugin['output'], 'LIGHTBOX_CAPTION', parseLightboxCaption($value['cnt_caption']['caption_text']) );
		}
		
		// Image URL
		if(empty($value['cm_events_image']['cm_events_image_link'])) {
			$print_plugin['output']	= render_cnt_template($print_plugin['output'], 'IMAGE_URL', '');
			$print_plugin['output']	= str_replace('{IMAGE_URL_TARGET}', '', $print_plugin['output']);

		} else {
			$value['image_url']		= get_redirect_link($value['cm_events_image']['cm_events_image_link'], ' ', '');
			$print_plugin['output']	= str_replace('{IMAGE_URL_TARGET}', $value['image_url']['target'], $print_plugin['output']);
			$print_plugin['output']	= render_cnt_template($print_plugin['output'], 'IMAGE_URL', htmlspecialchars($value['image_url']['link']) );

		}
		// Check for Zoom
		$print_plugin['output']	= render_cnt_template($print_plugin['output'], 'ZOOM', empty($value['cm_events_image']['cm_events_image_zoom']) ? '' : 'zoom' );

      //icalendar (no print)
      $print_plugin['output']  = render_cnt_template($print_plugin['output'], 'CALENDAR_ICAL', '');
 
      
      //articlelink (no print)
      $print_plugin['output']  = render_cnt_template($print_plugin['output'], 'CALENDAR_ARTICLELINK', '');
      if ($j < count($print_plugin['data'])) $print_plugin['output'] .= get_tmpl_section('CALENDAR_LIST_ENTRY_SPACE', $print_plugin['print_template']);
    
    }
  }


  if (isset($print_plugin['print_template'])) {

    //container for listing
    $print_plugin['container']		= '';
    $print_plugin['container'] .= get_tmpl_section('CALENDAR_LIST_TOP', $print_plugin['print_template']);
    //functions (no print)
    $print_plugin['container']  = str_replace('{PRINT_LINK}', '', $print_plugin['container']);
    $print_plugin['container']  = str_replace('{ICAL_LINK}', '', $print_plugin['container']);
    $print_plugin['container']  = str_replace('{SELECTION_DROPDOWN}', '', $print_plugin['container']);
    $print_plugin['container']  = str_replace('{LANG_SELECTION}', '', $print_plugin['container']);

    //enter the entries-listing
    $print_plugin['container']  = render_cnt_template($print_plugin['container'], 'CALENDAR_ENTRIES', $print_plugin['output']);

    $print_plugin['container'] .= get_tmpl_section('CALENDAR_LIST_BOTTOM', $print_plugin['print_template']);

  } else {
    $print_plugin['container']	= "missing template";
  }

  //return the rendered output
  $print_plugin['page_start']   = str_replace( '{DOCTYPE_LANG}', $phpwcms['DOCTYPE_LANG'], PHPWCMS_DOCTYPE );
  $print_plugin['page_start']  .= '<title>print calendar</title>'.LF;
  $print_plugin['page_start']  .= '<meta http-equiv="content-type" content="'.$_use_content_type.'; charset='.PHPWCMS_CHARSET.'"'.HTML_TAG_CLOSE.LF;
  $print_plugin['page_start'] .= '<link href="template/print/frontend_listing_print.css" rel="stylesheet" type="text/css"'.HTML_TAG_CLOSE.LF;
  $print_plugin['page_start'] .= '</head>'.LF;
  $print_plugin['page_start'] .= '<body>'.LF;
  $print_plugin['page_start'] .= '<div id="printlink"><a href="javascript:window.print()">'.$cal->langInfo['cm_lang_prnt'].'</a></div>'.LF;

  echo $print_plugin['page_start'].$print_plugin['container'].LF.'</body>'.LF.'</html>';;


  unset($print_plugin);

} else {

//keine id's
  echo "no calendar entries found";
}

?>