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

require_once (PHPWCMS_ROOT.'/include/inc_module/mod_cm_calendar/inc/cm.front.func.inc.php');
require_once (PHPWCMS_ROOT.'/include/inc_ext/feedcreator/feedcreator.class.php');

  $feeds_formats	= array('0.91', 'RSS0.91', '1.0', 'RSS1.0', '2.0', 'RSS2.0', 'ATOM', 'ATOM1.0', 'ATOM0.3');



  $artID = intval($_GET['art_id']);
  $cpID = intval($_GET['cp_id']);

  $sql_cnt  = "SELECT * FROM ".DB_PREPEND."phpwcms_articlecontent WHERE acontent_aid=".$artID." AND acontent_id=".$cpID."";
	$cresult  = _dbQuery($sql_cnt);
		
	foreach($cresult as $crow) {
      $content['cm_calendar']	= unserialize($crow["acontent_form"]); //should be only one
  }

  $feeds 			= array();
  $feeds['default'] = array(
								"title"				=> $content['cm_calendar']['cm_rss_title'],
								"description"		=> $content['cm_calendar']['cm_rss_descr'],
								"link"				=> PHPWCMS_URL,
								"syndicationURL"	=> PHPWCMS_URL.'feeds.php',
								"imagesrc"			=> "",
								"imagetitle"		=> "",
								"imagelink"			=> "",
								"imagedescription"	=> "",
								"timeZone"			=> "+01:00",
								"cacheTTL"			=> 3600,
								"structureID"		=> "",
								"useauthor"			=> 1,
								"feedAuthor"		=> "",
								"maxentries"		=> $content['cm_calendar']['cm_rss_number'],
								"encoding"			=> "UTF-8",
								"defaultFormat"		=> "RSS2.0",
								"filename"			=> "default_feed.xml",
                "locale"   =>  "fr_FR",
                "dateformat"   =>  "%A, %d. %B %Y"
							  );

  if($content['cm_calendar']['eventlist'] == 1 ) {

    $FEED = $feeds['default'];
    $FEED['defaultFormat']	= empty($_GET['format']) ? trim($FEED['defaultFormat']) : strtoupper(clean_slweg($_GET['format']));
    $FEED['defaultFormat']	= in_array($FEED['defaultFormat'], $feeds_formats) ? $FEED['defaultFormat'] : "RSS2.0";

    $FEED['filename']		=  'content/rss/feed-calendar-'.$artID.'-'.$cpID.'.xml';
    $FEED['maxentries']		= intval($FEED['maxentries']);
    $FEED['useauthor']		= intval($FEED['useauthor']);
    $FEED['encoding']		= empty($FEED['encoding']) ? 'utf-8' : $FEED['encoding'];

    define('FEED_ENCODING', trim(strtolower($FEED['encoding'])));
    //define("TIME_ZONE","+01:00");
    define("TIME_ZONE","");

    $rss 						= new UniversalFeedCreator();
    //$rss->useCached($FEED['defaultFormat'], $FEED['filename'], intval($FEED['cacheTTL']));
    $rss->title 				= $FEED['title'];
    $rss->description 			= $FEED['description'];
    $rss->link 					= $FEED['link'];
    $rss->syndicationURL 		= $FEED['syndicationURL'];
    $rss->encoding				= FEED_ENCODING;
    if(!empty($FEED['feedAuthor'])) {
    	$rss->editor			= $FEED['feedAuthor'];
    }
    if(!empty($FEED['feedEmail'])) {
    	$rss->editorEmail		= $FEED['feedEmail'];
    }

    if(!empty($FEED['imagesrc'])) {
    	$image 					= new FeedImage();
    	$image->title 			= cm_combinedParser($FEED['imagetitle'], FEED_ENCODING);
    	$image->url 			= $FEED['imagesrc'];
    	$image->link			= $FEED['imagelink'];
    	$image->description		= cm_combinedParser($FEED['imagedescription'], FEED_ENCODING);
    	$rss->image 			= $image;
    }

    //build the sql for active calendars ...
    foreach($content['cm_calendar']['cals']	 as $val) {
        $calsarray[] = "cm_events_allcals LIKE '%|".intval($val)."|%'";
  	}
    $wherequery = (count($calsarray)) ? " AND (".implode(' OR ', $calsarray).")" : " AND cm_events_allcals = '0'"; //then statement is never true

    // ... and current date
    if ($content['cm_calendar']['eventlist_startdate'] == 2) {
			$wherequery .=  " AND (cm_events_date) >= (CURDATE())";
    } else {
      $wherequery .=  " AND ( (cm_events_date) >= (CURDATE()) OR ( (MONTH(cm_events_date)) >= (MONTH(CURDATE())) AND " .
					"(YEAR(cm_events_date)) = (".date("Y").") ) )";
    }

    //get events
    $plugin_cmcalendar_events["sql"]  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_cmcalendar_events WHERE ';
  	$plugin_cmcalendar_events["sql"] .= "cm_events_status = 1";
  	$plugin_cmcalendar_events["sql"] .= $wherequery;
  	$plugin_cmcalendar_events["sql"] .= " ORDER BY cm_events_date";
  	($content['cm_calendar']['eventlist_asc'] ==  2) ? $plugin_cmcalendar_events["sql"] .= ' DESC' : $plugin_cmcalendar_events["sql"] .= ' ASC';
    $plugin_cmcalendar_events["sql"] .= ', cm_events_time ASC'; // +KH 120110  Innerhalb des Tages nach Zeit sortiert
    if($FEED['maxentries']) {
    	$plugin_cmcalendar_events["sql"] .= " LIMIT ".$FEED['maxentries'];
    }
    $plugin_cmcalendar_events["data"] = _dbQuery($plugin_cmcalendar_events["sql"]);

    //prepare output
    $timePlus = 0;
  	if( !isset($plugin_cmcalendar_events["data"][0]) ) {
      $plugin_cmcalendar_events["output"]		= '\n'; //no entry
    } else {  

    foreach ($plugin_cmcalendar_events["data"] as $value) {

  	    $value['cm_events_image'] = unserialize(	$value['cm_events_image']);

    		$item = new FeedItem();
    		$item->title 			= cm_combinedParser($value['cm_events_title'], FEED_ENCODING);
    		$item->link 			= PHPWCMS_URL.'index.php?aid='.$artID;

        /*
        date - time
        location
        description / teaser
        */
        setlocale(LC_TIME, $FEED['locale'].".UTF-8");
        $caldate = strftime($FEED['dateformat'],strtotime($value['cm_events_date']));
        $desr = cm_combinedParser( $caldate , FEED_ENCODING).' - '. cm_combinedParser( $value['cm_events_time'] , FEED_ENCODING)."<br />";
        $desr .=  cm_combinedParser( $value['cm_events_location'] , FEED_ENCODING)."<br />";
        $desr .=   cm_combinedParser( empty($value['cm_events_description']) ? $value['cm_events_extrainfo'] : $value['cm_events_description'] , FEED_ENCODING)  ;
    		$item->description 		= $desr;

    		//$item->date 			= strtotime($value['cm_events_date']);
    		$item->date 			= time() + $timePlus;

        //image
        if(!empty($value['cm_events_image']['cm_events_image_id'])) {

  		    $sql = 'SELECT * FROM '.DB_PREPEND.'phpwcms_file WHERE f_aktiv=1 AND f_public=1 AND f_id='.$value['cm_events_image']['cm_events_image_id'];
  		    $temp_internal_file = _dbQuery($sql);

          if(isset($temp_internal_file[0])) {
            $thumb_info = @getimagesize(PHPWCMS_FILES.$temp_internal_file[0]["f_hash"] . '.' . $temp_internal_file[0]["f_ext"]);

           $zoominfo	 = get_cached_image(
  						array(	"target_ext"	=>	$temp_internal_file[0]["f_ext"],
  								"image_name"	=>	$temp_internal_file[0]["f_hash"] . '.' . $temp_internal_file[0]["f_ext"],
  								"max_width"		=>	$thumb_info[0],
  								"max_height"	=>	$thumb_info[1],
  								"thumb_name"	=>	md5(	$temp_internal_file[0]["f_hash"].$thumb_info[0].
  															$thumb_info[1].$GLOBALS['phpwcms']["sharpen_level"])
  						)
          	);

          //<enclosure url="http://example.com/image.jpg" length="12216320" type="images/jpeg" />

          //$item->enclosure
          $item->enclosure->url = PHPWCMS_URL.PHPWCMS_IMAGES.$zoominfo[0];
          $item->enclosure->length = $temp_internal_file[0]["f_size"];
          $item->enclosure->type = "images/jpeg";
        }
      }
      //$item->additionalElements = array('datum'=> $itemDate->rfc822() );
      //$item->updateDate		= $value['cm_events_changed'] + $timePlus;
      //$item->updateDate		= $value['cm_events_changed'];
  		$item->source 			= PHPWCMS_URL;

  		if($FEED['useauthor'] || $FEED['defaultFormat'] == 'ATOM' || $FEED['defaultFormat'] == 'ATOM1.0') {
  				$item->author 	= $FEED['feedAuthor'];
  		}

  		$item->guid				= PHPWCMS_URL.'index.php?aid='.$artID;
  		$rss->addItem($item);

		  $timePlus += 2;
      } //end for
    }

    //write the xml file
    $rss->saveFeed($FEED['defaultFormat'], $FEED['filename'], false);
  }

  //redirect to CP-tab
  headerRedirect(decode_entities(cm_map_url('controller=cp')));

?>