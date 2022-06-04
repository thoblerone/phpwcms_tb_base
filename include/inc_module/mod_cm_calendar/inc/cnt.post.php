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

// cmCalendar module handle content part POST values
$content['cm_calendar'] = array();
$content['cm_calendar']['cals']	= array();
if (!empty($_POST['cals'])) $content['cm_calendar']['cals']	= $_POST['cals'];
$content['cm_calendar']['template'] = clean_slweg($_POST['template']);
$content['cm_calendar']['calrt_css'] = clean_slweg($_POST['calrt_css']);
//$content['cm_calendar']['cm_selection']	= explode(LF, $_POST['cm_selection']);
$content['cm_calendar']['cm_selection']	= clean_slweg($_POST['cm_selection']);
$content['cm_calendar']['cm_calrt']	= empty($_POST['cm_calrt']) ? 0 : 1;
$content['cm_calendar']['cm_calrt_artlnk']	= empty($_POST['cm_calrt_artlnk']) ? 0 : 1;
$content['cm_calendar']['cm_calrt_ajax']	= empty($_POST['cm_calrt_ajax']) ? 0 : 1;
$content['cm_calendar']['cm_calrt_firstday']	= intval($_POST['cm_calrt_firstday']);
$content['cm_calendar']['eventlist']	= intval($_POST['eventlist']);
$content['cm_calendar']['eventlist_css'] = clean_slweg($_POST['eventlist_css']);
$content['cm_calendar']['eventlist_print']	= empty($_POST['eventlist_print']) ? 0 : 1;
$content['cm_calendar']['eventlist_print_img'] = clean_slweg($_POST['eventlist_print_img']);
$content['cm_calendar']['eventlist_ical']	= empty($_POST['eventlist_ical']) ? 0 : 1;
$content['cm_calendar']['eventlist_ical_img'] = clean_slweg($_POST['eventlist_ical_img']);
$content['cm_calendar']['cm_events_article'] = intval($_POST['cm_events_article']);
$content['cm_calendar']['cm_calrt_actdays']	= empty($_POST['cm_calrt_actdays']) ? 0 : 1;
$content['cm_calendar']['eventlist_asc']	= intval($_POST['eventlist_asc']);
$content['cm_calendar']['teaserlist']	= empty($_POST['teaserlist']) ? 0 : 1;
$content['cm_calendar']['teaser_anz']	= intval($_POST['teaser_anz']);
$content['cm_calendar']['teaser_asc']	= intval($_POST['teaser_asc']);
$content['cm_calendar']['cm_teaser_article']	= intval($_POST['cm_teaser_article']);
$content['cm_calendar']['teaser_tpl']	= clean_slweg($_POST['teaser_tpl']);
$content['cm_calendar']['teaser_css']	= clean_slweg($_POST['teaser_css']);
$content['cm_calendar']['teaser_lnk']	= empty($_POST['teaser_lnk']) ? 0 : 1;
$content['cm_calendar']['teaser_anchor'] = empty($_POST['teaser_anchor']) ? 0 : 1;
$content['cm_calendar']['cm_calrt_anchor'] = empty($_POST['cm_calrt_anchor']) ? 0 : 1;
$content['cm_calendar']['eventlist_startdate'] = intval($_POST['eventlist_startdate']);
$content['cm_calendar']['cal_rt_img_leftbut'] = clean_slweg($_POST['cal_rt_img_leftbut']);
$content['cm_calendar']['cal_rt_img_rightbut'] = clean_slweg($_POST['cal_rt_img_rightbut']);
$content['cm_calendar']['page_mini_cal'] = empty($_POST['page_mini_cal']) ? 0 : 1;
$content['cm_calendar']['calrt_number'] = intval($_POST['calrt_number']);

//rss
$content['cm_calendar']['cm_rss_active'] = empty($_POST['cm_rss_active']) ? 0 : 1;
$content['cm_calendar']['cm_rss_title'] = empty( $_POST['cm_rss_title'] ) ? '' : clean_slweg($_POST['cm_rss_title']);
$content['cm_calendar']['cm_rss_descr'] = empty( $_POST['cm_rss_descr'] ) ? '' : clean_slweg($_POST['cm_rss_descr']);
if (empty($_POST['cm_rss_number'])) {
  if(isset($_POST['cm_rss_active']) && $_POST['cm_rss_active'] == 1) {
    $content['cm_calendar']['cm_rss_number'] = 10;
  } else {
    $content['cm_calendar']['cm_rss_number'] = '';
  }
} else {
  $content['cm_calendar']['cm_rss_number'] = intval($_POST['cm_rss_number']);
}

/*-- start ajax  --*/
	$content['cm_calendar']['cm_calrt_ajax'] = empty($_POST['cm_calrt_ajax']) ? 0 : 1;
	$content['cm_calendar']['cm_calrt_ajax_txt']	= intval($_POST['cm_calrt_ajax_txt']);
	$content['cm_calendar']['cm_calrt_ajax_daydig']	= intval($_POST['cm_calrt_ajax_daydig']);
	$content['cm_calendar']['cal_rt_img_backlink'] = clean_slweg($_POST['cal_rt_img_backlink']);
	$content['cm_calendar']['cal_rt_img_listinglink'] = clean_slweg($_POST['cal_rt_img_listinglink']);
/*-- end ajax  --*/

if($content['cm_calendar']['eventlist'] == 1 && $content['cm_calendar']['cm_rss_active'] == 1 ) {

include_once($phpwcms['modules'][$content["module"]]['path'].'inc/cm.front.func.inc.php');
require_once (PHPWCMS_ROOT.'/include/inc_ext/feedcreator/feedcreator.class.php');
$feeds_formats	= array('0.91', 'RSS0.91', '1.0', 'RSS1.0', '2.0', 'RSS2.0', 'ATOM', 'ATOM1.0', 'ATOM0.3');
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
                "locale"   =>  "de_DE",
                "dateformat"   =>  "%A, %d. %B %Y"
							  );

  //check for the next cp id when creating a new cp
  //neccessary because at this point phpwcms hasn't set the cp id yet
  $xml_cp_id = intval($_POST["cid"]);
  if($_POST["cid"]==0) {
      $result7 = mysql_query("SHOW TABLE STATUS LIKE '".DB_PREPEND."phpwcms_articlecontent'") or die("Error: ".mysql_error());
      $rows7 = mysql_fetch_assoc($result7);
      $xml_cp_id = $rows7['Auto_increment'];
  }


  $FEED 					= $feeds['default'];
  $FEED['defaultFormat']	= empty($_GET['format']) ? trim($FEED['defaultFormat']) : strtoupper(clean_slweg($_GET['format']));
  $FEED['defaultFormat']	= in_array($FEED['defaultFormat'], $feeds_formats) ? $FEED['defaultFormat'] : "RSS2.0";
  $FEED['filename']		=  'content/rss/feed-calendar-'.intval($_POST["caid"]).'-'.$xml_cp_id.'.xml';
  $FEED['maxentries']		= intval($FEED['maxentries']);
  $FEED['useauthor']		= intval($FEED['useauthor']);
  $FEED['encoding']		= empty($FEED['encoding']) ? 'utf-8' : $FEED['encoding'];

  define('FEED_ENCODING', trim(strtolower($FEED['encoding'])));
  //define("TIME_ZONE","+01:00");
  define("TIME_ZONE","");

  $rss 						= new UniversalFeedCreator();
  //$rss->useCached($FEED['defaultFormat'], $FEED['filename'], intval($FEED['cacheTTL']));
  $rss->title 				= cm_combinedParser($FEED['title'], FEED_ENCODING);
  $rss->description 			= cm_combinedParser($FEED['description'], FEED_ENCODING);
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
  	$image->title 			= $FEED['imagetitle'];
  	$image->url 			= $FEED['imagesrc'];
  	$image->link			= $FEED['imagelink'];
  	$image->description		= $FEED['imagedescription'];
  	$rss->image 			= $image;

  }

  $calsarray = array();
  if ($content['cm_calendar']['cals'] == '') $content['cm_calendar']['cals'] = array();  //compatibilty to V1.0
  foreach($content['cm_calendar']['cals']	 as $val) {
      $calsarray[] = "cm_events_allcals LIKE '%|".intval($val)."|%'";
  }
  $wherequery = (count($calsarray)) ? " AND (".implode(' OR ', $calsarray).")" : " AND cm_events_allcals = '0'"; //then statement is never true

  if ($content['cm_calendar']['eventlist_startdate'] == 2) {
		$wherequery .=  " AND (cm_events_date) >= (CURDATE())";
  } else {
    $wherequery .=  " AND ( (cm_events_date) >= (CURDATE()) OR ( (MONTH(cm_events_date)) >= (MONTH(CURDATE())) AND " .
				"(YEAR(cm_events_date)) = (".date("Y").") ) )";
  }

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

  $timePlus = 0;
  	if( !isset($plugin_cmcalendar_events["data"][0]) ) {
      $plugin_cmcalendar_events["output"]		= '\n';
    } else {
      foreach ($plugin_cmcalendar_events["data"] as $value) {
  	    $value['cm_events_image'] = unserialize(	$value['cm_events_image']);

    		$item = new FeedItem();
    		$item->title 			= cm_combinedParser($value['cm_events_title'], FEED_ENCODING);
    		$item->link 			= PHPWCMS_URL.'index.php?aid='.intval($_POST["caid"]);
        setlocale(LC_TIME, $FEED['locale'].".UTF-8");
        $caldate = strftime($FEED['dateformat'],strtotime($value['cm_events_date']));
        $desr = cm_combinedParser( $caldate , FEED_ENCODING).' - '. cm_combinedParser( $value['cm_events_time'] , FEED_ENCODING)."<br />";
        $desr .=  cm_combinedParser( $value['cm_events_location'] , FEED_ENCODING)."<br />";
        $desr .=   cm_combinedParser( empty($value['cm_events_description']) ? $value['cm_events_extrainfo'] : $value['cm_events_description'] , FEED_ENCODING)  ;
    		$item->description 		= $desr;
    		//$item->description 		= cm_combinedParser( empty($value['cm_events_description']) ? $value['cm_events_extrainfo'] : $value['cm_events_description'] , FEED_ENCODING);
    		//$item->date 			= strtotime($value['cm_events_date']) + 1;
    		$item->date 			= time() + $timePlus;
        //$item->updateDate		= $value['cm_events_changed'] + $timePlus;

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
    		$item->source 			= PHPWCMS_URL;

    		if($FEED['useauthor'] || $FEED['defaultFormat'] == 'ATOM' || $FEED['defaultFormat'] == 'ATOM1.0') {
    				$item->author 	= $FEED['feedAuthor'];
    		}

    		$item->guid				= PHPWCMS_URL.'index.php?aid='.intval($_POST["caid"]);
    		$rss->addItem($item);

    		$timePlus += 2;
	    }
    }

    $rss->saveFeed($FEED['defaultFormat'], $FEED['filename'], false);

}


?>