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

//rss functions
                
$i = 0;
$cm_calendar['xml'] = array();

  if ($handle = opendir(PHPWCMS_ROOT.'/content/rss')) {
    while (false !== ($file = readdir($handle))) {
          if ($file != "." && $file != "..") {
            if (substr($file, -3)=="xml" && substr($file, 0, 14)=="feed-calendar-") {
            $cm_calendar['xml'][$i] = $file;
            }
          }
        $i++;
        }
      closedir($handle);
  }

  if (count($cm_calendar['xml'])) {

    sort($cm_calendar['xml']);
    $filterfiles['xml'] = array();
    $j=0;

    foreach($cm_calendar['xml'] as $row) {
      $xml = "";
    $f = fopen( PHPWCMS_ROOT.'/content/rss/'.$row, 'r' );
      while( $data = fread( $f, 4096 ) ) { $xml .= $data; }
      fclose( $f );
     preg_match( "/\<lastBuildDate\>(.*?)\<\/lastBuildDate\>/s", $xml, $nameblocks );
        $filterfiles['xml'][$j]['filename']= $row;
    $filterfiles['xml'][$j]['descr']= $nameblocks[1];

    $j++;
    }
    $cm_calendar['xml'] = $filterfiles['xml'];
  }

//get the structure, article and cp with all nessesary data according visibality etc. and the settings in the contentparts 'plugin:cmCalendar'
$cmCal_cp = new ModuleCmCalendarCp();
$cmCal_cp->cmcalendar_get_cals();
$cmCal_cp->cmcalendar_get_articles();

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #92A1AF;">
 <tr>
    <td colspan="4" style="height:50px;" class="chatlist"><?php echo $BLM['cm_cp_title'] ?></td>
</tr>
<?php
  $row_count = 0;
  foreach($cmCal_cp->plugin_cplist as $row) {
?>
  <tr>
    <td width="38%" valign="top" style="border-top:1px solid #92A1AF;">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><td colspan="5" style="height:5px"><img src="img/leer.gif" alt="" width="1" height="1"></td></tr>
        <tr>
          <td width="5%"><img src="<?php echo $phpwcms['modules'][$module]['dir'] ?>img/page_<?php if (!$row["artdata"]["acat_hidden"]) {echo '1';} else {echo '7';} ; ?><?php if ($row["artdata"]["acat_regonly"]) {echo '_locked';} ; ?>.gif" border="0" alt="" /></td>
          <td width="15%"><?php echo $row["artdata"]["acat_id"] ?></td>
          <td width="70%"><?php echo substr($row["artdata"]["acat_name"],0 ,20 ) ?><?php if (strlen($row["artdata"]["acat_name"]) > 20 ) echo '&hellip;'; ?></td>
          <td width="5%"><img src="<?php echo $phpwcms['modules'][$module]['dir'] ?>img/visible_11x11a_<?php echo  $row["artdata"]["acat_aktiv"] ?>.gif" border="0" alt="active" /></td>
          <td width="5%"><img src="<?php echo $phpwcms['modules'][$module]['dir'] ?>img/public_11x11a_<?php echo  $row["artdata"]["acat_public"] ?>.gif" border="0" alt="public" /></td>
        </tr>
	<tr><td colspan="5" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1"></td></tr>
        <tr>
          <td width="5%"><img src="<?php echo $phpwcms['modules'][$module]['dir'] ?>img/text_1.gif" border="0" alt="" /></td>
          <td width="15%"><?php echo $row["artdata"]["article_id"] ?></td>
          <td width="70%"><?php if ($_SESSION['wcs_user_id'] == $row["artdata"]["article_uid"] || $_SESSION["wcs_user_admin"] == 1) { ?>
          <a href="phpwcms.php?do=articles&amp;p=2&amp;s=1&amp;id=<?php echo $row["artdata"]["article_id"] ?>">
<?php }  ?><?php echo  substr($row["artdata"]["article_title"],0 ,20 ) ?><?php if (strlen($row["artdata"]["article_title"]) > 20 ) echo '&hellip;'; ?>
<?php
if ($_SESSION['wcs_user_id'] == $row["artdata"]["article_uid"] || $_SESSION["wcs_user_admin"] == 1) {
echo '</a>';
}
?></td>
          <td width="5%"><img src="<?php echo $phpwcms['modules'][$module]['dir'] ?>img/visible_11x11a_<?php echo  $row["artdata"]["article_aktiv"] ?>.gif" border="0" alt="active" /></td>
          <td width="5%"><img src="<?php echo $phpwcms['modules'][$module]['dir'] ?>img/public_11x11a_<?php echo  $row["artdata"]["article_public"] ?>.gif" border="0" alt="public" /></td>
        </tr>
	<tr><td colspan="5" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1"></td></tr>
        <tr>
          <td width="5%"><img src="<?php echo $phpwcms['modules'][$module]['dir'] ?>img/content_9x11.gif" border="0" alt="" /></td>
          <td width="15%"><?php echo $row["acontent_id"] ?></td>
          <td width="70%"><?php if ($_SESSION['wcs_user_id'] == $row["artdata"]["article_uid"] || $_SESSION["wcs_user_admin"] == 1) { ?>
          <a href="phpwcms.php?do=articles&amp;p=2&amp;s=1&amp;aktion=2&amp;id=<?php echo $row["artdata"]["article_id"] ?>&amp;acid=<?php echo $row["acontent_id"] ?>">
<?php }  ?><?php echo  substr($row["acontent_title"],0 ,20 ) ?><?php if (strlen($row["acontent_title"]) > 20 ) echo '&hellip;'; ?><?php if (strlen($row["acontent_title"]) == 0 ) echo 'no title'; ?>
<?php
if ($_SESSION['wcs_user_id'] == $row["artdata"]["article_uid"] || $_SESSION["wcs_user_admin"] == 1) {
echo '</a>';
}
?></td>
          <td width="5%"><img src="<?php echo $phpwcms['modules'][$module]['dir'] ?>img/visible_11x11a_<?php echo  $row["acontent_visible"] ?>.gif" border="0" alt="active" /></td>
          <td width="5%">&nbsp;</td>
        </tr>
        <tr>
          <td width="5%">&nbsp;</td>
          <td width="15%">&nbsp;</td>
          <td width="70%"><?php echo  $row["acontent_tstamp"] ?></td>
          <td width="5%"></td>
          <td width="5%">&nbsp;</td>
        </tr>
	<tr><td colspan="5" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1"></td></tr>
      </table>

    </td>
    <td width="2%" style="border-top:1px solid #92A1AF;">&nbsp;</td>
    <td width="2%" style="border-top:1px solid #92A1AF;">&nbsp;</td>
    <td width="58%" style="border-top:1px solid #92A1AF;">


      <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><td colspan="3" class=""><img src="img/leer.gif" alt="" width="1" height="7"></td></tr>
        <tr>
          <td colspan="3"><?php
      if ( $row['acontent_form']['eventlist'] == 1 ) {
      echo '<img style="vertical-align:bottom;" src="'.$phpwcms['modules'][$module]['dir'].'img/application_view_list.gif" alt="entries listing" title="entries listing" /><span style="line-height:16px;">&nbsp;&nbsp;'.$BLM['tpl'].'</span>';
      } elseif ( $row['acontent_form']['eventlist'] == 2 ) {
      echo '<img style="vertical-align:bottom;" src="'.$phpwcms['modules'][$module]['dir'].'img/application_split.gif" alt="entries listing" title="entries listing" /><span style="line-height:16px;">&nbsp;&nbsp;'.$BLM['teaser'].'</span>';
      } elseif ( $row['acontent_form']['eventlist'] == 3 ) {
      echo '<img style="vertical-align:bottom;" src="'.$phpwcms['modules'][$module]['dir'].'img/calendar.gif" alt="entries listing" title="entries listing" /><span style="line-height:16px;">&nbsp;&nbsp;'.$BLM['cal_view'].'</span>';
      if ($row['acontent_form']['cm_calrt_ajax'] == 1) echo '<span style="line-height:16px;">&nbsp;&nbsp;AJAX</span>';
      }
?>
          </td>
        </tr>

        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>

        <tr>
          <td colspan="3" style="border-bottom:1px dotted #92A1AF;"><?php echo $BLM['cm_cp_actcals'] ?></td>
        </tr>

<?php
        $i=0;
if ($row['acontent_form']['cals'] == '') $row['acontent_form']['cals'] = array();  //compatibilty to V1.0
if (!isset($row['acontent_form']['cm_rss_active'])) $row['acontent_form']['cm_rss_active'] = 0;  //compatibilty to V1.0
        if (count($row['acontent_form']['cals'])) {
        foreach($row['acontent_form']['cals'] as $rowcals) {
          $i++;
?>
        <tr>
          <td width="2%"><?php echo $cmCal_cp->plugin_cals[$rowcals]['cm_cat_id'] ?></td>
          <td width="24%"><?php echo $cmCal_cp->plugin_cals[$rowcals]['cm_cat_name'] ?></td>
          <td width="2%"><img src="<?php echo $phpwcms['modules'][$module]['dir'] ?>img/visible_11x11a_<?php echo $cmCal_cp->plugin_cals[$rowcals]['cm_cat_status'] ?>.gif" border="0" alt="active" /></td>
        </tr>
	      <tr><td colspan="3" style="border-bottom:1px dotted #92A1AF;"><img src="img/leer.gif" alt="" width="1" height="1"></td></tr>
<?php
        }
        } else {
?>
        <tr>
          <td colspan="3" style="color:#F00;"><?php echo $BLM['cm_cp_nosel'] ?></td>
        </tr>
	      <tr><td colspan="3" style="border-bottom:1px dotted #92A1AF;"><img src="img/leer.gif" alt="" width="1" height="1"></td></tr>
<?php
        }
?>

        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>

        <tr>
          <td colspan="3"><?php
        if ( $row['acontent_form']['eventlist'] == 2 ) {
          echo 'RT: {SHOW_CONTENT:CP,'.$row["acontent_id"].'}';
        } elseif ( $row['acontent_form']['eventlist'] == 3 ) {
          echo 'RT: {CM_CALENDAR}{SHOW_CONTENT:CP,'.$row["acontent_id"].'}';
        } elseif ( $row['acontent_form']['eventlist'] == 1 ) {


          echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" summary="">'."\n";
          $row_count2 = 1;
          foreach($cm_calendar['xml'] as $rowrss) {
             preg_match( "/.*?-(\d+?)-(\d+?)\.xml/s", $rowrss["filename"], $ids );

            if($ids[1] == $row["artdata"]["article_id"] && $ids[2] == $row["acontent_id"]) {
            echo '<tr'.( ($row_count2 % 2) ? ' bgcolor="#F3F5F8"' : '' ).' onmouseover="this.bgColor=\'#CCFF00\';" onmouseout="this.bgColor=\''.( ($row_count2 % 2) ? '#F3F5F8' : '' ).'\';">'.LF.'<td width="10%" valign="top" style="padding-top:5px;">';
            echo '<a href="content/rss/'.html_specialchars($rowrss["filename"]).'" target="_blank"><img src="'.$phpwcms['modules'][$module]['dir'].'img/feed.gif" border="0" alt="'.$BLM['cm_cp_rss'].'" title="'.$BLM['cm_cp_rss'].'" /></a></td>'.LF;
            echo '<td class="dir" width="75%">'.html_specialchars($rowrss["filename"]).'<br />'."\n";
            echo date("Y-m-d H:i:s", strtotime($rowrss["descr"])).'</td>'."\n";
            echo '<td class="dir" width="5%" height="20"><a href="'.cm_map_url('controller=cp').'&amp;update=rss&amp;art_id='.$ids[1].'&amp;cp_id='.$ids[2].'" title="'.$BLM['cm_cp_update'].'"><img src="'.$phpwcms['modules'][$module]['dir'].'img/feed_disk.gif" border="0" alt="'.$BLM['cm_cp_update'].'" /></a> </td>'."\n";
            echo '<td width="5%" align="right" nowrap="nowrap"><img src="'.$phpwcms['modules'][$module]['dir'].'img/active_11x11a_'.$row['acontent_form']['cm_rss_active'].'.gif" border="0" alt="active" /></td>'."\n";
            echo '<td width="5%" align="right" nowrap="nowrap" class="button_td">';
if ($_SESSION['wcs_user_id'] == $row["artdata"]["article_uid"] || $_SESSION["wcs_user_admin"] == 1) {
            echo '<a href="'.cm_map_url('controller=cp').'&amp;delete=rss&amp;art_id='.$ids[1].'&amp;cp_id='.$ids[2].'"';
            echo ' title="delete: '.html_specialchars($rowrss["filename"]).'"';
            echo ' onclick="return confirm(\''.$BLM['delete_entry'].' '.js_singlequote($rowrss["filename"]).'\');">';
            echo '<img src="'.$phpwcms['modules'][$module]['dir'].'img/trash_13x13_1.gif" border="0" alt=""></a>';
}
            echo "</td>\n</tr>\n";
            }

          } //end foreach

          echo '</table>'."\n";

        }
?>

          </td>
        </tr>
	      <tr><td colspan="3" style="height:20px;"><img src="img/leer.gif" alt="" width="1" height="1"></td></tr>
      </table>

    </td>
  </tr>

<?php
    $row_count++;
  } ///end foreach
?>

</table>

<?php
  if($row_count == 0){
// nothing found
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td><img src="img/leer.gif" alt="" width="1" height="3"></td></tr>
	<tr><td bgcolor="#92A1AF"><img src="img/leer.gif" alt="" width="1" height="1"></td></tr>
	<tr><td><?php echo $BLM['cm_cp_nofile'] ?></td></tr>
</table>
<?php
  }
?>