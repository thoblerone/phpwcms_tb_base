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

// cmCalendar module content part listing

$cinfo["result"] = array();
$cinfo["result"][] = trim(html_specialchars(cut_string($row["acontent_title"],"…", 55)));
$cinfo["result"][] = trim(html_specialchars(cut_string($row["acontent_subtitle"],"…", 55)));
$cont_acontent_form	= unserialize($row["acontent_form"]);
switch ($cont_acontent_form['eventlist']) {
	case 1:
	 $listingstyle = $BL['modules'][$row["acontent_module"]]['tpl'];
 	break;
	case 2:
	 $listingstyle = $BL['modules'][$row["acontent_module"]]['teaser'];
 	break;
	case 3:
	 $listingstyle = $BL['modules'][$row["acontent_module"]]['cal_view'];
 	break;
  default:
	 $listingstyle = '';
	break;
}

if ( $cont_acontent_form['cals'] ) {
  $id = implode(',',$cont_acontent_form['cals']);
  $sql = "SELECT cm_cat_name FROM ".DB_PREPEND."phpwcms_cmcalendar_categories WHERE cm_cat_id IN(".$id.")";
  $data = _dbQuery($sql);
  $liststr = "";
  foreach ($data as $value) {
    $liststr .= $value["cm_cat_name"].', ';
  }
  $liststr = ' '.trim($liststr, ', ');
}else {
  $liststr = "";
}
$cinfo["result"] = implode(' / ', $cinfo["result"]);
//$cinfo["result"] = trim($cinfo["result"], ' ' );

if($cinfo["result"]) { //Zeige Inhaltinfo
$cinfo["result"] = trim($cinfo["result"], '/ ' );
if ($cinfo["result"]) $cinfo["result"]=$cinfo["result"].' / ';
	echo '<tr><td>&nbsp;</td><td class="v10">';
	echo '<a href="phpwcms.php?do=articles&amp;p=2&amp;s=1&amp;aktion=2&amp;id='.$article["article_id"].'&amp;acid='.$row["acontent_id"].'">';
	echo $cinfo["result"].''.$listingstyle.' > '.$liststr.'</a></td><td>&nbsp;</td></tr>';
}

?>
